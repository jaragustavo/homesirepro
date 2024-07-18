<?php
require_once("../../config/conexion.php");
if (isset($_SESSION["usuario_id"])) {
	?>

	<!doctype html>
	<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
		data-sidebar-image="none">

	<head>
		<title>SIREPRO | Home</title>
		<?php require_once("../MainHead/head.php"); ?>
		<link rel="stylesheet" href="../../public/css/separate/vendor/slick.min.css">
		<link rel="stylesheet" href="../../public/css/separate/pages/profile.min.css">

	</head>

	<body class="with-side-menu">
		<div class="mobile-menu-left-overlay"></div>
		<?php require_once("../MainHeader/header.php"); ?>
		<?php require_once("../MainNav/nav.php"); ?>

		<div class="page-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-3 col-lg-pull-6 col-md-6 col-sm-6">
						<section class="box-typical">
							<div class="profile-card">
								<div class="avatar-preview avatar-preview-128">
									<img src="https://sirepro.mspbs.gov.py/foto/<?php echo $_SESSION["cedula"] ?>.jpg" alt="" />
								</div>
								<div class="profile-card-name"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"] ?></div>
								<div class="profile-card-status">Enfermera</div>
								<div class="profile-card-location">IPS Central</div>

						
						</section><!--.box-typical-->

						<section class="box-typical">
							<?php
							require_once("../../models/Usuario.php");
							$usuarios = Usuario::get_usuarios($_SESSION["usuario_id"]);
							?>
							<header class="box-typical-header-sm">
								Amigos
								&nbsp;
								<a href="#" class="full-count">
									<?php echo count($usuarios) ?>
								</a>
							</header>
							<div class="friends-list">
								<?php
								foreach ($usuarios as $usuario) {
									?>
									<article class="friends-list-item">
										<div class="user-card-row">
											<div class="tbl-row">
												<div class="tbl-cell tbl-cell-photo">
													<a
														href="../Publicaciones/perfilUsuario.php?ID=<?php echo $usuario["id"] ?>">
														<img src="https://sirepro.mspbs.gov.py/foto/<?php echo $usuario["ci"] ?>.jpg"
															alt="">
													</a>
												</div>
												<div class="tbl-cell">
													<p class="user-card-row-name status-online"><a
															href="../Publicaciones/perfilUsuario.php?ID=<?php echo $usuario["id"] ?>">
															<?php echo $usuario["usuario"] ?>
														</a></p>
													<!-- <p class="user-card-row-location">New York</p> -->
												</div>
											</div>
										</div>
									</article>
									<?php
								}
								?>
							</div>
						</section><!--.box-typical-->
					</div><!--.col- -->

					<div class="col-lg-6 col-lg-push-3 col-md-12">
						<form class="box-typical" id="data_nuevo_post">
							<textarea rows="5" class="form-control" id="texto_publicacion" name="texto_publicacion" placeholder="¿Nueva publicación? Escriba algo..."></textarea>
							<div class="box-typical-footer">
								<div class="tbl">
									<div class="tbl-row">
										<div class="tbl-cell">
											<div class="tbl-cell">
												<button type="button" class="btn-icon" id="selectIconButton"
													title="Privacidad">
													<i class="font-icon font-icon-earth" id="icon"></i>
												</button>

												<select id="visibilitySelect" style="display:none">
													<option value="public">Público</option>
													<option value="private">Sólo para mí</option>
												</select>

												<script>
													document.getElementById('selectIconButton').addEventListener('click', function () {
														document.getElementById('visibilitySelect').setAttribute('style', 'display:true');
														document.getElementById('visibilitySelect').click();
													});

													document.getElementById('visibilitySelect').addEventListener('change', function () {
														var selectedValue = this.value;
														var iconElement = document.getElementById('icon');

														// Change the icon based on the selected option
														if (selectedValue === 'public') {
															iconElement.className = 'font-icon font-icon-earth';
														} else if (selectedValue === 'private') {
															// Assuming there is an icon class for the user, replace 'font-icon-user' with the appropriate class
															iconElement.className = 'font-icon font-icon-user';
														}
														document.getElementById('visibilitySelect').setAttribute('style', 'display:none');
													});
												</script>
												<button type="button" class="btn-icon" id="choosePhotoBtn"
													title="Adjuntar archivos">
													<i class="font-icon font-icon-clip"></i>
													<input type="file" id="photoInput" style="display: none;"
														multiple />
												</button>

												<button type="button" class="btn-icon" id="selectIconButton"
													title="Tipo de publicación">
													<i class="font-icon font-icon-notebook-lines" id="icon"></i>
												</button>
												<select id="visibilitySelect" style="display:none">
													<option value="publicacion">Publicación Científica</option>
													<option value="investigacion">Investigación</option>
													<option value="articulo">Artículo</option>
													<option value="articulo">Posteo</option>
												</select>
												<div class="" style="padding:5px;">Adjuntos</div>
												<div id="filePreviewContainer" class="file-preview-container"></div>


											</div>
										</div>


									</div>
									<div class="tbl-row">
										<div class="tbl-cell tbl-cell-action">
											<button type="button" class="btn btn-rounded" onclick="postear()"
											style="float:right; margin-left: 5px;">Postear</button>
											<!-- <button type="button" class="btn btn-secondary btn-rounded" onclick="window.location.reload();"
											style="float:right;">Descartar</button> -->
										</div>
										
									</div>

								</div>
							</div>
						</form><!--.box-typical-->
						
						<section class="box-typical">
							<?php
							require("../Publicaciones/publicaciones.php");
							?>
						</section>

					</div><!--.col- -->

					<div class="col-lg-3 col-md-6 col-sm-6">
						
					</div><!--.col- -->
				</div><!--.row-->
			</div><!--.container-fluid-->
		</div><!--.page-content-->

		<?php require_once("../MainJs/js.php"); ?>
		<script src="../MainJs/file-uploading.js"></script>
		<script src="../Publicaciones/publicaciones.js"></script>
		<script src="../../public/js/lib/slick-carousel/slick.min.js"></script>

		<?php require_once("../html/footer.php"); ?>
	</body>

	</html>
	<?php
} else {
	header("Location:" . Conectar::ruta() . "index.php");
}
?>