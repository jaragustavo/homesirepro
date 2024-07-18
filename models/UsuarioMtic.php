<?php

      
       class UsuarioMtic extends Conectar{
       
        public function insert_usuario_mtic($datos){
         
            try {
                $conectar=parent::Conexion();
                $conectar->beginTransaction();
                $sql = "INSERT INTO public.usuarios(
                    ci, email, activo, user_crea,
                    fecha_crea, user_mod, fecha_mod, 
                    nombre, apellido, telefono)
                    VALUES ( " . $datos['sub'] . ",'" . $datos['email'] . "',  true ," . $datos['user_crea'] . ",
                     '" . $datos['fecha_crea'] . "'," . $datos['user_crea'] . ", '" . $datos['fecha_crea'] . "',
                      '" . $datos['nombres'] . "','" . $datos['apellidos'] . "', '" . $datos['telefonoMovil'] . "')
                     RETURNING id"; // Utiliza RETURNING para obtener el usuario_id después de la inserción
                   
                    $query = $conectar->prepare($sql);
                    $query->execute();
                    
                    // Obtener el usuario_id devuelto por la consulta
                    $usuario_id = $query->fetchColumn();
                    $ci =  trim($datos['sub']);
                    
                    // Insertar el rol del usuario en la tabla roles_usuarios
                    $sql2 = "INSERT INTO public.roles_usuarios (
                        usuario_id, rol_id, activo, user_crea, fecha_crea, user_mod, fecha_mod
                    ) VALUES (
                        $usuario_id, 3, true, '".$ci."', NOW(), '".$ci."', NOW()
                    )";

                    $query2 = $conectar->prepare($sql2);
                    $query2->execute();

            } catch (Exception $e) {
                $conectar->rollBack();
    
                $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
                error_log($men . ' ' . $sql);
                echo $men . ' ' . $sql;
    
                return "error";
    
            }
        
            $conectar->commit();
            $conectar = null;
            return $usuario_id;
    
          
        }

        public function update_usuario_mtic($datos,$usuario_id){
            
            try {
                $conectar=parent::Conexion();
                $conectar->beginTransaction();
                $sql = "UPDATE public.usuarios
                    SET email = '" .  trim($datos['email']) . "', 
                        nombre = '" . trim($datos['nombres']) . "', apellido = '" . trim($datos['apellidos']) . "', telefono = '" . $datos['telefonoMovil'] . "'
                    WHERE  id = $usuario_id "; 
                error_log($sql);
                $query = $conectar->prepare($sql);
                $query->execute();

             
            } catch (Exception $e) {
                $conectar->rollBack();
                $men = str_replace('SQLSTATE[P0001]: Raise exception: 7 ERROR:', '', $e->getMessage());
                error_log($men . ' ' . $sql);
                echo $men . ' ' . $sql;
                return "error";
            }
        
            $conectar->commit();
            $conectar = null;
            return 'ok';
        
        }
        
        public function login_mtic($json_usuario){

            // Decodificar el JSON en un array asociativo
            $decoded_json = json_decode($json_usuario, true);
        
            // Acceder a los datos decodificados
            $datos = $decoded_json['datos'];
            
            // Almacenar cada dato en una variable
            $ci = trim($datos['sub']);
            $nombres = trim($datos['nombres']);
            $apellidos = trim($datos['apellidos']);
            $fechaNacimiento =  date('Y-m-d', $datos['fechaNacimiento']); 
            $iss = $datos['iss'];
            $idCiudad = $datos['idCiudad'];
            $nacionalidad = $datos['nacionalidad'];
            $aud = $datos['aud'];
            $idDepartamento = $datos['idDepartamento'];
            $domicilio = $datos['domicilio'];
            $idBarrio = $datos['idBarrio'];
            $fechaNacimientoString = $datos['fechaNacimientoString'];
            $telefonoMovil = $datos['telefonoMovil'];
            $telefonoMovilFormatoInternacional = $datos['telefonoMovilFormatoInternacional'];
            $idTipo = $datos['idTipo'];
            $exp = $datos['exp'];
            $sexo = $datos['sexo'];
            $telefonoParticular = $datos['telefonoParticular'];
            $email = $datos['email'];

            $conectar=parent::Conexion();
       
            $sql="select * from usuarios where ci = '".$ci."' ";
            $query=$conectar->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            if (!$resultado){
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $fecha_hora = $fecha . ' ' . $hora;
                $datos['fecha_crea'] =  $fecha_hora;
                $datos['user_crea'] =  $ci;
                $usuario_id = UsuarioMtic::insert_usuario_mtic($datos);
           
            } else {

                $usuario_id = $resultado["id"];
                UsuarioMtic::update_usuario_mtic($datos,$usuario_id);

            }

            $roles_usuario = UsuarioMtic::get_roles_x_usuario($usuario_id);

            foreach ($roles_usuario as $rol_usuario){
                if($rol_usuario["rol_nom"] == "PROFESIONAL"){
                    $_SESSION["inicio"]="index.php";
                    $urlDestino = "view/home/";
                }
                elseif($rol_usuario["rol_nom"] == "OPERATIVO"){
                    $_SESSION["inicio"]="indexOperativo.php";
                    $urlDestino = "view/home/indexOperativo.php";
                }
                elseif($rol_usuario["rol_nom"] == "GERENTE"){
                    $_SESSION["inicio"]="indexGerencia.php";
                    $urlDestino = "view/home/indexGerencia.php";
                }
            }

                /* TODO:Generar variables de Session del Usuario */
                $_SESSION["usuario_id"]=$usuario_id;
                $_SESSION["cedula"]=$ci;
                $_SESSION["nombre"]=$datos["nombres"];
                $_SESSION["apellido"]=$datos["apellidos"];
                $_SESSION["email"]=$datos["email"];
                $_SESSION["telefono"]=$datos["telefonoMovil"];
                $_SESSION["inicio"]="index.php";
                header("Location:".Conectar::ruta().$urlDestino);
          
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

    }

       
?>