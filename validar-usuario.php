<?php

require_once("config/conexion.php");
       
require_once("models/UsuarioMtic.php");

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

// Verificar que se reciba el código de autorización
if (isset($_GET['code']) && isset($_GET['state'])) {

    // Obtener el estado almacenado en la sesión
    $session_state = $_SESSION['oauth2_state'];

    // Verificar que el estado recibido coincida con el estado almacenado
    if ($_GET['state'] !== $session_state) {

        die('El estado recibido no coincide con el estado almacenado. Posible ataque CSRF.');

    }

    // Configuración de la solicitud
    $base_url = 'https://devidentidad.mitic.gov.py/rest/authentication';
    $client_id = '1077'; // ID de cliente
    $client_secret = 'dd123030-cd5a-4e3c-a4b3-0ee553747784'; // Reemplaza con tu client secret
    $grant_type = 'authorization_code';
    $code = $_GET['code']; // Obtener el código de autorización de la URL

    // Crear la URL con los parámetros
    $url = sprintf(
        '%s?client_id=%s&client_secret=%s&grant_type=%s&code=%s',
        $base_url,
        urlencode($client_id),
        urlencode($client_secret),
        urlencode($grant_type),
        urlencode($code)
    );

    // Inicializar cURL
    $ch = curl_init($url);

    // Configurar opciones para la solicitud POST
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devolver respuesta en lugar de imprimir en pantalla
    curl_setopt($ch, CURLOPT_POST, true); // Método POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, ''); // Sin datos en el cuerpo del POST

    // Configurar encabezados HTTP
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Encabezado Content-Type
        'Accept: application/json' // Encabezado Accept para recibir respuesta JSON
    ]);

    // Configurar para depuración
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);

    // Ejecutar la solicitud POST
    $response = curl_exec($ch); // Ejecutar la solicitud y obtener la respuesta
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtener el código de estado HTTP

    // Obtener información detallada de cURL para depuración
    // rewind($verbose);
    // $verbose_log = stream_get_contents($verbose);
    // error_log('cURL verbose info: ' . $verbose_log);

    // Manejar errores de cURL
    if ($response === false) {
        $curl_error = curl_error($ch); // Obtener errores de cURL
        error_log('Error al realizar la solicitud: ' . $curl_error);
        fclose($verbose);
        curl_close($ch); // Cerrar la conexión cURL
        die('Error al realizar la solicitud. Consulta los logs para más detalles.');
    }

    curl_close($ch); // Cerrar la conexión cURL


    // Verificar el estado de la respuesta HTTP
    if ($http_status !== 200) {
        error_log("Error HTTP recibido: $http_status");
        die("Error HTTP recibido: $http_status");
    }

    // Asumir que la respuesta es el token JWT directamente
    $token = $response;

    // Aquí decodificamos el token JWT para obtener los valores
    $decoded_token = decode_jwt($token);
   
 // Verificar si se decodificó correctamente
    if ($decoded_token !== null) {

        $json_usuario = json_encode(['datos' => $decoded_token]);
        $usuario = new UsuarioMtic();
        $usuario->login_mtic($json_usuario);

        // Eliminar la sesión después de procesar los datos
        // session_unset(); // Limpiar todas las variables de sesión
        // session_destroy(); // Destruir la sesión

    } else {
        error_log('Error al decodificar el token JWT.');
        die('Error al decodificar el token JWT.');
    }

} else {
    // Manejar el caso donde no se recibe el código de autorización
    error_log('Código de autorización no recibido.');
    die('Código de autorización no recibido.');
}

/**
 * Función para decodificar un token JWT sin validar la firma.
 *
 * @param string $jwt El token JWT a decodificar.
 * @return array Los datos decodificados del token.
 */
function decode_jwt($jwt) {
    list($header, $payload, $signature) = explode('.', $jwt);

    // Decodificar base64url
    $decoded_payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload));
    // Convertir el payload decodificado a objeto stdClass
    return json_decode($decoded_payload);
}
?>
