<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */
require_once 'PersistenciaCSV.php';

class PersistenciaAnalisadorLexico {

    public function retornaPalavrasReservadas() {

        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("palavrasReservadas.csv");
        return $aCSV;
    }

    public function retornaTabelaDeTransicao() {

        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv");
        //Apenas remove a ultima posição do array que no explode traz vazio ""
        $aTabTrans = array();
        foreach ($aCSV as $aVal) {
            array_pop($aVal);
            $aTabTrans[] = $aVal;
        }
        return $aTabTrans;
    }

    /**
     * Função que retorna um array de tokens com a seguinte estrutura [estado]=token
     * @return type
     */
    public function retornaTabelaDeTokens() {
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv");
        $aTokens = array();
        foreach ($aCSV as $aVal) {
            if ($aCSV[0] != $aVal) {
                $aTokens[$aVal[0]] = $aVal[1];
            }
        }
        return $aTokens;
    }

}

?>