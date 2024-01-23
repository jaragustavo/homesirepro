<?php
    /*TODO: llamada a las clases necesarias */
    require_once("../config/conexion.php");
    require_once("../models/Mensaje.php");
    $mensaje = new Mensaje();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $mensajes_nuevos = 0;
    $active = "";
    /*TODO: opciones del controlador */
    switch($_GET["op"]){

        case "listarNotificaciones":
            // $datos=$mensaje->get_mensajes_x_usu($_SESSION["usuario_id"]);
            // $data= Array();
            foreach($datos as $row){
                // $sub_array = array();
                $output["mensaje_id"] = $row["mensaje_id"];
                $output["mensaje"] = $row["mensaje"];
                $output["remitente_id"] = $row["remitente_id"];
                $output["nombre_remitente"] = $row["nombre_remitente"];
                $output["fecha"] = $row["fecha"];
                $mensajes_nuevos = $row["cant_mensajes_nuevos"];
                $active = "active";
                
                $cifrado = openssl_encrypt($row["remitente_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);
                $output["ruta_mensaje"] = '../Mensajes/abrirChat.php?ID='.$textoCifrado.'';

                echo json_encode($output);
                
            }

            break;
        /* TODO: Mostrar en formato JSON segun usu_id */
        

        case "cargarChat":
            $conversaciones=$mensaje->get_conversacion_x_usuario($_POST["chat_id"], $_SESSION["usuario_id"]);
            $data= Array();
            if(is_array($conversaciones)==true and count($conversaciones)>0){
                
                foreach($conversaciones as $row)
                {
                    $sub_array = array();
                    $sub_array["mensaje_id"] = $row["mensaje_id"];
                    $sub_array["mensaje"] = $row["mensaje"];
                    $sub_array["remitente_id"] = $row["remitente_id"];
                    $sub_array["usuario_id"] = $_SESSION["usuario_id"];
                    $sub_array["nombre_remitente"] = $row["nombre_remitente"];
                    $sub_array["nombre_destinatario"] = $row["nombre_destinatario"];
                    $sub_array["ind_estado"] = $row["ind_estado"];
                    $sub_array["hora"] = $row["hora"];
                    $sub_array["fecha"] = $row["fecha"];
                    $sub_array["cedula_usuario"] = $row["cedula_usuario"];
                    $sub_array["cedula_chat"] = $row["cedula_chat"];
                    $data[] = $sub_array;
                }
                echo json_encode($data);
            }
            break;

        /* TODO:Actualizar estado segun not_id */
        case "actualizar";
            $notificacion->update_notificacion_estado($_POST["not_id"]);
            break;

        /* TODO: Listado de notificacion segun formato json para el datatable */    
        case "listar":
            $datos=$notificacion->get_mensajes_x_usu($_SESSION["usuario_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["mensaje_id"];

                $cifrado = openssl_encrypt($row["mensaje_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

    }
?>