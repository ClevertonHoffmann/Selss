/**
 * Verifica se símbolos são aceitos nas expressões regulares
 * @returns retorna erros de especificação das expressões regulares
 */

window.onload = (function(){
    document.getElementById('defReg').addEventListener('keyup',analisaExpRegulares);
});

function analisaExpRegulares() {
    console.log('texto');
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerExpRegulares&metodo=analisaExpressoes"+"&dados="+dataToSend, function (result) {
        $("#saidaDefErros").val(JSON.parse(result).texto);
    });
}

/**
 * Método que constroi o automato finito das expressões regulares
 * @returns tela do automato finito
 */
function loadTabLexica(){
   // alert('teste');
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg
    });
    $.getJSON("http://localhost/Selss/php/principal.php?classe=ControllerExpRegulares&metodo=geradorTabelaAutomatoFinito"+"&dados="+dataToSend, function (result) {
        $("#saidaAnalise").val(JSON.parse(result).texto);
    });
}