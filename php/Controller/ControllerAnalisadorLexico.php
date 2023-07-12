<?php

/*
 * Classe responsável pela analise léxica e retorno dos dados de análise léxica do código digitado pelo usuário
 */
require_once '../php/Persistencia/PersistenciaAnalisadorLexico.php';

class ControllerAnalisadorLexico {

    //Variáveis e instancias iniciais carregegadas no construtor
    private PersistenciaAnalisadorLexico $oPersistencia;
    private array $aPalavrasReservadas;
    private array $aTabelaDeAnaliseLexica;
    private array $aTabelaTokens;
    private array $aCaracteresSeparados;
    private int $iCount;
    private int $q;
    private int $qntTokens;  
    private string $sBuild;
    private array $aListadeTokensLex; 
    
    private function InicializaAnalisadorLexico($sTexto){
        
        $this->oPersistencia = new PersistenciaAnalisadorLexico();
        $this->aPalavrasReservadas = $this->oPersistencia->retornaPalavrasReservadas();
        $this->aTabelaDeAnaliseLexica = $this->oPersistencia->retornaTabelaDeTransicao();
        $this->aTabelaTokens = $this->oPersistencia->retornaTabelaDeTokens();
        $this->aCaracteresSeparados = str_split($sTexto);
        $this->iCount = count($this->aCaracteresSeparados);
        $this->q = 0;
        $this->qntTokens = 0;
        $this->sBuild = "";
        $this->aListadeTokensLex = array();
    }


    /*
     * Método responsável por realizar a análise léxica do código
     */
    public function analiseLexica($sDados) {

        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};
        $sText = trim($sTexto);

        $this->InicializaAnalisadorLexico($sText); ///OKKKKKK

        //Inicia a análise léxica
        $iK = 0;
        while ($this->iCount>0){
            try{
                
            } catch (Exception $ex) {
                $sJson = '{"texto":"Estado não encontrado!"}';
                return json_encode($sJson);
            }
        //    $this->iCount--;
            
            /*
            
            int k = 0;
        while (count>0){
            try{
            //Aceita o caractere e avança uma posição na entrada
            if(!tab.getT().get(q).get(separado[k]).equals(-1)){ 
                build.append(separado[k]);//Concatena os caracteres até formar um token
                q = (int) tab.getT().get(q).get(separado[k]);  //Seta o estado presente na tabela
                count--;
                k++;                
            //Aceita o Token
            }else if(!tab.getT().get(q).equals("?")){  
                if(!build.toString().equals(" ")){ //Não salva os espaços na lista de tokens      
                   if(tab.getpReservada().containsValue(build.toString())){ //Verifica se contém palavra reservada
                       t.setListatokens(build.toString(), build.toString(), qntTokens);
//                       System.out.println("Estado: ".concat(String.valueOf(q))
//                            .concat(" Posição: ".concat(String.valueOf(k)))
//                            .concat(" Token: ").concat(build.toString())
//                            .concat(" Lexema: ").concat(build.toString()));
                   }else{
                       t.setListatokens(tab.getTs().get(q), build.toString(), qntTokens);
//                       System.out.println("Estado: ".concat(String.valueOf(q))
//                            .concat(" Posição: ".concat(String.valueOf(k)))
//                            .concat(" Token: ").concat(tab.getTs().get(q))
//                            .concat(" Lexema: ").concat(build.toString()));
                   }                 
                qntTokens++;
                }
                this.build = new StringBuilder();
                q = 0;
            //Regeita caractere não identificado 
            }else{ 
//                System.out.println("Estado: ".concat(String.valueOf(q))
//                                    .concat(" Posição: ").concat(String.valueOf(k))
//                                    .concat(" Token: ").concat("Erro Léxico")
//                                    .concat(" Lexema: ").concat(separado[k]).concat("Caractere não esperado"));
                count--;
                k++;
            }
            } catch(Exception e){
                System.out.println(e.getMessage());
                System.out.println("Estado não encontrado");
                break;
            }
        }
        
        return t.getListatokens();
        
             
            */
            
        }
        
        
        
        
//        $sAfdPrinc = $this->tabelas();
//        $aEstadosFinais = $this->estadosFinais();
//        $iEstado = 0;
//        $sLexema = '';
//        $i = 0;
//        $sAfdPrinc = $this->tabelas();
//        $aEstadosFinais;
//        $sListaTokens = array();
//      while ($i<count_chars($sTexto)){
//      try {
//      $iEstado = $sAfdPrinc[$iEstado][substr($sTexto, $i, 1)];
//      $sLexema = $sLexema.substr($sTexto, $i, 1);
//      $i++;
//      } catch (Exception $ex) {
//      if(isset($aEstadosFinais[$iEstado])){
//      $sListaTokens[$i] = [$aEstadosFinais[$iEstado],$sLexema];
//      $iEstado = 0;
//      $sLexema = '';
//      }else{
//      return "Erro Léxico";
//      }
//      }
//      }
//      return '';
//      }
    }

//    public function mostraModalTabelaLexica($sDados){
//        
//        $oPersistenciaCSV = new PersistenciaCSV();
//        $aTabela = $oPersistenciaCSV->retornaArrayCSV("defReg.csv"); 
//        $oViewModal = new ViewModal();
//        $sModal = $oViewModal->geraModalTabelaLexica($aTabela);
//
//        return json_encode($sModal);
//    }
//    
}