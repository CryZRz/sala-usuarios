import ShowLoading from "../utils/showLoading";

$(document).ready(function () {
    const pantallaCarga = document.getElementById("section-loading");
    const carga = new ShowLoading(pantallaCarga);
    carga.setPageLoading();

    //Terminar incidencia
    const formFinIndiv = $("#formFinIndividual");
    //Concatenar id de la sesión elegida a la ruta del form de finalizar incidencia. 
    $(".botonFin").on("click", function () {
        formFinIndiv.attr("action", $(this).data("ruta-fin"));
    });
});