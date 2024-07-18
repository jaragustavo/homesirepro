var usuario_chat = 0;
$(document).ready(function() {
    document.getElementById("header_chat").style.display = "none"; //show
    document.getElementById("body_chat").style.display = "none"; //show
    document.getElementById("escribir_mensaje").style.display = "none"; //show
});

// Carga el chat al seleccionar a uno del listado
function cargarChat(chat_id){
    //show
    document.getElementById("header_chat").style.display = "block"; 
    document.getElementById("body_chat").style.display = "block"; 
    document.getElementById("escribir_mensaje").style.display = "block"; 
    usuario_chat = chat_id;
    $.post("../../controller/mensaje.php?op=cargarChat", { chat_id: chat_id }, function(data) {
        const divChat = document.getElementById("listado_mensajes");
        divChat.innerHTML = "";
        var conversations = JSON.parse(data);
        var nameChat = "";
        for (var i = 0; i < conversations.length; i++) {
            var row = conversations[i];
            const divElement = document.createElement("div");
            // Se crea el div dependiendo si es un mensaje recibido o enviado
            if(row.remitente_id != row.usuario_id){
                divElement.innerHTML = 
                '<div class="messenger-message-container">'+
                    '<div class="avatar"><img src="https://sirepro.mspbs.gov.py/foto/'+row.cedula_chat+'.jpg"></div>'+
                    '<div class="messages">'+
                        '<ul><li>'+
                            '<div class="message"><div>'+row.mensaje+'</div></div>'+
                            '<div class="time-ago">'+ row.hora +'</div>'+
                        '</li></ul>'+
                    '</div>'+
                '</div>';
                nameChat = row.nombre_remitente;
            }
            else{
                divElement.innerHTML = 
                '<div class="messenger-message-container from bg-blue" style="margin-left: auto;margin-right: 0;">'+
                    '<div class="messages">'+
                        '<ul><li>'+
                            '<div class="time-ago">'+ row.hora +'</div>'+
                            '<div class="message"><div>'+row.mensaje+'</div></div>'+
                        '</li></ul>'+
                    '</div>'+
                    '<div class="avatar chat-list-item-photo"><img src="https://sirepro.mspbs.gov.py/foto/'+row.cedula_usuario+'.jpg"></div>'+
                '</div>';
                nameChat = row.nombre_destinatario;
                
            }
            divChat.appendChild(divElement);
            actualizarEstado(row.mensaje_id, row.ind_estado, row.usuario_id, row.remitente_id);
        }
        $(".name_chat").text(nameChat);
        $("#chat-list-item").load(location.href + " #chat-list-item");
        $("#header_mensajes").load(location.href + " #header_mensajes");
    });
}
// Actualiza el estado a 'Leido' de todos los mensajes recibidos del chat que se abre
function actualizarEstado(mensaje_id, estado, usuario_id, remitente_id) {
    if(estado=="No leido" && usuario_id != remitente_id){
        $.post("../../controller/mensaje.php?op=actualizarEstado", 
        { mensaje_id: mensaje_id, nuevo_estado: 'Leido' });
    }
}

const elem = document.getElementById("nuevo_mensaje");

elem.addEventListener("keypress", (event)=> {
    if (event.key === 'Enter') { // key code of the keybord key
        event.preventDefault();
        var mensaje_nuevo = document.getElementById("nuevo_mensaje").value;
        if(mensaje_nuevo != ""){
            $.post("../../controller/mensaje.php?op=enviarMensaje", 
            { destinatario_id: usuario_chat, nuevo_mensaje: mensaje_nuevo}, function(data){
                // console.log(data);
                var newMsg = JSON.parse(data);
                mostrarNuevoMensaje(newMsg);
            });
            
        }
        document.getElementById("nuevo_mensaje").value = "";
    }
  });

function mostrarNuevoMensaje(data){
    $("#chat-list-item").load(location.href + " #chat-list-item");
    const divChat = document.getElementById("listado_mensajes");
    const divElement = document.createElement("div");
    divElement.innerHTML = 
        '<div class="messenger-message-container from bg-blue" style="margin-left: auto;margin-right: 0;">'+
            '<div class="messages">'+
                '<ul><li>'+
                    '<div class="time-ago">'+ data.hora +'</div>'+
                    '<div class="message"><div>'+data.mensaje+'</div>'+
                '</li></ul>'+
            '</div>'+
            '<div class="avatar chat-list-item-photo"><img src="https://sirepro.mspbs.gov.py/foto/'+data.cedula_usuario+'.jpg"></div>'+
        '</div>';
    divChat.appendChild(divElement);
  }