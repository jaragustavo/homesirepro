
<?php
function verificarArchivo($url) {
    $context = stream_context_create(array(
        'http' => array(
            'method'  => 'GET',
            'header'  => "Accept-language: en\r\n",
            'timeout' => 5,
        ),
        'ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ),
    ));

    $headers = @get_headers($url, 1, $context);
    if ($headers === false) {
        return false; // La URL no es accesible
    }
    return strpos($headers[0], '200') !== false; // Verifica si la respuesta es 200 OK
}


?>
