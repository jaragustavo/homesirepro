<?php

class Especialidad extends Conectar
{
    public function obtenerEspecialidad($cedula) {
        $conectar = parent::ConexionSirepro();
         $sql = "select distinct on (a.codespe) a.*,b.nomespe 
					from rprofesional a
					INNER JOIN especialidades b ON (A.codespe = b.codespe)
					where cedula = :cedula
					and   tipoprof = 4";
                    error_log('$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$');
        $query = $conectar->prepare($sql);
        $query->bindValue(':cedula', $cedula, PDO::PARAM_STR); // Corrección aquí
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

