
function init(){
    $("#dato_personal_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

$(document).ready(function() {
    /* TODO: Inicializar SummerNote */
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

    /* TODO: Llenar Combo tipos de Documento */
    $.post("../../controller/tipoDocumento.php?op=combo",function(data, status){
        $('#tipo_documento').html(data);
    });
 

});

function guardaryeditar(e){
    e.preventDefault();
    /* TODO: Array del form ticket */
    var formData = new FormData($("#dato_personal_form")[0]);
    /* TODO: validamos si los campos tienen informacion antes de guardar */
    if ($('#dato_adic').summernote('isEmpty') || $('#documento').val()=='' || $('#tipo_documento').val() == 0){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        // var totalfiles = $('#fileElem').val().length;
        // for (var i = 0; i < totalfiles; i++) {
        //     formData.append("files[]", $('#fileElem')[0].files[i]);
        // }

        /* TODO: Guardar Ticket */
        $.ajax({
            url: "../../controller/datoPersonal.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                console.log(data);
                data = JSON.parse(data);
                console.log(data[0].tick_id);

                

                /* TODO: Limpiar campos */
                $('#documento').val('');
                $('#dato_adic').summernote('reset');
                $('#fecha').val('');
                $('#tipo_documento').val('');
                /* TODO: Alerta de Confirmacion */
                swal("Correcto!", "Registrado Correctamente", "success");
                window.location.replace('/');
            }
        });
    }
}

init();

$(document).on("click", ".btn-delete-row", function() {
    const ciphertext = $(this).data("ciphertext");
    swal({
    title: '¿Desea eliminarlo?',
    text: "No podrás revertir esta acción.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar.'
    },
    function(isConfirm){

    if (isConfirm){
    // if (result.isConfirmed) {
        $.ajax({
            // url: "../../controller/documentoPersonal.php?op=delete",
            // type: "POST",
            // data: formData,
            contentType: false,
            processData: false,
            "ajax": {
                url: '../../controller/documentoPersonal.php?op=delete',
                type: "post",
                dataType: "json",
                data: { ciphertext: ciphertext },
                error: function(e) {
                    console.log(e.responseText);
                }
            },
            success: function(data){
                // console.log(data);
                // data = JSON.parse(data);
                // console.log(data[0].tick_id);
    
                /* TODO: Alerta de Confirmacion */
                swal("Eliminado", "Eliminado correctamente", "success");
                window.location.replace('listarDocsPersonales.php');
            }
        });
    // }

    } else {
        swal("Cancelado", "No se eliminó el documento", "error");
    }
});
      
    
});