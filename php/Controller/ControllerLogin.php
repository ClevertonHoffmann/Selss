<?php

/*
 * Classe responsável pela contrução da classe de login sistema
 */

class ControllerLogin extends Controller {

    public function __construct() {
        $this->carregaClasses('Login');
    }

    /**
     * Retorna a tela de login caso não tenha sessão válida
     * @param type $sDados
     * @return type
     */
    public function mostraTelaLogin($sDados) {
        $this->errorlog('CL Chegou no método: mostraTelaLogin($sDados)');
        $sLoginHtml = $this->getOView()->retornaTelaLogin();
        $this->errorlog('CL Finalizou o método: $this->getOView()->retornaTelaLogin()');
        return $sLoginHtml;
    }

    /**
     * Método responsável por validar o login e suas variáveis e redirecionar
     * a tela retornando true se sessão válida ou false caso deva mostrar  a tela de login
     * @return boolean
     */
    public function validaLogin() {
        $this->errorlog('CL Chegou no método: mostraTelaLogin($sDados)');
        /**
         * Função responsável por recebe os dados da tela de login
         * Criar a sessão e validar os dados de entrada
         * E criar a pasta de arquivos para o usuário da sessão
         */
        //Pega valor do request POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Obtem o email do formulário
            $sEmail = $_POST["email"];
            $this->errorlog('CL Método valida login: EMAIL:'.$sEmail);

            // Obtem a senha do formulário
            $sSenha = $_POST["pass"];
            $sPass = password_hash($sSenha, PASSWORD_BCRYPT);
            $this->errorlog('CL Método valida login: Pass:'.$sPass);

            //Obtém o modo, convidado ou usuário
            $sModo = $_POST["modo"];
            if($sModo!=null && $sModo!=''){
                $_SESSION['modo'] = $sModo;
            }
            $this->errorlog('CL Método valida login: MODO:'.$_SESSION['modo']);
            
            //Valor a ser recebido caso e-mail com senha válido
            $bVal = $this->getOPersistencia()->verificaEmailPass($sEmail, $sSenha);
            $this->errorlog('CL Finalizou o método: $this->getOPersistencia()->verificaEmailPass($sEmail, $sSenha) retorno='.$bVal);
            //Ignora modo convidado
            if (!$bVal || $sModo == "convidado") {
                //Opta pelo modo sendo os possíveis casos: convidado, cadastro (isso se diferente de usuário)
                switch ($sModo) {
                    case "convidado":
                        $sSenha = $this->gerarNomeConvidado();
                        $sEmail = $sSenha;
                        $sPass = $sSenha;
                        $bVal = $this->getOPersistencia()->cadastraUsuario($sEmail, $sPass);
                        $this->errorlog('CL Finalizou o método: $this->getOPersistencia()->cadastraUsuario($sEmail, $sPass) retorno='.$bVal);
                        break;
                    default :
                        $this->errorlog('CL Método valida login: ERROR email ou forma de entrada errados');
                        $this->Mensagem('Verifique email ou senha, ou o modo de entrada!', 4);
                }
            }

            if ($bVal) {
                //Variável para mostrar a tela principal caso seja válido o email
                $bEmailValido = false;

                //Pasta que inicializa em branco caso exista traz o conteúdo dos arquivos
                $pasta = '';

                // Verifica se o email é válido e ignora quando for modo convidado
                if (filter_var($sEmail, FILTER_VALIDATE_EMAIL) || $sModo == "convidado") {

                    // Diretório para criar pasta de arquivos
                    $diretorio = "datausers//";

                    // Crie a pasta com o nome do email
                    $pasta = $diretorio . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $sEmail);

                    //Salva valores iniciais na variável de sessão do usuário
                    $_SESSION['pasta'] = $pasta;
                    $_SESSION['diretorio'] = $pasta;
                    $_SESSION['email'] = $sEmail;
                    $_SESSION['pass'] = $sPass;
                    $_SESSION['modo'] = $sModo;

                    // Verifique se a pasta já existe
                    if (!file_exists($pasta)) {
                        // Crie a pasta
                        $sRetorno = mkdir($pasta, 0777, true);
                        $this->errorlog('CL Método valida login: criação da pasta:'.$sRetorno);
                        $bEmailValido = true;
                    } else {
                        $this->errorlog('CL Método valida login: pasta já existe');
                        $bEmailValido = true;
                    }
                } else {
                    return false;
                }

                //Apresenta a tela inicial do sistema
                if ($bEmailValido) {
                    $this->Mensagem('Bem vindo ao sistema!', 1);
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->errorlog('CL Método valida login: ERROR email inválido');
                $this->Mensagem('Email ou senha incorretos!', 4);
                return false;
            }
        } else {
            $this->errorlog('CL Método valida login: ERROR não é método post');
            return false;
        }
    }

    /**
     * Método responsável por retornar a tela de cadastro de usuário
     * @param type $sDados
     * @return type
     */
    public function mostraTelaCadastraUsuario($sDados) {
        $this->errorlog('CL Chegou no método: mostraTelaCadastraUsuario($sDados)');
        $sLoginHtml = $this->getOView()->retornaTelaCadastro();
        $this->errorlog('CL Finalizou o método: $this->getOView()->retornaTelaCadastro()');
        return $sLoginHtml;
    }

    public function realizaCadastroUsuario($sDados) {
        $this->errorlog('CL Chegou no método: realizaCadastroUsuario($sDados)');
        //Pega valor do request POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Obtem o email do formulário
            $sEmail = $_POST["email"];

            // Obtem a senha do formulário
            $sSenha = $_POST["senha"];
            $sPass = password_hash($sSenha, PASSWORD_BCRYPT);

            //Valor a ser recebido caso e-mail com senha válido
            $bVal = $this->getOPersistencia()->verificaEmailPass($sEmail, $sSenha);
            $this->errorlog('CL Finalizou o método: $this->getOPersistencia()->verificaEmailPass($sEmail, $sSenha) retorno='.$bVal);
            if (!$bVal) {
                if (trim($sEmail) == '' || $sEmail == null) {
                    $this->Mensagem('Não é possível cadastrar sem email!', 4);
                    $this->errorlog('CL Finalizou o método: realizaCadastroUsuario($sDados) retorno= false email vazio');
                    return false;
                }
                $bVal = $this->getOPersistencia()->cadastraUsuario($sEmail, $sPass);
                if ($bVal) {
                    $this->Mensagem('Cadastro realizado com sucesso!', 1);
                    $this->errorlog('CL Finalizou o método: realizaCadastroUsuario($sDados) retorno= true');
                    return true;
                } else {
                    $this->Mensagem('Não é possível Cadastrar, Email já cadastrado!', 4);
                    $this->errorlog('CL Finalizou o método: realizaCadastroUsuario($sDados) retorno= false email já cadastrado');
                    return false;
                }
            } else {
                $this->Mensagem('Verifique email ou senha, ou o modo de entrada!', 4);
            }
        }
        $this->errorlog('CL Finalizou o método: realizaCadastroUsuario($sDados)');
    }

    // Função para gerar um nome de convidado único
    public function gerarNomeConvidado() {
        $this->errorlog('CL Chegou no método: gerarNomeConvidado()');
        // Obter timestamp atual
        $timestamp = time();

        // Gerar identificador único
        $identificadorUnico = uniqid();

        // Concatenar timestamp e identificador único para criar um nome único
        $nomeConvidado = "convidado" . $timestamp . "@" . $identificadorUnico;
        $this->errorlog('CL Finalizou o método: gerarNomeConvidado() retorno nomeconvidado='.$nomeConvidado);
        return $nomeConvidado;
    }

    public function excluirUsuario() {
        $this->errorlog('CL Chegou no método: excluirUsuario()');
        $sEmail = $_SESSION['email'];
        if ($sEmail != null && $sEmail != '') {
            $bVal = $this->getOPersistencia()->excluirUsuario($sEmail);
            $this->errorlog('CL Finalizou o método: excluirUsuario() retorno='.$bVal);
            return $bVal;
        }else{
            $this->errorlog('CL Finalizou o método: excluirUsuario() retorno=false');
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
}
