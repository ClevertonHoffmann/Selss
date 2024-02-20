<?php

class ViewAutomato {

    /**
     * Método responsável por montar a página em html do automato
     * @return string
     */
    public function montaPaginaAutomato(){
        
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
                           
        //Script que renderiza os desenhos dos estados do automato
        $sHtmlTela .= ' <script>
                                    // Obtém o elemento canvas e seu contexto
                                    var canvas = document.getElementById("canvas");
                                    var ctx = canvas.getContext("2d");

                                    // Define as coordenadas dos círculos e seus rótulos
                                    var circle1 = { x: 100, y: 100, radius: 20, isDragging: false, label: "q0" };
                                    var circle2 = { x: 300, y: 100, radius: 20, isDragging: false, label: "q1" };
                                    var circle3 = { x: 500, y: 100, radius: 20, isDragging: false, label: "q2" };/////////////////////////////////////////////////////////novo

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

                                        // Desenha a linha conectando as bordas dos círculos
                                        ctx.beginPath();
                                        ctx.moveTo(circle1.x + circle1.radius * Math.cos(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)),
                                                    circle1.y + circle1.radius * Math.sin(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)));
                                        ctx.lineTo(circle2.x - circle2.radius * Math.cos(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)),
                                                    circle2.y - circle2.radius * Math.sin(Math.atan2(circle2.y - circle1.y, circle2.x - circle1.x)));
                                        /////////////////////////////////////////////////////////novo
                                        ctx.moveTo(circle2.x + circle2.radius * Math.cos(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)),
                                                    circle2.y + circle2.radius * Math.sin(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)));/////////////////////////////////////////////////////////novo
                                        ctx.lineTo(circle3.x - circle3.radius * Math.cos(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)),
                                                    circle3.y - circle3.radius * Math.sin(Math.atan2(circle3.y - circle2.y, circle3.x - circle2.x)));/////////////////////////////////////////////////////////novo

                                        ctx.moveTo(circle1.x, circle1.y - circle1.radius); // Move para a borda superior do círculo 1
                                        ctx.bezierCurveTo(
                                            circle1.x + 20, circle1.y - 50, // Ponto de controle 1
                                            circle1.x + 80, circle1.y - 50, // Ponto de controle 2
                                            circle1.x, circle1.y - circle1.radius // Chega de volta ao círculo 1
                                        );

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