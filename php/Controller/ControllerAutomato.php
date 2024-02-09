<?php

/*
 * Classe responsável pela contrução do automado de análise léxica referente as expressões regulares
 */

class ControllerAutomato extends Controller {

    public function __construct() {
        $this->carregaClasses('Automato');
    }
    
    public function mostraModalAutomato($sTexto){
        
        $sModal = $this->oView->montaModalAutomato();
        $this->oPersistencia->gravaArquivo("modalAutomato.html", $sModal);

        return json_encode($sModal);
    }
        
}