<div data-role="content" id="contenido_pagina">
     <form class="form-signin" name = 'form_registro' id = 'form_registro' action="<?php echo base_url(). (isset($ruta_salir) ? $ruta_salir : '') ?>" method='post'>

        <h3 class="form-signin-heading"><?php if (isset($titulo)) {echo $titulo;} ?></h3>
        <hr class="colorgraph"><br>
     <div class="alert alert-info" role="alert">  
      <!-- <h4><?php echo $nom; ?></h4>   -->
      <p text-align = "center"><em><?php { if (isset($nom) and $nom <> '')  {echo  $nom.': ';}} ?></em><?php if (isset($texto)) {echo $texto;} ?></p></div>
      
        <?php if (isset($invitar) and ($invitar <> ''))  {echo  '<div class="form-signin-registro">¿Deseas registrarte? <a href="'. base_url().'registro_user_datos/registrar"> Regístrate aquí</a> </div><br>';} ?>


        <input type="submit" class="btn btn-lg btn-primary btn-block" data-theme="b" value="<?php if (isset($t_exit)) {echo $t_exit;} else {echo 'Salir';} ?>" title="<?php if (isset($t_exit)) {echo $t_exit;} else {echo 'Salir';} ?>" />

      </div>    
      </form>
    </div>   