<?php
session_start();

// Generar el estado aleatorio
$state = bin2hex(random_bytes(16)); // Genera un string aleatorio de 16 bytes

// Guardar el estado en la sesión
$_SESSION['oauth2_state'] = $state;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HomeSirepro</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets-main/images/favicon.png">

    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="assets-main/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets-main/css/vendor/slick.css">
    <link rel="stylesheet" href="assets-main/css/vendor/slick-theme.css">
    <link rel="stylesheet" href="assets-main/css/plugins/sal.css">
    <link rel="stylesheet" href="assets-main/css/plugins/feather.css">
    <link rel="stylesheet" href="assets-main/css/plugins/fontawesome.min.css">
    <link rel="stylesheet" href="assets-main/css/plugins/euclid-circulara.css">
    <link rel="stylesheet" href="assets-main/css/plugins/swiper.css">
    <link rel="stylesheet" href="assets-main/css/plugins/magnify.css">
    <link rel="stylesheet" href="assets-main/css/plugins/odometer.css">
    <link rel="stylesheet" href="assets-main/css/plugins/animation.css">
    <link rel="stylesheet" href="assets-main/css/plugins/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets-main/css/plugins/jquery-ui.css">
    <link rel="stylesheet" href="assets-main/css/plugins/magnigy-popup.min.css">
    <link rel="stylesheet" href="assets-main/css/style.css">
</head>

