var tabla;
//Se utiliza para listar los documentos del usuario
var usu_id = $('#user_idx').val();
var idEncrypted = "";
var arrayFiles = []; 

function init() {
    // $("#tramites_form").on("submit",function(e){
    //     guardaryeditar(e);
    // });
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
        var match_code = currentURL.match(/[\?&]code=([^&]*)/);
        // // Check if a match is found
        if (match_code) {
            $('#tramite_code').val(match_code[1]);
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
                $("#pasantia_rural").show();
                $("#residencia_permanente").hide();
                document.getElementById('progress-3').classList.add('active');

            });
            $("#back-2").click( function(){
                $("#pasantia_rural").hide();
                $("#residencia_permanente").show();
                document.getElementById('progress-3').classList.remove('active');

            });
            $("#next-3").click( function(){
                $("#libro_registros").show();
                $("#pasantia_rural").hide();
                document.getElementById('progress-4').classList.add('active');

            });
            $("#back-3").click( function(){
                $("#libro_registros").hide();
                $("#pasantia_rural").show();
                document.getElementById('progress-4').classList.remove('active');

            });
            $("#next-4").click( function(){
                $("#antecedentes_academicos").show();
                $("#libro_registros").hide();
                $("#progress-1").hide();
                $("#progress-5").show();
                document.getElementById('progress-5').classList.add('active');

            });
            $("#back-4").click( function(){
                $("#antecedentes_academicos").hide();
                $("#libro_registros").show();
                $("#progress-5").hide();
                $("#progress-1").show();
                document.getElementById('progress-5').classList.remove('active');

            });
            $("#next-5").click( function(){
                $("#post-grado").show();
                $("#antecedentes_academicos").hide();
                $("#progress-2").hide();
                $("#progress-6").show();
                document.getElementById('progress-6').classList.add('active');

            });
            $("#back-5").click( function(){
                $("#post-grado").hide();
                $("#antecedentes_academicos").show();
                $("#progress-6").hide();
                $("#progress-2").show();
                document.getElementById('progress-6').classList.remove('active');

            });
            
            // manejo del formulario

            /* TODO: Títulos del trámite */
            $.post("../../controller/tramite.php?op=cargarTitulo",{titulo: match_code[1]},function(data){
                $('.tramite_nombre').html(data);
            });
            $.post("../../controller/tramite.php?op=comboEstadoCivil",function(data){
                $('#estado_civil').html(data);
            });
            // Llenar combo países
            $.post("../../controller/tramite.php?op=comboPaises",function(data){
                $('#pais').html(data);
            });
            // LLenar combo departamentos para la residencia permanente
            $.post("../../controller/tramite.php?op=comboDepartamentos",{pais: "Paraguay"},function(data){
                $('#departamento_residencia').html(data);
            });
            // Llenar combo países
            $.post("../../controller/documentoAcademico.php?op=comboInstituciones",function(data){
                $('#institucion_acad').html(data);
                $('#institucion_postgrado').html(data);
            });
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

    /*=============================================
    AGREGAR MULTIMEDIA CON DROPZONE
    =============================================*/

    $(".multimediaFisica").dropzone({
        url: "/",
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg, image/png, application/pdf",
        maxFilesize: 5,
        maxFiles: 1,
        init: function() {
            this.on("addedfile", function(file) {
                console.log(file);
                arrayFiles.push({ id: id, value: file });

                console.log("arrayFiles: "+arrayFiles[0].id+"  "+arrayFiles[0].value);
            })
            this.on("removedfile", function(file) {
                var index = arrayFiles.indexOf(file);
            })

        }

    })
     
});
var id = 0;
function cargarIdDoc(idDiv){
    id = idDiv;
}

function abrirNuevoTramite(){
    // var tramite = $('option:selected', this).attr('url');
    var tramite = $('#tramite_nuevo').val();
    // var codeTramite = 0;
    $.post("../../controller/tramite.php?op=code", {tramiteUrl: tramite},function(data){
        // data = JSON.parse(data);
        codeTramite = data;
        console.log("$$$$$$$$$$$$ "+codeTramite);
        window.location.replace(tramite+'?code='+codeTramite);
    });

    
}

function cargarDptos(){
    var pais=$('#pais').val();
    $.post("../../controller/tramite.php?op=comboDepartamentos",{pais: pais},function(data){
        $('#departamento').html(data);
    });
}

function cargarCiudades(dpto_id){
    var departamento=0;
    if(dpto_id=="departamento"){
        departamento=$('#departamento').val();
    }
    else{
        departamento=$('#departamento_residencia').val();
    }
    $.post("../../controller/tramite.php?op=comboCiudades",{departamento:departamento},function(data){
        if(dpto_id=="departamento"){
            $('#ciudad').html(data);
        }
        else{
            $('#ciudad_residencia').html(data);
        }
        
    });
}

function guardarDocsTramites(){
    for (var i = 0; i < arrayFiles.length; i++) {

        var datosMultimedia = new FormData();
        datosMultimedia.append("id", arrayFiles[i].id);
        datosMultimedia.append("file", arrayFiles[i].value);
        datosMultimedia.append('tramite_code', $('#tramite_code').val());

        $.ajax({
            url: "../../controller/tramite.php?op=insertDocumentos",
            method: "POST",
            data: datosMultimedia,
            cache: false,
            contentType: false,
            processData: false
        });
    }

}

function guardarSolicitud(){

    /* TODO: Array del form Documento Personal */
    var formData = new FormData($("#inscripcion_registro_form")[0]);
    // Add the arrayFiles to formData
    // formData.append('arrayFiles', JSON.stringify(arrayFiles));

    // arrayFiles.forEach((fileObject, index) => {
    // formData.append(`file[${index}][id]`, fileObject.id);
    // formData.append(`file[${index}][name]`, fileObject.value.name);
    // formData.append(`file[${index}][type]`, fileObject.value.type);
    // formData.append(`file[${index}][size]`, fileObject.value.size);
    // formData.append(`file[${index}][tmp_name]`, fileObject.value.tmp_name);
    // });
    formData.append('tramite_code', $('#tramite_code').val());

    /* TODO: validamos si los campos tienen informacion antes de guardar */


        /* TODO: Guardar Documento Personal */
        $('#idEncrypted').val("");
        if($('#idEncrypted').val() == ""){
            $.ajax({
                url: "../../controller/tramite.php?op=insert",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false
                // success: function(data){
                    
                //     if(data= "Documento agregado"){
                //         Swal.fire({
                //             title: "¡Listo!",
                //             text: "Registrado Correctamente",
                //             icon: "success",
                //             showCancelButton: true,
                //             confirmButtonColor: "#3d85c6",
                //             confirmButtonText: "OK"
                //         }).then((result) => {    
                //             if (result.isConfirmed) {    
                //                 window.location.replace('listarTramites.php'); 
                //             }
                //         });
                //     }
                //     else{
                //         Swal.fire({
                //             title: "Error",
                //             text: data,
                //             icon: "error",
                //             showCancelButton: true,
                //             confirmButtonColor: "#3d85c6",
                //             confirmButtonText: "OK"
                //         });
                //     }
                    
                // }
            });
        }
        else{

            $.ajax({
                url: "../../controller/documentoPersonal.php?op=update&img=",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    
                    Swal.fire({
                        title: "¡Listo!",
                        text: "Modificado Correctamente",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3d85c6",
                        confirmButtonText: "OK"
                    }).then((result) => {   
                        if (result.isConfirmed) {    
                            window.location.replace('listarTramites.php'); 
                        }
                    });
                }
            });
        }
        
    // }
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

var arrayFiles = [];



init();