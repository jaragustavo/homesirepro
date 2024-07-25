<?php

class Profesion extends Conectar
{
   
    public function obtenerProfesion() {
          
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "SELECT * FROM public.profesiones
                ORDER BY nomprofe ASC ";
    
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>