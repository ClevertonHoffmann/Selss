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
    document.getElementById('defGram').addEventListener('keyup', analisaGramatica);

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
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerExpRegulares&metodo=geradorTabelaAutomatoFinito" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
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
    
    var dataToSend = 'teste'; 

    $.getJSON("http://localhost/Selss/index.php?classe=ControllerAutomato&metodo=gravaPaginaAutomato" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
    
    //Abre a modal
    window.open("http://localhost/Selss/datausers/cleverton_gmail_com/modalAutomato.html", "minhaJanela", "height=800,width=800");
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
function analisaGramatica() {
    var defgram = $("#defGram").val();
    var dataToSend = JSON.stringify({
        "texto": defgram
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerGramatica&metodo=analisaGramatica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
}

function loadFirstFollow() {
    var defgram = $("#defGram").val();
    var dataToSend = JSON.stringify({
        "texto": defgram
    });
    $.getJSON("http://localhost/Selss/index.php?classe=ControllerGramatica&metodo=geradorFirstFollow" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
    //Abre a modal
    // openModalTabLex(dataToSend);
}

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
