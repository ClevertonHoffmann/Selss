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
    private array $aListadeTokens; 
    
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
        $this->aListadeTokens = array();
//         $this->$t = new TokenFactoryList();
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
            $this->iCount--;
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

/*
      public function analisadorLexico($sTexto) {
      $sAfdPrinc = $this->tabelas();
      $aEstadosFinais = $this->estadosFinais();
      $iEstado = 0;
      $sLexema = '';
      $i = 0;$sAfdPrinc = $this->tabelas();
      $aEstadosFinais
      $sListaTokens = array();
      while ($i<count_chars($sTexto)){
      try {
      $iEstado = $sAfdPrinc[$iEstado][substr($sTexto, $i, 1)];
      $sLexema = $sLexema.substr($sTexto, $i, 1);
      $i++;
      } catch (Exception $ex) {
      if(isset($aEstadosFinais[$iEstado])){
      $sListaTokens[$i] = [$aEstadosFinais[$iEstado],$sLexema];
      $iEstado = 0;
      $sLexema = '';
      }else{
      return "Erro Léxico";
      }
      }
      }
      return '';
      }

      public function tabelas(){

      $sAfdPrinc = array();

      $sAfd = array();
      //0 - id:
      /*        $sAfd["a"] = 0;
      $sAfd["b"] = 0;
      $sAfd["c"] = 0;
      $sAfd["d"] = 0;
      $sAfd["e"] = 0;
      $sAfd["f"] = 0;
      $sAfd["g"] = 0;
      $sAfd["h"] = 0;
      $sAfd["i"] = 0;
      $sAfd["j"] = 0;
      $sAfd["k"] = 0;
      $sAfd["l"] = 0;
      $sAfd["m"] = 0;
      $sAfd["n"] = 0;
      $sAfd["o"] = 0;
      $sAfd["p"] = 0;
      $sAfd["q"] = 0;
      $sAfd["r"] = 0;
      $sAfd["s"] = 0;
      $sAfd["t"] = 0;
      $sAfd["u"] = 0;
      $sAfd["v"] = 0;
      $sAfd["x"] = 0;
      $sAfd["y"] = 0;
      $sAfd["z"] = 0;
      $sAfd["ç"] = 0;
      $sAfd["A"] = 0;
      $sAfd["B"] = 0;
      $sAfd["C"] = 0;
      $sAfd["D"] = 0;
      $sAfd["E"] = 0;
      $sAfd["F"] = 0;
      $sAfd["G"] = 0;
      $sAfd["I"] = 0;
      $sAfd["J"] = 0;
      $sAfd["K"] = 0;
      $sAfd["L"] = 0;
      $sAfd["M"] = 0;
      $sAfd["N"] = 0;
      $sAfd["O"] = 0;
      $sAfd["P"] = 0;
      $sAfd["Q"] = 0;
      $sAfd["R"] = 0;
      $sAfd["S"] = 0;
      $sAfd["T"] = 0;
      $sAfd["U"] = 0;
      $sAfd["V"] = 0;
      $sAfd["X"] = 0;
      $sAfd["Y"] = 0;
      $sAfd["Z"] = 0;
      $sAfd["Ç"] = 0;
      $sAfd["1"] = 0;
      $sAfd["2"] = 0;
      $sAfd["3"] = 0;
      $sAfd["4"] = 0;
      $sAfd["5"] = 0;
      $sAfd["6"] = 0;
      $sAfd["7"] = 0;
      $sAfd["8"] = 0;
      $sAfd["9"] = 0;
      $sAfd["0"] = 0;
      $sAfd[" "] = 0;
      $sAfd[":"] = 1;
      $sAfd[","] = -1;
      $sAfd["."] = -1;
      $sAfd["\'"] = -1;
      $sAfd["@"] = -1;
      $sAfd["#"] = -1;
      $sAfd["$"] = -1;
      $sAfd["%"] = -1;
      $sAfd["¨"] = -1;
      $sAfd["&"] = -1;
      $sAfd["*"] = -1;
      $sAfd["("] = -1;
      $sAfd[")"] = -1;
      $sAfd["_"] = -1;
      $sAfd["+"] = -1;
      $sAfd["-"] = -1;
      $sAfd["´"] = -1;
      $sAfd["`"] = -1;
      $sAfd["{"] = -1;
      $sAfd["}"] = -1;
      $sAfd["ª"] = -1;
      $sAfd["º"] = -1;
      $sAfd["~"] = -1;
      $sAfd["^"] = -1;
      $sAfd["<"] = -1;
      $sAfd[">"] = -1;
      $sAfd[";"] = -1;
      $sAfd["?"] = -1;
      $sAfd["/"] = -1;
      $sAfd["\\"] = -1;
      $sAfd["\t"] = -1;
      $sAfd["\n"] = -1;
      $sAfd["\r"] = -1;
      $sAfd["]"] = -1;
      $sAfd["["] = -1;

      $sAfd["a"] = 1;
      $sAfd["b"] = 1;
      $sAfd["c"] = 1;
      $sAfd["d"] = 1;
      $sAfd["e"] = 1;
      $sAfd["f"] = 1;
      $sAfd["g"] = 1;
      $sAfd["h"] = 1;
      $sAfd["i"] = 1;
      $sAfd["j"] = 1;
      $sAfd["k"] = 1;
      $sAfd["l"] = 1;
      $sAfd["m"] = 1;
      $sAfd["n"] = 1;
      $sAfd["o"] = 1;
      $sAfd["p"] = 1;
      $sAfd["q"] = 1;
      $sAfd["r"] = 1;
      $sAfd["s"] = 1;
      $sAfd["t"] = 1;
      $sAfd["u"] = 1;
      $sAfd["v"] = 1;
      $sAfd["x"] = 1;
      $sAfd["y"] = 1;
      $sAfd["z"] = 1;
      $sAfd["ç"] = 1;
      $sAfd["A"] = 1;
      $sAfd["B"] = 1;
      $sAfd["C"] = 1;
      $sAfd["D"] = 1;
      $sAfd["E"] = 1;
      $sAfd["F"] = 1;
      $sAfd["G"] = 1;
      $sAfd["I"] = 1;
      $sAfd["J"] = 1;
      $sAfd["K"] = 1;
      $sAfd["L"] = 1;
      $sAfd["M"] = 1;
      $sAfd["N"] = 1;
      $sAfd["O"] = 1;
      $sAfd["P"] = 1;
      $sAfd["Q"] = 1;
      $sAfd["R"] = 1;
      $sAfd["S"] = 1;
      $sAfd["T"] = 1;
      $sAfd["U"] = 1;
      $sAfd["V"] = 1;
      $sAfd["X"] = 1;
      $sAfd["Y"] = 1;
      $sAfd["Z"] = 1;
      $sAfd["Ç"] = 1;
      $sAfd["1"] = 1;
      $sAfd["2"] = 1;
      $sAfd["3"] = 1;
      $sAfd["4"] = 1;
      $sAfd["5"] = 1;
      $sAfd["6"] = 1;
      $sAfd["7"] = 1;
      $sAfd["8"] = 1;
      $sAfd["9"] = 1;
      $sAfd["0"] = 1;
      $sAfd[" "] = -1;
      $sAfd[":"] = 1;
      $sAfd[","] = -1;
      $sAfd["."] = -1;
      $sAfd["\'"] = -1;
      $sAfd["@"] = -1;
      $sAfd["#"] = -1;
      $sAfd["$"] = -1;
      $sAfd["%"] = -1;
      $sAfd["¨"] = -1;
      $sAfd["&"] = -1;
      $sAfd["*"] = -1;
      $sAfd["("] = -1;
      $sAfd[")"] = -1;
      $sAfd["_"] = -1;
      $sAfd["+"] = -1;
      $sAfd["-"] = -1;
      $sAfd["´"] = -1;
      $sAfd["`"] = -1;
      $sAfd["{"] = -1;
      $sAfd["}"] = -1;
      $sAfd["ª"] = -1;
      $sAfd["º"] = -1;
      $sAfd["~"] = -1;
      $sAfd["^"] = -1;
      $sAfd["<"] = -1;
      $sAfd[">"] = -1;
      $sAfd[";"] = -1;
      $sAfd["?"] = -1;
      $sAfd["/"] = -1;
      $sAfd["\\"] = -1;
      $sAfd["\t"] = -1;
      $sAfd["\n"] = -1;
      $sAfd["\r"] = -1;
      $sAfd["]"] = -1;
      $sAfd["["] = 2;

      $sAfdPrinc[0] = $sAfd;

      //1 - :
      $sAfd["a"] = -1;
      $sAfd["b"] = -1;
      $sAfd["c"] = -1;
      $sAfd["d"] = -1;
      $sAfd["e"] = -1;
      $sAfd["f"] = -1;
      $sAfd["g"] = -1;
      $sAfd["h"] = -1;
      $sAfd["i"] = -1;
      $sAfd["j"] = -1;
      $sAfd["k"] = -1;
      $sAfd["l"] = -1;
      $sAfd["m"] = -1;
      $sAfd["n"] = -1;
      $sAfd["o"] = -1;
      $sAfd["p"] = -1;
      $sAfd["q"] = -1;
      $sAfd["r"] = -1;
      $sAfd["s"] = -1;
      $sAfd["t"] = -1;
      $sAfd["u"] = -1;
      $sAfd["v"] = -1;
      $sAfd["x"] = -1;
      $sAfd["y"] = -1;
      $sAfd["z"] = -1;
      $sAfd["ç"] = -1;
      $sAfd["A"] = -1;
      $sAfd["B"] = -1;
      $sAfd["C"] = -1;
      $sAfd["D"] = -1;
      $sAfd["E"] = -1;
      $sAfd["F"] = -1;
      $sAfd["G"] = -1;
      $sAfd["I"] = -1;
      $sAfd["J"] = -1;
      $sAfd["K"] = -1;
      $sAfd["L"] = -1;
      $sAfd["M"] = -1;
      $sAfd["N"] = -1;
      $sAfd["O"] = -1;
      $sAfd["P"] = -1;
      $sAfd["Q"] = -1;
      $sAfd["R"] = -1;
      $sAfd["S"] = -1;
      $sAfd["T"] = -1;
      $sAfd["U"] = -1;
      $sAfd["V"] = -1;
      $sAfd["X"] = -1;
      $sAfd["Y"] = -1;
      $sAfd["Z"] = -1;
      $sAfd["Ç"] = -1;
      $sAfd["1"] = -1;
      $sAfd["2"] = -1;
      $sAfd["3"] = -1;
      $sAfd["4"] = -1;
      $sAfd["5"] = -1;
      $sAfd["6"] = -1;
      $sAfd["7"] = -1;
      $sAfd["8"] = -1;
      $sAfd["9"] = -1;
      $sAfd["0"] = -1;
      $sAfd[" "] = -1;
      $sAfd[":"] = 1;
      $sAfd[","] = -1;
      $sAfd["."] = -1;
      $sAfd["\'"] = -1;
      $sAfd["@"] = -1;
      $sAfd["#"] = -1;
      $sAfd["$"] = -1;
      $sAfd["%"] = -1;
      $sAfd["¨"] = -1;
      $sAfd["&"] = -1;
      $sAfd["*"] = -1;
      $sAfd["("] = -1;
      $sAfd[")"] = -1;
      $sAfd["_"] = -1;
      $sAfd["+"] = -1;
      $sAfd["-"] = -1;
      $sAfd["´"] = -1;
      $sAfd["`"] = -1;
      $sAfd["{"] = -1;
      $sAfd["}"] = -1;
      $sAfd["ª"] = -1;
      $sAfd["º"] = -1;
      $sAfd["~"] = -1;
      $sAfd["^"] = -1;
      $sAfd["<"] = -1;
      $sAfd[">"] = -1;
      $sAfd[";"] = -1;
      $sAfd["?"] = -1;
      $sAfd["/"] = -1;
      $sAfd["\\"] = -1;
      $sAfd["\t"] = -1;
      $sAfd["\n"] = -1;
      $sAfd["\r"] = -1;
      $sAfd["]"] = -1;
      $sAfd["["] = 2;

      $sAfdPrinc[1] = $sAfd;

      //2 - :
      $sAfd["a"] = -1;
      $sAfd["b"] = -1;
      $sAfd["c"] = -1;
      $sAfd["d"] = -1;
      $sAfd["e"] = -1;
      $sAfd["f"] = -1;
      $sAfd["g"] = -1;
      $sAfd["h"] = -1;
      $sAfd["i"] = -1;
      $sAfd["j"] = -1;
      $sAfd["k"] = -1;
      $sAfd["l"] = -1;
      $sAfd["m"] = -1;
      $sAfd["n"] = -1;
      $sAfd["o"] = -1;
      $sAfd["p"] = -1;
      $sAfd["q"] = -1;
      $sAfd["r"] = -1;
      $sAfd["s"] = -1;
      $sAfd["t"] = -1;
      $sAfd["u"] = -1;
      $sAfd["v"] = -1;
      $sAfd["x"] = -1;
      $sAfd["y"] = -1;
      $sAfd["z"] = -1;
      $sAfd["ç"] = -1;
      $sAfd["A"] = -1;
      $sAfd["B"] = -1;
      $sAfd["C"] = -1;
      $sAfd["D"] = -1;
      $sAfd["E"] = -1;
      $sAfd["F"] = -1;
      $sAfd["G"] = -1;
      $sAfd["I"] = -1;
      $sAfd["J"] = -1;
      $sAfd["K"] = -1;
      $sAfd["L"] = -1;
      $sAfd["M"] = -1;
      $sAfd["N"] = -1;
      $sAfd["O"] = -1;
      $sAfd["P"] = -1;
      $sAfd["Q"] = -1;
      $sAfd["R"] = -1;
      $sAfd["S"] = -1;
      $sAfd["T"] = -1;
      $sAfd["U"] = -1;
      $sAfd["V"] = -1;
      $sAfd["X"] = -1;
      $sAfd["Y"] = -1;
      $sAfd["Z"] = -1;
      $sAfd["Ç"] = -1;
      $sAfd["1"] = -1;
      $sAfd["2"] = -1;
      $sAfd["3"] = -1;
      $sAfd["4"] = -1;
      $sAfd["5"] = -1;
      $sAfd["6"] = -1;
      $sAfd["7"] = -1;
      $sAfd["8"] = -1;
      $sAfd["9"] = -1;
      $sAfd["0"] = -1;
      $sAfd[" "] = -1;
      $sAfd[":"] = 1;
      $sAfd[","] = -1;
      $sAfd["."] = -1;
      $sAfd["\'"] = -1;
      $sAfd["@"] = -1;
      $sAfd["#"] = -1;
      $sAfd["$"] = -1;
      $sAfd["%"] = -1;
      $sAfd["¨"] = -1;
      $sAfd["&"] = -1;
      $sAfd["*"] = -1;
      $sAfd["("] = -1;
      $sAfd[")"] = -1;
      $sAfd["_"] = -1;
      $sAfd["+"] = -1;
      $sAfd["-"] = -1;
      $sAfd["´"] = -1;
      $sAfd["`"] = -1;
      $sAfd["{"] = -1;
      $sAfd["}"] = -1;
      $sAfd["ª"] = -1;
      $sAfd["º"] = -1;
      $sAfd["~"] = -1;
      $sAfd["^"] = -1;
      $sAfd["<"] = -1;
      $sAfd[">"] = -1;
      $sAfd[";"] = -1;
      $sAfd["?"] = -1;
      $sAfd["/"] = -1;
      $sAfd["\\"] = -1;
      $sAfd["\t"] = -1;
      $sAfd["\n"] = -1;
      $sAfd["\r"] = -1;
      $sAfd["]"] = -1;
      $sAfd["["] = 2;

      $sAfdPrinc[2] = $sAfd;


      return $sAfdPrinc;

      }

      public function estadosFinais(){

      $aEstadosFinais = array();
      $aEstadosFinais[1] = 'id';
      $aEstadosFinais[2] = 'dp';
      $aEstadosFinais[3] = 'ac';
      $aEstadosFinais[4] = 'fc';
      $aEstadosFinais[5] = 'ap';
      $aEstadosFinais[6] = 'fp';
      $aEstadosFinais[7] = 'operadores';
      $aEstadosFinais[8] = 'logico';
      $aEstadosFinais[9] = 'relacional';
      $aEstadosFinais[10] = 'simbolos';

      return $aEstadosFinais;
      }
      /*
      //    public function constroiTabelaTokens(){
      //
      //
      //        $aTabelaTokens = array();
      //        $aTabelaTokens[0] = '?';
      //        $aTabelaTokens[1] = 'dp';
      //        $aTabelaTokens[2] = '[';
      //        $aTabelaTokens[3] = '?';
      //        $aTabelaTokens[4] = '?';
      //        $aTabelaTokens[5] = '?';
      //        $aTabelaTokens[6] = '?';
      //        $aTabelaTokens[7] = '?';
      //        $aTabelaTokens[8] = '?';
      //        $aTabelaTokens[9] = '?';
      //        $aTabelaTokens[10] = '?';
      //        $aTabelaTokens[11] = '?';
      //        $aTabelaTokens[12] = '?';
      //        $aTabelaTokens[13] = '?';
      //        $aTabelaTokens[14] = '?';
      //
      //
      ////        ts.put(0, "?");
      ////        ts.put(1, "espaco");
      ////        ts.put(2, "not");
      ////        ts.put(3, "?");
      ////        ts.put(4, "ap");
      ////        ts.put(5, "fp");
      ////        ts.put(6, "mult");
      ////        ts.put(7, "soma");
      ////        ts.put(8, "v");
      ////        ts.put(9, "subt");
      ////        ts.put(10, "div");
      ////        ts.put(11, "const");
      ////        ts.put(12, "dp");
      ////        ts.put(13, "pv");
      ////        ts.put(14, "menor");
      ////        ts.put(15, "at");
      ////        ts.put(16, "maior");
      ////        ts.put(17, "id");
      ////        ts.put(18, "ac");
      ////        ts.put(19, "?");
      ////        ts.put(20, "fc");
      ////        ts.put(21, "e");
      ////        ts.put(22, "inc");
      ////        ts.put(23, "dec");
      ////        ts.put(24, "?");
      ////        ts.put(25, "const");
      ////        ts.put(26, "menorig");
      ////        ts.put(27, "dif");
      ////        ts.put(28, "igual");
      ////        ts.put(29, "maiorig");
      ////        ts.put(30, "ou");
      ////        ts.put(31, "real");
      ////        ts.put(32, "const");
      //
      //    }
      //
      //    public function palavrasReservadas(){
      //
      //        $aPalavrasReservadas = array();
      //        $aPalavrasReservadas['if'] = 'if';
      //        $aPalavrasReservadas['then'] = 'then';
      //        $aPalavrasReservadas['else'] = 'else';
      //        $aPalavrasReservadas['while'] = 'while';
      //        $aPalavrasReservadas['begin'] = 'begin';
      //        $aPalavrasReservadas['end'] = 'end';
      //        $aPalavrasReservadas['for'] = 'for';
      //        $aPalavrasReservadas['int'] = 'int';
      //        $aPalavrasReservadas['str'] = 'str';
      //        $aPalavrasReservadas['double'] = 'double';
      //        $aPalavrasReservadas['boolean'] = 'boolean';
      //        $aPalavrasReservadas['float'] = 'float';
      //
      //        return $aPalavrasReservadas;
      //    }
     */