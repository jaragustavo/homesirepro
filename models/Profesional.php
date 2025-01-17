<?php

class Profesional extends Conectar
{
   
    public function obtenerProfesional($item, $valor) {
        // Validar que $item sea una columna válida
        $columnasValidas = ['codprofe', 'cedula', 'nroregis', 'nombreProfesional', 'codcateg1'];
        if (!in_array($item, $columnasValidas)) {
            throw new InvalidArgumentException("Columna no válida: $item");
        }
    
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "WITH dato AS (
                SELECT 
                    a.tipoprof,
                    a.codprofe,
                    MAX(a.fechains) AS fechains,
                    a.cedula,
                    a.nroregis,
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), ''), 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) AS nombreProfesional,
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) AS apellidos, 
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), '')
                    ) AS nombres,
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
                    tipoprof,
                    codprofe,
                    MAX(fechains) AS fechainsespe,
                    cedula,
                    nroregis,
                    codespe,
                    ROW_NUMBER() OVER (PARTITION BY cedula, nroregis, codprofe ORDER BY cedula) AS rn
                FROM 
                    rprofesional 
                WHERE 
                    tipoprof = 4
                GROUP BY  
                    tipoprof,
                    codprofe,
                    cedula,
                    nroregis,
                    codespe
            ),
            pivot AS (
                SELECT 
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombreProfesional,
                    dato.apellidos,
                    dato.nombres,
                    dato.nomprofe,
                    dato.nomuniv,
                    MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END) AS codespe1,
                    MAX(CASE WHEN espe.rn = 2 THEN espe.codespe END) AS codespe2,
                    MAX(CASE WHEN espe.rn = 3 THEN espe.codespe END) AS codespe3,
                    dato.fechains + INTERVAL '5 years' AS fecha_vencimiento,
                    CASE 
                        WHEN (dato.fechains + INTERVAL '5 years') < CURRENT_DATE THEN 'vencido'
                        ELSE 'vigente'
                    END AS estado,
                    CASE 
                        WHEN MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END) IS NOT NULL THEN 'SI'
                        ELSE 'NO'
                    END AS tiene_especialidad,
                    COALESCE(
                        (CASE WHEN MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END) IS NOT NULL THEN 1 ELSE 0 END) +
                        (CASE WHEN MAX(CASE WHEN espe.rn = 2 THEN espe.codespe END) IS NOT NULL THEN 1 ELSE 0 END) +
                        (CASE WHEN MAX(CASE WHEN espe.rn = 3 THEN espe.codespe END) IS NOT NULL THEN 1 ELSE 0 END), 0
                    ) AS cantidad_especialidad
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
                    dato.nombreProfesional,
                    dato.nomprofe,
                    dato.nomuniv,
                    dato.apellidos,
                    dato.nombres
            ),
            especialidades_con_categoria AS (
                SELECT 
                    e.codespe,
                    e.nomespe,
                    cate.codcateg,
                    cate.nomcateg
                FROM 
                    especialidades e
                INNER JOIN 
                    categoria cate ON e.codcateg = cate.codcateg
            ),
            final AS (
                SELECT 
                    pivot.tipoprof,
                    pivot.codprofe,
                    pivot.fechains,
                    pivot.fecha_vencimiento,
                    pivot.estado,
                    pivot.cedula,
                    pivot.nroregis,
                    pivot.nombreProfesional,
                    pivot.apellidos,
                    pivot.nombres,
                    pivot.nomprofe,
                    pivot.nomuniv,
                    pivot.codespe1,
                    espe1.nomespe AS description1,
                    espe1.codcateg AS codcateg1,
                    espe1.nomcateg AS nomcateg1,
                    pivot.codespe2,
                    espe2.nomespe AS description2,
                    espe2.codcateg AS codcateg2,
                    espe2.nomcateg AS nomcateg2,
                    pivot.codespe3,
                    espe3.nomespe AS description3,
                    espe3.codcateg AS codcateg3,
                    espe3.nomcateg AS nomcateg3,
                    pivot.tiene_especialidad,
                    pivot.cantidad_especialidad,
                    CONCAT_WS(', ', 
                        NULLIF(trim(espe1.nomcateg), ''), 
                        NULLIF(trim(espe2.nomcateg), ''), 
                        NULLIF(trim(espe3.nomcateg), '')
                    ) AS categoria
                FROM 
                    pivot
                LEFT JOIN especialidades_con_categoria espe1 ON pivot.codespe1 = espe1.codespe
                LEFT JOIN especialidades_con_categoria espe2 ON pivot.codespe2 = espe2.codespe
                LEFT JOIN especialidades_con_categoria espe3 ON pivot.codespe3 = espe3.codespe
            )
            SELECT * FROM final
                WHERE 
            (
               (CASE 
                    WHEN '$item' = 'codcateg1' THEN codcateg1::text
                    WHEN '$item' = 'codcateg2' THEN codcateg2::text
                    WHEN '$item' = 'codcateg3' THEN codcateg3::text
                    WHEN '$item' = 'cedula' THEN cedula::text
                    WHEN '$item' = 'nroregis' THEN nroregis::text
                    WHEN '$item' = 'nombreProfesional' THEN nombreProfesional::text
                    WHEN '$item' = 'codprofe' THEN codprofe::text
                    ELSE NULL
                END) ILIKE UPPER('%$valor%')
                OR (codcateg1::text ILIKE UPPER('%$valor%'))
                OR (codcateg2::text ILIKE UPPER('%$valor%'))
                OR (codcateg3::text ILIKE UPPER('%$valor%'))
            )
        ORDER BY 
            final.apellidos, 
            final.nombres,
            final.nomprofe;";
    
            $query = $conectar->prepare($sql);
            $query->execute();
            $conectar = null;
            return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProfesionalxNroRegistro($item,$valor) {

        // Validar que $item sea una columna válida
        $columnasValidas = ['codprofe', 'cedula', 'nroregis', 'nombreProfesional', 'codcateg1'];
        if (!in_array($item, $columnasValidas)) {
            throw new InvalidArgumentException("Columna no válida: $item");
        }
    
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "WITH dato AS (
                SELECT 
                    a.tipoprof,
                    a.codprofe,
                    MAX(a.fechains) AS fechains,
                    MAX(a.fechains) + INTERVAL '5 years' AS fecha_vencimiento,
                    CASE 
                        WHEN (MAX(a.fechains) + INTERVAL '5 years') < CURRENT_DATE THEN 'vencido'
                        ELSE 'vigente'
                    END AS estado,
                    a.cedula,
                    a.nroregis,
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), ''), 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) AS nombreProfesional,
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) AS apellidos, 
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), '')
                    ) AS nombres,
                    b.nomprofe,
                    STRING_AGG(DISTINCT i.nomuniv, ' .--.') AS nomuniv_concat
                FROM 
                    rprofesional a
                JOIN profesiones b ON a.codprofe = b.codprofe
                JOIN titulos c ON a.codtitu = c.codtitu
                JOIN personas p ON a.cedula = p.cedula
                JOIN instituciones i ON a.coduniv = i.coduniv
                WHERE 
                    a.tipoprof <> 4 
                AND a.nroregis = '$valor'
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
                b.nomprofe
            
            ),
            espe AS (
                SELECT DISTINCT ON (e.codespe) 
                    e.tipoprof,
                    e.codprofe,
                    MAX(e.fechains) AS fecinsespe,
                    e.cedula,
                    e.nroregis,
                    e.codespe,
                    es.nomespe,
                    es.codcateg,
                    cat.nomcateg,
                    ROW_NUMBER() OVER (PARTITION BY e.cedula, e.nroregis, e.codprofe ORDER BY e.fechains) AS rn
                FROM 
                    rprofesional e
                JOIN especialidades es ON e.codespe = es.codespe
                JOIN categoria cat ON es.codcateg = cat.codcateg
                JOIN personas p ON p.cedula = e.cedula 
                WHERE 
                    e.tipoprof = 4
                AND e.nroregis = '$valor'
                GROUP BY 
                    e.tipoprof,
                    e.codprofe,
                    e.fechains,
                    e.cedula,
                    e.nroregis,
                    e.codespe,
                p.pnombre, 
                    p.snombre, 
                    p.tnombre, 
                    p.papellido, 
                    p.sapellido, 
                    es.nomespe,
                    es.codcateg,
                    cat.nomcateg
            
            ),
            pivot AS (
                SELECT 
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.fecha_vencimiento,
                    dato.estado,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombreProfesional,
                    dato.apellidos,
                    dato.nombres,
                    dato.nomprofe,
                    dato.nomuniv_concat,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END), '-') AS codespe1,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomespe END), '-') AS nomespe1,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.codcateg END), '-') AS codcateg1,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomcateg END), '-') AS nomcateg1,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.codespe END), '-') AS codespe2,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomespe END), '-') AS nomespe2,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.codcateg END), '-') AS codcateg2,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomcateg END), '-') AS nomcateg2,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.codespe END), '-') AS codespe3,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomespe END), '-') AS nomespe3,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.codcateg END), '-') AS codcateg3,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomcateg END), '-') AS nomcateg3,
                    MAX(CASE WHEN espe.rn = 1 THEN espe.fecinsespe END) AS fecinsespe1,
                    MAX(CASE WHEN espe.rn = 2 THEN espe.fecinsespe END) AS fecinsespe2,
                    MAX(CASE WHEN espe.rn = 3 THEN espe.fecinsespe END) AS fecinsespe3,
                    COUNT(DISTINCT espe.codespe) AS cantidad_especialidad,
                    CONCAT_WS('.--.',
                        NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomcateg END), '-'), '-'),
                        NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomcateg END), '-'), '-'),
                        NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomcateg END), '-'), '-')
                    ) AS categoria
                FROM 
                    dato
                LEFT JOIN 
                    espe 
                ON 
                    dato.cedula = espe.cedula
                    AND dato.nroregis = espe.nroregis
                    AND dato.codprofe = espe.codprofe
                GROUP BY
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.fecha_vencimiento,
                    dato.estado,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombreProfesional,
                    dato.apellidos,
                    dato.nombres,
                    dato.nomprofe,
                    dato.nomuniv_concat
            )
            SELECT 
                tipoprof,
                codprofe,
                fechains,
                fecha_vencimiento,
                estado,
                cedula,
                nroregis,
                nombreProfesional,
                apellidos,
                nombres,
                nomprofe,
                nomuniv_concat,
                codespe1,
                nomespe1,
                fecinsespe1,
                codespe2,
                nomespe2,
                fecinsespe2,
                codespe3,
                nomespe3,
                fecinsespe3,
                cantidad_especialidad,
                categoria
            FROM 
                pivot
            ORDER BY 
                apellidos,
                nombres;";
            
        // Registrar la consulta SQL completa en error_log
            
            // Preparar y ejecutar la consulta
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProfesionalxCedula($item,$valor) {

        // Validar que $item sea una columna válida
        $columnasValidas = ['codprofe', 'cedula', 'nroregis', 'nombreProfesional', 'codcateg1'];
        if (!in_array($item, $columnasValidas)) {
            throw new InvalidArgumentException("Columna no válida: $item");
        }
    
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "WITH dato AS (
                    SELECT 
	                    a.norden,
	                    a.tipoinsc,
                        a.tipoprof,
	                    a.formainsc,
                        a.codprofe,
                        MAX(a.fechains) AS fechains,
                        MAX(a.fechains) + INTERVAL '5 years' AS fecha_vencimiento,
                        CASE 
                            WHEN (MAX(a.fechains) + INTERVAL '5 years') < CURRENT_DATE THEN 'vencido'
                            ELSE 'vigente'
                        END AS estado,
                        a.cedula,
                        a.nroregis,
                        CONCAT_WS(' ', 
                            NULLIF(trim(p.pnombre), ''), 
                            NULLIF(trim(p.snombre), ''), 
                            NULLIF(trim(p.tnombre), ''), 
                            NULLIF(trim(p.papellido), ''), 
                            NULLIF(trim(p.sapellido), '')
                        ) AS nombreProfesional,
                        CONCAT_WS(' ', 
                            NULLIF(trim(p.papellido), ''), 
                            NULLIF(trim(p.sapellido), '')
                        ) AS apellidos, 
                        CONCAT_WS(' ', 
                            NULLIF(trim(p.pnombre), ''), 
                            NULLIF(trim(p.snombre), ''), 
                            NULLIF(trim(p.tnombre), '')
                        ) AS nombres,
                        b.nomprofe,
                        STRING_AGG(DISTINCT i.nomuniv, ' .--.') AS nomuniv_concat
                    FROM 
                        rprofesional a
                    JOIN profesiones b ON a.codprofe = b.codprofe
                    JOIN titulos c ON a.codtitu = c.codtitu
                    JOIN personas p ON a.cedula = p.cedula
                    JOIN instituciones i ON a.coduniv = i.coduniv
                    WHERE 
                        a.tipoprof <> 4 
                    AND a.cedula = '$valor'
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
	                a.tipoinsc,
	                 a.norden,
	                a.formainsc
	     
                
                ),
                espe AS (
                    SELECT DISTINCT ON (e.codespe) 
                        e.tipoprof,
                        e.codprofe,
                        MAX(e.fechains) AS fecinsespe,
                        e.cedula,
                        e.nroregis,
                        e.codespe,
                        es.nomespe,
                        es.codcateg,
                        cat.nomcateg,
                        ROW_NUMBER() OVER (PARTITION BY e.cedula, e.nroregis, e.codprofe ORDER BY e.fechains) AS rn
                    FROM 
                        rprofesional e
                    JOIN especialidades es ON e.codespe = es.codespe
                    JOIN categoria cat ON es.codcateg = cat.codcateg
                    JOIN personas p ON p.cedula = e.cedula 
                    WHERE 
                        e.tipoprof = 4
                    AND e.cedula = '$valor'
                    GROUP BY 
                        e.tipoprof,
                        e.codprofe,
                        e.fechains,
                        e.cedula,
                        e.nroregis,
                        e.codespe,
                        p.pnombre, 
                        p.snombre, 
                        p.tnombre, 
                        p.papellido, 
                        p.sapellido, 
                        es.nomespe,
                        es.codcateg,
                        cat.nomcateg
                
                ),
                pivot AS (
                    SELECT 
					    dato.norden,
					    dato.tipoinsc,
					    dato.formainsc,
                        dato.tipoprof,
                        dato.codprofe,
                        dato.fechains,
                        dato.fecha_vencimiento,
                        dato.estado,
                        dato.cedula,
                        dato.nroregis,
                        dato.nombreProfesional,
                        dato.apellidos,
                        dato.nombres,
                        dato.nomprofe,
                        dato.nomuniv_concat,
                        COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END), '-') AS codespe1,
                        COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomespe END), '-') AS nomespe1,
                        COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.codcateg END), '-') AS codcateg1,
                        COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomcateg END), '-') AS nomcateg1,
                        COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.codespe END), '-') AS codespe2,
                        COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomespe END), '-') AS nomespe2,
                        COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.codcateg END), '-') AS codcateg2,
                        COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomcateg END), '-') AS nomcateg2,
                        COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.codespe END), '-') AS codespe3,
                        COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomespe END), '-') AS nomespe3,
                        COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.codcateg END), '-') AS codcateg3,
                        COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomcateg END), '-') AS nomcateg3,
                        MAX(CASE WHEN espe.rn = 1 THEN espe.fecinsespe END) AS fecinsespe1,
                        MAX(CASE WHEN espe.rn = 2 THEN espe.fecinsespe END) AS fecinsespe2,
                        MAX(CASE WHEN espe.rn = 3 THEN espe.fecinsespe END) AS fecinsespe3,
                        COUNT(DISTINCT espe.codespe) AS cantidad_especialidad,
                        CONCAT_WS('.--.',
                            NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomcateg END), '-'), '-'),
                            NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomcateg END), '-'), '-'),
                            NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomcateg END), '-'), '-')
                        ) AS categoria
                    FROM 
                        dato
                    LEFT JOIN 
                        espe 
                    ON 
                        dato.cedula = espe.cedula
                        AND dato.nroregis = espe.nroregis
                        AND dato.codprofe = espe.codprofe
                    GROUP BY
					    dato.tipoinsc,
				    	dato.formainsc,
                        dato.tipoprof,
                        dato.codprofe,
                        dato.fechains,
                        dato.fecha_vencimiento,
                        dato.estado,
                        dato.cedula,
                        dato.nroregis,
                        dato.nombreProfesional,
                        dato.apellidos,
                        dato.nombres,
                        dato.nomprofe,
					    dato.norden,
                        dato.nomuniv_concat
                )
                SELECT 
				    norden,
				    tipoinsc,
				    formainsc,
                    tipoprof,
                    codprofe,
                    fechains,
                    fecha_vencimiento,
                    estado,
                    cedula,
                    nroregis,
                    nombreProfesional,
                    apellidos,
                    nombres,
                    nomprofe,
                    nomuniv_concat,
                    codespe1,
                    nomespe1,
                    fecinsespe1,
                    codespe2,
                    nomespe2,
                    fecinsespe2,
                    codespe3,
                    nomespe3,
                    fecinsespe3,
                    cantidad_especialidad,
                    categoria
                FROM 
                    pivot
                ORDER BY 
                    apellidos,
                    nombres;";
          
                $query = $conectar->prepare($sql);
                $query->execute();
                $conectar = null;
                return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProfesionalxNombre($item,$valor) {

        // Validar que $item sea una columna válida
        $columnasValidas = ['codprofe', 'cedula', 'nroregis', 'nombreProfesional', 'codcateg1'];
        if (!in_array($item, $columnasValidas)) {
            throw new InvalidArgumentException("Columna no válida: $item");
        }
    
        $conectar = parent::ConexionSirepro();
    
        // Construir la consulta SQL con la columna y valor proporcionados
        $sql = "WITH dato AS (
                SELECT 
                    a.tipoprof,
                    a.codprofe,
                    MAX(a.fechains) AS fechains,
                    MAX(a.fechains) + INTERVAL '5 years' AS fecha_vencimiento,
                    CASE 
                        WHEN (MAX(a.fechains) + INTERVAL '5 years') < CURRENT_DATE THEN 'vencido'
                        ELSE 'vigente'
                    END AS estado,
                    a.cedula,
                    a.nroregis,
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), ''), 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) AS nombreProfesional,
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) AS apellidos, 
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), '')
                    ) AS nombres,
                    b.nomprofe,
                    STRING_AGG(DISTINCT i.nomuniv, ' .--.') AS nomuniv_concat
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
                    b.nomprofe
                HAVING 
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), ''), 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) LIKE UPPER('%$valor%')
            ),
            espe AS (
                SELECT DISTINCT ON (e.codespe) 
                    e.tipoprof,
                    e.codprofe,
                    MAX(e.fechains) AS fecinsespe,
                    e.cedula,
                    e.nroregis,
                    e.codespe,
                    es.nomespe,
                    es.codcateg,
                    cat.nomcateg,
                    ROW_NUMBER() OVER (PARTITION BY e.cedula, e.nroregis, e.codprofe ORDER BY e.fechains) AS rn
                FROM 
                    rprofesional e
                JOIN especialidades es ON e.codespe = es.codespe
                JOIN categoria cat ON es.codcateg = cat.codcateg
                JOIN personas p ON p.cedula = e.cedula 
                WHERE 
                    e.tipoprof = 4
                GROUP BY 
                    e.tipoprof,
                    e.codprofe,
                    e.fechains,
                    e.cedula,
                    e.nroregis,
                    e.codespe,
                    p.pnombre, 
                    p.snombre, 
                    p.tnombre, 
                    p.papellido, 
                    p.sapellido, 
                    es.nomespe,
                    es.codcateg,
                    cat.nomcateg
                HAVING 
                    CONCAT_WS(' ', 
                        NULLIF(trim(p.pnombre), ''), 
                        NULLIF(trim(p.snombre), ''), 
                        NULLIF(trim(p.tnombre), ''), 
                        NULLIF(trim(p.papellido), ''), 
                        NULLIF(trim(p.sapellido), '')
                    ) LIKE UPPER('%$valor%')
            ),
            pivot AS (
                SELECT 
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.fecha_vencimiento,
                    dato.estado,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombreProfesional,
                    dato.apellidos,
                    dato.nombres,
                    dato.nomprofe,
                    dato.nomuniv_concat,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.codespe END), '-') AS codespe1,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomespe END), '-') AS nomespe1,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.codcateg END), '-') AS codcateg1,
                    COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomcateg END), '-') AS nomcateg1,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.codespe END), '-') AS codespe2,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomespe END), '-') AS nomespe2,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.codcateg END), '-') AS codcateg2,
                    COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomcateg END), '-') AS nomcateg2,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.codespe END), '-') AS codespe3,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomespe END), '-') AS nomespe3,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.codcateg END), '-') AS codcateg3,
                    COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomcateg END), '-') AS nomcateg3,
                    MAX(CASE WHEN espe.rn = 1 THEN espe.fecinsespe END) AS fecinsespe1,
                    MAX(CASE WHEN espe.rn = 2 THEN espe.fecinsespe END) AS fecinsespe2,
                    MAX(CASE WHEN espe.rn = 3 THEN espe.fecinsespe END) AS fecinsespe3,
                    COUNT(DISTINCT espe.codespe) AS cantidad_especialidad,
                    CONCAT_WS('.--.',
                        NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 1 THEN espe.nomcateg END), '-'), '-'),
                        NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 2 THEN espe.nomcateg END), '-'), '-'),
                        NULLIF(COALESCE(MAX(CASE WHEN espe.rn = 3 THEN espe.nomcateg END), '-'), '-')
                    ) AS categoria
                FROM 
                    dato
                LEFT JOIN 
                    espe 
                ON 
                    dato.cedula = espe.cedula
                    AND dato.nroregis = espe.nroregis
                    AND dato.codprofe = espe.codprofe
                GROUP BY
                    dato.tipoprof,
                    dato.codprofe,
                    dato.fechains,
                    dato.fecha_vencimiento,
                    dato.estado,
                    dato.cedula,
                    dato.nroregis,
                    dato.nombreProfesional,
                    dato.apellidos,
                    dato.nombres,
                    dato.nomprofe,
                    dato.nomuniv_concat
            )
            SELECT 
                tipoprof,
                codprofe,
                fechains,
                fecha_vencimiento,
                estado,
                cedula,
                nroregis,
                nombreProfesional,
                apellidos,
                nombres,
                nomprofe,
                nomuniv_concat,
                codespe1,
                nomespe1,
                fecinsespe1,
                codespe2,
                nomespe2,
                fecinsespe2,
                codespe3,
                nomespe3,
                fecinsespe3,
                cantidad_especialidad,
                categoria
            FROM 
                pivot
            ORDER BY 
                apellidos,
                nombres;";

        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>