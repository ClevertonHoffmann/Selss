/*
 * Executado em tempo real de funcionamento da tela
 */
window.onload = (function () {

    /**
     * Verifica se símbolos são aceitos nas expressões regulares
     * @returns retorna erros de especificação das expressões regulares
     */
    document.getElementById('defReg').addEventListener('keyup', analisaExpRegulares);
    
//    var textarea = document.getElementById("defGram");
//    var texto = textarea.value;
//    texto = texto.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
//    texto = texto.replace(/&lt;b&gt;(.*?)&lt;\/b&gt;/g, '<b>$1</b>');
//    textarea.value = texto;
    
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

});


function analisaExpRegulares() {
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerExpRegulares&metodo=analisaExpressoes" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
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
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerExpRegulares&metodo=geradorTabelaAutomatoFinito" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
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
        $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerExpRegulares&metodo=mostraModalTabelaLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
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
function analiseLexica(){
    var defreg = $("#codTest").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerAnalisadorLexico&metodo=analiseLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
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
        $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerAnalisadorLexico&metodo=mostraModalResultadoAnaliseLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
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