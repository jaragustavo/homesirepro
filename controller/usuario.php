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
                    $output["telefono"] = $row["telefono"];
                    $output["password"] = $row["password"];
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

        case "cantidadesTramites":
            $datos=$usuario->get_cantidades_tramites($_SESSION["usuario_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                
                foreach($datos as $row)
                {
                    $output["lbltramitesrealizados"] = $row["cantidad_tramites"];
                }
                echo json_encode($output);
            }
            break;
        case "cantidadesReposos":
            $datos=$usuario->get_cantidades_reposos($_SESSION["cedula"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["lblreposos"] = $row["cant_reposos"];
                }
                echo json_encode($output);
            }
            break;
 
        case "totalRepososVisados":
            $datos=$usuario->get_total_reposos_visados();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["lbltotalrepososvisados"] = $row["cant_reposos"];
                }
                echo json_encode($output);
            }
            break;
        case "mostrarDatosPersonales":

            $datos = $usuario->get_datos_personales($_SESSION["cedula"]);  
            
            if ($datos) {
                echo json_encode($datos);
            } else {
                echo json_encode(["error" => "No se encontraron datos."]);
            }
         break;
        case "guardarFotoPerfil":
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        
                $doc1 = $_FILES['file']['tmp_name'];
                $cedula = $_SESSION['cedula']; // Asegúrate de tener esta variable bien definida
                if ($doc1 != "") {
        
                    // Define la ruta local donde se guardará la imagen
                    $ruta_local = "../docs/documents/foto_carnet/" . $cedula . '/';
                    // Crear el directorio si no existe
                    if (!file_exists($ruta_local)) {
                        mkdir($ruta_local, 0777, true);
                    } else {
                        // Eliminar archivos existentes con el mismo nombre
                        $files = glob($ruta_local . $cedula . '.*');
                        foreach ($files as $file_existente) {
                            if (is_file($file_existente)) {
                                unlink($file_existente);
                            }
                        }
                    }
        
                    // Obtener la extensión del archivo y generar un nuevo nombre de archivo
                    $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $docNombre = $cedula . "." . $fileExtension;
                    $destino = $ruta_local . $docNombre;
        
                    // Mover el archivo subido al destino local
                    if (move_uploaded_file($doc1, $destino)) {
                        // Transferir la imagen al servidor remoto
                        $url_remoto = 'http://sirepro.mspbs.gov.py/Apis/subir_foto.php'; // Debes crear este script en el servidor remoto
                        $data = [
                            'file' => new CURLFile($destino),
                            'cedula' => $cedula
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url_remoto);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);
                        curl_close($ch);
                        
                        if ($response === false) {
                            echo json_encode(["status" => "error", "message" => "Error al transferir la imagen al servidor remoto."]);
                        } else {
                            echo json_encode(["status" => "ok", "new_image_path" => $destino, "server_response" => $response]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error al mover el archivo subido."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "No se subió ningún archivo."]);
                }
            }
        break;
            
        case "updateDatosPersonales":
            date_default_timezone_set('America/Asuncion');

            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $fecha_hora = $fecha.' '.$hora;
            try {
                $datos = array(
                    "fecha_hora"=>$fecha_hora,
                    "usuario_id"=>$_SESSION["usuario_id"],
                    "cedula"=>$_SESSION["cedula"],
              //      "nombre"=>$_POST["nombre"],
         //           "apellido"=>$_POST["apellido"],
                    "email"=>$_POST["email"],
          //          "fecha_nacimiento"=>$_POST["fecha_nacimiento"],
                    "direccion_domicilio"=>$_POST["direccion_domicilio"],
                    "barrio"=>$_POST["barrio"],
                    "telefono"=>$_POST["telefono"],
                    "celular"=>$_POST["celular"],
                    "ciudad_id"=>$_POST["ciudad_id"],
                    "departamento_id"=>$_POST["departamento_id"]
                );
                $resultado = $usuario->update_usuario($datos);
            }
            catch(Exception $e){
                echo $e;
            }

         break;        
            
    }
?>