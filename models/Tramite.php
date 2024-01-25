<?php
    class Tramite extends Conectar{
        /* TODO: Listar trámites según su tipo*/
        public function get_tramites_x_tipo_id($tipo){
            $conectar=parent::Conexion();
            $sql="select id as tramite_id, nombre as tramite from tramites where tipo_tramite_id = 1;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar estados de trámites */
        public function get_estados_tramites(){
            $conectar=parent::Conexion();
            $sql="select id as estado_tramite_id, nombre as estado_tramite from estados_tramites;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar documentos requeridos según el trámite a gestionar */
        public function get_docsrequeridos_x_tramite($tramite){
            $conectar=parent::Conexion();
            $sql="SELECT tipos_documentos.documento AS tipo_documento, tramites.nombre as tramite_nombre
                FROM tramites_docs_requeridos
                JOIN tipos_documentos ON tipos_documentos.id = tramites_docs_requeridos.tipo_documento_id
                JOIN tramites on tramites.id = tramites_docs_requeridos.tramite_id
                WHERE tramite_id = $tramite;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>