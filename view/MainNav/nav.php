/* TODO: Rol 1 es de Usuario */

<nav class="side-menu">
    <ul class="side-menu-list">
        <li class="blue-dirty">
            <a href="../home/index.php"><span class="glyphicon glyphicon-home"></span>
            <span class="lbl">Inicio</span></a>
            
            <!-- <a href="..\home\ ">
            <?php 
            // echo $_SESSION["inicio"] 
            ?>
                <span class="glyphicon glyphicon-home"></span>
                <span class="lbl">Inicio</span>
            </a> -->
        </li>
        <li class="grey with-sub">
            <span>
                <span class="glyphicon glyphicon-user"></span>
                <span class="lbl">Perfil</span>
            </span>
            <ul>
                <a href="../Perfiles/datosPersonales.php"><span class="lbl">Datos personales</span></a>
        </li>
    </ul>

    <!-- <li class="magenta with-sub">
            <span>
                <span class="glyphicon glyphicon-folder-open"></span>
                <span class="lbl">Currículum Virtual</span>
            </span>
            <ul>
                <a href="..\DocsPersonales\listarDocsPersonales.php"><span class="lbl">Personales</span></a></li>
                <a href="..\DocsAcademicos\listarDocsAcademicos.php"><span class="lbl">Académicos</span></a></li>
                <a href="..\DocsAcademicos\listarCapacitaciones.php"><span class="lbl">Capacitaciones</span></a></li>
                <a href="..\DocsAcademicos\listarLaborales.php"><span class="lbl">Laborales</span></a></li>
            </ul>
        </li> -->
    <?php
    require_once("../../config/conexion.php");
    require_once("../../models/Usuario.php");
    $usuario = new Usuario();

    $permisos = $usuario->get_permisos_x_roles($_SESSION["usuario_id"]);

    foreach( $permisos as  $key => $value) {
        $permisos_ordenados = array();
        switch($value["nombre_permiso"]) {
            case "Investigaciones":
                $permisos_ordenados[0] = $value;
                break;
            case "Reposos Emitidos":
                $permisos_ordenados[1] = $value;
                break;
            case "Tramites en linea":
                $permisos_ordenados[2] = $value;
                break;
            case "Administrar":
                $permisos_ordenados[3] = $value;
                break;
            case "Consultas":
                $permisos_ordenados[4] = $value;
                break;
        }
    }
    // error_log(count($permisos_ordenados));
    foreach ($permisos as $key => $value) {
        if ($value["nombre_permiso"] == "Reposos Emitidos") { ?>
            <li class="coral">
                <a href="..\Reposos\listarReposos.php">
                    <span class="glyphicon glyphicon-plus-sign"></span>
                    <span class="lbl">Reposos Emitidos</span>
                </a>
            </li>
        <?php }
        if ($value["nombre_permiso"] == "Tramites en linea") { ?>
            <li class="gold with-sub">
                <span>
                    <span class="fa fa-laptop" style="font-size:20px;"></span>
                    <span class="lbl">Trámites en línea</span>
                </span>
                <ul>
                    <a href="..\Tramites\listarTramites.php"><span class="lbl">Gestiones</span></a>
                </li>
                </ul>
            </li>
        <?php }
        if ($value["nombre_permiso"] == "Consultas" || $value["nombre_permiso"] == "Tramites") { ?>
            
            <li class="red with-sub">
                <span>
                    <span class="glyphicon glyphicon-list-alt" style="font-size:20px;"></span>
                    <span class="lbl">Administrar</span>
                </span>
                <?php
            
                if($value["nombre_permiso"] == "Tramites"){
                ?>
                <ul>
                    <a href="..\Movimientos\listarSolicitudes.php"><span class="lbl">Trámites</span></a>
                </ul>
                <?php } elseif($value["nombre_permiso"] == "Consultas") {
                    ?>
                    <ul>
                        <a href="..\Consultas\listarTramites.php"><span class="lbl">Movimientos de trámites</span></a>
                    </ul>
                    <?php
                }
                ?>
            </li>
        <?php }
        if ($value["nombre_permiso"] == "Rendimiento de Departamentos") { ?>
            <li class="blue-darker with-sub">
                <span>
                    <span class="glyphicon glyphicon-stats" style="font-size:20px;"></span>
                    <span class="lbl">Indicadores de Gestión</span>
                </span>
                <ul>
                    <a href="..\Tramites\listarTramites.php"><span class="lbl">Rendimiento por Departamento</span></a>
                </li>
                </ul>
            </li>
        <?php }
        if ($value["nombre_permiso"] == "Comprobantes") { ?>
            <li class="blue-darker with-sub">
                <span>
                    <span class="glyphicon glyphicon-file" style="font-size:20px;"></span>
                    <span class="lbl">Comprobantes</span>
                </span>
                <ul>
                    <a href="..\Tramites\listarTramites.php"><span class="lbl">Rendimiento por Departamento</span></a>
                </li>
                </ul>
            </li>
        <?php }
    }
    ?>


    
    
    
</nav>