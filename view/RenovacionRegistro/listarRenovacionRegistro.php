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
							<h3>Renovación</h3>
							<ol class="breadcrumb breadcrumb-simple">
							<li><a href="../home/">Inicio</a></li>
								<li class="active">Renovación de Registro Profesional</li>
							</ol>
						</div>
						<div class="tbl-cell">
					</div>
				</div>
			</header>
			<header class="box-typical box-typical-padding">
				<div class="form-group">
					<p>
						En este listado se encuentran todas las renovaciones que realizo de su registro profesional en 
						la Dirección General de Control de Profesiones, Establecimientos y Tecnología de la Salud
						del MSPBS.
					</p>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				
				<div class="row">
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="tid">Nro.Transacción</label>
							<input type="text" placeholder="Nro.Transacciòn" class="form-control" id="tid" name="tid">

						</fieldset>
					</div>
					
					<div class="col-lg-2">
						<fieldset class="form-group">
							<label class="form-label" for="trn_dat">Fecha</label>
							<input type="date" placeholder="DD-MM-YYYY" class="form-control" id="trn_dat" name="trn_dat">
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
								<th style="width: 5%;">Nro.Transacción</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Cédula de Indentidad</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Nro.Registro Profesional</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Nro.Verificación</th>
								<th class="d-none d-sm-table-cell" style="width: 10%;">Fecha Transación</th>
								<!-- <th class="d-none d-sm-table-cell" style="width: 10%;">Editar Perfil</th> -->
								<th class="d-none d-sm-table-cell" style="width: 10%;">Generar PDF</th>
								<!-- <th class="d-none d-sm-table-cell" style="width: 1%;">Días de reposo</th> -->
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

	<script type="text/javascript" src="renovacionRegistro.js?v=<?php echo time();?>"></script>
	<?php require_once("../html/footer.php");?>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>