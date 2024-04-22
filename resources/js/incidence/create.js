import { interpretarResponse } from "../session/actualizarSesion";

export function configurarCrearIncidencia() {
    const numControlIncidencia = $("#num-control-crear");
    const msgNumControlIncidencia = document.getElementById("msg-num-control-crear");
    const msgCarrerasIncidencia = $("#msg-carreras-crear")
    const registroAlumno = document.getElementById("registro-alumno");
    const inputsRegistroAlumno = registroAlumno.getElementsByTagName("input");
    const selectCarreraRegistroAlumno = document.getElementById("selectCarrerasIncidencia");
    const formCrearIncidencia = $("#form-crear-incidencia")

    let alumnoValidado = false;
    activarRegistroAlumno(false);

    function activarRegistroAlumno(activar) {
        for (const inputs of inputsRegistroAlumno) {
            inputs.required = activar
            inputs.value = "";
        }
        selectCarreraRegistroAlumno.required = activar;

        if (activar) {
            registroAlumno.classList.remove("d-none");
            registroAlumno.classList.add("d-flex");
        } else {
            registroAlumno.classList.add("d-none");
            registroAlumno.classList.remove("d-flex");
        }
    }

    numControlIncidencia.on("change", function () {
        alumnoValidado = false;
    })

    /* Búsquedas de alumno */
    $("#btn-num-control-crear").on("click", function () {
        validarForm(false);
    });

    formCrearIncidencia.on("submit", (event) => {
        event.preventDefault();
        if (!alumnoValidado) {
            validarForm(true);
        } else {
            subirForm()
        }
    });

    function subirForm() {
        // carga.onLoading();
        interpretarResponse(formCrearIncidencia, msgNumControlIncidencia);
    }

    function validarForm(subir) {
        if (numControlIncidencia.val() != "" && !alumnoValidado) {
            msgNumControlIncidencia.innerText = "Buscando...";
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                url: '/estudiante/' + numControlIncidencia.val(),
                dataType: 'json',
                success: function (data) {
                    if (data.id != null) {
                        msgNumControlIncidencia.innerText = "Alumno: " + data["lastName"] + " " + data["name"] + ".";
                        activarRegistroAlumno(false);
                    }
                    if (subir) {
                        subirForm();
                    }
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 401) {
                    location.reload()
                } else {
                    msgNumControlIncidencia.innerText = "Alumno no registrado; si lo ingresaste correctamente, continúa: ";
                    activarRegistroAlumno(true);

                    /* Cargar carreras */
                    if (selectCarreraRegistroAlumno.length === 1) {
                        msgCarrerasIncidencia.text("Cargando...");
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            url: '/cargarCarreras',
                            datatype: 'json',
                            success: function (data) {
                                if (data[0] != null) {
                                    for (let i = 0; i < data.length; i++) {
                                        $("#selectCarrerasIncidencia").append('<option value="' + data[i] + '">' + data[i] + '</option>');
                                    }
                                }
                                msgCarrerasIncidencia.text("");
                            }
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            console.log('error: ' + textStatus + ' ' + errorThrown);
                        });
                    } else {
                        msgCarrerasIncidencia.text("");
                    }
                }
            }).always(function () {
                alumnoValidado = true;
            });
        }
    }


}
