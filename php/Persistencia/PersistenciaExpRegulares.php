<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */
//require_once 'PersistenciaCSV.php';

class PersistenciaExpRegulares{

    /**
     * Grava o array da tabela do automato para análise léxica
     * @return type
     */
    public function gravaTabelaLexica($aArray){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->gravaArrayEmCSV("tabelaAnaliseLexica.csv", 1, $aArray);
        return $aCSV;
        
    }
    
    /**
     * Método responsável por retornar o cabeçalho da tabela do automato
     * @return type
     */
    public function retornaCabecalhoTabelaLexica() {
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("cabecalho.csv", 0);
        return $aCSV;
    }

    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return type
     */
    public function retornaCaracteresValidos() {
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("caracteresValidos.csv", 0);
        return $aCSV;
    }
    
    /**
     * Grava o array das palavras reservadas
     * @return type
     */
    public function gravaPalavrasReservadas($aArray){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->gravaArrayEmCSV("palavrasReservadas.csv", 1, $aArray);
        return $aCSV;
        
    }
    
    
    
    
    /**
     * Função que retorna um array de tokens com a seguinte estrutura [estado]=token
     * @return type
     */
//    public function retornaTabelaDeTokens() {
//        $oPersistenciaCSV = new PersistenciaCSV();
//        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv");
//        $aTokens = array();
//        array_pop($aCSV);
//        foreach ($aCSV as $aVal) {
//            if ($aCSV[0] != $aVal) {
//                $aTokens[trim($aVal[0])] = trim($aVal[1]);
//            }
//        }
//        return $aTokens;
//    }

}

?>