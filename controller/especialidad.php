<?php

require_once '../config/conexion.php'; 
require_once '../models/Especialidad.php'; 

class ControladorEspecialidad
{
  
    public function obtenerEspecialidad() {
        if (isset($_POST['cedula'])) {
            $cedula = $_POST['cedula'];
            $especialidad = new Especialidad();
            $resultado = $especialidad->obtenerEspecialidad($cedula);
            echo json_encode($resultado);
        }
    }
   
}

$controladorEspecialidad = new ControladorEspecialidad();

if (isset($_GET['op']) && $_GET['op'] === 'obtenerEspecialidad') {

    $controladorEspecialidad->obtenerEspecialidad();
    
}
?>
