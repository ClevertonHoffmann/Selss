<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerExpRegulares {

    public function analisaExpressoes($sDados) {

        $sCampos = json_decode($sDados);

        $sTexto = $sCampos->{'texto'};
        $sText = trim($sTexto);
        //$array = explode(';', $sTexto);
        
        
        $arquivo = "defReg.txt";

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "w");

        //Escreve no arquivo aberto.
        fwrite($fp, $sText);

        //Fecha o arquivo.
        fclose($fp);
        
        return json_encode($sDados);
    }

    public function analisadorLexico($sExpressao) {

        
        return 'Erro Léxico';
    }
    
    public function tabelas(){
        
        $sAfd = array();
        // 0 - id:
        $sAfd[0] = ["a", 0];
        $sAfd[0] = ["b", 0];
        $sAfd[0] = ["c", 0];
        $sAfd[0] = ["d", 0];
        $sAfd[0] = ["e", 0];
        $sAfd[0] = ["f", 0];
        $sAfd[0] = ["g", 0];
        $sAfd[0] = ["h", 0];
        $sAfd[0] = ["i", 0];
        $sAfd[0] = ["j", 0];
        $sAfd[0] = ["k", 0];
        $sAfd[0] = ["l", 0];
        $sAfd[0] = ["m", 0];
        $sAfd[0] = ["n", 0];
        $sAfd[0] = ["o", 0];
        $sAfd[0] = ["p", 0];
        $sAfd[0] = ["q", 0];
        $sAfd[0] = ["r", 0];
        $sAfd[0] = ["s", 0];
        $sAfd[0] = ["t", 0];
        $sAfd[0] = ["u", 0];
        $sAfd[0] = ["v", 0];
        $sAfd[0] = ["w", 0];
        $sAfd[0] = ["x", 0];
        $sAfd[0] = ["y", 0];
        $sAfd[0] = ["z", 0];
        $sAfd[0] = ["ç", 0];
        $sAfd[0] = ["A", 0];
        $sAfd[0] = ["B", 0];
        $sAfd[0] = ["C", 0];
        $sAfd[0] = ["D", 0];
        $sAfd[0] = ["E", 0];
        $sAfd[0] = ["F", 0];
        $sAfd[0] = ["G", 0];
        $sAfd[0] = ["H", 0];
        $sAfd[0] = ["I", 0];
        $sAfd[0] = ["J", 0];
        $sAfd[0] = ["K", 0];
        $sAfd[0] = ["L", 0];
        $sAfd[0] = ["M", 0];
        $sAfd[0] = ["N", 0];
        $sAfd[0] = ["O", 0];
        $sAfd[0] = ["P", 0];
        $sAfd[0] = ["Q", 0];
        $sAfd[0] = ["R", 0];
        $sAfd[0] = ["S", 0];
        $sAfd[0] = ["T", 0];
        $sAfd[0] = ["U", 0];
        $sAfd[0] = ["V", 0];
        $sAfd[0] = ["W", 0];
        $sAfd[0] = ["X", 0];
        $sAfd[0] = ["Y", 0];
        $sAfd[0] = ["Z", 0];
        $sAfd[0] = ["Ç", 0];
        $sAfd[0] = ["1", 0];
        $sAfd[0] = ["2", 0];
        $sAfd[0] = ["3", 0];
        $sAfd[0] = ["4", 0];
        $sAfd[0] = ["5", 0];
        $sAfd[0] = ["6", 0];
        $sAfd[0] = ["7", 0];
        $sAfd[0] = ["8", 0];
        $sAfd[0] = ["9", 0];
        $sAfd[0] = ["0", 0];
        $sAfd[0] = [" ", 0];
        $sAfd[0] = [":", 1];
        $sAfd[0] = [",", -1];
        $sAfd[0] = [".", -1];
        $sAfd[0] = ["\'", -1];
        $sAfd[0] = ["@", -1];
        $sAfd[0] = ["#", -1];
        $sAfd[0] = ["$", -1];
        $sAfd[0] = ["%", -1];
        $sAfd[0] = ["¨", -1];
        $sAfd[0] = ["&", -1];
        $sAfd[0] = ["*", -1];
        $sAfd[0] = ["(", -1];
        $sAfd[0] = [")", -1];
        $sAfd[0] = ["_", -1];
        $sAfd[0] = ["+", -1];
        $sAfd[0] = ["-", -1];
        $sAfd[0] = ["´", -1];
        $sAfd[0] = ["`", -1];
        $sAfd[0] = ["{", -1];
        $sAfd[0] = ["}", -1];
        $sAfd[0] = ["ª", -1];
        $sAfd[0] = ["º", -1];
        $sAfd[0] = ["~", -1];
        $sAfd[0] = ["^", -1];
        $sAfd[0] = ["<", -1];
        $sAfd[0] = [">", -1];
        $sAfd[0] = [";", -1];
        $sAfd[0] = ["?", -1];
        $sAfd[0] = ["/", -1];
        $sAfd[0] = ["\\", -1];
        $sAfd[0] = ["\t", -1];
        $sAfd[0] = ["\n", -1];
        $sAfd[0] = ["\r", -1];
        $sAfd[0] = ["]", -1];
        $sAfd[0] = ["[", -1];
       
        //1 - [
        $sAfd[1] = ["a", -1];
        $sAfd[1] = ["b", -1];
        $sAfd[1] = ["c", -1];
        $sAfd[1] = ["d", -1];
        $sAfd[1] = ["e", -1];
        $sAfd[1] = ["f", -1];
        $sAfd[1] = ["g", -1];
        $sAfd[1] = ["h", -1];
        $sAfd[1] = ["i", -1];
        $sAfd[1] = ["j", -1];
        $sAfd[1] = ["k", -1];
        $sAfd[1] = ["l", -1];
        $sAfd[1] = ["m", -1];
        $sAfd[1] = ["n", -1];
        $sAfd[1] = ["o", -1];
        $sAfd[1] = ["p", -1];
        $sAfd[1] = ["q", -1];
        $sAfd[1] = ["r", -1];
        $sAfd[1] = ["s", -1];
        $sAfd[1] = ["t", -1];
        $sAfd[1] = ["u", -1];
        $sAfd[1] = ["v", -1];
        $sAfd[1] = ["w", -1];
        $sAfd[1] = ["x", -1];
        $sAfd[1] = ["y", -1];
        $sAfd[1] = ["z", -1];
        $sAfd[1] = ["ç", -1];
        $sAfd[1] = ["A", -1];
        $sAfd[1] = ["B", -1];
        $sAfd[1] = ["C", -1];
        $sAfd[1] = ["D", -1];
        $sAfd[1] = ["E", -1];
        $sAfd[1] = ["F", -1];
        $sAfd[1] = ["G", -1];
        $sAfd[1] = ["H", -1];
        $sAfd[1] = ["I", -1];
        $sAfd[1] = ["J", -1];
        $sAfd[1] = ["K", -1];
        $sAfd[1] = ["L", -1];
        $sAfd[1] = ["M", -1];
        $sAfd[1] = ["N", -1];
        $sAfd[1] = ["O", -1];
        $sAfd[1] = ["P", -1];
        $sAfd[1] = ["Q", -1];
        $sAfd[1] = ["R", -1];
        $sAfd[1] = ["S", -1];
        $sAfd[1] = ["T", -1];
        $sAfd[1] = ["U", -1];
        $sAfd[1] = ["V", -1];
        $sAfd[1] = ["W", -1];
        $sAfd[1] = ["X", -1];
        $sAfd[1] = ["Y", -1];
        $sAfd[1] = ["Z", -1];
        $sAfd[1] = ["Ç", -1];
        $sAfd[1] = ["1", -1];
        $sAfd[1] = ["2", -1];
        $sAfd[1] = ["3", -1];
        $sAfd[1] = ["4", -1];
        $sAfd[1] = ["5", -1];
        $sAfd[1] = ["6", -1];
        $sAfd[1] = ["7", -1];
        $sAfd[1] = ["8", -1];
        $sAfd[1] = ["9", -1];
        $sAfd[1] = ["0", -1];
        $sAfd[1] = [" ", -1];
        $sAfd[1] = [":", -1];
        $sAfd[1] = [",", -1];
        $sAfd[1] = [".", -1];
        $sAfd[1] = ["\'", -1];
        $sAfd[1] = ["@", -1];
        $sAfd[1] = ["#", -1];
        $sAfd[1] = ["$", -1];
        $sAfd[1] = ["%", -1];
        $sAfd[1] = ["¨", -1];
        $sAfd[1] = ["&", -1];
        $sAfd[1] = ["*", -1];
        $sAfd[1] = ["(", -1];
        $sAfd[1] = [")", -1];
        $sAfd[1] = ["_", -1];
        $sAfd[1] = ["+", -1];
        $sAfd[1] = ["-", -1];
        $sAfd[1] = ["´", -1];
        $sAfd[1] = ["`", -1];
        $sAfd[1] = ["{", -1];
        $sAfd[1] = ["}", -1];
        $sAfd[1] = ["ª", -1];
        $sAfd[1] = ["º", -1];
        $sAfd[1] = ["~", -1];
        $sAfd[1] = ["^", -1];
        $sAfd[1] = ["<", -1];
        $sAfd[1] = [">", -1];
        $sAfd[1] = [";", -1];
        $sAfd[1] = ["?", -1];
        $sAfd[1] = ["/", -1];
        $sAfd[1] = ["\\", -1];
        $sAfd[1] = ["\t", -1];
        $sAfd[1] = ["\n", -1];
        $sAfd[1] = ["\r", -1];
        $sAfd[1] = ["]", -1];
        $sAfd[1] = ["[", -1];
        $sAfd[1] = ["[", 2];   
        
        $sAfd[1] = ["a", -1];
        $sAfd[1] = ["b", -1];
        $sAfd[1] = ["c", -1];
        $sAfd[1] = ["d", -1];
        $sAfd[1] = ["e", -1];
        $sAfd[1] = ["f", -1];
        $sAfd[1] = ["g", -1];
        $sAfd[1] = ["h", -1];
        $sAfd[1] = ["i", -1];
        $sAfd[1] = ["j", -1];
        $sAfd[1] = ["k", -1];
        $sAfd[1] = ["l", -1];
        $sAfd[1] = ["m", -1];
        $sAfd[1] = ["n", -1];
        $sAfd[1] = ["o", -1];
        $sAfd[1] = ["p", -1];
        $sAfd[1] = ["q", -1];
        $sAfd[1] = ["r", -1];
        $sAfd[1] = ["s", -1];
        $sAfd[1] = ["t", -1];
        $sAfd[1] = ["u", -1];
        $sAfd[1] = ["v", -1];
        $sAfd[1] = ["w", -1];
        $sAfd[1] = ["x", -1];
        $sAfd[1] = ["y", -1];
        $sAfd[1] = ["z", -1];
        $sAfd[1] = ["ç", -1];
        $sAfd[1] = ["A", 0];
        $sAfd[1] = ["B", 0];
        $sAfd[1] = ["C", 0];
        $sAfd[1] = ["D", 0];
        $sAfd[1] = ["E", 0];
        $sAfd[1] = ["F", 0];
        $sAfd[1] = ["G", 0];
        $sAfd[1] = ["H", 0];
        $sAfd[1] = ["I", 0];
        $sAfd[1] = ["J", 0];
        $sAfd[1] = ["K", 0];
        $sAfd[1] = ["L", 0];
        $sAfd[1] = ["M", 0];
        $sAfd[1] = ["N", 0];
        $sAfd[1] = ["O", 0];
        $sAfd[1] = ["P", 0];
        $sAfd[1] = ["Q", 0];
        $sAfd[1] = ["R", 0];
        $sAfd[1] = ["S", 0];
        $sAfd[1] = ["T", 0];
        $sAfd[1] = ["U", 0];
        $sAfd[1] = ["V", 0];
        $sAfd[1] = ["W", 0];
        $sAfd[1] = ["X", 0];
        $sAfd[1] = ["Y", 0];
        $sAfd[1] = ["Z", 0];
        $sAfd[1] = ["Ç", 0];
        $sAfd[1] = ["1", 0];
        $sAfd[1] = ["2", 0];
        $sAfd[1] = ["3", 0];
        $sAfd[1] = ["4", 0];
        $sAfd[1] = ["5", 0];
        $sAfd[1] = ["6", 0];
        $sAfd[1] = ["7", 0];
        $sAfd[1] = ["8", 0];
        $sAfd[1] = ["9", 0];
        $sAfd[1] = ["0", 0];
        $sAfd[1] = [" ", 0];
        $sAfd[1] = [":", -1];
        $sAfd[1] = [",", -1];
        $sAfd[1] = [".", -1];
        $sAfd[1] = ["\'", -1];
        $sAfd[1] = ["@", -1];
        $sAfd[1] = ["#", -1];
        $sAfd[1] = ["$", -1];
        $sAfd[1] = ["%", -1];
        $sAfd[1] = ["¨", -1];
        $sAfd[1] = ["&", -1];
        $sAfd[1] = ["*", -1];
        $sAfd[1] = ["(", -1];
        $sAfd[1] = [")", -1];
        $sAfd[1] = ["_", -1];
        $sAfd[1] = ["+", -1];
        $sAfd[1] = ["-", -1];
        $sAfd[1] = ["´", -1];
        $sAfd[1] = ["`", -1];
        $sAfd[1] = ["{", -1];
        $sAfd[1] = ["}", -1];
        $sAfd[1] = ["ª", -1];
        $sAfd[1] = ["º", -1];
        $sAfd[1] = ["~", -1];
        $sAfd[1] = ["^", -1];
        $sAfd[1] = ["<", -1];
        $sAfd[1] = [">", -1];
        $sAfd[1] = [";", -1];
        $sAfd[1] = ["?", -1];
        $sAfd[1] = ["/", -1];
        $sAfd[1] = ["\\", -1];
        $sAfd[1] = ["\t", -1];
        $sAfd[2] = ["\n", -1];
        $sAfd[2] = ["\r", -1];
        $sAfd[2] = ["]", -1];
        $sAfd[2] = ["[", -1];
        $sAfd[2] = ["[", 3];  
        
        $sAfd[3] = ["a", 3];
        $sAfd[3] = ["b", 3];
        $sAfd[3] = ["c", 3];
        $sAfd[3] = ["d", 3];
        $sAfd[3] = ["e", 3];
        $sAfd[3] = ["f", 3];
        $sAfd[3] = ["g", 3];
        $sAfd[3] = ["h", 3];
        $sAfd[3] = ["i", 3];
        $sAfd[3] = ["j", 3];
        $sAfd[3] = ["k", 3];
        $sAfd[3] = ["l", 3];
        $sAfd[3] = ["m", 3];
        $sAfd[3] = ["n", 3];
        $sAfd[3] = ["o", 3];
        $sAfd[3] = ["p", 3];
        $sAfd[3] = ["q", 3];
        $sAfd[3] = ["r", 3];
        $sAfd[3] = ["s", 3];
        $sAfd[3] = ["t", 3];
        $sAfd[3] = ["u", 3];
        $sAfd[3] = ["v", 3];
        $sAfd[3] = ["w", 3];
        $sAfd[3] = ["x", 3];
        $sAfd[3] = ["y", 3];
        $sAfd[3] = ["z", 3];
        $sAfd[3] = ["ç", 3];
        $sAfd[3] = ["A", 3];
        $sAfd[3] = ["B", 3];
        $sAfd[3] = ["C", 3];
        $sAfd[3] = ["D", 3];
        $sAfd[3] = ["E", 3];
        $sAfd[3] = ["F", 3];
        $sAfd[3] = ["G", 3];
        $sAfd[3] = ["H", 3];
        $sAfd[3] = ["I", 3];
        $sAfd[3] = ["J", 3];
        $sAfd[3] = ["K", 3];
        $sAfd[3] = ["L", 3];
        $sAfd[3] = ["M", 3];
        $sAfd[3] = ["N", 3];
        $sAfd[3] = ["O", 3];
        $sAfd[3] = ["P", 3];
        $sAfd[3] = ["Q", 3];
        $sAfd[3] = ["R", 3];
        $sAfd[3] = ["S", 3];
        $sAfd[3] = ["T", 3];
        $sAfd[3] = ["U", 3];
        $sAfd[3] = ["V", 3];
        $sAfd[3] = ["W", 3];
        $sAfd[3] = ["X", 3];
        $sAfd[3] = ["Y", 3];
        $sAfd[3] = ["Z", 3];
        $sAfd[3] = ["Ç", 3];
        $sAfd[3] = ["1", 3];
        $sAfd[3] = ["2", 3];
        $sAfd[3] = ["3", 3];
        $sAfd[3] = ["4", 3];
        $sAfd[3] = ["5", 3];
        $sAfd[3] = ["6", 3];
        $sAfd[3] = ["7", 3];
        $sAfd[3] = ["8", 3];
        $sAfd[3] = ["9", 3];
        $sAfd[3] = ["0", 3];
        $sAfd[3] = [" ", 3];
        $sAfd[3] = [":", 3];
        $sAfd[3] = [",", 3];
        $sAfd[3] = [".", 3];
        $sAfd[3] = ["\'", 3];
        $sAfd[3] = ["@", 3];
        $sAfd[3] = ["#", 3];
        $sAfd[3] = ["$", 3];
        $sAfd[3] = ["%", 3];
        $sAfd[3] = ["¨", 3];
        $sAfd[3] = ["&", 3];
        $sAfd[3] = ["*", 3];
        $sAfd[3] = ["(", 3];
        $sAfd[3] = [")", 3];
        $sAfd[3] = ["_", 3];
        $sAfd[3] = ["+", 3];
        $sAfd[3] = ["-", 3];
        $sAfd[3] = ["´", 3];
        $sAfd[3] = ["`", 3];
        $sAfd[3] = ["{", 3];
        $sAfd[3] = ["}", 3];
        $sAfd[3] = ["ª", 3];
        $sAfd[3] = ["º", 3];
        $sAfd[3] = ["~", 3];
        $sAfd[3] = ["^", 3];
        $sAfd[3] = ["<", 3];
        $sAfd[3] = [">", 3];
        $sAfd[3] = [";", 3];
        $sAfd[3] = ["?", 3];
        $sAfd[3] = ["/", 3];
        $sAfd[3] = ["\\", 3];
        $sAfd[3] = ["\t", 3];
        $sAfd[3] = ["\n", 3];
        $sAfd[3] = ["\r", 3];
        $sAfd[3] = ["]", 4];

        $sAfd[4] = [';', 4];
        
        $sAux = array();
        
    }
    
    public function constroiTabelaTokens(){
        
        
        $aTabelaTokens = array();
        $aTabelaTokens[0] = '?';
        $aTabelaTokens[1] = 'dp';
        $aTabelaTokens[2] = '[';
        $aTabelaTokens[3] = '?';
        $aTabelaTokens[4] = '?';
        $aTabelaTokens[5] = '?';
        $aTabelaTokens[6] = '?';
        $aTabelaTokens[7] = '?';
        $aTabelaTokens[8] = '?';
        $aTabelaTokens[9] = '?';
        $aTabelaTokens[10] = '?';
        $aTabelaTokens[11] = '?';
        $aTabelaTokens[12] = '?';
        $aTabelaTokens[13] = '?';
        $aTabelaTokens[14] = '?';
        
        
//        ts.put(0, "?");
//        ts.put(1, "espaco");
//        ts.put(2, "not");
//        ts.put(3, "?");
//        ts.put(4, "ap");
//        ts.put(5, "fp");
//        ts.put(6, "mult");
//        ts.put(7, "soma");
//        ts.put(8, "v");
//        ts.put(9, "subt");
//        ts.put(10, "div");
//        ts.put(11, "const");
//        ts.put(12, "dp");
//        ts.put(13, "pv");
//        ts.put(14, "menor");
//        ts.put(15, "at");
//        ts.put(16, "maior");
//        ts.put(17, "id");
//        ts.put(18, "ac");
//        ts.put(19, "?");
//        ts.put(20, "fc");
//        ts.put(21, "e");
//        ts.put(22, "inc");
//        ts.put(23, "dec");
//        ts.put(24, "?");
//        ts.put(25, "const");
//        ts.put(26, "menorig");
//        ts.put(27, "dif");
//        ts.put(28, "igual");
//        ts.put(29, "maiorig");
//        ts.put(30, "ou");
//        ts.put(31, "real");
//        ts.put(32, "const");
        
    }
    
    public function palavrasReservadas(){
        
        $aPalavrasReservadas = array();
        $aPalavrasReservadas['if'] = 'if';
//        pReservada.put("if", "if");
//        pReservada.put("then", "then");
//        pReservada.put("else", "else");
//        pReservada.put("while", "while");
//        pReservada.put("begin", "begin");
//        pReservada.put("end", "end");
//        pReservada.put("for", "for");
//        pReservada.put("int", "int");
//        pReservada.put("str", "str");
//        pReservada.put("double", "double");
//        pReservada.put("boolean", "boolean");
//        pReservada.put("float", "float");
    }

}
