<!DOCTYPE html>
<html lang="en">

<?php 
session_start();

require_once ('../html/head.php'); 
?>

<style>
    /* Centrando el contenedor de búsqueda y la tabla dentro de su contenedor */
    .rbt-elements-area {
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
        padding: 20px; /* Espacio alrededor del contenedor */
    }

    .container {
        width: 100%; /* Asegúrate de que el contenedor ocupe todo el ancho disponible */
        max-width: 1200px; /* O el valor máximo que desees */
        display: flex;
        flex-direction: column;
        align-items: center; /* Centra el contenido en la dirección vertical */
    }

    .row {
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
        width: 100%;
    }

    .col-lg-4, .col-lg-3 {
        display: flex;
        justify-content: center; /* Centra el contenido dentro de las columnas */
    }

    .col-lg-4 {
        flex: 1;
    }

    .col-lg-3 {
        flex: 1;
    }

    .cart-table {
        width: 80%; /* Ancho deseado para la tabla */
        margin: 0 auto; /* Centra la tabla horizontalmente */
    }

    .table {
        width: 100%; /* Asegúrate de que la tabla ocupe el 100% del contenedor */
        border-collapse: collapse;
    }

    /* Otros estilos */
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
                            <h2 class="title">Consulta Pago de Visaciones</h2>
                        </div>
                    </div>
                </div>
                <div class="rbt-elements-area bg-color-white">
                    <div class="container">
                        <div class="row g-5">
                            <div class="col-lg-4">
                                <div class="rbt-search-with-category">
                                    <div class="search-field" id="searchButton">
                                        <input type="text" id="searchInputText" placeholder="Buscar...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" style="display: flex; align-items: center;">
                                <button type="button" class="rbt-btn btn-md btn-gradient hover-icon-reverse" id="buscarDato" name="buscarDato" onclick="buscarDatos()"> 
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Buscar</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wishlist_area bg-color-white">
                <div class="container">
                    <div class="row" id="divmensajes">
                        <div class="col-lg-12">
                            <div class="section-title text-center mb--60">
                                <p id="loadingMessage" class="description mt--30" style="color: #b966e7;display: none;">
                                    Cargando datos...
                                </p>

                                <!-- <p id="masInformacion" class="description mt--30" style="color: #b966e7;display: none;">
                                    Para más información, haga clic en la fila correspondiente.
                                </p> -->
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
                                    <table class="table" id="pagoVisacion_data">
                                            <thead>
                                                <tr>
                                                    <th class="columna-estrecha"></th>
                                                    <th class="pro-title">Nro.Boleta</th>
                                                    <th class="pro-title">Fecha</th>
                                                    <th class="pro-title">Hora</th>
                                                    <th class="pro-title">Utilizado</th>
                                                </tr>
                                            </thead>
                                        <tbody style="font-weight: lighter !important;">
                                            <!-- Data will be dynamically inserted here -->
                                        </tbody>
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

    <script type="text/javascript" src="pagoVisacion.js?v=<?php echo time(); ?>"></script>

</body>

</html>
