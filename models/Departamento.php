<?php

class Departamento extends Conectar
{
   
    public function obtenerDepartamento() {
          
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "SELECT * FROM public.departamentos
                order by nomdpto";
        error_log('$$$$$$$$$$$ '.$sql);
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>