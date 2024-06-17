<?php

/**
 * Classe responsável por realizar a persistencia dos dados da análise léxica
 */

class PersistenciaAnalisadorLexico extends Persistencia{

    public function retornaPalavrasReservadas() {

        $aDados = $this->retornaArray("palavrasReservadas", 1);
        return $aDados;
        
    }

    public function retornaTabelaDeTransicao() {

        $aDados = $this->retornaArray("tabelaAnaliseLexica", 1);
        $aCab = $this->retornaArray("caracteresValidos", 0);
        
        //Apenas remove a ultima posição do array que no explode traz vazio ""
        //Cria um array no formato array[estado]=>array[caracter] = estado de transição  
        $aTabTrans = array();
        $aAux = array();
        $iK=0;
       // array_pop($aDados);
        foreach ($aDados as $aVal) {
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

        $aDados = $this->retornaArray("tabelaAnaliseLexica", 1);
        $aTokens = array();
        //array_pop($aDados);
        foreach ($aDados as $aVal) {
            if ($aDados[0] != $aVal) {
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
        
        $aDados = $this->gravaArray("resultadoAnaliseLexica", 1, $aArray);
        return $aDados;
        
    }

}

?>