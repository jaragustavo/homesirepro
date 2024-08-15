<?php

class LugarTrabajo extends Conectar
{
    public function obtenerLugarTrabajo($cedula) {
        $conectar = parent::ConexionSirepro();
        $sql = "SELECT * FROM public.ltrabajo WHERE cedula = :cedula ORDER BY lugartra";
        $query = $conectar->prepare($sql);
        $query->bindValue(':cedula', $cedula, PDO::PARAM_STR); // Corrección aquí
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

