<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Clases Necesarias */
    require_once("../models/Tramite.php");
    $tramite = new Tramite();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $docs_lista = array();
    /*TODO: opciones del controlador Documento Personal*/
    switch($_GET["op"]){

        /* TODO: Listado de documentos personales segun usuario,formato json para Datatable JS */
        case "listar_x_usu":
            $datos=$documentoPersonal->listar_dato_personal_x_usu($_SESSION["usuario_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tipo_documento"];
                $sub_array[] = date("d/m/Y", strtotime($row["fecha"]));
                $ruta = "http://localhost:90/homesirepro/docs/documents/".$_SESSION["cedula"]."/"."personales/".$row["documento"];

                $cifrado = openssl_encrypt($row["dato_personal_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button title="Abrir documento" style="padding: 0;border: none;background: none;" type="button" data-ciphertext="'.$ruta.'" id="'.$textoCifrado.'" class="btn-open-pdf"><i class="glyphicon glyphicon-file" style="color:#2986cc; font-size:large; margin: 3px;" aria-hidden="true"></button></i>
                <button title="Editar documento" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-inline"><i  class="glyphicon glyphicon-edit" style="color:#6aa84f; font-size:large; margin: 3px;" aria-hidden="true"></i></button>
                <button title="Eliminar documento" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-delete-row"><i class="glyphicon glyphicon-trash" style="color:#e06666; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        
        /* TODO: Listado de documentos personales,formato json para Datatable JS, filtro avanzado*/
        case "listar_filtro":
            if($_POST["fecha"] != ""){
                $_POST["fecha"] = date('Y-m-d', strtotime($_POST["fecha"]));
            }
            
            $datos=$documentoPersonal->filtrar_doc_personal($_POST["tipo_documento"],$_POST["fecha"]);
            $data= Array();
            foreach($datos as $row){

                $sub_array = array();
                $sub_array[] = $row["tipo_documento"];
                $sub_array[] = date("d/m/Y", strtotime($row["fecha"]));
                $ruta = "http://localhost:90/homesirepro/docs/documents/".$_SESSION["cedula"]."/"."personales/".$row["documento"];

                $cifrado = openssl_encrypt($row["dato_personal_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button title="Abrir documento" style="padding: 0;border: none;background: none;" type="button" data-ciphertext="'.$ruta.'" id="'.$textoCifrado.'" class="btn-open-pdf"><i class="glyphicon glyphicon-file" style="color:#2986cc; font-size:large; margin: 3px;" aria-hidden="true"></button></i>
                <button title="Editar documento" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-inline"><i  class="glyphicon glyphicon-edit" style="color:#6aa84f; font-size:large; margin: 3px;" aria-hidden="true"></i></button>
                <button title="Eliminar documento" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-delete-row"><i class="glyphicon glyphicon-trash" style="color:#e06666; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                
                $data[] = $sub_array;
                
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /*=============================================
            GUARDAR DOCUMENTOS EN DIRECTORIOS CORRESPONDIENTES
            =============================================*/
        case "insertDocumentos":

            if(isset($_FILES['file'])) {
                $file = $_FILES['file'];
                $id = $_POST['id'];
                // Detalles del archivo
                if($id > 0){
                    $datos=$tramite->get_datos_directorio($id, $_POST['tramite_code']);
                    $data= Array();
                    foreach($datos as $row){
                        $tramite_nom = $row['tramite_nombre'];
                        $doc_nom = $row['doc_nombre_corto'];
                    }
                    $ruta = "../docs/documents/".$_SESSION["cedula"]."/".$tramite_nom."/".$doc_nom."/";
    
                    /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }
                    else{
                        // Get a list of all files in the directory
                        $files = glob($ruta . '*');
                        // Iterate through the list and delete each file
                        foreach ($files as $file_existente) {
                            if (is_file($file_existente)) {
                                unlink($file_existente);
                            }
                        }
                    }
                    $uploadedFile = $file['tmp_name'];
                    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $docNombre = $_SESSION["cedula"]."-".date('YmdHis')."-".
                    $doc_nom.".".$fileExtension;
                    $destino = $ruta.$docNombre;
                    /* TODO: Movemos los archivos hacia la carpeta creada */
                    move_uploaded_file($uploadedFile,$destino);
                }
            } else {
                echo "No se ha enviado ninguna imagen.";
            }
            
            break;
        case "insert":
                
                
            
            
            
            /*=============================================
            CREAR TRÁMITE
            =============================================*/

            date_default_timezone_set('America/Asuncion');

            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $fecha_hora = $fecha.' '.$hora;

          
                // try {
                //     $datos = array("tipo_documento"=>$_POST["tipo_documento"],
                //                 "ide_beneficiario"=>$_POST["proveedor"],
                //                 "nombre_beneficiario"=>$_POST["nombre_beneficiario"],
                //                 "descripcion"=>$_POST["descripcion"],
                //                 "nro_documento"=>$_POST["nro_documento"],
                //                 "fecha_documento"=>$_POST["fecha_documento"],
                //                 "moneda"=>$_POST["moneda"],
                //                 "total_iva"=>$_POST["total_iva"],

                //                 "total_retencion"=>$_POST["total_retencion"],
                //                 "monto_documento"=>$_POST["monto_documento"],
                //                 "saldo_documento"=>$_POST["monto_documento"],
                //                 "ind_estado"=>'PE',
                //                 "fec_alta"=>$fecha_hora,
                //                 "login"=>$_POST["login"],
                //                 "can_cuotas"=>$_POST["can_cuotas"],
                //                 "exenta"=>$_POST["exenta"],
                //                 "concepto_caja"=>$_POST["concepto_caja"],
                //                 "retencion"=>$_POST["retencion"],
                //                 "nro_cuota"=>$_POST["nro_cuota"],
                                
                //                 "monto_cuota"=>$_POST["monto_cuota"],
                //                 "vencimiento_cuota"=>$_POST["vencimiento_cuota"],
                //                 "pedido_fab"=>$pedido_fab

                            
                //     );

                //     // $respuesta = ModeloDocumentosPagos::mdlCrearDocumentoPago($datos);

                // } catch(Exception $e) {
                    
                //     echo $e->getMessage();
                    
                // }
            break;

        /* TODO: Actualizamos el Documento Personal a cerrado y adicionamos una linea adicional */
        case "update":

            $iv_dec = substr(base64_decode($_POST["idEncrypted"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["idEncrypted"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $docNombre = basename($_FILES["imagen"]["name"]);
            $datos = "";
            if ($decifrado === false) {
                echo "Decryption failed with error: $error";
            } else {

                $doc1 = $_FILES['imagen']['tmp_name'];
                if($doc1 != "" && $_GET["img"] == 0){
                    $ruta = "../docs/documents/".$_SESSION["cedula"]."/"."personales/";

                    /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }
                    $fileExtension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    $docNombre = $_SESSION["cedula"]."-".date('YmdHis')."-".
                    $_POST["tipo_documento"].".".$fileExtension;
                    $destino = $ruta.$docNombre;
                    /* TODO: Movemos los archivos hacia la carpeta creada */
                    move_uploaded_file($doc1,$destino);
                }
                /* Se inserta el registro en la BD */
                $datos = $documentoPersonal->update_doc_personal($decifrado,$_POST["usuario_id"],
                $_POST["tipo_documento"],$docNombre,$_POST["fecha"],$_POST["dato_adic"]);
            } 
            echo $datos ? "Documento agregado" : "El documento no se pudo agregar.";
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
            // error_log('$$$$$$$$$$$$$$$$'.$decifrado);
            
            $respuesta = $documentoPersonal->delete_doc_personal($decifrado, $_SESSION["usuario_id"]);
            echo $respuesta ? "Documento eliminado" : "El documento se pudo eliminar.";
            break;

        case "comboTramites":
        
            $datos = $tramite->get_tramites_x_tipo_id('P');
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['url']."'>".$row['tramite']."</option>";
                }
                echo $html;
            }
            break;

        case "comboEstadosTramites":
    
            $datos = $tramite->get_estados_tramites();
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['estado_tramite_id']."'>".$row['estado_tramite']."</option>";
                }
                echo $html;
            }
            break;    

        case "code":
            $code = $tramite->get_tramite_code($_POST["tramiteUrl"]);
            echo $code[0]["tramite_id"];
            break;
        
        case "cargarTitulo":
            $code = $tramite->get_tramite_name($_POST["titulo"]);
            echo $code[0]["tramite_nombre"];
            break;
        case "comboEstadoCivil":
            $datos = $tramite->get_estados_civiles();
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['estado_civil_id']."'>".$row['estado_civil']."</option>";
                }
                echo $html;
            }
            break;

        case "comboPaises":
            $datos = $tramite->get_paises();
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['pais_id']."'>".$row['pais']."</option>";
                }
                echo $html;
            }
            break;
        case "comboDepartamentos":
            $datos = $tramite->get_departamentos($_POST["pais"]);
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['departamento_id']."'>".$row['departamento']."</option>";
                }
                echo $html;
            }
            break;
        case "comboCiudades":
            $datos = $tramite->get_ciudades($_POST["departamento"]);
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['ciudad_id']."'>".$row['ciudad']."</option>";
                }
                echo $html;
            }
            break;
        }
        
?>