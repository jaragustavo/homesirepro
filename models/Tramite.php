<?php
    class Tramite extends Conectar{
        /* TODO: Listar trámites según su tipo*/
        public function get_tramites_x_tipo_id($tipo){
            $conectar=parent::Conexion();
            $sql="select id as tramite_id, nombre as tramite, url from tramites where tipo_tramite_id = 1 and activo =true;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar estados de trámites */
        public function get_estados_tramites(){
            $conectar=parent::Conexion();
            $sql="select id as estado_tramite_id, nombre as estado_tramite from estados_tramites where activo = true;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar documentos requeridos según el trámite a gestionar */
        static public function get_docsrequeridos_x_tramite($tramite){
            $conectar=parent::Conexion();
            $sql="SELECT tipos_documentos.documento AS tipo_documento, tramites.nombre as tramite_nombre,
                tipos_documentos.id AS tipo_documento_id
                FROM tramites_docs_requeridos
                JOIN tipos_documentos ON tipos_documentos.id = tramites_docs_requeridos.tipo_documento_id
                JOIN tramites on tramites.id = tramites_docs_requeridos.tramite_id
                WHERE tramite_id = $tramite
                AND tramites_docs_requeridos.activo = true;";

            // error.log($sql);
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_tramite_code($url){
            $conectar=parent::Conexion();
            $sql="select id as tramite_id from tramites where url='$url' and activo = true;";
            // error_log($sql);
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function get_tramite_name($tramite_id){
            $conectar=parent::Conexion();
            $sql="select nombre as tramite_nombre from tramites where id='$tramite_id' and activo = true;";
            // error_log($sql);
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar estados civiles */
        public function get_estados_civiles(){
            $conectar=parent::Conexion();
            $sql="select id as estado_civil_id, nombre as estado_civil from estados_civiles where activo = true;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar paises */
        public function get_paises(){
            $conectar=parent::Conexion();
            $sql="select id as pais_id, nombre as pais from paises where activo = true;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar departamentos, provincias o estados según el país seleccionado */
        public function get_departamentos($pais){
            $condicionPais = "";
            if($pais!="Paraguay"){
                $condicionPais = "pais_id =$pais";
            }
            else{
                $condicionPais = "paises.nombre = '$pais'";
            }
            $conectar=parent::Conexion();
            $sql="select departamentos.id as departamento_id, departamentos.nombre as departamento 
            from departamentos 
            join paises on paises.id = departamentos.pais_id
            where $condicionPais
            and departamentos.activo = true;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar ciudades según departamento seleccionado */
        public function get_ciudades($departamento){
            $conectar=parent::Conexion();
            $sql="select id as ciudad_id, nombre as ciudad from ciudades where departamento_id =$departamento;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_datos_directorio($tipo_doc_id, $tramite_id){
            $conectar=parent::Conexion();
            $sql="SELECT tipos_documentos.nombre_corto AS doc_nombre_corto, tramites.nombre_corto as tramite_nombre
            FROM tramites_docs_requeridos
            JOIN tipos_documentos ON tipos_documentos.id = tramites_docs_requeridos.tipo_documento_id
            JOIN tramites on tramites.id = tramites_docs_requeridos.tramite_id
            WHERE tramites_docs_requeridos.tipo_documento_id = $tipo_doc_id
            AND tramites_docs_requeridos.tramite_id = $tramite_id
            AND tramites_docs_requeridos.activo = true;";
            // error_log($sql);
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

    /*=============================================
	CREAR TRÁMITE
	=============================================*/

	static public function insertar_tramites($datos){

	
		try {
			
			$db=parent::Conexion();

			$respuesta = $db;
			$db->beginTransaction();
		
			$sql="INSERT INTO tramites_gestionados (
								nombre, usuario_id, estado_tramite_id, 
                                tramite_id, fecha_crea, 
                                fecha_mod, user_crea, user_mod, 
                                activo)

				VALUES (
					'".$datos['nombre']."',".$datos['usuario_id'].",".$datos['estado_tramite_id'].",
					".$datos['tramite_id'].",'".$datos['fecha_crea']."'::timestamp,
                    '".$datos['fecha_crea']."'::timestamp,'".$datos['login']."','".$datos['login']."',
                    ".$datos['activo'].");";
			
					$stmt = $db->prepare($sql);
						
					$stmt->execute();

					/*******************************
					 * OBTENER DOCUMENTO PAGO ID
					 **********************************/
					$sql="select currval( 'tramites_gestionados_id_seq' )::BIGINT;";
					
					$stmt = $db->prepare($sql);
						
					$stmt->execute();
					
					$data = $stmt -> fetch();

					$tramite_id = $data['0'];

					$item=0;
                    if(is_array($datos['arrayFiles'])){
                        while ( $item < count($datos['arrayFiles'] ) )
                        {   
                        
                            $sql="INSERT INTO docs_tramites_gestionados (
                                    observacion, documento, 
                                    tramite_gestionado_id, 
                                    estado_docs_tramite_id, tipo_documento_id, 
                                    fecha_crea, fecha_mod, 
                                    user_crea, user_mod, activo)
                            VALUES (
                                ".$tramite_id.",'".$datos['observacion'][$item]."','".$datos['documento'][$item]."',
                                ".$datos['tramite_gestionado_id'][$item].
                                ",".$datos['estado_docs_tramite_id'][$item].",".$datos['tipo_documento_id'][$item].",
                                '".$datos['fecha_crea'][$item]."'::timestamp,'".$datos['fecha_mod'][$item]."'::timestamp,
                                )";

                            $stmt = $db->prepare($sql);
                    
                            $stmt->execute();
                            $item++;		

                        }
					}
	
		} catch(Exception $e) {
		
				$db->rollBack();

				$men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
				
				echo $men.' '.$sql;

				return "error";
			
		}
		
		if($respuesta === $db){
	
				$db->commit();

				echo 'ok';
		
		}

	}
    }
?>