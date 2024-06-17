<?php
/**
 * Persistencia responsável por gravar em arquivos CSV
 * @author Cleverton
 */
class PersistenciaCSV {
    
    /**
     * Grava um array em um arquivo CSV
     * @param string $sArquivo O nome do arquivo CSV a ser criado/gravado
     * @param type $iTipo 0 sistema 1 usuario
     * @param array $dadosArray O array de dados a serem gravados no arquivo CSV
     * @return bool Retorna true se a gravação for bem-sucedida, false em caso de erro
     */
    public function gravaArray($sArquivo, $iTipo, $dadosArray) {

        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo. '.csv';
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '//' . $sArquivo. '.csv';
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
    public function gravaArrayComposto($sArquivo, $iTipo, $dadosArray) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo. '.csv';
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '/' . $sArquivo. '.csv';
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
    public function retornaArray($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo. '.csv';
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '//' . $sArquivo. '.csv';
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
    public function retornaArrayComposto($sArquivo, $iTipo) {
        $nomeArquivo = '';
        if ($iTipo == 0) {
            $nomeArquivo = 'data/' . $sArquivo. '.csv';
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $nomeArquivo = $sDiretorio . '/' . $sArquivo. '.csv';
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
     * @param type $sExt
     */
    public function gravaArquivo($sArquivo, $sText, $sExt) {

        $sDiretorio = $_SESSION['diretorio'];

        $arquivo = $sDiretorio . "//" . $sArquivo. $sExt;

        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "w");

        //Escreve no arquivo aberto.
        fwrite($fp, $sText);

        //Fecha o arquivo.
        fclose($fp);
    }
    
    /**
     * Função que realiza a leitura para retornar caso já exista os arquivos pré-carregados no sistema
     * @param type $sNome
     * @param type $sExt
     * @param type $iTipo 0 sistema 1 usuario
     * @return string
     */
    public function retornaTextoDoCampo($sNome, $sExt, $iTipo) {
        
        $arquivo = '';
        if ($iTipo == 0) {
            $arquivo = 'data/' . $sNome. $sExt;
        } else {
            $sDiretorio = $_SESSION['diretorio'];
            $arquivo = $sDiretorio . '/' . $sNome. $sExt;
        }
        
        // Verifica se o arquivo existe
        if (file_exists($arquivo)) {
            // Lê o conteúdo do arquivo e retorna
            return file_get_contents($arquivo);
        } else {
            return "";
        }
    }
    
}
