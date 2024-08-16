var tabla;
//Se utiliza para listar los documentos del usuario
var usu_id = $('#user_idx').val();
var idEncrypted = "";

function init() {
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
            onPaste: function(e) {
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

    $(document).ready(function() {
        $('#reposos_data').DataTable({
            "processing": true,
            "serverSide": true,
            "dom": 'rtip',
            "lengthChange": false,
            "colReorder": true,
            "ordering": false, // Desactiva el ordenamiento en todas las columnas
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                "url": '../../controller/reposo.php?op=listar_x_medico',
                "type": "post",
                "dataType": "json",
                "data": { usu_id: usu_id },
                "error": function(e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "responsive": true,
            "info": true,
            "pageLength": 10, // Corregido para iDisplayLength
            "autoWidth": false,
            "language": {
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "info": "Mostrando un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "loadingRecords": "Cargando...",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });


    var currentURL = window.location.href;
    // Use a regular expression to extract the ID from the URL
    var match = currentURL.match(/[\?&]ID=([^&]*)/);
    // // Check if a match is found
    if (match) {
        // Extracted ID is in match[1]
        idEncrypted = match[1];
        cargarReposo(idEncrypted);
    }
});

/* TODO: Link para poder ver el detalle de documento academico */
$(document).on("click", ".btn-inline", function() {
    const ciphertext = $(this).data("ciphertext");
    window.location.replace('http://localhost:90/homesirepro/view/Reposos/verDetalleReposo.php?ID=' + ciphertext + '');
});

/* TODO:Filtro avanzado */
$(document).on("click", "#btnfiltrar", function() {

    var ci_paciente = $('#ci_paciente').val();
    var nombre_paciente = $('#nombre_paciente').val();
    var fecha_inicio_reposo = $('#fecha_inicio_reposo').val();

    listardatatable(ci_paciente, nombre_paciente, fecha_inicio_reposo);

});

$(document).on("click", "#btnfiltrar", function() {

    var ci_paciente = $('#ci_paciente').val();
    var nombre_paciente = $('#nombre_paciente').val();
    var fecha_inicio_reposo = $('#fecha_inicio_reposo').val();

    listardatatable(ci_paciente, nombre_paciente, fecha_inicio_reposo);

});

function listardatatable(ci_paciente, nombre_paciente, fecha_inicio_reposo) {
    tabla = $('#reposos_data').dataTable({
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
            url: '../../controller/reposo.php?op=listar_filtro',
            type: "post",
            dataType: "json",
            data: { ci_paciente: ci_paciente, nombre_paciente: nombre_paciente, fecha_inicio_reposo: fecha_inicio_reposo },
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "ordering": false, // Desactiva el ordenamiento en todas las columnas
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
    }).DataTable().ajax.reload();
}

$(document).on("click", "#btntodo", function() {

    tabla = $('#reposos_data').dataTable({
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
            url: '../../controller/reposo.php?op=listar_x_medico',
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

});

function cargarReposo(idEncrypted) {
    /* TODO: Mostramos informacion del documento en inputs */
    $.post("../../controller/reposo.php?op=mostrar", { idEncrypted: idEncrypted }, function(data) {
        data = JSON.parse(data);
        $('#tipo_documento').val(data.tipo_documento);
        $('#tipo_documento').trigger('change');
        $('#institucion_educativa').val(data.institucion_educativa);
        $('#institucion_educativa').trigger('change');
        $('#imagenmuestra').attr("src", data.documento_ruta);
        $('#dato_adic').summernote('code', data.dato_adic);

        $('#idEncrypted').val(doc_academico_id);
    });
}

/*=============================================
SUBIENDO EL ARCHIVO
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