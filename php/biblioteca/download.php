<?php

// Inicia a sessão para usar as variáveis de sessão
session_start();

include_once '../../config/Conexao.php';
include_once '../../php/Persistencia/Persistencia.php';
include_once '../../php/Persistencia/PersistenciaCSV.php';
include_once '../../php/Persistencia/PersistenciaBD.php';

// Verifique se o parâmetro 'arquivo' está presente na consulta
if (isset($_GET['arquivo'])) {

    // Instancie a classe controller
    $persistencia = new Persistencia();

    if ($persistencia->getTipoPersistencia() == 'BD') {
        // Obtenha o nome da tabela ou arquivo a partir do parâmetro 'arquivo'
        $nomeArquivo = $_GET['arquivo'];

        // Obtenha os dados usando a persistência definida
        $dados = $persistencia->retornaArray($nomeArquivo, 1); // Ajuste o segundo parâmetro conforme necessário (0 para sistema, 1 para usuário)

        if (!empty($dados)) {
            // Define os cabeçalhos apropriados para forçar o download
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename=' . $nomeArquivo . '.csv');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');

            // Cria um ponteiro de arquivo temporário
            $output = fopen('php://output', 'w');

            foreach ($dados as $linha) {
                // Aplica a função de escape para cada campo da linha
                $linhaEscapada = array_map('escapeSpecialChars', $linha);

                // Codifica cada campo para UTF-8
                $linhaUtf8 = array_map('utf8_decode', $linhaEscapada);
                
                // Escreve a linha no arquivo CSV
                fputcsv($output, $linhaUtf8, ';');
            }

            // Fecha o ponteiro de arquivo
            fclose($output);    

            // Encerra a execução do script
            exit;
        } else {
            // Se não houver dados, emita um erro 404
            header("HTTP/1.0 404 Not Found");
            echo "Nenhum dado encontrado.";
        }
    } else {
        //Diretório do usuário para o sistema
        $sDiretorio = $_SESSION['diretorio'];

        // Obtenha o nome do arquivo a partir do parâmetro 'arquivo'
        $nomeArquivo = $_GET['arquivo'];

        // Caminho para o arquivo no servidor
        $caminhoArquivo = '../../' . $sDiretorio . '/' . $nomeArquivo . '.csv';

        // Verifique se o arquivo existe
        if (file_exists($caminhoArquivo)) {
            // Defina os cabeçalhos apropriados para forçar o download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($caminhoArquivo));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($caminhoArquivo));

            // Leia o arquivo e envie o conteúdo para o navegador
            readfile($caminhoArquivo);
            exit;
        } else {
            // Se o arquivo não existir, emita um erro 404
            header("HTTP/1.0 404 Not Found");
            echo "Arquivo não encontrado.";
        }
    }
} else {
    // Se o parâmetro 'arquivo' não estiver presente, emita um erro 400
    header("HTTP/1.0 400 Bad Request");
    echo "Parâmetro 'arquivo' ausente.";
}

// Função para escapar caracteres especiais
function escapeSpecialChars($value) {
    $value = str_replace("\n", '\\n', $value); // Escapa a quebra de linha
    return $value;
}

?>
