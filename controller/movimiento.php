<?php
/* TODO:Cadena de Conexion */
require_once("../config/conexion.php");
/* TODO:Clases Necesarias */
require_once("../models/Movimiento.php");
$movimiento = new Movimiento();

require_once("../models/Usuario.php");
$usuario = new Usuario();

$key = "mi_key_secret";
$cipher = "aes-256-cbc";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

date_default_timezone_set('America/Asuncion');

/*TODO: opciones del controlador Trámites*/
switch ($_GET["op"]) {
    case "asignarmeTramites":
        if (isset($_POST['selectedRows'])) {
            $tramites_autoasignados = $_POST['selectedRows'];

            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $fecha_hora = $fecha . ' ' . $hora;
            $resultado = $movimiento->update_usuario_asignado_tramite($tramites_autoasignados, $fecha_hora, $_SESSION["usuario_id"], $_SESSION["area_id"]);
            echo $resultado;
        }
        break;

    case "enviarObservaciones":
        // Receive data from the AJAX request
        $estadosDocs = json_decode($_POST['estadosDocs'], true);
        $idTramiteGestionado = $_POST['idTramiteGestionado'];
        $idTramiteGestionado = str_replace('%27', '', $idTramiteGestionado);
        $iv_dec = substr(base64_decode($idTramiteGestionado), 0, openssl_cipher_iv_length($cipher));
        $cifradoSinIV = substr(base64_decode($idTramiteGestionado), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        date_default_timezone_set('America/Asuncion');

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $fecha_hora = $fecha . ' ' . $hora;
        $observacion = $_POST['observacion'];
        $resultado = $movimiento->update_estados_documentos($estadosDocs, $decifrado, $observacion, $fecha_hora, $_SESSION["usuario_id"]);
        break;

    case "aprobarSolicitud":
        $estadoDoc = $_POST["estado_doc"];
        $estadoTramite = $_POST["estado_tramite"];
        error_log($_POST["idTramiteGestionado"]);
        $iv_dec = substr(base64_decode($_POST["idTramiteGestionado"]), 0, openssl_cipher_iv_length($cipher));
        $cifradoSinIV = substr(base64_decode($_POST["idTramiteGestionado"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        date_default_timezone_set('America/Asuncion');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $fecha_hora = $fecha . ' ' . $hora;
        $resultado = $movimiento->update_tramite_aprobado($estadoDoc, $estadoTramite, $decifrado, $fecha_hora, $_SESSION["usuario_id"]);
        break;

    case "cargarObs":
        $iv_dec = substr(base64_decode($_POST["tramite_gestionado_id"]), 0, openssl_cipher_iv_length($cipher));
        $cifradoSinIV = substr(base64_decode($_POST["tramite_gestionado_id"]), openssl_cipher_iv_length($cipher));
        $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

        $resultado = $movimiento->get_observacion($decifrado);
        foreach($resultado as $row){
            $observacion = $row["observacion"];
        }
        echo json_encode($observacion);
        break;
}
?>