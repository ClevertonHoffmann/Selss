<?php

/*
 * Classe responsável pela manipulação das modais e sua reenderização
 */
require_once '../php/Persistencia/PersistenciaCSV.php';
require_once '../php/View/ViewModal.php';
        
class ControllerModal {
    
    public function mostraModalTabelaLexica(){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aTabela = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv", 1); 
        $oViewModal = new ViewModal();
        $sModal = $oViewModal->geraModalTabelaLexica($aTabela);

        return json_encode($sModal);
    }
    
    public function mostraModalResultadoAnaliseLexica(){
        $oPersistenciaCSV = new PersistenciaCSV();
        $aTabela = $oPersistenciaCSV->retornaArrayCSV("resultadoAnaliseLexica.csv", 1); 
        $oViewModal = new ViewModal();
        $sModal = $oViewModal->geraModalTabelaLexica($aTabela);

        return json_encode($sModal);
    }
    
}
