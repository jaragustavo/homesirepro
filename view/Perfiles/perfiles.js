function init() {
    // $.post("../../controller/usuario.php?op=cantidadesTramites", function(data) {
    //     data = JSON.parse(data);
    //     $('#lbltramitesrealizados').html(data.lbltramitesrealizados);
    // });

    // $.post("../../controller/usuario.php?op=cantidadesReposos", function(data) {
    //     data = JSON.parse(data);
    //     $('#lblreposos').html(data.lblreposos);
    // });

    // $.post("../../controller/usuario.php?op=comboEstablecimientosSalud", function(data) {
    //     $('#lugares_trabajo').html(data);
    // });

    // $.post("../../controller/usuario.php?op=comboProfesiones", function(data) {
    //     $('#profesion').html(data);
    // });

    // actualizar_img();

}
$(document).ready(function() {

    // Inicializar Select2 para los selects de departamentos y ciudades
    // $('#departamento_id').select2();
    // $('#ciudad_id').select2();
    cargarDatosPersonales();
    // Cargar departamentos al cargar la página
   // cargarDepartamentos();

    // Función para cargar departamentos desde el archivo JSON
    // function cargarDepartamentos() {
    //     $.getJSON('../../json/departamentos.json', function(data) {
    //         // Guardar los datos de departamentos globalmente para su uso posterior
    //         departamentosData = data;

    //         // Obtener el select de departamentos
    //         var departamentoSelect = $('#departamento_id');
    //         departamentoSelect.empty(); // Limpiar opciones actuales

    //         // Agregar opción por defecto
    //         departamentoSelect.append(new Option('Seleccione Departamento', ''));

    //         // Iterar sobre los datos y agregar opciones al select
    //         data.forEach(function(departamento) {
    //             departamentoSelect.append(new Option(departamento.departamento_nombre, parseInt(departamento.departamento_id)));
    //         });

    //         // Llamar a cargarDatosPersonales después de cargar los departamentos
    //         cargarDatosPersonales();
    //     });
    //     actualizar_img();
    // }

    function cargarDatosPersonales() {
        $.post("../../controller/usuario.php?op=mostrarDatosPersonales", function(response) {
            
            console.log("Respuesta del servidor:", response); // Verificar la respuesta
    
            try {
                var datos = JSON.parse(response);
                
                // Verificar si la respuesta contiene un error
                if (datos.error) {
                    console.error("Error: " + datos.error);
                    alert("No se encontraron datos personales.");
                    return;
                }
    
                // Cargar los valores en los campos del formulario
                $('#nombre').val(datos.nombres);
                $('#apellido').val(datos.apellidos);
                $('#documento_identidad').val(datos.cedula);
                $('#fecha_nacimiento').val(datos.fechanac);
                $('#sexo').val(datos.sexo);
                $('#coddist').val(datos.coddist);
                $('#nomdist').val(datos.nomdist);
                $('#codreg').val(datos.codreg);
                $('#coddpto').val(datos.coddpto);
                $('#nomdpto').val(datos.nomdpto);
                $('#codnac').val(datos.codnac);
                $('#codnacs').val(datos.codnacs);
    
                // Si tienes otros campos que necesitan ser cargados, agrégalos aquí.
    
                // Establecer el departamento seleccionado y cargar ciudades
                // var departamento_id = datos.coddpto;
                // $('#departamento_id').val(departamento_id).trigger('change');
        
                // // Cargar ciudades basadas en el departamento seleccionado
                // cargarCiudades(departamento_id, datos.coddist);
    
            } catch (e) {
                console.error("Error al parsear JSON: ", e);
                alert("Error al cargar los datos personales.");
            }
        });
    }
    

    // Función para cargar ciudades basado en el departamento seleccionado
    function cargarCiudades(departamento_id, ciudad_id) {

        var ciudadSelect = $('#ciudad_id');
        ciudadSelect.empty(); // Limpiar opciones actuales
        ciudadSelect.append(new Option('Seleccione Ciudad', ''));

        // Encontrar el departamento seleccionado en los datos de departamentos
        var selectedDepartamento = departamentosData.find(d => parseInt(d.departamento_id) == parseInt(departamento_id));

        if (selectedDepartamento) {
            // Iterar sobre las ciudades del departamento seleccionado y agregarlas al select
            selectedDepartamento.ciudades.forEach(function(ciudad) {
                ciudadSelect.append(new Option(ciudad.ciudad_nombre, parseInt(ciudad.ciudad_id)));
            });

            // Establecer la ciudad seleccionada, si existe
            if (ciudad_id) {

                ciudad_id = parseInt(ciudad_id); // Convertir a entero

                $('#ciudad_id').val(ciudad_id).trigger('change.select2');
            }
        }
      
    }

   
 
});
// Función para guardar datos personales
function guardarDatosPersonales() {
    // Validar el formulario antes de enviarlo
    if (!validateForm("datos_personales_form")) {
        return;
    }

    var formData = new FormData($("#datos_personales_form")[0]);

    // Realizar la petición AJAX para guardar los datos
    $.ajax({
        url: "../../controller/usuario.php?op=updateDatosPersonales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data == "ok") {
                Swal.fire({
                    title: "¡Listo!",
                    text: "Datos guardados correctamente",
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#3d85c6",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al guardar los datos",
                    icon: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#3d85c6",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// Función para validar el formulario antes de enviar
function validateForm(formulario) {
    var form = document.getElementById(formulario);
    var elements = form.elements;
    var isEmpty = false;

    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];

        // Check if element is input or select
        if (element.tagName === "INPUT" || element.tagName === "SELECT") {
            // Check if element is required and is empty
            if (!element.value.trim()) {
                isEmpty = true;
                break;
            }
        }
    }

    if (isEmpty) {
        Swal.fire({
            title: "Error",
            text: "Todos los campos son requeridos",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#3d85c6",
            confirmButtonText: "OK"
        });
    }

    return !isEmpty;
}

// Asignar el evento de click al botón de guardar datos personales
$('#guardar_datos_personales_btn').click(function() {
    guardarDatosPersonales();
});

function guardarFoto() {

    var formData = new FormData();
    var fileInput = document.getElementById('foto_perfil');
    var file = fileInput.files[0];

    formData.append('file', file);

    $.ajax({
        url: '../../controller/usuario.php?op=guardarFotoPerfil',
        type: 'POST',
        data: formData,
        processData: false, // Importante
        contentType: false, // Importante
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === "ok") {
                // Swal.fire({
                //     // title: "Éxito",
                //     // text: "La foto de perfil fue actualizada.",
                //     // icon: "success",
                //     // showCancelButton: true,
                //     // confirmButtonColor: "#3d85c6",
                //     // confirmButtonText: "OK"
                // });

                // Actualizar la imagen de perfil con la nueva foto
                var foto_perfil = document.querySelector('.avatar-preview-128 img');
                foto_perfil.src = data.new_image_path;
            } else {
                Swal.fire({
                    title: "Error",
                    text: data.message,
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3d85c6",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error al subir el archivo.",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#3d85c6",
                confirmButtonText: "OK"
            });
        }
    });
}

function guardarFotoCi() {

    var formData = new FormData();
    var fileInput = document.getElementById('imagen');
    var file = fileInput.files[0];
    formData.append('file', file);

    $.ajax({
        url: '../../controller/usuario.php?op=guardarFotoCi',
        type: 'POST',
        data: formData,
        processData: false, // Importante
        contentType: false, // Importante
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === "ok") {

                // Actualizar la imagen de perfil con la nueva foto

                var rutaImagen = data.new_image_path;

                var contenedor = $("#contenedor-preview");

                if (file.type != "application/pdf") {
                    contenedor.html('<a id="imagen-enlace" href="' + rutaImagen + '" target="_blank"><img id="imagenmuestra" name="imagenmuestra" class="previsualizar" title="Imagen de la cedula" src="' + rutaImagen + '" alt="Imagen Registro Profesional."></a>');
                } else {
                    contenedor.html('<a id="pdf-enlace" href="' + rutaImagen + '" target="_blank"><iframe id="pdfmuestra" name="pdfmuestra" class="previsualizar" src="' + rutaImagen + '" style="display: block;" width="100%" height="300px"></iframe></a>');
                }

            } else {
                Swal.fire({
                    title: "Error",
                    text: data.message,
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3d85c6",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error al subir el archivo.",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#3d85c6",
                confirmButtonText: "OK"
            });
        }
    });
}


function actualizar_img() {
    $(".nuevaImagen").change(function() {
        var imagen = this.files[0];

        if (imagen.type != "image/jpeg" && imagen.type != "image/png" && imagen.type != "application/pdf") {
            $(".nuevaImagen").val("");
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡El archivo debe estar en formato PDF, JPG o PNG!",
                confirmButtonText: "¡Cerrar!"
            });
        } else if (imagen.size > 8000000) {
            $(".nuevaImagen").val("");
            Swal.fire({
                title: "Error al subir la imagen",
                text: "¡El archivo no debe pesar más de 8MB!",
                confirmButtonText: "¡Cerrar!"
            });
        } else {
            var datosImagen = new FileReader();
            datosImagen.readAsDataURL(imagen);

            datosImagen.onload = function(event) {

                var rutaImagen = event.target.result;

                var contenedor = $("#contenedor-preview");

                if (imagen.type != "application/pdf") {
                    contenedor.html('<a id="imagen-enlace" href="' + rutaImagen + '" target="_blank"><img id="imagenmuestra" name="imagenmuestra" class="previsualizar" title="Imagen de la cedula" src="' + rutaImagen + '" alt="Imagen Registro Profesional."></a>');
                } else {
                    contenedor.html('<a id="pdf-enlace" href="' + rutaImagen + '" target="_blank"><iframe id="pdfmuestra" name="pdfmuestra" class="previsualizar" src="' + rutaImagen + '" style="display: block;" width="100%" height="300px"></iframe></a>');
                }

            };

        }
    });
}

// Asegúrate de que la función está lista cuando la página se carga
$(document).ready(function() {
   // actualizar_img();
});