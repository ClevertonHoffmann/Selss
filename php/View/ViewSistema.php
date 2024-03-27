<?php

class ViewSistema {

    /**
     * Retorna a tela do sistema com os campos preenchidos de acordo com o usuário
     * @return type tela
     */
    public function retornaTelaSistema() {

        $pasta = $_SESSION["pasta"];
        $defReg = $this->retornaTexto($pasta . "//defReg.txt"); //Definições regulares do usuário no sistema
        $codigoParaAnalise = $this->retornaTexto($pasta . "//codigoParaAnalise.txt"); //Definições regulares do usuário no sistema
        $defGram = $this->retornaTexto($pasta . "//defGram.txt"); //Definições gramatica do usuário no sistema

        //Cabeçalho
        $oTela = "<!DOCTYPE html>
                <html lang='pt'>    
                    <head>
                            <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                            <meta charset='utf-8'>

                            <!-- Bootstrap CSS -->
                            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'
                                  integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>

                            <!-- Material Icons -->
                            <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>

                            <!-- CSS personalizado do projeto -->
                            <link rel='stylesheet' href='css/app.css'>

                            <!-- jQuery, Popper.js, Bootstrap JS -->
                            <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
                            <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js'></script>
                            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js'></script>

                            <!-- JS personalizado do projeto-->
                            <script src='js/app.js' type='text/javascript'></script>

                    </head>
                "; 
        
        //Menu, Título, Botão sair
        $oTela .= "    <body> 
                        <nav class='navbar p-1' style='background:#e3f2fd; display:flex;'>
                            <div class='dropdown p-1'>
                                <button class='dropbtn' type='button' id='dropdownMenu1' data-bs-toggle='dropdown' style='background:cornflowerblue;'>
                                    <span class='icon-asset material-icons ng-star-inserted' style='font-size: calc(1vw);'>menu</span>
                                </button>
                                <div class='dropdown-content'>
                                    <a href='#'>Link 1</a>
                                    <a href='#'>Link 2</a>
                                    <a href='#'>Documentação</a>
                                </div>
                            </div>
                            <h4 class='mx-auto' style='font-size:calc(5px + 1vw)' data-toggle='tooltip' data-placement='right' title='SELSS - SOFTWARE EDUCACIONAL LÉXICO, SINTÁTICO E
                                SEMÂNTICO'><img src='http://localhost/Selss/img/logo.png' alt='Sua Imagem' id='logo' style='width: 120px; height: 50px;'>
                            </h4>
                            <button class='btn btn-sm btn-outline-secondary me-2' id='btnSair'>Sair</button>
                            <div id='modalSair' class='modal' style='text-align: center;'>
                                <div class='modal-content-sair'>
                                    <p><h4>Você tem certeza que deseja sair?</h4></p>
                                    <button class='btsairLogout' id='btnSairLogout'>Sim, Sair</button>
                                    <button class='btcancelarLogout' id='cancelarLogout'>Cancelar</button>
                                </div>
                            </div>
                        </nav>";
        
        //Quadro 1: Tabela de análise léxica, autômato, definições Regulares
        $oTela .= "     <nav class='navbar p-1' style='background:#e3f2fd;'>
                            <div style='width: calc(27vw); height: calc(65vh); background-color: rgba(0,0,255,0.1); border:1px solid black;'>
                                <nav class='navbar p-1'>
                                    <form class='container-fluid justify-content-start p-0'>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' onclick='loadTabLexica()'
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button' 
                                                data-toggle='tooltip' data-placement='right' title='Gera a tabela do automato para análise léxica'>TABELA DE ANÁLISE
                                            LÉXICA</button>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' onclick='loadAutomato()'
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button' 
                                                data-toggle='tooltip' data-placement='right' title='Automato de análise léxica'>AUTÔMATO</button>
                                    </form>
                                        <div class='div text-center'
                                             style='width: calc(27vw); height: calc(57vh); background-color: rgba(0,0,255,0.1);'>
                                            <div class='div text-center p-1'>
                                                <h6 class='justify'
                                                    style='border:1px solid black; font-size:calc(1vw);'>DEFINIÇÕES REGULARES/TOKENS</h6>
                                            </div>
                                            <div class='div text-justify'>
                                                <textarea id='defReg' name='defReg' style='width: calc(26vw); height: calc(50vh);' placeholder=\"Escreva as definições regulares, tokens\">" . $defReg . "</textarea>
                                            </div>
                                        </div>
                                    <!-- Balão de sugestão -->
                                    <div id='balaoSugestao'></div>   
                                </nav>
                            </div>";
        
        //Quadro 2: First e Follows, Itens, Tabela Sintática
        $oTela .= "     <div style='width: calc(27vw); height: calc(65vh); background-color: rgba(0,0,255,0.1); border:1px solid black;'>
                                <nav class='navbar p-1' data-toggle='tooltip' data-placement='right' title='Em desenvolvimento!'>
                                    <form class='container-fluid justify-content-start p-0'>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' disabled
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button'>FIRST E
                                            FOLLOWS</button>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' disabled
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button'>ITENS</button>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' disabled
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button'>TABELA
                                            SINTÁTICA</button>
                                    </form>
                                    <div style='width: calc(27vw); height: calc(57vh); background-color: rgba(0,0,255,0.1);'>
                                        <div class='div p-1 text-center'>
                                            <h6 class='justify' style='border:1px solid black; font-size:calc(1vw); '>
                                                GRAMÁTICA
                                            </h6>
                                        </div>
                                        <div class='div text-justify'>
                                            <textarea readonly disabled id='defGram' name='defGram' style='width: calc(26vw); height: calc(50vh);' placeholder=\"Escreva as definições da gramática\">" . $defGram . "</textarea> 
                                        </div>
                                    </div>
                                </nav>
                            </div>";
        
        //Quadro 3: Análise léxica, sintática e semântica
        $oTela .= "     <div style='width: calc(42vw); height: calc(65vh); background-color: rgba(0,0,255,0.1); border:1px solid black;'>
                                <nav class='navbar p-1'>
                                    <form class='container-fluid justify-content-start p-0'>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' data-toggle='tooltip' data-placement='right' title='Realiza análise léxica e gera os tokens'
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button' onclick='analiseLexica()'>LÉXICO</button>
                                        <span class='d-inline-block' tabindex='0' data-toggle='tooltip' title='Em desenvolvimento!'>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' disabled
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button'>SINTÁTICO</button>
                                        <button class='btn btn-sm btn-outline-secondary me-1 ' disabled
                                                style='width: calc(vw); height: calc(vh); font-size:calc(1vw)' type='button'>SEMÂNTICO</button>
                                        </span>
                                        <button class='btn btn-sm btn-secondary' style='width: calc(vw); height: calc(vh); font-size:calc(1vw)'
                                                type='button' data-toggle='tooltip' data-placement='right' title='Documentação'>?</button>
                                    </form>
                                    <div style='width: calc(42vw); height: calc(57vh); background-color: rgba(0,0,255,0.1);'>
                                        <div class='div p-1 text-center'>
                                            <h6 class='container-fluid justify-content-start' style='border:1px solid black; font-size:calc(1vw);'>
                                                ÁREA PARA INSERIR CÓDIGO DE TESTE PARA AS DEFINIÇÕES CRIADAS
                                            </h6>
                                        </div>
                                        <div class='div p-1 text-justify'>
                                            <textarea id='codTest' name='codTest' style='width: calc(41vw); height: calc(49.5vh);' placeholder=\"Escreva o código a ser analisado\" >" . $codigoParaAnalise . "</textarea> 
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </nav>";
        
        //Quadro 4: Console de erros e informações das definições regulares e gramáticas
        $oTela .= "     <nav class='navbar p-1' style='background:#e3f2fd'>
                            <div style='width: calc(100vw); height: calc(20vh); background-color: rgba(0,0,255,0.1); border:1px solid black;'>
                                <div class='div p-1 text-center'>
                                    <h6 class='container-fluid justify-content-start' style='border:1px solid black; font-size:calc(1vw);'>
                                        CONSOLE DE ERROS E INFORMAÇÕES DAS DEFINIÇÕES REGULARES E GRAMÁTICAS
                                    </h6>
                                </div>
                                <div class='div p-1 text-justify'>
                                    <textarea id=\"saidaDefErros\" name=\"saidaDefErros\" style='resize:none; overflow:auto; width: calc(98vw); height: calc(12vh); background-color: #fcfaff;'></textarea>
                                </div>
                            </div>
                        </nav>";
        
        //Modal Tabela Análise Léxica
        $oTela .= "     <div id='myModal' class='modal'>
                            <div class='modal-content'>
                                <div class='modal-header-wrapper'>
                                    <div class='modal-header'>
                                        <h2 class='mx-auto'>Tabela de Analise Léxica</h2>
                                        <span class='close-button' onclick='closeModal()'>&times;</span>
                                    </div>
                                </div>
                                <div id='csvData' class='modal-table'>
                                    <!-- Conteúdo da tabela aqui -->
                                </div>
                                <button id='downloadTabelaAnaliseLexica'>Baixar Tabela</button>
                            </div>
                        </div>";
        
        //Modal autômato de análise léxica
        $oTela .= "     <div id='myModal3' class='modal'>
                            <div class='modal-content'>
                                <div class='modal-header-wrapper'>
                                    <div class='modal-header'>
                                        <h2 class='mx-auto'>Autômato de análise léxica</h2>
                                        <span class='close-button' onclick='closeModal3()'>&times;</span>
                                    </div>
                                </div>
                                <div id='csvData3' class='modal-table'>
                                    <!-- Conteúdo da tabela aqui -->
                                </div>
                            </div>
                        </div>";
        
        //Modal Resultado da Análise Léxica
        $oTela .= "     <div id='myModal2' class='modal'>
                            <div class='modal-content'>
                                <div class='modal-header-wrapper'>
                                    <div class='modal-header'>
                                        <h2 class='mx-auto'>Resultado da Análise Léxica</h2>
                                        <span class='close-button' onclick='closeModal2()'>&times;</span>
                                    </div>
                                </div>
                                <div id='csvData2' class='modal-table'>
                                    <!-- Conteúdo da tabela aqui -->
                                </div>
                                <button id='downloadResultadoAnaliseLexica'>Baixar Tabela</button>
                            </div>
                        </div>
                        
                        <div id='mensagemCarregando' style='display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: rgba(255, 255, 255, 0.7); padding: 20px; border-radius: 5px; z-index: 9999;'>Carregando...Aguarde!</div>   
                    </body>
                </html>
                ";
        
        
        return $oTela;
        
    }

    /**
     * Função que realiza a leitura para retornar caso já exista os arquivos pré-carregados no sistema
     * @param type $sNome
     * @return string
     */
    function retornaTexto($sNome) {
        // Verifica se o arquivo existe
        if (file_exists($sNome)) {
            // Lê o conteúdo do arquivo e retorna
            return file_get_contents($sNome);
        } else {
            return "";
        }
    }
}
