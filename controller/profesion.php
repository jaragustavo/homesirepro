<?php

require_once '../config/conexion.php'; 
require_once '../models/Profesion.php'; 

class ControladorProfesion
{
    private function verificarToken($token)
    {
        // Verifica el token con el valor esperado
        $tokenEsperado = TOKEN_SECRETO; // Puedes almacenar este valor en una configuración segura
        return $token === $tokenEsperado;
    }
    
    public function obtenerProfesion()
    {
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';

          // Configura los encabezados CORS
          header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
          header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
      
    
        // Verificar el token
        if ($this->verificarToken($token)) {
           
                $profesion = new Profesion();
                $resultado = $profesion->obtenerProfesion();
                
                header('Content-Type: application/json');
                echo json_encode($resultado);
         
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token invalido']);
        }
    }
   
}

// Ejemplo de uso
$controladorProfesion = new ControladorProfesion();
$controladorProfesion->obtenerProfesion();
?>
