<?php
class Certificacion extends Conectar
{
    /*  Listar estados de trámites */
    public function get_estados_tramites()
    {
        $conectar = parent::Conexion();
        $sql = "select id as estado_tramite_id, nombre as estado_tramite from estados_tramites where activo = true;";
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: Listar documentos requeridos según el trámite a gestionar */
    static public function get_docsrequeridos_x_tramite($tramite)
    {
        $conectar = parent::Conexion();
        $sql = "SELECT tipos_documentos.documento AS tipo_documento, tramites.nombre as tramite_nombre,
                tipos_documentos.id AS tipo_documento_id
                FROM tramites_docs_requeridos
                JOIN tipos_documentos ON tipos_documentos.id = tramites_docs_requeridos.tipo_documento_id
                JOIN tramites on tramites.id = tramites_docs_requeridos.tramite_id
                WHERE tramite_id = $tramite
                AND tramites_docs_requeridos.activo = true;";

        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_datos_directorio($tipo_doc_id, $tramite_id, $db)
    {
        if ($db == "archivosDisco") {
            $db = parent::Conexion();
        }

        $sql = "SELECT tipos_documentos.nombre_corto AS tipo_doc_nombre_corto, 
            tramites.nombre_corto as tramite_nombre_corto
            FROM tramites_docs_requeridos
            JOIN tipos_documentos ON tipos_documentos.id = tramites_docs_requeridos.tipo_documento_id
            JOIN tramites on tramites.id = tramites_docs_requeridos.tramite_id
            WHERE tramites_docs_requeridos.tipo_documento_id = $tipo_doc_id
            AND tramites_docs_requeridos.tramite_id = $tramite_id
            AND tramites_docs_requeridos.activo = true;";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /*=============================================
    EXTRAER NOMBRE ARCHIVO
    =============================================*/
    public function buscarNombreArchivo($idTypeFile, $tramite_id, $cedula, $db)
    {
        $datosPath = $this->get_datos_directorio($idTypeFile, $tramite_id, $db);

        foreach ($datosPath as $row) {
            $filePath = '../docs/documents/' . $cedula . '/certificaciones' . '/' . $row["tramite_nombre_corto"] . '/' . $row["tipo_doc_nombre_corto"] . '/';
        }
        $fileName = "";
        foreach (glob($filePath . '/*.*') as $file) {
            $fileName = basename($file);
        }
        $db = null;

        return $filePath . $fileName;
    }

    /*=============================================
    CREAR TRÁMITE
    =============================================*/
    public function insertar_tramites($datos)
    {
        try {
            $db = parent::Conexion();
            $respuesta = $db;
            $db->beginTransaction();

            $sql = "INSERT INTO tramites_gestionados (
                    usuario_id, estado_tramite_id, 
                    tramite_id, fecha_crea, 
                    fecha_mod, user_crea, user_mod, 
                    activo, forma_solicitud, nivel)
                VALUES (
                    " . $datos['usuario_id'] . ", 18,
                    " . $datos['tramite_id'] . ",'" . $datos['fecha_crea'] . "'::timestamp,
                    '" . $datos['fecha_crea'] . "'::timestamp,'" . $datos['usuario_id'] . "','" . $datos['usuario_id'] . "',
                    " . $datos['activo'] . ",'" . $datos['forma_solicitud'] . "', '" . $datos['nivel'] . "');";

            $db->exec($sql);

            /*******************************
             * OBTENER TRÁMITE GESTIONADO ID
             **********************************/
            $sql = "select currval( 'tramites_gestionados_id_seq' )::BIGINT;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch();
            $tramite_gestionado_id = $data['0'];

            // Se insertan los formularios en sus respectivas tablas
            //FORMULARIO DATOS PERSONALES
            $sql = "INSERT INTO public.formularios_datos_personales(
                nombre, apellido, 
                cedula_identidad, estado_civil_id, 
                fecha_nacimiento, pais_nacimiento_id, 
                departamento_nacimiento_id, ciudad_nacimiento_id, 
                tramite_gestionado_id, fecha_crea, 
                fecha_mod, user_crea, 
                user_mod, activo)
                VALUES ('" . $datos['nombre'] . "', '" . $datos['apellido'] . "', 
                        '" . $datos['cedula_identidad'] . "', " . $datos['estado_civil'] . ", 
                        '" . $datos['fecha_nacimiento'] . "'::timestamp, " . $datos['pais_nacimiento'] . ", 
                        " . $datos['departamento_nacimiento'] . ", " . $datos['ciudad_nacimiento'] . ", 
                        $tramite_gestionado_id, '" . $datos['fecha_crea'] . "', 
                        '" . $datos['fecha_crea'] . "', " . $datos['usuario_id'] . ", 
                        " . $datos['usuario_id'] . ", " . $datos['activo'] . ");";
            $db->exec($sql);
            //FORMULARIO RESIDENCIA PERMANENTE
            $sql = "INSERT INTO public.formularios_residencias_permanentes(
                direccion, departamento_residencia_id, 
                ciudad_residencia_id, barrio_residencia_id, 
                tramite_gestionado_id, telefono, 
                celular_principal, celular_secundario, 
                email, fecha_crea, 
                fecha_mod, user_crea, 
                user_mod, activo)
                VALUES ('" . $datos['direccion_residencia'] . "', " . $datos['departamento_residencia'] . ", 
                        " . $datos['ciudad_residencia'] . ", " . $datos['barrio_residencia'] . ", 
                        $tramite_gestionado_id, '" . $datos['telefono_residencia'] . "', 
                        '" . $datos['celular_principal'] . "', '" . $datos['celular_secundario'] . "', 
                        '" . $datos['email'] . "', '" . $datos['fecha_crea'] . "', 
                        '" . $datos['fecha_crea'] . "', " . $datos['usuario_id'] . ", 
                        " . $datos['usuario_id'] . ", " . $datos['activo'] . ");";

            $db->exec($sql);
            //FORMULARIO DATOS LABORALES PUBLICO
            $sql = "INSERT INTO public.formularios_datos_laborales(
                servicio, direccion, 
                departamento_trabajo_id, 
                ciudad_trabajo_id, 
                tramite_gestionado_id, telefono_trabajo, 
                email_trabajo, publico, 
                fecha_crea, fecha_mod, 
                user_crea, user_mod, activo)
                VALUES ('" . $datos['servicio_publico'] . "', '" . $datos['direccion_publico'] . "', 
                        " . $datos['departamento_publico'] . ", 
                        " . $datos['ciudad_publico'] . ", 
                        $tramite_gestionado_id, " . $datos['telefono_publico'] . ", 
                        '" . $datos['email_publico'] . "', true, 
                        '" . $datos['fecha_crea'] . "', '" . $datos['fecha_crea'] . "', 
                        " . $datos['usuario_id'] . ", " . $datos['usuario_id'] . ", " . $datos['activo'] . ");";

            $db->exec($sql);
            //FORMULARIO DATOS LABORALES PRIVADO
            $sql = "INSERT INTO public.formularios_datos_laborales(
                servicio, direccion, 
                departamento_trabajo_id, 
                ciudad_trabajo_id, 
                tramite_gestionado_id, telefono_trabajo, 
                email_trabajo, publico, 
                fecha_crea, fecha_mod, 
                user_crea, user_mod, activo)
                VALUES ('" . $datos['servicio_privado'] . "', '" . $datos['direccion_privado'] . "', 
                        " . $datos['departamento_privado'] . ", 
                        " . $datos['ciudad_privado'] . ", 
                        $tramite_gestionado_id, " . $datos['telefono_privado'] . ", 
                        '" . $datos['email_privado'] . "', false, 
                        '" . $datos['fecha_crea'] . "', '" . $datos['fecha_crea'] . "', 
                        " . $datos['usuario_id'] . ", " . $datos['usuario_id'] . ", " . $datos['activo'] . ");";

