<?php
require_once ("../../config/conexion.php");
if (isset($_SESSION["usuario_id"])) {
    ?>
    <!DOCTYPE html>
    <html>
    <link rel="stylesheet" href="plugins/dropzone/dropzone.css" type="text/css">
    <?php require_once ("../MainHead/head.php"); ?>

    <!-- <link rel="stylesheet" href="plugins/css/dropzone.css"> -->

    <title>Datos Personales</title>
    </head>

    <body class="with-side-menu">
    <?php require_once ("../MainHeader/header.php"); ?>

    <div class="mobile-menu-left-overlay"></div>
    <?php require_once ("../MainNav/nav.php"); ?>

    <style>
        
        .el-card-avatar {
        position: relative;
        width: 100%;
        height: 150px; /* Fija la altura del contenedor de la imagen */
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .el-card-avatar img, .el-card-avatar iframe {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Mantiene la relación de aspecto de la imagen */
    }

    .waves-effect {
        margin-top: 5px; /* Ajusta el margen superior para separar el botón de la imagen */
        display: flex;
        justify-content: center;
    }
    </style>
    <!-- Contenido -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Columna principal para el formulario de datos personales -->
                <div class="col-xxl-9 col-lg-12 col-xl-8 col-md-8">
                    <section class="box-typical profile-side-user" id="seccion_foto_perfil">
                        <div class="row">
                            <!-- Foto de perfil -->
                            <div class="col-lg-3">
                                <button type="button" class="avatar-preview avatar-preview-128">

                                     <?php
                                           
                                            $esImagen = false;
                                            $esPDF = false;
                                            $cedula = $_SESSION["cedula"];

                                            $imagen_default = "../../assets/assets-main/images/icons/user2.png";

                                           // Definir las posibles rutas de imagen
                                            $extensiones = ['jpg', 'png'];
                                           
                                            $imagen_mostrar = $imagen_default;

                                            // Intentar verificar la existencia de la imagen con cada extensión
                                            foreach ($extensiones as $ext) {

                                                $imagen_path = "http://sirepro.mspbs.gov.py/foto/{$cedula}.{$ext}";

                                                // Verificar si la imagen existe usando cURL
                                                $ch = curl_init($imagen_path);
                                                curl_setopt($ch, CURLOPT_NOBODY, true);
                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Tiempo de espera para la respuesta
                                                curl_exec($ch);
                                                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                                curl_close($ch);

                                                if ($http_code == 200) {
                                                    $imagen_mostrar = $imagen_path;
                                                    break; // Salir del bucle si se encuentra la imagen
                                                }

                                            }
                                           
                                      ?>
                                     <img src="<?php echo $imagen_mostrar; ?>" alt="Foto de usuario">
                                     <span class="update">
                                        <i class="font-icon font-icon-picture-double"></i>
                                        Cambiar foto
                                    </span>
                                    <input id="foto_perfil" type="file" onchange="guardarFoto()" />
                                </button>
                            </div>
                            <!-- Documento del usuario -->
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apellido">Apellido</label>
                                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="dd/mm/yyyy" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="documento_identidad">Nro.Documento</label>
                                            <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" placeholder="Documento de identidad" disabled/>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                   
                        </div>
                    </section>

                    <section class="box-typical proj-page">
                        <div class="row">
                            <form method="post" id="datos_personales_form">
                                <section class="proj-page-section">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="telefono">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="celular">Celular</label>
                                            <input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" style="width: 100%;" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Correo electrónico</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="email" />
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="departamento_id">Departamento</label>
                                            <select class="form-control" id="departamento_id" name="departamento_id">
                                                <option value="-1">Seleccione Departamento</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="ciudad_id">Ciudad</label>
                                            <select class="form-control" id="ciudad_id" name="ciudad_id">
                                                <option value="">Seleccione Ciudad</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="barrio">Barrio</label>
                                            <input type="text" class="form-control" id="barrio" name="barrio" placeholder="Barrio" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="direccion_domicilio">Dirección de domicilio</label>
                                            <textarea class="form-control" id="direccion_domicilio" name="direccion_domicilio" placeholder="Dirección de su domicilio" rows="3"></textarea>
                                        </div>
                                    </div>
                     
                                </section>
                            </form>
                        </div>
                    </section>
                </div>

                <!-- Columna lateral para acciones adicionales -->
                <div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4 align-self-start">
                    <section class="box-typical proj-page">
                        <section class="proj-page-section">
                            <ul class="proj-page-actions-list">
                                <li onclick="guardarDatosPersonales()" id="guardar_datos_btn"><a><i class="font-icon font-icon-check-square"></i>Guardar cambios</a></li>
                                <li><a class="cancelar" href="../home/"><i class="glyphicon glyphicon-trash"></i> Cancelar</a></li>
                            </ul>
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </div>


    <?php require_once ("../MainJs/js.php"); ?>
    <script type="text/javascript" src="perfiles.js?v=<?php echo time(); ?>"></script>
    <?php require_once ("../html/footer.php"); ?>

</body>

    </html>
    <?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>