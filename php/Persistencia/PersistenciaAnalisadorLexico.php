<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */
require_once 'PersistenciaCSV.php';

class PersistenciaAnalisadorLexico {

    public function retornaPalavrasReservadas(){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("palavrasReservadas.csv");
        return $aCSV;
        
    }
    
    public function retornaTabelaDeTransicao(){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv");
        return $aCSV;
        
    }
    
    public function retornaTabelaDeTokens(){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv");
        return $aCSV;
        
    }

}

?>