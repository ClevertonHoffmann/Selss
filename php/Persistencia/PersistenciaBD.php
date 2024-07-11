<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Persistencia responsável por gravar no banco de dados
 * @author Cleverton
 */
class PersistenciaBD {

    private $pdo;
    private $tabelaUsuario;
    private $tabelaDadosUsuario;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
        // Definindo as tabelas com base no modo
        // Verifica a existência das tabelas antes de definir
        if (isset($_SESSION['modo']) && $_SESSION['modo'] == 'convidado') {
            if ($this->tabelaExiste('tbusuariosconvidado') && $this->tabelaExiste('tbdadosusuariosconvidado')) {
                $this->tabelaUsuario = 'tbusuariosconvidado';
                $this->tabelaDadosUsuario = 'tbdadosusuariosconvidado';
            } else {
                $this->errorlog('PB Tabelas de usuário convidado não existem.');
            }
        } else {
            if ($this->tabelaExiste('tbusuarios') && $this->tabelaExiste('tbdadosusuarios')) {
                $this->tabelaUsuario = 'tbusuarios';
                $this->tabelaDadosUsuario = 'tbdadosusuarios';
            } else {
                $this->errorlog('PB Tabelas de usuário não existem.');
            }
        }
    }

    /**
     * Grava um array no banco de dados.
     * @param string $sArquivo O nome do campo da tabela onde os dados serão gravados.
     * @param int $iTipo 0 para sistema, 1 para usuário.
     * @param array $dadosArray O array de dados a ser gravado.
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro.
     */
    public function gravaArray($sArquivo, $iTipo, $dadosArray) {
        if (!$this->verificarSessao()) {
            return false;
        }
        $this->errorlog('PB Chegou no método: gravaArray $sArquivo:'.$sArquivo.' tipo='.$iTipo);        
        try {
            if ($iTipo == 0) {
                // Gravação na tabela do sistema
                $stmt = $this->pdo->prepare("UPDATE tbdatasistema SET $sArquivo = :dados WHERE seq = 1");
            } else {
                // Gravação na tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT seq FROM " . $this->tabelaUsuario . " WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    $seq = $usuario['seq'];
                    $stmt = $this->pdo->prepare("UPDATE " . $this->tabelaDadosUsuario . " SET $sArquivo = :dados WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                } else {
                    $this->errorlog('PB Finalizou o método: gravaArray($sArquivo, $iTipo, $dadosArray) ERROR RETORNO= FALSE NÃO ACHOU USUÁRIO');
                    return false;
                }
            }

            // Convertendo cada linha do array em uma string CSV
            $csvLinhas = [];
            foreach ($dadosArray as $linha) {
                $csvLinhas[] = implode(';', array_map(function ($value) {
                            return str_replace(['\\', ';'], ['\\\\', '\\;'], $value);
                }, $linha));
            }

            // Concatenando todas as linhas CSV em uma única string separada por quebras de linha
            $dados = implode("\n", $csvLinhas);

            $stmt->bindParam(':dados', $dados, PDO::PARAM_STR);
            $stmt->execute();
            $this->errorlog('PB Finalizou o método: gravaArray($sArquivo, $iTipo, $dadosArray) RETORNO= TRUE');
            return true;
        } catch (PDOException $e) {
            $this->errorlog('PB Finalizou o método: gravaArray($sArquivo, $iTipo, $dadosArray) ERROR RETORNO='. $e->getMessage());
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retorna o array do banco de dados.
     * @param string $sArquivo O nome do campo da tabela onde os dados serão lidos.
     * @param int $iTipo 0 para sistema, 1 para usuário.
     * @return array Retorna o array de dados.
     */
    public function retornaArray($sArquivo, $iTipo) {
        if (!$this->verificarSessao()) {
            return false;
        }
        $this->errorlog('PB Chegou no método: retornaArray $sArquivo:'.$sArquivo.' tipo='.$iTipo);  
        $aDados = array();

        try {
            if ($iTipo == 0) {
                // Leitura da tabela do sistema
                $stmt = $this->pdo->prepare("SELECT $sArquivo FROM tbdatasistema WHERE seq = 1");
            } else {
                // Leitura da tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT du.$sArquivo FROM " . $this->tabelaDadosUsuario . " du INNER JOIN " . $this->tabelaUsuario . " u ON du.seq = u.seq WHERE u.email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            }
            $this->errorlog('PB Chegou no método: retornaArray($sArquivo, $iTipo) execute linha 108 ');
            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dados && isset($dados[$sArquivo])) {
                $this->errorlog('PB Chegou no método: retornaArray($sArquivo, $iTipo) entrou no if ($dados && isset($dados[$sArquivo])) { linha 112');
                // A string CSV armazenada no banco de dados
                $csvString = $dados[$sArquivo];

                // Quebrar a string CSV em linhas
                $lines = explode("\n", $csvString);
                foreach ($lines as $line) {
                    if (!empty(trim($line))) {
                        $this->errorlog('PB Chegou no método: retornaArray($sArquivo, $iTipo) entrou no if (!empty(trim($line))) { { linha 120');
                        // Converter cada linha CSV em um array, ignorando \;
                        $aDados[] = array_map(function ($value) {
                            return str_replace(['\\;', '\\\\'], [';', '\\'], $value);
                        }, preg_split('/(?<!\\\);/', $line));
                    }
                }
                $this->errorlog('PB Chegou no método: retornaArray($sArquivo, $iTipo) finalizou no if linha 127');
            }
        } catch (PDOException $e) {
            $this->errorlog('PB Finalizou o método: retornaArray($sArquivo, $iTipo) linha 130 ERROR RETORNO='. $e->getMessage());
            // echo "Failed: " . $e->getMessage();
        }
        $this->errorlog('PB Finalizou o método: retornaArray($sArquivo, $iTipo) linha 133');
        return $aDados;
    }

    /**
     * Método responsável por gravar todos os elementos do array composto array[][] = [valor1, valor2]
     */
    public function gravaArrayComposto($sArquivo, $iTipo, $dadosArray) {
        if (!$this->verificarSessao()) {
            return false;
        }
        $this->errorlog('PB Chegou no método: gravaArrayComposto $sArquivo:'.$sArquivo.' tipo='.$iTipo); 
        try {
            $stmt = '';
            if ($iTipo == 0) {
                // Gravação na tabela do sistema
                $stmt = $this->pdo->prepare("UPDATE tbdatasistema SET $sArquivo = :dados WHERE seq = 1");
            } else {
                // Gravação na tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT seq FROM " . $this->tabelaUsuario . " WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->errorlog('PB Chegou no método: gravaArrayComposto($sArquivo, $iTipo, $dadosArray) RETORNOU USUÁRIO LINHA 154 ');
                if ($usuario) {
                    $seq = $usuario['seq'];
                    $stmt = $this->pdo->prepare("UPDATE " . $this->tabelaDadosUsuario . " SET $sArquivo = :dados WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                } else {
                    $this->errorlog('PB Chegou no método: gravaArrayComposto($sArquivo, $iTipo, $dadosArray) ERRO RETORNO NÃO TEM USUÁRIO LINHA 160');
                    return false;
                }
            }

            // Converte o array composto em uma string CSV com caracteres especiais escapados
            $csvString = '';
            foreach ($dadosArray as $linha) {
                $linhaParaGravar = array();

                // Encontra o valor máximo das chaves
                $maxChave = max(array_keys($linha));

                // Preenche as lacunas com arrays vazios
                for ($i = 1; $i <= $maxChave; $i++) {
                    if (!isset($linha[$i])) {
                        $linha[$i] = [-1, -1]; // Adiciona um array com posições -1, -1
                    }
                }

                // Ordena o array pela chave
                ksort($linha);

                // Converte cada elemento do array em uma string CSV
                foreach ($linha as $item) {
                    if (is_array($item)) {
                        foreach ($item as $subitem) {
                            // Escapa os caracteres especiais
                            $subitem = str_replace(['\\', ';'], ['\\\\', '\\;'], $subitem);
                            $linhaParaGravar[] = $subitem;
                        }
                    } else {
                        $linhaParaGravar[] = '';
                    }
                }

                // Converte a linha em uma string CSV
                $csvString .= implode(';', $linhaParaGravar) . "\n";
            }
            $this->errorlog('PB Chegou no método: gravaArrayComposto($sArquivo, $iTipo, $dadosArray) LINHA 198');
            // Grava a string CSV no banco de dados
            $stmt->bindParam(':dados', $csvString, PDO::PARAM_STR);
            $stmt->execute();
            $this->errorlog('PB Chegou no método: gravaArrayComposto($sArquivo, $iTipo, $dadosArray) LINHA 202 RETORNO TRUE');
            return true;
        } catch (PDOException $e) {
            $this->errorlog('PB Finalizou o método: gravaArrayComposto($sArquivo, $iTipo, $dadosArray) linha 206 ERROR RETORNO='. $e->getMessage());
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retorna o array composto do banco de dados
     * @param type $sArquivo
     * @param type $iTipo 0 sistema 1 usuario
     * @return type
     */
    public function retornaArrayComposto($sArquivo, $iTipo) {
        if (!$this->verificarSessao()) {
            return false;
        }
        $this->errorlog('PB Chegou no método: gravaArrayComposto $sArquivo:'.$sArquivo.' tipo='.$iTipo); 
        try {
            $stmt = '';
            if ($iTipo == 0) {
                // Seleção na tabela do sistema
                $stmt = $this->pdo->prepare("SELECT $sArquivo FROM tbdatasistema WHERE seq = 1");
            } else {
                // Seleção na tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT seq FROM " . $this->tabelaUsuario . " WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->errorlog('PB Chegou no método: retornaArrayComposto($sArquivo, $iTipo) RETORNOU USUÁRIO LINHA 232 ');
                if ($usuario) {
                    $seq = $usuario['seq'];
                    $stmt = $this->pdo->prepare("SELECT $sArquivo FROM " . $this->tabelaDadosUsuario . " WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                } else {
                    $this->errorlog('PB Chegou no método: retornaArrayComposto($sArquivo, $iTipo) linha 238 ERRO RETORNO NÃO TEM USUÁRIO LINHA 238');
                    return false;
                }
            }
            $this->errorlog('PB Chegou no método: retornaArrayComposto($sArquivo, $iTipo) LINHA 198');
            // Executa a consulta
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->errorlog('PB Chegou no método: retornaArrayComposto($sArquivo, $iTipo) LINHA 246');
            if (!$resultado || !isset($resultado[$sArquivo])) {
                return array();
            }

            // Converte a string CSV de volta para o array composto
            $csvString = $resultado[$sArquivo];
            $linhas = explode("\n", trim($csvString));
            $dadosArray = array();

            foreach ($linhas as $linha) {
                if (!empty($linha)) {
                    $itens = preg_split('/(?<!\\\\);/', $linha);
                    $linhaArray = array();
                    for ($i = 0; $i < count($itens); $i += 2) {
                        if ($itens[$i] != -1) {
                            // Desscapa os caracteres especiais
                            $item1 = str_replace(['\\;', '\\\\'], [';', '\\'], $itens[$i]);
                            $item2 = str_replace(['\\;', '\\\\'], [';', '\\'], $itens[$i + 1]);
                            $linhaArray[($i / 2) + 1] = [$item1, $item2];
                        }
                    }
                    $dadosArray[] = $linhaArray;
                }
            }
            $this->errorlog('PB Finalizou o método: retornaArrayComposto($sArquivo, $iTipo) LINHA 271');
            return $dadosArray;
        } catch (PDOException $e) {
            $this->errorlog('PB Finalizou o método: retornaArrayComposto($sArquivo, $iTipo) linha 274 ERROR RETORNO='. $e->getMessage());
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Função para escrever as entradas do usuário para ficar salvo para o próximo logon
     * @param type $sCampo
     * @param type $sText
     */
    public function gravaArquivo($sCampo, $sText, $sExt) {
        if (!$this->verificarSessao()) {
            return false;
        }
        try {
            $this->errorlog('PB Chegou no método: gravaArquivo $sCampo:'.$sCampo.' extensao='.$sExt); 
            // Obter o email do usuário da sessão
            $email = $_SESSION['email'];

            // Consultar o seq do usuário
            $stmt = $this->pdo->prepare("SELECT seq FROM " . $this->tabelaUsuario . " WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $this->errorlog('PB Chegou no método: gravaArquivo($sCampo, $sText, $sExt) LINHA 295:');
            // Verificar se o usuário foi encontrado
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->errorlog('PB Chegou no método: gravaArquivo($sCampo, $sText, $sExt) LINHA 298');
            
            if ($usuario) {
                $seq = $usuario['seq'];

                // Verificar se já existe um registro para este usuário na tabela tbdadosusuarios
                $stmt = $this->pdo->prepare("SELECT * FROM " . $this->tabelaDadosUsuario . " WHERE seq = :seq");
                $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                $stmt->execute();
                $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->errorlog('PB Chegou no método: gravaArquivo($sCampo, $sText, $sExt) LINHA 308');
                if ($dadosUsuario) {
                    // Atualizar o registro existente
                    $sql = "UPDATE " . $this->tabelaDadosUsuario . " SET $sCampo = :texto WHERE seq = :seq";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                    $stmt->bindParam(':texto', $sText, PDO::PARAM_STR);
                    $stmt->execute();
                    $this->errorlog('PB Finalizou update no método: gravaArquivo($sCampo, $sText, $sExt) LINHA 316');
                } else {
                    // Inserir um novo registro
                    $sql = "INSERT INTO " . $this->tabelaDadosUsuario . " (seq, $sCampo) VALUES (:seq, :texto)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                    $stmt->bindParam(':texto', $sText, PDO::PARAM_STR);
                    $stmt->execute();
                    $this->errorlog('PB Finalizou update no método:: gravaArquivo($sCampo, $sText, $sExt) LINHA 324');
                }
                $this->errorlog('PB Finalizou o método: gravaArquivo($sCampo, $sText, $sExt) RETORNO TRUE');
                return true;
            } else {
                // echo "Usuário não encontrado.";
                $this->errorlog('PB Finalizou o método: gravaArquivo($sCampo, $sText, $sExt) linha 330 RETORNO ERROR FALSE USUÁRIO NÃO ENCONTRADO');
                return false;
            }
        } catch (PDOException $e) {
            $this->errorlog('PB Finalizou o método: gravaArquivo($sCampo, $sText, $sExt) linha 334 ERROR RETORNO='. $e->getMessage());
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Função que realiza a leitura para retornar caso já exista os arquivos pré-carregados no sistema
     * @param type $sCampo
     * @param type $sExt //Usado apenas no CSV
     * @param type $iTipo 0 sistema 1 usuario
     * @return string
     */
    public function retornaTextoDoCampo($sCampo, $sExt, $iTipo) {
        if (!$this->verificarSessao()) {
            return false;
        }
        try {
            $this->errorlog('PB Chegou no método: gravaArquivo $sCampo:'.$sCampo.' extensao='.$sExt.' tipo='.$iTipo);
            if ($iTipo == 0) {
                // Seleção na tabela do sistema
                $stmt = $this->pdo->prepare("SELECT $sCampo FROM tbdatasistema WHERE seq = 1");
                $stmt->execute();
                $dados = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($dados && isset($dados[$sCampo])) {
                    $this->errorlog('PB Finalizou o método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) LINHA 357 RETORNO TRUE');
                    return $dados[$sCampo];
                } else {
                    // echo "Campo ou registro não encontrado.";
                    $this->errorlog('PB Finalizou o método:retornaTextoDoCampo($sCampo, $sExt, $iTipo) RETORNO LINHA 361 ERROR FALSE CAMPO NÃO ENCONTRADO');
                    return false;
                }
            } else {
                // Obter o email do usuário da sessão
                $email = $_SESSION['email'];
                $this->errorlog('PB Chegou no método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) LINHA 367 TIPO:'.$iTipo);
                // Consultar o seq do usuário
                $stmt = $this->pdo->prepare("SELECT seq FROM " . $this->tabelaUsuario . " WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $this->errorlog('PB Chegou no método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) LINHA 372');
                // Verificar se o usuário foi encontrado
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    $seq = $usuario['seq'];
                    $this->errorlog('PB Chegou no método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) LINHA 377 seq:'.$seq);
                    // Consultar o valor do campo especificado na tabela tbdadosusuarios
                    $stmt = $this->pdo->prepare("SELECT $sCampo FROM " . $this->tabelaDadosUsuario . " WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                    $stmt->execute();
                    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->errorlog('PB Chegou no método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) LINHA 384 $dadosUsuario:');
                    if ($dadosUsuario && isset($dadosUsuario[$sCampo])) {
                        $this->errorlog('PB Finalizou o método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) LINHA 385 RETORNO TRUE ');
                        return $dadosUsuario[$sCampo];
                    } else {
                        $this->errorlog('PB Finalizou o método:retornaTextoDoCampo($sCampo, $sExt, $iTipo) RETORNO LINHA 388 ERROR FALSE CAMPO NÃO ENCONTRADO');
                        // echo "Campo ou registro não encontrado.";
                        return false;
                    }
                } else {
                    $this->errorlog('PB Finalizou o método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) linha 393 RETORNO LINHA 393 ERROR FALSE USUÁRIO NÃO ENCONTRADO');
                    // echo "Usuário não encontrado.";
                    return false;
                }
            }
        } catch (PDOException $e) {
            $this->errorlog('PB Finalizou o método: retornaTextoDoCampo($sCampo, $sExt, $iTipo) linha 399 ERROR RETORNO='. $e->getMessage());
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }
    
    public function errorlog($message) {
        // Abre o arquivo no modo de adição ('a')
        $fp = fopen('data/errorLog.txt', "a");

        // Adiciona uma nova linha ao arquivo com a data e hora atuais
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = $timestamp . ' - ' . $message . PHP_EOL;

        // Escreve no arquivo aberto
        fwrite($fp, $logEntry);

        // Fecha o arquivo
        fclose($fp);
    }
    
    // O método para verificar se uma tabela existe
    public function tabelaExiste($tabela) {
        try {
            $result = $this->pdo->query("SELECT 1 FROM $tabela LIMIT 1");
        } catch (PDOException $e) {
            $this->errorlog("PB Tabela $tabela não existe. Erro: " . $e->getMessage());
            return false;
        }
        return $result !== false;
    }

    // O método para verificar a sessão
    private function verificarSessao() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['email'])) {
            $this->errorlog("Variável de sessão 'email' não está definida.");
            return false;
        }

        return true;
    }
}
