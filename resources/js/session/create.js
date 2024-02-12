import ShowLoading from "../utils/showLoading";

/* Obtener los tipos de uso registrados y equipos disponibles */
$(document).ready(function () {
    let haySesionActiva;
    const pantallaCarga = document.getElementById("section-loading");

    /* Validación para el formulario */
    const form = document.querySelector('.formRegistro');
    const carga = new ShowLoading(pantallaCarga);
    carga.setPageLoading();

    form.addEventListener('submit', function (event) {
        form.classList.add('was-validated');
        if (!form.checkValidity() || haySesionActiva) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            carga.onLoading();
        }
    }, false);

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
                    $('#uso').append('<option value="' + data[i].id + '">' +
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

    const mensajeAlumno = document.getElementById("msgNumControl");
    const registrado = document.getElementById("registrado");
    const nombre = document.getElementById("nombre");
    const apellidos = document.getElementById("apellidos");
    const semestre = document.getElementById("semestre");
    const carrera = document.getElementById("selectCarreras");

    /* Autocompletar datos del alumno */
    $("#botonBuscar").on("click", function () {
        /* El campo perdió el enfoque */
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/sesion/' + numControl.value,
            dataType: 'json',
            success: function (data) {
                console.log(data)
                if (data.name == null) {
                    /* Consulta vacía */
                    haySesionActiva = false;
                    registrado.value = 0;
                    mensajeAlumno.innerText = 'El alumno no está registrado continúa manualmente.';
                    cambiarCampos(false); //Habilitar campos.
                    vaciarCampos();
                } else {
                    registrado.value = 1;
                    if (data.prestamo != null) {
                        /* Sesión activa del alumno */
                        haySesionActiva = true;
                        mensajeAlumno.innerText = 'El alumno tiene una sesión de préstamo activa.';
                        cambiarCampos(true); //Deshabilitar campos.
                        vaciarCampos();
                    } else {
                        /* No hay problemas */
                        haySesionActiva = false;
                        mensajeAlumno.innerText = "";
                        nombre.value = data.name;
                        apellidos.value = data.lastName;
                        semestre.value = data.semester;
                        carrera.value = data.career;
                        cambiarCampos(true); //Deshabilitar campos.
                    }
                }
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log('error: ' + textStatus + ' ' + errorThrown);
        });

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
        function cambiarCampos(deshabilitar) {
            nombre.disabled = deshabilitar;
            apellidos.disabled = deshabilitar;
            semestre.disabled = deshabilitar;
            carrera.disabled = deshabilitar;
        }
    });

    /* Resaltar equipos acordes al cambiar de opción de uso */
    $("#uso").on("change", function () {

    });
});
