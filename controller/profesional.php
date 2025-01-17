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
        $item = isset($_GET['item']) ? trim($_GET['item']) : '';
        $valor = isset($_GET['valor']) ? trim($_GET['valor']) : '';
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';

        // Configura los encabezados CORS
        header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
    
        // Verificar el token
        if ($this->verificarToken($token)) {
            if ($this->esParametroValido($valor) || $this->esParametroValido($item)) {
                $profesional = new Profesional();
                $resultado = $profesional->obtenerProfesional($item,$valor);
                
                header('Content-Type: application/json');
                echo json_encode($resultado);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Parámetro invalido']);
            }
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token invalido']);
        }
    }
   
    public function obtenerProfesionalxCedula()
    {
        $item = isset($_REQUEST['item']) ? trim($_REQUEST['item']) : '';
        $valor = isset($_REQUEST['valor']) ? trim($_REQUEST['valor']) : '';
        $token = isset($_REQUEST['token']) ? trim($_REQUEST['token']) : '';

        // Configura los encabezados CORS
        header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
    
        // Verificar el token
        if ($this->verificarToken($token)) {
            if ($this->esParametroValido($valor) || $this->esParametroValido($item)) {
                $profesional = new Profesional();
                $resultado = $profesional->obtenerProfesionalxCedula($item,$valor);
             
                header('Content-Type: application/json');
              
                echo json_encode($resultado);
            } else {
            
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Parámetro invalido']);
            }
        } else {
           
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token invalido']);
        }
    }

    public function obtenerProfesionalxNroRegistro()
    {
        $item = isset($_GET['item']) ? trim($_GET['item']) : '';
        $valor = isset($_GET['valor']) ? trim($_GET['valor']) : '';
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';

        // Configura los encabezados CORS
        header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
    
        // Verificar el token
        if ($this->verificarToken($token)) {
            if ($this->esParametroValido($valor) || $this->esParametroValido($item)) {
                $profesional = new Profesional();
                $resultado = $profesional->obtenerProfesionalxNroRegistro($item,$valor);
                
                header('Content-Type: application/json');
                echo json_encode($resultado);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Parámetro invalido']);
            }
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token invalido']);
        }
    }
    public function obtenerProfesionalxNombre()
    {
        $item = isset($_GET['item']) ? trim($_GET['item']) : '';
        $valor = isset($_GET['valor']) ? trim($_GET['valor']) : '';
        $token = isset($_GET['token']) ? trim($_GET['token']) : '';

        // Configura los encabezados CORS
        header("Access-Control-Allow-Origin: *"); // Permite solicitudes desde cualquier origen
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Métodos permitidos
        header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Encabezados permitidos
    
        // Verificar el token
        if ($this->verificarToken($token)) {
            if ($this->esParametroValido($valor) || $this->esParametroValido($item)) {
                $profesional = new Profesional();
                $resultado = $profesional->obtenerProfesionalxNombre($item,$valor);
                
                header('Content-Type: application/json');
                echo json_encode($resultado);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Parámetro invalido']);
            }
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(['error' => 'Token invalido']);
        }
    }
    private function esParametroValido($dato)
    {
        // Aquí puedes agregar reglas de validación según sea necesario
        // Por ejemplo, asegurarte de que el dato sea una cadena alfanumérica y no esté vacío
        return !empty($dato) && preg_match('/^[a-zA-Z0-9\s]+$/', $dato);
    }
}


$controladorProfesional = new ControladorProfesional();

if (isset($_REQUEST['item']) && $_REQUEST['item'] == 'cedula') {
 

    $controladorProfesional->obtenerProfesionalxCedula();

}else if (isset($_REQUEST['item']) && $_REQUEST['item'] == 'nombreProfesional') {

    $controladorProfesional->obtenerProfesionalxNombre(); 

}else if (isset($_REQUEST['item']) && $_REQUEST['item'] == 'nroregis') {

    $controladorProfesional->obtenerProfesionalxNroRegistro(); 


}else if  (isset($_REQUEST['item']) && $_REQUEST['item'] != 'nombreProfesional' && $_REQUEST['item'] != 'cedula')  {

    $controladorProfesional->obtenerProfesional(); 

}

?>
