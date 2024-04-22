/**
* Configura el evento para reasignar el equipo de una sesión,
* en función de los componentes de donde se llame.
* @param select El select en cuál listar los equipos disponibles.
* @param btnConfirmar El botón de envío del formulario.
* @param mensaje Elemento donde mostrar el estado de la operación.
*/
export function cargarEquiposDisponibles(select, btnConfirmar, mensaje) {
    if (select.children("option").length == 0) { //Si no se han cargado los equipos al select.
        btnConfirmar.disabled = true; //Deshabilitado hasta listar los equipos.
        mensaje.innerText = "Cargando equipos...";
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
                        select.append('<option value="' + data[i].id + '">' + data[i].id + '</option>');
                    }
                    btnConfirmar.disabled = false;
                    mensaje.innerText = "";
                } else {
                    mensaje.innerText = 'No hay ningún equipo disponible.';
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

/**
 * Hace la acción del form proporcionado con una petición ajax, en función de los componentes de donde se llame. 
 * para manipular la respuesta obtenida y si ocurre, mostrar error con los campos ingresados
 * @param form Formulario cuya acción se lleva a cabo.
 * @param mensaje Elemento donde informar sobre posible error.
 */
export function interpretarResponse(form, mensaje) {
    $.ajax({
        headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: form.attr("action"),
        data: new FormData(form.get(0)),
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.error) { //Mostrar mensaje de error
                mensaje.innerText = response.error;
            } else if (response.redireccion) { //Redirigir
                window.location.href = response.redireccion;
            } else { //Expiró la sesión
                location.reload()
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
