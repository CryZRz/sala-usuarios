import { configurarReasignarEquipo } from "./reasignarEquipo";

$(document).ready(function () {
    //Al reasignar equipo mediante la barra de navegación o el botón general en el recuadro de opciones.
    const selectEquipoReasignarGen = $("#equipoReasignadoGeneral");
    const btnConfirmarReasignarGen = document.getElementById("confirmarReasignarGeneral");
    const mensajeReasignarGen = document.getElementById("msgReasignarGeneral");

    $("#modalReasignarGeneral").on("shown.bs.modal", function () { //Al mostrar el modal.
        configurarReasignarEquipo(selectEquipoReasignarGen, btnConfirmarReasignarGen, mensajeReasignarGen);
    });

    const opcionBuscar = $("#opcionBuscar");
    const busquedaNumControl = $("#busquedaNumControl");
    const busquedaNumEquipo = $("#busquedaNumEquipo");

    const campoNumControl = $("#numControlFin")
    const selectEquiposFin = $("#selectEquiposFin");
    const btnFinGeneral = document.getElementById("btnFinGeneral");
    const msgFinGeneral = document.getElementById("msgFinGeneral");

    //Opción predeterminada
    opcionBuscar.val("numControl");
    busquedaNumControl.prop("hidden", false);
    busquedaNumEquipo.prop("hidden", true);
    campoNumControl.prop("required", true);
    selectEquiposFin.prop("required", false);

    opcionBuscar.on("change", function () {
        if ($(this).val() == "numControl") {
            busquedaNumControl.prop("hidden", false);
            busquedaNumEquipo.prop("hidden", true);
            campoNumControl.prop("required", true);
            selectEquiposFin.prop("required", false);
        } else {
            busquedaNumEquipo.prop("hidden", false);
            busquedaNumControl.prop("hidden", true);
            selectEquiposFin.prop("required", true);
            campoNumControl.prop("required", false);
            if (selectEquiposFin.children("option").length == 0) { //Si no se han cargado los equipos al select.
                btnFinGeneral.disabled = true; //Deshabilitado hasta listar los equipos.
                msgFinGeneral.innerText = "Cargando equipos...";
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/cargarEquiposUso',
                    dataType: 'json',
                    success: function (data) {
                        if (data[0] != null) {
                            for (let i = 0; i < data.length; i++) {
                                selectEquiposFin.append('<option value="' + data[i].id + '">' + data[i].id + '</option>');
                            }
                            btnFinGeneral.disabled = false;
                            msgFinGeneral.innerText = "";
                        } else {
                            msgFinGeneral.innerText = 'No hay ninguna sesión disponible.';
                        }
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log('error: ' + textStatus + ' ' + errorThrown);
                });
            }
        }
    });

    opcionBuscar.on("submit", function () {
        formReasignarIndiv.attr("action", $(this).data("ruta-reasignar"));
    });
});