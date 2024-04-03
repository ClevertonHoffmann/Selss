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

    public function getAArrayCaracteres() {
        return $this->aArrayCaracteres;
    }

    public function setAArrayCaracteres($aArrayCaracteres) {
        $this->aArrayCaracteres = $aArrayCaracteres;
    }

    //Responsável por armazenar a tabela de transição dos estados do automato para análise léxica
    private $aTabelaAutomato = array();

    public function getATabelaAutomato() {
        return $this->aTabelaAutomato;
    }

    /**
     * $this->aTabelaAutomato[$iPosicao] = $sValor;
     * @param type $iPosicao
     * @param type $sValor
     */
    public function setValorATabelaAutomato($iPosicao, $sValor) {
        $this->aTabelaAutomato[$iPosicao] = $sValor;
    }

    //aTabelaAutomato[$iPosicao][] = $sValor;
    public function setValorAutATabelaAutomato($iPosicao, $sValor) {
        $this->aTabelaAutomato[$iPosicao][] = $sValor;
    }

    public function setATabelaAutomato($aTabelaAutomato) {
        $this->aTabelaAutomato = $aTabelaAutomato;
    }

    //Armazena as palavras reservadas para posterior análise léxica e salva as palavras reservadas
    private $aPalavrasReservadas = array();

    public function getAPalavrasReservadas() {
        return $this->aPalavrasReservadas;
    }

    public function setAPalavrasReservadas($aPalavrasReservadas) {
        $this->aPalavrasReservadas = $aPalavrasReservadas;
    }

    public function setValorAutAPalavrasReservadas($sValor) {
        $this->aPalavrasReservadas[] = $sValor;
    }

    //Usado para armazenar informações dos estados de transição posteriores ao 0
    private $aArrayEstTokenExpr = array();

    public function getAArrayEstTokenExpr() {
        return $this->aArrayEstTokenExpr;
    }

    public function getValorAArrayEstTokenExpr($iPosicao) {
        return $this->aArrayEstTokenExpr[$iPosicao];
    }

    public function setAArrayEstTokenExpr($aArrayEstTokenExpr) {
        $this->aArrayEstTokenExpr = $aArrayEstTokenExpr;
    }

    public function setValorAArrayEstTokenExpr($iPosicao, $sValor) {
        $this->aArrayEstTokenExpr[$iPosicao] = $sValor;
    }

    //Armazena inicialmente todos os tokens porém retira os que são estados simples ou palavras reservadas definidas a partir de uma expressão
    private $aArrayTokenExpr = array();

    public function getAArrayTokenExpr() {
        return $this->aArrayTokenExpr;
    }

    public function setAArrayTokenExpr($aArrayTokenExpr) {
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
    private $aArray1 = array();

    public function getAArray1() {
        return $this->aArray1;
    }

    public function getValorAArray1($iPosicao) {
        return $this->aArray1[$iPosicao];
    }

    public function setAArray1($aArray1) {
        $this->aArray1 = $aArray1;
    }

    public function setValorAArray1($iPosicao, $sValor) {
        $this->aArray1[$iPosicao] = $sValor;
    }

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
    private $aArrayPalavraChave = array();

    public function getAArrayPalavraChave() {
        return $this->aArrayPalavraChave;
    }

    public function getValorAArrayPalavraChave($iPosicao) {
        return $this->aArrayPalavraChave[$iPosicao];
    }

    public function setAArrayPalavraChave($aArrayPalavraChave) {
        $this->aArrayPalavraChave = $aArrayPalavraChave;
    }

    public function setValorAArrayPalavraChave($iPosicao, $sValor) {
        $this->aArrayPalavraChave[$iPosicao] = $sValor;
    }

    public function issetAArrayPalavraChave($sValor) {
        return isset($this->aArrayPalavraChave[$sValor]);
    }

    //Array que armazena todas as expressões simples pelo token que são diferentes dos estados de transição e seu respectivo estado
    private $aArrayExprEst = array();
    
    public function getAArrayExprEst() {
        return $this->aArrayExprEst;
    }
    
    public function getValorAArrayExprEst($iPosicao) {
        return $this->aArrayExprEst[$iPosicao];
    }

    public function setAArrayExprEst($aArrayExprEst) {
        $this->aArrayExprEst = $aArrayExprEst;
    }
    
    public function setValorAArrayExprEst($iPosicao, $sValor) {
        $this->aArrayExprEst[$iPosicao] = $sValor;
    }
        
    //Não deixa atribuir outro estado ao mesmo token que já contém um estado
    public $aTokenEstado = array();
}
