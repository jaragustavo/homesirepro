<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Clases Necesarias */
    require_once("../models/Reposo.php");
    $reposo = new Reposo();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    /*TODO: opciones del controlador Reposos*/
    switch($_GET["op"]){

        /* TODO: Listado de reposos segun usuario,formato json para Datatable JS */
        case "listar_x_medico":
            $datos=$reposo->listar_reposos_x_medico($_SESSION["cedula"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["ci_paciente"];
                $sub_array[] = $row["nombre_paciente"];
                $sub_array[] = date("d/m/Y", strtotime($row["fecha_inicio"]));
                $sub_array[] = date("d/m/Y", strtotime($row["fecha_fin"]));
                $sub_array[] = (int)$row["cantrep"]+1;
                
                $cifrado = openssl_encrypt($row["id_reposo"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                // $sub_array[] = '<button title="Ver detalle" type="button" style="padding: 0;border: none;background: none;" 
                // data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn-inline">
                // <i  class="glyphicon glyphicon-eye-open" style="color:#6aa84f; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                
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
            if($_POST["fecha_inicio_reposo"] != ""){
                $_POST["fecha_inicio_reposo"] = date('Y-m-d', strtotime($_POST["fecha_inicio_reposo"]));
            }
            
            $datos=$reposo->filtrar_reposos($_SESSION["cedula"],$_POST["ci_paciente"],$_POST["nombre_paciente"],$_POST["fecha_inicio_reposo"]);
            $data= Array();
            foreach($datos as $row){

                $sub_array = array();
                $sub_array[] = $row["ci_paciente"];
                $sub_array[] = $row["nombre_paciente"];
                $sub_array[] = date("d/m/Y", strtotime($row["fecha_inicio"]));
                $sub_array[] = date("d/m/Y", strtotime($row["fecha_fin"]));
                $sub_array[] = (int)$row["cantrep"]+1;
                
                $cifrado = openssl_encrypt($row["id_reposo"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button title="Editar documento" type="button" 
                style="padding: 0;border: none;background: none;" data-ciphertext="'.$textoCifrado.'" 
                id="'.$textoCifrado.'" class="btn-inline"><i  class="glyphicon glyphicon-edit" 
                style="color:#6aa84f; font-size:large; margin: 3px;" aria-hidden="true"></i></button>';
                
                $data[] = $sub_array;
                
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /* TODO: Mostrar informacion del Reposo en formato JSON para la vista */
        case "mostrar":
            
            $iv_dec = substr(base64_decode($_POST["reposo_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["reposo_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$documentoPersonal->mostrar($decifrado);
            $ruta = "../../docs/documents/".$_SESSION["cedula"]."/"."repososEmitidos/";
            if(is_array($datos)==true and count($datos)>0){
                
                foreach($datos as $row)
                {
                    $output["reposo_id"] = $row["reposo_id"];
                    $output["usuario_id"] = $row["usuario_id"];
                    $output["ci_paciente"] = $row["ci_paciente"];
                    $output["nombre_paciente"] = $row["nombre_paciente"];
                    $output["documento_ruta"] = $ruta.$row["documento"];
                    $output["dato_adic"] = $row["dato_adic"];

                    $output["fecha"] = $row["fecha"];
                }
                echo json_encode($output);
            }
            break;
        }
?>