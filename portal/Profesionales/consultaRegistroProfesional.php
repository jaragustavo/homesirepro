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
                <div class="rbt-elements-area bg-color-white">
                    <div class="container">
                        <div class="row g-5">
                            <div class="col-lg-6">
                                <div class="rbt-search-with-category">
                                    <div class="filter-select rbt-modern-select search-by-category">
                                        <select id="searchCategory">
                                            <option value="cedula">Cédula de Identidad</option>
                                            <option value="nombreProfesional">Nombre y Apellido</option>
                                            <option value="nroregis">Registro Profesional</option>
                                            <option value="codprofe">Profesión</option>
                                            <option value="codcateg1">Especialidad</option>
                                        </select>
                                    </div>
                                    <div id="divEspecialidad" class="filter-select rbt-modern-select search-by-category"
                                        style="display:none;">
                                        <select id="searchEspecialidad">
                                            <option>Seleccione una especialidad</option>
                                        </select>
                                    </div>
                                    <div id="divProfesion" class="filter-select rbt-modern-select search-by-category"
                                        style="display:none;">
                                        <select id="searchProfesion">
                                            <option>Seleccione una profesión</option>
                                        </select>
                                    </div>
                                    <div class="search-field" id="searchButton">
                                        <input type="text" id="searchInput" placeholder="Buscar...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="wishlist_area bg-color-white">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center mb--60">
                                <p id="loadingMessage" class="description mt--30" style="color: #b966e7;display: none;">
                                    Cargando datos...
                                </p>

                                <p id="masInformacion" class="description mt--30" style="color: #b966e7;display: none;">
                                    Para
                                    más información sobre el
                                    profesional, haga clic
                                    la fila correspondiente.
                                </p>
                                <p id="ceroRegistros" class="description mt--30" style="color: #2F57EF;display: none;">
                                    No se han encontrado registros con los datos ingresados.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form action="#">
                                <div class="cart-table table-responsive">
                                    <table class="table" id="profesionales_data">
                                        <thead>
                                            <tr>
                                                <th class="pro-thumbnail"></th>
                                                <th class="pro-title">CI</th>
                                                <th class="pro-title">Nombre</th>
                                                <th class="pro-title">N° de Registro</th>
                                                <th class="pro-price">Profesión</th>
                                                <th class="pro-quantity">Especialidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data will be dynamically inserted here -->
                                        </tbody style="font-weight: lighter !important;">
                                    </table>
                                </div>

                            </form>
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

    <script type="text/javascript" src="profesionales.js?v=<?php echo time(); ?>"></script>
</body>

</html>