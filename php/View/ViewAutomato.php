<?php

class ViewAutomato {

    /**
     * Método responsável por montar a página em html do automato
     * @return string
     */
    public function montaPaginaAutomato2($aEstadosTransicoes, $aTabelaDeTokens) {

        //Cabeçalho da página
        $sHtmlTela = ' <!DOCTYPE html>
                        <html lang="pt-BR">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Desenhar e Conectar Círculos</title>
                                <style>
                                    #canvas { border: 1px solid #000; cursor: pointer; }
                                </style>
                            </head>
                            <br>
                            <br>';

        //    // Calcula o número total de círculos e o número de linhas
        $numStates = count($aTabelaDeTokens);
        $numRows = 5; // Fixa o número de linhas em 5
        // Calcula a largura necessária para o canvas
        $canvasWidth = 100 + ceil($numStates / $numRows) * 100; // Espaço para o primeiro círculo + número de colunas * espaço entre círculos
        if ($canvasWidth < 700) {
            $canvasWidth = 700;
        }

        //Define o canvas para desenho dos círculos
        $sHtmlTela .= ' <body style="text-align:center">
                                <canvas id="canvas" width="' . $canvasWidth . '" height="700"></canvas>';

        //Script que renderiza a parte inicial do canvas
        $sHtmlTela .= ' <script>
                                    // Obtém o elemento canvas e seu contexto
                                    var canvas = document.getElementById("canvas");
                                    var ctx = canvas.getContext("2d");';

        foreach ($aTabelaDeTokens as $iKey => $sVal) {

            //Aqui desenha os círculos
            //Define as cordenaas iniciais dos círculos
            $sHtmlTela .= '         // Define as coordenadas dos círculos e seus rótulos
                                    var circle' . $iKey . ' = { x: 100+' . ($iKey * 50) . ', y: 100+' . ($iKey * 50) . ', radius: 20, isDragging: false, label: "q' . $iKey . '" };
            
//                                    var circle2 = { x: 300, y: 100, radius: 20, isDragging: false, label: "q1" };
//                                    var circle3 = { x: 500, y: 100, radius: 20, isDragging: false, label: "q2" };/////////////////////////////////////////////////////////novo
//                                    var circle4 = { x: 500, y: 150, radius: 20, isDragging: false, label: "q3" } ///PARA DESENHAR UM NOVO CÍRCULO
                      ';
        }

        foreach ($aEstadosTransicoes as $aVal) {


            foreach ($aVal as $iEst => $aExp) {

                //Aqui desenha as linhas e transições
            }
        }



        //Desenha os círculos e suas características
        $sHtmlTela .= '
                                    // Função para desenhar os círculos
                                    function drawCircle(circle) {
                                    
                                        // Desenha o círculo
                                        ctx.beginPath();
                                        ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
                                        ctx.fillStyle = "rgba(0, 149, 221, 0.5)"; // Azul claro para o preenchimento
                                        ctx.fill();
                                        ctx.strokeStyle = "#0095DD"; // Azul para o contorno
                                        ctx.lineWidth = 2;
                                        ctx.stroke();
                                        ctx.closePath();
                      ';

        //Desenha o estado inicial
        $sHtmlTela .= '             // Desenha a flecha apontando para o estado inicial q0
                                        if (circle.label === "q0") {
                                            ctx.beginPath();
                                            ctx.moveTo(circle.x - circle.radius, circle.y);
                                            ctx.lineTo(circle.x - circle.radius - 20, circle.y - 10);
                                            ctx.lineTo(circle.x - circle.radius - 20, circle.y + 10);
                                            ctx.closePath();
                                            ctx.fillStyle = "rgba(200, 200, 200, 0.5)"; // Cinza claro para o preenchimento
                                            ctx.fill();
                                            ctx.strokeStyle = "#0095DD"; // Azul para a borda
                                            ctx.lineWidth = 2;
                                            ctx.stroke();
                                        }
                       ';

        //Desenha a borda dupla do circulo do estado final
        $sHtmlTela .= '                                
                                        // Desenha a borda dupla para o círculo do estado final
                                        if (circle.label === "q2") {
                                            ctx.beginPath();
                                            ctx.arc(circle.x, circle.y, circle.radius - 4, 0, 2 * Math.PI); // Aumenta o raio para a borda dupla
                                            ctx.strokeStyle = "#0095DD"; // Azul para a cor da primeira borda
                                            ctx.lineWidth = 2;
                                            ctx.stroke();
                                            ctx.closePath();
                                        }

        ';

        // Desenha a linha conectando as bordas dos círculos
        $sHtmlTela .= '
                                        // Adiciona o rótulo à linha entre circle1 e circle2
                                        var labelX = (circle1.x + circle2.x) / 2;
                                        var labelY = (circle1.y + circle2.y) / 2;
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Transição", labelX, labelY-10);
                                        ';

        $sHtmlTela .= '
                                        // Adiciona o rótulo à linha entre circle1 e circle2
                                        var labelX = (circle2.x + circle3.x) / 2;
                                        var labelY = (circle2.y + circle3.y) / 2;
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Transição2", labelX, labelY-10);
                                        ';

        // Adiciona um rótulo ao círculo circle1
        $sHtmlTela .= '
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Estado", circle1.x, circle1.y - circle1.radius + 50);
                                        ';

        // Desenha a linha conectando os círculos e adiciona rótulos
        $sHtmlTela .= '
                                        // Desenha a linha conectando circle1 e circle1 (criando uma pétala)
                                        ctx.beginPath();
                                        ctx.moveTo(circle1.x, circle1.y - circle1.radius);
                                        ctx.bezierCurveTo(circle1.x - 50, circle1.y - 70, circle1.x + 50, circle1.y - 70, circle1.x, circle1.y - circle1.radius);
                                        ctx.strokeStyle = "#0095DD"; // Azul para a linha de conexão
                                        ctx.lineWidth = 2;
                                        ctx.stroke();

                                        // Desenha a curva fechada ligando o ponto final da curva ao ponto inicial (o centro do círculo)
                                        //ctx.arc(circle1.x, circle1.y, circle1.radius, Math.PI * 1.75, Math.PI * 1.25, true); // Desenha um arco que fecha a curva
                                        //ctx.stroke();

                                        // Adiciona o rótulo à linha entre circle1 e ele mesmo
                                        var labelX = circle1.x;
                                        var labelY = circle1.y - 80;
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Loop", labelX, labelY);
                                        ';

        //Define as cores e estilo do rótulo
        $sHtmlTela .= '

                                        // Desenha o rótulo
                                        ctx.fillStyle = "#000"; // Cor preta para o texto
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText(circle.label, circle.x, circle.y);
                                    }';

        //Função que redesenha a tela
        $sHtmlTela .= '
                                    // Função para redesenhar toda a tela
                                    function redraw() {
                                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                                        
                                    ';

        foreach ($aTabelaDeTokens as $iKey => $sVal) {
            //Função que redesenha os círculos
            $sHtmlTela .= '             drawCircle(circle' . $iKey . ');                                                              ///PARA DESENHAR UM NOVO CÍRCULO
                                    ';
        }

        //
        $sHtmlTela .= '                            
                                        // Desenha a linha conectando as bordas dos círculos
                                        ctx.beginPath();
                                        ctx.moveTo(circle1.x + circle1.radius * Math.cos(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)), circle1.y + circle1.radius * Math.sin(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)));
                                        ctx.lineTo(circle2.x - circle2.radius * Math.cos(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)), circle2.y - circle2.radius * Math.sin(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)));

                                        // Adiciona a seta na ponta da linha
                                        var arrowSize = 10; // Tamanho da seta
                                        var angle = Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x);
                                        var circle2EdgeX = circle2.x - circle2.radius * Math.cos(angle);
                                        var circle2EdgeY = circle2.y - circle2.radius * Math.sin(angle);
                                        ctx.moveTo(circle2EdgeX, circle2EdgeY);
                                        ctx.lineTo(circle2EdgeX - arrowSize * Math.cos(angle - Math.PI / 6), circle2EdgeY - arrowSize * Math.sin(angle - Math.PI / 6));
                                        ctx.moveTo(circle2EdgeX, circle2EdgeY);
                                        ctx.lineTo(circle2EdgeX - arrowSize * Math.cos(angle + Math.PI / 6), circle2EdgeY - arrowSize * Math.sin(angle + Math.PI / 6));
                                        
                                        // Repete o mesmo processo para a linha entre circle2 e circle3
                                        ctx.moveTo(circle2.x + circle2.radius * Math.cos(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)), circle2.y + circle2.radius * Math.sin(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)));
                                        ctx.lineTo(circle3.x - circle3.radius * Math.cos(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)), circle3.y - circle3.radius * Math.sin(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)));

                                        // Adiciona a seta na ponta da linha entre circle2 e circle3
                                        var angle2 = Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x);
                                        var circle3EdgeX = circle3.x - circle3.radius * Math.cos(angle2);
                                        var circle3EdgeY = circle3.y - circle3.radius * Math.sin(angle2);
                                        ctx.moveTo(circle3EdgeX, circle3EdgeY);
                                        ctx.lineTo(circle3EdgeX - arrowSize * Math.cos(angle2 - Math.PI / 6), circle3EdgeY - arrowSize * Math.sin(angle2 - Math.PI / 6));
                                        ctx.moveTo(circle3EdgeX, circle3EdgeY);
                                        ctx.lineTo(circle3EdgeX - arrowSize * Math.cos(angle2 + Math.PI / 6), circle3EdgeY - arrowSize * Math.sin(angle2 + Math.PI / 6));
                                       
                                        ///////////////////////////////////////////////////////// fim novo
                                        ctx.strokeStyle = "#0095DD"; // Azul para a linha de conexão
                                        ctx.lineWidth = 2;
                                        ctx.stroke();
                                        ctx.closePath();
                                    }

                                    // Função para verificar se o mouse está sobre um círculo
                                    function isMouseOverCircle(mouseX, mouseY, circle) {
                                        var dx = mouseX - circle.x;
                                        var dy = mouseY - circle.y;
                                        return dx * dx + dy * dy < circle.radius * circle.radius;
                                    }

                                    // Evento de clique do mouse
                                    canvas.addEventListener("mousedown", function(event) {
                                        var mouseX = event.clientX - canvas.getBoundingClientRect().left;
                                        var mouseY = event.clientY - canvas.getBoundingClientRect().top;

                                        if (isMouseOverCircle(mouseX, mouseY, circle1)) {
                                            circle1.isDragging = true;
                                        } else if (isMouseOverCircle(mouseX, mouseY, circle2)) {
                                            circle2.isDragging = true;
                                        }else if (isMouseOverCircle(mouseX, mouseY, circle3)) {/////////////////////////////////////////////////////////novo
                                            circle3.isDragging = true;
                                        }
                                    });

                                    // Evento de movimento do mouse
                                    canvas.addEventListener("mousemove", function(event) {
                                        if (circle1.isDragging) {
                                            circle1.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle1.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        } else if (circle2.isDragging) {
                                            circle2.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle2.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        }else if (circle3.isDragging) {/////////////////////////////////////////////////////////novo
                                            circle3.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle3.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        }
                                    });

                                    // Evento de soltar o botão do mouse
                                    canvas.addEventListener("mouseup", function() {
                                        circle1.isDragging = false;
                                        circle2.isDragging = false;
                                        circle3.isDragging = false;/////////////////////////////////////////////////////////novo
                                    });

                                    // Desenhar os círculos pela primeira vez
                                    redraw();
                                    
                                </script>';

        //Finalização do HTML
        $sHtmlTela .= '    </body>
                        </html>';

        return $sHtmlTela;
    }

    /**
     * Retorna array da quantidade de níveis/colunas e a quantidade de estados diferentes por nível
     * @param type $aEstadosTransicoes
     * @return int
     */
    public function retornaNiveisQntEst($aEstadosTransicoes) {

        //Array da quantidade de níveis e a quantidade de estados diferentes por nível
        $aArrayNiveisQntEst = array();
        //Contador de estados diferentes por nível
        $iQntEst = 0;
        //Contador de niveis
        $iQuant = 0;
        //Controlador
        $iK = 0;
        //Estado maior controlador de níveis
        $iEstCount = 0;
        foreach ($aEstadosTransicoes as $iKey => $aVal) {
            foreach ($aVal as $iEst => $aExp) {
                if ($iK == 0 || $iK < $iEst) {
                    $iK = $iEst;
                    if($iEst>$iKey) {//&& $iK!=0
                        $iQntEst++;
                    }
                }
            }
            if ($iEstCount == 0 || $iKey > $iEstCount - 1) {
                $iQuant++;
                $aArrayNiveisQntEst[$iQuant] = $iQntEst;
                $iEstCount = $iK;
                $iK = 0;
                $iQntEst = 0;
            }
        }
        return $aArrayNiveisQntEst;
    }

    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {

        // Calcula o número total de círculos
        $numStates = count($aTabelaDeTokens);
        //Retorna os níveis de expansão do automato sendo assim o número de colunas do automato e a quantidade de estados de cada nível
        $aNiveisQntEst = $this->retornaNiveisQntEst($aEstadosTransicoes);
        //Numero de colunas com base nos níveis do automato
        $numColumns = count($aNiveisQntEst);
        // Número de linhas com base no estado 0 que é o com maior saída de transições
        $numRows = count($aEstadosTransicoes[0]);
        // Calcula a largura necessária para o canvas
        $canvasWidth = 50 + $numColumns * 200; // Espaço para o primeiro círculo + número de colunas * espaço entre círculos
        if ($canvasWidth < 700) {
            $canvasWidth = 700;
        }

        // Cabeçalho da página
        $sHtmlTela = '<!DOCTYPE html>
                    <html lang="pt-BR">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Desenhar e Conectar Círculos</title>
                            <style>
                                #canvas { border: 1px solid #000; cursor: pointer; }
                            </style>
                        </head>
                        <body style="text-align:center">
                            <canvas id="canvas" width="' . $canvasWidth . '" height="700"></canvas>
                            <script>
                    ';
        //Inicia as variáveis
        $sHtmlTela .= '         var canvas = document.getElementById("canvas");
                                var ctx = canvas.getContext("2d");
                                var circles = [];
                                var numRows = ' . $numRows . '; // Número de linhas
                                var numColumns = ' . $numColumns . '; // Número de colunas
                                var circleRadius = 20; // Raio do círculo
                                var circleSpacingX = 120; // Espaçamento horizontal entre os círculos
                                var circleSpacingY = canvas.height / (numRows + 1); // Espaçamento vertical entre os círculos
                        ';
        $sHtmlTela .= '         // Função para verificar se o mouse está sobre um círculo
                                function isMouseOverCircle(mouseX, mouseY, circle) {
                                    var dx = mouseX - circle.x;
                                    var dy = mouseY - circle.y;
                                    return dx * dx + dy * dy < circle.radius * circle.radius;
                                }
                        ';
        $sHtmlTela .= '                        
                                // Evento de clique do mouse
                                canvas.addEventListener("mousedown", function(event) {
                                    var mouseX = event.clientX - canvas.getBoundingClientRect().left;
                                    var mouseY = event.clientY - canvas.getBoundingClientRect().top;

                                    circles.forEach(function(circle) {
                                        if (isMouseOverCircle(mouseX, mouseY, circle)) {
                                            circle.isDragging = true;
                                        }
                                    });
                                });
                        ';
        $sHtmlTela .= ' 
                                // Evento de movimento do mouse
                                canvas.addEventListener("mousemove", function(event) {
                                    circles.forEach(function(circle) {
                                        if (circle.isDragging) {
                                            circle.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        }
                                    });
                                });

                                // Evento de soltar o botão do mouse
                                canvas.addEventListener("mouseup", function() {
                                    circles.forEach(function(circle) {
                                        circle.isDragging = false;
                                    });
                                });
                        ';
        $sHtmlTela .= '         
                                // Função para desenhar os círculos
                                function drawCircle(circle) {
                                    ctx.beginPath();
                                    ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
                                    ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
                                    ctx.fill();
                                    ctx.strokeStyle = "#0095DD";
                                    ctx.lineWidth = 2;
                                    ctx.stroke();
                                    ctx.closePath();

                                    ctx.fillStyle = "#000";
                                    ctx.font = "12px Arial";
                                    ctx.textAlign = "center";
                                    ctx.textBaseline = "middle";
                                    ctx.fillText(circle.label, circle.x, circle.y);
                                }
                        ';
        $sHtmlTela .= '         
                                // Função para redesenhar toda a tela
                                function redraw() {
                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                                    circles.forEach(function(circle) {
                                        drawCircle(circle);
                                    });
                                }
                        ';
        $sHtmlTela .= ' 
                                // Adiciona o estado q0 separadamente
                                circles.push({ x: circleSpacingX, y: canvas.height / 2, radius: circleRadius, label: "q0" });
                        ';
        $sHtmlTela .= ' 
                                // Loop para adicionar os outros estados
                                for (var i = 1; i < ' . $numStates . '; i++) {
                                    var row = (i - 1) % numRows;
                                    var col = Math.floor((i - 1) / numRows);
                                    var x = circleSpacingX * (col + 2); // Começa da segunda coluna
                                    var y = circleSpacingY * (row + 1);
                                    circles.push({ x: x, y: y, radius: circleRadius, label: "q" + i });
                                }


                                // Desenhar os círculos pela primeira vez
                                redraw();
                            </script>
                        </body>
                    </html>';

        return $sHtmlTela;
    }

    //    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//        // Calcula o número total de círculos e o número de linhas
