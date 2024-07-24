<?php
session_start();

// Generar el estado aleatorio
$state = bin2hex(random_bytes(16)); // Genera un string aleatorio de 16 bytes

// Guardar el estado en la sesión
$_SESSION['oauth2_state'] = $state;

 require_once ("portal/html/head.php") 

?>


</head>

<body class="rbt-header-sticky">

<?php require_once ("portal/html/header.php") ?>

<a class="close_side_menu" href="javascript:void(0);"></a>


    <main class="rbt-main-wrapper">
        <!-- Start Banner Area -->
        <div class="rbt-banner-area rbt-banner-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 pb--120 pt--70">
                        <div class="content">
                            <div class="inner">

                                <h1 class="title">
                                Bienvenido a HomeSirepro
                                </h1>
                                <p class="description">
                                Sistema informático para profesionales de la salud. Con HomeSirepro, podrás gestionar todos tus trámites y 
                                llevar un control detallado de los reposos a pacientes. ¡Optimiza tu tiempo y mejora tu eficiencia
                                con nuestras herramientas avanzadas!

                                </p>
                                <div class="slider-btn">
                                    <a class="rbt-btn btn-gradient hover-icon-reverse" href="portal/Profesionales/consultaRegistroProfesional.php">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Consultar profesionales</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="shape-wrapper" id="scene">
                                <img src="assets-main/images/banner/banner-02.png" alt="Hero Image">
                                <div class="hero-bg-shape-1 layer" data-depth="0.4">
                                    <img src="assets-main/images/shape/shape-01.png" alt="Hero Image Background Shape">
                                </div>
                                <div class="hero-bg-shape-2 layer" data-depth="0.4">
                                    <img src="assets-main/images/shape/shape-02.png" alt="Hero Image Background Shape">
                                </div>
                            </div>

                            <div class="banner-card pb--60 mb--50 swiper rbt-dot-bottom-center banner-swiper-active">
                                <div class="swiper-wrapper">
                                    <!-- Start Single Card  -->
                                    <div class="swiper-slide">
                                        <div class="rbt-card variation-01 rbt-hover">
                                            <div class="rbt-card-img">
                                                <a href="course-details.html">
                                                    <img src="assets-main/images/service/Crear_identidad_electronica.jpg" alt="Card image">
                                                </a>
                                            </div>
                                            <div class="rbt-card-body">
                                                <h4 class="rbt-card-title"><a href="" class="loginMtic">Acceso a HomeSirepro</a>
                                                </h4>
                                                <p class="rbt-card-text">Puede acceder mediante Identidad Electrónica</p>

                                                <div class="rbt-card-bottom">
                                                    <a class="rbt-btn-link" href="https://identidad.paraguay.gov.py/login?clientId=1&scope=read&responseType=code&state=3a8595b1-bd02-d4e7-0964-ad3efdeabcc0">Ir<i
                                                            class="feather-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Card  -->

                                    <!-- Start Single Card  -->
                                    <div class="swiper-slide">
                                        <div class="rbt-card variation-01 rbt-hover">
                                            <div class="rbt-card-img">
                                                <a href="course-details.html">
                                                    <img src="assets-main/images/service/tramites_en_linea.jpg" alt="Card image">
                                                </a>
                                            </div>
                                            <div class="rbt-card-body">
                                                <ul class="rbt-meta">
                                                    <li><i class="feather-book"></i>Registros Profesionales</li>
                                                    <li><i class="feather-users"></i>Constancias</li>
                                                </ul>
                                                <h4 class="rbt-card-title"><a href="course-details.html">Trámites en línea</a>
                                                </h4>
                                                <p class="rbt-card-text">Puede realizar trámites en línea desde el lugar en que se encuentre.</p>

                                                <div class="rbt-card-bottom">
                                                    <a class="rbt-btn-link" href="course-details.html">Saber más<i
                                                            class="feather-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Card  -->

                                    <!-- Start Single Card  -->
                                    <div class="swiper-slide">
                                        <div class="rbt-card variation-01 rbt-hover">
                                            <div class="rbt-card-img">
                                                <a href="course-details.html">
                                                    <img src="assets-main/images/service/reposo_medico.jpg" alt="Card image">
                                                </a>
                                            </div>
                                            <div class="rbt-card-body">
                                                <ul class="rbt-meta">
                                                    <li><i class="feather-book"></i>Reposos médicos</li>
                                                </ul>
                                                <h4 class="rbt-card-title"><a href="course-details.html">Reposos emitidos</a>
                                                </h4>
                                                <p class="rbt-card-text">Encuentre el historial de reposos emitidos visados por el Control de Profesiones.</p>
                                                <div class="rbt-card-bottom">
                                                    <a class="rbt-btn-link" href="course-details.html">Saber más<i
                                                                class="feather-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Card  -->

                                </div>
                                <div class="rbt-swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Banner Area -->

        <!-- Start About Area  -->
        <div class="rbt-about-area bg-color-white rbt-section-gapTop pb_md--80 pb_sm--80 about-style-1">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="thumbnail-wrapper">
                            <div class="thumbnail image-1">
                                <img data-parallax='{"x": 0, "y": -20}' src="assets-main/images/team/doctor1.jpg" alt="Education Images">
                            </div>
                            <div class="thumbnail image-2 d-none d-xl-block">
                                <img data-parallax='{"x": 0, "y": 60}' src="assets-main/images/team/dentist1.jpg" alt="Education Images">
                            </div>
                            <div class="thumbnail image-3 d-none d-md-block">
                                <img data-parallax='{"x": 0, "y": 80}' src="assets-main/images/team/doctor2.jpg" alt="Education Images">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="inner pl--50 pl_sm--0 pl_md--0">
                            <div class="section-title text-start">
                                <span class="subtitle bg-coral-opacity">Sobre HomeSirepro</span>
                                <h2 class="title">Conoce sobre la plataforma HomeSirepro</h2>
                            </div>

                            <p class="description mt--30">Los profesionales de salud en el Paraguay son personas que dan todo de sí por salvar vidas y estar al servicio constante de la ciudadanía.
                                <br><br>Por ello, se busca ofrecer una plataforma íntegra para todos los profesionales de salud, desde donde puedan realizar trámites en cualquier momento y lugar.
                            </p>
                            <div class="about-btn mt--40">
                                <a class="rbt-btn btn-gradient hover-icon-reverse" href="#">
                                    <span class="icon-reverse-wrapper">
                            <span class="btn-text">Más acerca de HomeSirepro</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Area  -->

        <!-- Start Counterup Area  -->
        <div class="rbt-counterup-area bg-color-extra2 rbt-section-gapBottom default-callto-action-overlap">
            <div class="container">
                <div class="row mb--60">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <span class="subtitle bg-primary-opacity">¿Por qué formar parte de HomeSirepro?</span>

                        </div>
                    </div>
                </div>
                <div class="row g-5 hanger-line">
                    <!-- Start Single Counter  -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                            <div class="top-circle-shape"></div>
                            <div class="inner">
                                <div class="rbt-round-icon">
                                    <img src="assets-main/images/icons/counter-01.png" alt="Icons Images">
                                </div>
                                <div class="content">
                                    <h3 class="counter"><span class="odometer" data-count="13000">00</span>
                                    </h3>
                                    <span class="subtitle">Profesionales inscriptos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Counter  -->

                    <!-- Start Single Counter  -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--60 mt_md--30 mt_sm--30 mt_mobile--60">
                        <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                            <div class="top-circle-shape"></div>
                            <div class="inner">
                                <div class="rbt-round-icon">
                                    <img src="assets-main/images/icons/counter-02.png" alt="Icons Images">
                                </div>
                                <div class="content">
                                    <h3 class="counter"><span class="odometer" data-count="4000">00</span>
                                    </h3>
                                    <span class="subtitle">Reposos visados</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Counter  -->

                    <!-- Start Single Counter  -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_md--60 mt_sm--60">
                        <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                            <div class="top-circle-shape"></div>
                            <div class="inner">
                                <div class="rbt-round-icon">
                                    <img src="assets-main/images/icons/counter-03.png" alt="Icons Images">
                                </div>
                                <div class="content">
                                    <h3 class="counter"><span class="odometer" data-count="1000">00</span>
                                    </h3>
                                    <span class="subtitle">Certificados expedidos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Counter  -->

                    <!-- Start Single Counter  -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--60 mt_md--60 mt_sm--60">
                        <div class="rbt-counterup rbt-hover-03 border-bottom-gradient">
                            <div class="top-circle-shape"></div>
                            <div class="inner">
                                <div class="rbt-round-icon">
                                    <img src="assets-main/images/icons/counter-04.png" alt="Icons Images">
                                </div>
                                <div class="content">
                                    <h3 class="counter"><span class="odometer" data-count="1500">00</span>
                                    </h3>
                                    <span class="subtitle">Trámites gestionados</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Counter  -->
                </div>
            </div>
        </div>
        <!-- End Counterup Area  -->

        

    </main>

    <?php require_once ('portal/html/footer.php'); ?>
    <?php require_once ('portal/html/js.php'); ?>
</body>

</html>