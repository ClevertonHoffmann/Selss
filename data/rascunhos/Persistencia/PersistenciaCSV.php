<?php

class PersistenciaCSV implements PersistenciaInterface {

    public function gravaArrayEmCSV($sArquivo, $iTipo, $dadosArray) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '//' . $sArquivo;
        }

        $handle = fopen($nomeArquivo, 'w');

        if ($handle !== false) {
            foreach ($dadosArray as $linha) {
                fputcsv($handle, $linha, ';');
            }
            fclose($handle);
            return true;
        } else {
            echo "Não foi possível criar o arquivo $nomeArquivo.";
            return false;
        }
    }

    public function gravaArrayCompostoEmCSV($sArquivo, $iTipo, $dadosArray) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '/' . $sArquivo;
        }

        $handle = fopen($nomeArquivo, 'w');

        if ($handle !== false) {
            foreach ($dadosArray as $linha) {
                $linhaParaGravar = array();

                $maxChave = max(array_keys($linha));

                for ($i = 1; $i <= $maxChave; $i++) {
                    if (!isset($linha[$i])) {
                        $linha[$i] = [-1, -1];
                    }
                }
                ksort($linha);
                foreach ($linha as $item) {
                    if (is_array($item)) {
                        foreach ($item as $subitem) {
                            $linhaParaGravar[] = $subitem;
                        }
                    } else {
                        $linhaParaGravar[] = '';
                    }
                }
                fputcsv($handle, $linhaParaGravar, ';');
            }
            fclose($handle);
            return true;
        } else {
            echo "Não foi possível criar o arquivo $nomeArquivo.";
            return false;
        }
    }

    public function retornaArrayCSV($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '//' . $sArquivo;
        }

        $aCSV = array();

        if (($handle = fopen($nomeArquivo, 'r')) !== false) {
            while (($slinha = fgets($handle)) !== false) {
                $aCSV[] = str_getcsv($slinha, ';');
            }
            fclose($handle);
        } else {
            echo "Não foi possível abrir o arquivo $nomeArquivo.";
        }

        return $aCSV;
    }

    public function retornaArrayCompostoCSV($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '/' . $sArquivo;
        }

        $dadosArray = array();

        if (($handle = fopen($nomeArquivo, 'r')) !== false) {
            while (($linha = fgetcsv($handle, 0, ';')) !== false) {
                $maxChave = max(array_keys($linha));
                $linhaArray = array();
                $iPos = 1;
                for ($i = 0; $i <= $maxChave; $i=$i+2) {
                    if ($linha[$i] != -1) {
                        $linhaArray[$iPos] = [$linha[$i], $linha[$i+1]];
                    }
                    $iPos++;
                }
                $dadosArray[] = $linhaArray;
            }
            fclose($handle);
        } else {
            echo "Não foi possível abrir o arquivo $nomeArquivo.";
        }

        return $dadosArray;
    }

    public function gravaArquivo($sArquivo, $sText) {
        $sDiretorio = $_SESSION['diretorio'];

        $arquivo = $sDiretorio . "//" . $sArquivo;

        $fp = fopen($arquivo, "w");

        fwrite($fp, $sText);

        fclose($fp);
    }
}

?>