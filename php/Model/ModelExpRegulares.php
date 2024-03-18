<?php

/**
 * Classe responsável por conter as variáveis de construção do automato
 */
class ModelExpRegulares{
           
    //Responsável por armazenar a entrada dos dados pelo usuário nas definições regulares
    public $aArray = array(); 
    
    //Responsável por armazenar os caracteres válidos para a geração da tabela do automato de análise
    public $aArrayCaracteres = array();
    
    //Responsável por armazenar a tabela de transição dos estados do automato para análise léxica
    public $aTabelaAutomato = array();
    
    //Armazena as palavras reservadas para posterior análise léxica e salva as palavras reservadas
    public $aPalavrasReservadas = array();
    
    //Usado para armazenar informações dos estados de transição posteriores ao 0
    public $aArrayEstTokenExpr = array();
    
    //Armazena inicialmente todos os tokens porém retira os que são estados simples ou palavras reservadas definidas a partir de uma expressão
    public $aArrayTokenExpr = array();
    
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
