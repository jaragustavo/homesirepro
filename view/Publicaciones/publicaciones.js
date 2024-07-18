function init() {
}

$(document).ready(function () {
    // Get the current URL
    var currentUrl = window.location.href;

    // Si la página es del perfil de otro usuario, entrará en el if
    if (currentUrl.indexOf("perfilUsuario.php") !== -1) {
        // The URL contains "perfilUsuario.php"
        var usuario_visitado_id = $("#usuario_visitado_id").val();
        console.log(usuario_visitado_id);
        $.post("../../controller/publicacion.php?op=datosPerfilVisitado",{usuario_visitado_id: usuario_visitado_id}, function (data) {
            data = JSON.parse(data);
            if (data != "error") {
                $('#nombre_perfil').val(data["nombre_perfil"]);
                $('#acerca_de_mi').val(data["acerca_de_mi"]);
                document.getElementById('parrafo_acerca_de_mi').innerText = data["acerca_de_mi"];
                $('#ciudad_trabajo').val(data["ciudad_trabajo_id"]);
                var paragraph = document.getElementById("parrafo_ciudad_trabajo");
                var text = document.createTextNode(data["ciudad_trabajo_nombre"]);
                paragraph.appendChild(text);
                $('#ciudad_trabajo').trigger('change');
                $('#profesion_principal').val(data["profesion_principal_id"]);
                $('#profesion_principal').trigger('change');
                $('#educacion').val(data["educacion"]);
                paragraph = document.getElementById("parrafo_educacion");
                text = document.createTextNode(data["educacion"]);
                paragraph.appendChild(text);
                $('#lugar_trabajo').val(data["lugar_trabajo_id"]);
                $('#lugar_trabajo').trigger('change');
                paragraph = document.getElementById("parrafo_lugar_trabajo");
                text = document.createTextNode(data["lugar_trabajo_nombre"]);
                paragraph.appendChild(text);
            }
            if(data["ciudad_trabajo_nombre"] == null){
                var element = document.getElementById("parrafo_ciudad_trabajo");
                element.style.display = "none";
            }
            if(data["educacion"] == null){
                var element = document.getElementById("parrafo_educacion");
                element.style.display = "none";
            }
            if(data["lugar_trabajo_nombre"] == null){
                var element = document.getElementById("parrafo_lugar_trabajo");
                element.style.display = "none";
            }
        });
        
    } else {
        //Carga todas las ciudades
        $.post("../../controller/publicacion.php?op=comboCiudades", function (data) {
            $('#ciudad_trabajo').html(data);
        });
        //Cargar las profesiones del sistema
        $.post("../../controller/publicacion.php?op=comboProfesiones", function (data) {
            $('#profesion_principal').html(data);
        });
        //Cargar los establecimientos de salud
        $.post("../../controller/publicacion.php?op=comboEstablecimientos", function (data) {
            $('#lugar_trabajo').html(data);
        });

        $.post("../../controller/publicacion.php?op=datosPerfil", function (data) {
            data = JSON.parse(data);
            if (data != "error") {
                $('#nombre_perfil').val(data["nombre_perfil"]);
                $('#acerca_de_mi').val(data["acerca_de_mi"]);
                document.getElementById('parrafo_acerca_de_mi').innerText = data["acerca_de_mi"];
                $('#ciudad_trabajo').val(data["ciudad_trabajo_id"]);
                var paragraph = document.getElementById("parrafo_ciudad_trabajo");
                var text = document.createTextNode(data["ciudad_trabajo_nombre"]);
                paragraph.appendChild(text);
                $('#ciudad_trabajo').trigger('change');
                $('#profesion_principal').val(data["profesion_principal_id"]);
                $('#profesion_principal').trigger('change');
                $('#educacion').val(data["educacion"]);
                paragraph = document.getElementById("parrafo_educacion");
                text = document.createTextNode(data["educacion"]);
                paragraph.appendChild(text);
                $('#lugar_trabajo').val(data["lugar_trabajo_id"]);
                $('#lugar_trabajo').trigger('change');
                paragraph = document.getElementById("parrafo_lugar_trabajo");
                text = document.createTextNode(data["lugar_trabajo_nombre"]);
                paragraph.appendChild(text);
            }
            else {
                console.log(data);

                $.post("../../controller/publicacion.php?op=crearPerfil", function (data) {
                    $('#nombre_perfil').val(data);
                });
            }
        });
    }

});

