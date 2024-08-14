<?php
// Asegúrate de que el script tenga permisos de escritura en la carpeta de destino

// Obtener la cédula y el archivo subido desde la solicitud
$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : '';
$upload_dir = '/var/www/html/MSPBS_CONTROL_PROFESIONES/sirepro/Apis/';

if (isset($_FILES['file']) && !empty($cedula)) {
    // Crear el directorio si no existe
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Definir la ruta completa del archivo con la cédula como nombre
    $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $file_path = $upload_dir . basename($cedula . '.' . $file_extension);

    // Mover el archivo subido al destino
    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        echo json_encode(array("status" => "ok", "message" => "Imagen guardada correctamente."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error al guardar la imagen."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "No se recibieron datos correctos."));
}
?>
