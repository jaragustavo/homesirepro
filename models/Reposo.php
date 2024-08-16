<?php
    class Reposo extends Conectar{

        /* TODO: Listar reposos segun CI del usuario (médico) */
        public function listar_reposos_x_medico($cedula){
            $conectar= parent::conexionSirepro();
            $sql="select id as id_reposo, cedula as ci_paciente, nombyapel as nombre_paciente,
            nrecibo, fechainicio as fecha_inicio, fechafin as fecha_fin, cantrep from reposos 
            where ciprof = '$cedula'";
      
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Filtro Avanzado de reposos */
        public function filtrar_reposos($cedula,$ci_paciente,$nombre_paciente,$fecha_inicio_reposo){
           
            $conectar= parent::conexionSirepro();
            // Construir la consulta con placeholders
            $sql = "SELECT id AS id_reposo, cedula AS ci_paciente, nombyapel AS nombre_paciente,
                        nrecibo, fechainicio AS fecha_inicio, fechafin AS fecha_fin, cantrep 
                    FROM reposos 
                    WHERE ciprof = :cedula";
            
            // Añadir condiciones dinámicamente
            if ($ci_paciente != "") {
                $sql .= " AND cedula ILIKE :ci_paciente";
            }
            if ($nombre_paciente != "") {
                $sql .= " AND nombyapel ILIKE :nombre_paciente";
            }
            if ($fecha_inicio_reposo != "") {
                $sql .= " AND fechainicio::date >= :fecha_inicio_reposo";
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