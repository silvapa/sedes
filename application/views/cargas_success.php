<div data-role="content" id="contenido_pagina">
    <form class="form-signin_inicio_sesion" name = 'form_cargas' id = 'form_cargas' action="<?php echo base_url() ?>Archivos/cargas" method='POST'>
        <h3 class="form-signin-heading">Archivos subidos correctamente</h3>
        <div id = "row"><div id = "col" class="Lines1"></div></div>
        <div id = "row"><div id = "col" class="Lines2"></div></div>
        <ul>
            <li><?php echo 'Archivo subido : '.$upload_data['file_name'];?></li>
            <li><?php echo 'Tamaño (kbytes): '.$upload_data['file_size'];?></li>
        </ul>
        <br>
        <br>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
                <button type="submit" class="btn btn-lg btn-primary btn-block" data-theme="b" value="Volver" title="Volver">Subir Otro</button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
                <a href="<?php echo base_url() ?>Main/Principal" class="btn btn-lg btn-primary btn-block" role="button">Salir</a>
            </div>
       </div>
    </form>
</div>   