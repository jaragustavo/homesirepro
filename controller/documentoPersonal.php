<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Clases Necesarias */
    require_once("../models/DocumentoPersonal.php");
    $documentoPersonal = new DocumentoPersonal();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    /*TODO: opciones del controlador Documento Personal*/
    switch($_GET["op"]){

    /* TODO: Listado de documentos personales segun usuario,formato json para Datatable JS */
    case "listar_x_usu":
        $datos=$documentoPersonal->listar_dato_personal_x_usu($_SESSION["usuario_id"]);
        $data= Array();
        $rowNumber = 1;
        foreach($datos as $row){
            $sub_array = array();
            $sub_array[] = $rowNumber;
            $sub_array[] = $row["tipo_documento"];
            $sub_array[] = $row["documento"];
            $sub_array[] = date("d/m/Y", strtotime($row["fecha"]));

            
            $cifrado = openssl_encrypt($row["dato_personal_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>
            <button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-inline btn-success btn-sm ladda-button"><i class="fa fa-edit"></i></button>
            <button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-delete-row btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
            
            $data[] = $sub_array;
            // Increment the row number
            $rowNumber++;
        }

        $results = array(
            "sEcho"=>1,
            "iTotalRecords"=>count($data),
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data);
        echo json_encode($results);
        break;

    
        /* TODO: Insertar nuevo Documento Personal */
        case "insert":

            // $ruta = "../docs/documents/".$_SESSION["cedula"]."/"."personales/";

            //  /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
            //  if (!file_exists($ruta)) {
            //     mkdir($ruta, 0777, true);
            // }
            // $doc1 = $_FILES['imagen']['tmp_name'];
            // $destino = $ruta.'pepito';

            /* TODO: Insertamos Documentos */
            // $documento->insert_documento( $output["dato_personal_id"],$_FILES['documento']['name'][$index]);

            /* TODO: Movemos los archivos hacia la carpeta creada */
            // move_uploaded_file($doc1,$destino);


            $docNombre = basename($_FILES["imagen"]["name"]);

            $datos=$documentoPersonal->insert_doc_personal($_POST["usuario_id"],$_POST["tipo_documento"],
                $docNombre,$_POST["fecha"],$_POST["dato_adic"]);
           
           
            if (is_array($datos)==true && count($datos)>0){
                foreach ($datos as $row){
                    $output["dato_personal_id"] = $row["dato_personal_id"];
                   
                    /* TODO: Validamos si vienen archivos desde la Vista */
                    if ($docNombre == ''){
                        error_log('################## '.count($datos));
                    }else{
                        $ruta = "../docs/documents/".$_SESSION["cedula"]."/"."personales/";

                        /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        $doc1 = $_FILES['imagen']['tmp_name'];
                        $destino = $ruta.$_FILES['imagen']['name'];

                        /* TODO: Movemos los archivos hacia la carpeta creada */
                        move_uploaded_file($doc1,$destino);
                    }
                }
            }
            echo json_encode($datos);
            break;

        /* TODO: Actualizamos el Documento Personal a cerrado y adicionamos una linea adicional */
        case "update":

            $iv_dec = substr(base64_decode($_POST["idEncrypted"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["idEncrypted"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            error_log('$$$$$$$$$$$$$'.$decifrado);

            $docNombre = basename($_FILES["imagen"]["name"]);
            if ($decifrado === false) {
                echo "Decryption failed with error: $error";
            } else {
                $datos = $documentoPersonal->update_doc_personal($decifrado,$_POST["usuario_id"],
                $_POST["tipo_documento"],$docNombre,$_POST["fecha"],$_POST["dato_adic"]);
                if (is_array($datos)==true and count($datos)>0){
                    foreach ($datos as $row){
    
                        /* TODO: Validamos si vienen archivos desde la Vista */
                        if ($docNombre == ''){
                            error_log('################## '.count($datos));
                        }else{
                            $ruta = "../docs/documents/".$_SESSION["cedula"]."/";
                            $files_arr = array();
    
                            /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                            if (!file_exists($ruta)) {
                                mkdir($ruta, 0777, true);
                            }
                            $doc1 = $_FILES['imagen']['tmp_name'];
                            $destino = $ruta.$_FILES['imagen']['name'];
    
                            /* TODO: Movemos los archivos hacia la carpeta creada */
                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo $datos ? "Documento eliminado" : "El documento se pudo eliminar.";
            break;

        
        /* TODO: Mostrar informacion de Documento Personal en formato JSON para la vista */
        case "mostrar":
            
            $iv_dec = substr(base64_decode($_POST["doc_personal_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["doc_personal_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$documentoPersonal->mostrar($decifrado);
            $ruta = "../../docs/documents/".$_SESSION["cedula"]."/"."personales/";
            if(is_array($datos)==true and count($datos)>0){
                
                foreach($datos as $row)
                {
                    $output["dato_personal_id"] = $row["dato_personal_id"];
                    $output["usuario_id"] = $row["usuario_id"];
                    $output["tipo_documento"] = $row["tipo_documento"];
                    $output["imagenmuestra"] = $row["documento"];
                    $output["documento_ruta"] = $ruta.$row["documento"];
                    $output["dato_adic"] = $row["dato_adic"];

                    $output["fecha"] = $row["fecha"];
                }
                echo json_encode($output);
            }
            break;

        case "delete": 
            $iv_dec = substr(base64_decode($_POST["ciphertext"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["ciphertext"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            error_log('$$$$$$$$$$$$$$$$'.$decifrado);
            
            $respuesta = $documentoPersonal->delete_doc_personal($decifrado, $_SESSION["usuario_id"]);
            echo $respuesta ? "Documento eliminado" : "El documento se pudo eliminar.";
            break;

        case "grafico";
            $datos=$documentoPersonal->get_documentos_grafico();  
            echo json_encode($datos);
            break;

    }
?>