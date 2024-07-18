<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usuario_id"])) {
	?>
	<!DOCTYPE html>
	<html>
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
									Revisión de solicitud
									<i class="font-icon font-icon-pencil"></i>
								</div>
								<div class="project">Trámite: <a href="#" class="tramite_nombre"></a></div>
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
									<div class="row">
										<div class="col-md-6">
											<h3>Documentos presentados</h3>
										</div>
										<div class="col-md-5">
											<h3>Observación del documento</h3>
										</div>
									</div>

								</header>
								<div class="form-group" id="documentos_presentados">
									<input type="hidden" id="tramite_id">
									<!-- <div class="form-group"> -->
									<div class="row" style="margin-left:25px;">

										<?php
										require_once "../../models/Movimiento.php";

										$id = rawurldecode($_GET['ID']);
										$id = str_replace(' ', '+', $id);
										$key = "mi_key_secret";
										$cipher = "aes-256-cbc";
										$iv_dec = substr(base64_decode($id), 0, openssl_cipher_iv_length($cipher));
										$cifradoSinIV = substr(base64_decode($id), openssl_cipher_iv_length($cipher));
										$decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
										$decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
										$tiposDocumentos = Movimiento::revisar_solicitud($decifrado);
										foreach ($tiposDocumentos as $key => $value) {
											?>
											<div class="row">
												<div class="col-md-5">
													<div class="proj-page-attach">
														<i class="font-icon font-icon-doc"></i>
														<p class="name">
															<?php echo $value["tipo_doc"] ?>
														</p>
														<p class="date">
															<?php echo $value["hora_formato_doc"] . ", " . $value["fecha_formato_doc"] ?>
														</p>
														<p>
															<a href="<?php echo '../' . $value["documento"] ?>">Ver</a>
															<a href="#">Descargar</a>
														</p>
													</div>
												</div>
												<div class="col-md-6">
													<select class="form-control estado_documento"
														id="estado_documento<?php echo $value["documento_id"] ?>"
														name="estado_documento" data-placeholder="Estado del documento">
														<option label="Observación del documento"></option>
														<?php
														$datos = Movimiento::get_estados_documentos_id();
														$html = "";

														if (is_array($datos) && count($datos) > 0) {
															foreach ($datos as $row) {
																$selected = ($row['estado_documento_id'] == $value["estado_doc_id"]) ? 'selected' : '';
																$html .= "<option value='" . $row['estado_documento_id'] . "' $selected>" . $row['estado_documento'] . "</option>";
															}
															echo $html;
														}
														?>
													</select>
												</div>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							</section><!--.proj-page-section-->
							<section class="proj-page-section">
								<label class="form-label semibold" for="observacion">Observaciones a notificar al
									solicitante</label>
								<div class="summernote-theme-1">
									<textarea id="observacion" name="observacion" class="summernote" name="name"></textarea>
								</div>
							</section>
						</section><!-- box-typical proj-page -->
					</div>

					<div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
						<section class="box-typical proj-page">

							<section class="proj-page-section">
								<ul class="proj-page-actions-list">
									<li onclick="aprobarSolicitud(10, 1)"><a><i class="glyphicon glyphicon-check"></i>
											Aprobar
											Solicitud</a></li>
									<li onclick="enviarObservaciones()"><a><i class="glyphicon glyphicon-send"></i> Enviar
											Observaciones</a></li>
									<li><a class="cancelar" href="listarSolicitudes.php"><i
												class="glyphicon glyphicon-remove"></i> Cancelar</a></li>
								</ul>
							</section><!--.proj-page-section-->
						</section><!--.proj-page-->
					</div>
				</div><!--.row-->
			</div><!--.container-fluid-->
		</div><!--.page-content-->
		<!-- Contenido -->

		<?php require_once("../MainJs/js.php"); ?>
		<script type="text/javascript" src="movimientos.js?v=<?php echo time(); ?>"></script>
		<?php require_once("../html/footer.php"); ?>

	</body>

	</html>
	<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>