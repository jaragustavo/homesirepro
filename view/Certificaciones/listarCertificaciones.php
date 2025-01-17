<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usuario_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Sirepro::Certificaciones</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php");?>

    <div class="mobile-menu-left-overlay"></div>
    
    <?php require_once("../MainNav/nav.php");?>

	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">

			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Certificaciones</h3>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">

				<!-- <div class="row">
					<div class="col-lg-4">
						<fieldset class="form-group">
							<label class="form-label" for="tramite">Curso</label>
							<select class="select2" id="tramite" name="tramite" data-placeholder="Seleccionar">
								<option label="Seleccionar"></option>

							</select>
						</fieldset>
					</div>
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="estado_tramite">Estado actual</label>
							<select class="select2" id="estado_tramite" name="estado_tramite" data-placeholder="Seleccionar">
								<option label="Seleccionar"></option>

							</select>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="btnfiltrar">&nbsp;</label>
							<button type="submit" class="btn btn-rounded btn-primary btn-block" id="btnfiltrar">Filtrar</button>
						</fieldset>
					</div>

					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="btntodo">&nbsp;</label>
							<button class="btn btn-rounded btn-primary btn-block" id="btntodo">Ver Todo</button>
						</fieldset>
					</div>
				</div> -->

				<div class="box-typical box-typical-padding" id="table">
					<table id="certificaciones_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 5%;">Curso</th>
								<th style="width: 5%;">Fecha de inscripción</th>
								<th class="d-none d-sm-table-cell" style="width: 10%">Estado actual</th>
								<th class="d-none d-sm-table-cell" style="width: 15%">Avance</th>
								<th class="d-none d-sm-table-cell" style="width: 5%;">Acciones</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>

			</div>

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script type="text/javascript" src="certificaciones.js?v=<?php echo time();?>"></script>
	<script src="dropzone/dropzone.js"></script>

	<?php require_once("../html/footer.php");?>

	<!-- <script type="text/javascript" src="../notificacion.js"></script> -->

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>