import { cargarEquiposDisponibles, interpretarResponse } from "./actualizarSesion";
import { configurarCrearIncidencia } from "../incidence/create";
import { Modal } from 'bootstrap';
import ShowLoading from "../utils/showLoading";

$(document).ready(function () {

    configurarCrearIncidencia();

    const pantallaCarga = document.getElementById("section-loading");
    const carga = new ShowLoading(pantallaCarga);
    carga.setPageLoading();

    //Cierre de sesión:
    const btnCierre = $("#btnCierre");
    const modalCierre = new Modal(document.getElementById('avisoCierre'));
    const mensajeCierre = $("#msgCierre");
    const formCierre = document.getElementById("formCierre");

    btnCierre.on("click", function () {
        carga.onLoading();
        //Revisar si hay préstamos activos:
        $.ajax({
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            url: '/contarSesiones',
            dataType: 'json',
            success: function (data) {
                //Mostrar el modal de confirmación.
                if (data != 0) {
                    mensajeCierre.text("Aún hay " + data +
                        (data % 2 == 0 ? " préstamos activos." : " préstamo activo."));
                    modalCierre.show();
                } else {
                    formCierre.requestSubmit();
                }
                carga.offLoading();
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 401) {
                location.reload()
            } else {
                console.log('error: ' + textStatus + ' ' + errorThrown);
            }
        });
    })

    //Al reasignar equipo mediante la barra de navegación o el botón general en el recuadro de opciones.
    const selectEquipoReasignarGen = $("#equipoReasignadoGeneral");
    const btnConfirmarReasignarGen = document.getElementById("confirmarReasignarGeneral");
    const mensajeReasignarGen = document.getElementById("msgReasignarGeneral");

    $("#modalReasignarGeneral").on("shown.bs.modal", function () { //Al mostrar el modal.
        cargarEquiposDisponibles(selectEquipoReasignarGen, btnConfirmarReasignarGen, mensajeReasignarGen);
    });

    //Reasignar desde el menú.
    const formReasignar = $("#formReasignarGeneral");
    //Interceptar la acción y hacerla con ajax para indicar errores con los datos proporcionados, si los hay.   
    formReasignar.on("submit", (event) => {
        event.preventDefault();
        interpretarResponse(formReasignar, mensajeReasignarGen);
    });

    //Terminar desde el menú.
    const formFin = $("#formFinGeneral");
    const mensajeFinGen = document.getElementById("msgFinGeneral");
    formFin.on("submit", (event) => {
        event.preventDefault();
        interpretarResponse(formFin, mensajeFinGen);
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
                    if (jqXHR.status === 401) {
                        location.reload()
                    } else {
                        console.log('error: ' + textStatus + ' ' + errorThrown);
                    }
                });
            }
        }
    });
});