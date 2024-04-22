import ShowLoading from "../utils/showLoading";

/* Obtener los tipos de uso registrados y equipos disponibles */
$(document).ready(function () {
    const pantallaCarga = document.getElementById("section-loading");

    const mensajeAlumno = document.getElementById("msgNumControl");
    const numControl = document.getElementById("numControl");
    const nombre = document.getElementById("nombre");
    const apellidos = document.getElementById("apellidos");
    const semestre = document.getElementById("semestre");
    const carrera = document.getElementById("selectCarreras");

    vaciarCampos();

    /* Autocompletar datos del alumno */
    $("#botonBuscar").on("click", function () {
        mensajeAlumno.innerText = "Cargando...";
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/sesion/' + numControl.value,
            dataType: 'json',
            success: function (data) {
                esAlumnoValido(data);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 401) {
                location.reload()
            } else {
                console.log('error: ' + textStatus + ' ' + errorThrown);
            }
        });
    });

    /* Validación para el formulario */
    const form = $("#formSesion");
    const carga = new ShowLoading(pantallaCarga);
    carga.setPageLoading();

    form.on('submit', function (event) {
        form.addClass('was-validated');
        event.preventDefault();
        event.stopPropagation();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/sesion/' + numControl.value,
            dataType: 'json',
            success: function (alumno) {
                let alumnoValido = esAlumnoValido(alumno);
                //Si el alumno y campos del formulario son válidos
                if (alumnoValido && form.get(0).checkValidity()) {
                    carga.onLoading();
                    form.unbind('submit').submit()
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 401) {
                location.reload()
            } else {
                console.log('error: ' + textStatus + ' ' + errorThrown);
            }
        });
    });

    /** Evalúa si el alumno es apto para un nuevo préstamo, 
     * en base a la información obtenida al consultar la existencia 
     * del registro del estudiante o algún préstamo activo.
     */
    function esAlumnoValido(alumno) {
        if (alumno.id == null) { //No halló registro del alumno.
            mensajeAlumno.innerText = 'El alumno no está registrado; continúa manualmente.';
            if (!nombre.disabled) { //Si los campos de alumno están habilitados para llenar.
                return true;
            } else { //Los campos estaban completados y deshabilitados por encontrar otro núm. de control.
                deshabilitarCampos(false);
                vaciarCampos();
                return false;
            }
        } else if (alumno.prestamo != null) {
            /* Sesión activa del alumno */
            mensajeAlumno.innerText = 'El alumno tiene una sesión de préstamo activa.';
            deshabilitarCampos(true); //Deshabilitar campos.
            vaciarCampos();
            return false;
        } else {
            /* No hay problemas */
            mensajeAlumno.innerText = "";
            nombre.value = alumno.name;
            apellidos.value = alumno.lastName;
            semestre.value = alumno.semester;
            carrera.value = alumno.career;
            deshabilitarCampos(true); //Deshabilitar campos.
            return true;
        }
    }

    function vaciarCampos() {
        nombre.value = "";
        apellidos.value = "";
        semestre.value = "";
        carrera.value = "";
    }

    /**
     * Habilita o deshabilita los campos del estudiante.
     * @param deshabilitar Booleano indicador de habilitado.
     */
    function deshabilitarCampos(deshabilitar) {
        nombre.disabled = deshabilitar;
        apellidos.disabled = deshabilitar;
        semestre.disabled = deshabilitar;
        carrera.disabled = deshabilitar;
    }

    /* Cargar tipos de uso */
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/cargarUsos',
        dataType: 'json',
        success: function (data) {
            if (data[0].name != null) {
                for (let i = 0; i < data.length; i++) {
                    $('#uso').append('<option ' +
                        'value="' + data[i].id + '">' +
                        data[i].name + '</option>');
                }
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log('error: ' + textStatus + ' ' + errorThrown);
    });

    /* Cargar carreras */
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
                    $("#selectCarreras").append('<option value="' + data[i] + '">' + data[i] + '</option>');
                }
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log('error: ' + textStatus + ' ' + errorThrown);
    });

    /* Cargar equipos disponibles */
    const mensajeCarga = document.getElementById("msgEquipo");
    mensajeCarga.innerText = "Cargando...";
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
                    $('#equipos').append('<option value="' + data[i].id + '">' +
                        data[i].id + '</option>');
                }
                mensajeCarga.innerText = "";
            } else {
                mensajeCarga.innerText = "No hay ningún equipo disponible.";
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log('error: ' + textStatus + ' ' + errorThrown);
    });

    /* Resaltar equipos acordes al cambiar de opción de uso */
    $("#uso").on("change", function () {
        //Aquellos equipos que tengan programas relacionados al uso

    });
});
