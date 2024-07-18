<?php
class Movimiento extends Conectar
{
    /* TODO: Listar trámites según el área del usuario*/
    public static function get_tramites($area_id, $table, $usuario_id)
    {
        $conectar = parent::Conexion();
        $condicion_tabla = "";
        if ($table == "usuario") {
            $condicion_tabla = " AND movimientos_tramites.usuario_asignado_id = $usuario_id";
        }
        $sql = "SELECT DISTINCT ON (tramite_gestionado_id) 
                tramites_gestionados.id AS tramite_gestionado_id,
                usuarios.nombre || ' ' || usuarios.apellido AS usuario_solicitante,
                (select nombre || ' ' || apellido from usuarios where id = movimientos_tramites.usuario_asignado_id) AS usuario_asignado,
                tramites_gestionados.fecha_crea as fecha_solicitud,
                estados_tramites.nombre AS estado_actual,
                tramites_gestionados.fecha_mod AS ultimo_movimiento,
                tramites.nombre as tramite_nombre,
                areas.nombre as area_asignada,
                ROUND(EXTRACT(EPOCH FROM (NOW() AT TIME ZONE 'America/Asuncion' - tramites_gestionados.fecha_crea)) / 3600) AS horas_transcurridas
                FROM movimientos_tramites
                JOIN tramites_gestionados on tramites_gestionados.id = movimientos_tramites.tramite_gestionado_id
                JOIN tramites on tramites.id = tramites_gestionados.tramite_id
                JOIN estados_tramites on estados_tramites.id = COALESCE(tramites_gestionados.estado_tramite_id,movimientos_tramites.estado_tramite_id)
                JOIN usuarios ON usuarios.id = tramites_gestionados.usuario_id
                JOIN areas on areas.id = movimientos_tramites.area_asignada_id
                WHERE movimientos_tramites.area_asignada_id = $area_id
                AND movimientos_tramites.activo = true
                AND tramites_gestionados.activo = true $condicion_tabla
                ORDER BY tramite_gestionado_id, movimientos_tramites.fecha_mod DESC;";
        $query = $conectar->prepare($sql);
        $query->execute();
        $db = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar el usuario asignado de cada trámite cuando se asigna a sí mismo
    public function update_usuario_asignado_tramite($tramites_autoasignados, $fecha_hora, $usuario_id, $area_id)
    {

        try {
            $db = parent::Conexion();
            $respuesta = $db;
            $db->beginTransaction();
            foreach ($tramites_autoasignados as $tramite_autoasignado) {
                $sql = "SELECT estado_tramite_id from tramites_gestionados where id = $tramite_autoasignado";
                $query = $db->prepare($sql);
                $query->execute();
                $data = $query->fetch();
                $estado_tramite_id = $data['0'];
                if ($estado_tramite_id != 9) {
                    $estado_tramite_id = 3;
                }
                $sql = "UPDATE public.tramites_gestionados
                        SET estado_tramite_id=$estado_tramite_id, fecha_mod='$fecha_hora'::timestamp, 
                        user_mod=$usuario_id
                        WHERE id = $tramite_autoasignado;";
                $query = $db->prepare($sql);
                $query->execute();

                $sql = "INSERT INTO public.movimientos_tramites(
                            tramite_gestionado_id, area_asignada_id, 
                            usuario_asignado_id, fecha_crea, 
                            fecha_mod, user_crea, user_mod, 
                            activo, estado_tramite_id)
                            VALUES ($tramite_autoasignado, $area_id, 
                            $usuario_id, '$fecha_hora'::timestamp, 
                            '$fecha_hora'::timestamp, $usuario_id, $usuario_id, true, 3);";
                $query = $db->prepare($sql);
                $query->execute();
            }

        } catch (Exception $e) {
            error_log("$$$$$$$$$$$" . $e->getMessage());
            $db->rollBack();

            $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
            error_log($men . ' ' . $sql);

            return "error";

        }
        if ($respuesta === $db) {
            $db->commit();
            return 'ok';
        }
        $db = null;
    }

