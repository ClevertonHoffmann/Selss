/*
 * Executado em tempo real de funcionamento da tela
 */
window.onload = (function () {

    /**
     * Verifica se símbolos são aceitos nas expressões regulares
     * @returns retorna erros de especificação das expressões regulares
     */
    document.getElementById('defReg').addEventListener('keyup', analisaExpRegulares);

    //VER A POSSIBILIDADE DE REALIZAR A ANÁLISE LÉXICA EM TEMPO REAL


    //****Inicio fechar modal*****//
    var modal = document.getElementById('myModal');

    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal();
        }
    }
    //****Fim fechar modal*****//

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
    openModal(dataToSend);
}

/*
 * Responsável por chamar a classe para abrir a tela modal e apresentar os resultados da tabela de análise léxica
 */
function openModal(dataToSend) {
    var div = document.getElementById('csvData');
    div.innerHTML = '';
    document.getElementById("myModal").style.display = "block";
    setTimeout(function () {
        $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerModal&metodo=mostraModalTabelaLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
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
}