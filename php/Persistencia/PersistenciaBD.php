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

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    /**
     * Grava um array no banco de dados.
     * @param string $sArquivo O nome do campo da tabela onde os dados serão gravados.
     * @param int $iTipo 0 para sistema, 1 para usuário.
     * @param array $dadosArray O array de dados a ser gravado.
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro.
     */
    public function gravaArray($sArquivo, $iTipo, $dadosArray) {
        try {
            if ($iTipo == 0) {
                // Gravação na tabela do sistema
                $stmt = $this->pdo->prepare("UPDATE tbdatasistema SET $sArquivo = :dados WHERE seq = 1");
            } else {
                // Gravação na tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT seq FROM tbusuarios WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    $seq = $usuario['seq'];
                    $stmt = $this->pdo->prepare("UPDATE tbdadosusuarios SET $sArquivo = :dados WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                } else {
                    return false;
                }
            }

            // Convertendo cada linha do array em uma string CSV
            $csvLinhas = [];
            foreach ($dadosArray as $linha) {
                $csvLinhas[] = implode(';', array_map(function ($value) {
                            return str_replace(';', '\;', str_replace('\n', '\\n', $value));
                        }, $linha));
            }

            // Concatenando todas as linhas CSV em uma única string separada por quebras de linha
            $dados = implode("\n", $csvLinhas);

            $stmt->bindParam(':dados', $dados, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
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

        $aDados = array();

        try {
            if ($iTipo == 0) {
                // Leitura da tabela do sistema
                $stmt = $this->pdo->prepare("SELECT $sArquivo FROM tbdatasistema WHERE seq = 1");
            } else {
                // Leitura da tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT du.$sArquivo FROM tbdadosusuarios du INNER JOIN tbusuarios u ON du.seq = u.seq WHERE u.email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            }

            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dados && isset($dados[$sArquivo])) {

                // A string CSV armazenada no banco de dados
                $csvString = $dados[$sArquivo];

                // Quebrar a string CSV em linhas
                $lines = explode("\n", $csvString);
                foreach ($lines as $line) {
                    if (!empty(trim($line))) {
                        // Converter cada linha CSV em um array
                        $aDados[] = array_map(function ($value) {
                            return str_replace('\;', ';', str_replace('\\n', '\n', $value));
                        }, explode(';', $line));
                    }
                }
            }
        } catch (PDOException $e) {
            // echo "Failed: " . $e->getMessage();
        }

        return $aDados;
    }

    /**
     * Método responsável por gravar todos os elementos do array composto array[][] = [valor1, valor2]
     */
    public function gravaArrayComposto($sArquivo, $iTipo, $dadosArray) {
        try {
            if ($iTipo == 0) {
                // Gravação na tabela do sistema
                $stmt = $this->pdo->prepare("UPDATE tbdatasistema SET $sArquivo = :dados WHERE seq = 1");
            } else {
                // Gravação na tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT seq FROM tbusuarios WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    $seq = $usuario['seq'];
                    $stmt = $this->pdo->prepare("UPDATE tbdadosusuarios SET $sArquivo = :dados WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                } else {
                    return false;
                }
            }

            // Converte o array composto em uma string CSV
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
                foreach ($linha as $item) {
                    if (is_array($item)) {
                        foreach ($item as $subitem) {
                            $linhaParaGravar[] = $subitem;
                        }
                    } else {
                        $linhaParaGravar[] = '';
                    }
                }
                // Converte a linha em uma string CSV
                $csvString .= implode(';', $linhaParaGravar) . "\n";
            }

            // Grava a string CSV no banco de dados
            $stmt->bindParam(':dados', $csvString, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retorna o array composto dos dados gravados no banco de dados
     * @param string $sArquivo Nome da coluna
     * @param int $iTipo 0 para sistema, 1 para usuário
     * @return array Array composto com os dados
     */
    public function retornaArrayComposto($sArquivo, $iTipo) {
        try {
            if ($iTipo == 0) {
                // Seleção na tabela do sistema
                $stmt = $this->pdo->prepare("SELECT $sArquivo FROM tbdatasistema WHERE seq = 1");
            } else {
                // Seleção na tabela do usuário
                $email = $_SESSION['email'];
                $stmt = $this->pdo->prepare("SELECT seq FROM tbusuarios WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    $seq = $usuario['seq'];
                    $stmt = $this->pdo->prepare("SELECT $sArquivo FROM tbdadosusuarios WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                } else {
                    return false;
                }
            }

            // Executa a consulta
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado || !isset($resultado[$sArquivo])) {
                return array();
            }

            // Converte a string CSV de volta para o array composto
            $csvString = $resultado[$sArquivo];
            $linhas = explode("\n", trim($csvString));
            $dadosArray = array();

            foreach ($linhas as $linha) {
                $itens = explode(';', $linha);
                $linhaArray = array();
                for ($i = 0; $i < count($itens); $i += 2) {
                    if ($itens[$i] != -1) {
                        $linhaArray[($i / 2) + 1] = [$itens[$i], $itens[$i + 1]];
                    }
                }
                $dadosArray[] = $linhaArray;
            }

            return $dadosArray;
        } catch (PDOException $e) {
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
        try {
            // Obter o email do usuário da sessão
            $email = $_SESSION['email'];

            // Consultar o seq do usuário
            $stmt = $this->pdo->prepare("SELECT seq FROM tbusuarios WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Verificar se o usuário foi encontrado
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario) {
                $seq = $usuario['seq'];

                // Verificar se já existe um registro para este usuário na tabela tbdadosusuarios
                $stmt = $this->pdo->prepare("SELECT * FROM tbdadosusuarios WHERE seq = :seq");
                $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                $stmt->execute();
                $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($dadosUsuario) {
                    // Atualizar o registro existente
                    $sql = "UPDATE tbdadosusuarios SET $sCampo = :texto WHERE seq = :seq";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                    $stmt->bindParam(':texto', $sText, PDO::PARAM_STR);
                    $stmt->execute();
                } else {
                    // Inserir um novo registro
                    $sql = "INSERT INTO tbdadosusuarios (seq, $sCampo) VALUES (:seq, :texto)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                    $stmt->bindParam(':texto', $sText, PDO::PARAM_STR);
                    $stmt->execute();
                }

                return true;
            } else {
                // echo "Usuário não encontrado.";
                return false;
            }
        } catch (PDOException $e) {
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
        try {
            if ($iTipo == 0) {
                // Seleção na tabela do sistema
                $stmt = $this->pdo->prepare("SELECT $sCampo FROM tbdatasistema WHERE seq = 1");
                $stmt->execute();
                $dados = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($dados && isset($dados[$sCampo])) {
                    return $dados[$sCampo];
                } else {
                    // echo "Campo ou registro não encontrado.";
                    return false;
                }
            } else {
                // Obter o email do usuário da sessão
                $email = $_SESSION['email'];

                // Consultar o seq do usuário
                $stmt = $this->pdo->prepare("SELECT seq FROM tbusuarios WHERE email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                // Verificar se o usuário foi encontrado
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    $seq = $usuario['seq'];

                    // Consultar o valor do campo especificado na tabela tbdadosusuarios
                    $stmt = $this->pdo->prepare("SELECT $sCampo FROM tbdadosusuarios WHERE seq = :seq");
                    $stmt->bindParam(':seq', $seq, PDO::PARAM_INT);
                    $stmt->execute();
                    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($dadosUsuario && isset($dadosUsuario[$sCampo])) {
                        return $dadosUsuario[$sCampo];
                    } else {
                        // echo "Campo ou registro não encontrado.";
                        return false;
                    }
                } else {
                    // echo "Usuário não encontrado.";
                    return false;
                }
            }
        } catch (PDOException $e) {
            // echo "Failed: " . $e->getMessage();
            return false;
        }
    }
}
