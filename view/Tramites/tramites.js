var tabla;
//Se utiliza para listar los documentos del usuario
var usu_id = $('#user_idx').val();
var idEncrypted = "";

function init() {
    $("#tramites_form").on("submit",function(e){
        guardaryeditar(e);
    });
    actualizar_img();
}

$(document).ready(function() {
    // Extraer el ID del registro a modificar
    var currentURL = window.location.href;
    // Use a regular expression to extract the ID from the URL
    var match = currentURL.match(/[\?&]ID=([^&]*)/);
    // // Check if a match is found
    if (match) {
        // Extracted ID is in match[1]
        idEncrypted = match[1];
        cargarTramite(idEncrypted);
    }
    else{
        //Extrae el tipo de trámite a ser gestionado
        var currentURL = window.location.href;
        // Use a regular expression to extract the ID from the URL
        var match = currentURL.match(/[\?&]code=([^&]*)/);
        // // Check if a match is found
        if (match) {
            // Extracted ID is in match[1]
            tramite_gestionado = match[1];
            cargarDocsRequeridos(tramite_gestionado);
            // manejo del formulario
            $("#next-1").click( function(){
                $("#residencia_permanente").show();
                $("#informacion_personal").hide();
                document.getElementById('progress-2').classList.add('active');
            });
            $("#back-1").click( function(){
                $("#residencia_permanente").hide();
                $("#informacion_personal").show();
                document.getElementById('progress-2').classList.remove('active');

            });
            $("#next-2").click( function(){
                $("#formacion").show();
                $("#residencia_permanente").hide();
                document.getElementById('progress-3').classList.add('active');

            });
            $("#back-2").click( function(){
                $("#formacion").hide();
                $("#residencia_permanente").show();
                document.getElementById('progress-3').classList.remove('active');

            });
            $("#next-3").click( function(){
                $("#experiencia_laboral").show();
                $("#formacion").hide();
                document.getElementById('progress-4').classList.add('active');

            });
            $("#back-3").click( function(){
                $("#experiencia_laboral").hide();
                $("#formacion").show();
                document.getElementById('progress-4').classList.remove('active');

            });
            $("#next-4").click( function(){
                $("#confirmacion").show();
                $("#experiencia_laboral").hide();
                $("#progress-1").hide();
                $("#progress-5").show();
                document.getElementById('progress-5').classList.add('active');

            });
            $("#back-4").click( function(){
                $("#confirmacion").hide();
                $("#experiencia_laboral").show();
                $("#progress-5").hide();
                $("#progress-1").show();
                document.getElementById('progress-5').classList.remove('active');

            });
            // manejo del formulario
        }
        else{
            tabla = $('#datos_academicos_data').dataTable({
                "aProcessing": true,
                "aServerSide": true,
                dom: 'rtip',
                lengthChange: false,
                colReorder: true,
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                "ajax": {
                    url: '../../controller/documentoAcademico.php?op=listar_x_usu',
                    type: "post",
                    dataType: "json",
                    data: { usu_id: usu_id },
                    error: function(e) {
                        console.log(e.responseText);
                    }
                },
                "ordering": false,
                "bDestroy": true,
                "responsive": true,
                "bInfo": true,
                "iDisplayLength": 10,
                "autoWidth": false,
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            }).DataTable();
        
            /* TODO: Llenar Combo trámites */
            $.post("../../controller/tramite.php?op=comboTramites",function(data){
                $('#tramite_nuevo').html(data);
                $('#tramite').html(data);
            });
            
            /* TODO: Llenar Combo estados de trámites */
            $.post("../../controller/tramite.php?op=comboEstadosTramites",function(data){
                $('#estado_tramite').html(data);
            });
        }
    }    
});

function abrirNuevoTramite(){
    var tramite = $("#tramite_nuevo option:selected").text();
    var tramiteId = $('#tramite_nuevo').val();
    console.log(tramiteId);
    tramite = camelCase(tramite);
    window.location.replace(tramite+'.php?code='+tramiteId+'');
}

function camelCase(str) {
    // Using replace method with regEx
    return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function (word, index) {
        return index == 0 ? word.toLowerCase() : word.toUpperCase();
    }).replace(/\s+/g, '');
}

function cargarDocsRequeridos(tramite_gestionado){
    /* TODO: Mostramos informacion del documento en inputs */
    $.post("../../controller/tramite.php?op=documentosRequeridos", { tramite_gestionado: tramite_gestionado }, function(data) {
        data = JSON.parse(data);
        x=document.getElementsByClassName("tramite_nombre");  // Find the elements
        for(var i = 0; i < x.length; i++){
            x[i].innerText=data[0].tramite_nombre;    // Change the content
        }
        // var divListadoRequerido = document.getElementById('documentos_requeridos');
        // var ulElement = document.createElement("ul");
        // data.forEach(function(data) {
        //     ulElement.innerHTML +=
        //     '<li>'+ data.tipo_documento +'</li>';
        // });
        // divListadoRequerido.innerHTML = ulElement.innerHTML;
        
    });
}

/*=============================================
SUBIENDO LOS ARCHIVOS
=============================================*/
function actualizar_img() {
    $(".nuevaImagen").change(function() {
        var imagen = this.files[0];
        /*=============================================
        VALIDAMOS EL FORMATO DEL ARCHIVO SEA PDF, JPG O PNG
        =============================================*/
        
        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" && imagen["type"] != "application/pdf") {
            $(".nuevaImagen").val("");
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡La imagen debe estar en formato PDF, JPG o PNG!",
                confirmButtonText: "¡Cerrar!"
            });

        } else if (imagen["size"] > 2000000) {
            $(".nuevaImagen").val("");
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡La imagen no debe pesar más de 2MB!",
                confirmButtonText: "¡Cerrar!"
            });
        } else {
            var datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);
            $(datosImagen).on("load", function(event) {
                var rutaImagen = event.target.result;
                $(".previsualizar").attr("src", rutaImagen);
            });
         }

        
    });
}

init();