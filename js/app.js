/**
 * Verifica se símbolos são aceitos nas expressões regulares
 * @returns retorna erros de especificação das expressões regulares
 */

window.onload = (function () {
    document.getElementById('defReg').addEventListener('keyup', analisaExpRegulares);
});

function analisaExpRegulares() {
    console.log('texto');
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
 * @returns tela do automato finito
 */
function loadTabLexica() {
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerExpRegulares&metodo=geradorTabelaAutomatoFinito" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        $("#saidaAnalise").val(JSON.parse(result).texto);
    });
    
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerModal&metodo=mostraModalTabelaLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
        var div = document.getElementById('myModal');

        // Altera o conteúdo da div
        div.innerHTML = JSON.parse(result).texto;
        openModal();
    });
}

function openModal() {
    document.getElementById("myModal").style.display = "block";
}

function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
}