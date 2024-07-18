<style>
    /* Style the dropdown */
    .dropdown-busqueda {
        position: relative;
        display: inline-block;
    }

    .dropdown-content-busqueda {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-item-busqueda {
        padding: 12px;
        cursor: pointer;
    }
</style>
<header class="site-header">
    <div class="container-fluid">

        <a href="../home/index.php" class="site-logo">
            <img src="../../assets/images/logo1_sirepro.jpg">
        </a>

        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
            <span>toggle menu</span>
        </button>

        <button class="hamburger hamburger--htla">
            <span>toggle menu</span>
        </button>

        <div class="site-header-content">
            <div class="site-header-content-in">
                <div class="site-header-shown">
                    <?php
                    require_once ('mensajes.php');
                    ?>

                    <?php
                    require_once ('notificaciones.php');
                    ?>
                    <div class="dropdown user-menu">
                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="https://sirepro.mspbs.gov.py/foto/<?php echo $_SESSION["cedula"] ?>.jpg" alt="">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                            <a class="dropdown-item" href="../Perfiles/datosPersonales.php"><span
                                    class="font-icon glyphicon glyphicon-user"></span>
                                <?php echo $_SESSION["nombre"] ?>
                                <?php echo $_SESSION["apellido"] ?>
                            </a>
                            <a class="dropdown-item" href="#"><span
                                    class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../Logout/logout.php"><span
                                    class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
                        </div>
                    </div>
                </div>

                <div class="mobile-menu-right-overlay"></div>

                <input type="hidden" id="user_idx" value="<?php echo $_SESSION["usuario_id"] ?>"><!-- ID del Usuario-->

                
            </div>
        </div>
    </div>
</header>
