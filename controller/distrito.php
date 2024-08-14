<?php

require_once '../config/conexion.php'; 
require_once '../models/Distrito.php'; 

class ControladorDistrito
{
  
    public function obtenerDistritos() {
        if (isset($_POST['coddpto'])) {
            $coddpto = $_POST['coddpto'];
            $distrito = new Distrito();
            $resultado = $distrito->obtenerDistritosPorDepartamento($coddpto);
            echo json_encode($resultado);
        }
    }
   
}

$controladorDistrito = new ControladorDistrito();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['op']) && $_GET['op'] === 'obtenerDistritos') {

    $controladorDistrito->obtenerDistritos();
    
}
?>
