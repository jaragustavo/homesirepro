<?php

require_once '../config/conexion.php'; 
require_once '../models/Profesional.php'; 

class ControladorProfesional
{
    private function verificarToken($token)
    {
        // Verifica el token con el valor esperado
        $tokenEsperado = TOKEN_SECRETO; // Puedes almacenar este valor en una configuración segura
        return $token === $tokenEsperado;
    }
    
    public function obtenerProfesional()
    {
        $dato = isset($_GET['dato']) ? trim($_GET['dato']) : '';
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';
    
        // Verificar el token
        if ($this->verificarToken($token)) {
            if ($this->esParametroValido($dato)) {
                $profesional = new Profesional();
                $resultado = $profesional->obtenerProfesional($dato);
                
                header('Content-Type: application/json');
                echo json_encode($resultado);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Parámetro inválido']);
            }
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token inválido']);
        }
    }
   
    private function esParametroValido($dato)
    {
        // Aquí puedes agregar reglas de validación según sea necesario
        // Por ejemplo, asegurarte de que el dato sea una cadena alfanumérica y no esté vacío
        return !empty($dato) && preg_match('/^[a-zA-Z0-9\s]+$/', $dato);
    }
}

// Ejemplo de uso
$controladorProfesional = new ControladorProfesional();
$controladorProfesional->obtenerProfesional();
?>
