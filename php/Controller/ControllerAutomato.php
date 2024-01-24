<?php

/*
 * Classe responsável pela contrução do automado de análise léxica referente as expressões regulares
 */

class ControllerAutomato extends Controller {

    public function __construct() {
        $this->carregaClasses('Automato');
    }
    
}