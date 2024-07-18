function init() {

    actualizar_img();
}
idEncrypted = 0;

$(document).ready(function () {
    
    // manejo del formulario
    $("#next-1").click( function(){
        $("#parte_2").show();
        $("#parte_1").hide();
        document.getElementById('progress-2').classList.add('active');
    });
    $("#back-1").click( function(){
        $("#parte_2").hide();
        $("#parte_1").show();
        document.getElementById('progress-2').classList.remove('active');

    });
    $("#next-2").click( function(){
        $("#parte_3").show();
        $("#parte_2").hide();
        document.getElementById('progress-3').classList.add('active');

    });
    $("#back-2").click( function(){
        $("#parte_3").hide();
        $("#parte_2").show();
        document.getElementById('progress-3').classList.remove('active');

    });
    $("#next-3").click( function(){
        $("#parte_4").show();
        $("#parte_3").hide();
        document.getElementById('progress-4').classList.add('active');

    });
    $("#back-3").click( function(){
        $("#parte_4").hide();
        $("#parte_3").show();
        document.getElementById('progress-4').classList.remove('active');

    });
    $("#next-4").click( function(){
        $("#parte_5").show();
        $("#parte_4").hide();
        $("#progress-1").hide();
        $("#progress-5").show();
        document.getElementById('progress-5').classList.add('active');

    });
    $("#back-4").click( function(){
        $("#parte_5").hide();
        $("#parte_4").show();
        $("#progress-5").hide();
        $("#progress-1").show();
        document.getElementById('progress-5').classList.remove('active');

    });
    $("#next-5").click( function(){
        $("#parte_6").show();
        $("#parte_5").hide();
        $("#progress-2").hide();
        $("#progress-6").show();
        document.getElementById('progress-6').classList.add('active');

    });
    $("#back-5").click( function(){
        $("#parte_6").hide();
        $("#parte_5").show();
        $("#progress-6").hide();
        $("#progress-2").show();
        document.getElementById('progress-6').classList.remove('active');

    });
    $("#next-6").click( function(){
        $("#parte_7").show();
        $("#parte_6").hide();
        $("#progress-3").hide();
        $("#progress-7").show();
        document.getElementById('progress-7').classList.add('active');

    });
    $("#back-6").click( function(){
        $("#parte_7").hide();
        $("#parte_6").show();
        $("#progress-7").hide();
        $("#progress-3").show();
        document.getElementById('progress-7').classList.remove('active');
    
    });
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
    else {

    }
});

// Función para que el usuario se asigne trámites en la bandeja del área en la que se encuentra
function asignarmeTramites() {
    // Get all selected checkboxes
    var selectedRows = $(".tramite_area_checkbox:checked").map(function () {
        return this.id;
    }).get();
    $.post("../../controller/movimiento.php?op=asignarmeTramites", { selectedRows: selectedRows }, function (data) {
        if (data == "ok") {
            document.location.reload(true);
        }
        else {
            alert(data);
        }

    });
}

// Abrir el trámite para su verificación
$(document).on("click", ".btn-open-solicitud", function () {
    const ciphertext = $(this).data("ciphertext");
    window.location.replace('revisarTramiteSolicitado.php?ID=' + ciphertext + '');
});

function cargarTramite(tramite_gestionado_id) {

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
    $.post("../../controller/movimiento.php?op=cargarObs", { tramite_gestionado_id: tramite_gestionado_id }, function(data) {
        data = JSON.parse(data);
        $('#observacion').summernote('code', data);
    });
}

function enviarObservaciones() {

    var formData = new FormData();

    // Loop through all selects with the class 'estado_documento'
    var estadosDocs = {};
    document.querySelectorAll('.estado_documento').forEach(function (select) {
        var selectId = select.id;
        var selectValue = select.value;
        estadosDocs[selectId] = selectValue;
    });

    formData.append('estadosDocs', JSON.stringify(estadosDocs));
    formData.append('observacion', $("#observacion").val());
    formData.append('idTramiteGestionado', idEncrypted);

    $.ajax({
        type: "POST",
        url: "../../controller/movimiento.php?op=enviarObservaciones",
        data: formData,
        processData: false,  // Important: prevent jQuery from transforming the data
        contentType: false,  // Important: let the server handle the content type
        success: function (data) {
          
        if(data= "ok"){
            Swal.fire({
                title: "¡Listo!",
                text: "Registrado Correctamente",
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3d85c6",
                confirmButtonText: "OK"
            }).then((result) => {    
                if (result.isConfirmed) {    
                    window.location.replace('listarSolicitudes.php'); 
                }
            });
        }
        else{
            Swal.fire({
                title: "Error",
                text: data,
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#3d85c6",
                confirmButtonText: "OK"
            });
        }
            
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

}

function aprobarSolicitud(estado_tramite, estado_doc){
    var formData = new FormData();
    formData.append('observacion', $("#observacion").val());
    formData.append('idTramiteGestionado', idEncrypted);
    formData.append('estado_tramite', estado_tramite);
    formData.append('estado_doc', estado_doc);

    $.ajax({
        type: "POST",
        url: "../../controller/movimiento.php?op=aprobarSolicitud",
        data: formData,
        processData: false,  // Important: prevent jQuery from transforming the data
        contentType: false,  // Important: let the server handle the content type
        success: function (data) {
          
        if(data= "ok"){
            Swal.fire({
                title: "¡Listo!",
                text: "Registrado Correctamente",
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3d85c6",
                confirmButtonText: "OK"
            }).then((result) => {    
                if (result.isConfirmed) {    
                    window.location.replace('listarSolicitudes.php'); 
                }
            });
        }
        else{
            Swal.fire({
                title: "Error",
                text: data,
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#3d85c6",
                confirmButtonText: "OK"
            });
        }
            
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

}
