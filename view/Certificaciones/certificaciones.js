var tabla;
//Se utiliza para listar los documentos del usuario
var idEncrypted = "";
var arrayFiles = [];
var arrayId = [];

function init() {

    actualizar_img();
}

$(document).ready(function () {
    $('#observacion').summernote({
        height: 150,
        lang: "es-ES",
        popover: {
            image: [],
            link: [],
            air: []
        },
        callbacks: {
            onImageUpload: function (image) {
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

    // // // Check if a match is found
    // var currentURL = window.location.href;
    // // Use a regular expression to extract the ID from the URL
    // var match_code = currentURL.match(/[\?&]code=([^&]*)/);
    tabla = $('#certificaciones_data').dataTable({
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
            url: '../../controller/certificacion.php?op=listar_x_usu',
            type: "post",
            dataType: "json",
            error: function (e) {
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

    // if (match_code) {
    //     $('#tramite_code').val(match_code[1]);
    // }
    // manejo del formulario
    $(".progress-1").click(function () {
        $("#parte_1").show();
        $("#parte_2").hide();
        $("#parte_3").hide();
        $("#parte_4").hide();
        $("#parte_5").hide();
        $("#parte_6").hide();
        $("#parte_7").hide();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.remove('active');
        document.getElementById('progress-3').classList.remove('active');
        document.getElementById('progress-4').classList.remove('active');
        document.getElementById('progress-5').classList.remove('active');
        document.getElementById('progress-6').classList.remove('active');
        document.getElementById('progress-7').classList.remove('active');
    });
    $(".progress-2").click(function () {
        $("#parte_1").hide();
        $("#parte_2").show();
        $("#parte_3").hide();
        $("#parte_4").hide();
        $("#parte_5").hide();
        $("#parte_6").hide();
        $("#parte_7").hide();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.add('active');
        document.getElementById('progress-3').classList.remove('active');
        document.getElementById('progress-4').classList.remove('active');
        document.getElementById('progress-5').classList.remove('active');
        document.getElementById('progress-6').classList.remove('active');
        document.getElementById('progress-7').classList.remove('active');
    });
    $(".progress-3").click(function () {
        $("#parte_1").hide();
        $("#parte_2").hide();
        $("#parte_3").show();
        $("#parte_4").hide();
        $("#parte_5").hide();
        $("#parte_6").hide();
        $("#parte_7").hide();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.add('active');
        document.getElementById('progress-3').classList.add('active');
        document.getElementById('progress-4').classList.remove('active');
        document.getElementById('progress-5').classList.remove('active');
        document.getElementById('progress-6').classList.remove('active');
        document.getElementById('progress-7').classList.remove('active');

        $("#progress-1").show();
        $("#progress-5").hide();
    });
    $(".progress-4").click(function () {
        $("#parte_1").hide();
        $("#parte_2").hide();
        $("#parte_3").hide();
        $("#parte_4").show();
        $("#parte_5").hide();
        $("#parte_6").hide();
        $("#parte_7").hide();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.add('active');
        document.getElementById('progress-3').classList.add('active');
        document.getElementById('progress-4').classList.add('active');
        document.getElementById('progress-5').classList.remove('active');
        document.getElementById('progress-6').classList.remove('active');
        document.getElementById('progress-7').classList.remove('active');

        $("#progress-1").hide();
        $("#progress-5").show();
    });
    $(".progress-5").click(function () {
        $("#parte_1").hide();
        $("#parte_2").hide();
        $("#parte_3").hide();
        $("#parte_4").hide();
        $("#parte_5").show();
        $("#parte_6").hide();
        $("#parte_7").hide();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.add('active');
        document.getElementById('progress-3').classList.add('active');
        document.getElementById('progress-4').classList.add('active');
        document.getElementById('progress-5').classList.add('active');
        document.getElementById('progress-6').classList.remove('active');
        document.getElementById('progress-7').classList.remove('active');

        $("#progress-2").hide();
        $("#progress-6").show();
    });
    $(".progress-6").click(function () {
        $("#parte_1").hide();
        $("#parte_2").hide();
        $("#parte_3").hide();
        $("#parte_4").hide();
        $("#parte_5").hide();
        $("#parte_6").show();
        $("#parte_7").hide();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.add('active');
        document.getElementById('progress-3').classList.add('active');
        document.getElementById('progress-4').classList.add('active');
        document.getElementById('progress-5').classList.add('active');
        document.getElementById('progress-6').classList.add('active');
        document.getElementById('progress-7').classList.remove('active');
        $("#progress-3").hide();
        $("#progress-7").show();
    });
    $(".progress-7").click(function () {
        $("#parte_1").hide();
        $("#parte_2").hide();
        $("#parte_3").hide();
        $("#parte_4").hide();
        $("#parte_5").hide();
        $("#parte_6").hide();
        $("#parte_7").show();
        document.getElementById('progress-1').classList.add('active');
        document.getElementById('progress-2').classList.add('active');
        document.getElementById('progress-3').classList.add('active');
        document.getElementById('progress-4').classList.add('active');
        document.getElementById('progress-5').classList.add('active');
        document.getElementById('progress-6').classList.add('active');
        document.getElementById('progress-7').classList.add('active');
    });
    $("#next-1").click(function () {
        $("#parte_2").show();
        $("#parte_1").hide();
        document.getElementById('progress-2').classList.add('active');
    });
    $("#back-1").click(function () {
        $("#parte_2").hide();
        $("#parte_1").show();
        document.getElementById('progress-2').classList.remove('active');

    });
    $("#next-2").click(function () {
        $("#parte_3").show();
        $("#parte_2").hide();
        document.getElementById('progress-3').classList.add('active');

    });
    $("#back-2").click(function () {
        $("#parte_3").hide();
        $("#parte_2").show();
        document.getElementById('progress-3').classList.remove('active');

    });
    $("#next-3").click(function () {
        $("#parte_4").show();
        $("#parte_3").hide();
        $("#progress-1").hide();
        $("#progress-5").show();
        document.getElementById('progress-4').classList.add('active');

    });
    $("#back-3").click(function () {
        $("#parte_4").hide();
        $("#parte_3").show();
        $("#progress-5").hide();
        $("#progress-1").show();
        document.getElementById('progress-4').classList.remove('active');

    });
    $("#next-4").click(function () {
        $("#parte_5").show();
        $("#parte_4").hide();
        $("#progress-2").hide();
        $("#progress-6").show();
        document.getElementById('progress-5').classList.add('active');

    });
    $("#back-4").click(function () {
        $("#parte_5").hide();
        $("#parte_4").show();
        $("#progress-6").hide();
        $("#progress-2").show();
        document.getElementById('progress-5').classList.remove('active');

    });
    $("#next-5").click(function () {
        $("#parte_6").show();
        $("#parte_5").hide();
        $("#progress-3").hide();
        $("#progress-7").show();
        document.getElementById('progress-6').classList.add('active');

    });
    $("#back-5").click(function () {
        $("#parte_6").hide();
        $("#parte_5").show();
        $("#progress-7").hide();
        $("#progress-3").show();
        document.getElementById('progress-6').classList.remove('active');

    });
    $("#next-6").click(function () {
        $("#parte_7").show();
        $("#parte_6").hide();
        document.getElementById('progress-7').classList.add('active');

    });
    $("#back-6").click(function () {
        $("#parte_7").hide();
        $("#parte_6").show();
        document.getElementById('progress-7').classList.remove('active');

    });
    // manejo del formulario

    // Llenar combo Estado Civil
    $.post("../../controller/tramite.php?op=comboEstadoCivil", function (data) {
        $('#estado_civil').html(data);
    });
    // Llenar combo países
    $.post("../../controller/tramite.php?op=comboPaises", function (data) {
        $('#pais_nacimiento').html(data);
        $('#pais_titulo').html(data);
        $('#pais_postgrado').html(data);
    });
    // LLenar combo departamentos para la residencia permanente
    $.post("../../controller/tramite.php?op=comboDepartamentos", { pais: "Paraguay" }, function (data) {
        $('#departamento_residencia').html(data);
        $('#departamento_publico').html(data);
        $('#departamento_privado').html(data);
    });
    // Llenar combo países
    $.post("../../controller/documentoAcademico.php?op=comboInstituciones", function (data) {
        $('#institucion_titulo').html(data);
        $('#institucion_postgrado').html(data);
    });

    // Llenar combo titulos
    $.post("../../controller/certificacion.php?op=comboTitulos", function (data) {
        $('#titulo_obtenido').html(data);
        $('#titulo_postgrado').html(data);
    });


    // }


    /* TODO: Llenar Combo trámites */
    $.post("../../controller/tramite.php?op=comboTramites", function (data) {
        $('#tramite_nuevo').html(data);
        $('#tramite').html(data);
    });

    /* TODO: Llenar Combo estados de trámites */
    $.post("../../controller/tramite.php?op=comboEstadosTramites", function (data) {
        $('#estado_tramite').html(data);
    });

    // Extraer el ID del registro a modificar
    var currentURL = window.location.href;
    // Use a regular expression to extract the ID from the URL
    var match = currentURL.match(/[\?&]ID=([^&]*)/);
    if (match) {
        // Extracted ID is in match[1]
        idEncrypted = match[1];
        cargarInscripcion(idEncrypted);

        $('#idEncrypted').val(idEncrypted);

    }
    else {
        $('#idEncrypted').val("");
        // Check if a match is found

    }




    /*=============================================
    AGREGAR MULTIMEDIA CON DROPZONE
    =============================================*/

    $(".multimediaFisica").dropzone({
        url: "plugins/dropzone/dropzone.js",
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg, image/png, application/pdf",
        maxFilesize: 5,
        maxFiles: 1,
        init: function () {
            this.on("addedfile", function (file) {
                arrayFiles.push({ id: id, value: file });
                arrayId.push(id);
            })
            this.on("removedfile", function (file) {
                var index = arrayFiles.indexOf(file);
                arrayFiles.splice(index, 1);
                arrayId.splice(index);

            })

        }

    })

});
var id = 0;
function cargarIdDoc(idDiv) {
    id = idDiv;
}

// function cargarDptos(){
//     var pais=$('#pais_nacimiento').val();
//     $.post("../../controller/tramite.php?op=comboDepartamentos",{pais: pais},function(data){
//         $('#departamento_nacimiento').html(data);
//     });

// }

function cargarDptos(callback) {
    var pais = $('#pais_nacimiento').val();

    $.post("../../controller/tramite.php?op=comboDepartamentos", { pais: pais }, function (data) {
        $('#departamento_nacimiento').html(data);

        // Call the callback function if provided
        if (typeof callback === "function") {
            callback();
        }
    });
}

function cargarBarrios(ciudad) {
    if(ciudad == ""){
        var ciudad = $('#ciudad_residencia').val();
    }
    $.post("../../controller/tramite.php?op=comboBarrios", { ciudad: ciudad }, function (data) {
        $('#barrio_residencia').html(data);
    });
}

function cargarCiudades(dpto_id) {
    var departamento = 0;
    if (dpto_id == "departamento_nacimiento") {
        departamento = $('#departamento_nacimiento').val();
    }
    else if (dpto_id == "departamento_residencia") {
        departamento = $('#departamento_residencia').val();
    }
    else if (dpto_id == "departamento_publico") {
        departamento = $('#departamento_publico').val();
    }
    else if (dpto_id == "departamento_privado") {
        departamento = $('#departamento_privado').val();
    }
    $.post("../../controller/tramite.php?op=comboCiudades", { departamento: departamento }, function (data) {
        if (dpto_id == "departamento_nacimiento") {
            $('#ciudad_nacimiento').html(data);
        }
        else if (dpto_id == "departamento_residencia") {
            $('#ciudad_residencia').html(data);
        }
        else if (dpto_id == "departamento_publico") {
            $('#ciudad_publico').html(data);
        }
        else if (dpto_id == "departamento_privado") {
            $('#ciudad_privado').html(data);
        }

    });
}

async function guardarDocsTramites(estado_tramite) {
    try {
        await Promise.all(arrayFiles.map(async (file) => {
            const datosMultimedia = new FormData();
            datosMultimedia.append("id", file.id);
            datosMultimedia.append("file", file.value);
            datosMultimedia.append('tramite_code', $('#tramite_code').val());

            try {
                await $.ajax({
                    url: "../../controller/tramite.php?op=insertDocumentos",
                    method: "POST",
                    data: datosMultimedia,
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } catch (error) {
                // Handle errors if necessary
                console.error("Error uploading document:", error);
                throw error; // Re-throw the error to break out of Promise.all
            }
        }));

        // All AJAX requests are complete
        guardarSolicitud(estado_tramite);

    } catch (error) {
        // Handle any error that might occur during the process
        console.error("Error in guardarDocsTramites:", error);
    }
}

function guardarSolicitud(estado_tramite) {

    /* TODO: Array del form inscripción */
    var formData = new FormData($("#inscripcion_registro_form")[0]);
    formData.append('tramite_code', $('#tramite_code').val());
    formData.append('tiposDocumentos', JSON.stringify(arrayId));
    formData.append('estado_tramite', estado_tramite);
    formData.append('nivel', nivel);
    /* TODO: Guardar inscripción */

    $.ajax({
        url: "../../controller/certificacion.php?op=insert",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data == "ok") {
                Swal.fire({
                    title: "¡Listo!",
                    text: "Registrado Correctamente",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#3d85c6",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('listarCertificaciones.php');
                    }
                });
            }
            else {
                Swal.fire({
                    title: "Error",
                    text: data,
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3d85c6",
                    confirmButtonText: "OK"
                });
            }

        }
    });
}


/*=============================================
SUBIENDO LOS ARCHIVOS
=============================================*/
function actualizar_img() {
    $(".nuevaImagen").change(function () {
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
            $(datosImagen).on("load", function (event) {
                var rutaImagen = event.target.result;
                $(".previsualizar").attr("src", rutaImagen);
            });
        }
    });
}

/* TODO: Link para poder ver el tramite guardado */
$(document).on("click", ".btn-inline", function () {
    const ciphertext = $(this).data("ciphertext");
    window.location.replace('editarInscripcionRegistro.php?ID=' + ciphertext + '');
});

$(document).on("click", ".btn-abrir-inscripcion", function () {
    const ciphertext = $(this).data("ciphertext");
    window.location.replace('primerosAuxilios.php?ID=' + ciphertext + '');
});

$(document).on("click", ".btn-ver-observaciones", function () {
    const ciphertext = $(this).data("ciphertext");
    window.location.replace('verObservaciones.php?ID=' + ciphertext + '');

});

function cargarInscripcion(tramite_gestionado_id) {
    /* TODO: Mostramos informacion del documento en inputs */
    $.post("../../controller/certificacion.php?op=mostrar", { tramite_gestionado_id: tramite_gestionado_id }, function (data) {
        try {
            // Parse the JSON response
            var jsArray = JSON.parse(data);
            // Check if the array is not empty
            if (jsArray.length > 0) {
                // Use the keys of the first element to dynamically set values
                var keys = Object.keys(jsArray[0]);

                // Iterate through the array using forEach
                jsArray.forEach(function (element) {
                    // Access each element in the array here
                    keys.forEach(function (key) {
                        // Set the value for the corresponding element ID
                        if (key == "departamento_nacimiento") {
                            cargarDptos(function () {
                                $('#' + key).val(element[key]).trigger('change');
                                cargarCiudades(key);  // Pass the value to cargarCiudades
                            });
                        } else {
                            $('#' + key).val(element[key]);
                        }
                
                        if (key.includes("ciudad")) {
                            console.log("element[" + key + "]: ", element[key]);
                            $('#' + key).val(element[key]).trigger('change');
                            cargarBarrios(element[key]);
                        }
                    });
                });
                $('#nivelContainer input[type=radio]').filter('[value=' + jsArray[0]["nivel"] + ']').prop('checked', true);
            }
        } catch (error) {
            console.error("Error parsing JSON:", error);
        }
    });
}

function enviarSolicitud(estado_tramite) {
    // Se validan que todos los campos tengan algún valor

    // ---------------
    // Se guardan los datos o se editan si fue modificado
    guardarDocsTramites(estado_tramite);


}

/*=============================================
ELIMINAR LA SOLICITUD, DOCUMENTOS Y FORMULARIO
=============================================*/
$(document).on("click", ".btn-delete-row", function () {
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
            $.post("../../controller/tramite.php?op=delete", { ciphertext: ciphertext }, function (e) {

                if (e == "Documento eliminado") {
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
                else {
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

init();

var canvas = document.getElementById('canvas');
var firmaPad = new SignaturePad(canvas);

function limpiarFirma() {
    firmaPad.clear();
}

// Al enviar el formulario, convierte la firma en una imagen base64 y la guarda en un campo oculto
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();
    var firmaInput = document.getElementById('firma');
    firmaInput.value = firmaPad.toDataURL();
    this.submit();
});

$('.verifyButton').click(function () {
    var button = $(this);

    // Add loading icon
    button.html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Verificando...');

    // Simulate verification process (you can replace this with your actual verification logic)
    setTimeout(function () {
        var isVerified = Math.random() < 0.5; // Simulating success or failure

        // Change button text and icon based on verification result
        if (isVerified) {
            button.removeClass('btn-default').addClass('btn-success');
            button.html('<span class="glyphicon glyphicon-ok" style="color:#9bcc86"></span> Verificado');
        } else {
            button.removeClass('btn-default').addClass('btn-danger');
            button.html('<span class="glyphicon glyphicon-remove" style="color:#df7e7e"></span> No encontrado');
        }
    }, 2000); // Simulating a 2-second verification process
});

var nivel = "";
document.addEventListener("DOMContentLoaded", function () {
    var nivelContainer = document.getElementById("nivelContainer");
    nivelContainer.addEventListener("change", function (event) {
        var selectedRadio = event.target;
        nivel = selectedRadio.value;
    });
});