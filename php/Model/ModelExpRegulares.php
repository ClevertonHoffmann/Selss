<?php

/**
 * Classe responsável por conter as variáveis de construção do automato
 */
class ModelExpRegulares {

    //Responsável por armazenar a entrada dos dados pelo usuário nas definições regulares
    private $aArray = array();

    public function getAArray() {
        return $this->aArray;
    }

    public function getValorAArray($iPosicao) {
        return $this->aArray[$iPosicao];
    }

    public function setAArray($aArray) {
        $this->aArray = $aArray;
    }

    public function setValorAArray($iPosicao, $sValor) {
        $this->aArray[$iPosicao] = $sValor;
    }

    public function unsetAArray($key) {
        unset($this->aArray[$key]);
    }

    //Responsável por armazenar os caracteres válidos para a geração da tabela do automato de análise
    private $aArrayCaracteres = array();

    function getAArrayCaracteres() {
        return $this->aArrayCaracteres;
    }

    function setAArrayCaracteres($aArrayCaracteres) {
        $this->aArrayCaracteres = $aArrayCaracteres;
    }

    //Responsável por armazenar a tabela de transição dos estados do automato para análise léxica
    private $aTabelaAutomato = array();

    function getATabelaAutomato() {
        return $this->aTabelaAutomato;
    }

    public function setValorATabelaAutomato($iPosicao, $sValor) {
        $this->aTabelaAutomato[$iPosicao] = $sValor;
    }

    //aTabelaAutomato[$iPosicao][] = $sValor;
    public function setValorAutATabelaAutomato($iPosicao, $sValor) {
        $this->aTabelaAutomato[$iPosicao][] = $sValor;
    }

    function setATabelaAutomato($aTabelaAutomato) {
        $this->aTabelaAutomato = $aTabelaAutomato;
    }

    //Armazena as palavras reservadas para posterior análise léxica e salva as palavras reservadas
    private $aPalavrasReservadas = array();

    function getAPalavrasReservadas() {
        return $this->aPalavrasReservadas;
    }

    function setAPalavrasReservadas($aPalavrasReservadas) {
        $this->aPalavrasReservadas = $aPalavrasReservadas;
    }

    public function setValorAutAPalavrasReservadas($sValor) {
        $this->aPalavrasReservadas[] = $sValor;
    }

    //Usado para armazenar informações dos estados de transição posteriores ao 0
    private $aArrayEstTokenExpr = array();

    function getAArrayEstTokenExpr() {
        return $this->aArrayEstTokenExpr;
    }

    public function getValorAArrayEstTokenExpr($iPosicao) {
        return $this->aArrayEstTokenExpr[$iPosicao];
    }

    function setAArrayEstTokenExpr($aArrayEstTokenExpr) {
        $this->aArrayEstTokenExpr = $aArrayEstTokenExpr;
    }

    public function setValorAArrayEstTokenExpr($iPosicao, $sValor) {
        $this->aArrayEstTokenExpr[$iPosicao] = $sValor;
    }

    //Armazena inicialmente todos os tokens porém retira os que são estados simples ou palavras reservadas definidas a partir de uma expressão
    private $aArrayTokenExpr = array();

    function getAArrayTokenExpr() {
        return $this->aArrayTokenExpr;
    }

    function setAArrayTokenExpr($aArrayTokenExpr) {
        $this->aArrayTokenExpr = $aArrayTokenExpr;
    }

    public function setValorAArrayTokenExpr($iPosicao, $sValor) {
        $this->aArrayTokenExpr[$iPosicao] = $sValor;
    }

    /**
     * Remove caso existe a posição
     */
    public function unsetIFissetAArrayTokenExpr($key) {
        if (isset($this->aArrayTokenExpr[$key])) {
            unset($this->aArrayTokenExpr[$key]);
        }
    }

    //Guarda um array do tipo array[0]=>token; array[1]=>exp;
    public $aArray1 = array();
    
    //Grava o estado de transição posição da chave no array inicia em -1 por causa do cabeçalho
    public $iPos = -1;
    
    //Contador dos estados
    public $iEst = 0;
    
    //Contador composto caso de palavras reservadas
    public $iEstRes = 0;
    
    //Responsável por armazenar a expressão já verificada no estado 0 para não precisar repetir a análise
    public $sExp = '';
    
    //Usada para controle de atribuições não deixando atribuir dois estados para o mesmo caracter na tabela de transição
    public $bCont;
    
    //Parte dois
    //Contador importante para as expressões compostas
    public $iki;
    
    //Array responsável por armazenar as palavras chaves no formato array[palavra] = palavra; 
    public $aArrayPalavraChave = array();
    
    //Array que armazena todas as expressões simples pelo token que são diferentes dos estados de transição e seu respectivo estado
    public $aArrayExprEst = array();
    
    //Não deixa atribuir outro estado ao mesmo token que já contém um estado
    public $aTokenEstado = array();
    
}
