<?php

/*
 * Classe responsável pela analise léxica e retorno dos dados de análise léxica do código digitado pelo usuário
 */

class ControllerAnalisadorLexico extends Controller {

    public function __construct() {
        $this->carregaClasses('AnalisadorLexico');
    }

    /**
     * Funcão que inicializa as variáveis utilizadas na análise léxica
     * @param type $sTexto
     * @return string
     */
    public function InicializaAnalisadorLexico($sTexto) {

        $this->getOModel()->setAPalavrasReservadas($this->getOPersistencia()->retornaPalavrasReservadas());
        $this->getOModel()->setATabelaDeTransicao($this->getOPersistencia()->retornaTabelaDeTransicao());
        $this->getOModel()->setATabelaTokens($this->getOPersistencia()->retornaTabelaDeTokens());
        $this->getOModel()->setACaracteresSeparados(str_split($sTexto));
        $this->getOModel()->setICount(count($this->getOModel()->getACaracteresSeparados()));
        $this->getOModel()->setQ(0);
        $this->getOModel()->setQntTokens(0);
        $this->getOModel()->setSBuild("");
        $this->getOModel()->setAListadeTokensLex(array());
    }

    /*
     * Método responsável por realizar a análise léxica do código
     */

    public function analiseLexica($sDados) {

        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'} . " ";
        $sText = str_replace("\n", " ", $sTexto);

        $this->getOPersistencia()->gravaArquivo("codigoParaAnalise", trim($sText), '.txt');

        $this->InicializaAnalisadorLexico($sText);

        //Inicia a análise léxica
        $iK = 0;
        while ($this->getOModel()->getICount() > 0) {
            try {
                //Aceita o caractere e avança uma posição na entrada tanto normal como com espaços
                if (!((($this->getOModel()->getATabelaDeTransicaoPosicaoEsp($this->getOModel()->getQ(),$this->getOModel()->getACaracteresSeparadosPosicao($iK))) == '-1') 
                        || (($this->getOModel()->getATabelaDeTransicaoPosicaoEsp($this->getOModel()->getQ(), "'" . $this->getOModel()->getACaracteresSeparadosPosicao($iK) . "'")) == '-1')) 
                        && $this->getOModel()->issetACaracteresSeparadosPosicao($iK) 
                        && $this->getOModel()->issetATabelaDeTransicaoPosicaoEsp($this->getOModel()->getQ(),$this->getOModel()->getACaracteresSeparadosPosicao($iK))) {
                    //Estado com espaços
                    if ($this->getOModel()->getACaracteresSeparadosPosicao($iK) == " ") {
                        //Concatena até formar um token
                        $this->getOModel()->setSBuild($this->getOModel()->getSBuild(). "'" . $this->getOModel()->getACaracteresSeparadosPosicao($iK) . "'");
                        //Seta o estado presente na tabela
                        $this->getOModel()->setQ((int) $this->getOModel()->getATabelaDeTransicaoPosicaoEsp($this->getOModel()->getQ(),"'" . $this->getOModel()->getACaracteresSeparadosPosicao($iK) . "'"));
                    } else {
                        //Concatena até formar um token
                        $this->getOModel()->setSBuild($this->getOModel()->getSBuild(). $this->getOModel()->getACaracteresSeparadosPosicao($iK));
                        //Seta o estado presente na tabela
                        $this->getOModel()->setQ((int) $this->getOModel()->getATabelaDeTransicaoPosicaoEsp($this->getOModel()->getQ(),$this->getOModel()->getACaracteresSeparadosPosicao($iK)));
                    }
                    $this->getOModel()->setICount($this->getOModel()->getICount()-1);
                    $iK++;
                    //Aceita o token
                } else if (!($this->getOModel()->getATabelaTokensPosicaoEsp($this->getOModel()->getQ()) == '?')) {
                    $this->getOModel()->setAListadeTokensLexEsp([$this->getOModel()->getATabelaTokensPosicaoEsp($this->getOModel()->getQ()), $this->getOModel()->getSBuild(), $this->getOModel()->getQntTokens()]);
                    $this->getOModel()->setQntTokens($this->getOModel()->getQntTokens()+1);
                    $this->getOModel()->setSBuild("");
                    $this->getOModel()->setQ(0);
                } else {
                    //Deixa passar caracter em branco caso não tenha sido definido
                    if ($this->getOModel()->getACaracteresSeparadosPosicao($iK) == ' ') {
                        $iK++;
                        $this->getOModel()->setICount($this->getOModel()->getICount()-1);
                    } else {
                        $this->getOModel()->setAListadeTokensLexEsp(['?', 'Caractére ' . $this->getOModel()->getACaracteresSeparadosPosicao($iK) . ' não identificado', $this->getOModel()->getQntTokens()]);
                        break;
                    }
                }
                //Regeita caractere não identificado
            } catch (Exception $ex) {
                $this->getOModel()->setAListadeTokensLexEsp(['?', 'Caractére não identificado', $this->getOModel()->getQntTokens()]);
                $sJson = '{"texto":"Estado não encontrado!"}';
                return json_encode($sJson);
            }
        }
        $aListaTokenLexPer = array();
        $aListaTokenLexPer[0] = ['Token', 'Lexema', 'Posição'];
        $sTeste = "Token    Lex    Pos \\n ";
        $sTextoRetorno = '{"texto":';
        foreach ($this->getOModel()->getAListadeTokensLex() as $aLex) {
            $sTeste .= "" . $aLex[0] . "       " . $aLex[1] . "            " . $aLex[2] . " \\n ";
            $aListaTokenLexPer[] = [$aLex[0], $aLex[1], $aLex[2]];
        }
        $this->getOPersistencia()->gravaResultadoAnaliseLexica($aListaTokenLexPer);

        $sTextoRetorno .= '"' . $sTeste . '"}';
        return json_encode($sTextoRetorno);
    }

    /**
     * Método que mostra modal da tabela de saida do resultado da análise léxica
     * @param type $sDados
     * @return type
     */
    public function mostraModalResultadoAnaliseLexica($sDados) {

        $aTabela = $this->getOPersistencia()->retornaArray("resultadoAnaliseLexica", 1);
        $sModal = $this->getOView()->geraModalResAnaliseLexica($aTabela);

        return json_encode($sModal);
    }
}
