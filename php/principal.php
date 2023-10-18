<?php

/*
 * Classe principal que chama as controllers do sistema
 * E carrega os autoloader das classes
 * Parâmetros pelo $_REQUEST classe, metodo, dados
 */

$sClasse = "";
$sMetodo = "";

session_start();

function custom_autoloader($class) {
    // Diretórios a serem pesquisados para as classes
    $directories = ['../php/Controller/', '../php/Persistencia/', '../php/View/'];

    // Loop através dos diretórios
    foreach ($directories as $directory) {
        $file = $directory . '/' . $class . '.php';
        if (file_exists($file)) {
            include $file;
            return;
        }
    }
}

// Registre a função de autoload personalizada
spl_autoload_register('custom_autoloader');

if (isset($_REQUEST['classe'])) {
    $sClasse = $_REQUEST['classe'];
    //require_once '../php/Controller/'.$sClasse.'.php';
}

if (isset($_REQUEST['classe'])) {
    $sMetodo = $_REQUEST['metodo'];
}

if ($sClasse != "" && $sMetodo != "") {
    if (isset($_REQUEST['dados'])) {

        $Controller = new $sClasse();

        echo $Controller->$sMetodo($_REQUEST['dados']);
    }
}