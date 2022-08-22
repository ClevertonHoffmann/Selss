<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$sClasse = "";
$sMetodo = "";

//echo ('Teste');
require_once '../php/Controller/ControllerExpRegulares.php';

if(isset($_REQUEST['classe'])){
    $sClasse = $_REQUEST['classe'];
}
if(isset($_REQUEST['classe'])){
    $sMetodo = $_REQUEST['metodo'];
}

if(isset($_REQUEST['dados'])){
    
    $ContExp = new ControllerExpRegulares();

    echo $ContExp->analisaExpressoes($_REQUEST['dados']);
    
}