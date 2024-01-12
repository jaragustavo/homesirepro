

<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <title>SIREPRO | Home</title>
    <?php require_once("../MainHead/head.php"); ?>

    <!-- jsvectormap css -->
    <!-- <link href="../../assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" /> -->

    <!--Swiper slider css-->
    <!-- <link href="../../assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" /> -->

    <!--HelpDesk-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<link rel="stylesheet" href="../../public/css/lib/fullcalendar/fullcalendar.min.css">
	<link rel="stylesheet" href="../../public/css/separate/pages/calendar.min.css">
	<!-- <link rel="stylesheet" href="../../public/css/main.css"> -->
</head>

<body class="with-side-menu">
    <div class="mobile-menu-left-overlay"></div>
    <?php require_once("../MainHeader/header.php"); ?>
	<?php require_once("../MainNav/nav.php"); ?>
	<!-- Contenido -->
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-12">
					<div class="row">
						<div class="col-sm-4">
	                        <article class="statistic-box green">
	                            <div>
	                                <div class="number" id="lbltotal">15</div>
	                                <div class="caption"><div>Investigaciones Cientificas</div></div>
	                            </div>
	                        </article>
	                    </div>
						<div class="col-sm-4">
	                        <article class="statistic-box yellow">
	                            <div>
	                                <div class="number" id="lbltotalabierto">106</div>
	                                <div class="caption"><div>Reposos emitidos</div></div>
	                            </div>
	                        </article>
	                    </div>
						<div class="col-sm-4">
	                        <article class="statistic-box red">
	                            <div>
	                                <div class="number" id="lbltotalcerrado">31/05/2024<div>
	                                <div class="caption"><div>Vencimiento de registro</div></div>
	                            </div>
	                        </article>
	                    </div>
					</div>
				</div>
			</div>

			<!-- <section class="card">
				<header class="card-header">
					Bar Chart
				</header>
				<div class="card-block">
					<div id="bar-chart"></div>
				</div>
			</section> -->

			<section class="card">
				<header class="card-header">
					Grafico Estadístico
				</header>
				<div class="card-block">
					<div id="divgrafico" style="height: 250px;"></div>
				</div>
			</section>


			<!-- <section class="card">
				<header class="card-header">
					Calendario
				</header>
				<div class="card-block">
					<div id="idcalendar"></div>
				</div>
			</section> -->
			

		</div>
	</div>
	<!-- Contenido -->

	<?php require_once("../MainJs/js.php");?>

	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

	<script type="text/javascript" src="../../public/js/lib/moment/moment-with-locales.min.js"></script>
	<script src="../../public/js/lib/fullcalendar/fullcalendar.min.js"></script>

	<script type="text/javascript" src="home.js"></script>

	<!-- <script type="text/javascript" src="../notificacion.js"></script> -->
	<?php require_once("../html/footer.php"); ?>
</body>

</html>
<?php
    //     }else{
    //         header("Location:".Conectar::ruta()."view/404/");
    //     }
    // }else{
    //     header("Location:".Conectar::ruta()."view/404/");
    // }
?>