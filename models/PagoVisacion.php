<?php

class PagoVisacion extends Conectar
{
   
      public function obtenerPagoVisacion($cedula) {
       
        $conectar = parent::ConexionSirepro();
        $sql = "SELECT pv.*,
                 CASE 
                  WHEN pv.estado = '1' THEN 'NO'
                  WHEN pv.estado = '2' THEN 'SI'
                
                END AS des_estado,
                NULLIF(
                    CONCAT_WS(' ', 
                          NULLIF(TRIM(p.pnombre), ''), 
                          NULLIF(TRIM(p.snombre), ''), 
                          NULLIF(TRIM(p.tnombre), ''), 
                          NULLIF(TRIM(p.papellido), ''), 
                          NULLIF(TRIM(p.sapellido), '')
                    ), ''
                ) AS nombreProfesional
                FROM public.pagos_visaciones pv
                LEFT JOIN personas p ON p.cedula = pv.ciusuario
                WHERE pv.ciusuario LIKE (:cedula)
                ORDER BY pv.tid;";
        $query = $conectar->prepare($sql);
        $query->bindValue(':cedula', $cedula, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>