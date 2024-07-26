document.addEventListener('DOMContentLoaded', () => {
    // Inicializar select2 para #searchEspecialidad
    $('#searchEspecialidad').select2({
        placeholder: 'Selecciona una especialidad'
    });
    // Inicializar select2 para #searchProfesion
    $('#searchProfesion').select2({
        placeholder: 'Selecciona una profesión',
        allowClear: true
    });

    // Configurar eventos para mostrar/ocultar selectores según la selección en #searchCategory
    $('#searchCategory').on('change', function () {
        var value = $(this).val();
        if (value === 'codcateg1') {
            $('#divEspecialidad').show();
            $('#divProfesion').hide();
        } else if (value === 'codprofe') {
            $('#divEspecialidad').hide();
            $('#divProfesion').show();
        } else {
            $('#divEspecialidad').hide();
            $('#divProfesion').hide();
        }
    });

    var url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/categoria.php?token=alguno";

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const select = $('#searchEspecialidad'); // Usamos jQuery para Select2

            if (select) {

                select.empty(); // Vaciar las opciones existentes

                // Añadir una opción vacía para Select2
                select.append(new Option('', '', true, true));

                data.forEach(categoria => {
                    const option = new Option(categoria.nomcateg, categoria.codcateg, false, false);
                    select.append(option).trigger('change');
                });


            } else {
                console.error('Elemento select no encontrado');
            }

        })
        .catch(error => console.error('Error:', error));

    url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/profesion.php?token=alguno";

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const select = $('#searchProfesion'); // Usamos jQuery para Select2

            if (select) {

                select.empty(); // Vaciar las opciones existentes

                // Añadir una opción vacía para Select2
                select.append(new Option('', '', true, true));

                data.forEach(categoria => {
                    const option = new Option(categoria.nomprofe, categoria.codprofe, false, false);
                    select.append(option).trigger('change');
                });


            } else {
                console.error('Elemento select no encontrado');
            }

        })
        .catch(error => console.error('Error:', error));
});

document.getElementById('searchButton').addEventListener('keyup', function (e) {
    if (e.keyCode === 13) {
        // Hide initial elements and show loading message
        document.getElementById('masInformacion').style.display = 'none';
        document.getElementById('ceroRegistros').style.display = 'none';
        document.getElementById('loadingMessage').style.display = 'block';

        // Get the selected category and input value
        var category = document.getElementById("searchCategory").value;
        var searchValue = document.getElementById("searchInput").value;
        var token = "alguno"; // Token value (set dynamically if needed)

        if (category = "codcateg1") {
            searchValue = document.getElementById("searchEspecialidad").value;
        }
        else if(category = "codprofe"){
            searchValue = document.getElementById("searchProfesion").value;
        }

        // Construct the URL
        var url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/profesional.php?item=" + encodeURIComponent(category) + "&valor=" + encodeURIComponent(searchValue) + "&token=" + encodeURIComponent(token);
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                var cantidad_registros = data.length;
                // Clear the existing table data
                var tbody = document.querySelector("#profesionales_data tbody");
                tbody.innerHTML = '';

                // Iterate over the data and create table rows
                data.forEach(item => {
                    var imgURL = 'https://sirepro.mspbs.gov.py/foto/' + item.cedula + '.jpg';

                    checkImage(imgURL, function (exists) {
                        var srcImage = exists ? imgURL : '/homesirepro/assets/images/users/user-dummy-img.jpg';

                        var row = document.createElement('tr');
                        // Create cells for each data field
                        var cellThumbnail = document.createElement('td');
                        cellThumbnail.className = 'pro-thumbnail normal-font';
                        cellThumbnail.innerHTML = '<a href="informacionProfesional.php?cedula=' + item.cedula + '"><div class="thumbnail rbt-avatars size-lg">' +
                            '<img class="square-image" style="border-radius: 100%;" src="' + srcImage + '" alt="Profesional"></div></a>';
                        row.appendChild(cellThumbnail);

                        var cellCedula = document.createElement('td');
                        cellCedula.className = 'normal-font';
                        cellCedula.innerHTML = '<a href="informacionProfesional.php?cedula=' + item.cedula + '">' + item.cedula + '</a>';
                        row.appendChild(cellCedula);

                        var cellNombre = document.createElement('td');
                        cellNombre.className = 'pro-title normal-font';
                        cellNombre.innerHTML = '<a href="informacionProfesional.php?cedula=' + item.cedula + '">' + item.nombres + ' ' + item.apellidos + '</a>';
                        row.appendChild(cellNombre);

                        var cellRegistro = document.createElement('td');
                        cellRegistro.className = 'normal-font';
                        cellRegistro.innerHTML = '<span>' + item.nroregis + '</span>';
                        row.appendChild(cellRegistro);

                        var cellProfesion = document.createElement('td');
                        cellProfesion.className = 'normal-font';
                        cellProfesion.innerHTML = '<span>' + item.nomprofe + '</span>';
                        row.appendChild(cellProfesion);

                        var cellEspecialidad = document.createElement('td');
                        cellEspecialidad.className = 'normal-font';
                        cellEspecialidad.innerHTML = '<span>' + (item.description1 || '-') + '</span>';
                        row.appendChild(cellEspecialidad);

                        // Append the row to the table body
                        tbody.appendChild(row);
                    });
                });

                // Hide the loading message
                document.getElementById('loadingMessage').style.display = 'none';
                if (cantidad_registros > 0) {
                    document.getElementById('masInformacion').style.display = 'block';
                } else {
                    document.getElementById('ceroRegistros').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                // Hide the loading message in case of error
                document.getElementById('loadingMessage').style.display = 'none';
                document.getElementById('ceroRegistros').style.display = 'block';
            });
    }
});

