/*
 * Executado em tempo real de funcionamento da tela
 */
window.onload = (function () {

    /**
     * Verifica se símbolos são aceitos nas expressões regulares
     * @returns retorna erros de especificação das expressões regulares
     */
    document.getElementById('defReg').addEventListener('keyup', analisaExpRegulares);

    /**
     * Responsável por chamar método para download da tabela do automato de análise léxica
     */
    document.getElementById('downloadTabelaAnaliseLexica').addEventListener('click', function (event) {
        downloadTabela(event, 'tabelaAnaliseLexica.csv');
    });

    /**
     * Responsável por chamar método para download da tabela do resultado da análise léxica
     */
    document.getElementById('downloadResultadoAnaliseLexica').addEventListener('click', function (event) {
        downloadTabela(event, 'resultadoAnaliseLexica.csv');
    });

    /**
     * Verifica se símbolos pertencem aos tokens válidos e separa 
     * @returns retorna erros de especificação das expressões regulares
     */
    //document.getElementById('defGram').addEventListener('keyup', analisaGramatica);

    /**
     * Abre a modal para sair do sistema
     */
    document.getElementById('btnSair').addEventListener('click', openModalSair);

    /**
     * Chama a função que realiza o logout do sistema
     */
    document.getElementById('btnSairLogout').addEventListener('click', logout);

    /**
     * Fecha a modal de logout caso não seja do interesse de sair do sistema
     */
    document.getElementById('cancelarLogout').addEventListener('click', closeModalSair);

    //****Inicio fechar modal*****//
    var modal = document.getElementById('myModal');

    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    var modal2 = document.getElementById('myModal2');

    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal2();
        }
    }

    //****Fim fechar modais*****//

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /*********************************Inicio da parte das sugestões********************************/
    // Array de sugestões
    var arquivo = new XMLHttpRequest();
    arquivo.open("GET", "http://localhost/Selss/data/sugestoes.txt", false);
    arquivo.send(null);

    // Processa as sugestões do arquivo
    var sugestoes = arquivo.responseText.split('\n');
    sugestoes = sugestoes.map(function (sugestao) {
        return sugestao.trim();
    });

    // Obtém o elemento textarea
    var campoTexto = document.getElementById('defReg');

    // Obtém o elemento do balão de sugestão
    var balaoSugestao = document.getElementById('balaoSugestao');

    // Função para mostrar as sugestões
    function mostrarSugestoes() {
        // Limpa as sugestões anteriores
        balaoSugestao.innerHTML = '';

        // Obtém o texto digitado
        var textoDigitado = campoTexto.value.trim().toLowerCase();

        // Verifica se há texto digitado e se a última palavra está incompleta
        var palavras = textoDigitado.split(' ');
        var ultimaPalavra = palavras.pop();
        if (campoTexto.selectionStart == textoDigitado.length && ultimaPalavra.length > 0) {
            // Verifica se há sugestões para a palavra digitada
            var sugestoesFiltradas = sugestoes.filter(function (sugestao) {
                return sugestao.startsWith(ultimaPalavra);
            });

            // Exibe as sugestões no balão de sugestão
            sugestoesFiltradas.forEach(function (sugestao) {
                var sugestaoElemento = document.createElement('div');
                sugestaoElemento.textContent = sugestao;
                sugestaoElemento.classList.add('sugestao');
                sugestaoElemento.addEventListener('click', function () {
                    completarTexto(sugestao);
                });
                balaoSugestao.appendChild(sugestaoElemento);
            });

            // Exibe o balão de sugestão se houver sugestões filtradas
            if (sugestoesFiltradas.length > 0) {
                balaoSugestao.style.display = 'block';
                balaoSugestao.style.top = campoTexto.offsetTop + campoTexto.offsetHeight + 'px';
                balaoSugestao.style.left = campoTexto.offsetLeft + 'px';
                return;
            }
        }

        // Se não houver sugestões ou texto incompleto, oculta o balão de sugestão
        balaoSugestao.style.display = 'none';
    }

    // Evento keyup para monitorar a digitação no campo de texto
    campoTexto.addEventListener('keyup', function () {
        mostrarSugestoes();
    });


    // Função para completar o texto do campo com a sugestão selecionada
    function completarTexto(sugestao) {
        var textoAtual = campoTexto.value; // Texto atual do campo
        var textoAntesCursor = textoAtual.substring(0, campoTexto.selectionStart); // Texto antes do cursor
        var textoDepoisCursor = textoAtual.substring(campoTexto.selectionEnd); // Texto depois do cursor

        // Encontrar a última palavra digitada no texto atual
        var palavras = textoAntesCursor.split(' ');
        var ultimaPalavra = palavras.pop();

        // Remover a última palavra digitada e adicionar a sugestão completa
        palavras.push(sugestao);
        var novoTexto = palavras.join(' ');

        // Adicionar o restante do texto depois do cursor
        novoTexto += textoDepoisCursor;

        // Atualizar o texto do campo
        campoTexto.value = novoTexto;

        // Reposicionar o cursor
        campoTexto.selectionStart = campoTexto.selectionEnd = novoTexto.length;

        // Ocultar o balão de sugestão
        balaoSugestao.style.display = 'none';
    }

    // Fechar o balão de sugestão ao clicar em qualquer lugar fora dele
    document.addEventListener('click', function (event) {
        if (!balaoSugestao.contains(event.target) && event.target !== campoTexto) {
            balaoSugestao.style.display = 'none';
        }
    });
    /*********************************Fim da parte das sugestões********************************/

});


function analisaExpRegulares() {
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerExpRegulares&metodo=analisaExpressoes" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
}

