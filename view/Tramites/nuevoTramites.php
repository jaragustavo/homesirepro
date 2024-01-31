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
								<p>En la sección de abajo, verá los documentos que se requieren adjuntar para presentar
									la solicitud de forma completa. Además, asegúrese de completar correctamente
									el formulario correspondiente.
									<br>De no completar la totalidad de lo necesario para la solicitud, podrá guardar
									la solicitud como borrador.
								</p>
							</div>
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<header class="proj-page-subtitle with-del">
								<h3>Documentos requeridos</h3>
							</header>
							<div class="form-group" id="documentos_requeridos">
							</div>
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<header class="proj-page-subtitle">
								<h3>Carga de archivos</h3>
							</header>
							<div class="drop-zone">
								<i class="font-icon font-icon-cloud-upload-2"></i>
								<div class="drop-zone-caption">Arrastre aquí su archivo</div>
								<span class="btn btn-rounded btn-file">
									<span>Elegir archivo</span>
									<input type="file" name="files[]" multiple>
								</span>
							</div>
							<ul class="uploading-list">
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
						</section><!--.proj-page-section-->

						<section class="proj-page-attach-section scrollable-block">
							<div class="proj-page-attach-section-in">
								<header class="proj-page-subtitle">
									<h3>Adjuntos</h3>
								</header>
								<div class="proj-page-attach-grid">
									<div class="gd-doc">
										<div class="gd-doc-preview">
											<a href="#">
												<img src="img/doc.jpg" alt="">
												<span class="icon"><i class="font-icon font-icon-downloaded"></i></span>
											</a>
										</div>
										<div class="gd-doc-title">History Class Final</div>
										<div class="gd-doc-date">05/30/2014</div>
									</div>
									<div class="gd-doc">
										<div class="gd-doc-preview">
											<a href="#">
												<img src="img/doc.jpg" alt="">
												<span class="icon"><i class="font-icon font-icon-downloaded"></i></span>
											</a>
										</div>
										<div class="gd-doc-title">History Class Final</div>
										<div class="gd-doc-date">05/30/2014</div>
									</div>
								</div>
							</div>
						</section><!--.proj-page-attach-section-->

						<section class="proj-page-section">
							<header class="proj-page-subtitle">
								<h3>Attachments 2</h3>
							</header>
							<div class="proj-page-attach">
								<i class="font-icon font-icon-pdf"></i>
								<p class="name">Concept and UX.pdf</p>
								<p class="date">16:48, 02 dec 2016</p>
								<p>
									<a href="#">View</a>
									<a href="#">Download</a>
								</p>
							</div>
							<div class="proj-page-attach">
								<i class="font-icon font-icon-cam-photo"></i>
								<p class="name">Concept and UX.jpg</p>
								<p class="date">16:48, 02 dec 2016</p>
								<p>
									<a href="#">View</a>
									<a href="#">Download</a>
								</p>
							</div>
						</section><!--.proj-page-attach-section-->
					</section><!--.proj-page-->
				</div>

				<div class="col-xxl-3 col-lg-12 col-xl-4 col-md-4">
					<section class="box-typical proj-page">
						<section class="proj-page-section proj-page-time-info">
							<div class="tbl">
								<div class="tbl-row">
									<div class="tbl-cell">Tiempo estimado</div>
									<div class="tbl-cell tbl-cell-time">48 hs
									</div>
								</div>
								<!-- <div class="tbl-row">
									<div class="tbl-cell">Time working</div>
									<div class="tbl-cell tbl-cell-time">2h 10m</div>
								</div> -->
							</div>
							<!-- <div class="progress-compact-style">
								<progress class="progress progress-success" value="65" max="100">65%</progress>
							</div> -->
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<ul class="proj-page-actions-list">
								<li><a href="#"><i class="font-icon font-icon-check-square"></i>Enviar solicitud</a></li>
								<li><a href="#"><i class="font-icon font-icon-archive"></i>Guardar solicitud</a></li>
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

	<script type="text/javascript" src="tramites.js"></script>
	<?php require_once("../html/footer.php");?>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>