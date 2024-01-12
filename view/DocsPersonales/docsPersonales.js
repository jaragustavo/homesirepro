var tabla;
//Se utiliza para listar los documentos del usuario
var usu_id = $('#user_idx').val();
var idEncrypted = "";

function init() {
    $("#dato_personal_form").on("submit",function(e){
        guardaryeditar(e);
    });
    actualizar_img();
}

$(document).ready(function() {
    $('#dato_adic').summernote({
        height: 150,
        lang: "es-ES",
        popover: {
            image: [],
            link: [],
            air: []
        },
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });
    $('#viewuser').hide();

    tabla = $('#datos_personales_data').dataTable({
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
            url: '../../controller/documentoPersonal.php?op=listar_x_usu',
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

    /* TODO: Llenar Combo tipos de Documento */
    $.post("../../controller/tipoDocumento.php?op=combo",function(data, status){
        $('#tipo_documento').html(data);
    });
    
    var currentURL = window.location.href;
    if($('#idEncrypted').val() != "" && $('#idEncrypted').val() != null){
        // Use a regular expression to extract the ID from the URL
        // var match = currentURL.match(/[\?&]ID=([^&]*)/);
        // // Check if a match is found
        // if (match) {
        //     // Extracted ID is in match[1]
        //     var idEncrypted = match[1];
        //     cargarDocumentoPersonal(idEncrypted);
            cargarDocumentoPersonal($('#idEncrypted').val());

        // } else {
        //     // No ID found in the URL
        //     console.log("No ID found in the URL");
        // }
    }
    
});

/* TODO: Link para poder ver el detalle de documento personal en otra ventana */
$(document).on("click", ".btn-inline", function() {
    const ciphertext = $(this).data("ciphertext");
    window.location.replace('http://localhost:90/sirepro/view/DocsPersonales/editarDocsPersonales.php?ID=' + ciphertext + '');
    
});

/* TODO: Link para poder ver el eliminar el Documento Personal */
$(document).on("click", ".btn-delete-row", function() {
    var ciphertext = $(this).data("ciphertext");
    
    Swal.fire({
        title: '¿Desea eliminarlo?',
        text: "No podrás revertir esta acción.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar.'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/documentoPersonal.php?op=delete", {ciphertext : ciphertext}, function(e){
                
                if(e == "Documento eliminado"){
                    Swal.fire({
                        title: e,
                        text: "El documento se eliminó correctamente.",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3d85c6",
                        confirmButtonText: "OK"
                    });
                    tabla.ajax.reload();
                }
                else{
                    Swal.fire({
                        title: "Error",
                        text: e,
                        icon: "error",
                        showCancelButton: true,
                        confirmButtonColor: "#3d85c6",
                        confirmButtonText: "OK"
                    });
                }
            });
        }
        
        
      })
});

function guardaryeditar(e){
    e.preventDefault();
    /* TODO: Array del form Documento Personal */
    var formData = new FormData($("#dato_personal_form")[0]);
    /* TODO: validamos si los campos tienen informacion antes de guardar */
    if ($('#dato_adic').summernote('isEmpty') || $('#imagen').val()=='' || $('#tipo_documento').val() == 0){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{

        /* TODO: Guardar Documento Personal */
        if(idEncrypted == ""){
            $.ajax({
                url: "../../controller/documentoPersonal.php?op=insert",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    console.log(data[0].tick_id);

                    /* TODO: Limpiar campos */
                    $('#imagen').val('');
                    $('#dato_adic').summernote('reset');
                    $('#fecha').val('');
                    $('#tipo_documento').val('');
                    
                    Swal.fire({
                        title: "¡Listo!",
                        text: "Registrado Correctamente",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3d85c6",
                        confirmButtonText: "OK"
                    }).then((result) => {    
                        if (result.isConfirmed) {    
                            window.location.replace('listarDocsPersonales.php'); 
                        }
                    });
                    
                }
            });
        }
        else{

            $.ajax({
                url: "../../controller/documentoPersonal.php?op=update&ID="+idEncrypted,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    console.log(data[0].tick_id);
                    
                    Swal.fire({
                        title: "¡Listo!",
                        text: "Modificado Correctamente",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3d85c6",
                        confirmButtonText: "OK"
                    }).then((result) => {   
                        if (result.isConfirmed) {    
                            window.location.replace('listarDocsPersonales.php'); 
                        }
                    });
                }
            });
        }
        
    }
}

function cargarDocumentoPersonal(doc_personal_id){
    /* TODO: Mostramos informacion del documento en inputs */
    $.post("../../controller/documentoPersonal.php?op=mostrar", { doc_personal_id: doc_personal_id }, function(data) {
        // console.log(data);
        data = JSON.parse(data);
        $('#fecha').val(data.fecha);
        $('#tipo_documento').val(data.tipo_documento);
        $('#tipo_documento').trigger('change');
        $('#imagenmuestra').attr("src",data.documento_ruta);
        $('#dato_adic').summernote('code', data.dato_adic);

        $('#idEncrypted').val(doc_personal_id);
    });
}

/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/
function actualizar_img() {
    $(".nuevaImagen").change(function() {
        var imagen = this.files[0];
        /*=============================================
        VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
        =============================================*/
        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" && imagen["type"] != "application/pdf") {
            $(".nuevaImagen").val("");
            swal({
                title: "Error al subir la imagen",
                text: "¡La imagen debe estar en formato PDF, JPG o PNG!",
                // icon: "error",
                confirmButtonText: "¡Cerrar!"
            });

        } else if (imagen["size"] > 2000000) {
            $(".nuevaImagen").val("");
            swal({
                title: "Error al subir la imagen",
                text: "¡La imagen no debe pesar más de 2MB!",
                // icon: "error",
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