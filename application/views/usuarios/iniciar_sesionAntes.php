  <div data-role="content">
      <form class="form-signin" name = 'form1' id = 'form1' action="<?php if (isset($admin) and ($admin)) { echo base_url() . 'usuarios/iniciar_sesion_admin_post'; } else { echo base_url() . 'usuarios/iniciar_sesion_post'; } ?>" method='post'>

        <h3 class="form-signin-heading">Ingrese al sistema</h3>
        <hr class="colorgraph">

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="email" class="control-label">Email</label>
              <input type="text" class="form-control" name="email" id="email"  tabindex="1"  placeholder="Email" autofocus="" value="<?php if (isset($email)) {echo $email;} ?>"/>
             </div> 
          </div>  
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <label for="contrasena" class="control-label">Contraseña</label>
              <input type="password" class="form-control" name="contrasena" id="contrasena"  tabindex="2"  placeholder="Contraseña" />
            </div>
          </div>          

        <div class="form-signin-registro">¿Olvidaste tu clave?<a href="<?php echo base_url(); ?>envio_clave/enviar_clave"> Ingresa aquí</a><br><br><br>
        <?php if ($error): ?>
          <?php echo '<div class="alert alert-danger"> <strong>Error</strong> '.$error."</div><br>" ?> 
        <?php endif; ?>
   
         <input type="submit" class="btn btn-lg btn-primary btn-block" data-theme="b" value='Iniciar sesión' /><br>
   
        <?php if (isset($admin) and !($admin)) {
          echo '<div class="form-signin-registro">¿Usuario nuevo? <a href="'.base_url().'registro_user_datos/registrar"> Regístrate aquí</a> </div><br>';
          echo '<div class="form-signin-registro">¿Solicitar versión de prueba? <a href="'.base_url().'registro_user_datos/registrar_demo"> Ingresa aquí</a> </div>';          
         } ?>


      </form>
    </div>   