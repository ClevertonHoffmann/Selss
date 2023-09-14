<?php

/*
 * Classe que realiza a manipulação de CSVs
 */

class PersistenciaCSV {

    /**
     * Grava um array em um arquivo CSV
     * @param string $nomeArquivo O nome do arquivo CSV a ser criado/gravado
     * @param array $dadosArray O array de dados a serem gravados no arquivo CSV
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro
     */
    public function gravaArrayEmCSV($nomeArquivo, $dadosArray) {
        $caminhoArquivo = "data\\" . $nomeArquivo;

        $handle = fopen($caminhoArquivo, 'w');

        if ($handle !== false) {
            foreach ($dadosArray as $linha) {
                fputcsv($handle, $linha, ';');
            }
            fclose($handle);
            return true; // Retorna true se a gravação for bem-sucedida
        } else {
            echo "Não foi possível criar o arquivo $caminhoArquivo.";
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
     * @return type
     */
    public function retornaArrayCSV($sArquivo) {
        $nomeArquivo = 'data/' . $sArquivo;
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