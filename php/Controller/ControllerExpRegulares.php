<?php

/*
 * Classe que analisa as expressões regulares definidas pelo usuário
 * e realiza a criação da tabela de transição (automato) para a análise léxica
 */

class ControllerExpRegulares extends Controller {

    public function __construct() {
        $this->carregaClasses('ExpRegulares');
    }

    /**
     * Método responsável por chamar o analisador de expressões regulares
     * @param type $sDados
     * @return type
     */
    public function analisaExpressoes($sDados) {

        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};
        $sText = trim($sTexto);

        $this->oPersistencia->gravaArquivo("defReg.txt", $sText);

        $sText2 = $this->analisador($sText);

        $sJson = '{"texto":"' . $sText2 . '"}';

        return json_encode($sJson);
    }

    /**
     * Método responsável por realizar a indentificação dos caracteres válidos nas expressões regulares
     * @param type $sTexto
     * @return string
     */
    public function analisador($sTexto) {
        
        $aAfd = $this->oPersistencia->retornaCaracteresInvalidos()[0];//Retorna todos os caracteres inválidos
        $aChar = str_split($sTexto);
        $sRetorno = ' ';
        foreach ($aChar as $sPos) {
            $sPos = trim($sPos);
            //Verifica se o caracter é inválido
            if (in_array($sPos, $aAfd)) { 
                $sRetorno = 'Erro Léxico Caractere (' . $sPos . ') inesperado!'; 
            } 
        }
        return $sRetorno;
    }

    /**
     * Método responsável por gerar a tabela do automato finito para análise léxica
     * @param type $sDados
     * @return type
     */
    public function geradorTabelaAutomatoFinito($sDados) {
        /*
         * @Observações iniciais
         * São caracteres especiais : e ; pois são usados no controle inicial de separação dos tokens
         */

        //Recebe o json das expressões regulares e transforma em texto.
        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};

        //Separa a string pelo ponto e vírgula
        $this->oModel->aArray = explode(';', trim($sTexto));

        //Remove a possições em branco depois do ; mais analisar se precisa 
        $key = array_search('', $this->oModel->aArray);
        if ($key !== false) {
            unset($this->oModel->aArray[$key]);
        }

        // Obtem o cabeçalho do array
        $aCabecalhoTabelaLexica = $this->oPersistencia->retornaCabecalhoTabelaLexica()[0];

        //Cria cabeçalho da tabela
        $this->oModel->aTabelaAutomato[-1] = $aCabecalhoTabelaLexica;

        //Inicializa a variável de controle de estado
        $this->oModel->iPos = 0;

        //Estado 0 sempe inicia com uma incógnita pois não reconhece nenhum elemento apenas indica para qual estado ir para reconhecer
        $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iPos;
        $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = '?';

        //Busca caracteres válidos usados para analisar e criar estados de transição conforme correspondência.
        $this->oModel->aArrayCaracteres = $this->oPersistencia->retornaCaracteresValidos()[0];

        /*
         * Inicio da análise: Percore caracteres possíveis e analisar se eles estão especificados
         * criando um estado de transisão para os mesmos 
         */

        //Cria um array do tipo Token=>Expressão Regular removendo espaços em branco
        $this->retornaArrayTokenExp();

        //Monta o estado inicial 0
        $this->montaEstadoInicial();

        //Monta os demais estados
        $this->montaEstadosTransicao();

        //Parte que salva as palavras reservadas
        $this->oPersistencia->gravaPalavrasReservadas($this->oModel->aPalavrasReservadas);

        //Parte que grava a tabela do automato para análise léxica
        $this->oPersistencia->gravaTabelaLexica($this->oModel->aTabelaAutomato);

        $sJson = '{"texto":"Sucesso!"}';

        return json_encode($sJson);
    }

    /**
     * Cria um array do tipo array[Token]=>(Expressão Regular) 
     * removendo espaços em branco e escapa o caractere ":" (Dois pontos)
     */
    public function retornaArrayTokenExp() {
        foreach ($this->oModel->aArray as $sVal1) {
            //Função que aceita o :
            if (strpos($sVal1, '\:') !== false) {
                $aArray2 = explode(':', $sVal1);
                $this->oModel->aArrayTokenExpr[trim($aArray2[0])] = ":";
            } else {
                $aArray2 = explode(':', $sVal1);
                $this->oModel->aArrayTokenExpr[trim($aArray2[0])] = trim($aArray2[1]);
            }
        }
    }

    /**
     * Monta estado inicial do automato
     */
    public function montaEstadoInicial() {
        //Percorre caracter por caracter para formar o estado 0 inicial de transição
        foreach ($this->oModel->aArrayCaracteres as $sChar) {
            //Variável de controle para não entrar nos demais ifs caso caracter já analisado
            $this->oModel->bCont = true;
            foreach ($this->oModel->aArray as $sVal) {

                //Cria um array do tipo array[0]=>token; array[1]=>exp; 
                $this->retornaArrayPosTokenExp($sVal);

                /*
                 * Retira espaços em branco
                 * Verifica palavras reservadas
                 * Pega posição que contém as definições de cada tokem ex: [a-b] ou &&
                 * E verifica se for igual a 1 inicia a criação da árvore
                 */
                if (trim($this->oModel->aArray1[1]) != "") {

                    //Tratamento de expressões em branco
                    $this->analisaExprEmBranco($sChar);

                    $this->analisaPalavrasChaves($sChar);

                    //Todas as expressões exceto palavras token:token
                    if (!($this->verificaPalavraChave($sChar))) {

                        //Escapa simbolo quando contém aspas duplas
                        $bEscapaCol = false;
                        if (strpos($this->oModel->aArray1[1], '"') !== false) {
                            $bEscapaCol = true;
                        }
                        if ($sChar != "\\t" && $sChar != "\\n" && $sChar != "\\r" && $sChar != "{" || $bEscapaCol) {

                            //Substitui textos encontrados com " por exemplo "{" por { (sem aspas)
                            if (strpos($this->oModel->aArray1[1], '"') !== false) {
                                $this->oModel->aArray1[1] = str_replace('"', '', $this->oModel->aArray1[1]);
                            }

                            //Opção de caracteres simples +, -, *, /
                            if ($this->oModel->bCont && $this->oModel->aArray1[1] == $sChar) {
                                $this->funcaoAtribuicaoVariaveis();
                            }

                            //Opção que analisa se a expressão regular do tipo [a-b] ou [a-z]* é reconhecida pelo preg_match
                            if ($this->oModel->bCont && (preg_match("/^" . $this->oModel->aArray1[1] . "$/", $sChar) == 1)) {
                                $this->funcaoAtribuicaoVariaveis();
                            }

                            //Opção que verfica duplicidade na definição de uma expressão regular do tipo ++, --, ||, &&
                            if ($this->oModel->bCont && substr_count($this->oModel->aArray1[1], $sChar) == strlen($this->oModel->aArray1[1]) && strlen($this->oModel->aArray1[1]) > 1) {
                                $this->funcaoAtribuicaoVariaveis2();
                            }
                            //Opção quando existe caracteres diferentes que definem um token tipo <=, >=
                            if ($this->oModel->bCont && (preg_match("/[" . $this->oModel->aArray1[1] . "]/", $sChar) == 1) && strlen($this->oModel->aArray1[1]) > 1) {
                                $aCarac = str_split($this->oModel->aArray1[1]);
                                if ($aCarac[0] == $sChar) {
                                    $this->funcaoAtribuicaoVariaveis2();
                                }
                            }
                        }
                    }
                }
            }
            //Coloca -1 em todas as posições que não possuem transição na tabela
            if ($this->oModel->bCont) {
                $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = -1;
            }
        }
    }

    /**
     * Cria um array do tipo array[0]=>token; array[1]=>exp; 
     * removendo espaços em branco e escapa o caractere ":" (Dois pontos)
     */
    public function retornaArrayPosTokenExp($sVal) {
        $this->oModel->aArray1 = array();

        //Função que aceita o :
        if (strpos($sVal, '\:') !== false) {
            $aArray2 = explode(':', $sVal);
            $this->oModel->aArray1[0] = trim($aArray2[0]);
            $this->oModel->aArray1[1] = ':';
        } else {
            $this->oModel->aArray1 = explode(':', $sVal);
            $this->oModel->aArray1[0] = trim($this->oModel->aArray1[0]); //Remove espaços em branco
            $this->oModel->aArray1[1] = trim($this->oModel->aArray1[1]); //Remove espaços em branco
        }
    }

    /**
     * Realiza a verificação caso exista um caracter digitado como \t, \r, ou \n
     */
    public function analisaExprEmBranco($sChar) {
        if ($sChar == "\\t" && $sChar == $this->oModel->aArray1[1]) {
            $this->funcaoAtribuicaoVariaveis();
        }
        if ($sChar == "\\n" && $sChar == $this->oModel->aArray1[1]) {
            $this->funcaoAtribuicaoVariaveis();
        }
        if ($sChar == "\\r" && $sChar == $this->oModel->aArray1[1]) {
            $this->funcaoAtribuicaoVariaveis();
        }
    }

    /**
     * Função responsável pela atribuição de valores as variáveis 
     * de acordo com os casamentos das expressões
     */
    public function funcaoAtribuicaoVariaveis() {
        if ($this->oModel->sExp != $this->oModel->aArray1[1]) {
            $this->oModel->iEst++;
            $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = $this->oModel->aArray1;
            //Parte que retira as expressões que possuem estado (Ficar só compostas)
            if (isset($this->oModel->aArrayTokenExpr[$this->oModel->aArray1[0]])) {
                unset($this->oModel->aArrayTokenExpr[$this->oModel->aArray1[0]]);
            }
        }
        $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iEst;
        $this->oModel->bCont = false;
        $this->oModel->sExp = $this->oModel->aArray1[1];
    }

    /**
     * Função responsável pela atribuição de valores as variáveis 
     * de acordo com os casamentos das expressões adiciona token com ?
     */
    public function funcaoAtribuicaoVariaveis2() {
        if ($this->oModel->sExp != $this->oModel->aArray1[1]) {
            $this->oModel->iEst++;
            $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = $this->oModel->aArray1;
            $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = ["?", $this->oModel->aArray1[1], $this->oModel->aArray1[0]]; //Adiciona o token
            //Parte que retira as expressões que possuem estado (Ficar só compostas)
            if (isset($this->oModel->aArrayTokenExpr[$this->oModel->aArray1[0]])) {
                unset($this->oModel->aArrayTokenExpr[$this->oModel->aArray1[0]]);
            }
        }
        $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iEst;
        $this->oModel->bCont = false;
        $this->oModel->sExp = $this->oModel->aArray1[1];
    }

    /**
     * Retorna se o caracter pertence ou não a palavra chave
     * @param type $sChar
     * @return boolean
     */
    public function verificaPalavraChave($sChar) {
        $bRetorno = false;
        if ((trim($this->oModel->aArray1[0]) == trim($this->oModel->aArray1[1])) && preg_match("/[" . $this->oModel->aArray1[1] . "]/", $sChar) == 1) {
            $bRetorno = true;
        }
        return $bRetorno;
    }

    /**
     * Função que realiza a transição das palavras chaves conforme caracter
     * @param type $sChar
     */
    public function analisaPalavrasChaves($sChar) {
        if ($this->verificaPalavraChave($sChar)) {
            if ($this->oModel->bCont && (preg_match("/[" . $this->oModel->aArray1[1] . "]/", $sChar) == 1) && strlen($this->oModel->aArray1[1]) > 1) {
                $aCarac = str_split($this->oModel->aArray1[1]);
                if ($aCarac[0] == $sChar) {
                    $this->oModel->aPalavrasReservadas[] = [trim($this->oModel->aArray1[0]), trim($this->oModel->aArray1[0])]; //Preenche array com as palavras chaves para posterior salvar em csv
                    $this->oModel->aArrayPalavraChave[trim($this->oModel->aArray1[0])] = trim($this->oModel->aArray1[0]); //Armazena palavras chaves para analise posterior
                //    $this->oModel->iEst = $this->oModel->iEst + $this->oModel->iEstRes; //Realiza controle dos estados das palavras reservadas
                    $this->funcaoAtribuicaoVariaveis2();
                //    $this->oModel->iEstRes++;
                //    $this->oModel->iEst = $this->oModel->iEst - $this->oModel->iEstRes - 1;
                }
            }
        }
    }

    /*
     * Monta os estados de transição e final
     */

    public function montaEstadosTransicao() {

        $this->oModel->iPos++;
        $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iPos;
        ksort($this->oModel->aArrayEstTokenExpr); //Ordena o array conforme os estados do menor para o maior
        //Monta o índice de tokens retornados e estados de transição de tokens compostos
        $this->oModel->bCont = true;

        //Armazena todas as expressões simples pelo token que são diferentes dos estados de transição e seu respectivo estado
        foreach ($this->oModel->aArrayEstTokenExpr as $iEstado => $aVal) {
            if ($aVal[0] != "?") {
                $this->oModel->aArrayExprEst[trim($aVal[0])] = [$iEstado, $aVal[1]];
            }
        }

        //Adiciona os estados que são transições das palavras reservadas
        $this->oModel->iEst = $this->oModel->iEst + $this->oModel->iEstRes;

        //Percorre todos estados que possuem transição ou formam um estado de transição e final
        while (count($this->oModel->aArrayEstTokenExpr) >= $this->oModel->iPos) {

            $aVal = $this->oModel->aArrayEstTokenExpr[$this->oModel->iPos]; //Token, expressão

            $aToken = $this->verificaEstadoComposto($aVal); //Verifica se o atual estado é estado final e de transição composto por outro ex: [a-z]* ou [a-z]+

            $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = trim($aToken[0]); //Seta o token retornado de cada estado

            $this->oModel->iki = 0; //Contador importante para as expressões compostas
            //Percorre os caracteres colocando -1 quando não tem transição ou o estado de transição
            foreach ($this->oModel->aArrayCaracteres as $sChar) {

                $this->oModel->bCont = true;

                $this->funcaoAtribuicaoTokenTransicao($aVal, $sChar); //Se for ? é por que é um estado de transição e não de aceitação

                $this->funcaoAtribuicaoComposta($aVal, $sChar); //Expressões compostas por outras expressões

                $this->funçãoAtribuicaoCuringa($sChar, $aToken); //Expressões compostas por + ou *
                //Coloca -1 em todas as posições que não possuem transição na tabela
                if ($this->oModel->bCont) {
                    $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = -1;
                }
            }
            $this->oModel->iPos++;
            if (count($this->oModel->aArrayEstTokenExpr) >= $this->oModel->iPos) {
                $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iPos;
            }
        }
    }

    /**
     * Função responsável por retornar nome do token da expressão equivalente caso o estado for composto
     * @param type $aVal
     * @return type
     */
    public function verificaEstadoComposto($aVal) {
        if ($aVal[0] == "?") {
            foreach ($this->oModel->aArrayEstTokenExpr as $iEstado => $aValor) {
                if (($aValor[1] != $aVal[1]) && preg_match("/^" . $aValor[1] . "$/", $aVal[1]) == 1 && (strpos($aValor[1], '*') !== false || strpos($aValor[1], '+') !== false)) {
                    return $aValor;
                }
            }
            return $aVal;
        } else {
            return $aVal;
        }
    }

    /**
     * Se for ? é por que é um estado de transição e não de aceitação
     * @param type $aVal
     * @param type $sChar
     */
    public function funcaoAtribuicaoTokenTransicao($aVal, $sChar) {
        if ($aVal[0] == "?") {
            $this->oModel->aArray1 = str_split($aVal[1]);
            //Possibilidade dupla caracteres igual
            if (strlen($aVal[1]) == 2) {
                if ($this->oModel->aArray1[1] == $sChar) {
                    $this->oModel->iEst++;
                    $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = [$aVal[2], $this->oModel->aArray1[1]];
                    $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iEst;
                    $this->oModel->bCont = false;
                }
            }
            //Possibilidade n caracteres iguais
            if (count($this->oModel->aArray1) > 2) {
                if ($this->oModel->aArray1[1] == $sChar) {
                    $this->oModel->iEst++;
                    $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = ["?", substr($aVal[1], 1), $aVal[2]];
                    $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iEst;
                    $this->oModel->bCont = false;
                }
            }
        }
    }

    /**
     * Função que realiza o empilhamento de estados de expressões compostas por outras expressões
     * @param type $aVal
     * @param type $sChar
     */
    public function funcaoAtribuicaoComposta($aVal, $sChar) {
        if (count($this->oModel->aArrayTokenExpr) > 0) {
            foreach ($this->oModel->aArrayTokenExpr as $key => $sExprr) {
                $sValorExp1 = str_replace("}{", ",", trim($sExprr));
                $sValorExp2 = str_replace("{", "", $sValorExp1);
                $sValorExp = str_replace("}", "", $sValorExp2);
                $aArrayComp = explode(',', $sValorExp);
                foreach ($aArrayComp as $sKey1 => $sLexic) {
                    if (trim($aVal[0]) == trim($sLexic) && isset($aArrayComp[$sKey1 + 1])) {
                        $sChave = trim($aArrayComp[$sKey1 + 1]);
                        $sExp2 = $this->oModel->aArrayExprEst[$sChave][1];
                        if ((preg_match("/^" . $sExp2 . "$/", $sChar) == 1) && $sChar != "\\t" && $sChar != "\\n" && $sChar != "\\r") {

                            $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iEst;
                            $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = [$key, $aArrayComp];
                            if ($this->oModel->iki == 0) {
                                $this->oModel->iEst++;
                                $this->oModel->iki++;
                            }
                            $this->oModel->bCont = false;
                        }
                    }
                }
            }
        }
    }

    /**
     * Função que verifica se necessário alguma transição para o mesmo estado caso * ou +
     */
    public function funçãoAtribuicaoCuringa($sChar, $aToken) {
        if ($this->oModel->bCont) {
            //Atribui a transição para seu próprio estado caso necessário
            if (preg_match("/^" . $aToken[1] . "$/", $sChar) == 1 && (strpos($aToken[1], '*') !== false || strpos($aToken[1], '+') !== false)) {
                $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iPos;
                $this->oModel->bCont = false;
            } else {
                //Verifica a atribuição para as palavras reservadas compostas em uma expressão curringa ex: else seguido de uma letra pertence a exp: [a-z]*
                if (isset($this->oModel->aArrayPalavraChave[$aToken[0]])) {
                    foreach ($this->oModel->aArrayExprEst as $sKey1 => $aLexic) {
                        if (preg_match("/^" . $aLexic[1] . "$/", $sChar) == 1 &&
                                preg_match("/^" . $aLexic[1] . "$/", $aToken[0]) == 1 &&
                                (strpos($aLexic[1], '*') !== false || strpos($aLexic[1], '+') !== false)) {

                            $this->oModel->aArrayEstTokenExpr[$this->oModel->iEst] = [$sKey1, $aLexic[1]];
                            $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iEst;
                            if ($this->oModel->iki == 0) {
                                $this->oModel->iEst++;
                                $this->oModel->iki++;
                            }
                            $this->oModel->bCont = false;
                        }
                    }
                } else {
                    //Verifica se um estado final de atribuição composta necessita emplimento do mesmo, no ex soma:{mais}{num}; onde num:[0-9]*;
                    if (isset($aToken[1][1])) { //Verifica se existe variáveis
                        if (isset($this->oModel->aArrayExprEst[$aToken[1][1]][1])) {
                            if (preg_match("/^" . $this->oModel->aArrayExprEst[$aToken[1][1]][1] . "$/", $sChar) == 1 && (strpos($this->oModel->aArrayExprEst[$aToken[1][1]][1], '*') !== false || strpos($this->oModel->aArrayExprEst[$aToken[1][1]][1], '+') !== false)) {
                                $this->oModel->aTabelaAutomato[$this->oModel->iPos][] = $this->oModel->iPos;
                                $this->oModel->bCont = false;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Método que mostra modal da tabela do automato para a léxica
     * @param type $sDados
     * @return type
     */
    public function mostraModalTabelaLexica($sDados) {

        $aTabela = $this->oPersistencia->retornaArrayCSV("tabelaAnaliseLexica.csv", 1);
        $sModal = $this->oView->geraModalTabelaLexica($aTabela);
        $this->oPersistencia->gravaArquivo("modal.html", $sModal);

        return json_encode($sModal);
    }

}
