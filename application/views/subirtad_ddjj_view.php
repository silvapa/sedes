<div data-role="content" id="contenido_pagina">
      <form class="form-signin_inicio_sesion" name = 'form_cargas' id = 'form_cargas' enctype="multipart/form-data" action="<?php echo base_url() ?>Tad/cargas_ddjj_post" method='POST'>

        <h3 class="form-signin-heading">Seleccione el archivo a importar</h3>
  <!--        <hr class="colorgraph">-->
        <div id = "row"><div id = "col" class="Lines1"></div></div>
  <div id = "row"><div id = "col" class="Lines2"></div></div><br><br>


        <?php echo form_open_multipart('upload/do_upload');?>

          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <label for="userfile" class="control-label">Archivo CSV en UTF-8</label>
              <input type="file" name="userfile" id="userfile"  tabindex="1"  placeholder="Archivos" />
            </div>
          </div>          

          <br>
        <?php if ($error): ?>
          <?php echo '<div class="alert alert-danger">'.$error."</div>" ?> 
        <?php endif; ?>   
          <noscript>
          <div class="alert alert-danger">
              Javascript está deshabilitado en su navegador. Para ver correctamente este sitio,
              <a href="http://www.enable-javascript.com/es/" 
              target="_blank"><b><i>habilite javascript</i></b></a>
          </div>
          </noscript>
          <script>
            if (typeof(Storage) == "undefined") {
             alert('Para ver correctamente este sitio, actualice su navegador')
            }
          </script>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <input type="submit" class="btn boton" data-theme="b" value='Subir'/><br>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
                <a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Salir</a>
            </div>
       </div>

    </form>
  </div>   