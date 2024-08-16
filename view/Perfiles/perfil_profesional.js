let cedula;
let tipoprof;
let tipoinsc;
let formainsc;
let dia;
let mes;
let anio;
let rorden;

$(document).ready(function() {
    $.get("../../controller/get_cedula_session.php", function(sessionData) {
        // Obtener la cédula de la sesión
        cedula = sessionData.cedula;

        cargarDatosProfesionales(function() {
            // Verificar los valores antes de llamar a cargarDocumentos
            console.log("Valores antes de cargarDocumentos:", { tipoprof, tipoinsc, formainsc, cedula });

            cargarLugarTrabajo();
            cargarDocumentos();
            cargarPostGrado();
        });
    });
});

function cargarDatosProfesionales(callback) {
    var item = 'cedula';
    $.ajax({
        url: '../../controller/profesional.php',
        method: 'POST',
        data: {
            item: item,
            valor: cedula,
            token: 'alguno'
        },
        success: function(response) {
            if (Array.isArray(response) && response.length > 0) {
                const profesional = response[0];
                $('#nro_registro').val(profesional.nroregis);
                $('#profesion').val(profesional.nomprofe);
                $('#universidad').val(profesional.nomuniv_concat);



                document.getElementById('nro_registro').textContent = profesional.nroregis;

                rorden = profesional.norden;
                tipoprof = profesional.tipoprof;
                tipoinsc = profesional.tipoinsc;
                formainsc = profesional.formainsc;

                // Ejecutar el callback si está definido
                if (callback && typeof callback === 'function') {
                    console.log("Ejecutando callback");
                    callback();
                }
            } else {
                console.error("No se encontraron datos");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.status, error);
        }
    });
}

function cargarDocumentos() {
    // Envío de datos mediante POST
    $.post("../../controller/documentos.php?op=obtenerDocumentos", {
        cedula: cedula,
        tipoinsc: tipoinsc,
        formainsc: formainsc,
        tipoprof: tipoprof

    }, function(data) {
        try {
            // Convertir la respuesta a JSON
            let documentos = typeof data === "string" ? JSON.parse(data) : data;

            // Limpiar el contenedor antes de cargar los nuevos datos
            $('#documentos-container').empty();

            // Comprobar si el array de documentos está vacío
            if (documentos.length === 0) {
                // Mostrar mensaje si no hay documentos
                $('#documentos-container').append('<p>No hay documentos registrados.</p>');
                return;
            }

            // Crear el encabezado de la tabla
            let tableHtml = `
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ver</th>
                                <th>Documento Exigidos</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

            documentos.forEach(function(documento) {
                let documentoUrl = null;
                let iconHtml = '';

                if (documento.norden) {

                    let [year, month, day] = documento.fechasol.split('-');
                    mes = month.padStart(2, '0');
                    dia = day.padStart(2, '0');
                    anio = year;

                    // Construir URL del documento si norden tiene un valor
                    documentoUrl = `https://sirepro.mspbs.gov.py/documentos/${cedula}_${dia}${mes}${anio}_${rorden}_${documento.norden}.pdf`;
                    iconHtml = `<a href="${documentoUrl}" target="_blank" title="Ver Documento">
                                    <img src="../../public/img/pdf.bmp" alt="Ver Documento" style="width: 20px; height: 20px;"/> <!-- ícono de archivo PDF -->
                                </a>`;
                } else {
                    iconHtml = `
                        <i class="glyphicon glyphicon-paperclip" style="color:#5bc0de;" title="Documento no disponible"></i>  `;
                }

                tableHtml += `
                        <tr>
                            <td>${iconHtml}</td>
                            <td>${documento.nomtdoc}</td>
                        </tr>
                    `;
            });

            // Cerrar la tabla
            tableHtml += `
                        </tbody>
                    </table>
                `;

            // Añadir la tabla al contenedor
            $('#documentos-container').append(tableHtml);
        } catch (e) {
            // Manejar errores en la conversión de datos a JSON
            console.error("Error al procesar la respuesta del servidor:", e);
            $('#documentos-container').append('<p>Error al cargar los documentos. Inténtalo de nuevo más tarde.</p>');
        }
    }).fail(function(xhr, status, error) {
        // Manejar errores en la solicitud
        console.error("Error al obtener datos del lugar de trabajo:", error);
        $('#documentos-container').append('<p>Error al cargar los documentos. Inténtalo de nuevo más tarde.</p>');
    });
}


