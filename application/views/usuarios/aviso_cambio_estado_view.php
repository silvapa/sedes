<div data-role="content" id="contenido_pagina">
    <form class="form-signin" name = 'form_cambio_estado' id = 'form_cambio_estado' action="<?php echo base_url() ?>Admin/inactivar" method='post'>

        <h3 class="form-signin-heading">Cambio de estado del usuario</h3>
        <hr class="colorgraph"><br>
        <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>" />
      <div class="alert alert-info" role="alert">  
      <!-- <h4><?php echo $nom; ?></h4>   -->
      <p text-align = "center">Si continua con la operacion, el usuario quedara inactivo</p> 
      </div>
       <div>
         <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="Inactivar" title="Inactivar">Inactivar</button>
         <a href="<?php echo base_url() ?>Admin/abm_users" class="btn btn-lg btn-default pull-right" role="button">Cancelar</a>
       </div>

      </div>    
      </form>
    </div>   