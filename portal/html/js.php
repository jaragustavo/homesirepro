<?php
  // Obtener la ruta relativa del directorio actual
$root_path = "/homesirepro/portal/";
$root_path_main = "/homesirepro/";

// Generar el state aleatorio
$state = bin2hex(random_bytes(16)); // Genera un string aleatorio de 16 bytes

// Guardar el estado en la sesión
$_SESSION['oauth2_state'] = $state;


?>


    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!--     
    <script src="<?php //echo $root_path_main ?>assets-main/js/vendor/jquery.js"></script> -->  <!-- Bootstrap JS -->
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/bootstrap.min.js"></script>
    <!-- sal.js -->
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/sal.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/swiper.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/magnify.min.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/jquery-appear.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/odometer.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/backtotop.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/isotop.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/imageloaded.js"></script>

    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/wow.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/waypoint.min.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/easypie.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/text-type.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/jquery-one-page-nav.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/bootstrap-select.min.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/jquery-ui.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/magnify-popup.min.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/paralax-scroll.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/paralax.min.js"></script>
    <script src="<?php echo $root_path_main ?>assets-main/js/vendor/countdown.js"></script>
  
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>



    <!-- Main JS -->
    <script src="<?php echo $root_path_main ?>assets-main/js/main.js"></script>
 

    <script>

       
        const SERVER_URL = 'https://identidad.paraguay.gov.py/login';
        const CLIENT_ID = '36'; // ID de cliente generado por MITIC
        const SCOPE = 'read';
        const RESPONSE_TYPE = 'code';
        const STATE = '<?php if(isset($state)) echo $state; ?>'; // Estado generado en PHP
        // Construir la URL
        const redirectURL = `${SERVER_URL}?clientId=${CLIENT_ID}&scope=${SCOPE}&responseType=${RESPONSE_TYPE}&state=${STATE}`;

        // Asignar la URL generada al atributo href del enlace cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            var elements = document.querySelectorAll('.loginMtic');
            elements.forEach(function(element) {
                element.href = redirectURL;
            });
        });
    </script>
    