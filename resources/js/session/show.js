import { configurarReasignarEquipo } from "./reasignarEquipo";

$(document).ready(function () {
    //Al reasignar equipo mediante un botón individual en la tabla de sesiones.
    const formReasignarIndiv = $("#formReasignarIndividual");
    const selectEquipoReasignarIndiv = $("#equipoReasignadoIndividual");
    const btnConfirmarReasignarIndiv = document.getElementById("confirmarReasignarIndividual");
    const mensajeReasignarIndiv = document.getElementById("msgReasignarIndividual");

    $(".botonReasignar").on("click", function () {
        formReasignarIndiv.attr("action", $(this).data("ruta-reasignar"));
        configurarReasignarEquipo(selectEquipoReasignarIndiv, btnConfirmarReasignarIndiv, mensajeReasignarIndiv);
    });

    const checkboxGlobal = $("#checkGlobal");
    const checkboxesSesiones = $(".checkSesion");
    const btnTerminarMultiple = $("#btnTerminarMultiple");
    let checkboxesActivas = 0;
    checkboxesSesiones.each(function () {
        if ($(this).is(":checked")) {
            checkboxesActivas++
        }
    });

    checkboxGlobal.change(function () {
        if ($(this).is(":checked")) {
            checkboxesSesiones.each(function () {
                $(this).prop("checked", true);
            });
            btnTerminarMultiple.prop("disabled", false);
            checkboxesActivas = checkboxesSesiones.length;
        } else {
            checkboxesSesiones.each(function () {
                $(this).prop("checked", false);
                btnTerminarMultiple.prop("disabled", true);
            });
            checkboxesActivas = 0;
        }
    });

    checkboxesSesiones.change(function () {
        if ($(this).is(":checked")) {
            checkboxesActivas++;
            if (checkboxesActivas == 1) {
                btnTerminarMultiple.prop("disabled", false);
            };
        } else {
            checkboxesActivas--;
            if (checkboxesActivas == 0) {
                btnTerminarMultiple.prop("disabled", true);
            };
        }
    });

    const modalFin = $("#modalFin");
    $(".botonFin").on("click", function () {
        modalFin.attr("action", $(this).data("ruta-fin"));
    });

    const formFinMultiple = $("#formFinMultiple");
    btnTerminarMultiple.on("click", function () {
        const seleccionadas = [];
        checkboxesSesiones.each(function () {
            if ($(this).is(":checked")) {
                seleccionadas.push($(this).data("id-sesion"));
            }
        })
        formFinMultiple.attr("action", formFinMultiple.data("ruta-fin-multiple") + "/" + JSON.stringify(seleccionadas));
    });
});
