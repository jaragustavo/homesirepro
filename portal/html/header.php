<?php
// Obtener la ruta relativa del directorio actual
$root_path = "/homesirepro/portal/";
$root_path_main = "/homesirepro/";
?>
<header class="rbt-header rbt-header-10">
    <div class="rbt-sticky-placeholder"></div>
    <!-- Start Header Top  -->
    <div
        class="rbt-header-top rbt-header-top-1 header-space-betwween bg-not-transparent bg-color-darker top-expended-activation">
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
                            <a href="<?php echo $root_path_main ?>index.php">
                                  <img src="<?php echo $root_path_main ?>assets/images/logo1_sirepro.jpg"
                                    alt="Logo Control de Profesiones">
                            </a>
                        </div>
                    </div>
                    <div class="header-info">
                        <div class="rbt-category-menu-wrapper">
                            <div class="rbt-category-btn rbt-side-offcanvas-activation">
                                <div class="rbt-offcanvas-trigger md-size icon">
                                    <span class="d-none d-xl-block">
                                        <i class="feather-grid"></i>
                                    </span>
                                    <i title="Category" class="feather-grid d-block d-xl-none"></i>
                                </div>
                                <span class="category-text d-none d-xl-block">HomeSirepro</span>
                            </div>

                            <div class="category-dropdown-menu d-none d-xl-block">
                                <div class="category-menu-item">
                                    <div class="rbt-vertical-nav">
                                        <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                                            <li class="vertical-nav-item active">
                                                <a href="<?php //echo $root_path ?>">Misión y
                                                    Visión</a>
                                            </li>
                                            <li class="vertical-nav-item">
                                                <a href="<?php echo $root_path ?>APE/quienesSomos.php">Resoluciones</a>
                                            </li>
                                            <li class="vertical-nav-item">
                                                <a href="<?php echo $root_path ?>APE/presidenta.php">Formularios Varios</a>
                                            </li>
                                            <li class="vertical-nav-item">
                                                <a href="<?php echo $root_path ?>APE/juntaDirectiva.php">Requisitos para la Habilitación de Establecimientos de Salud</a>
                                            </li>
                                            
                                        </ul>
                                    </div>

                                </div>
                            </div>
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
                                                        <li><a href="">Inscripción</a></li>
                                                        <li><a href="">Renovación</a></li>
                                                        <li><a href="">Reexpedición</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                                    <h3 class="rbt-short-title">Expedición de documentos</h3>
                                                    <ul class="mega-menu-item">
                                                        <li><a href="">Constancias</a></li>
                                                        <li><a href="">Recertificación de especialidad</a></li>
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
                                                <li><a href="">Menu del Sistema</a></li>
                                                <li><a href="">- Perfil</a></li>
                                                <li><a href="">- Trámites en línea</a></li>
                                                <li><a href="">- Reposos emitidos</a></li>
                                                <li><a href="">- Certificaciones</a></li>
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
                        <li class="account-access rbt-user-wrapper d-none d-xl-block">
                            <a class="loginMtic" href="#"><i class="feather-user"></i>Ingresar</a>
                        </li>
                        <li class="access-icon rbt-user-wrapper d-block d-xl-none">
                            <a class="rbt-round-btn loginMtic" href="#"><i class="feather-user"></i></a>
                        </li>
                    </ul>

                    <div class="rbt-btn-wrapper d-none d-xl-block">
                        <a class="rbt-btn rbt-marquee-btn marquee-auto btn-border-gradient radius-round btn-sm hover-transform-none loginMtic"
                            href="" >
                            <span data-text="Inscribase a HomeSirepro">Inscribase a HomeSirepro</span>
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
    </div>
    <!-- Start Side Vav -->
    <div class="rbt-offcanvas-side-menu rbt-category-sidemenu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="inner-title">
                    <h4 class="title">HomeSirepro</h4>
                </div>
                <div class="rbt-btn-close">
                    <button class="rbt-close-offcanvas rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
               <nav class="side-nav w-100">
                <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                    <li>
                        <a href="">Inscripción</a>
                    </li>
                    <li>
                        <a href="">Renovación</a>
                    </li>
                    <li>
                        <a href="">Reexpedición</a>
                    </li>
                    <li>
                        <a href="">Reposos Emitidos</a>
                    </li>
                  
                </ul>
           
            </nav>
            <div class="rbt-offcanvas-footer">

            </div>
        </div>
    </div>
    <!-- End Side Vav -->
    <a class="rbt-close_side_menu" href="javascript:void(0);"></a>
