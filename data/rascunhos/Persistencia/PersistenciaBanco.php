<?php

class PersistenciaBanco {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    /**
     * Grava um array em uma tabela no banco de dados
     * @param string $tabela O nome da tabela no banco de dados
     * @param array $dadosArray O array de dados a serem gravados na tabela
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro
     */
    public function gravaArrayEmTabela($tabela, $dadosArray) {
        try {
            $this->pdo->beginTransaction();
            foreach ($dadosArray as $linha) {
                $placeholders = implode(',', array_fill(0, count($linha), '?'));
                $sql = "INSERT INTO $tabela VALUES ($placeholders)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(array_values($linha));
            }
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Grava um array composto em uma tabela no banco de dados
     * @param string $tabela O nome da tabela no banco de dados
     * @param array $dadosArray O array de dados compostos a serem gravados na tabela
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro
     */
    public function gravaArrayCompostoEmTabela($tabela, $dadosArray) {
        try {
            $this->pdo->beginTransaction();
            foreach ($dadosArray as $linha) {
                $linhaParaGravar = [];
                $maxChave = max(array_keys($linha));
                for ($i = 1; $i <= $maxChave; $i++) {
                    if (!isset($linha[$i])) {
                        $linha[$i] = [-1, -1];
                    }
                }
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
                $placeholders = implode(',', array_fill(0, count($linhaParaGravar), '?'));
                $sql = "INSERT INTO $tabela VALUES ($placeholders)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($linhaParaGravar);
            }
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retorna o array da tabela no banco de dados
     * @param string $tabela O nome da tabela no banco de dados
     * @return array Retorna um array com os dados da tabela
     */
    public function retornaArrayDaTabela($tabela) {
        try {
            $stmt = $this->pdo->query("SELECT * FROM $tabela");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Retorna o array composto da tabela no banco de dados
     * @param string $tabela O nome da tabela no banco de dados
     * @return array Retorna um array composto com os dados da tabela
     */
    public function retornaArrayCompostoDaTabela($tabela) {
        try {
            $stmt = $this->pdo->query("SELECT * FROM $tabela");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dadosArray = [];
            foreach ($result as $row) {
                $linhaArray = [];
                foreach ($row as $key => $value) {
                    $linhaArray[$key] = $value;
                }
                $dadosArray[] = $linhaArray;
            }
            return $dadosArray;
        } catch (PDOException $e) {
            echo "Failed: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Função para escrever as entradas do usuário para ficar salvo para o próximo logon
     * @param string $tabela O nome da tabela no banco de dados
     * @param string $sText O texto a ser gravado
     */
    public function gravaTextoEmTabela($tabela, $sText) {
        try {
            $sql = "INSERT INTO $tabela (texto) VALUES (:texto)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':texto', $sText, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Failed: " . $e->getMessage();
        }
    }
}
