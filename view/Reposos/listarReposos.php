<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usuario_id"])){ 
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php");?>
	<title>Sirepro::Reposos</title>
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
							<h3>Reposos Emitidos</h3>
							<ol class="breadcrumb breadcrumb-simple">
							<li><a href="../home/">Inicio</a></li>
								<li class="active">Reposos Emitidos</li>
							</ol>
						</div>
						<div class="tbl-cell">
					</div>
				</div>
			</header>
			<header class="box-typical box-typical-padding">
				<div class="form-group">
					<p>
						En este listado se encuentran solamente aquellos reposos que fueron visados
						por la Dirección General de Control de Profesiones, Establecimientos y Tecnología de la Salud
						del MSPBS.
					</p>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				
				<div class="row">
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="ci_paciente">CI paciente</label>
							<input type="text" placeholder="Cédula de Identidad" class="form-control" id="ci_paciente" name="ci_paciente">

						</fieldset>
					</div>
					<div class="col-lg-3">
						<fieldset class="form-group">
							<label class="form-label" for="institucion_educativa">Nombre paciente</label>
							<input type="text" placeholder="Nombre y apellido" class="form-control" id="nombre_paciente" name="nombre_paciente">
						</fieldset>
					</div>
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="fecha_inicio_reposo">Fecha inicio</label>
							<input type="date" placeholder="DD-MM-YYYY" class="form-control" id="fecha_inicio_reposo" name="fecha_inicio_reposo">
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
				</div>

				<div class="box-typical box-typical-padding" id="table">
					<table id="reposos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
						<thead>
							<tr>
								<th style="width: 5%;">Cédula paciente</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Nombre y Apellido</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha inicio</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha fin</th>
								<th class="d-none d-sm-table-cell" style="width: 1%;">Días de reposo</th>
								<!-- <th class="d-none d-sm-table-cell" style="width: 1%;">Acciones</th> -->
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

	<script type="text/javascript" src="reposos.js?v=<?php echo time();?>"></script>
	<?php require_once("../html/footer.php");?>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>