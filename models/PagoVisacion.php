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
    public function obtenerCantidadRepososWeb($cedula) {
      $conectar = parent::ConexionSirepro();
      $sql = "SELECT count(*) as cantidad_visado_web 
              FROM pagos_visaciones 
              WHERE ciprof = :cedula
                AND estado = '2'
                AND cantrep <> '0'";
  
       // Reemplazar el marcador de posición con el valor real
     //  $sql_debug = str_replace(':cedula', $conectar->quote($cedula), $sql);
    
       // Registrar el SQL con el valor de la variable
       error_log('SQL Query: ' . $sql_debug);

      $query = $conectar->prepare($sql);
      $query->bindValue(':cedula', $cedula, PDO::PARAM_STR);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
  }
    
}

?>