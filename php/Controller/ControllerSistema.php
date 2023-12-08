<?php

/*
 * Classe responsável por realizar o controle do sistema
 * validando o login e mostrando a tela do sistema
 */

class ControllerSistema extends Controller {

    public function __construct() {
        $this->carregaClasses('Sistema');
    }

    /**
     * Método responsável de mostrar a tela de sistema correspondente
     */
    public function mostraSistema($sDados) {

        $oControllerLogin = new ControllerLogin();

        $bLogin = $oControllerLogin->validaLogin();

        if (!$bLogin) {
            return $oControllerLogin->mostraTelaLogin($sDados);
        } else {     
            return $this->oView->retornaTelaSistema();
        }
    }

}
