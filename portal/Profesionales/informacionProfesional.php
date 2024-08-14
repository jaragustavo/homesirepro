<!DOCTYPE html>
<html lang="en">

<?php require_once ('../html/head.php'); ?>
<style>
    .normal-font {
        font-size: 14px;
    }

    .square-image {
        width: 50%;
        object-fit: cover;
        /* Required to prevent the image from stretching, use the object-position property to adjust the visible area */
        aspect-ratio: 1/1;
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
                        <div class="tutor-bg-photo bg_image height-350"
                            style="background-image: url(/homesirepro/assets-main/images/service/medical_background.jpg);">
                        </div>
                        <!-- Start Tutor Information  -->
                        <div class="rbt-tutor-information">
                            <div class="rbt-tutor-information-left">
                                <div class="thumbnail rbt-avatars size-lg">
                                    <img class="square-image" id="profesional_img" src="/homesirepro/assets/images/users/user-dummy-img.jpg" alt="Profesional">
                                </div>
                                <div class="tutor-content">
                                    <h5 class="title nombre-profesional"></h5>
                                    <ul class="rbt-meta rbt-meta-white mt--5">
                                        <li id="cantidad_profesiones"></li>
                                        <li id="cantidad_especialidades"></li>
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
                        <div class="col-lg-7">
                            <div class="section-title text-center mb--60">
                                <p id="loadingMessage" class="description mt--30" style="color: #b966e7;display: none;">
                                    Cargando datos...
                                </p>
                            </div>
                            <!-- Start Dashboard Sidebar  -->
                            <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                                <div class="inner">
                                    <div class="content-item-content">

                                        <div id="info_card" class="rbt-default-sidebar-wrapper"
                                            style="justify-content: space-around;">
                                            <div class="section-title mb--20">
                                                <h6 class="rbt-title-style-2 nombre-profesional"></h6>
                                            </div>
                                            <nav class="mainmenu-nav">
                                                <ul class="dashboard-mainmenu rbt-default-sidebar-list"
                                                    id="userInfoList">
                                                    <li>
                                                        <p><i class="far fa-user"></i><span>Nombre: </span><span
                                                                id="userName"></span></p>
                                                    </li>
                                                    <li>
                                                        <p><i class="far fa-id-card"></i><span>Cédula de
                                                                Identidad: </span><span id="userCedula"></span></p>
                                                    </li>
                                                </ul>
                                            </nav>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Dashboard Sidebar  -->
                            <div class="row" style="margin-top:10px">
                                <div class="col-12">
                                    <form action="#">
                                        <div class="cart-table table-responsive">
                                            <table class="table" id="profesiones_data">
                                                <thead>
                                                    <tr>
                                                        <th class="pro-title">N° de Registro</th>
                                                        <th class="pro-price">Profesión</th>
                                                        <th class="pro-price">Universidad</th>
                                                        <th class="pro-price">Vencimiento</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="normal-font" style="font-weight: lighter !important;">
                                                    <!-- Data will be dynamically inserted here -->
                                                </tbody>
                                            </table>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Especialidades</h4>
                            </div>
                            <!-- Start Especialidad Profile  -->
                            <div id="professionsContainer">
                            </div>
                            <!-- End Especialidad Profile  -->
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
        cargarInformacionProf();
    </script>
</body>

</html>