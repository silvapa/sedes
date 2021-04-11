<div data-role="content" id="contenido_pagina_admin">
      <form class="form-signin" name = 'form_registro' id = 'form_registro' action="<?php echo base_url() ?>registro_user_datos/registro_inicial_user_post" method='post'>
        <h3 class="form-signin-heading"><?php echo ($version == 'U' ? 'Formulario de registro' : 'Solicitud de versión DEMO'); ?></h3>
        <hr class="colorgraph">
          <input id="version" name="version" type="hidden" value=<?php echo ($version); ?> >
          <div class="container">

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="nom" class="control-label">Nombre de usuario</label>  
              <input type="text" class="form-control" name="nom" id="nom"  tabindex="1"  placeholder="Nombre de usuario" autofocus="" value="<?php if (isset($nom)) {echo $nom;} ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="email" class="control-label">Email</label>
              <input type="text" class="form-control" name="email" id="email"  tabindex="2"  placeholder="Email" autofocus="" value="<?php if (isset($email)) {echo $email;} ?>"/>
             </div> 
          </div>  
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <label for="pass" class="control-label">Contraseña</label>
              <input type="password" class="form-control" name="pass" id="pass"  tabindex="3"  placeholder="Contraseña" value="<?php if (isset($pass)) {echo $pass;} ?>" />
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
              <label for="pass2" class="control-label">Repetir contraseña</label>
              <input type="password" class="form-control" name="pass2" id="pass2"  tabindex="4"  placeholder="Repetir contraseña" value="<?php if (isset($pass2)) {echo $pass2;} ?>" />
            </div>
          </div><br>

      <?php if ($error): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible">'.$error."</div>" ?> 
      <?php endif; ?>
      <?php if ($mensaje_ok): ?>
        <?php echo '<div class="alert alert-success">'.$mensaje_ok."</div><br>" ?> 
      <?php endif; ?>

         <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="Registrarme" title="Registrarme"><?php echo ($version == 'U' ? 'Registrarme' : 'Enviar'); ?></button>
         <a href="<?php echo base_url() ?>" class="btn btn-lg btn-default pull-right" role="button">Cancelar</a>
       </div>
      </form>
    </div>   