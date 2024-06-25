<?php

class ModelAnalisadorLexico{
    
    private array $aPalavrasReservadas;
    private array $aTabelaDeTransicao;
    private array $aTabelaTokens;
    private array $aCaracteresSeparados;
    private int $iCount;
    private int $q;
    private int $qntTokens;
    private string $sBuild;
    private array $aListadeTokensLex;
    
    /*
     * Retorna se existe ou não a palavra reservada na posição
     * Retorno bool
     */
    function getAPalavrasReservadasPosicao($sPosicao){
        return isset($this->aPalavrasReservadas[$sPosicao]);
    }
    
    /*
     * Retorna valor de transição específica
     * Retorno Int
     */
    function getATabelaDeTransicaoPosicaoEsp($sPos1, $sPos2){
        return $this->aTabelaDeTransicao[$sPos1][$sPos2];
    }
    
    /*
     * Retorna se valor existe ou não no array
     * Retorno bool
     */
    function issetATabelaDeTransicaoPosicaoEsp($sPos1, $sPos2){
        return isset($this->aTabelaDeTransicao[$sPos1][$sPos2]);
    }
    
    /*
     * Retorna posição específica do array de tokens
     * Retorno 
     */
    function getATabelaTokensPosicaoEsp($sPos){
        return $this->aTabelaTokens[$sPos];
    }
    
    /*
     * Retorna posição específica do array de caracteres separados
     * Retorno 
     */
    function getACaracteresSeparadosPosicao($sPos){
        return $this->aCaracteresSeparados[$sPos];
    }
    
    /*
     * Retorna se existe posição no array de caracteres separados
     * Retorno 
     */
    function issetACaracteresSeparadosPosicao($sPos){
        return isset($this->aCaracteresSeparados[$sPos]);
    }
    
    /*
     * Seta a lista de tokens lexemas de forma especial
     */
    function setAListadeTokensLexEsp($aValor){
        $this->aListadeTokensLex[] = $aValor;
    }
    
    function getAPalavrasReservadas(): array {
        return $this->aPalavrasReservadas;
    }

    function getATabelaDeTransicao(): array {
        return $this->aTabelaDeTransicao;
    }

    function getATabelaTokens(): array {
        return $this->aTabelaTokens;
    }

    function getACaracteresSeparados(): array {
        return $this->aCaracteresSeparados;
    }

    function getICount(): int {
        return $this->iCount;
    }

    function getQ(): int {
        return $this->q;
    }

    function getQntTokens(): int {
        return $this->qntTokens;
    }

    function getSBuild(): string {
        return $this->sBuild;
    }

    function getAListadeTokensLex(): array {
        return $this->aListadeTokensLex;
    }

    function setAPalavrasReservadas(array $aPalavrasReservadas){
        $this->aPalavrasReservadas = $aPalavrasReservadas;
    }

    function setATabelaDeTransicao(array $aTabelaDeTransicao){
        $this->aTabelaDeTransicao = $aTabelaDeTransicao;
    }

    function setATabelaTokens(array $aTabelaTokens){
        $this->aTabelaTokens = $aTabelaTokens;
    }

    function setACaracteresSeparados(array $aCaracteresSeparados){
        $this->aCaracteresSeparados = $aCaracteresSeparados;
    }

    function setICount(int $iCount){
        $this->iCount = $iCount;
    }

    function setQ(int $q){
        $this->q = $q;
    }

    function setQntTokens(int $qntTokens){
        $this->qntTokens = $qntTokens;
    }

    function setSBuild(string $sBuild){
        $this->sBuild = $sBuild;
    }

    function setAListadeTokensLex(array $aListadeTokensLex){
        $this->aListadeTokensLex = $aListadeTokensLex;
    }
    
}