<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */
require_once 'PersistenciaCSV.php';

class PersistenciaAnalisadorLexico{//extends PersistenciaCSV

    public function retornaPalavrasReservadas() {

        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("palavrasReservadas.csv", 1);
        return $aCSV;
    }//Duvida quando extendo de uma classe pai não preciso fazer o new só chamar o this?
    //Por que automáticamente já vai estar instanciada?

    public function retornaTabelaDeTransicao() {

        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv", 1);
        $aCab = $oPersistenciaCSV->retornaArrayCSV("caracteresValidos.csv", 0);
        
        //Apenas remove a ultima posição do array que no explode traz vazio ""
        //Cria um array no formato array[estado]=>array[caracter] = estado de transição  
        $aTabTrans = array();
        $aAux = array();
        $iK=0;
       // array_pop($aCSV);
        foreach ($aCSV as $aVal) {
       //     array_pop($aVal);
            if($iK!=0){
                for ($c=0; $c<count($aCab[0]); $c++){
                    $aAux[$aCab[0][$c]] = $aVal[$c+2];
                }
                $aTabTrans[] = $aAux;
            }
            $iK++;
        }
        return $aTabTrans;
    }

    /**
     * Função que retorna um array de tokens com a seguinte estrutura [estado]=token
     * @return type
     */
    public function retornaTabelaDeTokens() {
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv", 1);
        $aTokens = array();
        //array_pop($aCSV);
        foreach ($aCSV as $aVal) {
            if ($aCSV[0] != $aVal) {
                $aTokens[trim($aVal[0])] = trim($aVal[1]);
            }
        }
        return $aTokens;
    }
    
    /**
     * Grava o array de saída do resultado da análise léxica
     * @return type
     */
    public function gravaResultadoAnaliseLexica($aArray){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aCSV = $oPersistenciaCSV->gravaArrayEmCSV("resultadoAnaliseLexica.csv", 1, $aArray);
        return $aCSV;
        
    }

}

?>