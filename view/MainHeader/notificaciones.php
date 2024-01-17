<?php

    
$mensajes_pendientes = 1;
if($mensajes_pendientes>0){
    $active = "active";
}
else{
    $active = "";
}


?>
<div class="dropdown dropdown-notification messages">
    <a href="#"
        class="header-alarm dropdown-toggle <?php echo $active ?>"
        
        id="dd-messages"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
        <i class="font-icon-mail"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-messages" aria-labelledby="dd-messages">
        <div class="dropdown-menu-messages-header">
            <ul class="nav" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                        data-toggle="tab"
                        href="#tab-incoming"
                        role="tab">
                        Notificaciones
                        <span class="label label-pill label-danger">
                            <?php echo $mensajes_pendientes
                            ?>
                        </span>
                    </a>
                </li>
            </ul>
            <!--<button type="button" class="create">
                <i class="font-icon font-icon-pen-square"></i>
            </button>-->
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-incoming" role="tabpanel">
                <div class="dropdown-menu-messages-list">
                    <?php
                    // for($i = 0; $i < count($respuesta); $i++){
                        for($i = 0; $i < 5; $i++){                    
                    ?>
                    <a href="#" class="mess-item">
                        <span class="avatar-preview avatar-preview-32"><img src="img/photo-64-2.jpg" alt=""></span>
                        <span class="mess-item-name">Tim Collins</span>
                        <span class="mess-item-txt">Morgan was bothering about something!</span>
                    </a>
                    <?php
                        }?>
                </div>
            </div>
        </div>
        <div class="dropdown-menu-notif-more">
            <a href="" class="actualizarMensajes" 
               usuario_id="<?php echo $_SESSION["usuario_id"]?>">
                Ver todos los mensajes</a>
        </div>
    </div>
</div>