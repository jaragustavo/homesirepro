<style>

    /* Estilo para el ícono de agregar trabajo */
    .glyphicon.agregar-trabajo {
        color: #8DC26F; /* Color verde claro */
        font-size: large;
        padding: 10px 5px 0px 0px !important;
        margin: 3px;
        cursor: pointer; /* Cambia el cursor a una manita */
    }

   /* Estilo cuando el mouse está encima del ícono */
    .glyphicon.agregar-trabajo:hover {
        color: #5A904E !important; /* Azul oscuro cuando se pasa el mouse */
    }
   /* Estilo base para el ícono de eliminar fila */
    .glyphicon.eliminar-fila {
        float: left;
        color: #e06666;
        font-size: large;
        padding: 10px 0px 0px 5px;
        margin: 3px;
        cursor: pointer; /* Cambia el cursor a una manita */
    }

    /* Estilo cuando el mouse está encima del ícono de eliminar fila */
    .glyphicon.eliminar-fila:hover {
         color: #8B0000 !important; /* Azul oscuro cuando se pasa el mouse */
    }


    .el-card-avatar {
    position: relative;
    width: 150%;
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
        margin-top: 20px; /* Ajusta el margen superior para separar el botón de la imagen */
        display: flex;
        justify-content: center; /* Centra el botón horizontalmente */
    }




    .el-card-avatar {
        position: relative;
        width: 100%;
        height: 100px; /* Fija la altura del contenedor de la imagen */
        overflow: hidden;
        display: flex;
      
    }

    .el-card-avatar img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Mantiene la relación de aspecto de la imagen */
    }

    .waves-effect {
        margin-top: 5px; /* Ajusta el margen superior para separar el botón de la imagen */
        display: flex;
        
    }
</style>
<?php
require_once ("../../config/conexion.php");

if (isset($_SESSION["usuario_id"])) {

     ?>
    <!DOCTYPE html>
    <html>
    <?php require_once ("../MainHead/head.php"); ?>


    <title>Datos Profesionales</title>
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
                                    Mis datos profesionales
                                </div>
                            </section><!-- .proj-page-section -->

                            <!-- Formulario -->
                            <div class="container-fluid">
                                <div class="row">
                                    <form method="post" id="datos_profesionales_form">
                                            <section class="proj-page-section" id="formulario">
                                                <!-- Sección de Datos Personales -->
                                                <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="nro_registro">Nro.Registro</label>
                                                                    <input type="text" class="form-control" id="nro_registro" name="nro_registro" placeholder="Nro.Registro">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="profesion">Profesión</label>
                                                                    <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Profesión">
                                                                </div>
                                                            </div>
                                                           
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="universidad">Universidad</label>
                                                                        <input type="text" class="form-control" id="universidad" name="universidad" placeholder="Uninversidad">
                                                                    </div>
                                                                </div>
                                                        
                                              
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <section class="proj-page-section proj-page-header">
                                                            <div class="title">
                                                                Post Grados
                                                            </div>
                                                        </section><!-- .proj-page-section -->

                                                        <section class="proj-page-section">
                                                    
                                                            <div id="especialidad-container">
                                                                    
                                                            </div>
                                                        
                                                        </section><!-- .box-typical.steps-icon-block -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <section class="proj-page-section proj-page-header">
                                                            <div class="title">
                                                                Datos Laborales
                                                            </div>
                                                        </section><!-- .proj-page-section -->

                                                        <section class="proj-page-section">
                                                    
                                                            <div id="trabajo-container">
                                                                    
                                                            </div>
                                                        
                                                        </section><!-- .box-typical.steps-icon-block -->
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div id="documentos-container">

                                                    
                                                    </div>
                                                </div>
                                             
                                                 
                                        </section><!-- .box-typical.steps-icon-block -->

                                      

                                    </form>
                                </div><!-- .row -->
                            </div><!-- .container-fluid -->
                        </section><!-- .box-typical.proj-page -->
                    </div><!-- .col-xxl-9.col-lg-12.col-xl-8.col-md-8 -->

                    <div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
                        <section class="box-typical proj-page">

                            <section class="proj-page-section">
                                <ul class="proj-page-actions-list">
                                    <li onclick="guardarDatosProfesionales()" id="guardar_datos_btn"><a><i
                                                class="font-icon font-icon-check-square"></i>Guardar cambios</a></li>
                                    <li><a class="cancelar" href="../home/"><i class="glyphicon glyphicon-trash"></i>
                                            Cancelar</a></li>
                                </ul>
                            </section><!--.proj-page-section-->
                        </section><!--.proj-page-->
                    </div>

   


                </div><!--.row-->
            </div><!--.container-fluid-->
        </div><!--.page-content-->
        <!-- Contenido -->

        <?php require_once ("../MainJs/js.php"); ?>
        <script type="text/javascript" src="perfil_profesional.js?v=<?php echo time(); ?>"></script>
        <?php require_once ("../html/footer.php"); ?>

    </body>

    </html>
    <?php
} else {
    header("Location:" . Conectar::ruta() . "index.php");
}
?>