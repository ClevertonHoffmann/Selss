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
        $this->errorlog('PE Chegou no método: gravaTabelaLexica($aArray)');
        $aDados = $this->gravaArray("tabelaAnaliseLexica", 1, $aArray);
        $this->errorlog('PE Finalizou o método: $this->gravaArray("tabelaAnaliseLexica", 1, $aArray)');
        return $aDados;
    }
    
    /**
     * Método responsável por retornar o cabeçalho da tabela do automato
     * @return aDados
     */
    public function retornaCabecalhoTabelaLexica() {
        $this->errorlog('PE Chegou no método: retornaCabecalhoTabelaLexica()');
        $aDados = $this->retornaArray("cabecalho", 0);
        $this->errorlog('PE Finalizou o método: retornaCabecalhoTabelaLexica()');
        return $aDados;
    }

    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return aDados
     */
    public function retornaCaracteresValidos() {
        $this->errorlog('PE Chegou no método: retornaCaracteresValidos()');
        $aDados = $this->retornaArray("caracteresvalidos", 0);
        $this->errorlog('PE Finalizou o método: retornaCaracteresValidos()');
        return $aDados;
    }
    
    /**
     * Método responsável por retornar os caractéres válidos para a análise léxica
     * @return aDados
     */
    public function retornaCaracteresInvalidos() {
        $this->errorlog('PE Chegou no método: retornaCaracteresInvalidos()');
        $aDados = $this->retornaArray("caracteresinvalidos", 0);
        $this->errorlog('PE Finalizou o método: retornaCaracteresInvalidos()');
        return $aDados;
    }
    
    /**
     * Grava o array das palavras reservadas
     * @return aDados
     */
    public function gravaPalavrasReservadas($aArray){
        $this->errorlog('PE Chegou no método: gravaPalavrasReservadas($aArray)');
        $aDados = $this->gravaArray("palavrasReservadas", 1, $aArray);
        $this->errorlog('PE Finalizou o método: gravaPalavrasReservadas($aArray)');
        return $aDados;
    }
    
    /**
     * Grava o array AArrayEstTransicaoExpToken
     * @return aDados
     */
    public function gravaArrayEstTransicaoExpToken($aArray){
        $this->errorlog('PE Chegou no método: gravaArrayEstTransicaoExpToken($aArray)');
        $aDados = $this->gravaArrayComposto("estTransicaoExpToken", 1, $aArray);
        $this->errorlog('PE Finalizou o método: gravaArrayEstTransicaoExpToken($aArray)');
        return $aDados;
    }
    
    public function errorlog($message) {
        // Abre o arquivo no modo de adição ('a')
        $fp = fopen('data/errorLog.txt', "a");

        // Adiciona uma nova linha ao arquivo com a data e hora atuais
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = $timestamp . ' - ' . $message . PHP_EOL;

        // Escreve no arquivo aberto
        fwrite($fp, $logEntry);

        // Fecha o arquivo
        fclose($fp);
    }
    
}

?>