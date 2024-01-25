<?php
	$tipoDoc = 'P';
	require_once("../../config/conexion.php"); 
	if(isset($_SESSION["usuario_id"])){ 
	
?>
<!DOCTYPE html>
<html>
		<?php require_once("../MainHead/head.php");?>

		<title>Trámites</title>
	</head>
<style>
	#residencia_permanente,#formacion,#experiencia_laboral,#confirmacion,#progress-5{
		display:none;
	}
</style>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php");?>

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
								<p>Asegúrese de completar correctamente el formulario a que se encuentra a continuación.<br>
									En la siguiente sección, verá los documentos que se requieren adjuntar para presentar
									la solicitud de forma completa.<br>
									Si desea completar la solicitud en otro momento, puede guardarla como borrador.
								</p>
							</div>
						</section><!--.proj-page-section-->

						<!-- formulario -->
						<div class="container-fluid">
							<div class="row">
								<section class="box-typical steps-icon-block">
									<div class="steps-icon-progress">
										<ul>
											<li class="active" id="progress-1">
												<div class="icon">
													<i class="font-icon font-icon-notebook-lines"></i>
												</div>
												<div class="caption">Información Personal</div>
											</li>
											<li id="progress-2">
												<div class="icon">
													<i class="font-icon font-icon-home"></i>
												</div>
												<div class="caption">Residencia Permanente</div>
											</li>
											<li id="progress-3">
												<div class="icon">
													<i class="glyphicon glyphicon-education"></i>
												</div>
												<div class="caption">Formación</div>
											</li>
											<li id="progress-4">
												<div class="icon">
													<i class="font-icon font-icon-case-2"></i>
												</div>
												<div class="caption">Experiencia Laboral</div>
											</li>
											<li id="progress-5">
												<div class="icon">
													<i class="font-icon font-icon-ok"></i>
												</div>
												<div class="caption">Confirmación</div>
											</li>
										</ul>
									</div>
									<div id="informacion_personal">
										<header class="steps-numeric-title">Información Personal</header>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<button type="button" class="btn btn-rounded float-right" id="next-1">Next →</button>
									</div>
									<div id="residencia_permanente">
										<header class="steps-numeric-title">Residencia Permantente</header>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<button type="button" class="btn btn-rounded btn-grey float-left" id="back-1">← Back</button>
										<button type="button" class="btn btn-rounded float-right" id="next-2">Next →</button>
									</div>
									<div id="formacion">
										<header class="steps-numeric-title">Formación</header>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<button type="button" class="btn btn-rounded btn-grey float-left" id="back-2">← Back</button>
										<button type="button" class="btn btn-rounded float-right" id="next-3">Next →</button>
									</div>
									<div id="experiencia_laboral">
										<header class="steps-numeric-title">Experiencia Laboral</header>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Repeat password"/>
											</div>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="E-Mail"/>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password"/>
											</div>
										</div>
										<button type="button" class="btn btn-rounded btn-grey float-left" id="back-3">← Back</button>
										<button type="button" class="btn btn-rounded float-right" id="next-4">Next →</button>
									</div>
									<div id="confirmacion">
										<header class="steps-numeric-title">Confirmación</header>
										<div class="form-group">
											<button type="button" style="padding: 0;border: none;background: none;">
												<i class="glyphicon glyphicon-ok" style="font-size: 50px;color:#93C572;"></i>
											</button>
										</div>
										<button type="button" class="btn btn-rounded btn-grey float-left" id="back-4">← Back</button>
									</div>
								</section><!--.steps-icon-block-->
							</div><!--.row-->
						</div><!--.container-fluid-->

						<!-- listado de documentos requeridos -->
						<section class="proj-page-section">
							<header class="proj-page-subtitle with-del">
								<h3>Documentos requeridos</h3>
							</header>
							<div class="form-group" id="documentos_requeridos">
								<ul>
									<div class="row">
										<div class="col-md-4">
											<li>
												<b>Vida y residencia</b>
												<div class="drop-zone" style="">
													<i class="font-icon font-icon-cloud-upload-2"></i>
													<div class="drop-zone-caption">Arrastre aquí su archivo</div>
													<span class="btn btn-rounded btn-file">
														<span>Elegir archivo</span>
														<input type="file" name="files[]">
													</span>
												</div>
												<ul class="uploading-list" style="width:50%;">
													<li class="uploading-list-item">
														<div class="uploading-list-item-wrapper">
															<div class="uploading-list-item-name">
																<i class="font-icon font-icon-cam-photo"></i>
																photo.png
															</div>
															<div class="uploading-list-item-size">7,5 mb</div>
															<button type="button" class="uploading-list-item-close">
																<i class="font-icon-close-2"></i>
															</button>
														</div>
														<progress class="progress" value="25" max="100">
															<div class="progress">
																<span class="progress-bar" style="width: 25%;">25%</span>
															</div>
														</progress>
														<div class="uploading-list-item-progress">37% done</div>
														<div class="uploading-list-item-speed">90KB/sec</div>
													</li>
												</ul>
											</li>

										</div>
										<div class="col-md-4">
											<li>
												<b>Vida y residencia</b>
												<div class="drop-zone" style="">
													<i class="font-icon font-icon-cloud-upload-2"></i>
													<div class="drop-zone-caption">Arrastre aquí su archivo</div>
													<span class="btn btn-rounded btn-file">
														<span>Elegir archivo</span>
														<input type="file" name="files[]">
													</span>
												</div>
												<ul class="uploading-list" style="width:50%;">
													<li class="uploading-list-item">
														<div class="uploading-list-item-wrapper">
															<div class="uploading-list-item-name">
																<i class="font-icon font-icon-cam-photo"></i>
																photo.png
															</div>
															<div class="uploading-list-item-size">7,5 mb</div>
															<button type="button" class="uploading-list-item-close">
																<i class="font-icon-close-2"></i>
															</button>
														</div>
														<progress class="progress" value="25" max="100">
															<div class="progress">
																<span class="progress-bar" style="width: 25%;">25%</span>
															</div>
														</progress>
														<div class="uploading-list-item-progress">37% done</div>
														<div class="uploading-list-item-speed">90KB/sec</div>
													</li>
												</ul>
											</li>

										</div>
										<div class="col-md-4">
											<li>
												<b>Vida y residencia</b>
												<div class="drop-zone" style="">
													<i class="font-icon font-icon-cloud-upload-2"></i>
													<div class="drop-zone-caption">Arrastre aquí su archivo</div>
													<span class="btn btn-rounded btn-file">
														<span>Elegir archivo</span>
														<input type="file" name="files[]">
													</span>
												</div>
												<ul class="uploading-list" style="width:50%;">
													<li class="uploading-list-item">
														<div class="uploading-list-item-wrapper">
															<div class="uploading-list-item-name">
																<i class="font-icon font-icon-cam-photo"></i>
																photo.png
															</div>
															<div class="uploading-list-item-size">7,5 mb</div>
															<button type="button" class="uploading-list-item-close">
																<i class="font-icon-close-2"></i>
															</button>
														</div>
														<progress class="progress" value="25" max="100">
															<div class="progress">
																<span class="progress-bar" style="width: 25%;">25%</span>
															</div>
														</progress>
														<div class="uploading-list-item-progress">37% done</div>
														<div class="uploading-list-item-speed">90KB/sec</div>
													</li>
												</ul>
											</li>

										</div>
									</div>
												
								</ul>
							</div>
						</section><!--.proj-page-section-->

						
					</section><!--.proj-page-->
				</div>

				<div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
					<section class="box-typical proj-page">
						<section class="proj-page-section proj-page-time-info">
							<div class="tbl">
								<div class="tbl-row">
									<div class="tbl-cell">Tiempo estimado a partir de la aprobación de la solicitud:</div>
									<div class="tbl-cell tbl-cell-time">48 hs
									</div>
								</div>
							</div>
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<ul class="proj-page-actions-list">
								<li><a href="#"><i class="font-icon font-icon-check-square"></i>Enviar solicitud</a></li>
								<li><a href="#"><i class="font-icon font-icon-archive"></i>Guardar borrador</a></li>
								<li><a href="#"><i class="glyphicon glyphicon-trash"></i>  Cancelar</a></li>
							</ul>
						</section><!--.proj-page-section-->
					</section><!--.proj-page-->
				</div>
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>
	
	<script src="../../public/js/lib/bootstrap/bootstrap.bundle.min.js"></script>
	<script src="../../public/js/lib/bootstrap/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="../../public/js/lib/jquery/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="tramites.js"></script>
	<?php require_once("../html/footer.php");?>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>