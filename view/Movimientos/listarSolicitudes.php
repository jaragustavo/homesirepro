<?php
require_once("../../config/conexion.php"); 
if(isset($_SESSION["usuario_id"])){ 
?>
<!DOCTYPE html>
<html>
		<?php require_once("../MainHead/head.php");?>
        <link rel="stylesheet" href="../../public/css/lib/bootstrap-table/bootstrap-table.min.css">

		<title>Solicitudes</title>
	</head>
<style>

    .tableFixHead thead th {
    position: sticky;
    top: 0;
    }
</style>
    <body class="with-side-menu">
        <?php require_once("../MainHeader/header.php");?>

        <div class="mobile-menu-left-overlay"></div>

        <?php require_once("../MainNav/nav.php");?>

        <!-- Contenido -->
        <div class="page-content">
            <div class="container-fluid">
                <section class="box-typical box-typical-max-280 scrollable">
                    <header class="box-typical-header">
                        <div class="tbl-row">
                            <div class="tbl-cell tbl-cell-title">
                                <h3>Trámites en Fiscalización</h3>
                            </div>
                            <div class="tbl-cell" style="float: right;">
                            <button type="button" class="btn btn-rounded btn-success" 
                            onclick="asignarmeTramites()" id="asignarme">Asignarme</button>
                            </div>
                        </div>
                    </header>
                    <div class="box-typical-body" id="solicitudes_area">
                        <div class="table-responsive tableFixHead">
                            <table class="table table-hover" id="solicitudes_area_data">
                            
                                <?php
                                    require_once("tablasSolicitudesArea.php"); 
                                ?>
                            </table>
                        </div>
                    </div><!--.box-typical-body-->
                </section><!--.box-typical-->
                <section class="box-typical box-typical-max-280 scrollable">
                    <header class="box-typical-header">
                        <div class="tbl-row">
                            <div class="tbl-cell tbl-cell-title">
                                <h3>Solicitudes asignadas a mí</h3>
                            </div>
                        </div>
                    </header>
                    <div class="box-typical-body" id="solicitudes_asignadas_a_mi">
                    <div class="table-responsive">
                            <table class="table table-hover" id="solicitudes_asignadas_a_mi_data">
                                    
                                    <?php
                                        require_once("tablasSolicitudesUsuario.php"); 
                                    ?>
                            </table>
                        </div>
                    </div><!--.box-typical-body-->
                </section><!--.box-typical-->
            </div>
        </div>
        <?php require_once("../MainJs/js.php");?>
        <script src="../../public/js/lib/peity/jquery.peity.min.js"></script>
        <script src="../../public/js/lib/table-edit/jquery.tabledit.min.js"></script>
        <script type="text/javascript" src="movimientos.js?v=<?php echo time();?>"></script>
        <?php require_once("../html/footer.php");?>
    </body>
</html>
<?php
} else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>