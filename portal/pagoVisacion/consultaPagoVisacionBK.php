<!DOCTYPE html>
<html lang="en">

<?php 
session_start();

require_once ('../html/head.php'); 

?>

<style>
    /* Estilos para centrar la tabla */
    .wishlist_area {
        display: flex;
        justify-content: center; /* Centrar la tabla horizontalmente */
        padding: 20px; /* Espacio alrededor de la tabla */
    }

    .cart-table {
        width: 80%; /* Ajusta el ancho de la tabla al 50% del contenedor */
        margin: 0 auto; /* Centrar la tabla dentro del contenedor */
    }

    .table {
        width: 100%; /* La tabla ocupará el 100% del ancho del contenedor .cart-table */
        border-collapse: collapse;
    }

    #pagoVisacion_data th, #pagoVisacion_data td {
        padding: 8px; /* Ajusta el padding si es necesario */
        text-align: center; /* Centrar el contenido dentro de las celdas */
    }

    /* Estilos para centrar el contenedor de búsqueda */
    .rbt-elements-area {
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
        padding: 20px; /* Espacio alrededor del contenido */
    }

    .rbt-elements-area .container {
        max-width: 800px; /* Ajusta el ancho máximo del contenedor de búsqueda */
        width: 100%; /* Ocupa el 100% del ancho disponible del contenedor padre */
    }

    .rbt-search-with-category {
        display: flex;
        justify-content: center; /* Centra el contenido horizontalmente */
    }

    .search-field {
        max-width: 100%; /* Ajusta el ancho máximo del campo de búsqueda */
    }

    .rbt-btn {
        display: flex;
        align-items: center;
        justify-content: center; /* Centra el contenido del botón */
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
                            <h2 class="title">Consulta Pago de Visaciones</h2>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="wishlist_area bg-color-white">
                <div class="container">
                   
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
                                <div class="col-lg-3" style="display: flex; align-items: center; justify-content: center;">
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title text-center mb--60">
                                <p id="loadingMessage" class="description mt--30" style="color: #b966e7;display: none;">
                                    Cargando datos...
                                </p>

                                <p id="masInformacion" class="description mt--30" style="color: #b966e7;display: none;">
                                    Para más información sobre el profesional, haga clic en la fila correspondiente.
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
                                <div class="cart-table">
                                    <table class="table" id="pagoVisacion_data">
                                        <thead>
                                            <tr>
                                                <th class="columna-estrecha"></th>
                                                <th class="pro-title">Nro.Boleta</th>
                                                <th class="pro-title">Fecha</th>
                                                <th class="pro-title">Hora</th>
                                                <th class="pro-title">Profesional</th>
                                                <th class="pro-title">Estado</th>
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
