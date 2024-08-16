<?php

require_once '../config/conexion.php'; 
require_once '../models/LugarTrabajo.php'; 

class ControladorLugarTrabajo
{
  
    public function obtenerLugarTrabajo() {
        if (isset($_POST['cedula'])) {
            $cedula = $_POST['cedula'];
            $lugarTrabajo = new LugarTrabajo();
            $resultado = $lugarTrabajo->obtenerLugarTrabajo($cedula);
            echo json_encode($resultado);
        }
    }
   
}

$controladorLugarTrabajo = new ControladorLugarTrabajo();

if (isset($_GET['op']) && $_GET['op'] === 'obtenerLugarTrabajo') {

    $controladorLugarTrabajo->obtenerLugarTrabajo();
    
}
?>
