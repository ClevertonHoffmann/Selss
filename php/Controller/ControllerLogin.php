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
        $sLoginHtml = $this->oView->retornaTelaLogin();
        return $sLoginHtml;
    }

    /**
     * Método responsável por validar o login e suas variáveis e redirecionar
     * a tela retornando true se sessão válida ou false caso deva mostrar  a tela de login
     * @return boolean
     */
    public function validaLogin() {

        /**
         * Função responsável por recebe os dados da tela de login
         * Criar a sessão e validar os dados de entrada
         * E criar a pasta de arquivos para o usuário da sessão
         */
        //Pega valor do request POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Obtem o email do formulário
            $sEmail = $_POST["email"];

            // Obtem a senha do formulário
            $sSenha = $_POST["pass"];
            $sPass = password_hash($sSenha, PASSWORD_BCRYPT);

            $bVal = false; //Valor a ser recebido caso e-mail com senha válido
            //Obtém o modo, convidado ou usuário
            $sModo = $_POST["modo"];

            //Opta pelo modo sendo os possíveis: convidado, cadastro, usuário
            switch ($sModo) {
                case "convidado":
                    //////////////////////////////////////////
                    break;
                case "cadastro":
                    $bVal = $this->oPersistencia->cadastraUsuario($sEmail, $sPass);
                    break;
                default:
                    $bVal = $this->oPersistencia->verificaEmailPass($sEmail, $sSenha);
            }

            if ($bVal) {
                //Variável para mostrar a tela principal caso seja válido o email
                $bEmailValido = false;

                //Pasta que inicializa em branco caso exista traz o conteúdo dos arquivos
                $pasta = '';

                // Verifica se o email é válido
                if (filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {

                    // Diretório para criar pasta de arquivos
                    $diretorio = "datausers//";

                    // Crie a pasta com o nome do email
                    $pasta = $diretorio . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $sEmail);

                    //Salva valores iniciais na variável de sessão do usuário
                    $_SESSION['pasta'] = $pasta;
                    $_SESSION['diretorio'] = "..//" . $pasta;
                    $_SESSION['email'] = $sEmail;
                    $_SESSION['pass'] = $sPass;
                    $_SESSION['modo'] = $sModo;

                    //    $this->oPersistencia->gravaArrayEmCSV($sArquivo, $iTipo, $dadosArray);
                    // Verifique se a pasta já existe
                    if (!file_exists($pasta)) {
                        // Crie a pasta
                        mkdir($pasta, 0777, true);

                        $bEmailValido = true;
                    } else {
                        $bEmailValido = true;
                    }
                } else {
                    return false;
                }

                //Apresenta a tela inicial do sistema
                if ($bEmailValido) {
                    return true;
                }else{
                    return false;
                }
            } else {
                header("Location:index.php?metodo=login_invalido");
                return false;
            }
        } else {
            return false;
        }
        //  header("Location: login.php?erro=email_invalido");
        // 
        
    }
}
