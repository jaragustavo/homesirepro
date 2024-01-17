/*=============================================
ACTUALIZAR MENSAJES
=============================================*/

$(".actualizarMensajes").click(function(e) {

    e.preventDefault();

    var usuario_destino_id = $(this).attr("usuario_id");

    var datos = new FormData();

    datos.append("usuario_destino_id", usuario_destino_id);

    $.ajax({

        url: "../ajax/mensajes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {

            window.location = "mensajeUsuario.php";
        }
    })
})