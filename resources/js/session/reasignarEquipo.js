/**
* Configura el evento para reasignar el equipo de una sesión, en función de dónde se llame.
* @param select El select en cuál listar los equipos disponibles.
* @param btnConfirmar El botón de envío del formulario.
* @param msj Mensaje para mostrar el estado de la operación.
*/
export function configurarReasignarEquipo(select, btnConfirmar, msj) {
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
               console.log(data)
               if (data[0] != null) {
                   for (let i = 0; i < data.length; i++) {
                       select.append('<option value="' + data[i].id + '">' + data[i].id + '</option>');
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