    // Muestra la pantalla para que el fiscalizador pueda abrir la solicitud
    public static function revisar_solicitud($tramite_gestionado_id)
    {
        $db = parent::Conexion();
        $sql = "SELECT 
                TGD.id as documento_id,
                TGD.documento as documento,
                TGD.tipo_documento_id as tipo_doc_id,
                tipos_documentos.documento as tipo_doc,
                tramites_gestionados.id as tramite_gestionado_id,
                tramites.nombre AS nombre_tramite,
                tramites_gestionados.fecha_mod as fecha_solicitud,
                TO_CHAR(TGD.fecha_mod, 'DD Mon YYYY') AS fecha_formato_doc,
                TO_CHAR(TGD.fecha_mod, 'HH24:MI') AS hora_formato_doc,
                estados_tramites.nombre as estado_actual,
                tramites_gestionados.fecha_mod as ultimo_movimiento,
                TGD.estado_docs_tramite_id as estado_doc_id,
                (SELECT nombre from estados_docs_tramites where id = TGD.estado_docs_tramite_id) as estado_doc_nombre
                FROM tramites_gestionados_docs as TGD
                JOIN tramites_gestionados ON tramites_gestionados.id = TGD.tramite_gestionado_id
                JOIN estados_tramites on estados_tramites.id = tramites_gestionados.estado_tramite_id
                JOIN tipos_documentos on tipos_documentos.id = TGD.tipo_documento_id
                JOIN tramites on tramites.id = tramites_gestionados.tramite_id
                AND tramites_gestionados.id = $tramite_gestionado_id
                AND tramites_gestionados.activo = true;";
        $query = $db->prepare($sql);
        $query->execute();
        $db = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_estados_documentos_id()
    {
        $db = parent::Conexion();
        $sql = "SELECT id as estado_documento_id, nombre as estado_documento FROM estados_docs_tramites;";
        $query = $db->prepare($sql);
        $query->execute();
        $db = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // Actualizar los estados de los documentos de la solicitud, 
    // además del estado del trámite gestionado y se agrega el movimiento generado
    public function update_estados_documentos($estadosDocs, $idTramiteGestionado, $observacion, $fecha_hora, $usuario_id)
    {
        try {
            $db = parent::Conexion();
            $respuesta = $db;
            $db->beginTransaction();
            $sql = "UPDATE public.tramites_gestionados
                SET estado_tramite_id=8, fecha_mod='$fecha_hora'::timestamp, user_mod=$usuario_id, 
                observacion='$observacion'
                WHERE id = $idTramiteGestionado;";
            // error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();

            $sql = "INSERT INTO public.movimientos_tramites(
                    tramite_gestionado_id, area_asignada_id,
                    usuario_asignado_id, fecha_crea, 
                    fecha_mod, user_crea, user_mod, 
                    activo, estado_tramite_id)
                    VALUES ($idTramiteGestionado, 1,
                    $usuario_id, '$fecha_hora'::timestamp, 
                    current_timestamp, $usuario_id, $usuario_id, true, 8);";
            error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();

            foreach ($estadosDocs as $key => $value) {

                $idDoc = str_replace('estado_documento', '', $key);
                $sql = "UPDATE public.tramites_gestionados_docs
                    SET estado_docs_tramite_id=$value, fecha_mod='$fecha_hora'::timestamp, user_mod=$usuario_id
                    WHERE id = $idDoc;";
                $query = $db->prepare($sql);
                $query->execute();
            }
            $resultado = "";
        } catch (Exception $e) {
            $db->rollback();
            $resultado = "error";
            error_log($e->getMessage());
        }
        if ($respuesta === $db) {
            $db->commit();
            $resultado = "ok";
            echo 'ok';
        }
        $db = null;
        return $resultado;
    }

    public function update_tramite_aprobado($estadoDoc, $estadoTramite, $idTramiteGestionado, $fecha_hora, $usuario_id)
    {
        try {
            $db = parent::Conexion();
            $respuesta = $db;
            $db->beginTransaction();
            $sql = "UPDATE public.tramites_gestionados
                SET estado_tramite_id=$estadoTramite, fecha_mod='$fecha_hora'::timestamp, user_mod=$usuario_id
                WHERE id = $idTramiteGestionado;";
            // error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();

            $sql = "INSERT INTO public.movimientos_tramites(
                    tramite_gestionado_id, area_asignada_id, 
                    fecha_crea, 
                    fecha_mod, user_crea, user_mod, 
                    activo, estado_tramite_id)
                    VALUES ($idTramiteGestionado, 3,
                    '$fecha_hora'::timestamp, 
                    '$fecha_hora'::timestamp, $usuario_id, $usuario_id, 
                    true, $estadoTramite);";
            error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();

            $sql = "SELECT id FROM tramites_gestionados_docs
                    WHERE tramite_gestionado_id = $idTramiteGestionado;";
            // error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();
            // Fetch the results into an associative array
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            // Now you can iterate through the results using a foreach loop
            foreach ($results as $row) {
                $sql = "UPDATE public.tramites_gestionados_docs
                    SET estado_docs_tramite_id=$estadoDoc, fecha_mod='$fecha_hora'::timestamp, user_mod=$usuario_id
                    WHERE id = ".$row["id"].";";
                $query = $db->prepare($sql);
                $query->execute();
            }

            // Se busca el usuario al cual pertenece el trámite gestionado, de modo a enviarle una solicitud
            $sql = "SELECT usuario_id FROM tramites_gestionados
                    WHERE id = $idTramiteGestionado LIMIT 1;";
            $query = $db->prepare($sql);
            $query->execute();
            // Fetch the results into an associative array
            $usuario_tramite = $query->fetchAll(PDO::FETCH_ASSOC);
            // Se inserta la notificación de la cita al ser aprobada la solicitud
            $sql = "INSERT INTO public.notificaciones(
                usuario_notificado_id, mensaje_completo,
                mensaje_notificacion, leido, 
                fecha_crea, fecha_mod, user_crea, 
                user_mod, activo)
                VALUES (".$usuario_tramite[0]["usuario_id"].", 'Revise su correo para mas detalle', 
                        'Tiene una cita para el jueves 15/02 a las 11:30. Revise su correo para más detalles.', false, 
                        '$fecha_hora'::timestamp, '$fecha_hora'::timestamp, 5, 
                        5, true);"; //El usuario con id 5 es el de SIREPRO
            // error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();
            $resultado = "";
        } catch (Exception $e) {
            $db->rollback();
            $resultado = "error";
            error_log($e->getMessage());
        }
        if ($respuesta === $db) {
            $db->commit();
            $resultado = "ok";
            echo 'ok';
        }
        $db = null;
        return $resultado;
    }

    public function get_observacion($idTramiteGestionado){
        $db = parent::Conexion();
        $sql = "SELECT observacion FROM tramites_gestionados
            WHERE id = $idTramiteGestionado;";
        $query = $db->prepare($sql);
        $query->execute();
        $db = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>