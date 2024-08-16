document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('divmensajes').style.display = 'none';
});

function buscarDatos() {
   // document.getElementById('masInformacion').style.display = 'none';
   document.getElementById('divmensajes').style.display = 'block';
    document.getElementById('ceroRegistros').style.display = 'none';
    document.getElementById('loadingMessage').style.display = 'block';

    let searchValue = document.getElementById("searchInputText").value;
    var token = "alguno";

    var url = "https://homesirepro.mspbs.gov.py/homesirepro/controller/pagoVisacion.php?cedula=" + encodeURIComponent(searchValue) + "&token=" + encodeURIComponent(token);
   
  //  var url = "http://localhost/homesirepro/controller/pagoVisacion.php?cedula=" + encodeURIComponent(searchValue) + "&token=" + encodeURIComponent(token);

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            var cantidad_registros = data.length;
            var tbody = document.querySelector("#pagoVisacion_data tbody");

            if (!tbody) {
                console.error("No se pudo encontrar el elemento tbody.");
                return;
            }

            tbody.innerHTML = '';
            console.log( data);
            data.forEach(item => {

                var tr = document.createElement('tr');

                var tdAcciones = document.createElement('td');
                tdAcciones.className = 'pro-price';
                // No es necesario aplicar ancho fijo aquí
                var linkOjo = document.createElement('a');
                linkOjo.href = `https://sirepro.mspbs.gov.py/tramites/verif_nro.php`; // Reemplaza con la URL deseada
                linkOjo.target = '_blank'; // Abre en una nueva pestaña

                var iconOjo = document.createElement('i');
                iconOjo.className = 'fas fa-eye fa-1x'; // Ícono de ojo de Font Awesome
                iconOjo.style.padding = '25px 0px 25px 35px';
                iconOjo.style.color = "#2F57EF"; // Color del ícono

                linkOjo.appendChild(iconOjo);
                tdAcciones.appendChild(linkOjo);

                tr.appendChild(tdAcciones);

                var tdNroBoleta = document.createElement('td');
                tdNroBoleta.className = 'pro-title';
                tdNroBoleta.textContent = item.tid || 'No disponible';
                tr.appendChild(tdNroBoleta);

                var tdFecha = document.createElement('td');
                tdFecha.className = 'pro-title';
                tdFecha.textContent = formatDate(item.trn_dat) || 'No disponible';
                tr.appendChild(tdFecha);

                var tdHora = document.createElement('td');
                tdHora.className = 'pro-title';
                tdHora.textContent = formatTime(item.trn_hou) || 'No disponible';
                tr.appendChild(tdHora);
               
                // var tdProfesional = document.createElement('td');
                // tdProfesional.className = 'pro-title';
               
                // tdProfesional.textContent =   item.nombreprofesional; // item.estado  == '2' ?  item.nombreprofesional : item.des_estado;
                // tr.appendChild(tdProfesional);

                var tdEstado = document.createElement('td');
                tdEstado.className = 'pro-title';
                tdEstado.textContent =  item.des_estado;
                tr.appendChild(tdEstado);
           
                tbody.appendChild(tr);
           

            });

            document.getElementById('loadingMessage').style.display = 'none';
            if (cantidad_registros > 0) {
                document.getElementById('divmensajes').style.display = 'none';
            } else {
                document.getElementById('ceroRegistros').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('loadingMessage').style.display = 'none';
            document.getElementById('ceroRegistros').style.display = 'block';
        });
}

function volverListado() {
    window.location.replace("consultaRegistroProfesional.php");
}

function formatDate(dateString) {
    var date = new Date(dateString);
    var day = String(date.getDate()).padStart(2, '0');
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

function formatTime(timeString) {
    if (!timeString) return 'No disponible';
    var parts = timeString.split(':');
    if (parts.length >= 2) {
        return parts[0] + ':' + parts[1]; // Retorna hh:mm
    }
    return timeString; // Retorna el valor original si no se puede formatear
}