            $db->exec($sql);

            //FORMULARIO TITULO DE SALUD OBTENIDO
            $sql = "INSERT INTO public.formularios_titulos_obtenidos(
                titulo_obtenido_id, institucion_titulo_id, 
                pais_titulo_id, tramite_gestionado_id, 
                fecha_crea, fecha_mod,
                user_crea, user_mod, activo)
                VALUES (" . $datos['titulo_obtenido'] . ", " . $datos['institucion_titulo'] . ", 
                        " . $datos['pais_titulo'] . ", $tramite_gestionado_id, 
                        '" . $datos['fecha_crea'] . "', '" . $datos['fecha_crea'] . "', 
                        " . $datos['usuario_id'] . ", " . $datos['usuario_id'] . ", " . $datos['activo'] . ");";
            $db->exec($sql);

            //FORMULARIO POSTGRADO
            $sql = "INSERT INTO public.formularios_postgrados(
                titulo_obtenido_id, institucion_titulo_id, 
                pais_titulo_id, tramite_gestionado_id, 
                fecha_crea, fecha_mod,
                user_crea, user_mod, activo)
                VALUES (" . $datos['titulo_postgrado'] . ", " . $datos['institucion_postgrado'] . ", 
                        " . $datos['pais_postgrado'] . ", $tramite_gestionado_id, 
                        '" . $datos['fecha_crea'] . "', '" . $datos['fecha_crea'] . "', 
                        " . $datos['usuario_id'] . ", " . $datos['usuario_id'] . ", " . $datos['activo'] . ");";
            $db->exec($sql);


            $item = 0;

            $tiposDocumentos = json_decode($datos['tiposDocumentos']);

            if (is_array($tiposDocumentos)) {

                $tramite_id = $datos['tramite_id'];
                $item = 0;
                $nombre_archivo = array();
                while ($item < count($tiposDocumentos)) {
                    $idTypeFile = $tiposDocumentos[$item];
                    $cedula = $datos['cedula_user'];
                    $nombre_archivo = Certificacion::buscarNombreArchivo($idTypeFile, $tramite_id, $cedula, $db);

                    $sql = "INSERT INTO tramites_gestionados_docs (
                            tramite_gestionado_id, documento, 
                            estado_docs_tramite_id, tipo_documento_id, 
                            fecha_crea, fecha_mod, 
                            user_crea, user_mod, activo)
                        VALUES (
                            " . $tramite_gestionado_id . ",'" . $nombre_archivo . "',
                            " . $datos['estado_docs_tramite_id'] . "," . $idTypeFile . ",
                            '" . $datos['fecha_crea'] . "'::timestamp,'" . $datos['fecha_crea'] . "'::timestamp,
                            " . $datos['usuario_id'] . "," . $datos['usuario_id'] . "," . $datos['activo'] . ");";
                    $item++;
                    $db->exec($sql);

                }
            }
            // Se inserta la notificación de ser ingresada la inscripción
            $sql = "INSERT INTO public.notificaciones(
                usuario_notificado_id, mensaje_completo,
                mensaje_notificacion, leido, 
                fecha_crea, fecha_mod, user_crea, 
                user_mod, activo)
                VALUES (" . $datos['usuario_id'] . ", 'Revise su correo para mas detalle', 
                        'La inscripción fue realizada con éxito.', false, 
                        '" . $datos['fecha_crea'] . "'::timestamp, 
                        '" . $datos['fecha_crea'] . "'::timestamp, 5, 
                        5, true);"; //El usuario con id 5 es el de SIREPRO
            // error_log($sql);
            $query = $db->prepare($sql);
            $query->execute();
        } catch (Exception $e) {
            $db->rollBack();

            $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
            error_log($men . ' ' . $sql);

            return "error";

        }
        if ($respuesta === $db) {
            $db->commit();
            $db = null;
            return "ok";

        }

    }
    /*=============================================
    LISTAR TRÁMITES 
    =============================================*/
    public function get_tramites_gestionados_x_usuario($usuario_id)
    {
        $conectar = parent::Conexion();
        $sql = "SELECT DISTINCT ON (tg.id) 
        tg.id AS tramite_gestionado_id,
        (select nombre from tramites where tramites.id = tg.tramite_id) AS nombre_tramite,
        u.nombre || ' ' || u.apellido AS usuario_solicitante,
        (SELECT nombre || ' ' || apellido FROM usuarios WHERE id = mt.usuario_asignado_id) AS usuario_asignado,
        tg.fecha_crea AS fecha_solicitud,
        et.nombre AS estado_actual,
        tg.fecha_mod AS ultimo_movimiento,
        tg.tramite_id as tramite_id,
        a.nombre AS area_asignada
        FROM tramites_gestionados tg
        LEFT JOIN movimientos_tramites mt ON tg.id = mt.tramite_gestionado_id AND mt.area_asignada_id = 1 AND mt.activo = true
        JOIN estados_tramites et ON et.id = COALESCE(tg.estado_tramite_id,mt.estado_tramite_id)
        JOIN usuarios u ON u.id = tg.usuario_id
        LEFT JOIN areas a ON a.id = mt.area_asignada_id
        WHERE tg.activo = true 
        AND tg.usuario_id = $usuario_id
        AND tg.tramite_id = 7
        ORDER BY tg.id, COALESCE(mt.fecha_crea, tg.fecha_mod) DESC;";
        $query = $conectar->prepare($sql);
        $query->execute();
        $db = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrar($tramite_gestionado_id, $usuario_id)
    {
        $conectar = parent::Conexion();
        $sql = "SELECT DISTINCT ON (TG.id)
                TG.nivel as nivel,
                FDP.nombre AS nombre, FDP.apellido AS apellido, FDP.cedula_identidad AS documento_identidad,
                FDP.estado_civil_id AS estado_civil, FDP.fecha_nacimiento AS fecha_nacimiento,
                FDP.pais_nacimiento_id AS pais_nacimiento, FDP.departamento_nacimiento_id AS departamento_nacimiento,
                FDP.ciudad_nacimiento_id AS ciudad_nacimiento, 
                FRP.direccion AS direccion_residencia, FRP. departamento_residencia_id AS departamento_residencia,
                FRP.ciudad_residencia_id AS ciudad_residencia, FRP.barrio_residencia_id AS barrio_residencia,
                FRP.telefono AS telefono_residencia, FRP.celular_principal AS celular_principal_residencia,
                FRP.celular_secundario AS celular_secundario_residencia, FRP.email AS email_residencia,
                FDLPub.servicio AS servicio_publico, FDLPub.direccion AS direccion_publico,
                FDLPub.departamento_trabajo_id AS departamento_publico, FDLPub.ciudad_trabajo_id AS ciudad_trabajo,
                FDLPub.telefono_trabajo AS telefono_publico, FDLPub.email_trabajo AS email_publico,
                FDLPriv.servicio AS servicio_privado, FDLPriv.direccion AS direccion_privado,
                FDLPriv.departamento_trabajo_id AS departamento_privado, FDLPriv.ciudad_trabajo_id AS ciudad_privado,
                FDLPriv.telefono_trabajo AS telefono_privado, FDLPriv.email_trabajo AS email_privado,
                FTO.titulo_obtenido_id AS titulo_obtenido, FTO.institucion_titulo_id AS institucion_titulo,
                FTO.pais_titulo_id AS pais_titulo, FP.titulo_obtenido_id AS titulo_postgrado,
                FP.institucion_titulo_id AS institucion_postgrado, FP.pais_titulo_id AS pais_postgrado
              FROM tramites_gestionados AS TG
              LEFT JOIN formularios_datos_personales AS FDP ON FDP.tramite_gestionado_id = TG.id
              LEFT JOIN formularios_residencias_permanentes AS FRP ON FRP.tramite_gestionado_id = TG.id
              LEFT JOIN formularios_datos_laborales AS FDLPub ON FDLPub.tramite_gestionado_id = TG.id
              LEFT JOIN formularios_datos_laborales AS FDLPriv ON FDLPriv.tramite_gestionado_id = TG.id
              LEFT JOIN formularios_titulos_obtenidos AS FTO ON FTO.tramite_gestionado_id = TG.id
              LEFT JOIN formularios_postgrados AS FP ON FP.tramite_gestionado_id = TG.id
              WHERE TG.id = $tramite_gestionado_id;";
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    // Trae los documentos que fueron observados por un fiscalizador 
    // para poder ser modificados por el solicitante
    public static function get_docs_x_tramite_gestionado($tramite_gestionado_id)
    {
        $conectar = parent::Conexion();
        $sql = "SELECT  TGD.id as documento_id,
            TGD.documento as documento,
            TGD.tipo_documento_id as tipo_doc_id,
            tipos_documentos.documento as tipo_doc,
            tramites_gestionados.id as tramite_gestionado_id,
            tramites.nombre AS nombre_tramite, 
            tramites_gestionados.fecha_crea as fecha_solicitud,
            estados_tramites.nombre as estado_actual,
            tramites_gestionados.fecha_mod as ultimo_movimiento,
			(SELECT nombre from estados_docs_tramites where id = TGD.estado_docs_tramite_id) as estado_doc_nombre
            FROM tramites_gestionados_docs as TGD
            JOIN tramites_gestionados ON tramites_gestionados.id = TGD.tramite_gestionado_id
            JOIN estados_tramites on estados_tramites.id = tramites_gestionados.estado_tramite_id
            JOIN tipos_documentos on tipos_documentos.id = TGD.tipo_documento_id
            JOIN tramites on tramites.id = tramites_gestionados.tramite_id
			JOIN estados_docs_tramites on estados_docs_tramites.id = TGD.estado_docs_tramite_id
            WHERE tramites_gestionados.id = $tramite_gestionado_id
            AND tramites_gestionados.activo = true
			AND TGD.estado_docs_tramite_id not in (1);";
        error_log($sql);
        $query = $conectar->prepare($sql);
        $query->execute();
        $conectar = null;
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_observacion_tramite($id_tramite_gestionado)
    {
        $conectar = parent::Conexion();
        $sql = "select observacion from tramites_gestionados where id='$id_tramite_gestionado' and activo = true;";
        $query = $conectar->prepare($sql);
        $query->execute();
        $db = null;

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar_tramites($datos)
    {
        try {
            $db = parent::Conexion();
            $respuesta = $db;
            $db->beginTransaction();

            $sql = "UPDATE public.tramites_gestionados
                SET 
                estado_tramite_id=" . $datos['estado_tramite_id'] . ", 
                fecha_mod='" . $datos['fecha_crea'] . "'::timestamp, user_mod=" . $datos['usuario_id'] . "
                WHERE id = " . $datos['tramite_gestionado_id'] . ";";

            $db->exec($sql);

            // Se ingresa el primer movimiento del trámite gestionado si es que se envió la solicitud
            if ($datos["estado_tramite_id"] == 6 || $datos["estado_tramite_id"] == 9) {

                $sql = "INSERT INTO public.movimientos_tramites(
                        tramite_gestionado_id, area_asignada_id, 
                        fecha_crea, fecha_mod, 
                        user_crea, user_mod, estado_tramite_id)
                        VALUES (" . $datos['tramite_gestionado_id'] . ", 1, 
                        '" . $datos['fecha_crea'] . "'::timestamp,'" . $datos['fecha_crea'] . "'::timestamp,"
                    . $datos['usuario_id'] . "," . $datos['usuario_id'] . ", " . $datos["estado_tramite_id"] . ");";

                $db->exec($sql);
            }

            $item = 0;
            $tiposDocumentos = json_decode($datos['tiposDocumentos']);

            if (is_array($tiposDocumentos)) {

                $item = 0;
                $nombre_archivo = array();
                while ($item < count($tiposDocumentos)) {
                    $tramite_id = $datos['tramite_id'];
                    $idTypeFile = $tiposDocumentos[$item];
                    $cedula = $datos['cedula_user'];
                    $nombre_archivo = Certificacion::buscarNombreArchivo($idTypeFile, $tramite_id, $cedula, $db);

                    $sql = "SELECT id FROM tramites_gestionados_docs 
                        where tramite_gestionado_id = " . $datos['tramite_gestionado_id'] . "
                        AND tipo_documento_id = $idTypeFile;";
                    $query = $db->prepare($sql);
                    $query->execute();
                    $doc_existente = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($doc_existente) > 0) {
                        $sql = "UPDATE public.tramites_gestionados_docs
                            SET documento='$nombre_archivo', fecha_mod=current_timestamp, 
                            user_mod=" . $datos['usuario_id'] . "
                            WHERE id = " . $doc_existente[0]["id"] . ";";
                    } else {
                        $sql = "INSERT INTO tramites_gestionados_docs (
                                tramite_gestionado_id, documento, 
                                estado_docs_tramite_id, tipo_documento_id, 
                                fecha_crea, fecha_mod, 
                                user_crea, user_mod, activo)
                            VALUES (
                                " . $datos['tramite_gestionado_id'] . ",'" . $nombre_archivo . "',
                                " . $datos['estado_docs_tramite_id'] . "," . $idTypeFile . ",
                                '" . $datos['fecha_crea'] . "'::timestamp,'" . $datos['fecha_crea'] . "'::timestamp,
                                " . $datos['usuario_id'] . "," . $datos['usuario_id'] . "," . $datos['activo'] . ");";
                    }

                    $item++;
                    $db->exec($sql);

                }
            }
        } catch (Exception $e) {
            $db->rollBack();

            $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
            error_log($men . ' ' . $sql);
            echo $men . ' ' . $sql;


        }
        if ($respuesta === $db) {
            $db->commit();
            echo 'ok';
            $db = null;
            return $db;

        }
    }

    public function delete_tramite_gestionado($id_tramite_gestionado, $usuario_id, $fecha_hora)
    {
        try {
            $db = parent::Conexion();
            $respuesta = $db;
            $db->beginTransaction();

            $sql = "UPDATE public.tramites_gestionados
                SET activo = false, estado_tramite_id = 17
                WHERE id = $id_tramite_gestionado;";

            $db->exec($sql);

            // Se inserta un movimiento para registrar la anulación del trámite por parte del solicitante
            $sql = "INSERT INTO public.movimientos_tramites(
                    tramite_gestionado_id, area_asignada_id, 
                    fecha_crea, fecha_mod, 
                    user_crea, user_mod, estado_tramite_id)
                    VALUES ($id_tramite_gestionado, 8, 
                    '$fecha_hora'::timestamp,'$fecha_hora'::timestamp,
                    $usuario_id,$usuario_id, 17);";

            $db->exec($sql);

            $sql = "SELECT id FROM tramites_gestionados_docs 
                    where tramite_gestionado_id = $id_tramite_gestionado ";
            $query = $db->prepare($sql);
            $query->execute();
            $docs_existentes = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($docs_existentes as $doc_existente) {
                $sql = "UPDATE public.tramites_gestionados_docs
                    SET estado_docs_tramite_id=5, fecha_mod=$fecha_hora, 
                    user_mod=$usuario_id, activo = false
                    WHERE id = " . $doc_existente["id"] . ";";

                $db->exec($sql);

            }

        } catch (Exception $e) {
            $db->rollBack();

            $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
            error_log($men . ' ' . $sql);
            echo $men . ' ' . $sql;

            return "error";

        }
        if ($respuesta === $db) {
            $db->commit();
            echo 'ok';
            $db = null;
            return "ok";

        }
    }
}
?>