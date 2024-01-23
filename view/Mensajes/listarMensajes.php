<?php
  require_once("../../config/conexion.php"); 
  if(isset($_SESSION["usuario_id"])){ 
    require_once("../../models/Mensaje.php");
    $mensaje = new Mensaje();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $mensajes_nuevos = 0;
    $active = "";
    $chats=$mensaje->get_chats_x_usuario($_SESSION["usuario_id"]);
    $mensajes_nuevos=count($chats);
    
?>

<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <?php require_once("../MainHead/head.php"); ?>

    <link rel="stylesheet" href="../../public/css/separate/pages/chat.css">
    <link rel="stylesheet" href="../../public/css/separate/pages/messenger.css">
</head>
  <body class="with-side-menu">
      <div class="mobile-menu-left-overlay"></div>
      <?php require_once("../MainHeader/header.php"); ?>
      <?php require_once("../MainNav/nav.php"); ?>

      <div class="page-content">
    <div class="container-fluid messenger">

        <div class="box-typical chat-container">
            <section class="chat-list">
                <div class="chat-list-search chat-list-settings-header">
                    <div class="row">
                        <div class="col-sm-2 col-lg-2 action">
                            <a href="#"><span class="font-icon font-icon-cogwheel"></span></a>
                        </div>
                        <div class="col-sm-8 col-lg-8 text-center description">
                            Mensajería
                        </div>
                        <div class="col-sm-2 col-lg-2 text-right action">
                            <a href="#"><span class="font-icon fa fa-pencil"></span></a>
                        </div>
                    </div>
                </div><!--.chat-list-search-->
                <div class="chat-list-in scrollable-block">
                    <!-- <div class="chat-list-item online">
                        <div class="chat-list-item-photo">
                            <img src="../../public/img/photo-64-1.jpg" alt="">
                        </div>
                        <div class="chat-list-item-header">
                            <div class="chat-list-item-name">
                                <span class="name">Matt McGill</span>
                            </div>
                            <div class="chat-list-item-date">16:59</div>
                        </div>
                        <div class="chat-list-item-cont">
                            <div class="chat-list-item-txt writing">
                                <div class="icon">
                                    <i class="font-icon font-icon-pencil-thin"></i>
                                </div>
                                Matt McGill typing a message
                            </div>
                            <div class="chat-list-item-count">3</div>
                        </div>
                    </div> -->
                    <?php
                      foreach($chats as $row){
                    ?>
                    <div class="chat-list-item" onclick="cargarChat(<?php echo $row['chat_id'] ?>)">
                        <div class="chat-list-item-photo">
                            <img src="../../public/img/photo-64-2.jpg" alt="">
                        </div>
                        <div class="chat-list-item-header">
                            <div class="chat-list-item-name">
                                <span class="name" ><?php echo $row["nombre_chat"] ?></span>
                            </div>
                            <div class="chat-list-item-date"><?php echo $row["hora"] ?></div>
                        </div>
                        <div class="chat-list-item-cont">
                            <div class="chat-list-item-txt"><?php echo $row["mensaje"] ?></div>
                            <div class="chat-list-item-count"><?php echo $row["cant_mensajes_nuevos_x_chat"] ?></div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                    <!-- <div class="chat-list-item selected">
                        <div class="chat-list-item-photo">
                            <img src="../../public/img/photo-64-3.jpg" alt="">
                        </div>
                        <div class="chat-list-item-header">
                            <div class="chat-list-item-name">
                                <span class="name">Vasilisa</span>
                            </div>
                            <div class="chat-list-item-date">05 Aug</div>
                        </div>
                        <div class="chat-list-item-cont">
                            <div class="chat-list-item-txt">no</div>
                            <div class="chat-list-item-dot"></div>
                        </div>
                    </div> -->
                    
                </div><!--.chat-list-in-->
            </section><!--.chat-list-->
            <section class="chat-list-info">
                <div class="chat-list-search chat-list-settings-header">
                    
                </div><!--.chat-list-search-->
                
            </section>

            <section class="chat-area">
              <div class="chat-area-in">
                  <div class="chat-area-header">
                      <div class="chat-list-item online" id="header_chat">
                          <div class="chat-list-item-name">
                              <span class="name_chat"></span>
                          </div>
                          <div class="chat-list-item-txt writing">Última vez 05 ago 2015 a las 18:04</div>
                      </div>
                  </div><!--.chat-area-header-->

                  <div class="chat-dialog-area scrollable-block" id="body_chat">
                      <div class="messenger-dialog-area" id="listado_mensajes">
                          <!-- <div class="messenger-message-container">
                              <div class="avatar">
                                  <img src="../../public/img/avatar-1-32.png">
                              </div>
                              <div class="messages">
                                  <ul id="mensajes_recibidos">
                                      
                                  </ul>
                              </div>
                          </div> -->
                          <!-- <div class="messenger-message-container from bg-blue">
                              <div class="messages">
                                  <ul id="mensajes_remitidos">
                                      
                                  </ul>
                              </div>
                              <div class="avatar chat-list-item-photo">
                                  <img src="../../public/img/photo-64-1.jpg">
                              </div>
                          </div> -->
                      </div>
                  </div>

                  <div class="chat-area-bottom" id="escribir_mensaje">
                      <form class="write-message">
                          <div class="form-group">
                              <textarea rows="1" class="form-control" placeholder="Type a message"></textarea>
                              <div class="dropdown dropdown-typical dropup attach">
                                  <a class="dropdown-toggle dropdown-toggle-txt"
                                      id="dd-chat-attach"
                                      data-target="#"
                                      data-toggle="dropdown"
                                      aria-haspopup="true"
                                      aria-expanded="false">
                                      <span class="font-icon fa fa-file-o"></span>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-chat-attach">
                                      <a class="dropdown-item" href="#"><i class="font-icon font-icon-cam-photo"></i>Photo</a>
                                      <a class="dropdown-item" href="#"><i class="font-icon font-icon-cam-video"></i>Video</a>
                                      <a class="dropdown-item" href="#"><i class="font-icon font-icon-sound"></i>Audio</a>
                                      <a class="dropdown-item" href="#"><i class="font-icon font-icon-page"></i>Document</a>
                                      <a class="dropdown-item" href="#"><i class="font-icon font-icon-earth"></i>Map</a>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div><!--.chat-area-bottom-->
              </div><!--.chat-area-in-->
            </section><!--.chat-area-->
        </div><!--.chat-container-->

    </div><!--.container-fluid-->
</div><!--.page-content-->
      
	  <!-- <script type="text/javascript" src="mensajes.js"></script> -->
    <?php require_once("../MainJs/js.php");?>
    <?php require_once("../html/footer.php"); ?>
    <script type="text/javascript" src="mensajes.js"></script>
  </body>

</html>
<?php
} else {
  header("Location:".Conectar::ruta()."index.php");
}
?>