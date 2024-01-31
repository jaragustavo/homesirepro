
<div class="form-group" id="documentos_requeridos">
    <input type="hidden" id="tramite_id">
    <!-- <div class="form-group"> -->
    <div class="row" style="margin-left:25px;">
        
        <?php 
            require_once "../../Models/Tramite.php";
            $tiposDocumentos = Tramite::get_docsrequeridos_x_tramite(1);
            $cantidad_actual = 0;
            foreach ($tiposDocumentos as $key => $value) {
                if($cantidad_actual-1%2==0){
                    ?>
                    <div class="row" style="margin-left:25px;">
                    <?php    
                }
                ?>
                <div class="col-md-6" onclick="cargarIdDoc(this.id)" id="<?php echo $value["tipo_documento_id"] ?>">
                    <div class="row" style="width:80%;">
                        <div class="form-group agregarMultimedia"> 
                            <b style="font-size:18px;color:#1e4568;"><?php echo $value["tipo_documento"] ?></b>
                            <div class="multimediaFisica needsclick dz-clickable">
                                <div class="dz-message needsclick" >
                                    Arrastrar o dar click para subir imagenes.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                //
                if($cantidad_actual-1%2==0){
                    ?>
                    </div>
                    <?php    
                }

                $cantidad_actual+=1; 
            }
        ?>
    </div>
</div>
