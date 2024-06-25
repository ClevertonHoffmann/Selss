<?php

/*
 * Classe Index do sistema que carrega as bibliotecas iniciais e inicializa o sistema
 * E carrega os autoloader das classes
 * Parâmetros pelo $_REQUEST: classe, metodo, dados, modo
 */

// Inicia a sessão para usar as variáveis de sessão
session_start();

// Registre a função de autoload personalizada
spl_autoload_register('custom_autoloader');

class index {
    private $sClasse = "";
    private $sMetodo = "";
    private $sDados = "";
    private $sModo = "";

    public function __construct() {
        // Atribuir valores de $_REQUEST às variáveis da classe
        if (isset($_REQUEST['classe'])) {
            $this->sClasse = $_REQUEST['classe'];
        }

        if (isset($_REQUEST['metodo'])) {
            $this->sMetodo = $_REQUEST['metodo'];
        }

        if (isset($_REQUEST['dados'])) {
            $this->sDados = $_REQUEST['dados'];
        }

        if (isset($_REQUEST['modo'])) {
            $this->sModo = $_REQUEST['modo'];
        }

        $this->inicializaSistema();
    }

    private function inicializaSistema() {
        if ($this->sClasse == "" && $this->sMetodo == "") {
            if ($this->sModo) {
                if ($this->sModo == 'cadastro') {
                    $this->sClasse = 'ControllerSistema';
                    $this->sMetodo = 'mostraTelaCadastroUsuario';
                    $this->sDados = 'cadastro';
                } else {
                    $this->sClasse = 'ControllerSistema';
                    $this->sMetodo = 'mostraSistema';
                    $this->sDados = 'login';
                }
            } else {
                $this->sClasse = 'ControllerSistema';
                $this->sMetodo = 'mostraSistema';
                $this->sDados = 'login';
            }
        }

        if ($this->sClasse != "" && $this->sMetodo != "") {
            $Controller = new $this->sClasse();
            echo $Controller->{$this->sMetodo}($this->sDados);
        }
    }
}

// Instanciar a classe Index
new index();

// Carrega as classes das pastas inicialmente sem precisar ficar dando require_once
function custom_autoloader($class) {
    // Diretórios a serem pesquisados para as classes
    $directories = [
        'config/',
        'php/biblioteca/',
        'php/Controller/',
        'php/Model/',
        'php/Persistencia/',
        'php/View/'
    ];

    // Loop através dos diretórios
    foreach ($directories as $directory) {
        $file = $directory . '/' . $class . '.php';
        if (file_exists($file)) {
            include $file;
            return;
        }
    }
}
?>
