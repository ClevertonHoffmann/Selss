<?php

class ViewAutomato {

    public function montaModalAutomato(){
        
        $sHtmlModal = "<!DOCTYPE html>
<html lang=\'pt-BR\'>
<head>
  <meta charset=\'UTF-8\'>
  <meta name=\'viewport' content='width=device-width, initial-scale=1.0\'>
  <style>
    /* Estilos para os estados e transições */
    .estado {
      fill: #99cc99;
      stroke: #336633;
    }

    .transicao {
      fill: none;
      stroke: #333;
      stroke-width: 2px;
    }

    .texto {
      font-family: Arial, sans-serif;
      font-size: 14px;
      fill: #333;
    }

    .estado-inicial {
      fill: #99cc99;
      stroke: #336633;
      stroke-width: 2px;
    }

    .estado-final {
      fill: #cc9999;
      stroke: #993333;
      stroke-width: 2px;
    }
  </style>
</head>
<body>

<svg width='600' height='400' id='automato'>
  <!-- Elementos do autômato serão renderizados aqui -->
</svg>

<script src=\'https://d3js.org/d3.v7.min.js\'></script>
<script>
  // Exemplo de dados para a tabela de transição
  const tabelaTransicao = {
    q0: { 0: 'q1', 1: 'q0' },
    q1: { 0: 'q1', 1: 'q2' },
    q2: { 0: 'q2', 1: 'q3' },
    q3: { 0: 'q3', 1: 'q0' }
  };

  // Adiciona uma transição específica para a palavra reservada 'if'
  tabelaTransicao.q2.i = 'q3';
  tabelaTransicao.q3.f = 'q4';

  // Configuração do SVG
  const svg = d3.select('#automato');

  // Adiciona os estados ao SVG
  const estados = svg.selectAll('.estado')
    .data(Object.keys(tabelaTransicao))
    .enter().append('circle')
    .attr('class', d => d === 'q0' ? 'estado estado-inicial' : d === 'q4' ? 'estado estado-final' : 'estado')
    .attr('r', 20)
    .attr('cx', d => Math.random() * 600)
    .attr('cy', d => Math.random() * 400)
    .call(d3.drag()
      .on('start', dragstarted)
      .on('drag', dragged)
      .on('end', dragended));

  // Adiciona texto dentro dos estados
  const textos = svg.selectAll('.texto')
    .data(Object.keys(tabelaTransicao))
    .enter().append('text')
    .attr('class', 'texto')
    .attr('x', d => Math.random() * 600)
    .attr('y', d => Math.random() * 400)
    .attr('text-anchor', 'middle') // Alinha o texto no centro do círculo
    .attr('dy', 5) // Desloca o texto para baixo para centralizá-lo verticalmente
    .text(d => d);

  // Adiciona as transições ao SVG
  const transicoes = svg.selectAll('.transicao')
    .data(Object.entries(tabelaTransicao))
    .enter().append('g')
    .selectAll('line')
    .data(d => Object.entries(d[1]))
    .enter().append('line')
    .attr('class', 'transicao')
    .attr('x1', d => getXPos(d[0]))
    .attr('y1', d => getYPos(d[0]))
    .attr('x2', d => getXPos(d[1]))
    .attr('y2', d => getYPos(d[1]));

  // Função de arrasto
  function dragstarted(event, d) {
    d3.select(this).raise().classed('active', true);
  }

  function dragged(event, d) {
    d3.select(this).attr('cx', d.x = event.x).attr('cy', d.y = event.y);
    updateTransicoes();
    updateTextos();
  }

  function dragended(event, d) {
    d3.select(this).classed('active', false);
  }

  // Atualiza as posições das transições durante o arrasto
  function updateTransicoes() {
    transicoes
      .attr('x1', d => getXPos(d[0]))
      .attr('y1', d => getYPos(d[0]))
      .attr('x2', d => getXPos(d[1]))
      .attr('y2', d => getYPos(d[1]));
  }

  // Atualiza as posições dos textos durante o arrasto
  function updateTextos() {
    textos
      .attr('x', d => getXPos(d))
      .attr('y', d => getYPos(d));
  }

  // Funções auxiliares para obter as posições x e y com base no nome do estado
  function getXPos(estado) {
    const estadoSelecionado = estados.filter(node => node.__data__ === estado).node();
    return parseFloat(estadoSelecionado.getAttribute('cx'));
  }

  function getYPos(estado) {
    const estadoSelecionado = estados.filter(node => node.__data__ === estado).node();
    return parseFloat(estadoSelecionado.getAttribute('cy'));
  }
</script>

</body>
</html>'";
        
        return $sHtmlModal;
        
    }
    
}