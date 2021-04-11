<div data-role="content" id="contenido_pagina">
    <form class="form-signin_inicio_sesion" name = 'form_cargas' id = 'form_cargas' action="<?php echo base_url().'Tad/'.($t_tramite == 'I' ? 'cargas' : 'cargas_ddjj'); ?>" method='POST'>
        <h3 class="form-signin-heading">Archivos subidos correctamente</h3>
        <div id = "row"><div id = "col" class="Lines1"></div></div>
        <div id = "row"><div id = "col" class="Lines2"></div></div>
        <ul>
            <li><?php echo 'Archivo subido  : '.$original;?></li>
            <li><?php echo 'Tamaño (kbytes) : '.$upload_data['file_size'];?></li>
            <li><?php echo 'Filas insertadas: '.$filas_insertadas;?></li>
            <br>
            <li><?php echo 'Total: '.$resultado['total'];?></li>
            <br>
            <li><?php echo 'Repetidos   : '.$resultado['repetido'];?></li>
            <li><?php echo 'En guarani  : '.$resultado['enguarani'];?></li>
            <li><?php echo 'No en Padron: '.$resultado['noenpadron'];?></li>
            <br>
            <li><?php echo 'En Padron: '.$resultado['enpadron'];?></li>
            <p class='p_indentado'><?php echo 'Sancionados: '.$resultado['sancionados'];?></p>
            <p class='p_indentado'><?php echo 'En Baja: '.$resultado['enbaja'];?></p>
            <br>
            <li><?php echo 'Revisar: '.$resultado['revisar'];?></li>
            <p class='p_indentado'><?php echo 'Coinicidencia en GUARANI por DNI: '.$resultado['revisar_g_dni'];?></p>
            <p class='p_indentado'><?php echo 'Coinicidencia en GUARANI por F.Nac: '.$resultado['revisar_g_fnac'];?></p>
            <p class='p_indentado'><?php echo 'Coinicidencia en GUARANI por Email: '.$resultado['revisar_g_mail'];?></p>
            <p class='p_indentado'><?php echo 'Coinicidencia en padron por DNI: '.$resultado['revisar_dni'];?></p>
            <p class='p_indentado'><?php echo 'Coinicidencia en padron por F.Nac: '.$resultado['revisar_fnac'];?></p>
            <p class='p_indentado'><?php echo 'Coinicidencia en padron por Email: '.$resultado['revisar_mail'];?></p>
        </ul>
        <br>
        <br>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <input type="submit" class="btn boton" data-theme="b" value='Subir Otro'/><br>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
                <a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Salir</a>
            </div>
       </div>
    </form>
</div>   