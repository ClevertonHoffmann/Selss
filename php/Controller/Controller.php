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
    
    /**
     * $this->Mensagem('Mensagem a ser apresentada', 1);
     * Método responsável por exibir as mensagens do sistema
     * @param type $sMensagem
     * @param type $iTipo SUCCESS = 1; INFO = 2; WARNING = 3; ERROR = 4;
     */
    public function Mensagem($sMensagem, $iTipo){
        $oMensagem = new Mensagem();
        $oMensagem->exibirToast($sMensagem, $iTipo);
    }
    
}
