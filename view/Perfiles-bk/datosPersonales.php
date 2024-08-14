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

        <!-- Contenido -->
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-9 col-lg-12 col-xl-8 col-md-8">
                        <section class="box-typical proj-page">
                            <section class="proj-page-section proj-page-header">
                                <div class="title">
                                    Mis datos personales
                                </div>
                            </section><!--.proj-page-section-->

                            <!-- formulario -->
                            <div class="container-fluid">
                                <div class="row">
                                    <form method="post" id="datos_personales_form">
                                        <section class="box-typical steps-icon-block" id="formulario">

                                            <!-- Información personal -->
                                            <div id="" class="row">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="nombre"
                                                                style="text-align:left;margin:5px;margin-left:30px;">Nombre
                                                                completo</label>
                                                            <input type="text" class="form-control" id="nombre"
                                                                name="nombre" placeholder="Nombre" />
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label for="apellido"
                                                                    style="text-align:left;margin:5px;margin-left:30px;">Apellido
                                                                    completo</label>
                                                                <input type="text" class="form-control" id="apellido"
                                                                    name="apellido" placeholder="Apellido" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <label for="documento_identidad"
                                                                style="text-align:left;margin:5px;margin-left:30px;">Documento
                                                                de identidad</label>
                                                            <input type="text" class="form-control" id="documento_identidad"
                                                                name="documento_identidad" placeholder="Documento de identidad"/>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label for="fecha_nacimiento"
                                                                    style="text-align:left;margin:5px;margin-left:30px;">Fecha de nacimiento</label>
                                                                <input type="date" class="form-control" id="fecha_nacimiento"
                                                                    name="fecha_nacimiento" placeholder="dd/mm/yyyy"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label for="telefono"
                                                                    style="text-align:left;margin:5px;margin-left:30px;">Teléfono</label>
                                                                <input type="text" class="form-control" id="telefono"
                                                                    name="telefono" placeholder="Telefono" />
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label for="email"
                                                                    style="text-align:left;margin:5px;margin-left:30px;">Correo electrónico</label>
                                                                <input type="text" class="form-control" id="email"
                                                                    name="email" placeholder="email" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <label for="direccion_domicilio"
                                                                style="text-align:left;margin:5px;margin-left:30px;">Dirección de domicilio</label>
                                                            <input type="text" class="form-control" id="direccion_domicilio"
                                                                name="direccion_domicilio" placeholder="Dirección de su domicilio"
                                                                />
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        
                                                    </div>
                                                </div>

                                            </section><!--.steps-icon-block-->

                                        </form>
                                    </div><!--.row-->
                                </div><!--.container-fluid-->
                            </section><!-- box-typical proj-page -->
                        </div>



                        <div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
                            <section class="box-typical proj-page">

                                <section class="proj-page-section">
                                    <ul class="proj-page-actions-list">
                                        <li onclick="guardarDatosPersonales()" id="guardar_datos_btn"><a><i
                                                    class="font-icon font-icon-check-square"></i>Guardar cambios</a></li>
                                        <li><a class="cancelar" href="../home/"><i
                                                    class="glyphicon glyphicon-trash"></i> Cancelar</a></li>
                                    </ul>
                                </section><!--.proj-page-section-->
                            </section><!--.proj-page-->
                        </div>
                    </div><!--.row-->
                </div><!--.container-fluid-->
            </div><!--.page-content-->
            <!-- Contenido -->

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