<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Clases Necesarias */
    require_once("../models/Tramite.php");
    $tramite = new Tramite();

    require_once("../models/Certificacion.php");
    $certificacion = new Certificacion();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $docs_lista = array();
    /*TODO: opciones del controlador Trámites*/
    switch($_GET["op"]){

        /* TODO: Listado de trámites por usuario,formato json para Datatable JS */
        case "listar_x_usu":
            $datos=$certificacion->get_tramites_gestionados_x_usuario($_SESSION["usuario_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["nombre_tramite"];
                $sub_array[] = date("d/m/Y", strtotime($row["fecha_solicitud"]));
                $sub_array[] = $row["estado_actual"];
                require("../view/Formularios/avance.php");
                $sub_array[] = '<div class="progress-with-amount">
                                    <progress class="progress progress'.$color.' progress-no-margin" value="'.$avance.'" max="100">'.$avance.'%</progress>
                                    <div class="progress-with-amount-number">'.$avance.'%</div>
                                </div>';
            

                $cifrado = openssl_encrypt($row["tramite_gestionado_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $boton_mostrado = "";
                if($row["estado_actual"]=="PENDIENTE ENVIO"){
                    $boton_mostrado ='<button title="Editar solicitud" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-inline"><i  class="glyphicon glyphicon-edit" style="color:#6aa84f; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                }
                elseif($row["estado_actual"]=="CON OBSERVACIONES"){
                    $boton_mostrado ='<button title="Ver solicitud" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-abrir-solicitud"><i  class="glyphicon glyphicon-eye-open" style="color:#2986cc; font-size:large; margin: 3px;" aria-hidden="true"></i></button>'.
                    '<button title="Ver Observaciones" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-ver-observaciones"><i  class="glyphicon glyphicon-alert" style="color:#e69138; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                    
                }
                elseif($row["estado_actual"]=="INSCRIPTO"){
                    $boton_mostrado ='<button title="Ver inscripcion" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-abrir-inscripcion"><i  class="glyphicon glyphicon-eye-open" style="color:#2986cc; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                }
                else {
                    $boton_mostrado ='<button title="Ver solicitud" style="padding: 0;border: none;background: none;" type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-abrir-solicitud"><i class="glyphicon glyphicon-eye-open" style="color:#2986cc; font-size:large; margin: 3px;" aria-hidden="true"></button></i>';
                }
                if($row["estado_actual"]!="ASIGNADO" && $row["estado_actual"]!="CON CITA AGENDADA"){
                    $boton_mostrado = $boton_mostrado.
                    '<button title="Cancelar solicitud" type="button" style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-delete-row"><i class="glyphicon glyphicon-trash" style="color:#e06666; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                }
                $sub_array[]= $boton_mostrado;
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
                    $datos=$certificacion->get_datos_directorio($id, $_POST['tramite_code'], "archivosDisco");
                    $data= Array();
                    foreach($datos as $row){
                        $tramite_nom = $row['tramite_nombre_corto'];
                        $doc_nom = $row['tipo_doc_nombre_corto'];
                    }
                    $ruta = "../docs/documents/".$_SESSION["cedula"]."/certificaciones"."/".$tramite_nom."/".$doc_nom."/";
    
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
                    $docNombre = date('mdHis')."-".
                    $doc_nom.".".$fileExtension;
                    $destino = $ruta.$docNombre;
                    /* TODO: Movemos los archivos hacia la carpeta creada */
                    move_uploaded_file($uploadedFile,$destino);
                }
            } else {
                echo "No se ha enviado ninguna imagen.";
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
                try {
                    $item = 0;
                    $tiposDocumentos=json_decode($_POST['tiposDocumentos']);
                    $datos = array(
                                // Para todas las tablas
                                "usuario_id"=>$_SESSION["usuario_id"],
                                "fecha_crea"=>$fecha_hora,
                                "tramite_id"=>$_POST["tramite_code"],
                                "activo"=>"true",

                                // Datos para el trámite gestionado
                                "estado_tramite_id"=>$_POST["estado_tramite"],
                                "forma_solicitud"=>"definitiva",
                                "nivel" => $_POST["nivel"],

                                // Datos para documentos del trámite gestionado
                                "tramite_code"=>$_POST["tramite_code"],
                                "cedula_user"=>$_POST["documento_identidad"],
                                "tiposDocumentos"=> $_POST['tiposDocumentos'],
                                "estado_docs_tramite_id"=> 2,

                                // Información Personal formulario
                                "estado_civil"=>$_POST["estado_civil"],
                                "nombre"=>$_POST["nombre"],
                                "apellido"=>$_POST["apellido"],
                                "cedula_identidad"=>$_POST["documento_identidad"],
                                "fecha_nacimiento"=>$_POST["fecha_nacimiento"],
                                "pais_nacimiento"=>$_POST["pais_nacimiento"],
                                "departamento_nacimiento"=>$_POST["departamento_nacimiento"],
                                "ciudad_nacimiento"=>$_POST["ciudad_nacimiento"],

                                // Residencia Permanente
                                "direccion_residencia"=>$_POST["direccion_residencia"],
                                "departamento_residencia"=>$_POST["departamento_residencia"],
                                "ciudad_residencia"=>$_POST["ciudad_residencia"],
                                "barrio_residencia"=>$_POST["barrio_residencia"],
                                "telefono_residencia"=>$_POST["telefono_residencia"],
                                "celular_principal"=>$_POST["celular_principal_residencia"],
                                "celular_secundario"=>$_POST["celular_secundario_residencia"],
                                "email"=>$_POST["email_residencia"],
                                
                                // Datos laborales
                                //Público
                                "servicio_publico"=>$_POST["servicio_publico"],
                                "direccion_publico"=>$_POST["direccion_publico"],
                                "departamento_publico"=>$_POST["departamento_publico"],
                                "ciudad_publico"=>$_POST["ciudad_publico"],
                                "telefono_publico"=>$_POST["telefono_publico"],
                                "email_publico"=>$_POST["email_publico"],
                                //Privado
                                "servicio_privado"=>$_POST["servicio_privado"],
                                "direccion_privado"=>$_POST["direccion_privado"],
                                "departamento_privado"=>$_POST["departamento_privado"],
                                "ciudad_privado"=>$_POST["ciudad_privado"],
                                "telefono_privado"=>$_POST["telefono_privado"],
                                "email_privado"=>$_POST["email_privado"],
                                
                                // Título de Salud Obtenido
                                "titulo_obtenido"=>$_POST["titulo_obtenido"],
                                "institucion_titulo"=>$_POST["institucion_titulo"],
                                "pais_titulo"=>$_POST["pais_titulo"],
                                
                                // Post-grado
                                "titulo_postgrado"=>$_POST["titulo_postgrado"],
                                "institucion_postgrado"=>$_POST["institucion_postgrado"],
                                "pais_postgrado"=>$_POST["pais_postgrado"],

                            
                    );

                    $respuesta = $certificacion->insertar_tramites($datos);

                } catch(Exception $e) {
                    
                    echo $respuesta;
                    
                }
                if($respuesta == "error"){
                    echo $respuesta;
                }
            break;

        
        /* TODO: Mostrar informacion de Documento Personal en formato JSON para la vista */
        case "mostrar":
            
            $iv_dec = substr(base64_decode($_POST["tramite_gestionado_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tramite_gestionado_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$certificacion->mostrar($decifrado, $_SESSION["usuario_id"]);
            if (is_array($datos) && count($datos) > 0) {
                $output = array();
            
                foreach ($datos as $row) {
                    $item = array();
                    
                    // Iterate through each key-value pair in $row
                    foreach ($row as $key => $value) {
                        // Add each key-value pair to the $item array
                        $item[$key] = $value;
                    }
            
                    // Append each item to the output array
                    $output[] = $item;
                }
            
                echo json_encode($output);
            }
            break;

        case "delete": 
            $iv_dec = substr(base64_decode($_POST["ciphertext"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["ciphertext"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            // error_log('$$$$$$$$$$$$$$$$'.$decifrado);
            date_default_timezone_set('America/Asuncion');
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $fecha_hora = $fecha . ' ' . $hora;
            
            $respuesta = $tramite->delete_tramite_gestionado($decifrado, $_SESSION["usuario_id"], $fecha_hora);
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
        
        case "comboTitulos":

            $datos = $tramite->get_titulos();
            $html="";
            $html.="<option label='Seleccionar'></option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['titulo_id']."'>".$row['nombre_titulo']."</option>";
                }
                echo $html;
            }
            break;
        
        case "observacionTramite":
            $iv_dec = substr(base64_decode($_POST["idEncrypted"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["idEncrypted"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            $code = $tramite->get_observacion_tramite($decifrado);
            echo $code[0]["observacion"];
            break;
        }
        
?>