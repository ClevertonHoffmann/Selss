<?php

/**
 * Classe responsável por exibir as menagens no sistema
 */
class Mensagem {
    
    const SUCCESS = 1;
    const INFO = 2;
    const WARNING = 3;
    const ERROR = 4;

    /**
     * Método chamado para exibir as mensagens no sistema
     * @param string $sMensagem
     * @param int $iTipo SUCCESS = 1; INFO = 2; WARNING = 3; ERROR = 4;
     */
    public static function exibirToast($sMensagem, $iTipo = self::SUCCESS) {
        $tiposValidos = [self::SUCCESS, self::INFO, self::WARNING, self::ERROR];

        // Verifica se o tipo fornecido é válido
        if (!in_array($iTipo, $tiposValidos)) {
            $iTipo = self::SUCCESS; // Define como padrão se for inválido
        }

        $tipoNomes = [
            self::SUCCESS => 'success',
            self::INFO => 'info',
            self::WARNING => 'warning',
            self::ERROR => 'error'
        ];

        // Inclui o estilo diretamente no echo
        echo "<div class='toast toast-" . $tipoNomes[$iTipo] . "' style='background-color: #e5e5e5; border: 1px solid #ccc; padding: 10px; margin: 10px; color: #333;'>$sMensagem</div>";
    }
}

?>