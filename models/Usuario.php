<?php

    class Usuario extends Conectar{
       
        /* TODO: Registro de datos */
        public function insert_usuario_mtic($datos){
         
            try {
                $db = parent::Conexion();
                $respuesta = $db;
                $db->beginTransaction();
                $sql = "INSERT INTO public.usuarios(
                    ci, email, activo, user_crea,
                    fecha_crea, user_mod, fecha_mod,suc_id, 
                    nombre, apellido, telefono, area_id)
                    VALUES ( " . $datos['su'] . "," . $datos['email'] . ",  true ," . $datos['user_crea'] . ",
                     " . $datos['fecha_crea'] . "," . $datos['user_crea'] . ", " . $datos['fecha_crea'] . ",1,
                      " . $datos['nombres'] . "," . $datos['apellidos'] . ", " . $datos['telefonoMovil'] . ",1)
                     RETURNING id"; // Utiliza RETURNING para obtener el usuario_id después de la inserción
                    $query = $conectar->prepare($sql);
                    $query->execute();
                    
                    // Obtener el usuario_id devuelto por la consulta
                    $usuario_id = $query->fetchColumn();
                    $ci =  $datos['su'];
                    
                    // Insertar el rol del usuario en la tabla roles_usuarios
                    $sql2 = "INSERT INTO public.roles_usuarios (
                        usuario_id, rol_id, activo, user_crea, fecha_crea, user_mod, fecha_mod
                    ) VALUES (
                        $usuario_id, 3, true, '".$ci."', NOW(), '".$ci."', NOW()
                    )";

                    $query2 = $conectar->prepare($sql2);
                    $query2->execute();

            } catch (Exception $e) {
                $db->rollBack();
    
                $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
                error_log($men . ' ' . $sql);
                echo $men . ' ' . $sql;
    
                return "error";
    
            }
        
            $db->commit();
            $db = null;
            return $usuario_id;
    
          
        }

               /* TODO:Acceso al Sistema */
        public function login(){
            $conectar=parent::Conexion();
            if (isset($_POST["enviar"])){
                /* TODO: Recepcion de Parametros desde la Vista Login */
                $ci = $_POST["ci"];
                $pass =  $_POST["password"];
               
                if (empty($ci) and empty($pass)){
                    header("Location:".Conectar::ruta()."index.php?m=2");
                    exit();
                }else{
                    $sql="select * from usuarios where ci = '".$ci."' and password= '".$pass."'";

                    // error_log('$$$$$$$$$$$$$$ '.$sql);
                    $query=$conectar->prepare($sql);
                    $query->execute();
                    $resultado = $query->fetch();
                    if (is_array($resultado) and count($resultado)>0){
                        /* TODO:Generar variables de Session del Usuario */
                        $_SESSION["usuario_id"]=$resultado["id"];
                        $_SESSION["nombre"]=$resultado["nombre"];
                        $_SESSION["apellido"]=$resultado["apellido"];
                        $_SESSION["email"]=$resultado["email"];
                        $_SESSION["suc_id"]=$resultado["suc_id"];
                        $_SESSION["cedula"]=$resultado["ci"];
                        $_SESSION["telefono"]=$resultado["telefono"];
                        $_SESSION["area_id"]=$resultado["area_id"];

                        $roles_usuario = Usuario::get_roles_x_usuario($resultado["id"]);
                        foreach ($roles_usuario as $rol_usuario){
                            if($rol_usuario["rol_nom"] == "PROFESIONAL"){
                                $_SESSION["inicio"]="index.php";
                                header("Location:".Conectar::ruta()."view/home/");
                            }
                            elseif($rol_usuario["rol_nom"] == "OPERATIVO"){
                                $_SESSION["inicio"]="indexOperativo.php";
                                header("Location:".Conectar::ruta()."view/home/indexOperativo.php");
                            }
                            elseif($rol_usuario["rol_nom"] == "GERENTE"){
                                $_SESSION["inicio"]="indexGerencia.php";
                                header("Location:".Conectar::ruta()."view/home/indexGerencia.php");
                            }
                        }
                    }else{
                        // $_SESSION["m"] = 1;
                        header("Location:".Conectar::ruta()."index.php?m=1");
                        exit();
                    }
                }
            }else{
                exit();
            }
        }

        // Carga los permisos que tiene el usuario según sus roles
        public static function get_permisos_x_roles($usuario_id){
            $conectar=parent::Conexion();
            $sql="SELECT roles_permisos.permiso_id, permisos.nombre_permiso
            FROM roles_permisos
            JOIN roles_usuarios on roles_usuarios.rol_id = roles_permisos.rol_id
            JOIN permisos on permisos.id = roles_permisos.permiso_id
            WHERE roles_usuarios.usuario_id = $usuario_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // Carga los roles que tiene el usuario según sus roles
        public static function get_roles_x_usuario($usuario_id){
            $conectar=parent::Conexion();
            $sql="select rol_nom 
            from roles_usuarios
            join roles on roles.id = roles_usuarios.rol_id
            WHERE roles_usuarios.usuario_id = $usuario_id;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Subit imagen de usuario */
        public function upload_image(){
            if (isset($_FILES["usu_img"])){
                $extension = explode('.', $_FILES['usu_img']['name']);
                $new_name = rand() . '.' . $extension[1];
                $destination = '../assets/usuario/' . $new_name;
                move_uploaded_file($_FILES['usu_img']['tmp_name'], $destination);
                return $new_name;
            }
        }

        /* TODO: Total de Tickets por categoria segun usuario */
        public function get_usuario_grafico($usuario_id){
            $conectar= parent::conexion();
            // parent::set_names();
            $sql="SELECT tipos_documentos.documento as nom,COUNT(*) AS total
                FROM   datos_personales  JOIN  
                    tipos_documentos ON datos_personales.tipo_doc_id = tipos_documentos.id  
                WHERE    
                datos_personales.activo = true
                and datos_personales.usuario_id = $usuario_id
                GROUP BY 
                tipos_documentos.documento 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Listar documentos pertenecientes a Currículum Virtual */
        public function get_cantidades_tramites($usu_id){
            $conectar=parent::Conexion();
            $sql="select 
            count(*) as cantidad_tramites from tramites_gestionados
            where usuario_id = $usu_id
            AND activo = true;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_cantidades_reposos($cedula){
            $conectar=parent::ConexionSirepro();
            $sql="select 
            count(*) as cant_reposos from reposos
            where ciprof = '$cedula'";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_total_reposos_visados(){
            $conectar=parent::ConexionSirepro();
            $sql="select 
            count(*) as cant_reposos from reposos";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function get_usuarios($usuario_id){
            $conectar=parent::Conexion();
            $sql="SELECT 
            id, nombre || ' ' || apellido AS usuario, ci 
            from usuarios WHERE id NOT IN ($usuario_id)";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function get_datos_personales($usuario_id){
            $conectar= parent::Conexion();
            $sql="SELECT ci, 
            email,
            nombre, apellido, 
            telefono, ciudad_id, 
            direccion, fecha_nacimiento
                FROM usuarios WHERE id = $usuario_id;";
            $query=$conectar->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>