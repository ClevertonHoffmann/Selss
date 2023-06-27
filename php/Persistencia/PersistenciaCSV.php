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

}

?>