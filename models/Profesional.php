<?php

class Profesional extends Conectar
{
   
    public function obtenerProfesional($dato){
        $conectar = parent::ConexionSirepro();
        $sql = "WITH dato AS (
                SELECT 
                    a.tipoprof,
                    a.codprofe,
                    MAX(a.fechains) AS fechains, -- Obtiene la fecha más reciente de inscripción
                    a.cedula,
                    a.nroregis,
                    p.pnombre || ' ' || p.snombre  || ' ' || p.tnombre AS nombres, -- Concatenación de nombres
                    p.papellido  || ' ' || p.sapellido AS apellidos, -- Concatenación de apellidos
                    b.nomprofe,
                    i.nomuniv
                FROM 
                    rprofesional a
                    JOIN profesiones b ON a.codprofe = b.codprofe
                    JOIN titulos c ON a.codtitu = c.codtitu
                    JOIN personas p ON a.cedula = p.cedula
                    JOIN instituciones i ON a.coduniv = i.coduniv
                WHERE 
                    a.tipoprof <> 4 
                GROUP BY 
                    a.tipoprof, 
                    a.codprofe, 
                    a.cedula, 
                    a.nroregis, 
                    p.pnombre, 
                    p.snombre, 
                    p.tnombre, 
                    p.papellido, 
                    p.sapellido, 
                    b.nomprofe, 
                    i.nomuniv
            ),


            espe AS (
                SELECT 
                    *,
                    ROW_NUMBER() OVER (PARTITION BY cedula, nroregis, codprofe ORDER BY cedula) AS rn
                FROM 
                    rprofesional 
                WHERE 
                    tipoprof = 4 
            ),

            -- Subconsulta 'pivot': Pivotea los valores de 'codespe' en columnas y calcula las nuevas columnas
            pivot AS (
                SELECT 
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombres,
                    dato.apellidos,
                    dato.nomprofe,
                    dato.nomuniv,
                    MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END) AS codespe1, -- Asigna la primera especialidad
                    MAX(CASE WHEN espe.rn = 2 THEN espe.codespe END) AS codespe2, -- Asigna la segunda especialidad
                    MAX(CASE WHEN espe.rn = 3 THEN espe.codespe END) AS codespe3, -- Asigna la tercera especialidad
                    dato.fechains + INTERVAL '5 years' AS fecha_vencimiento, -- Calcula la fecha de vencimiento sumando 5 años a 'fechains'
                    CASE 
                        WHEN (dato.fechains + INTERVAL '5 years') < CURRENT_DATE THEN 'vencido' -- Determina el estado como 'vencido' si la fecha de vencimiento es menor a la fecha actual
                        ELSE 'vigente' -- Determina el estado como 'vigente' si la fecha de vencimiento es mayor o igual a la fecha actual
                    END AS estado,
                    CASE 
                        WHEN MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END) IS NOT NULL THEN 'SI' -- Si tiene al menos una especialidad
                        ELSE 'NO' -- Si no tiene ninguna especialidad
                    END AS tiene_especialidad
                FROM dato
                LEFT JOIN espe ON 
                    dato.cedula = espe.cedula
                    AND dato.nroregis = espe.nroregis
                    AND dato.codprofe = espe.codprofe
                GROUP BY 
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombres,
                    dato.apellidos,
                    dato.nomprofe,
                    dato.nomuniv
            )

            -- Consulta final: Realiza los LEFT JOINs con la tabla 'especialidades' para obtener las descripciones y selecciona las columnas deseadas
            SELECT 
                pivot.tipoprof,
                pivot.codprofe,
                pivot.fechains,
                pivot.fecha_vencimiento, -- Columna nueva para la fecha de vencimiento
                pivot.estado, -- Columna nueva para el estado
                pivot.cedula,
                pivot.nroregis,
                pivot.nombres,
                pivot.apellidos,
                pivot.nomprofe,
                pivot.nomuniv,
                pivot.codespe1,
                e1.nomespe AS description1, -- Descripción de la primera especialidad
                pivot.codespe2,
                e2.nomespe AS description2, -- Descripción de la segunda especialidad
                pivot.codespe3,
                e3.nomespe AS description3, -- Descripción de la tercera especialidad
                pivot.tiene_especialidad -- Nueva columna que indica si tiene especialidad o no
            FROM 
                pivot
            LEFT JOIN especialidades e1 ON pivot.codespe1 = e1.codespe
            LEFT JOIN especialidades e2 ON pivot.codespe2 = e2.codespe
            LEFT JOIN especialidades e3 ON pivot.codespe3 = e3.codespe
            WHERE 
                pivot.tipoprof::text ILIKE UPPER('%$dato%') OR
                pivot.codprofe::text ILIKE UPPER('%$dato%') OR
                pivot.fechains::text ILIKE UPPER('%$dato%') OR
                pivot.fecha_vencimiento::text ILIKE UPPER('%$dato%') OR
                pivot.estado ILIKE UPPER('%$dato%') OR
                pivot.cedula::text ILIKE UPPER('%$dato%') OR
                pivot.nroregis::text ILIKE UPPER('%$dato%') OR
                pivot.nombres ILIKE UPPER('%$dato%') OR
                pivot.apellidos ILIKE UPPER('%$dato%') OR
                pivot.nomprofe ILIKE UPPER('%$dato%') OR
                pivot.nomuniv ILIKE UPPER('%$dato%') OR
                pivot.codespe1::text ILIKE UPPER('%$dato%') OR
                e1.nomespe ILIKE UPPER('%$dato%') OR
                pivot.codespe2::text ILIKE UPPER('%$dato%') OR
                e2.nomespe ILIKE UPPER('%$dato%') OR
                pivot.codespe3::text ILIKE UPPER('%$dato%') OR
                e3.nomespe ILIKE UPPER('%$dato%') OR
                pivot.tiene_especialidad ILIKE UPPER('%$dato%')
            ORDER BY 
                pivot.cedula, 
                pivot.codprofe;";

        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>