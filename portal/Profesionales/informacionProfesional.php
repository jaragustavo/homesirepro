<!DOCTYPE html>
<html lang="en">

<?php require_once ('../html/head.php'); ?>
<style>
    .normal-font {
        font-size: 14px;
    }
</style>
</head>

<body class="rbt-header-sticky">

    <!-- Start Header Area -->
    <?php require_once ('../html/header.php'); ?>
    
    <div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
    </div>
    <!-- Start Card Style -->
    <div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Start Dashboard Top  -->
                    <div class="rbt-dashboard-content-wrapper">
                        <div class="tutor-bg-photo bg_image height-350" style="background-image: url(/homesirepro/assets-main/images/service/medical_background.jpg);"></div>
                        <!-- Start Tutor Information  -->
                        <div class="rbt-tutor-information">
                            <div class="rbt-tutor-information-left">
                                <div class="thumbnail rbt-avatars size-lg">
                                    <img src="/homesirepro/assets-main/images/team/avatar-2.jpg" alt="Instructor">
                                </div>
                                <div class="tutor-content">
                                    <h5 class="title nombre-profesional"></h5>
                                    <ul class="rbt-meta rbt-meta-white mt--5">
                                        <li id="cantidad_profesiones"><i class="feather-award"></i>2 Profesiones</li>
                                        <li id="cantidad_especialidades"><i class="feather-plus-circle"></i>4 Especialidades</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rbt-tutor-information-right">
                                <div class="tutor-btn">
                                    <a class="rbt-btn btn-md hover-icon-reverse" href="#">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text" onclick="volverListado()">Volver a la búsqueda</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Tutor Information  -->
                    </div>
                    <!-- End Dashboard Top  -->

                    <div class="row g-5">
                        <div class="col-lg-6">
                            <!-- Start Dashboard Sidebar  -->
                            <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                                <div class="inner">
                                    <div class="content-item-content">

                                        <div id="info_card" class="rbt-default-sidebar-wrapper" style="justify-content: space-around;">
                                            <div class="section-title mb--20">
                                                <h6 class="rbt-title-style-2 nombre-profesional"></h6>
                                            </div>
                                            <nav class="mainmenu-nav">
                                                <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                    <li><p><i class="far fa-user"></i><span>Nombre:</span></p></li>
                                                    <li><p><i class="far fa-id-card"></i><span>Cédula de Identidad:</span></p></li>
                                                    <li><p><i class="feather-calendar"></i><span>Fecha de nacimiento:</span></p></li>
                                                    <li><p><i class="feather-globe"></i><span>Nacionalidad:</span></p></li>
                                                </ul>
                                            </nav>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Dashboard Sidebar  -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Start Instructor Profile  -->
                            <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                                <div class="content">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3">Profesiones</h4>
                                    </div>
                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Número de Registro</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2">123</div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->

                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15 mt--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Profesión</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2">Médico/a</div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->

                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15 mt--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Universidad</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2"></div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->

                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15 mt--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Especialidad</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2"></div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->
                                </div>

                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15 mt--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Inscripción</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2"></div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->

                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15 mt--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Renovación</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2"></div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->

                                    <!-- Start Profile Row  -->
                                    <div class="rbt-profile-row row row--15 mt--15">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="rbt-profile-content b2">Vencimiento</div>
                                        </div>
                                        <div class="col-lg-8 col-md-8">
                                            <div class="rbt-profile-content b2"></div>
                                        </div>
                                    </div>
                                    <!-- End Profile Row  -->
                            </div>
                            <!-- End Instructor Profile  -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php require_once ('../html/footer.php'); ?>
    <?php require_once ('../html/js.php'); ?>

    <script type="text/javascript" src="profesionales.js?v=<?php echo time(); ?>"></script>

<script>
    var el =document.getElementById("info_card");
    console.log("removeProper");
    el.style.removeProperty('justify-content');
</script>
</body>

</html>