
<?php

require_once '../config/conexion.php'; 
require_once '../models/PagoVisacion.php'; 

class ControladorPagoVisacion
{
    private function verificarToken($token)
    {
        // Verifica el token con el valor esperado
        $tokenEsperado = TOKEN_SECRETO; // Puedes almacenar este valor en una configuración segura
        return $token === $tokenEsperado;
    }
    
    public function obtenerPagoVisacion()
    {
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';

          // Configura los encabezados CORS
          header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
          header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
      
    
        // Verificar el token
        if ($this->verificarToken($token)) {
                $cedula = isset($_REQUEST['cedula']) ? trim($_REQUEST['cedula']) : '';
                $pagoVisacion = new PagoVisacion();
                $resultado = $pagoVisacion->obtenerPagoVisacion($cedula);
                
                header('Content-Type: application/json');
                echo json_encode($resultado);
         
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token invalido']);
        }
    }

   
}

// Ejemplo de uso
$pagoVisacion = new ControladorPagoVisacion();
$pagoVisacion->obtenerPagoVisacion();

?>
