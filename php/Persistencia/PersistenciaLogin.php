<?php

class PersistenciaLogin extends Persistencia {

    public function verificaEmailPass($sEmail, $sPass) {

    //    $pdo = Conexao::getInstance();

        if (count($aUsers) != 0) {
            foreach ($aUsers as $aValue) {
                
                
                password_verify($senha, $hash);
            }
        } else {
            return false;
        }
    }

    // Função para gerar um nome aleatório
    function gerarNomeAleatorio($length = 8) {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nome = '';

        for ($i = 0; $i < $length; $i++) {
            $nome .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $nome;
    }

//    
//    
//    $pdo = Conexao::getInstance();
//        $sSql = "insert into clientes (nome, sexo, cpf, rg, ativo, telefone, email, datanascimento, usuario) 
//                 values ('" . $sNom . "', '" . $sSex . "', '" . $iCPF . "', '" . $iRG . "', '" . $bAtivo . "', '" . $sTel . "', '" . $sEma . "', '" . $sDat . "', '" . $sUser . "')";
//
//        $bResultado = $pdo->query($sSql);
//        
//        $pdo2 = Conexao::getInstance();
//        $sql2 = "select max(id) as id from clientes";
//        $aResultado2 = $pdo2->query($sql2);
//        $Id = $aResultado2->fetch(PDO::FETCH_ASSOC);
//        
//        $pdo1 = Conexao::getInstance();
//        $sSql1 = "insert into enderecos (cliente_id, endereco, numero, cep, bairro, complemento) 
//                 values ('".$Id['id']."','" . $sEnd . "', '" . $sNum . "', '" . $sCep . "', '" . $sBair . "', '" . $sComp . "')";
//
//        $bResultado1 = $pdo1->query($sSql1);
        
        
        
//    
//    
//    // Função para verificar se um nome já existe no arquivo CSV
//    function nomeExisteNoCSV($nome, $caminhoCSV) {
//        $linhas = array_map('str_getcsv', file($caminhoCSV));
//        $nomesExistem = array_column($linhas, 0);
//        return in_array($nome, $nomesExistem);
//    }
//
//    // Função para adicionar um nome ao arquivo CSV
//    function adicionarNomeAoCSV($nome, $caminhoCSV) {
//        $handle = fopen($caminhoCSV, 'a');
//        fputcsv($handle, [$nome]);
//        fclose($handle);
//    }
//    
////    $quantidadeConvidados = 10000;
////                $caminhoCSV = 'convidados.csv';
////
////                for ($i = 0; $i < $quantidadeConvidados; $i++) {
////                    $nomeConvidado = gerarNomeAleatorio();
////
////                    // Verificar se o nome já existe no arquivo CSV
////                    while (nomeExisteNoCSV($nomeConvidado, $caminhoCSV)) {
////                        $nomeConvidado = gerarNomeAleatorio();
////                    }
////
////                    // Adicionar o nome ao arquivo CSV
////                    adicionarNomeAoCSV($nomeConvidado, $caminhoCSV);
////
////                    echo "Convidado: $nomeConvidado\n";
////                }

}
