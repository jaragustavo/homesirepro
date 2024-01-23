<?php
    class Mensaje extends Conectar{

        /* TODO:Trae los mensajes nuevos que tiene el usuario en la sección de Mensajes del header */
        public function get_mensajes_x_usu($usu_id){
            $conectar= parent::conexion();
            $sql=" select mensajes.id as mensaje_id, mensaje, usuario_envio_id as remitente_id,
            usuarios.nombre || ' ' || usuarios.apellido AS nombre_remitente,
            ind_estado, mensajes.fecha_crea as fecha,
            COUNT(*) OVER () AS cant_mensajes_nuevos
            from mensajes
            join usuarios on usuarios.id = mensajes.usuario_envio_id
            where usuario_destino_id = $usu_id
            AND mensajes.activo = true
            AND ind_estado = 'No leído';";
            // error_log("$$$$$$$$ ".$sql);
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Trae el último mensaje (recibido o enviado) de cada chat que tiene el usuario */
        public function get_chats_x_usuario($usu_id){
                $conectar= parent::conexion();
                $sql="SELECT DISTINCT ON (chat_id)
                    mensaje_id, mensaje, chat_id,
                    nombre_chat, ind_estado, fecha,
                    hora, (SELECT COUNT(*) FROM mensajes where usuario_envio_id = chat_id and ind_estado = 'No leído') AS cant_mensajes_nuevos_x_chat
                FROM(
                SELECT 
                            mensajes.id AS mensaje_id,
                            mensaje,
                            usuario_envio_id AS chat_id,
                            usuarios.nombre || ' ' || usuarios.apellido AS nombre_chat,
                            ind_estado,
                            mensajes.fecha_crea AS fecha,
                            TO_CHAR(mensajes.fecha_crea, 'HH24:MI') AS hora
                        FROM mensajes
                        JOIN usuarios ON usuarios.id = mensajes.usuario_envio_id
                        WHERE usuario_destino_id = 2
                            AND mensajes.activo = true
                UNION
                SELECT 
                        mensajes.id AS mensaje_id,
                        mensaje,
                        usuario_destino_id AS chat_id,
                        (select nombre || ' ' || apellido from usuarios where id = usuario_destino_id),
                        ind_estado,
                        mensajes.fecha_crea AS fecha,
                        TO_CHAR(mensajes.fecha_crea, 'HH24:MI') AS hora
                    FROM mensajes
                    JOIN usuarios ON usuarios.id = mensajes.usuario_destino_id
                    WHERE usuario_envio_id = 2
                        AND mensajes.activo = true
                    ORDER BY chat_id,fecha DESC
                );";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Trae toda la conversación que el usuario logueado tiene con otros */
        public function get_conversacion_x_usuario($chat_id, $usuario_id){
            $conectar= parent::conexion();
            $sql="SELECT 
                    mensajes.id AS mensaje_id,
                    mensaje,
                    usuario_envio_id AS remitente_id,
                    usuarios.nombre || ' ' || usuarios.apellido AS nombre_remitente,
                    ind_estado,
                    mensajes.fecha_crea AS fecha,
                    TO_CHAR(mensajes.fecha_crea, 'HH24:MI') AS hora,
                    (select ci from usuarios where id =$usuario_id) as cedula_usuario, 
                    (select ci from usuarios where id =$chat_id) as cedula_chat,
                    (select nombre || ' ' || apellido from usuarios where id =$chat_id) as nombre_destinatario
                FROM mensajes
                JOIN usuarios ON usuarios.id = mensajes.usuario_envio_id
                WHERE (usuario_destino_id = $chat_id or usuario_envio_id = $chat_id)
                AND (usuario_destino_id = $usuario_id or usuario_envio_id = $usuario_id)
                AND mensajes.activo = true
                ORDER BY fecha ASC;";
                // error_log("%%%%%%%%  ".$sql);
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Actualizar estado de la notificacion luego de ser mostrado */
        public function update_notificacion_estado($not_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_notificacion SET est=1 WHERE not_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Actualizar notificacion luego de ser leido */
        public function update_notificacion_estado_read($not_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_notificacion SET est=0 WHERE not_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $not_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

    }
?>