//require('./bootstrap');

//$(document).ready(function () {
//    $("defReg").on("keyup change click focus", function () {
//        $(".classenome").val($("#defReg").val());
//       // var func = loadDoc();
//    });
//});
//https://sistema.metalbo.com.br/index.php?classe=MET_RH_Curriculo&metodo=getDadosCurriculo" + "&dados=" + dataToSend
function loadDoc() {
    var defreg = $("#defReg").val();
    var dataToSend = JSON.stringify({
        "texto": defreg,
    });
    $.getJSON("http://localhost/Selss/php/index.php?classe=ControllerExpRegulares&metodo=analisaExpressoes"+"&dados="+dataToSend, function (result) {
        $("#saidaDefErros").text(JSON.parse(result).texto);
    });
}