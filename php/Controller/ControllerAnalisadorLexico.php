<?php

/*
 * Classe responsável pela analise léxica e retorno dos dados de análise léxica do código digitado pelo usuário
 */
require_once '../php/Persistencia/PersistenciaAnalisadorLexico.php';

class ControllerAnalisadorLexico {

    //Variáveis e instancias iniciais carregegadas no construtor
    public PersistenciaAnalisadorLexico $oPersistencia;
    public array $aPalavrasReservadas;
    public array $aTabelaDeTransicao;
    public array $aTabelaTokens;
    public array $aCaracteresSeparados;
    public int $iCount;
    public int $q;
    public int $qntTokens;
    public string $sBuild;
    public array $aListadeTokensLex;

    /**
     * Funcão que inicializa as variáveis utilizadas na análise léxica
     * @param type $sTexto
     * @return string
     */
    private function InicializaAnalisadorLexico($sTexto) {

        $this->oPersistencia = new PersistenciaAnalisadorLexico();
        $this->aPalavrasReservadas = $this->oPersistencia->retornaPalavrasReservadas();
        $this->aTabelaDeTransicao = $this->oPersistencia->retornaTabelaDeTransicao();
        $this->aTabelaTokens = $this->oPersistencia->retornaTabelaDeTokens();
        $this->aCaracteresSeparados = str_split($sTexto);
        $this->iCount = count($this->aCaracteresSeparados);
        $this->q = 0;
        $this->qntTokens = 0;
        $this->sBuild = "";
        $this->aListadeTokensLex = array();
        return '';
    }

    /*
     * Método responsável por realizar a análise léxica do código
     */

    public function analiseLexica($sDados) {

        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};
        $sText = trim($sTexto);

        $this->InicializaAnalisadorLexico($sText);

        //Inicia a análise léxica
        $iK = 0;
        while ($this->iCount > 0) {
            try {
                //Aceita o caractere e avança uma posição na entrada
                if ((!(($this->aTabelaDeTransicao[$this->q][$this->aCaracteresSeparados[$iK]]) == '-1')) && isset($this->aCaracteresSeparados[$iK])) {
                    //Concatena até formar um token
                    $this->sBuild .= $this->aCaracteresSeparados[$iK];
                    //Seta o estado presente na tabela
                    $this->q = (int) $this->aTabelaDeTransicao[$this->q][$this->aCaracteresSeparados[$iK]];
                    $this->iCount--;
                    $iK++;
                    //Aceita o token
                } else if (!($this->aTabelaTokens[$this->q] == '?')) {
                    if (isset($this->aPalavrasReservadas[$this->sBuild])) {
                        $this->aListadeTokensLex[] = [$this->sBuild, $this->sBuild, $this->qntTokens];
                    } else {
                        $this->aListadeTokensLex[] = [$this->aTabelaTokens[$this->q], $this->sBuild, $this->qntTokens];
                    }
                    $this->qntTokens++;
                    $this->sBuild = "";
                    $this->q = 0;
                } else {
                    $iK++;
                   // $this->iCount--;
                }
                //Regeita caractere não identificado
            } catch (Exception $ex) {
                $sJson = '{"texto":"Estado não encontrado!"}';
                return json_encode($sJson);
            }
        }
        $aListaTokenLexPer = array();
        $aListaTokenLexPer[0] = ['Token', 'Lex', 'Pos'];
        $this->aListadeTokensLex[] = [$this->aTabelaTokens[$this->q], $this->sBuild, $this->qntTokens];
        $sTeste = "Token    Lex    Pos \\n ";
        $sTextoRetorno = '{"texto":';
        foreach ($this->aListadeTokensLex as $aLex) {
            $sTeste .= "" . $aLex[0] . "    " . $aLex[1] . "         " . $aLex[2] . " \\n ";
            $aListaTokenLexPer[] = [$aLex[0],$aLex[1],$aLex[2]];
        }
        $this->oPersistencia->gravaResultadoAnaliseLexica($aListaTokenLexPer);
        $sTextoRetorno .= '"' . $sTeste . '"}';
        return json_encode($sTextoRetorno);
    }

    /*
     * Método responsável por realizar a análise léxica do código
     */

    public function analiseLexicabkp($sDados) {

        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};
        $sText = trim($sTexto);

        $this->InicializaAnalisadorLexico($sText);

        //Inicia a análise léxica
        $iK = 0;
        while ($this->iCount > 0) {
            try {
                //Aceita o caractere e avança uma posição na entrada
                if ((!(($this->aTabelaDeTransicao[$this->q][$this->aCaracteresSeparados[$iK]]) == '-1')) && isset($this->aCaracteresSeparados[$iK])) {
                    //Concatena até formar um token
                    $this->sBuild .= $this->aCaracteresSeparados[$iK];
                    //Seta o estado presente na tabela
                    $this->q = (int) $this->aTabelaDeTransicao[$this->q][$this->aCaracteresSeparados[$iK]];
                    $this->iCount--;
                    $iK++;
                    //Aceita o token
                } else {
                    if (!($this->aTabelaTokens[$this->q] == '?')) {
                        if (isset($this->aPalavrasReservadas[$this->sBuild])) {
                            $this->aListadeTokensLex[] = [$this->sBuild, $this->sBuild, $this->qntTokens];
                        } else {
                            $this->aListadeTokensLex[] = [$this->aTabelaTokens[$this->q], $this->sBuild, $this->qntTokens];
                        }
                        $this->qntTokens++;
                        $this->sBuild = "";
                        $this->q = 0;
                    } else {
                        $iK++;
                    }
                }
                //Regeita caractere não identificado
            } catch (Exception $ex) {
                $sJson = '{"texto":"Estado não encontrado!"}';
                return json_encode($sJson);
            }
        }
        $this->aListadeTokensLex[] = [$this->aTabelaTokens[$this->q], $this->sBuild, $this->qntTokens];
        $sTeste = "Token    Lex    Pos \\n ";
        $sTextoRetorno = '{"texto":';
        foreach ($this->aListadeTokensLex as $aLex) {
            $sTeste .= "" . $aLex[0] . "    " . $aLex[1] . "         " . $aLex[2] . " \\n ";
        }
        $sTextoRetorno .= '"' . $sTeste . '"}';
        return json_encode($sTextoRetorno);
    }

}
