$(document).ready(function () {
    var especialidadSelect = document.getElementById('searchEspecialidad');
    console.log('especialidadSelect:', especialidadSelect); // Debugging line

    // URL to fetch categories from
    var url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/categoria.php?token=alguno";
    console.log('Fetching URL:', url); // Debugging line

    // Fetch categories data
    fetch(url)
        .then(response => {
            console.log('Fetch response:', response); // Debugging line
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched data:', data); // Debugging line

            // Populate the select element with the categories
            data.forEach(item => {
                var option = document.createElement('option');
                option.value = item.codcateg;
                option.textContent = item.nomcateg;
                console.log('Appending option:', option); // Debugging line

                especialidadSelect.appendChild(option);
            });

            // Show the div containing the select element
            console.log('divEspecialidad is now visible'); // Debugging line
        })
        .catch(error => console.error('Error fetching categories:', error));
});

document.getElementById("searchCategory").addEventListener("change", cambiarCampoFiltrado);

function cambiarCampoFiltrado() {
    var x = document.getElementById("searchCategory");
    if (document.getElementById('searchCategory').value === "especialidad") {
        document.getElementById('divEspecialidad').style.display = 'block';
        document.getElementById('searchButton').style.display = 'none';
    }
    else {
        document.getElementById('divEspecialidad').style.display = 'none';
        document.getElementById('searchButton').style.display = 'block';
    }
}

document.getElementById('searchButton').addEventListener('keyup', function (e) {
    if (e.keyCode === 13) {
        document.getElementById('masInformacion').style.display = 'none';
        document.getElementById('loadingMessage').style.display = 'block';
        // Get the selected category and input value
        var category = document.getElementById("searchCategory").value;
        var searchValue = document.getElementById("searchInput").value;
        // Token value (you can set it dynamically if needed)
        var token = "alguno";

        // Construct the URL
        var url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/profesional.php?item=" + encodeURIComponent(category) + "&valor=" + encodeURIComponent(searchValue) + "&token=" + encodeURIComponent(token);
        console.log(url);

        // Fetch data from the URL
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Clear the existing table data
                var tbody = document.querySelector("#profesionales_data tbody");
                tbody.innerHTML = '';

                // Iterate over the data and create table rows
                data.forEach(item => {
                    var row = document.createElement('tr');

                    // Create cells for each data field
                    var cellThumbnail = document.createElement('td');
                    cellThumbnail.className = 'pro-thumbnail';
                    cellThumbnail.className = 'normal-font';
                    cellThumbnail.innerHTML = '<a href="informacionProfesional.php?cedula='+ item.cedula +'"><img src="/homesirepro/assets/images/users/user-dummy-img.jpg" alt="Profesional"></a>';
                    row.appendChild(cellThumbnail);

                    var cellCedula = document.createElement('td');
                    cellCedula.className = 'normal-font';
                    cellCedula.innerHTML = '<a href="informacionProfesional.php?cedula='+ item.cedula +'">' + item.cedula + '</a>';
                    row.appendChild(cellCedula);

                    var cellNombre = document.createElement('td');
                    cellNombre.className = 'pro-title';
                    cellNombre.className = 'normal-font';
                    cellNombre.innerHTML = '<a href="informacionProfesional.php?cedula='+ item.cedula +'">' + item.nombres + ' ' + item.apellidos + '</a>';
                    row.appendChild(cellNombre);
                    console.log(item.nombres + ' ' + item.apellidos);


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
                // Hide the loading message
                document.getElementById('masInformacion').style.display = 'block';
                document.getElementById('loadingMessage').style.display = 'none';
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                // Hide the loading message in case of error
                document.getElementById('loadingMessage').style.display = 'none';
            });
    }
});

function volverListado(){
    window.location.href = "consultaRegistroProfesional.php";
}