function volverListado() {
    window.location.replace("consultaRegistroProfesional.php");
}

function cargarInformacionProf() {
    document.getElementById('loadingMessage').style.display = 'block';

    var token = "alguno";
    var currentURL = window.location.href;
    var match_code = currentURL.match(/[\?&]cedula=([^&]*)/);
    var cedula = match_code[1];
    var url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/profesional.php?item=cedula&valor=" + cedula + "&token=" + encodeURIComponent(token);
    console.log(url);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log('Fetched data:', data);

            if (data.length === 0) {
                document.getElementById('professionsContainer').innerHTML = "No se encontraron datos.";
                document.getElementById('loadingMessage').style.display = 'none';
                return;
            }

            var userData = data[0];
            document.getElementById('userName').textContent = `${userData.nombres} ${userData.apellidos}`;
            document.getElementById('userCedula').textContent = userData.cedula;
            var imageUrl = 'https://sirepro.mspbs.gov.py/foto/' + userData.cedula + '.jpg';
            checkImage(imageUrl, function (exists) {
                if (exists) {
                    document.getElementById('profesional_img').src = imageUrl;
                }
            });

            var countEspecialidades = 0; // Initialize counter
            var professionCount = data.length;

            var profesionText = professionCount === 1 ? ' Profesión' : ' Profesiones';
            document.getElementById("cantidad_profesiones").innerHTML =
                '<i class="feather-award"></i><span>' + professionCount + profesionText + '</span>';

            var tbody = $('#profesiones_data tbody');
            var container = document.getElementById('professionsContainer');

            data.forEach((item, index) => {
                // Accumulate cantidad_especialidad
                countEspecialidades += item.cantidad_especialidad;

                var row = `<tr data-index="${index}">
                    <td>${item.nroregis}</td>
                    <td>${item.nomprofe}</td>
                    <td>${item.nomuniv}</td>
                    <td>${formatDate(item.fecha_vencimiento)}</td>
                </tr>`;
                tbody.append(row);
            });

            $('#profesiones_data tbody').on('click', 'tr', function () {
                var index = $(this).data('index');
                var selectedItem = data[index];

                var card;
                if (selectedItem.cantidad_especialidad > 0) {
                    card = `<div class="col-lg-12">
                        <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                            <div class="content">
                                <div class="rbt-profile-row row row--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2"><b>Especialidad</b></div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">${selectedItem.description1 || '--'}</div>
                                    </div>
                                </div>
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2"><b>Inscripción</b></div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">${formatDate(selectedItem.fechains)}</div>
                                    </div>
                                </div>
                                <div class="rbt-profile-row row row--15 mt--15">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="rbt-profile-content b2"><b>Fecha de Vencimiento</b></div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="rbt-profile-content b2">${formatDate(selectedItem.fecha_vencimiento)}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                } else {
                    card = `<div class="col-lg-12">
                        <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                            <div class="content">
                                <p>El profesional no registra especialidades relacionadas con la profesión seleccionada.</p>
                            </div>
                        </div>
                    </div>`;
                }
                container.innerHTML = card;
            });

            var especialidadText = countEspecialidades === 1 ? ' Especialidad' : ' Especialidades';
            document.getElementById("cantidad_especialidades").innerHTML =
                '<i class="feather-plus-circle"></i><span>' + countEspecialidades + especialidadText + '</span>';

            document.getElementById('loadingMessage').style.display = 'none';
        })
        .catch(error => console.error('Error fetching data:', error));
}


function formatDate(sentDate) {
    var fecha = new Date(sentDate);
    m = fecha.getMonth() + 1;
    d = fecha.getDate();
    y = fecha.getFullYear();
    fechaFormateada = d + '/' + m + '/' + y;
    return fechaFormateada;
}

function checkImage(url, callback) {
    var img = new Image();
    img.onload = function () { callback(true); };
    img.onerror = function () { callback(false); };
    img.src = url;
}