/*=============================================
CREA LA NUEVA PUBLICACION
=============================================*/
const result = 0;
async function postear() {
    // JavaScript Program to convert date to number
    // creating the new date
    const d1 = new Date();

    // converting to number
    const nombre_carpeta = d1.getTime();

    // Use Promise.all to wait for all asynchronous operations to complete
    await Promise.all(selectedFiles.map(async (file) => {
        const datosMultimedia = new FormData();
        datosMultimedia.append("file", file);
        datosMultimedia.append("folder_name", nombre_carpeta);

        try {
            await $.ajax({
                url: "../../controller/publicacion.php?op=subirArchivo",
                method: "POST",
                data: datosMultimedia,
                cache: false,
                contentType: false,
                processData: false
            });
        } catch (error) {
            // Handle errors if necessary
            console.error("Error uploading file:", error);
        }
    }));

    // This will be executed after all asynchronous operations are completed
    guardarPublicacion(nombre_carpeta);
}

function guardarPublicacion(nombre_carpeta) {
    var formData = new FormData($("#data_nuevo_post")[0]);
    var e = document.getElementById("visibilitySelect");

    var strUser = e.value;
    if (strUser == "public") {
        formData.append("publico", true);
    }
    else {
        formData.append("publico", false);
    }
    formData.append("folder_name", nombre_carpeta);
    $.ajax({
        url: "../../controller/publicacion.php?op=subirPublicacion",
        method: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {

            if (data = "Publicado exitosamente") {
                $.notify({
                    title: "¡Listo!",
                    message: "Se creó la nueva publicación"
                });
            }
            else {
                $.notify({
                    icon: 'font-icon font-icon-warning',
                    title: '<strong>Error!</strong>',
                    message: 'Hubo un error al intentar crear su publicación. Inténtelo de nuevo.'
                }, {
                    placement: {
                        align: "center"
                    }
                });
            }

        }
    });
}

function likePublicacion(publicacion_id) {
    $.post("../../controller/publicacion.php?op=likePublicacion", { publicacion_id: publicacion_id }, function (data, status) {
        myDiv = 'counters' + publicacion_id;
        if (data == "ok") {
            $("#" + myDiv).load(" #" + myDiv + " > *");
        }
    });

}

function seguirUsuario(usuario_ci) {
    $.post("../../controller/publicacion.php?op=seguirUsuario", { usuario_ci: usuario_ci }, function (data, status) {

        if (data == "ok") {
            $("#profile_side_user").load(" #profile_side_user > *");
        }
    });
}



function guardarDatosPerfil() {
    /* TODO: Array del form Documento Personal */
    var formData = new FormData($("#datos_perfil_form")[0]);

    /* TODO: validamos si los campos tienen informacion antes de guardar */
    if ($('#nombre_perfil').val() == '') {
        Swal.fire("Advertencia!", "Debe tener un nombre de perfil", "warning");
    } else {
        /* TODO: Actualizar datos del perfil */
        $.ajax({
            url: "../../controller/publicacion.php?op=actualizarPerfil",
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {

                if (data == "ok") {
                    $("#tabs-2-tab-4").load(" #tabs-2-tab-4 > *");
                }

            }
        });
    }
}

function enviarComentario(publicacion_id) {
    var nuevo_comentario = $('#nuevo_comentario' + publicacion_id).val();
    console.log(nuevo_comentario);
    if (nuevo_comentario == '') {
        Swal.fire("Advertencia!", "Debe escribir algo", "warning");
    } else {
        /* TODO: Actualizar datos del perfil */
        $.ajax({
            url: "../../controller/publicacion.php?op=comentarPosteo",
            method: "POST",
            data: {
                nuevo_comentario: nuevo_comentario,
                publicacion_id: publicacion_id
            },
            success: function (data) {
                if (data == "ok") {
                    $("#nuevo_comentario" + publicacion_id).val("");
                    $("#comentarios_post" + publicacion_id).load(" #comentarios_post" + publicacion_id + "> *");
                    $("#counters" + publicacion_id).load(" #counters" + publicacion_id + "> *");
                }
            }
        });
    }
}