</header>

<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo">
                    <a href="<?php echo $root_path_main ?>index.php">
                        <img src="<?php echo $root_path_main ?>assets/images/logo1_sirepro.jpg" alt="Logo Control de profesiones">
                    </a>
                </div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
            <p class="description"> HomeSirepro </p>
            <ul class="navbar-top-left rbt-information-list justify-content-start">
                <li>
                    <a href="mailto:ae_paraguay@yahoo.com.ar"><i class="feather-mail"></i>controldeprofesiones@mspbs.gov.py</a>
                </li>
                <li>
                    <a href="#"><i class="feather-phone"></i>(021) 237 4000</a>
                </li>
            </ul>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">

                <li class="with-megamenu has-menu-child-item position-static">
                    <a href="index.php">Informaciones <i class="feather-chevron-down"></i></a>
                    <!-- Start Mega Menu  -->
                    <div class="rbt-megamenu menu-skin-dark">
                        <div class="wrapper">
                            <div class="row row--15 home-plesentation-wrapper single-dropdown-menu-presentation">

                                <!-- Start Single Demo  -->
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Intructivos Generales<span class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Demo  -->
                                <!-- Start Single Demo  -->
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Tramites<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Demo  -->
                            </div>

                            <div class="load-demo-btn text-center">
                                <a class="rbt-btn-link color-white" href="#">Scroll to view more <svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z" />
                                    </svg></a>
                            </div>
                        </div>
                    </div>
                    <!-- End Mega Menu  -->
                </li>

                <li class="with-megamenu has-menu-child-item position-static">
                    <a href="index.php">Marco Legal <i class="feather-chevron-down"></i></a>
                    <!-- Start Mega Menu  -->
                    <div class="rbt-megamenu menu-skin-dark">
                        <div class="wrapper">
                            <div class="row row--15 home-plesentation-wrapper single-dropdown-menu-presentation">

                                <!-- Start Single Demo  -->
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Resoluciones Vigentes<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Demo  -->
                                <!-- Start Single Demo  -->
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Circulares<span class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Demo  -->
                            </div>
                        </div>
                    </div>
                    <!-- End Mega Menu  -->
                </li>

                <li class="with-megamenu has-menu-child-item position-static">
                    <a href="index.php">Documentaciones <i class="feather-chevron-down"></i></a>
                    <!-- Start Mega Menu  -->
                    <div class="rbt-megamenu menu-skin-dark">
                        <div class="wrapper">
                            <div class="row row--15 home-plesentation-wrapper single-dropdown-menu-presentation">

                                <!-- Start Single Demo  -->
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Inscripción con títulos Nacionales<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Inscripción de Profesionales con Títulos Extranjeros<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Inscripción de Especialidades en el Registro Profesional<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Renovación de Registros<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                    <div class="demo-single">
                                        <div class="inner">
                                            <div class="content">
                                                <h4 class="title"><a
                                                        href="">Procedimiento y requisitos para visacion de documentos<span
                                                            class="btn-icon"><i
                                                                class="feather-arrow-right"></i></span></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- End Single Demo  -->

                            </div>

                        
                        </div>
                    </div>
                    <!-- End Mega Menu  -->
                </li>

                
            </ul>
        </nav>

        <div class="mobile-menu-bottom">
            <div class="rbt-btn-wrapper mb--20">
                <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center loginMtic"
                    href="" >
                    <span>Registrarse</span>
                </a>
            </div>

            <div class="social-share-wrapper">
                <span class="rbt-short-title d-block">Redes Sociales</span>
                <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                    <li>
                        <a href="https://www.facebook.com/">
                            <i class="feather-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.twitter.com">
                            <i class="feather-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/">
                            <i class="feather-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkdin.com/">
                            <i class="feather-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>