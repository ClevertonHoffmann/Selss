<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */

class PersistenciaExpRegulares extends Persistencia{

    /**
     * Grava o array da tabela do automato para análise léxica
     * @return type
     */
    public function gravaTabelaLexica($aArray){
        
        $aCSV = $this->gravaArrayEmCSV("tabelaAnaliseLexica", 1, $aArray);
        return $aCSV;
        
    }
    
    /**
     * Método responsável por retornar o cabeçalho da tabela do automato
     * @return type
     */
    public function retornaCabecalhoTabelaLexica() {

        $aCSV = $this->retornaArrayCSV("cabecalho", 0);
        return $aCSV;
        
    }

    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return type
     */
    public function retornaCaracteresValidos() {

        $aCSV = $this->retornaArrayCSV("caracteresvalidos", 0);
        return $aCSV;
        
    }
    
    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return type
     */
    public function retornaCaracteresInvalidos() {

        $aCSV = $this->retornaArrayCSV("caracteresinvalidos", 0);
        return $aCSV;
        
    }
    
    /**
     * Grava o array das palavras reservadas
     * @return type
     */
    public function gravaPalavrasReservadas($aArray){
        
        $aCSV = $this->gravaArrayEmCSV("palavrasReservadas", 1, $aArray);
        return $aCSV;
        
    }
    
    /**
     * Grava o array AArrayEstTransicaoExpToken
     * @return type
     */
    public function gravaArrayEstTransicaoExpToken($aArray){
        
        $aCSV = $this->gravaArrayCompostoEmCSV("estTransicaoExpToken", 1, $aArray);
        return $aCSV;
        
    }
    
}

?>