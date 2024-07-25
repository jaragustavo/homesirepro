<?php

class Categoria extends Conectar
{
   
    public function obtenerCategoria() {
          
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "SELECT * FROM public.categoria
                order by nomcateg";
    
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>