<?php

class PersistenciaLogin extends Persistencia {

    private $tabelaUsuario;
    
    public function __construct() {
        // Inicialize a tabela de usuários com base no modo da sessão
        $this->setTabela();
    }
    
    public function setTabela() {
        if (isset($_SESSION['modo']) && $_SESSION['modo'] == 'convidado') {
            $this->tabelaUsuario = 'tbusuariosconvidado';
        } else {
            $this->tabelaUsuario = 'tbusuarios';
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
                return false;
            }
        } else {
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

        return $bResultado;
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
}
