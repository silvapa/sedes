<div data-role="content" id="contenido_pagina">
      <form class="form-signin_inicio_sesion" name = 'form1' id = 'form1' action="<?php if (isset($admin) and ($admin)) { echo base_url() . 'usuarios/iniciar_sesion_admin_post'; } else { echo base_url() . 'usuarios/iniciar_sesion_post'; } ?>" method='post'>

        <h3 class="form-signin-heading">Ingresa al sistema</h3>
  <!--        <hr class="colorgraph">-->
        <div id = "row"><div id = "col" class="Lines1"></div></div>
  <div id = "row"><div id = "col" class="Lines2"></div></div>
         
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="login" class="control-label">Usuario</label>
              <input type="text" class="form-control" name="login" id="login"  tabindex="1"  placeholder="Usuario" autofocus="" value="<?php if (isset($login)) {echo $login;} ?>"/>
             </div> 
          </div>  
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <label for="contrasena" class="control-label">Contraseña</label>
              <input type="password" class="form-control" name="contrasena" id="contrasena"  tabindex="2"  placeholder="Contraseña" />
            </div>
 <!--            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
             <label for="olvidaste_clave" class="control-label">¿Olvidaste tu clave?</label>
              <a href="<?php echo base_url(); ?>envio_clave/enviar_clave"> Ingresa aquí</a>
            </div>

        <div class="form-signin-registro">¿Olvidaste tu clave?<a href="<?php echo base_url(); ?>envio_clave/enviar_clave"> Ingresa aquí</a> -->
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
          <input type="submit" class="btn boton btn-block" data-theme="b" value='Iniciar sesión' /><br>
    </form>
  </div>   