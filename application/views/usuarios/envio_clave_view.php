<div data-role="content" id="contenido_pagina">
      <form class="form-signin" name = 'form_envio_clave' id = 'form_envio_clave' action="<?php echo base_url() ?>envio_clave/envio_clave_post" method='post'>

        <h3 class="form-signin-heading">Envío de clave</h3>
        <hr class="colorgraph">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="email" class="control-label">Email</label>
              <input type="text" class="form-control" name="email" id="email"  tabindex="1"  placeholder="Ingrese su email" autofocus="" value="<?php if (isset($email)) {echo $email;} ?>"/>
             </div> 
          </div> <br><br>

        <?php if ($error): ?>
          <?php echo '<div class="alert alert-danger"> <strong>Error</strong> '.$error."</div><br>" ?> 
        <?php endif; ?>
       <div>
         <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="Reenviar clave" title="Reenviar clave">Reenviar clave</button>
         <a href="<?php echo base_url() ?>" class="btn btn-lg btn-default pull-right" role="button">Cancelar</a>
       </div>

      </div>    
      </form>
    </div>   