// Función para cargar lugar de trabajo
function cargarLugarTrabajo() {

    // Envío la cédula al controlador mediante POST
    $.post("../../controller/lugarTrabajo.php?op=obtenerLugarTrabajo", {
        cedula: cedula
    }, function(data) {
        // Convertir la respuesta a JSON si no está ya en formato JSON
        var trabajos = typeof data === "string" ? JSON.parse(data) : data;

        // Limpiar el contenedor antes de cargar los nuevos datos
        $('#trabajo-container').empty();

        // Comprobar si el array de trabajos está vacío
        if (trabajos.length === 0) {
            // Mostrar mensaje si no hay trabajos
<<<<<<< HEAD
            $('#trabajo-container').append('<p>No tiene dados laborales registrado.</p>');
=======
            $('#trabajo-container').append('<p>No hay lugar de trabajo registrado.</p>');
>>>>>>> 987cb6c326ad03bec247a7803027d5f05c74ba7f
            return;
        }

        // Iterar sobre cada trabajo y añadirlo al contenedor
        trabajos.forEach(function(trabajo) {
            var trabajoHtml = `
                    <div class="row trabajo-row col-12">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lugar_trabajo">Lugar Trabajo</label>
                                <input type="text" class="form-control" name="lugar_trabajo[]" placeholder="Descripción Lugar Trabajo" value="${trabajo.lugartra}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" name="telefono[]" placeholder="Teléfono" value="${trabajo.telef}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" name="direccion[]" placeholder="Dirección" value="${trabajo.dccion}">
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="direccion">Email</label>
                                <input type="text" class="form-control" name="direccion[]" placeholder="Dirección" value="${trabajo.email}">
                            </div>
                        </div>
                       
                    </div>
                `;

            // Añadir el trabajo al contenedor
            $('#trabajo-container').append(trabajoHtml);
        });
    }).fail(function(xhr, status, error) {
        // Manejar errores en la solicitud
        console.error("Error al obtener datos del lugar de trabajo:", error);
    });

}


// Función para cargar Post Grados
function cargarPostGrado() {
    // Envío la cédula al controlador mediante POST
    $.post("../../controller/especialidad.php?op=obtenerEspecialidad", {
        cedula: cedula
    }, function(data) {
        // Convertir la respuesta a JSON si no está ya en formato JSON
        var especialidades = typeof data === "string" ? JSON.parse(data) : data;

        // Limpiar el contenedor antes de cargar los nuevos datos
        $('#especialidad-container').empty();

        // Comprobar si el array de especialidades está vacío
        if (especialidades.length === 0) {
            // Mostrar mensaje si no hay especialidades
            $('#especialidad-container').append('<p>No tiene especialidad registrada.</p>');
            return;
        }

        // Crear la tabla
        var tableHtml = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Especialidad</th>
                    </tr>
                </thead>
                <tbody>
        `;

        // Iterar sobre cada especialidad y añadirla a la tabla
        especialidades.forEach(function(especialidad) {
            tableHtml += `
                <tr>
                    <td>${especialidad.nomespe}</td>
                </tr>
            `;
        });

        // Cerrar la tabla
        tableHtml += `
                </tbody>
            </table>
        `;

        // Añadir la tabla al contenedor
        $('#especialidad-container').append(tableHtml);
    }).fail(function(xhr, status, error) {
        // Manejar errores en la solicitud
        console.error("Error al obtener datos del lugar de Especialidad:", error);
    });
}


function guardarDatosProfesionales() {
    // Validar el formulario antes de enviarlo
    if (!validateForm("datos_profesionales_form")) {
        return;
    }

    // Obtener los datos de especialidad, año de egreso y lugar de egreso
    var anioEgreso = $('#anio_egreso').val();
    var lugarEgreso = $('#lugar_egreso').val();

    // Crear un objeto con los datos profesionales
    var datosProfesionales = {
        anio_egreso: anioEgreso,
        lugar_egreso: lugarEgreso,
        lugares_trabajo: [],
        estudios: []
    };

    // Recorrer cada fila de trabajo para obtener lugar de trabajo
    $('.trabajo-row').each(function() {
        var lugarTrabajo = $(this).find('select[name="lugar_trabajo[]"]').val();
        var tipoContrato = $(this).find('select[name="tipo_contrato[]"]').val();
        var vinculo = $(this).find('select[name="vinculo[]"]').val();

        // Agregar cada lugar de trabajo al arreglo dentro de datosProfesionales
        datosProfesionales.lugares_trabajo.push({
            lugar_trabajo: lugarTrabajo,
            tipo_contrato: tipoContrato,
            vinculo: vinculo
        });
    });

    // Recorrer cada fila de estudio para obtener los datos
    $('.estudio-row').each(function() {
        var titulo = $(this).find('select[name="titulo[]"]').val();
        var titulo_descripcion = $(this).find('input[name="titulo_descripcion[]"]').val();

        // Agregar cada estudio al arreglo dentro de datosProfesionales
        datosProfesionales.estudios.push({
            titulo: titulo,
            titulo_descripcion: titulo_descripcion
        });
    });

    // Convertir el objeto a JSON
    var jsonDatosProfesionales = JSON.stringify(datosProfesionales);

    // Crear un objeto FormData para enviar al servidor
    var formData = new FormData($("#datos_profesionales_form")[0]);
    formData.append('jsonDatosProfesionales', jsonDatosProfesionales);

    // Realizar la petición AJAX para guardar los datos
    $.ajax({
        url: "../../controller/usuario.php?op=updateDatosProfesionales",
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

function validateForm(formulario) {


    var form = document.getElementById(formulario);
    var elements = form.elements;
    var isEmpty = false;



    for (var i = 0; i < elements.length; i++) {

        var element = elements[i];

        // Excluir los campos imagen e imagenactual del proceso de validación
        if (element.id === 'imagen' || element.id === 'imagenactual') {
            continue; // Saltar estos campos
        }

        // Excluir los campos con nombres de array del proceso de validación
        if (element.name && element.name.endsWith('[]')) {
            continue; // Saltar estos campos
        }

        // Check if element is input or select
        if (element.tagName === "INPUT" || element.tagName === "SELECT") {


            console.log("Elemento:", element.name, "Valor:", element.value.trim());
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