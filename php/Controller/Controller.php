<?php
/**
 * Classe controller que implementa os controles essenciais do sistema
 * e a fabricação das classes
 */

class Controller{
    
    public $oPersistencia;
    public $oModel;
    public $oView;
    
    public function carregaClasses($sNomeClasse){

       $this->oPersistencia = $this->fabricaPersistencia('Persistencia'.$sNomeClasse); 
       $this->oModel = $this->fabricaModel('Model'.$sNomeClasse); 
       $this->oView = $this->fabricaView('View'.$sNomeClasse); 
       
    }
    
    public function fabricaPersistencia($sNomeClasse) {
       return new $sNomeClasse();
    }
    
    public function fabricaModel($sNomeClasse) {
       return new $sNomeClasse();
    }
    
    public function fabricaView($sNomeClasse) {
       return new $sNomeClasse();
    }
    
}
