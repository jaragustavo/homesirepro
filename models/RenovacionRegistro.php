<?php
    class RenovacionRegistro extends Conectar{

        /* TODO: Listar reposos segun CI del usuario (médico) */
        public function listar_renovacion_registro($cedula){
            $conectar= parent::conexionSirepro();
            $sql="SELECT * FROM pagos_renovreg
                  WHERE cedula = '3383782'
                  order by tid desc 
                    ";
            error_log($sql);
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Filtro Avanzado de reposos */
        public function filtrar_reposos($cedula,$ci_paciente,$nombre_paciente,$fecha_inicio_reposo){
           
            $conectar= parent::conexionSirepro();
            // Construir la consulta con placeholders
            // $sql = "SELECT id AS id_reposo, cedula AS ci_paciente, nombyapel AS nombre_paciente,
            //             nrecibo, fechainicio AS fecha_inicio, fechafin AS fecha_fin, cantrep 
            //         FROM reposos 
            //         WHERE ciprof = :cedula";

            $sql = "select * from (SELECT cast (tid as bigint) id_reposo, ciusuario ci_paciente, nombyapel nombre_paciente,
                    0 nrecibo,fechainicio fecha_inicio,fechafin fecha_fin, cantrep
                    FROM pagos_visaciones 
                    WHERE ciprof = :cedula
                    AND estado = '2'
                    AND cantrep <> '0'
                    union
                    select id AS id_reposo, cedula AS ci_paciente, nombyapel AS nombre_paciente,
                        nrecibo, fechainicio AS fecha_inicio, fechafin AS fecha_fin, cantrep  from reposos
                    WHERE ciprof = :cedula
                    AND estado = '2'
                    AND cantrep <> '0'
                    ) DATO
                     WHERE 1 = 1";
                    
            // Añadir condiciones dinámicamente
            if ($ci_paciente != "") {
                $sql .= " AND ci_paciente ILIKE :ci_paciente";
            }
            if ($nombre_paciente != "") {
                $sql .= " AND nombre_paciente ILIKE :nombre_paciente";
            }
            if ($fecha_inicio_reposo != "") {
                $sql .= " AND fecha_inicio::date >= :fecha_inicio_reposo";
            }

            // Preparar la consulta
            $stmt = $conectar->prepare($sql);

            // Vincular parámetros
            $stmt->bindParam(':cedula', $cedula);

            if ($ci_paciente != "") {
                $ci_paciente_param = "%$ci_paciente%";
                $stmt->bindParam(':ci_paciente', $ci_paciente_param);
            }
            if ($nombre_paciente != "") {
                $nombre_paciente_param = "%$nombre_paciente%";
                $stmt->bindParam(':nombre_paciente', $nombre_paciente_param);
            }
            if ($fecha_inicio_reposo != "") {
                $stmt->bindParam(':fecha_inicio_reposo', $fecha_inicio_reposo);
            }

            // Ejecutar la consulta
            $stmt->execute();
            $conectar = null;

            return $resultado = $stmt->fetchAll();
        }

        /* TODO: Mostrar documento personal segun id del documento */
        public function mostrar($doc_personal_id){
            $conectar= parent::conexion();
            $sql="SELECT 
            datos_personales.id as dato_personal_id, usuario_id,tipos_documentos.id as tipo_documento,
            pdf as documento,fecha,dato_adic
            FROM 
            datos_personales
            INNER join tipos_documentos on tipos_documentos.id = datos_personales.tipo_doc_id
            WHERE
            datos_personales.id = $doc_personal_id";

            $sql=$conectar->prepare($sql);
            $sql->execute();
            $conectar = null;

            return $resultado=$sql->fetchAll();
        }

    }
?>