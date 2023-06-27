/**
 * Verifica se símbolos são aceitos nas expressões regulares
 * @returns retorna erros de especificação das expressões regulares
 */

window.onload = (function () {
    document.getElementById('defReg').addEventListener('keyup', analisaExpRegulares);

    var modal = document.getElementById('myModal');

    window.onclick = function (event) {
        if (event.target == modal) {
            closeModal();
        }
    }

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
    //Abre a modal
    openModal();
    setTimeout(function () {
        $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerModal&metodo=mostraModalTabelaLexica" + "&dados=" + encodeURIComponent(dataToSend), function (result) {
            var div = document.getElementById('csvData');
            // Altera o conteúdo da div
            div.innerHTML = result;
        });
    }, 5000);

}

function openModal() {
    var div = document.getElementById('csvData');
    div.innerHTML = '';
    document.getElementById("myModal").style.display = "block";
}

function closeModal() {
    var div = document.getElementById('csvData');
    div.innerHTML = '';
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
}

