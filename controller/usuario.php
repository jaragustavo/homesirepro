<?php
    /* TODO: Llamando Clases */
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    require_once("../models/Menu.php");
    /* TODO: Inicializando clase */
    $usuario = new Usuario();
    $menu = new Menu();

    switch($_GET["op"]){
        /* TODO: Guardar y editar, guardar cuando el ID este vacio, y Actualizar cuando se envie el ID */
        case "guardaryeditar":
            if(empty($_POST["usu_id"])){
                $usuario->insert_usuario(
                    $_POST["suc_id"],
                    $_POST["email"],
                    $_POST["nombre"],
                    $_POST["apeliido"],
                    $_POST["ci"],
                    $_POST["activo"],
                    $_POST["password"]
                    // $_POST["rol_id"],
                    // $_POST["usu_img"]
                );
            }else{
                $usuario->update_usuario(
                    $_POST["suc_id"],
                    $_POST["email"],
                    $_POST["nombre"],
                    $_POST["apeliido"],
                    $_POST["ci"],
                    $_POST["activo"],
                    $_POST["password"]
                );
            }
            break;

        /* TODO: Listado de registros formato JSON para Datatable JS */
        case "listar":
            $datos=$usuario->get_usuario_x_suc_id($_POST["suc_id"]);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();

                // if ($row["USU_IMG"] != ''){
                //     $sub_array[] =
                //     "<div class='d-flex align-items-center'>" .
                //         "<div class='flex-shrink-0 me-2'>".
                //             "<img src='../../assets/usuario/".$row["USU_IMG"]."' alt='' class='avatar-xs rounded-circle'>".
                //         "</div>".
                //     "</div>";
                // }else{
                //     $sub_array[] =
                //     "<div class='d-flex align-items-center'>" .
                //         "<div class='flex-shrink-0 me-2'>".
                //             "<img src='../../assets/usuario/no_imagen.png' alt='' class='avatar-xs rounded-circle'>".
                //         "</div>".
                //     "</div>";
                // }
                $sub_array[] = $row["email"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["apellido"];
                $sub_array[] = $row["ci"];
                $sub_array[] = $row["password"];
                $sub_array[] = $row["fech_crea"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["id"].')" id="'.$row["id"].'" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["id"].')" id="'.$row["id"].'" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /* TODO:Mostrar informacion de registro segun su ID */
        case "mostrar":
            $datos=$usuario->get_usuario_x_usu_id($_POST["id"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $output["id"] = $row["id"];
                    $output["suc_id"] = $row["suc_id"];
                    $output["nombre"] = $row["nombre"];
                    $output["apellido"] = $row["apellido"];
                    $output["email"] = $row["email"];
                    $output["ci"] = $row["ci"];
                    $output["password"] = $row["password"];
                    // if($row["USU_IMG"] != ''){
                    //     $output["USU_IMG"] = '<img src="../../assets/usuario/'.$row["USU_IMG"].'" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_usuario_imagen" value="'.$row["USU_IMG"].'" />';
                    // }else{
                    //     $output["USU_IMG"] = '<img src="../../assets/usuario/no_imagen.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_usuario_imagen" value="" />';
                    // }
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Cambiar Estado a 0 del Registro */
        case "eliminar";
            $usuario->delete_usuario($_POST["id"]);
            break;
        /* TODO:Actualizar contraseña del Usuario */
        case "actualizar";
            $usuario->update_usuario_pass($_POST["id"],$_POST["password"]);
            break;
        case "cargarMenu";
            $permisos = array();
            $datos = $menu->get_menu_x_permisos_id($_SESSION["usuario_id"]);
            foreach ($datos as $row) {
                array_push($permisos, $row['nombre_permiso']);
            }

            in_array('Curriculum Virtual', $permisos)?$_SESSION['Curriculum Virtual']=1:$_SESSION['Curriculum Virtual']=0;
            in_array('Investigaciones', $permisos)?$_SESSION['Investigaciones']=1:$_SESSION['Investigaciones']=0;
            in_array('Documentos personales', $permisos)?$_SESSION['Documentos personales']=1:$_SESSION['Documentos personales']=0;
            
            // error_log('################## '.count($datos));
            
            break;
        case "grafico";
            $datos=$usuario->get_usuario_grafico($_SESSION["usuario_id"]);  
            echo json_encode($datos);
            break;
    }
?>