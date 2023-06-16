<?php

/*
 * Classe que analisa as expressões regulares definidas pelo usuário
 * e realiza a criação da tabela de transição (automato) para a análise léxica
 */

class ControllerExpRegulares {

    public function analisaExpressoes($sDados) {

        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};
        $sText = trim($sTexto);

        $sText2 = $this->analisador($sText);

        $arquivo = "data\\defReg.txt";

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "w");

        //Escreve no arquivo aberto.
        fwrite($fp, $sText);

        //Fecha o arquivo.
        fclose($fp);

        $sJson = '{"texto":"' . $sText2 . '"}';

        return json_encode($sJson);
    }

    public function analisador($sTexto) {

        $sAfd = array();
        //0 - id:
        $sAfd["a"] = 0;
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
        $sAfd[":"] = 0;
        $sAfd[","] = 0;
        $sAfd["."] = 0;
        $sAfd["\'"] = -1;
        $sAfd["@"] = -1;
        $sAfd["#"] = -1;
        $sAfd["$"] = -1;
        $sAfd["%"] = 0;
        $sAfd["¨"] = -1;
        $sAfd["&"] = 0;
        $sAfd["*"] = 0;
        $sAfd["("] = 0;
        $sAfd[")"] = 0;
        $sAfd["_"] = -1;
        $sAfd["+"] = 0;
        $sAfd["-"] = 0;
        $sAfd["´"] = -1;
        $sAfd["`"] = -1;
        $sAfd["{"] = 0;
        $sAfd["}"] = 0;
        $sAfd["ª"] = -1;
        $sAfd["º"] = -1;
        $sAfd["~"] = 0;
        $sAfd["^"] = 0;
        $sAfd["<"] = 0;
        $sAfd[">"] = 0;
        $sAfd[";"] = 0;
        $sAfd["?"] = -1;
        $sAfd["/"] = -1;
        $sAfd["\\"] = -1;
        $sAfd["\t"] = 0;
        $sAfd["\n"] = 0;
        $sAfd["\r"] = 0;
        $sAfd["]"] = 0;
        $sAfd["["] = 0;

        $aChar = str_split($sTexto);
        $sRetorno = ' ';
        foreach ($aChar as $sPos) {
            if ($sAfd[$sPos] != 0) {
                $sRetorno = 'Erro Léxico Caractere ( ' . $sPos . ' ) inesperado!';
            }
        }
        return $sRetorno;
    }

    public function geradorTabelaAutomatoFinito($sDados) {


        $sCampos = json_decode($sDados);
        $sTexto = $sCampos->{'texto'};

        $aArray = explode(';', trim($sTexto));
        //Remove a possição em branco depois do ; mais analisar se precisa 
        $key = array_search('', $aArray);
        if ($key !== false) {
            unset($aArray[$key]);
        }

        //Cria cabeçalho da tabela
        $sTabelaAutomato = "Estado;Token Retornado;\\t;\\n;\\r;' ';!;\\\";#;$;%;&;';(;);*;+;,;-;.;/;0;1;2;3;4;5;6;7;8;9;:;<;=;>;?;@;A;B;C;D;E;F;G;H;I;J;K;L;M;N;O;P;Q;R;S;T;U;V;W;X;Y;Z;[;\;];^;_;`;a;b;c;d;e;f;g;h;i;j;k;l;m;n;o;p;q;r;s;t;u;v;w;x;y;z;{;|;};~;¡;¢;£;¤;¥;¦;§;¨;©;ª;«;¬;®;¯;°;±;²;³;´;µ;¶;·;¸;¹;º;»;¼;½;¾;¿;À;Á;Â;Ã;Ä;Å;Æ;Ç;È;É;Ê;Ë;Ì;Í;Î;Ï;Ð;Ñ;Ò;Ó;Ô;Õ;Ö;×;Ø;Ù;Ú;Û;Ü;Ý;Þ;ß;à;á;â;ã;ä;å;æ;ç;è;é;ê;ë;ì;í;î;ï;ð;ñ;ò;ó;ô;õ;ö;÷;ø;ù;ú;û;ü;ý;þ;ÿ; \n";
        $iPos = 0;
        //Estado 0
        $sTabelaAutomato .= $iPos . "; ?;";
        /*
         * Percorer caracteres possíveis e analisar se eles estão especificados
         * criando um estado de transisão para os mesmos 
         * ** ver como resolver quando se tem mais caminhos com o ? ex: && ++ --
         */
        $sArrayEstTokenExpr = array();
        $sArrayTokenExpr1 = array(); //(Fica somente palavras compostas)Armazena inicialmente todos os tokens porém retira os que são estados simples ou palavras reservadas definidas a partir de uma expressão 
        $sArrayTokenExpr2 = array(); //Palavras reservadas quando não sozinhas
        $iEst = 0; //Inicia contador de estado em 0
        $iEst2 = 0; //Contador composto caso de palavras reservadas
        $sExp = '';
        $sCaracteres = "\\t;\\n;\\r;' ';!;\";#;$;%;&;';(;);*;+;,;-;.;/;0;1;2;3;4;5;6;7;8;9;:;<;=;>;?;@;A;B;C;D;E;F;G;H;I;J;K;L;M;N;O;P;Q;R;S;T;U;V;W;X;Y;Z;[;\;];^;_;`;a;b;c;d;e;f;g;h;i;j;k;l;m;n;o;p;q;r;s;t;u;v;w;x;y;z;{;|;};~;¡;¢;£;¤;¥;¦;§;¨;©;ª;«;¬;®;¯;°;±;²;³;´;µ;¶;·;¸;¹;º;»;¼;½;¾;¿;À;Á;Â;Ã;Ä;Å;Æ;Ç;È;É;Ê;Ë;Ì;Í;Î;Ï;Ð;Ñ;Ò;Ó;Ô;Õ;Ö;×;Ø;Ù;Ú;Û;Ü;Ý;Þ;ß;à;á;â;ã;ä;å;æ;ç;è;é;ê;ë;ì;í;î;ï;ð;ñ;ò;ó;ô;õ;ö;÷;ø;ù;ú;û;ü;ý;þ;ÿ";
        $aArrayCaracteres = explode(';', $sCaracteres);
        //Cria um array do tipo Token=>Expressão Regular
        foreach ($aArray as $sVal1) {
            $aArray2 = explode(':', $sVal1);
            $sArrayTokenExpr1[$aArray2[0]] = $aArray2[1];
        }
        foreach ($aArrayCaracteres as $sChar) {
            $bCont = true;
            foreach ($aArray as $sVal) {
                $aArray1 = explode(':', $sVal);
                /*
                 * Retira espaços em branco
                 * Pega posição que contém as definições de cada tokem ex: [a-b] ou &&
                 * E verifica se for igual a 1 inicia a criação da árvore
                 */
                if (trim($aArray1[1]) != "") {
                    //Todas as expressões exceto palavras token:token
                    if (!(trim($aArray1[0]) == trim($aArray1[1]))) {
                        //Tratamento de expressões em branco
                        if ($sChar == "\\t" && $sChar == $aArray1[1]) {
                            if ($sExp != $aArray1[1]) {
                                $iEst++;
                                $sArrayEstTokenExpr[$iEst] = $aArray1;
                                //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                    unset($sArrayTokenExpr1[$aArray1[0]]);
                                }
                            }
                            $sTabelaAutomato .= '' . $iEst . ';';
                            $bCont = false;
                            $sExp = $aArray1[1];
                            //echo 'aqui entra se precisa fazer alguma projeção para frente';
                        }
                        if ($sChar == "\\n" && $sChar == $aArray1[1]) {
                            if ($sExp != $aArray1[1]) {
                                $iEst++;
                                $sArrayEstTokenExpr[$iEst] = $aArray1;
                                //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                    unset($sArrayTokenExpr1[$aArray1[0]]);
                                }
                            }
                            $sTabelaAutomato .= '' . $iEst . ';';
                            $bCont = false;
                            $sExp = $aArray1[1];
                            //echo 'aqui entra se precisa fazer alguma projeção para frente';
                        }
                        if ($sChar == "\\r" && $sChar == $aArray1[1]) {
                            if ($sExp != $aArray1[1]) {
                                $iEst++;
                                $sArrayEstTokenExpr[$iEst] = $aArray1;
                                //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                    unset($sArrayTokenExpr1[$aArray1[0]]);
                                }
                            }
                            $sTabelaAutomato .= '' . $iEst . ';';
                            $bCont = false;
                            $sExp = $aArray1[1];
                            //echo 'aqui entra se precisa fazer alguma projeção para frente';
                        }
                        if ($sChar != "\\t" && $sChar != "\\n" && $sChar != "\\r" && $sChar != "{") {
                            //Opção que analisa se a expressão regular é reconhecida pelo preg_match
                            if ($bCont && (preg_match("/" . $aArray1[1] . "/", $sChar) == 1)) {
                                if ($sExp != $aArray1[1]) {
                                    $iEst++;
                                    $sArrayEstTokenExpr[$iEst] = $aArray1;
                                    //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                    if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                        unset($sArrayTokenExpr1[$aArray1[0]]);
                                    }
                                }
                                $sTabelaAutomato .= '' . $iEst . ';';
                                $bCont = false;
                                $sExp = $aArray1[1];
                            }
                            //Opção que verfica duplicidade na definição de uma expressão regular do tipo ++, --, ||, &&
                            if ($bCont && substr_count($aArray1[1], $sChar) == strlen($aArray1[1]) && strlen($aArray1[1]) > 1) {
                                if ($sExp != $aArray1[1]) {
                                    $iEst++;
                                    $sArrayEstTokenExpr[$iEst] = ["?", $aArray1[1], $aArray1[0]]; //Adiciona o token
                                    //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                    if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                        unset($sArrayTokenExpr1[$aArray1[0]]);
                                    }
                                }
                                $sTabelaAutomato .= '' . $iEst . ';';
                                $bCont = false;
                                $sExp = $aArray1[1];
                            }
                            //Opção quando existe caracteres diferentes que definem um token tipo <=, >=
                            if ($bCont && (preg_match("/[" . $aArray1[1] . "]/", $sChar) == 1) && strlen($aArray1[1]) > 1) {
                                $aCarac = str_split($aArray1[1]);
                                if ($aCarac[0] == $sChar) {
                                    if ($sExp != $aArray1[1]) {
                                        $iEst++;
                                        $sArrayEstTokenExpr[$iEst] = ["?", $aArray1[1], $aArray1[0]]; //Adiciona o token
                                        //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                        if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                            unset($sArrayTokenExpr1[$aArray1[0]]);
                                        }
                                    }
                                    $sTabelaAutomato .= '' . $iEst . ';';
                                    if ($aArray1[1] == $aArray1[0]) {
                                        $iEst--;
                                        $iEst2++;
                                    }
                                    $sExp = $aArray1[1];
                                    $bCont = false;
                                }
                            }
                        }
                    } else {
                        /**
                         * Opção que armazena as palavras reservadas em um array extra caso tenha composições antes ou depois [a-z]
                         * se não for composto realiza as transições das palavras chaves
                         * ex: else, if, while 
                         */
                        $sContr = false;
                        //Percorre todas as entradas verificando se as palavras chaves else não esteja em uma composição
                        //Do tipo letras:[a-z]
                        foreach ($aArray as $sVal3) {
                            $aArrayAux = explode(':', $sVal3);
                            if ((preg_match("/" . $aArrayAux[1] . "/", $aArray1[1]) == 1) && $aArrayAux[1] != $aArray1[1]) {
                                $sContr = true;
                            }
                        }
                        //Só entra caso as palavras chaves sejam compostas em uma expressão
                        if ($sContr) {
                            $sArrayTokenExpr2[$aArray1[0]] = $aArray1[1];
                        }
                        //Coloca no estado 0  as transições quando 
                        //as palavras chaves forem apenas composições simples sem ser composta em [a-z]
                        if (!$sContr) {
                            if ($bCont && (preg_match("/[" . $aArray1[1] . "]/", $sChar) == 1) && strlen($aArray1[1]) > 1) {
                                $aCarac = str_split($aArray1[1]);
                                if ($aCarac[0] == $sChar) {
                                    if ($sExp != $aArray1[1]) {
                                        $iEst++;
                                        $sArrayEstTokenExpr[$iEst] = ["?", $aArray1[1], $aArray1[0]]; //Adiciona o token
                                        //Parte que retira as expressões que possuem estado (Ficar só compostas)
                                        if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                                            unset($sArrayTokenExpr1[$aArray1[0]]);
                                        }
                                    }
                                    $sTabelaAutomato .= '' . $iEst . ';';
                                    $sExp = $aArray1[1];
                                    $bCont = false;
                                }
                            }
                        }
                        //Parte que retira as expressões que possuem estado (Ficar só compostas)
                        if (isset($sArrayTokenExpr1[$aArray1[0]])) {
                            unset($sArrayTokenExpr1[$aArray1[0]]);
                        }
                    }
                }
            }
            //Coloca -1 em todas as posições que não possuem transição na tabela
            if ($bCont) {
                $sTabelaAutomato .= '-1;';
            }
        }
        $sTabelaAutomato .= " \n ";

        $iPos++;
        ksort($sArrayEstTokenExpr); //Ordena o array conforme os estados do menor para o maior
        //Monta o índice de tokens retornados e estados de transição de tokens compostos
        $bCont = true;
        //Array que armazena todos as expressões simples pelo token que são diferentes dos estados de transição e seu
        //respectivo estado
        $aArrayExprEst = array();
        foreach ($sArrayEstTokenExpr as $iEstado => $aVal) {
            if ($aVal[0] != "?") {
                $aArrayExprEst[trim($aVal[0])] = [$iEstado, $aVal[1]];
            }
        }
        $iEst = $iEst + $iEst2; //Adiciona os estados que são transições das palavras reservadas
        while (count($sArrayEstTokenExpr) >= $iPos) {
            $sVal = $sArrayEstTokenExpr[$iPos];
            $sTabelaAutomato .= $iPos . "; " . trim($sVal[0]) . "; "; //Seta o estado de cada expressão
            $iki = 0; //Contador importante para as expressões compostas
            //Percorre os caracteres colocando -1 quando não tem transição ou o estado de transição
            foreach ($aArrayCaracteres as $sChar) {
                $bCont = true;
                if ($sVal[0] == "?") { //Se for ? é por que é um token composto, estado de transição e não de aceitação
                    $aArray1 = str_split($sVal[1]);
                    //Possibilidade dupla caracteres igual
                    if (strlen($sVal[1]) == 2) {
                        if ($aArray1[1] == $sChar) {
                            $iEst++;
                            $sArrayEstTokenExpr[$iEst] = [$sVal[2], $aArray1[1]];
                            $sTabelaAutomato .= '' . $iEst . ';';
                            $bCont = false;
                        }
                    }
                    //Possibilidade n caracteres iguais
                    if (count($aArray1) > 2) {
                        if ($aArray1[1] == $sChar) {
                            $iEst++;
                            $sArrayEstTokenExpr[$iEst] = ["?", substr($sVal[1], 1), $sVal[2]];
                            $sTabelaAutomato .= '' . $iEst . ';';
                            $bCont = false;
                        }
                    }
                }
                //Palavras reservadas ////////////////////////////////////////////////ARRUMAR ESTÁ FALTANDO UM ESTADO
                if (count($sArrayTokenExpr2) > 0) {
                    foreach ($sArrayTokenExpr2 as $key => $sExprr) {
                        $aArray1 = str_split($sExprr);
                        if ((preg_match("/" . $sVal[1] . "/", $aArray1[1]) == 1) && $aArray1[1] == $sChar) {
                            $iEst++;
                            //Mais que dois caracteres
                            if (strlen(substr($sExprr, 1)) > 2) {
                                $sArrayEstTokenExpr[$iEst] = [$sVal[0], substr($sExprr, 1), $key, $iPos, $sVal[1]];
                            } else {
                                $sArrayEstTokenExpr[$iEst] = [$key, $sExprr, $key, $iPos, $sVal[1]];
                            }
                            $sTabelaAutomato .= '' . $iEst . ';';
                            unset($sArrayTokenExpr2[$key]);
                            $bCont = false;
                        }
                    }
                }
                //Tendo 3 é palavra reservada e precisa colocar o estado de transição composta por ex:id
                //Ou indicar mais um estado dependendo dos caracteres
                if (isset($sVal[3])) {
                    if (preg_match("/" . $sVal[4] . "/", $sChar) == 1 && $sChar != "\\t" && $sChar != "\\n" && $sChar != "\\r") {
                        if ($sVal[0] == $sVal[2]) {
                            $sTabelaAutomato .= '' . $sVal[3] . ';';
                            $bCont = false;
                        } else {
                            $aArray1 = str_split($sVal[1]);
                            if ((preg_match("/" . $sVal[4] . "/", $aArray1[1]) == 1) && $aArray1[1] == $sChar) {
                                $iEst++;
                                //Mais que dois caracteres
                                if (strlen(substr($sVal[1], 1)) > 2) {
                                    $sArrayEstTokenExpr[$iEst] = [$sVal[0], substr($sVal[1], 1), $sVal[2], $sVal[3], $sVal[4]];
                                } else {
                                    $sArrayEstTokenExpr[$iEst] = [$sVal[2], substr($sExprr, 1), $sVal[2], $sVal[3], $sVal[4]];
                                }
                                $sTabelaAutomato .= '' . $iEst . ';';
                                $bCont = false;
                            } else {
                                $sTabelaAutomato .= '' . $sVal[3] . ';';
                                $bCont = false;
                            }
                        }
                    }
                }
                //Tokens compostos por outros tokens
                if (count($sArrayTokenExpr1) > 0) {
                    foreach ($sArrayTokenExpr1 as $key => $sExprr) {
                        $sValorExp1 = str_replace("}{", ",", trim($sExprr));
                        $sValorExp2 = str_replace("{", "", $sValorExp1);
                        $sValorExp = str_replace("}", "", $sValorExp2);
                        $aArrayComp = explode(',', $sValorExp);
                        foreach ($aArrayComp as $sKey1 => $sLexic) {
                            if (trim($sVal[0]) == trim($sLexic) && isset($aArrayComp[$sKey1 + 1])) {
                                $sChave = trim($aArrayComp[$sKey1 + 1]);
                                $sExp2 = $aArrayExprEst[$sChave][1];
                                if ((preg_match("/" .$sExp2. "/", $sChar) == 1)) {
                                    if ($iki == 0) {
                                        $iEst++;
                                        $iki++;
                                    }
                                    $sTabelaAutomato .= '' . $iEst . ';';
                                    $sArrayEstTokenExpr[$iEst] = [$key, $aArrayComp];
                                    $bCont = false;
                                }
                            }
                        }
                    }
                }
                //Coloca -1 em todas as posições que não possuem transição na tabela
                if ($bCont) {
                    $sTabelaAutomato .= '-1;';
                }
            }
            $sTabelaAutomato .= " \n ";
            $iPos++;
        }


        //Criar um armazenamento para as palavras reservadas que serão usadas na análise léxica
//                        if ((trim($aArray1[0]) == trim($aArray1[1]))) {
//                            if ($sExp != $aArray1[1]) {
//                                $iEst++;
//                                $sArrayEstTokenExpr[$iEst] = ["?", $aArray1[1], $aArray1[0]]; //Adiciona o token
//                            }
//                            $sTabelaAutomato .= '' . $iEst . ';';
//                            $bCont = false;
//                            $sExp = $aArray1[1];
//                        }
        //Criar uma regra para tokens compostos por outros
        //Fazer comparação e gerar tabela depois montar o automato de análise


        $arquivo = "data\\defReg.csv";

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "w");

        //Escreve no arquivo aberto.
        fwrite($fp, $sTabelaAutomato);

        //Fecha o arquivo.
        fclose($fp);

        $sJson = '{"texto":"' . $sTabelaAutomato . '"}';

        return json_encode($sJson);
    }

}
