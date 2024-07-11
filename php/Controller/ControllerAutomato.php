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
        $this->errorlog('CA Chegou no método: gravaPaginaAutomato($sTexto)');

        $this->errorlog('CA Chegou no método: $this->getOPersistencia()->retornaArrayEstadosTransicoes()');
        $aEstadosTransicoes = $this->getOPersistencia()->retornaArrayEstadosTransicoes();
        $this->errorlog('CA Finalizou o método: $this->getOPersistencia()->retornaArrayEstadosTransicoes()');

        $this->errorlog('CA Chegou no método: $this->getOPersistencia()->retornaTabelaDeTokens()');
        $aTabelaDeTokens = $this->getOPersistencia()->retornaTabelaDeTokens();
        $this->errorlog('CA Finalizou o método: $this->getOPersistencia()->retornaTabelaDeTokens()');

        $this->errorlog('CA Chegou no método: $this->getOPersistencia()->retornaTransicoesProprias()');
        $aTransicoesProprias = $this->getOPersistencia()->retornaTransicoesProprias();
        $this->errorlog('CA Finalizou o método: $this->getOPersistencia()->retornaTransicoesProprias()');

        $this->errorlog('CA Chegou no método: $this->getOView()->montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens, $aTransicoesProprias)');
        $sModal = $this->getOView()->montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens, $aTransicoesProprias);
        $this->errorlog('CA Finalizou o método: $this->getOView()->montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens, $aTransicoesProprias) retorno=' . $sModal);
        $this->getOPersistencia()->gravaArquivo("modalAutomato", $sModal, '.html');

        //Retorna diretório da pasta do usuário para abrir a página com o automato gráfico
        // Cria um array associativo
        $sRetorno = array("texto" => $sModal);
        $this->errorlog('CA Finalizou o método: gravaPaginaAutomato($sTexto)');
        return json_encode($sRetorno);
    }

    public function errorlog($message) {
        // Abre o arquivo no modo de adição ('a')
        $fp = fopen('data/errorLog.txt', "a");

        // Adiciona uma nova linha ao arquivo com a data e hora atuais
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = $timestamp . ' - ' . $message . PHP_EOL;

        // Escreve no arquivo aberto
        fwrite($fp, $logEntry);

        // Fecha o arquivo
        fclose($fp);
    }
}
