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
    public function gravaPaginaAutomato($sTexto) {

        $aEstadosTransicoes = $this->getOPersistencia()->retornaArrayEstadosTransicoes();

        $aTabelaDeTokens = $this->getOPersistencia()->retornaTabelaDeTokens();

        $aTransicoesProprias = $this->getOPersistencia()->retornaTransicoesProprias();

        $sModal = $this->getOView()->montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens, $aTransicoesProprias);
        $this->getOPersistencia()->gravaArquivo("modalAutomato", $sModal, '.html');

        //Retorna diretório da pasta do usuário para abrir a página com o automato gráfico
        // Cria um array associativo
        $sRetorno = array("texto" => $sModal);
        return json_encode($sRetorno);
    }
}
