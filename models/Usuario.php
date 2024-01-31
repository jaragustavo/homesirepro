<?php
    class Usuario extends Conectar{
        /* TODO: Listar Registros */
        public function get_usuario_x_suc_id($suc_id){
            $conectar=parent::Conexion();
            $sql="SP_L_USUARIO_01 ?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$suc_id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Listar Registro por ID en especifico */
        public function get_usuario_x_usu_id($usu_id){
            $conectar=parent::Conexion();
            $sql="SP_L_USUARIO_02 ?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$usu_id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO: Eliminar o cambiar estado a eliminado */
        public function delete_usuario($usu_id){
            $conectar=parent::Conexion();
            $sql="SP_D_USUARIO_01 ?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$usu_id);
            $query->execute();
        }

        /* TODO: Registro de datos */
        public function insert_usuario($suc_id,$usu_correo,$usu_nom,$usu_ape,$usu_dni,$usu_telf,$usu_pass,$rol_id,$usu_img){
            $conectar=parent::Conexion();

            require_once("Usuario.php");
            $usu=new Usuario();
            $usu_img='';
            if($_FILES["usu_img"]["name"] !=''){
                $usu_img=$usu->upload_image();
            }

            $sql="SP_I_USUARIO_01 ?,?,?,?,?,?,?,?,?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$suc_id);
            $query->bindValue(2,$usu_correo);
            $query->bindValue(3,$usu_nom);
            $query->bindValue(4,$usu_ape);
            $query->bindValue(5,$usu_dni);
            $query->bindValue(6,$usu_telf);
            $query->bindValue(7,$usu_pass);
            $query->bindValue(8,$rol_id);
            $query->bindValue(9,$usu_img);
            $query->execute();
        }

        /* TODO:Actualizar Datos */
        public function update_usuario($usu_id,$suc_id,$usu_correo,$usu_nom,$usu_ape,$usu_dni,$usu_telf,$usu_pass,$rol_id,$usu_img){
            $conectar=parent::Conexion();

            require_once("Usuario.php");
            $usu=new Usuario();
            $usu_img='';
            if($_FILES["usu_img"]["name"] !=''){
                $usu_img=$usu->upload_image();
            }else{
                $usu_img = $POST["hidden_usuario_imagen"];
            }

            $sql="SP_U_USUARIO_01 ?,?,?,?,?,?,?,?,?,?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$usu_id);
            $query->bindValue(2,$suc_id);
            $query->bindValue(3,$usu_correo);
            $query->bindValue(4,$usu_nom);
            $query->bindValue(5,$usu_ape);
            $query->bindValue(6,$usu_dni);
            $query->bindValue(7,$usu_telf);
            $query->bindValue(8,$usu_pass);
            $query->bindValue(9,$rol_id);
            $query->bindValue(10,$usu_img);
            $query->execute();
        }

        public function update_usuario_pass($usu_id,$usu_pass){
            $conectar=parent::Conexion();
            $sql="SP_U_USUARIO_02 ?,?";
            $query=$conectar->prepare($sql);
            $query->bindValue(1,$usu_id);
            $query->bindValue(2,$usu_pass);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /* TODO:Acceso al Sistema */
        public function login(){
            $conectar=parent::Conexion();
            if (isset($_POST["enviar"])){
                /* TODO: Recepcion de Parametros desde la Vista Login */
                $correo = $_POST["email"];
                $pass =  $_POST["password"];
               
                if (empty($correo) and empty($pass)){
                    header("Location:".Conectar::ruta()."index.php?m=2");
                    exit();
                }else{
                    $sql="select * from usuarios where email = '".$correo."' and password= '".$pass."'";

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

                        header("Location:".Conectar::ruta()."view/home/");
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
            // $sql->bindValue(1, $usuario_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO: Listar documentos pertenecientes a Currículum Virtual */
        public function get_cantidades_curriculum($usu_id){
            $conectar=parent::Conexion();
            $sql="select 
            t1.cant_personales,t2.cant_academicos
            from 
            (SELECT count(*) as cant_personales
                FROM datos_personales
                WHERE usuario_id = $usu_id
                AND activo = true) as t1, 
            (SELECT count(*) as cant_academicos
                FROM documentos_academicos
                WHERE usuario_id = $usu_id
                AND activo = true) as t2;";
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
    }
?>