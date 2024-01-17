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
                        require_once('notificaciones.php');
                    ?>
                    <div class="dropdown dropdown-notification notif">
                        <a href="../MntNotificacion/" class="header-alarm">
                            <i class="font-icon-alarm"></i>
                        </a>
                    </div>
                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <img src="https://sirepro.mspbs.gov.py/foto/<?php echo $_SESSION["cedula"] ?>.jpg" alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-user"></span><?php echo $_SESSION["nombre"] ?> <?php echo $_SESSION["apellido"] ?></a>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
	                            <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../Logout/logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
	                        </div>
	                    </div>
                    <!-- <div class="dropdown user-menu">
                        <div class="tbl">
                            <div class="tbl-row">
                                <div class="tbl-cell">
                                <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
                                    <a class="dropdown-item" href="../MntPerfil/"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span>Ayuda</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../../index.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Cerrar Sesion</a>
                                </div>
                                </div>
                                <div class="tbl-cell">
                                    <div class="dropdown dropdown-typical">
                                        <a href="#" class="dropdown-toggle no-arr">
                                            <span class="font-icon font-icon-user"></span>
                                            <span class="lblcontactonomx"><?php echo $_SESSION["nombre"] ?> <?php echo $_SESSION["apellido"] ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div> -->
                </div>

                <div class="mobile-menu-right-overlay"></div>

                <input type="hidden" id="user_idx" value="<?php echo $_SESSION["usuario_id"] ?>"><!-- ID del Usuario-->

                

            </div>
        </div>
    </div>
</header>