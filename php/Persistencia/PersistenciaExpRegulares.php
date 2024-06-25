<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */

class PersistenciaExpRegulares extends Persistencia{

    /**
     * Grava o array da tabela do automato para análise léxica
     * @return aDados
     */
    public function gravaTabelaLexica($aArray){
        
        $aDados = $this->gravaArray("tabelaAnaliseLexica", 1, $aArray);
        return $aDados;
        
    }
    
    /**
     * Método responsável por retornar o cabeçalho da tabela do automato
     * @return aDados
     */
    public function retornaCabecalhoTabelaLexica() {

        $aDados = $this->retornaArray("cabecalho", 0);
        return $aDados;
        
    }

    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return aDados
     */
    public function retornaCaracteresValidos() {

        $aDados = $this->retornaArray("caracteresvalidos", 0);
        return $aDados;
        
    }
    
    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return aDados
     */
    public function retornaCaracteresInvalidos() {

        $aDados = $this->retornaArray("caracteresinvalidos", 0);
        return $aDados;
        
    }
    
    /**
     * Grava o array das palavras reservadas
     * @return aDados
     */
    public function gravaPalavrasReservadas($aArray){
        
        $aDados = $this->gravaArray("palavrasReservadas", 1, $aArray);
        return $aDados;
        
    }
    
    /**
     * Grava o array AArrayEstTransicaoExpToken
     * @return aDados
     */
    public function gravaArrayEstTransicaoExpToken($aArray){
        
        $aDados = $this->gravaArrayComposto("estTransicaoExpToken", 1, $aArray);
        return $aDados;
        
    }
    
}

?>