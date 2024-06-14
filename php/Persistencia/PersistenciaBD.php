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
     * Grava um array em um arquivo CSV
     * @param string $sArquivo O nome do arquivo CSV a ser criado/gravado
     * @param type $iTipo 0 sistema 1 usuario
     * @param array $dadosArray O array de dados a serem gravados no arquivo CSV
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro
     */
    public function gravaArrayEmCSV($sArquivo, $iTipo, $dadosArray) {

        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '//' . $sArquivo;
        }

        $handle = fopen($nomeArquivo, 'w');

        if ($handle !== false) {
            foreach ($dadosArray as $linha) {
                fputcsv($handle, $linha, ';');
            }
            fclose($handle);
            return true; // Retorna true se a gravação for bem-sucedida
        } else {
            echo "Não foi possível criar o arquivo $nomeArquivo.";
            return false; // Retorna false em caso de erro ao criar o arquivo
        }
    }

    /**
     * Método responsável por gravar todos os elementos do array composto array[][] = [valor1, valor2]
     */
    public function gravaArrayCompostoEmCSV($sArquivo, $iTipo, $dadosArray) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '/' . $sArquivo;
        }

        $handle = fopen($nomeArquivo, 'w');

        if ($handle !== false) {
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
                fputcsv($handle, $linhaParaGravar, ';');
            }
            fclose($handle);
            return true; // Retorna true se a gravação for bem-sucedida
        } else {
            echo "Não foi possível criar o arquivo $nomeArquivo.";
            return false; // Retorna false em caso de erro ao criar o arquivo
        }
    }

    /**
     * Retorna o array do arquivo CSV
     * @param type $sArquivo
     * @param type $iTipo 0 sistema 1 usuario
     * @return type
     */
    public function retornaArrayCSV($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '//' . $sArquivo;
        }

        $aCSV = array();

        if (($handle = fopen($nomeArquivo, 'r')) !== false) {
            while (($slinha = fgets($handle)) !== false) {
                $aCSV[] = str_getcsv($slinha, ';');
            }
            fclose($handle);
        } else {
            echo "Não foi possível abrir o arquivo $nomeArquivo.";
        }

        return $aCSV;
    }

    /**
     * Retorna o array composto do arquivo CSV
     * @param type $sArquivo
     * @param type $iTipo 0 sistema 1 usuario
     * @return type
     */
    public function retornaArrayCompostoCSV($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '/' . $sArquivo;
        }

        $dadosArray = array();

        if (($handle = fopen($nomeArquivo, 'r')) !== false) {
            while (($linha = fgetcsv($handle, 0, ';')) !== false) {
                $maxChave = max(array_keys($linha));
                $linhaArray = array();
                $iPos = 1;
                for ($i = 0; $i <= $maxChave; $i = $i + 2) {
                    if ($linha[$i] != -1) {
                        $linhaArray[$iPos] = [$linha[$i], $linha[$i + 1]]; // Adiciona o par de valores ao array da linha
                    }
                    $iPos++;
                }
                $dadosArray[] = $linhaArray; // Adiciona a linha ao array de dados
            }
            fclose($handle);
        } else {
            echo "Não foi possível abrir o arquivo $nomeArquivo.";
        }

        return $dadosArray;
    }

    /**
     * Função para escrever as entradas do usuário para ficar salvo para o próximo logon
     * @param type $sArquivo
     * @param type $sText
     */
//    public function gravaArquivo($sArquivo, $sText) {
//
//        $sDiretorio = $_SESSION['diretorio'];
//
//        $arquivo = $sDiretorio . "//" . $sArquivo;
//
//        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
//        $fp = fopen($arquivo, "w");
//
//        //Escreve no arquivo aberto.
//        fwrite($fp, $sText);
//
//        //Fecha o arquivo.
//        fclose($fp);
//    }
    
    /**
     * Função para escrever as entradas do usuário para ficar salvo para o próximo logon
     * @param type $sCampo
     * @param type $sText
     */
    public function gravaArquivo($sCampo, $sText) {
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
     * Função para retornar as entradas do usuário no login
     * @param type $sCampo
     */
    public function retornaTextoDoCampo($sCampo) {
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
        } catch (PDOException $e) {
           // echo "Failed: " . $e->getMessage();
            return false;
        }
    }
    
}