//        $numStates = count($aTabelaDeTokens);
//        $numColumns = min(5, ceil($numStates / 5)); // Número máximo de colunas é 5
//        $numRows = 5; // Número fixo de linhas
//        // Calcula a largura necessária para o canvas
//        $canvasWidth = 100 + $numColumns * 200; // Espaço para o primeiro círculo + número de colunas * espaço entre círculos
//        if ($canvasWidth < 700) {
//            $canvasWidth = 700;
//        }
//
//        // Cabeçalho da página
//        $sHtmlTela = '<!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="' . $canvasWidth . '" height="700"></canvas>
//                            <script>
//                                var canvas = document.getElementById("canvas");
//                                var ctx = canvas.getContext("2d");
//                                var circles = [];
//                                var numRows = ' . $numRows . '; // Número de linhas
//                                var numColumns = ' . $numColumns . '; // Número de colunas
//                                var circleRadius = 20; // Raio do círculo
//                                var circleSpacingX = 120; // Espaçamento horizontal entre os círculos
//                                var circleSpacingY = canvas.height / (numRows + 1); // Espaçamento vertical entre os círculos
//                        ';
//        $sHtmlTela .= '         // Função para verificar se o mouse está sobre um círculo
//                                function isMouseOverCircle(mouseX, mouseY, circle) {
//                                    var dx = mouseX - circle.x;
//                                    var dy = mouseY - circle.y;
//                                    return dx * dx + dy * dy < circle.radius * circle.radius;
//                                }
//                        ';
//        $sHtmlTela .= '                        
//                                // Evento de clique do mouse
//                                canvas.addEventListener("mousedown", function(event) {
//                                    var mouseX = event.clientX - canvas.getBoundingClientRect().left;
//                                    var mouseY = event.clientY - canvas.getBoundingClientRect().top;
//
//                                    circles.forEach(function(circle) {
//                                        if (isMouseOverCircle(mouseX, mouseY, circle)) {
//                                            circle.isDragging = true;
//                                        }
//                                    });
//                                });
//                        ';
//        $sHtmlTela .= ' 
//                                // Evento de movimento do mouse
//                                canvas.addEventListener("mousemove", function(event) {
//                                    circles.forEach(function(circle) {
//                                        if (circle.isDragging) {
//                                            circle.x = event.clientX - canvas.getBoundingClientRect().left;
//                                            circle.y = event.clientY - canvas.getBoundingClientRect().top;
//                                            redraw();
//                                        }
//                                    });
//                                });
//
//                                // Evento de soltar o botão do mouse
//                                canvas.addEventListener("mouseup", function() {
//                                    circles.forEach(function(circle) {
//                                        circle.isDragging = false;
//                                    });
//                                });
//                        ';
//        $sHtmlTela .= '         
//                                // Função para desenhar os círculos
//                                function drawCircle(circle) {
//                                    ctx.beginPath();
//                                    ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
//                                    ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                                    ctx.fill();
//                                    ctx.strokeStyle = "#0095DD";
//                                    ctx.lineWidth = 2;
//                                    ctx.stroke();
//                                    ctx.closePath();
//
//                                    ctx.fillStyle = "#000";
//                                    ctx.font = "12px Arial";
//                                    ctx.textAlign = "center";
//                                    ctx.textBaseline = "middle";
//                                    ctx.fillText(circle.label, circle.x, circle.y);
//                                }
//                        ';
//        $sHtmlTela .= '         
//                                // Função para redesenhar toda a tela
//                                function redraw() {
//                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
//                                    circles.forEach(function(circle) {
//                                        drawCircle(circle);
//                                    });
//                                }
//                        ';
//        $sHtmlTela .= ' 
//                                // Adiciona o estado q0 separadamente
//                                circles.push({ x: circleSpacingX, y: canvas.height / 2, radius: circleRadius, label: "q0" });
//                        ';
//        $sHtmlTela .= ' 
//                                // Loop para adicionar os outros estados
//                                for (var i = 1; i < ' . $numStates . '; i++) {
//                                    var row = (i - 1) % numRows;
//                                    var col = Math.floor((i - 1) / numRows);
//                                    var x = circleSpacingX * (col + 2); // Começa da segunda coluna
//                                    var y = circleSpacingY * (row + 1);
//                                    circles.push({ x: x, y: y, radius: circleRadius, label: "q" + i });
//                                }
//
//
//                                // Desenhar os círculos pela primeira vez
//                                redraw();
//                            </script>
//                        </body>
//                    </html>';
//
//        return $sHtmlTela;
//    }
//    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//
//    // Calcula o número total de círculos e o número de linhas
//    $numStates = count($aTabelaDeTokens);
//    $numRows = 5; // Fixa o número de linhas em 5
//
//    // Calcula a largura necessária para o canvas
//    $canvasWidth = 100 + ceil($numStates / $numRows) * 100; // Espaço para o primeiro círculo + número de colunas * espaço entre círculos
//
//    // Cabeçalho da página
//    $sHtmlTela = '<!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="' . $canvasWidth . '" height="700"></canvas>
//                            <script>
//                                var canvas = document.getElementById("canvas");
//                                var ctx = canvas.getContext("2d");
//                                var circles = [];
//                                var numRows = ' . $numRows . '; // Número de linhas
//                                var circleRadius = 20; // Raio do círculo
//                                var circleSpacingX = 100; // Espaçamento horizontal entre os círculos
//                                var circleSpacingY = canvas.height / (numRows + 1); // Espaçamento vertical entre os círculos
//
//                                // Loop para desenhar os círculos
//                                for (var i = 0; i < ' . $numStates . '; i++) {
//                                    var row = i % numRows;
//                                    var col = Math.floor(i / numRows);
//                                    var x = circleSpacingX * (col + 1);
//                                    var y = circleSpacingY * (row + 1);
//                                    circles.push({ x: x, y: y, radius: circleRadius, label: "q" + i });
//                                }
//
//                                // Função para desenhar os círculos
//                                function drawCircle(circle) {
//                                    ctx.beginPath();
//                                    ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
//                                    ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                                    ctx.fill();
//                                    ctx.strokeStyle = "#0095DD";
//                                    ctx.lineWidth = 2;
//                                    ctx.stroke();
//                                    ctx.closePath();
//
//                                    ctx.fillStyle = "#000";
//                                    ctx.font = "12px Arial";
//                                    ctx.textAlign = "center";
//                                    ctx.textBaseline = "middle";
//                                    ctx.fillText(circle.label, circle.x, circle.y);
//                                }
//
//                                // Função para redesenhar toda a tela
//                                function redraw() {
//                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
//                                    circles.forEach(function(circle) {
//                                        drawCircle(circle);
//                                    });
//                                }
//
//                                // Desenhar os círculos pela primeira vez
//                                redraw();
//                            </script>
//                        </body>
//                    </html>';
//
//    return $sHtmlTela;
//}
//    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//        // Calcula o número total de círculos e o número de linhas
//        $numStates = count($aTabelaDeTokens);
//        $numColumns = min(5, ceil($numStates / 5)); // Número máximo de colunas é 5
//        $numRows = 5; // Número fixo de linhas
//        // Calcula a largura necessária para o canvas
//        $canvasWidth = 100 + $numColumns * 200; // Espaço para o primeiro círculo + número de colunas * espaço entre círculos
//        if ($canvasWidth < 700) {
//            $canvasWidth = 700;
//        }
//
//        // Cabeçalho da página
//        $sHtmlTela = '<!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="' . $canvasWidth . '" height="700"></canvas>
//                            <script>
//                                var canvas = document.getElementById("canvas");
//                                var ctx = canvas.getContext("2d");
//                                var circles = [];
//                                var numRows = ' . $numRows . '; // Número de linhas
//                                var numColumns = ' . $numColumns . '; // Número de colunas
//                                var circleRadius = 20; // Raio do círculo
//                                var circleSpacingX = 120; // Espaçamento horizontal entre os círculos
//                                var circleSpacingY = canvas.height / (numRows + 1); // Espaçamento vertical entre os círculos
//                        ';
//        $sHtmlTela .= '         // Função para verificar se o mouse está sobre um círculo
//                                function isMouseOverCircle(mouseX, mouseY, circle) {
//                                    var dx = mouseX - circle.x;
//                                    var dy = mouseY - circle.y;
//                                    return dx * dx + dy * dy < circle.radius * circle.radius;
//                                }
//                        ';
//        $sHtmlTela .= '                        
//                                // Evento de clique do mouse
//                                canvas.addEventListener("mousedown", function(event) {
//                                    var mouseX = event.clientX - canvas.getBoundingClientRect().left;
//                                    var mouseY = event.clientY - canvas.getBoundingClientRect().top;
//
//                                    circles.forEach(function(circle) {
//                                        if (isMouseOverCircle(mouseX, mouseY, circle)) {
//                                            circle.isDragging = true;
//                                        }
//                                    });
//                                });
//                        ';
//        $sHtmlTela .= ' 
//                                // Evento de movimento do mouse
//                                canvas.addEventListener("mousemove", function(event) {
//                                    circles.forEach(function(circle) {
//                                        if (circle.isDragging) {
//                                            circle.x = event.clientX - canvas.getBoundingClientRect().left;
//                                            circle.y = event.clientY - canvas.getBoundingClientRect().top;
//                                            redraw();
//                                        }
//                                    });
//                                });
//
//                                // Evento de soltar o botão do mouse
//                                canvas.addEventListener("mouseup", function() {
//                                    circles.forEach(function(circle) {
//                                        circle.isDragging = false;
//                                    });
//                                });
//                        ';
//        $sHtmlTela .= '         
//                                // Função para desenhar os círculos
//                                function drawCircle(circle) {
//                                    ctx.beginPath();
//                                    ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
//                                    ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                                    ctx.fill();
//                                    ctx.strokeStyle = "#0095DD";
//                                    ctx.lineWidth = 2;
//                                    ctx.stroke();
//                                    ctx.closePath();
//
//                                    ctx.fillStyle = "#000";
//                                    ctx.font = "12px Arial";
//                                    ctx.textAlign = "center";
//                                    ctx.textBaseline = "middle";
//                                    ctx.fillText(circle.label, circle.x, circle.y);
//                                }
//                        ';
//        $sHtmlTela .= '         
//                                // Função para redesenhar toda a tela
//                                function redraw() {
//                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
//                                    circles.forEach(function(circle) {
//                                        drawCircle(circle);
//                                    });
//                                }
//                        ';
//        $sHtmlTela .= ' 
//                                // Adiciona o estado q0 separadamente
//                                circles.push({ x: circleSpacingX, y: canvas.height / 2, radius: circleRadius, label: "q0" });
//                        ';
//        $sHtmlTela .= ' 
//                                // Loop para adicionar os outros estados
//                                for (var i = 1; i < ' . $numStates . '; i++) {
//                                    var row = (i - 1) % numRows;
//                                    var col = Math.floor((i - 1) / numRows);
//                                    var x = circleSpacingX * (col + 2); // Começa da segunda coluna
//                                    var y = circleSpacingY * (row + 1);
//                                    circles.push({ x: x, y: y, radius: circleRadius, label: "q" + i });
//                                }
//
//
//                                // Desenhar os círculos pela primeira vez
//                                redraw();
//                            </script>
//                        </body>
//                    </html>';
//
//        return $sHtmlTela;
//    }
//    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//
//    // Calcula o número total de círculos e o número de linhas
//    $numStates = count($aTabelaDeTokens);
//    $numRows = 5; // Fixa o número de linhas em 5
//
//    // Calcula a largura necessária para o canvas
//    $canvasWidth = 100 + ceil($numStates / $numRows) * 100; // Espaço para o primeiro círculo + número de colunas * espaço entre círculos
//
//    // Cabeçalho da página
//    $sHtmlTela = '<!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="' . $canvasWidth . '" height="700"></canvas>
//                            <script>
//                                var canvas = document.getElementById("canvas");
//                                var ctx = canvas.getContext("2d");
//                                var circles = [];
//                                var numRows = ' . $numRows . '; // Número de linhas
//                                var circleRadius = 20; // Raio do círculo
//                                var circleSpacingX = 100; // Espaçamento horizontal entre os círculos
//                                var circleSpacingY = canvas.height / (numRows + 1); // Espaçamento vertical entre os círculos
//
//                                // Loop para desenhar os círculos
//                                for (var i = 0; i < ' . $numStates . '; i++) {
//                                    var row = i % numRows;
//                                    var col = Math.floor(i / numRows);
//                                    var x = circleSpacingX * (col + 1);
//                                    var y = circleSpacingY * (row + 1);
//                                    circles.push({ x: x, y: y, radius: circleRadius, label: "q" + i });
//                                }
//
//                                // Função para desenhar os círculos
//                                function drawCircle(circle) {
//                                    ctx.beginPath();
//                                    ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
//                                    ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                                    ctx.fill();
//                                    ctx.strokeStyle = "#0095DD";
//                                    ctx.lineWidth = 2;
//                                    ctx.stroke();
//                                    ctx.closePath();
//
//                                    ctx.fillStyle = "#000";
//                                    ctx.font = "12px Arial";
//                                    ctx.textAlign = "center";
//                                    ctx.textBaseline = "middle";
//                                    ctx.fillText(circle.label, circle.x, circle.y);
//                                }
//
//                                // Função para redesenhar toda a tela
//                                function redraw() {
//                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
//                                    circles.forEach(function(circle) {
//                                        drawCircle(circle);
//                                    });
//                                }
//
//                                // Desenhar os círculos pela primeira vez
//                                redraw();
//                            </script>
//                        </body>
//                    </html>';
//
//    return $sHtmlTela;
//}
//
//public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//
//    //Cabeçalho da página
//    $sHtmlTela = ' <!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="700" height="700"></canvas>
//                            <script>
//                                var canvas = document.getElementById("canvas");
//                                var ctx = canvas.getContext("2d");
//                                var circles = [];
//                                var numRows = ' . ceil(count($aTabelaDeTokens) / 5) . '; // Define o número de linhas
//                                var circleRadius = 20; // Raio do círculo
//                                var circleSpacingX = canvas.width / 6; // Espaçamento horizontal entre os círculos
//                                var circleSpacingY = canvas.height / (numRows + 1); // Espaçamento vertical entre os círculos
//
//                                // Loop para desenhar os círculos
//                                for (var i = 0; i < ' . count($aTabelaDeTokens) . '; i++) {
//                                    var row = Math.floor(i / 5);
//                                    var col = i % 5;
//                                    var x = circleSpacingX * (col + 1);
//                                    var y = circleSpacingY * (row + 1);
//                                    circles.push({ x: x, y: y, radius: circleRadius, label: "q" + i });
//                                }
//
//                                // Função para desenhar os círculos
//                                function drawCircle(circle) {
//                                    ctx.beginPath();
//                                    ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
//                                    ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                                    ctx.fill();
//                                    ctx.strokeStyle = "#0095DD";
//                                    ctx.lineWidth = 2;
//                                    ctx.stroke();
//                                    ctx.closePath();
//
//                                    ctx.fillStyle = "#000";
//                                    ctx.font = "12px Arial";
//                                    ctx.textAlign = "center";
//                                    ctx.textBaseline = "middle";
//                                    ctx.fillText(circle.label, circle.x, circle.y);
//                                }
//
//                                // Função para redesenhar toda a tela
//                                function redraw() {
//                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
//                                    circles.forEach(function(circle) {
//                                        drawCircle(circle);
//                                    });
//                                }
//
//                                // Desenhar os círculos pela primeira vez
//                                redraw();
//                            </script>
//                        </body>
//                    </html>';
//
//    return $sHtmlTela;
//}
//    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//
//    //Cabeçalho da página
//    $sHtmlTela = '<!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="700" height="700"></canvas>';
//
//    //Script que renderiza a parte inicial do canvas
//    $sHtmlTela .= '<script>
//                        // Obtém o elemento canvas e seu contexto
//                        var canvas = document.getElementById("canvas");
//                        var ctx = canvas.getContext("2d");
//
//                        // Função para desenhar um círculo
//                        function drawCircle(x, y, radius, label) {
//                            ctx.beginPath();
//                            ctx.arc(x, y, radius, 0, 2 * Math.PI);
//                            ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                            ctx.fill();
//                            ctx.strokeStyle = "#0095DD";
//                            ctx.lineWidth = 2;
//                            ctx.stroke();
//                            ctx.closePath();
//
//                            // Adiciona o rótulo ao círculo
//                            ctx.fillStyle = "#000";
//                            ctx.font = "12px Arial";
//                            ctx.textAlign = "center";
//                            ctx.textBaseline = "middle";
//                            ctx.fillText(label, x, y);
//                        }
//
//                        // Função para desenhar uma linha entre dois círculos
//                        function drawLine(x1, y1, x2, y2) {
//                            ctx.beginPath();
//                            ctx.moveTo(x1, y1);
//                            ctx.lineTo(x2, y2);
//                            ctx.strokeStyle = "#0095DD";
//                            ctx.lineWidth = 2;
//                            ctx.stroke();
//                            ctx.closePath();
//                        }
//
//                        // Função para desenhar a página inteira
//                        function drawPage() {
//                            // Limpa o canvas
//                            ctx.clearRect(0, 0, canvas.width, canvas.height);
//
//                            // Calcula a posição inicial para os círculos
//                            var centerX = canvas.width / 2;
//                            var centerY = canvas.height / 2;
//                            var radius = 150;
//                            var numCircles = ' . count($aTabelaDeTokens) . ';
//
//                            // Desenha os círculos
//                            for (var i = 0; i < numCircles; i++) {
//                                var angle = i * (2 * Math.PI / numCircles);
//                                var x = centerX + radius * Math.cos(angle);
//                                var y = centerY + radius * Math.sin(angle);
//                                drawCircle(x, y, 20, "q" + i);
//                            }
//
//                            // Desenha as transições entre os círculos
//                            // Aqui você precisará adicionar o código para desenhar as linhas de transição
//
//                            // Exemplo: desenha uma linha do primeiro para o segundo círculo
//                            // drawLine(centerX, centerY, centerX + radius, centerY);
//                        }
//
//                        // Chama a função para desenhar a página quando a janela é carregada
//                        window.onload = drawPage;
//                    </script>';
//
//    //Finalização do HTML
//    $sHtmlTela .= '</body>
//                    </html>';
//
//    return $sHtmlTela;
//}
//    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {
//
//    //Cabeçalho da página
//    $sHtmlTela = '<!DOCTYPE html>
//                    <html lang="pt-BR">
//                        <head>
//                            <meta charset="UTF-8">
//                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                            <title>Desenhar e Conectar Círculos</title>
//                            <style>
//                                #canvas { border: 1px solid #000; cursor: pointer; }
//                            </style>
//                        </head>
//                        <body style="text-align:center">
//                            <canvas id="canvas" width="700" height="700"></canvas>';
//
//    //Script que renderiza a parte inicial do canvas
//    $sHtmlTela .= '<script>
//                        // Obtém o elemento canvas e seu contexto
//                        var canvas = document.getElementById("canvas");
//                        var ctx = canvas.getContext("2d");
//
//                        // Estrutura de dados para os círculos em formato de árvore
//                        var circlesTree = [
//                            { label: "q0", children: [1, 2] },
//                            { label: "q1", children: [3] },
//                            { label: "q2", children: [] },
//                            { label: "q3", children: [] }
//                            // Adicione mais círculos e seus filhos conforme necessário
//                        ];
//
//                        // Função para desenhar um círculo
//                        function drawCircle(x, y, radius, label) {
//                            ctx.beginPath();
//                            ctx.arc(x, y, radius, 0, 2 * Math.PI);
//                            ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                            ctx.fill();
//                            ctx.strokeStyle = "#0095DD";
//                            ctx.lineWidth = 2;
//                            ctx.stroke();
//                            ctx.closePath();
//
//                            // Adiciona o rótulo ao círculo
//                            ctx.fillStyle = "#000";
//                            ctx.font = "12px Arial";
//                            ctx.textAlign = "center";
//                            ctx.textBaseline = "middle";
//                            ctx.fillText(label, x, y);
//                        }
//
//                        // Função para desenhar uma linha entre dois círculos
//                        function drawLine(x1, y1, x2, y2) {
//                            ctx.beginPath();
//                            ctx.moveTo(x1, y1);
//                            ctx.lineTo(x2, y2);
//                            ctx.strokeStyle = "#0095DD";
//                            ctx.lineWidth = 2;
//                            ctx.stroke();
//                            ctx.closePath();
//                        }
//
//                        // Função para desenhar a árvore de círculos
//                        function drawTree() {
//                            // Calcula a posição inicial para o primeiro círculo
//                            var startX = canvas.width / 2;
//                            var startY = 100;
//                            var radius = 20;
//
//                            // Define a distância horizontal entre os círculos
//                            var horizontalSpacing = 100;
//
//                            // Função recursiva para desenhar a árvore
//                            function drawNode(node, x, y) {
//                                // Desenha o círculo atual
//                                drawCircle(x, y, radius, node.label);
//
//                                // Desenha linhas para os filhos e chama a função recursivamente para cada filho
//                                var numChildren = node.children.length;
//                                for (var i = 0; i < numChildren; i++) {
//                                    var childX = startX + i * horizontalSpacing - (numChildren - 1) * horizontalSpacing / 2;
//                                    var childY = y + 50;
//                                    drawLine(x, y + radius, childX, childY);
//                                    drawNode(circlesTree[node.children[i]], childX, childY);
//                                }
//                            }
//
//                            // Chama a função para desenhar a árvore a partir do nó raiz
//                            drawNode(circlesTree[0], startX, startY);
//                        }
//
//                        // Chama a função para desenhar a árvore quando a janela é carregada
//                        window.onload = drawTree;
//                    </script>';
//
//    //Finalização do HTML
//    $sHtmlTela .= '</body>
//                    </html>';
//
//    return $sHtmlTela;
//}

    /**
     * Método responsável por montar a página em html do automato
     * @return string
     */
    public function montaPaginaAutomatoBKP($aEstadosTransicoes, $aTabelaDeTokens) {

        //Cabeçalho da página
        $sHtmlTela = ' <!DOCTYPE html>
                        <html lang="pt-BR">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Desenhar e Conectar Círculos</title>
                                <style>
                                    #canvas { border: 1px solid #000; cursor: pointer; }
                                </style>
                            </head>
                            <br>
                            <br>';

        //Define o canvas para desenho dos círculos
        $sHtmlTela .= ' <body style="text-align:center">
                                <canvas id="canvas" width="700" height="700"></canvas>';

        //Script que renderiza a parte inicial do canvas
        $sHtmlTela .= ' <script>
                                    // Obtém o elemento canvas e seu contexto
                                    var canvas = document.getElementById("canvas");
                                    var ctx = canvas.getContext("2d");';

        //Define as cordenaas iniciais dos círculos
        $sHtmlTela .= '             // Define as coordenadas dos círculos e seus rótulos
                                    var circle1 = { x: 100, y: 100, radius: 20, isDragging: false, label: "q0" };
                                    var circle2 = { x: 300, y: 100, radius: 20, isDragging: false, label: "q1" };
                                    var circle3 = { x: 500, y: 100, radius: 20, isDragging: false, label: "q2" };/////////////////////////////////////////////////////////novo
                        //            var circle4 = { x: 500, y: 150, radius: 20, isDragging: false, label: "q3" } ///PARA DESENHAR UM NOVO CÍRCULO
                      ';

        //Desenha os círculos e suas características
        $sHtmlTela .= '
                                    // Função para desenhar os círculos
                                    function drawCircle(circle) {
                                    
                                        // Desenha o círculo
                                        ctx.beginPath();
                                        ctx.arc(circle.x, circle.y, circle.radius, 0, 2 * Math.PI);
                                        ctx.fillStyle = "rgba(0, 149, 221, 0.5)"; // Azul claro para o preenchimento
                                        ctx.fill();
                                        ctx.strokeStyle = "#0095DD"; // Azul para o contorno
                                        ctx.lineWidth = 2;
                                        ctx.stroke();
                                        ctx.closePath();
                      ';

        //Desenha o estado inicial
        $sHtmlTela .= '             // Desenha a flecha apontando para o estado inicial q0
                                        if (circle.label === "q0") {
                                            ctx.beginPath();
                                            ctx.moveTo(circle.x - circle.radius, circle.y);
                                            ctx.lineTo(circle.x - circle.radius - 20, circle.y - 10);
                                            ctx.lineTo(circle.x - circle.radius - 20, circle.y + 10);
                                            ctx.closePath();
                                            ctx.fillStyle = "rgba(200, 200, 200, 0.5)"; // Cinza claro para o preenchimento
                                            ctx.fill();
                                            ctx.strokeStyle = "#0095DD"; // Azul para a borda
                                            ctx.lineWidth = 2;
                                            ctx.stroke();
                                        }
                       ';

        //Desenha a borda dupla do circulo do estado final
        $sHtmlTela .= '                                
                                        // Desenha a borda dupla para o círculo do estado final
                                        if (circle.label === "q2") {
                                            ctx.beginPath();
                                            ctx.arc(circle.x, circle.y, circle.radius - 4, 0, 2 * Math.PI); // Aumenta o raio para a borda dupla
                                            ctx.strokeStyle = "#0095DD"; // Azul para a cor da primeira borda
                                            ctx.lineWidth = 2;
                                            ctx.stroke();
                                            ctx.closePath();
                                        }

        ';

        // Desenha a linha conectando as bordas dos círculos
        $sHtmlTela .= '
                                        // Adiciona o rótulo à linha entre circle1 e circle2
                                        var labelX = (circle1.x + circle2.x) / 2;
                                        var labelY = (circle1.y + circle2.y) / 2;
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Transição", labelX, labelY-10);
                                        ';

        $sHtmlTela .= '
                                        // Adiciona o rótulo à linha entre circle1 e circle2
                                        var labelX = (circle2.x + circle3.x) / 2;
                                        var labelY = (circle2.y + circle3.y) / 2;
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Transição2", labelX, labelY-10);
                                        ';

        // Adiciona um rótulo ao círculo circle1
        $sHtmlTela .= '
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Estado", circle1.x, circle1.y - circle1.radius + 50);
                                        ';

        // Desenha a linha conectando os círculos e adiciona rótulos
        $sHtmlTela .= '
                                        // Desenha a linha conectando circle1 e circle1 (criando uma pétala)
                                        ctx.beginPath();
                                        ctx.moveTo(circle1.x, circle1.y - circle1.radius);
                                        ctx.bezierCurveTo(circle1.x - 50, circle1.y - 70, circle1.x + 50, circle1.y - 70, circle1.x, circle1.y - circle1.radius);
                                        ctx.strokeStyle = "#0095DD"; // Azul para a linha de conexão
                                        ctx.lineWidth = 2;
                                        ctx.stroke();

                                        // Desenha a curva fechada ligando o ponto final da curva ao ponto inicial (o centro do círculo)
                                        //ctx.arc(circle1.x, circle1.y, circle1.radius, Math.PI * 1.75, Math.PI * 1.25, true); // Desenha um arco que fecha a curva
                                        //ctx.stroke();

                                        // Adiciona o rótulo à linha entre circle1 e ele mesmo
                                        var labelX = circle1.x;
                                        var labelY = circle1.y - 80;
                                        ctx.fillStyle = "#000";
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText("Loop", labelX, labelY);
                                        ';

        //Define as cores e estilo do rótulo
        $sHtmlTela .= '

                                        // Desenha o rótulo
                                        ctx.fillStyle = "#000"; // Cor preta para o texto
                                        ctx.font = "12px Arial";
                                        ctx.textAlign = "center";
                                        ctx.textBaseline = "middle";
                                        ctx.fillText(circle.label, circle.x, circle.y);
                                    }

                                    // Função para redesenhar toda a tela
                                    function redraw() {
                                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                                        drawCircle(circle1);
                                        drawCircle(circle2);
                                        drawCircle(circle3);/////////////////////////////////////////////////////////novo
                                    //    drawCircle(circle4);                                                               ///PARA DESENHAR UM NOVO CÍRCULO

                                        // Desenha a linha conectando as bordas dos círculos
                                        ctx.beginPath();
                                        ctx.moveTo(circle1.x + circle1.radius * Math.cos(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)), circle1.y + circle1.radius * Math.sin(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)));
                                        ctx.lineTo(circle2.x - circle2.radius * Math.cos(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)), circle2.y - circle2.radius * Math.sin(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)));

                                        // Adiciona a seta na ponta da linha
                                        var arrowSize = 10; // Tamanho da seta
                                        var angle = Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x);
                                        var circle2EdgeX = circle2.x - circle2.radius * Math.cos(angle);
                                        var circle2EdgeY = circle2.y - circle2.radius * Math.sin(angle);
                                        ctx.moveTo(circle2EdgeX, circle2EdgeY);
                                        ctx.lineTo(circle2EdgeX - arrowSize * Math.cos(angle - Math.PI / 6), circle2EdgeY - arrowSize * Math.sin(angle - Math.PI / 6));
                                        ctx.moveTo(circle2EdgeX, circle2EdgeY);
                                        ctx.lineTo(circle2EdgeX - arrowSize * Math.cos(angle + Math.PI / 6), circle2EdgeY - arrowSize * Math.sin(angle + Math.PI / 6));
                                        
                                        // Repete o mesmo processo para a linha entre circle2 e circle3
                                        ctx.moveTo(circle2.x + circle2.radius * Math.cos(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)), circle2.y + circle2.radius * Math.sin(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)));
                                        ctx.lineTo(circle3.x - circle3.radius * Math.cos(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)), circle3.y - circle3.radius * Math.sin(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)));

                                        // Adiciona a seta na ponta da linha entre circle2 e circle3
                                        var angle2 = Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x);
                                        var circle3EdgeX = circle3.x - circle3.radius * Math.cos(angle2);
                                        var circle3EdgeY = circle3.y - circle3.radius * Math.sin(angle2);
                                        ctx.moveTo(circle3EdgeX, circle3EdgeY);
                                        ctx.lineTo(circle3EdgeX - arrowSize * Math.cos(angle2 - Math.PI / 6), circle3EdgeY - arrowSize * Math.sin(angle2 - Math.PI / 6));
                                        ctx.moveTo(circle3EdgeX, circle3EdgeY);
                                        ctx.lineTo(circle3EdgeX - arrowSize * Math.cos(angle2 + Math.PI / 6), circle3EdgeY - arrowSize * Math.sin(angle2 + Math.PI / 6));
                                       
                                        ///////////////////////////////////////////////////////// fim novo
                                        ctx.strokeStyle = "#0095DD"; // Azul para a linha de conexão
                                        ctx.lineWidth = 2;
                                        ctx.stroke();
                                        ctx.closePath();
                                    }

                                    // Função para verificar se o mouse está sobre um círculo
                                    function isMouseOverCircle(mouseX, mouseY, circle) {
                                        var dx = mouseX - circle.x;
                                        var dy = mouseY - circle.y;
                                        return dx * dx + dy * dy < circle.radius * circle.radius;
                                    }

                                    // Evento de clique do mouse
                                    canvas.addEventListener("mousedown", function(event) {
                                        var mouseX = event.clientX - canvas.getBoundingClientRect().left;
                                        var mouseY = event.clientY - canvas.getBoundingClientRect().top;

                                        if (isMouseOverCircle(mouseX, mouseY, circle1)) {
                                            circle1.isDragging = true;
                                        } else if (isMouseOverCircle(mouseX, mouseY, circle2)) {
                                            circle2.isDragging = true;
                                        }else if (isMouseOverCircle(mouseX, mouseY, circle3)) {/////////////////////////////////////////////////////////novo
                                            circle3.isDragging = true;
                                        }
                                    });

                                    // Evento de movimento do mouse
                                    canvas.addEventListener("mousemove", function(event) {
                                        if (circle1.isDragging) {
                                            circle1.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle1.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        } else if (circle2.isDragging) {
                                            circle2.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle2.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        }else if (circle3.isDragging) {/////////////////////////////////////////////////////////novo
                                            circle3.x = event.clientX - canvas.getBoundingClientRect().left;
                                            circle3.y = event.clientY - canvas.getBoundingClientRect().top;
                                            redraw();
                                        }
                                    });

                                    // Evento de soltar o botão do mouse
                                    canvas.addEventListener("mouseup", function() {
                                        circle1.isDragging = false;
                                        circle2.isDragging = false;
                                        circle3.isDragging = false;/////////////////////////////////////////////////////////novo
                                    });

                                    // Desenhar os círculos pela primeira vez
                                    redraw();
                                    
                                </script>';

        //Finalização do HTML
        $sHtmlTela .= '    </body>
                        </html>';

        return $sHtmlTela;
    }
}
