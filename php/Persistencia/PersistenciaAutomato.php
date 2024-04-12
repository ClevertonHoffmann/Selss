<?php

/**
 * Classe responsável por realizar a persistencia dos dados do automato
 */

class PersistenciaAutomato extends Persistencia{
    
     /**
     * Método responsável por retornar os estados e suas transições presentes na tabela de análise léxica
     * @return type
     */
    public function retornaArrayEstadosTransicoes() {

        $aCSV = $this->retornaArrayCompostoCSV("estTransicaoExpToken.csv", 1);
        return $aCSV;
        
    }

    /**
     * Função que retorna um array de tokens com a seguinte estrutura [estado]=token
     * @return type
     */
    public function retornaTabelaDeTokens() {

        $aCSV = $this->retornaArrayCSV("tabelaAnaliseLexica.csv", 1);
        $aTokens = array();
        //array_pop($aCSV);
        foreach ($aCSV as $aVal) {
            if ($aCSV[0] != $aVal) {
                $aTokens[trim($aVal[0])] = trim($aVal[1]);
            }
        }
        return $aTokens;
    }
    
}