<?php

require_once '../config/conexion.php'; 
require_once '../models/Distrito.php'; 

class ControladorDistrito
{
  
    public function obtenerDistrito()
    {
       
        // Configura los encabezados CORS
        header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
        header('Content-Type: application/json');

        $distrito = new Distrito();
        $resultado = $distrito->obtenerDistrito();
        echo json_encode($resultado);
        
    }
   
}

// Ejemplo de uso
$controladorDistrito = new ControladorDistrito();
$controladorDistrito->obtenerDistrito();
?>
