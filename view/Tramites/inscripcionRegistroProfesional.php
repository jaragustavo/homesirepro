<?php
	$tipoDoc = 'P';
	require_once("../../config/conexion.php"); 
	if(isset($_SESSION["usuario_id"])){ 
?>
<!DOCTYPE html>
<html>
		<link rel="stylesheet" href="plugins/dropzone/dropzone.css" type="text/css">
		<?php require_once("../MainHead/head.php");?>
		
		<!-- <link rel="stylesheet" href="plugins/css/dropzone.css"> -->

		<title>Trámites</title>
	</head>
<style>
	#residencia_permanente,#pasantia_rural,#libro_registros,#antecedentes_academicos,#post-grado,#confirmacion,#progress-5,#progress-6{
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
								<form method="post" id="inscripcion_registro_form">
									<input type="hidden" id="idEncrypted" name="idEncrypted">
									<input type="hidden" id="tramite_code" name="tramite_code">

									<section class="box-typical steps-icon-block" id="formulario">
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
														<i class="glyphicon glyphicon-tree-deciduous"></i>
													</div>
													<div class="caption">Pasantía Rural</div>
												</li>
												<li id="progress-4">
													<div class="icon">
														<i class="glyphicon glyphicon-book"></i>
													</div>
													<div class="caption">Libro de Registros</div>
												</li>
												<li id="progress-5">
													<div class="icon">
														<i class="glyphicon glyphicon-education"></i>
													</div>
													<div class="caption">Antecedentes Académicos</div>
												</li>
												<li id="progress-6">
													<div class="icon">
														<i class="glyphicon glyphicon-education"></i>
													</div>
													<div class="caption">Post-grado</div>
												</li>
											</ul>
										</div>
										<!-- Información personal -->
										<div id="informacion_personal" class="row">
											<header class="steps-numeric-title">Información Personal</header>
											<div class="row">
												<div class="form-group">
													<div class="col-xl-6">
														<label for="documento_identidad"  style="text-align:left;margin:5px;margin-left:30px;">Documento de identidad</label>
														<input type="text" class="form-control" id="documento_identidad" name="documento_identidad" placeholder="Documento de identidad" value="<?php echo $_SESSION["cedula"] ?>"/>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">
													<div class="form-group">
														<label for="nacionalidad" style="text-align:left;margin:5px;margin-left:30px;">Nacionalidad</label>
														<input type="text" class="form-control" id="nacionalidad" name="nacionalidad" placeholder="Nacionalidad"/>
													</div>
													<div class="form-group">
														<label class="form-label" for="estado_civil"  style="text-align:left;margin:5px;margin-left:30px;">Estado Civil</label>
														<select class="form-control " id="estado_civil" name="estado_civil" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="año_inmigracion" style="text-align:left;margin:5px;margin-left:30px;">Año inmigracion</label>
														<input type="number" class="form-control" id="anio_inmigracion" name="anio_inmigracion" placeholder="Año inmigración"/>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">
													<div class="form-group">
														<label for="nombre" style="text-align:left;margin:5px;margin-left:30px;">Nombre completo</label>
														<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $_SESSION["nombre"] ?>" />
													</div>
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="apellido" style="text-align:left;margin:5px;margin-left:30px;">Apellido completo</label>
														<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo $_SESSION["apellido"] ?>"/>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">
													<div class="form-group">
														<label for="apellido_casada" style="text-align:left;margin:5px;margin-left:30px;">Apellido de casada</label>
														<input type="text" class="form-control" id="apellido_casada" name="apellido_casada" placeholder="Apellido de casada" />
													</div>
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="sexo" style="text-align:left;margin:5px;margin-left:30px;">Sexo</label>
														<div class="col-xl-6">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="radio-1" value="option1">
																<label for="radio-1">Femenino</label>
															</div>
														</div>
														<div class="col-xl-6">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="radio-2" value="option2" checked>
																<label for="radio-2">Masculino</label>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">
													<div class="form-group">
														<label for="fecha_nacimiento" style="text-align:left;margin:5px;margin-left:30px;">Fecha de nacimiento</label>
														<input type="date" class="form-control" placeholder=""/>
													</div>
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="pais" style="text-align:left;margin:5px;margin-left:30px;">País</label>
														<select class="form-control " id="pais" name="pais" onchange="cargarDptos()" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>
												</div>
											</div>		
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="departamento" style="text-align:left;margin:5px;margin-left:30px;">Departamento</label>
														<select class="form-control " id="departamento" name="departamento" onchange="cargarCiudades(this.id)" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="ciudad" style="text-align:left;margin:5px;margin-left:30px;">Ciudad</label>
														<select class="form-control " id="ciudad" name="ciudad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>
												</div>
											</div>
											
											<button type="button" class="btn btn-rounded float-right" id="next-1">Next →</button>
										</div>
										<!-- Información Personal -->
										<!-- Residencia permanente -->
										<div id="residencia_permanente">
											<header class="steps-numeric-title">Residencia Permantente</header>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="departamento_residencia" style="text-align:left;margin:5px;margin-left:30px;">Departamento</label>
														<select class="form-control " id="departamento_residencia" name="departamento_residencia" onchange="cargarCiudades(this.id)" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="ciudad_residencia" style="text-align:left;margin:5px;margin-left:30px;">Ciudad</label>
														<select class="form-control " id="ciudad_residencia" name="ciudad_residencia" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="calle" style="text-align:left;margin:5px;margin-left:30px;">Calle</label>
														<input type="text" class="form-control" id="calle" name="calle" placeholder="Calle principal, número de casa y calle secundaria" />
													</div>
												</div>
												
												<div class="col-xl-6">
													<label for="referencia" style="text-align:left;margin:5px;margin-left:30px;">Referencia</label>
													<textarea id="referencia" name="referencia" class="form-control summernote" placeholder="Escriba alguna referencia de su casa."></textarea>
												</div>													
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="barrio" style="text-align:left;margin:5px;margin-left:30px;">Barrio</label>
														<input type="text" class="form-control" id="barrio" name="barrio" placeholder="Barrio" />
													</div>
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="otro_barrio" style="text-align:left;margin:5px;margin-left:30px;">Otro barrio</label>
														<input type="text" class="form-control" id="otro_barrio" name="otro_barrio" placeholder="Otro barrio" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="telefono" style="text-align:left;margin:5px;margin-left:30px;">Teléfono</label>
														<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Barrio" value="<?php echo $_SESSION["telefono"] ?>" />
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="celular" style="text-align:left;margin:5px;margin-left:30px;">Celular</label>
														<input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="celular" style="text-align:left;margin:5px;margin-left:30px;">Celular</label>
														<input type="text" class="form-control" id="celular" name="celular" placeholder="Celular" />
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="email" style="text-align:left;margin:5px;margin-left:30px;">Email</label>
														<input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $_SESSION["email"] ?>" />
													</div>
												</div>
											</div>
											
											<button type="button" class="btn btn-rounded btn-grey float-left" id="back-1">← Back</button>
											<button type="button" class="btn btn-rounded float-right" id="next-2">Next →</button>
										</div>
										<!-- Residencia permanente -->
										<!-- Pasantía rural -->
										<div id="pasantia_rural">
											<header class="steps-numeric-title">Pasantía Rural</header>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="fecha_inicio_pasantia" style="text-align:left;margin:5px;margin-left:30px;">Fecha Inicio</label>
														<input type="date" class="form-control" id="fecha_inicio_pasantia" name="fecha_inicio_pasantia" placeholder="" />
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="fecha_fin_pasantia" style="text-align:left;margin:5px;margin-left:30px;">Fecha Fin</label>
														<input type="date" class="form-control" id="fecha_fin_pasantia" name="fecha_fin_pasantia" placeholder="" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="lugar_pasantia" style="text-align:left;margin:5px;margin-left:30px;">Lugar de la Pasantía</label>
														<input type="text" class="form-control" id="lugar_pasantia" name="lugar_pasantia" placeholder="Lugar donde se realizó la pasantía" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="extensión_pasantia" style="text-align:left;margin:5px;margin-left:30px;">Extensión de la Pasantía</label>
														<input type="checkbox" id="extensión_pasantia">
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="fecha_pasantia_cumplida" style="text-align:left;margin:5px;margin-left:30px;">Fecha Pasantía cumplida</label>
														<input type="date" class="form-control" id="fecha_pasantia_cumplida" name="fecha_pasantia_cumplida" placeholder="" />
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-rounded btn-grey float-left" id="back-2">← Back</button>
											<button type="button" class="btn btn-rounded float-right" id="next-3">Next →</button>
										</div>
										<!-- Pasantía rural -->
										<!-- Libro de registros -->
										<div id="libro_registros">
											<header class="steps-numeric-title">Experiencia Laboral</header>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="libro" style="text-align:left;margin:5px;margin-left:30px;">Libro</label>
														<input type="text" class="form-control" id="libro" name="libro" placeholder="Libro" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-4">		
													<div class="form-group">
														<label for="numero" style="text-align:left;margin:5px;">Número</label>
														<input type="text" class="form-control" id="numero" name="numero" placeholder="Número" />
													</div>
												</div>
												<div class="col-xl-4">		
													<div class="form-group">
														<label for="tomo" style="text-align:left;margin:5px;">Tomo</label>
														<input type="text" class="form-control" id="tomo" name="tomo" placeholder="Tomo" />
													</div>
												</div>
												<div class="col-xl-4">		
													<div class="form-group">
														<label for="folio" style="text-align:left;margin:5px;">Folio</label>
														<input type="text" class="form-control" id="folio" name="folio" placeholder="folio" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="observaciones" style="text-align:left;margin:5px;margin-left:30px;">Observaciones</label>
														<input type="text" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" />
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="nro_carnet" style="text-align:left;margin:5px;margin-left:30px;">Nro. Carnet</label>
														<input type="text" class="form-control" id="nro_carnet" name="nro_carnet" placeholder="Nro. Carnet" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="fecha_inscrip_renov" style="text-align:left;margin:5px;margin-left:30px;">Fecha Inscrip/Renov</label>
														<input type="date" class="form-control" id="fecha_inscrip_renov" name="fecha_inscrip_renov" placeholder="Fecha de inscripción o renovación" />
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="hora_inscrip_renov" style="text-align:left;margin:5px;margin-left:30px;">Hora</label>
														<input type="time" class="form-control" id="hora_inscrip_renov" name="hora_inscrip_renov" placeholder="Hora de inscripción o renovación" />
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-rounded btn-grey float-left" id="back-3">← Back</button>
											<button type="button" class="btn btn-rounded float-right" id="next-4">Next →</button>
										</div>
										<!-- Libro de registros -->
										<!-- Antecedentes Académicos -->
										<div id="antecedentes_academicos">
											<header class="steps-numeric-title">Antecedentes Académicos</header>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="profesion_acad" style="text-align:left;margin:5px;margin-left:30px;">Profesión</label>
														<select class="form-control " id="profesion_acad" name="profesion_acad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="titulo_acad" style="text-align:left;margin:5px;margin-left:30px;">Título</label>
														<select class="form-control " id="titulo_acad" name="titulo_acad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="institucion_acad" style="text-align:left;margin:5px;margin-left:30px;">Institución</label>
														<select class="form-control " id="institucion_acad" name="institucion_acad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="facultad_acad" style="text-align:left;margin:5px;margin-left:30px;">Facultad</label>
														<select class="form-control " id="facultad_acad" name="facultad_acad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="anio_expedicion_acad" style="text-align:left;margin:5px;margin-left:30px;">Año expedición</label>
														<input type="text" class="form-control" id="anio_expedicion_acad" name="anio_expedicion_acad" placeholder="Año" />
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-rounded btn-grey float-left" id="back-4">← Back</button>
											<button type="button" class="btn btn-rounded float-right" id="next-5">Next →</button>
										</div>
										<!-- Antecedentes Académicos -->
										<!-- Post-grado -->
										<div id="post-grado">
											<header class="steps-numeric-title">Post-grado</header>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="institucion_postgrado" style="text-align:left;margin:5px;margin-left:30px;">Institución</label>
														<select class="form-control " id="institucion_postgrado" name="institucion_postgrado" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="especialidad" style="text-align:left;margin:5px;margin-left:30px;">Especialidad</label>
														<select class="form-control " id="especialidad" name="especialidad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="sub_especialidad" style="text-align:left;margin:5px;margin-left:30px;">Sub-especialidad</label>
														<select class="form-control " id="sub_especialidad" name="sub_especialidad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-12">
													<div class="form-group">
														<label for="sexo" style="text-align:left;margin:5px;margin-left:30px;">Tipo</label>
														<div class="col-xl-4">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="especializacion" value="especializacion">
																<label for="especializacion">1.Especializacion</label>
															</div>
														</div>
														<div class="col-xl-4">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="masterado" value="masterado" checked>
																<label for="masterado">2.Masterado</label>
															</div>
														</div>
														<div class="col-xl-4">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="doctorado" value="doctorado" checked>
																<label for="doctorado">3.Doctorado</label>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="circulo" style="text-align:left;margin:5px;margin-left:30px;">Círculo</label>
														<select class="form-control " id="circulo" name="circulo" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>													
												</div>
												<div class="col-xl-6">
													<div class="form-group">
														<label for="sociedad" style="text-align:left;margin:5px;margin-left:30px;">Sociedad</label>
														<select class="form-control " id="sociedad" name="sociedad" data-placeholder="Seleccionar">
															<option label="Seleccionar"></option>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-6">
													<div class="form-group">
														<label for="rectificacion" style="text-align:left;margin:5px;margin-left:30px;">Rectificación</label>
														<div class="col-xl-4">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="si_rectificacion" value="si">
																<label for="si_rectificacion">Sí</label>
															</div>
														</div>
														<div class="col-xl-4">
															<div class="radio">
																<input type="radio" name="optionsRadios" id="no_rectificacion" value="no" checked>
																<label for="no_rectificacion">No</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-xl-6">		
													<div class="form-group">
														<label for="anio_rectificacion" style="text-align:left;margin:5px;margin-left:30px;">Año rectificacion</label>
														<input type="text" class="form-control" id="anio_rectificacion" name="anio_rectificacion" placeholder="Celular" />
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-rounded btn-grey float-left" id="back-5">← Back</button>
											<!-- <button type="button" class="btn btn-rounded float-right" id="next-6">Next →</button> -->
										</div>
										<!-- Post-grado -->
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
									<div class="tbl-cell">Tiempo estimado a partir de la aprobación de la solicitud:</div>
									<div class="tbl-cell tbl-cell-time">48 hs
									</div>
								</div>
							</div>
						</section><!--.proj-page-section-->

						<section class="proj-page-section">
							<ul class="proj-page-actions-list">
								<li onclick="guardarDocsTramites()"><a><i class="font-icon font-icon-check-square"></i>Guardar borrador</a></li>
								<li><a href="#"><i class="font-icon font-icon-archive" onclick="enviarSolicitud()"></i>Enviar solicitud</a></li>
								<li><a class="cancelar" href="listarTramites.php"><i class="glyphicon glyphicon-trash"></i>  Cancelar</a></li>
							</ul>
						</section><!--.proj-page-section-->
					</section><!--.proj-page-->
				</div>
			</div><!--.row-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>
	<script src="plugins/dropzone/dropzone.js"></script>
	<p><?php echo time();?></p>
	<script type="text/javascript" src="tramites.js?v=<?php echo time();?>"></script>
	<?php require_once("../html/footer.php");?>

</body>
</html>
<?php
  } else {
    header("Location:".Conectar::ruta()."index.php");
  }
?>