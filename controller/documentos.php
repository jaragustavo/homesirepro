<?php

require_once '../config/conexion.php'; 
require_once '../models/Documentos.php'; 

class ControladorDocumentos
{
    public function obtenerDocumentos() {
        if (isset($_POST['cedula']) && isset($_POST['tipoinsc']) && isset($_POST['formainsc'])) {
           
            $cedula = $_POST['cedula'];
            $tipoinsc = $_POST['tipoinsc'];
            $formainsc = $_POST['formainsc'];
            $tipoprof = $_POST['tipoprof'];
      
            $documentos = new Documentos();
            $resultado = $documentos->obtenerDocumentos($cedula, $tipoinsc, $formainsc, $tipoprof);

            // Verificar si el resultado es un array o un objeto antes de codificar en JSON
            if (is_array($resultado) || is_object($resultado)) {
                // Codificar en JSON y devolver la respuesta
                echo json_encode($resultado);
            } else {
                // Manejar casos en los que el resultado no es un array u objeto válido
                echo json_encode(['error' => 'Datos no válidos']);
            }
        } else {
            // Manejar el caso en que los parámetros no están establecidos
            echo json_encode(['error' => 'Parámetros incompletos']);
        }
    }
}
$controladorDocumentos = new ControladorDocumentos();

if (isset($_GET['op']) && $_GET['op'] === 'obtenerDocumentos') {

 
  

    $controladorDocumentos->obtenerDocumentos();
    
}
?>
