/*=============================================
ACTUALIZAR MENSAJES
=============================================*/

$(document).ready(function() {
    document.getElementById("header_chat").style.display = "none"; //show
    document.getElementById("body_chat").style.display = "none"; //show
    document.getElementById("escribir_mensaje").style.display = "none"; //show
});



function cargarChat(chat_id){
    //show
    document.getElementById("header_chat").style.display = "block"; 
    document.getElementById("body_chat").style.display = "block"; 
    document.getElementById("escribir_mensaje").style.display = "block"; 
    $.post("../../controller/mensaje.php?op=cargarChat", { chat_id: chat_id }, function(data) {
        // console.log(data);
        const divChat = document.getElementById("listado_mensajes");
        divChat.innerHTML = "";
        // const ulRecibidos = document.getElementById("mensajes_recibidos");
        var conversations = JSON.parse(data);
        console.log("#### "+conversations.length);
        var nameChat = "";
        for (var i = 0; i < conversations.length; i++) {
            var row = conversations[i];
            // Create a new <li> element
            const divElement = document.createElement("div");
            console.log("#### "+row.mensaje);
            // Set the text content of the <li> element
            // liElement.textContent = data[i];
            // Append the <li> element to the <ul> element
            if(row.remitente_id != row.usuario_id){
                divElement.innerHTML = 
                '<div class="messenger-message-container">'+
                    '<div class="avatar"><img src="https://sirepro.mspbs.gov.py/foto/'+row.cedula_chat+'.jpg"></div>'+
                    '<div class="messages">'+
                        '<ul><li>'+
                            '<div class="message">'+row.mensaje+'</div>'+
                            '<div class="time-ago">'+ row.hora +'</div>'+
                        '</li></ul>'+
                    '</div>'+
                '</div>';
                nameChat = row.nombre_remitente;
            }
            else{
                divElement.innerHTML = 
                '<div class="messenger-message-container from bg-blue">'+
                    '<div class="messages">'+
                        '<ul><li>'+
                            '<div class="time-ago">'+ row.hora +'</div>'+
                            '<div class="message"><div>'+row.mensaje+'</div>'+
                        '</li></ul>'+
                    '</div>'+
                    '<div class="avatar chat-list-item-photo"><img src="https://sirepro.mspbs.gov.py/foto/'+row.cedula_usuario+'.jpg"></div>'+
                '</div>';
                nameChat = row.nombre_destinatario;
                
            }
            divChat.appendChild(divElement);
        }
        $(".name_chat").text(nameChat);
    });
}

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