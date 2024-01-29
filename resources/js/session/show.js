
$(document).ready(function () {
    //Al reasignar equipo mediante un botón individual en la tabla de sesiones.  
    const formReasignarIndiv = $("#formReasignarIndividual");
    const selectEquipoReasignarIndiv = $("#equipoReasignadoIndividual");
    const btnConfirmarReasignarIndiv = document.getElementById("confirmarReasignarIndividual");
    const mensajeReasignarIndiv = document.getElementById("msgReasignarIndividual");

    $(".botonReasignar").on("click", function () {
        formReasignarIndiv.attr("action", $(this).data("ruta-reasignar"));
        reasignarEquipo(selectEquipoReasignarIndiv, btnConfirmarReasignarIndiv, mensajeReasignarIndiv);
    });

    //Al reasignar equipo mediante la barra de navegación o el botón general en el recuadro de opciones. 
    const selectEquipoReasignarGen = $("#equipoReasignadoGeneral");
    const btnConfirmarReasignarGen = document.getElementById("confirmarReasignarGeneral");
    const mensajeReasignarGen = document.getElementById("msgReasignarGeneral");

    $("#modalReasignarGeneral").on("shown.bs.modal", function () { //Al mostrar el modal.
        reasignarEquipo(selectEquipoReasignarGen, btnConfirmarReasignarGen, mensajeReasignarGen);
    });

    /**
     * Configura el evento para reasignar el equipo de una sesión, en función de dónde se llame.
     * @param select El select en cuál listar los equipos disponibles.
     * @param btnConfirmar El botón de envío del formulario. 
     * @param msj Mensaje para mostrar el estado de la operación.
     */
    function reasignarEquipo(select, btnConfirmar, msj) {
        if (select.children("option").length == 0) { //Si no se han cargado los equipos al select.
            btnConfirmar.disabled = true; //Deshabilitado hasta listar los equipos.
            msj.innerText = "Cargando equipos...";
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '/cargarEquipos',
                dataType: 'json',
                success: function (data) {
                    if (data[0] != null) {
                        for (let i = 0; i < data.length; i++) {
                            select.append('<option value="' + data[i] + '">' + data[i] + '</option>');
                        }
                        btnConfirmar.disabled = false;
                        msj.innerText = "";
                    } else {
                        msj.innerText = 'No hay ningún equipo disponible.';
                    }
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log('error: ' + textStatus + ' ' + errorThrown);
            });
        }
    }

    const opcionBuscar = $("#opcionBuscar");
    const busquedaNumControl = document.getElementById("busquedaNumControl");
    const busquedaNumEquipo = document.getElementById("busquedaNumEquipo");

    const selectEquiposFin = $("#selectEquiposFin");
    const btnFinGeneral = document.getElementById("btnFinGeneral");
    const msgFinGeneral = document.getElementById("msgFinGeneral");

    opcionBuscar.on("change", function () {
        if (opcionBuscar.val() == "numControl") {
            busquedaNumEquipo.hidden = true;
            busquedaNumEquipo.removeAttribute('required');
            busquedaNumControl.hidden = false;
            busquedaNumControl.setAttribute('required', '');
        } else {
            busquedaNumControl.hidden = true;
            busquedaNumControl.removeAttribute('required');
            busquedaNumEquipo.hidden = false;
            busquedaNumEquipo.setAttribute('required', '');
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
                                selectEquiposFin.append('<option value="' + data[i] + '">' + data[i] + '</option>');
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

    opcionBuscar.on("submit", function(){
        formReasignarIndiv.attr("action", $(this).data("ruta-reasignar"));
    });

    const modalFin = $("#modalFin");
    $(".botonFin").on("click", function () {
        modalFin.attr("action", $(this).data("ruta-fin"));
    });
});