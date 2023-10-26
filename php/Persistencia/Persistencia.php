<?php

/*
 * Classe que realiza a manipulação de CSVs
 */

class Persistencia {

    /**
     * Grava um array em um arquivo CSV
     * @param string $sArquivo O nome do arquivo CSV a ser criado/gravado
     * @param type $iTipo 0 sistema 1 usuario
     * @param array $dadosArray O array de dados a serem gravados no arquivo CSV
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro
     */
    public function gravaArrayEmCSV($sArquivo, $iTipo, $dadosArray) {
        
        $nomeArquivo = '';
        if($iTipo==0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio.'//' . $sArquivo;
        }

        $handle = fopen($nomeArquivo, 'w');

        if ($handle !== false) {
            foreach ($dadosArray as $linha) {
                fputcsv($handle, $linha, ';');
            }
            fclose($handle);
            return true; // Retorna true se a gravação for bem-sucedida
        } else {
            echo "Não foi possível criar o arquivo $nomeArquivo.";
            return false; // Retorna false em caso de erro ao criar o arquivo
        }
    }

    /**
     * Retorna o array do arquivo CSV
     * @param type $sArquivo
     * @return type
     */
    public function retornaArrayCSVbkp($sArquivo) {

        $nomeArquivo = "data\\" . $sArquivo;
        $aCSV = array();
        if (($handle = fopen($nomeArquivo, 'r')) !== false) {
            while (($slinha = fgets($handle)) !== false) {
                $aCSV[] = explode(';', $slinha);
            }
            fclose($handle);
        } else {
            echo "Não foi possível abrir o arquivo $nomeArquivo.";
        }

        return $aCSV;
    }

    /**
     * Retorna o array do arquivo CSV
     * @param type $sArquivo
     * @param type $iTipo 0 sistema 1 usuario
     * @return type
     */
    public function retornaArrayCSV($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if($iTipo==0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio.'//' . $sArquivo;
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

}

?>