/**
 * Método que constroi o automato finito das expressões regulares 
 * preenchendo a tabela do automato salvando em csv para ser utilizada na análise léxica
 * @returns tela do automato finito
 */
function loadTabLexica() {
    // Exibe a mensagem de carregamento
    $("#mensagemCarregando").show();
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerExpRegulares&metodo=geradorTabelaAutomatoFinito" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
    
    // Ativa os botões
    document.getElementById("btdesenhaautomato").disabled = false;
    document.getElementById("btexecutaanaliselex").disabled = false;
    
    //Abre a modal
    openModalTabLex(dataToSend);
}

/*
 * Responsável por chamar a classe para abrir a tela modal e apresentar os resultados da tabela de análise léxica
 */
function openModalTabLex(dataToSend) {
    var div = document.getElementById('csvData');
    div.innerHTML = '';
    document.getElementById("myModal").style.display = "block";
    setTimeout(function () {
        $.getJSON("http://localhost/Selss/index.php?classe=ControllerExpRegulares&metodo=mostraModalTabelaLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
            var div = document.getElementById('csvData');
            // Depois de obter o resultado, oculta a mensagem de carregamento
            $("#mensagemCarregando").hide();
            // Altera o conteúdo da div
            div.innerHTML = result;
        });
    }, 5000);
}

/*
 * Método responsável por fechar a modal da tabela de análise léxica
 */
function closeModal() {
    var div = document.getElementById('csvData');
    div.innerHTML = '';
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
}

/*
 * Método responsável por chamar a classe de análise léxica
 */
function analiseLexica() {
    // Exibe a mensagem de carregamento
    $("#mensagemCarregando").show();
    var defreg = $("#codTest").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerAnalisadorLexico&metodo=analiseLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaAnalise").val(JSON.parse(result).texto);
    });
    //Abre a modal
    openModalResLex(dataToSend);
}

/*
 * Responsável por chamar a classe para abrir a tela modal e apresentar os resultados da tabela de análise léxica
 */
function openModalResLex(dataToSend) {
    var div = document.getElementById('csvData2');
    div.innerHTML = '';
    document.getElementById("myModal2").style.display = "block";
    setTimeout(function () {
        $.getJSON("http://localhost/Selss/index.php?classe=ControllerAnalisadorLexico&metodo=mostraModalResultadoAnaliseLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
            var div = document.getElementById('csvData2');
            // Altera o conteúdo da div
            div.innerHTML = result;
            // Depois de obter o resultado, oculta a mensagem de carregamento
            $("#mensagemCarregando").hide();
        });
    }, 5000);
}

/*
 * Método responsável por fechar a modal da tabela de análise léxica
 */
function closeModal2() {
    var div = document.getElementById('csvData2');
    div.innerHTML = '';
    var modal = document.getElementById('myModal2');
    modal.style.display = 'none';
}

/**
 * Método que constroi o automato finito das expressões regulares gráficamente
 * com base na tabela de transição utilizada na análise léxica
 * @returns tela do automato finito
 */
function loadAutomato() {

    // Exibe a mensagem de carregamento
    $("#mensagemCarregando").show();

    var dataToSend = 'teste';

    $.getJSON("http://localhost/Selss/index.php?classe=ControllerAutomato&metodo=gravaPaginaAutomato" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        //Abre a página com automato de análise léxica gráficamente conforme usuário
        window.open("http://localhost/Selss/" + JSON.parse(result).texto + "/modalAutomato.html", "minhaJanela", "height=800,width=1000");
        // Depois de obter o resultado, oculta a mensagem de carregamento
        $("#mensagemCarregando").hide();
    });

}


function downloadTabela(event, nome) {
    // Cria um elemento de link temporário
    var link = document.createElement('a');

    // Define o atributo 'href' do link com o caminho para o script download.php e o nome do arquivo
    link.href = 'http://localhost/Selss/php/biblioteca/download.php?arquivo=' + encodeURIComponent(nome);

    // Define o atributo 'target' para '_blank' para abrir o link em uma nova janela/tab
    link.target = '_blank';

    // Simula um clique no link para iniciar o download
    link.click();
}

/**
 * Analisa a gramática digitada pelo usuário
 */
//function analisaGramatica() {
//    var defgram = $("#defGram").val();
//    var dataToSend = JSON.stringify({
//        "texto": defgram
//    });
//    $.getJSON("http://localhost/Selss/index.php?classe=ControllerGramatica&metodo=analisaGramatica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
//        $("#saidaDefErros").val(JSON.parse(result).texto);
//    });
//}
//
//function loadFirstFollow() {
//    var defgram = $("#defGram").val();
//    var dataToSend = JSON.stringify({
//        "texto": defgram
//    });
//    $.getJSON("http://localhost/Selss/index.php?classe=ControllerGramatica&metodo=geradorFirstFollow" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
//        $("#saidaDefErros").val(JSON.parse(result).texto);
//    });
//    //Abre a modal
//    // openModalTabLex(dataToSend);
//}

/**
 * Abre a modal de logout do sistema
 */
function openModalSair() {
    document.getElementById("modalSair").style.display = "block";
}

/*
 * Fecha a modal de sair do sistema
 */
function closeModalSair() {
    document.getElementById("modalSair").style.display = "none";
}

/**
 * Realiza o Logout do sistema
 */
function logout() {
    closeModalSair();
    var dataToSend = JSON.stringify({
        "texto": "logout"
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerSistema&metodo=realizaLogout" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
    });
    window.location.href = 'index.php';
}

/**
 * Mensagem de carregando no sistema
 */
function mostrarCarregando() {
    document.getElementById('loading').style.display = 'block';
}

// Função para esconder mensagem de carregamento
function esconderCarregando() {
    document.getElementById('loading').style.display = 'none';
}