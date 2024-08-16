<?php

class Distrito extends Conectar
{
   
      public function obtenerDistritosPorDepartamento($coddpto) {
       
        $conectar = parent::ConexionSirepro();
        $sql = "SELECT coddist, nomdist FROM public.distritos WHERE coddpto = :coddpto ORDER BY nomdist";
        $query = $conectar->prepare($sql);
        $query->bindValue(':coddpto', $coddpto, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>