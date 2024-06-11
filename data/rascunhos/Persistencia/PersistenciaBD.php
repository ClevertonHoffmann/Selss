<?php

class PersistenciaDB implements PersistenciaInterface {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function gravaArrayEmCSV($tabela, $dadosArray) {
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

    public function gravaArrayCompostoEmCSV($tabela, $dadosArray) {
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

    public function retornaArrayCSV($tabela) {
        try {
            $stmt = $this->pdo->query("SELECT * FROM $tabela");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Failed: " . $e->getMessage();
            return [];
        }
    }

    public function retornaArrayCompostoCSV($tabela) {
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

    public function gravaArquivo($tabela, $sText) {
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

?>
