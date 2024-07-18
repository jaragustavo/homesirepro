<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usuario_id"])) {
	?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" href="plugins/dropzone/dropzone.css" type="text/css">
	<?php require_once("../MainHead/head.php"); ?>

	<!-- <link rel="stylesheet" href="plugins/css/dropzone.css"> -->

	<title>Trámites</title>
	</head>
	<style>
		#parte_2,
		#parte_3,
		#parte_4,
		#parte_5,
		#parte_6,
		#parte_7,
		#progress-5,
		#progress-6,
		#progress-7 {
			display: none;
		}
	</style>

	<body class="with-side-menu">

		<?php require_once("../MainHeader/header.php"); ?>

		<div class="mobile-menu-left-overlay"></div>

		<?php require_once("../MainNav/nav.php"); ?>

		<!-- Contenido -->
		<div class="page-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xxl-9 col-lg-12 col-xl-8 col-md-8">
						<section class="box-typical proj-page">
							<section class="proj-page-section proj-page-header">
								<div class="title">
									Nueva solicitud
									<i class="font-icon font-icon-pencil"></i>
								</div>
								<div class="project">Trámite: <a href="#" class="tramite_nombre"></a></div>
							</section><!--.proj-page-section-->

							<section class="proj-page-section">

								<div class="proj-page-txt">
									<header class="proj-page-subtitle">
										<h3 class="tramite_nombre"></h3>
									</header>
									<p>Asegúrese de completar correctamente el formulario a que se encuentra a
										continuación.<br>
										En la siguiente sección, verá los documentos que se requieren adjuntar para
										presentar
										la solicitud de forma completa.<br>
										Si desea completar la solicitud en otro momento, puede guardarla como borrador.
									</p>
								</div>
							</section><!--.proj-page-section-->

							<!-- formulario -->
							<div class="container-fluid">
								<div class="row">
									<form method="post" id="inscripcion_registro_form">
										<input type="hidden" id="idEncrypted" name="idEncrypted">
										<input type="hidden" id="tramite_code" name="tramite_code">
										<?php
											require_once "../Formularios/formularioTramite.php";
										?>
									</form>
								</div><!--.row-->
							</div><!--.container-fluid-->

							<!-- listado de documentos requeridos -->
							<section class="proj-page-section">
								<header class="proj-page-subtitle with-del">
									<h3>Documentos requeridos</h3>
								</header>
								<?php
								require_once "tramiteDocumento.php";
								?>
							</section><!--.proj-page-section-->
						</section><!-- box-typical proj-page -->
					</div>

					<div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
						<section class="box-typical proj-page">
							<section class="proj-page-section proj-page-time-info">
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell">Tiempo estimado a partir de la aprobación de la solicitud:
										</div>
										<div class="tbl-cell tbl-cell-time">48 hs
										</div>
									</div>
								</div>
							</section><!--.proj-page-section-->

							<section class="proj-page-section">
								<ul class="proj-page-actions-list">
									<li onclick="guardarDocsTramites(7)"><a><i
												class="font-icon font-icon-archive"></i>Guardar borrador</a></li>
									<li onclick="enviarSolicitud(6)"><a><i
												class="font-icon font-icon-check-square"></i>Enviar solicitud</a></li>
									<li><a class="cancelar" href="listarTramites.php"><i
												class="glyphicon glyphicon-trash"></i> Cancelar</a></li>
								</ul>
							</section><!--.proj-page-section-->
						</section><!--.proj-page-->
					</div>
				</div><!--.row-->
			</div><!--.container-fluid-->
		</div><!--.page-content-->
		<!-- Contenido -->

		<?php require_once("../MainJs/js.php"); ?>
		<script src="plugins/dropzone/dropzone.js"></script>
		<script type="text/javascript" src="tramites.js?v=<?php echo time(); ?>"></script>
		<?php require_once("../html/footer.php"); ?>

	</body>

	</html>
	<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>