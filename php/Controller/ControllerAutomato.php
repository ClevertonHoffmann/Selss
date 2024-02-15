<?php

/*
 * Classe responsável pela contrução do automado de análise léxica referente as expressões regulares
 */

class ControllerAutomato extends Controller {

    public function __construct() {
        $this->carregaClasses('Automato');
    }
    
    /**
     * Monta e grava a pagina contendo o automato gráfico em html
     * E Retorna o diretório do arquivo de html para ser aberto na nova tela
     * @param type $sTexto
     * @return type
     */
    public function gravaPaginaAutomato($sTexto){
        
        $sModal = $this->oView->montaPaginaAutomato();
        $this->oPersistencia->gravaArquivo("modalAutomato.html", $sModal);

        return json_encode($sModal);
    }
        
}