<?php

require_once '../config/conexion.php'; 
require_once '../models/Departamento.php'; 

class ControladorDepartamento
{
    private function verificarToken($token)
    {
        // Verifica el token con el valor esperado
        $tokenEsperado = TOKEN_SECRETO; // Puedes almacenar este valor en una configuración segura
        return $token === $tokenEsperado;
    }
    
    public function obtenerDepartamento()
    {
       
        // Configura los encabezados CORS
        header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
        header('Content-Type: application/json');

        $departamento = new Departamento();
        $resultado = $departamento->obtenerDepartamento();
        echo json_encode($resultado);
        
    }
   
}

// Ejemplo de uso
$controladorDepartamento = new ControladorDepartamento();
$controladorDepartamento->obtenerDepartamento();
?>obtenerDistrito();
?>
