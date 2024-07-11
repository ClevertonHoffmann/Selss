<?php

class PersistenciaLogin extends Persistencia {

    private $tabelaUsuario;
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
        // Inicialize a tabela de usuários com base no modo da sessão
        $this->setTabela();
    }

    public function setTabela() {
        if (!$this->verificarSessao()) {
            return false;
        }
        if (isset($_SESSION['modo']) && $_SESSION['modo'] == 'convidado') {
            if ($this->tabelaExiste('tbusuariosconvidado')) {
                $this->tabelaUsuario = 'tbusuariosconvidado';
            } else {
                $this->errorlog('PL Tabela de usuário convidado não existe. ERROR');
            }
        } else {
            if ($this->tabelaExiste('tbusuarios')) {
                $this->tabelaUsuario = 'tbusuarios';
            } else {
                $this->errorlog('PL Tabela de usuário não existe. ERROR');
            }
        }
    }

    /**
     * Método responsável por verificar a senha do usuário digitada se já consta no banco de dados
     * @param type $sEmail
     * @param type $sSenha
     * @return bool
     */
    public function verificaEmailPass($sEmail, $sSenha) {
        
        $this->setTabela();

        $pdo = Conexao::getInstance();

        // Utilizando prepared statements para evitar injeção de SQL
        $sql = "SELECT * FROM " . $this->tabelaUsuario . " WHERE email = :email";
        $oQuery = $pdo->prepare($sql);
        $oQuery->bindParam(':email', $sEmail, PDO::PARAM_STR);
        $oQuery->execute();

        $aUser = $oQuery->fetch(PDO::FETCH_ASSOC);

        if ($aUser !== false) {
            // Utilizando password_hash para armazenar senhas de forma segura
            if (password_verify($sSenha, $aUser['senha'])) {
                return true;
            } else {
                $this->errorlog('PL Senha incorreta para o email ERROR: ' . $sEmail);
                return false;
            }
        } else {
            $this->errorlog('PL Usuário não encontrado ERROR: ' . $sEmail);
            return false;
        }
    }

    /**
     * Método responsável por realizar o cadastro do usuário no sistema
     * @param type $sEmail
     * @param type $sPass
     * @return type
     */
    public function cadastraUsuario($sEmail, $sPass) {

        $pdo = Conexao::getInstance();

        // Verifica se o e-mail já está cadastrado
        $verificarEmailSql = "SELECT COUNT(*) FROM " . $this->tabelaUsuario . " WHERE email = :email";
        $verificarEmailQuery = $pdo->prepare($verificarEmailSql);
        $verificarEmailQuery->bindParam(':email', $sEmail);
        $verificarEmailQuery->execute();
        $count = $verificarEmailQuery->fetchColumn();

        // Se o e-mail já estiver cadastrado, retorna false
        if ($count > 0) {
            $this->errorlog('PL email já cadastrado ERROR: ' . $sEmail);
            return false;
        }

        // Se o e-mail não estiver cadastrado, continua com a inserção
        //SQL usando prepared statement para prevenir SQL injection
        $inserirUsuarioSql = "INSERT INTO " . $this->tabelaUsuario . " (email, senha) VALUES (:email, :senha)";

        // Preparando a query
        $inserirUsuarioQuery = $pdo->prepare($inserirUsuarioSql);

        // Substituindo os parâmetros com valores reais
        $inserirUsuarioQuery->bindParam(':email', $sEmail);
        $inserirUsuarioQuery->bindParam(':senha', $sPass);

        // Executando a query
        $bResultado = $inserirUsuarioQuery->execute();
        $this->errorlog('PL resultado cadastra usuário: ' . $bResultado);
        return $bResultado;
    }

    // Função para gerar um nome aleatório
    function gerarNomeAleatorio($length = 8) {

        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nome = '';

        for ($i = 0; $i < $length; $i++) {
            $nome .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        $this->errorlog('PL resultado gerarNomeAleatorio: ' . $nome);
        return $nome;
    }

    /**
     * Método responsável por realizar a exclusão do usuário no sistema
     * @param type $sEmail
     * @return type
     */
    function excluirUsuario($sEmail) {

        $pdo = Conexao::getInstance();

        // Verifica se o e-mail está cadastrado
        $verificarEmailSql = "SELECT COUNT(*) FROM " . $this->tabelaUsuario . " WHERE email = :email";
        $verificarEmailQuery = $pdo->prepare($verificarEmailSql);
        $verificarEmailQuery->bindParam(':email', $sEmail);
        $verificarEmailQuery->execute();
        $count = $verificarEmailQuery->fetchColumn();

        // Se o e-mail não estiver cadastrado, retorna false
        if ($count == 0) {
            return false;
        }

        // Se o e-mail estiver cadastrado, continua com a exclusão
        // SQL usando prepared statement para prevenir SQL injection
        $excluirUsuarioSql = "DELETE FROM " . $this->tabelaUsuario . " WHERE email = :email";

        // Preparando a query
        $excluirUsuarioQuery = $pdo->prepare($excluirUsuarioSql);

        // Substituindo o parâmetro com o valor real
        $excluirUsuarioQuery->bindParam(':email', $sEmail);

        // Executando a query
        $bResultado = $excluirUsuarioQuery->execute();

        return $bResultado;
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
            $this->errorlog("PL Tabela $tabela não existe. Erro: " . $e->getMessage());
            return false;
        }
        return $result !== false;
    }

    // O método para verificar a sessão
    private function verificarSessao() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['modo'])) {
            $this->errorlog("PL Variável de sessão 'modo' não está definida.");
            return false;
        }

        return true;
    }
}
