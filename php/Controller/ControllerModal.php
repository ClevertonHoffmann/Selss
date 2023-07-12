<?php

/*
 * Classe responsável pela manipulação das modais e sua reenderização
 */
require_once '../php/Persistencia/PersistenciaCSV.php';
require_once '../php/View/ViewModal.php';
        
class ControllerModal {
    
    public function mostraModalTabelaLexica($sDados){
        
        $oPersistenciaCSV = new PersistenciaCSV();
        $aTabela = $oPersistenciaCSV->retornaArrayCSV("tabelaAnaliseLexica.csv"); 
        $oViewModal = new ViewModal();
        $sModal = $oViewModal->geraModalTabelaLexica($aTabela);

        return json_encode($sModal);
    }
    
}