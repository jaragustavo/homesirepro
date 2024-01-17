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
            $condicionCiPaciente = "";
            $condicionNombrePaciente = "";
            $condicionFecha = "";
            $and = "";
            $and2 = "";
            if($ci_paciente != ""){
                $condicionCiPaciente = "cedula ilike '%$ci_paciente%' ";
            } 
            if($nombre_paciente != ""){
                $condicionNombrePaciente = "nombyapel ilike '%$nombre_paciente%' ";
            }
            if($fecha_inicio_reposo != ""){
                $condicionFecha= "fechainicio::date = '$fecha'";
            }
            if($condicionNombrePaciente != "" && $condicionCiPaciente != ""){
                $and = " AND ";
            }
            if($condicionFecha != "" && $condicionNombrePaciente != ""){
                $and2 = " AND ";
            }
            $sql="select id as id_reposo, cedula as ci_paciente, nombyapel as nombre_paciente,
            nrecibo, fechainicio as fecha_inicio, fechafin as fecha_fin, cantrep from reposos 
            where ciprof = '$cedula' AND ".$condicionCiPaciente.$and.$condicionNombrePaciente.
            $and2.$condicionFecha;

            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
            $conectar->close();
            $conectar = null;
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
            return $resultado=$sql->fetchAll();
            $conectar->close();
            $conectar = null;
        }

    }
?>