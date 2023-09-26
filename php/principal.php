<?php

/*
 * Classe principal que chama as controllers do sistema
 * Parâmetros pelo $_REQUEST classe, metodo, dados
 */

$sClasse = "";
$sMetodo = "";

session_start();

if (isset($_REQUEST['classe'])) {
    $sClasse = $_REQUEST['classe'];
    require_once '../php/Controller/'.$sClasse.'.php';
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