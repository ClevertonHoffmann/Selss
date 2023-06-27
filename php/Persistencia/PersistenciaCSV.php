<?php

/*
 * Classe que realiza a manipulação de CSVs
 */

class PersistenciaCSV {

    /**
     * Retorna o array do arquivo CSV
     * @param type $sArquivo
     * @return type
     */
    public function retornaArrayCSV($sArquivo) {

        $nomeArquivo = "data\\".$sArquivo;
        $aCSV = array();
        if (($handle = fopen($nomeArquivo, 'r')) !== false) {
            while (($slinha = fgets($handle)) !== false) {
                $aCSV[] = explode(';', $slinha);
            }
            fclose($handle);
        } else {
            echo "Não foi possível abrir o arquivo $nomeArquivo.";
        }


        // Ler o conteúdo do arquivo CSV
//        $csvData = file_get_contents('../data/'.$sArquivo);
//
//        // Dividir as linhas do CSV
//        $csvLines = explode(PHP_EOL, $csvData);
//
//        // Array para armazenar os dados do CSV
//        $csvArray = array();
//
//        // Iterar pelas linhas do CSV
//        foreach ($csvLines as $line) {
//        // Converter a linha em um array usando a função str_getcsv()
//        $csvArray[] = str_getcsv($line);
//        }

        return $aCSV;
    }

}

?>