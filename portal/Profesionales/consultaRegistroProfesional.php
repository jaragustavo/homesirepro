<!DOCTYPE html>
<html lang="en">

<?php require_once ('../html/head.php'); ?>
</head>

<body class="rbt-header-sticky">

    <!-- Start Header Area -->
    <?php require_once ('../html/header.php'); ?>
    <!-- End Side Vav -->
    <a class="close_side_menu" href="javascript:void(0);"></a>
    <main class="rbt-main-wrapper">
        <div class="rbt-advance-tab-area bg-gradient-2 rbt-section-gapTop">
            <div class="container">
                <div class="row mb--40">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <span class="subtitle bg-secondary-opacity">HOMESIREPRO</span>
                            <h2 class="title">Consulta de Registro Profesional</h2>
                        </div>
                    </div>
                </div>
                <div class="rbt-elements-area bg-color-white rbt-section-gap">
                    <div class="container">
                        <div class="row g-5">
                            <div class="col-lg-6">
                                <span class="select-label d-block">Seleccione la categoría</span>
                                <div class="rbt-search-with-category">
                                    <div class="filter-select rbt-modern-select search-by-category">
                                        <select>
                                            <option>Todas las categorías</option>
                                            <option>Nombre y Apellido</option>
                                            <option>Registro Profesional</option>
                                            <option>Profesión</option>
                                            <option>Especialidad</option>
                                        </select>
                                    </div>
                                    <div class="search-field">
                                        <input type="text" placeholder="Search Course">
                                        <button class="rbt-round-btn serach-btn" type="submit"><i
                                                class="feather-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 offset-lg-1">
                                <div class="filter-select rbt-modern-select search-by-category">
                                    <span class="select-label d-block">Short By</span>
                                    <select>
                                        <option>All Categories</option>
                                        <option>Education</option>
                                        <option>Course</option>
                                        <option>Art</option>
                                        <option>Web Design</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- End Page Wrapper Area -->
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <?php require_once ('../html/footer.php'); ?>
    <?php require_once ('../html/js.php'); ?>

</body>

</html>