<body class="rbt-header-sticky">

    <!-- Start Header Area -->
    <header class="rbt-header rbt-header-10">
        <div class="rbt-sticky-placeholder"></div>
        <!-- Start Header Top  -->
        <div class="rbt-header-top rbt-header-top-1 header-space-betwween bg-not-transparent bg-color-darker top-expended-activation">
            <div class="container-fluid">
                <div class="top-expended-wrapper">
                    <div class="top-expended-inner rbt-header-sec align-items-center ">
                        <div class="rbt-header-sec-col rbt-header-left d-none d-xl-block">
                            <div class="rbt-header-content">
                                <!-- Start Header Information List  -->
                                <div class="header-info">
                                    <ul class="rbt-information-list">
                                        <li>
                                            <a href="https://www.facebook.com/controldeprofesiones/"><i class="fab fa-facebook-square"></i>3k <span class="d-none d-xxl-block">Seguidores</span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>(021) 237 4000</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Header Information List  -->
                            </div>
                        </div>
                        <div class="rbt-header-sec-col rbt-header-center">
                            <div class="rbt-header-content justify-content-start justify-content-xl-center">
                                <div class="header-info">
                                    <div class="rbt-header-top-news">
                                        <div class="inner">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rbt-header-sec-col rbt-header-right mt_md--10 mt_sm--10">
                            <div class="rbt-header-content justify-content-start justify-content-lg-end">
                                <div class="header-info d-none d-xl-block">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="header-info">
                        <div class="top-bar-expended d-block d-lg-none">
                            <button class="topbar-expend-button rbt-round-btn"><i class="feather-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top  -->
        <div class="rbt-header-wrapper header-space-betwween header-sticky">
            <div class="container-fluid">
                <div class="mainbar-row rbt-navigation-center align-items-center">
                    <div class="header-left rbt-header-content">
                        <div class="header-info">
                            <div class="logo">
                                <a href="index.html">
                                    <img src="assets/images/logo1_sirepro.jpg" alt="Sirepro">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="rbt-main-navigation d-none d-xl-block">
                        <nav class="mainmenu-nav">
                            <ul class="mainmenu">
                                <li class="with-megamenu has-menu-child-item position-static">
                                    <a href="#">Inicio</a>
                                </li>

                                <li class="with-megamenu has-menu-child-item">
                                    <a href="#">Trámites en línea <i class="feather-chevron-down"></i></a>
                                    <!-- Start Mega Menu  -->
                                    <div class="rbt-megamenu grid-item-2">
                                        <div class="wrapper">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mega-top-banner">
                                                        <div class="content">
                                                            <h4 class="title">Trámites</h4>
                                                            <p class="description">Realice trámites desde cualquier lugar y de manera más efectiva.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row--15">
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <h3 class="rbt-short-title">Registro Profesional</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="course-filter-one-toggle.html">Inscripción</a></li>
                                                        <li><a href="course-filter-one-open.html">Renovación</a></li>
                                                        <li><a href="course-filter-two-toggle.html">Reexpedición</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <h3 class="rbt-short-title">Expedición de documentos</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="course-card-2.html">Constancias</a></li>
                                                        <li><a href="course-card-3.html">Recertificación de especialidad</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Mega Menu  -->
                                </li>

                                <li class="has-dropdown has-menu-child-item">
                                    <a href="#">Funcionalidades
                                        <i class="feather-chevron-down"></i>
                                    </a>
                                    <ul class="submenu">
                                        <li class="has-dropdown"><a href="#">Profesional de Salud</a>
                                            <ul class="submenu">
                                                <li><a href="student-dashboard.html">Inicio</a></li>
                                                <li><a href="student-profile.html">Perfil</a></li>
                                                <li><a href="student-enrolled-courses.html">Trámites en línea</a></li>
                                                <li><a href="student-wishlist.html">Reposos emitidos</a></li>
                                                <li><a href="student-reviews.html">Certificaciones</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="header-right">

                        <!-- Navbar Icons -->
                        <ul class="quick-access">
                            <li class="access-icon">
                                <a class="search-trigger-active rbt-round-btn" href="#">
                                    <i class="feather-search"></i>
                                </a>
                            </li>

                            <li class="account-access rbt-user-wrapper d-none d-xl-block">
                                <a id="loginLink" href=""><i class="feather-user"></i>Iniciar Sesión</a>
                            </li>

                        </ul>

                        <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a class="rbt-btn rbt-marquee-btn marquee-auto btn-border-gradient radius-round btn-sm hover-transform-none" href="#">
                                <span data-text="Inscribirse">Inscribirse</span>
                            </a>
                        </div>

                        <!-- Start Mobile-Menu-Bar -->
                        <div class="mobile-menu-bar d-block d-xl-none">
                            <div class="hamberger">
                                <button class="hamberger-button rbt-round-btn">
                                    <i class="feather-menu"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Start Mobile-Menu-Bar -->

                    </div>
                </div>
            </div>
            <!-- Start Search Dropdown  -->
            <div class="rbt-search-dropdown">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="#">
                                <input type="text" placeholder="Buscar">
                                <div class="submit-btn">
                                    <a class="rbt-btn btn-gradient btn-md" href="#">Buscar</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="rbt-separator-mid">
                        <hr class="rbt-separator m-0">
                    </div>

                </div>
            </div>
            <!-- End Search Dropdown  -->
        </div>
        <a class="rbt-close_side_menu" href="javascript:void(0);"></a>
    </header>
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
                                    Sistema de Control de Profesiones
                                </h1>
                                <p class="description">
                                    Una plataforma que eleva la experiencia del profesional, ofreciendo una atención de calidad y optimizando los procesos internos para lograr eficiencia.

                                </p>
                                <div class="slider-btn">
                                    <a class="rbt-btn btn-gradient hover-icon-reverse" href="#">
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
                                                <h4 class="rbt-card-title"><a href="course-details.html">Acceso a HomeSirepro</a>
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

        <!-- Start Footer aera -->
        <footer class="rbt-footer footer-style-1">
            <div class="footer-top">
                <div class="container">
                    <div class="row row--15 mt_dec--30">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                            <div class="footer-widget">
                                <div class="logo">
                                    <a href="index.html">
                                        <img src="assets/images/logo1_sirepro.jpg" alt="Edu-cause">
                                    </a>
                                </div>

                                <p class="description mt--20">Contáctanos para ofrecerle ayuda o soporte con el sistema.
                                </p>

                                <div class="contact-btn mt--30">
                                    <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round" href="#">
                                        <div class="icon-reverse-wrapper">
                                            <span class="btn-text">Contáctanos</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h5 class="ft-title">Contactos</h5>
                                <ul class="ft-link">
                                    <li><span>Teléfono:</span> <a href="#">(021) 237 4000</a></li>
                                    <li><span>E-mail:</span> <a href="mailto:controldeprofesiones@mspbs.gov.py">controldeprofesiones@mspbs.gov.py</a></li>
                                    <li><span>Dirección:</span> Brasil casi Manuel Dominguez, Asunción, Paraguay</li>
                                </ul>
                                <ul class="social-icon social-default icon-naked justify-content-start mt--20">
                                    <li>
                                        <a href="https://www.facebook.com/controldeprofesiones/">
                                            <i class="feather-facebook"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer aera -->
        <div class="rbt-separator-mid">
            <div class="container">
                <hr class="rbt-separator m-0">
            </div>
        </div>
        <!-- Start Copyright Area  -->
        <div class="copyright-area copyright-style-1 ptb--20">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                        <p class="rbt-link-hover text-center text-lg-start">Copyright © 2024 <a href="#">Desarrollo HomeSirepro</a> Todos los derechos reservados</p>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                        <ul class="copyright-link rbt-link-hover justify-content-center justify-content-lg-end mt_sm--10 mt_md--10">
                            <li><a href="#">Términos de uso</a></li>
                            <li><a href="privacy-policy.html">Políticas de privacidad</a></li>
                            <li><a href="subscription.html">Inscribirse</a></li>
                            <li><a href="login.html">Iniciar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Copyright Area  -->

    </main>

    <!-- End Page Wrapper Area -->
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="assets-main/js/vendor/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="assets-main/js/vendor/jquery.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets-main/js/vendor/bootstrap.min.js"></script>
    <!-- sal.js -->
    <script src="assets-main/js/vendor/sal.js"></script>
    <script src="assets-main/js/vendor/swiper.js"></script>
    <script src="assets-main/js/vendor/magnify.min.js"></script>
    <script src="assets-main/js/vendor/jquery-appear.js"></script>
    <script src="assets-main/js/vendor/odometer.js"></script>
    <script src="assets-main/js/vendor/backtotop.js"></script>
    <script src="assets-main/js/vendor/isotop.js"></script>
    <script src="assets-main/js/vendor/imageloaded.js"></script>

    <script src="assets-main/js/vendor/wow.js"></script>
    <script src="assets-main/js/vendor/waypoint.min.js"></script>
    <script src="assets-main/js/vendor/easypie.js"></script>
    <script src="assets-main/js/vendor/text-type.js"></script>
    <script src="assets-main/js/vendor/jquery-one-page-nav.js"></script>
    <script src="assets-main/js/vendor/bootstrap-select.min.js"></script>
    <script src="assets-main/js/vendor/jquery-ui.js"></script>
    <script src="assets-main/js/vendor/magnify-popup.min.js"></script>
    <script src="assets-main/js/vendor/paralax-scroll.js"></script>
    <script src="assets-main/js/vendor/paralax.min.js"></script>
    <script src="assets-main/js/vendor/countdown.js"></script>
    <!-- Main JS -->
    <script src="assets-main/js/main.js"></script>
    <script>
        const SERVER_URL = 'https://identidad.paraguay.gov.py/login';
        const CLIENT_ID = '36'; // ID de cliente generado por MITIC
        const SCOPE = 'read';
        const RESPONSE_TYPE = 'code';
        const STATE = '<?php echo $state; ?>'; // Estado generado en PHP

        // Construir la URL
        const redirectURL = `${SERVER_URL}?clientId=${CLIENT_ID}&scope=${SCOPE}&responseType=${RESPONSE_TYPE}&state=${STATE}`;

        // Asignar la URL generada al atributo href del enlace cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('loginLink').href = redirectURL;
        });
    </script>
</body>

</html>