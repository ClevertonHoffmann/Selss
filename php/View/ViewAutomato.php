<?php

class ViewAutomato {

    /**
     * Método responsável por montar a página em html do automato
     * @return string
     */
    public function montaPaginaAutomato($aEstadosTransicoes, $aTabelaDeTokens) {

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

        // Cabeçalho da página
//        $sHtmlTela = ' <!DOCTYPE html>
//                        <html lang="pt-BR">
//                            <head>
//                                <meta charset="UTF-8">
//                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
//                                <title>Desenhar e Conectar Círculos</title>
//                                <style>
//                                    #canvas { border: 1px solid #000; cursor: pointer; }
//                                </style>
//                            </head>
//                            <body style="text-align:center">
//                                <canvas id="canvas" width="700" height="700"></canvas>
//                                <script>
//                                    var canvas = document.getElementById("canvas");
//                                    var ctx = canvas.getContext("2d");
//                                    var circles = []; // Array para armazenar os círculos
//
//                                    // Função para desenhar um círculo
//                                    function drawCircle(x, y, label) {
//                                        ctx.beginPath();
//                                        ctx.arc(x, y, 20, 0, 2 * Math.PI);
//                                        ctx.fillStyle = "rgba(0, 149, 221, 0.5)";
//                                        ctx.fill();
//                                        ctx.strokeStyle = "#0095DD";
//                                        ctx.lineWidth = 2;
//                                        ctx.stroke();
//                                        ctx.closePath();
//
//                                        // Adiciona o rótulo ao círculo
//                                        ctx.fillStyle = "#000";
//                                        ctx.font = "12px Arial";
//                                        ctx.textAlign = "center";
//                                        ctx.textBaseline = "middle";
//                                        ctx.fillText(label, x, y);
//
//                                        // Adiciona o círculo ao array de círculos
//                                        circles.push({ x: x, y: y });
//                                    }
//
//                                    // Função para desenhar uma seta
//                                    function drawArrow(x1, y1, x2, y2, label) {
//                                        ctx.beginPath();
//                                        ctx.moveTo(x1, y1);
//                                        ctx.lineTo(x2, y2);
//                                        ctx.strokeStyle = "#0095DD";
//                                        ctx.lineWidth = 2;
//                                        ctx.stroke();
//
//                                        // Adiciona o rótulo à seta
//                                        var labelX = (x1 + x2) / 2;
//                                        var labelY = (y1 + y2) / 2;
//                                        ctx.fillStyle = "#000";
//                                        ctx.font = "12px Arial";
//                                        ctx.textAlign = "center";
//                                        ctx.textBaseline = "middle";
//                                        ctx.fillText(label, labelX, labelY);
//                                    }
//
//                                    // Função para desenhar o autômato
//                                    function drawAutomato() {
//                                        // Desenha os círculos e as transições
//                                        foreach ($tabelaAutomato as $estado => $transicoes) {
//                                            $x = /* Calcular a posição x do círculo */;
//                                            $y = /* Calcular a posição y do círculo */;
//                                            drawCircle($x, $y, $estado);
//
//                                            foreach ($transicoes as $token => $proximoEstado) {
//                                                $indiceProximoEstado = /* Encontrar o índice do próximo estado no array de círculos */;
//                                                $xProximoEstado = circles[$indiceProximoEstado].x;
//                                                $yProximoEstado = circles[$indiceProximoEstado].y;
//                                                drawArrow($x, $y, $xProximoEstado, $yProximoEstado, $token);
//                                            }
//                                        }
//                                    }
//
//                                    // Chama a função para desenhar o autômato
//                                    drawAutomato();
//                                </script>
//                            </body>
//                        </html>';
        
        return $sHtmlTela;
    }
}
