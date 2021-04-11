<div data-role="content" id="contenido_pagina">
      <form class="form-signin" name = 'form_registro' id = 'form_registro' action="<?php echo base_url() ?>Registro/registro_post" method='post'>

        <h3 class="form-signin-heading"><?php echo $t_register_title;?></h3>
        <hr class="colorgraph"><br>

        <input type="text" class="form-control" name="nom" id="nom"  tabindex="1"  placeholder="<?php echo $t_name;?>" required="" autofocus="" value="<?php if (isset($nom)) {echo $nom;} ?>"/>

<!--         <input type="hidden" name="grabar" value="si" />
 -->
        <input type="text" class="form-control" name="email" id="email"  tabindex="2"  placeholder="<?php echo $t_email;?>" required="" autofocus="" value="<?php if (isset($email)) {echo $email;} ?>"/>

        <input type="text" class="form-control" name="email2" id="email2"  tabindex="3"  placeholder="<?php echo $t_email2;?>" required="" autofocus="" value="<?php if (isset($email2)) {echo $email2;} ?>"/>

        <?php if ($error): ?>
          <?php echo '<div class="alert alert-danger"> <strong>Error</strong> '.$error."</div><br>" ?> 
        <?php endif; ?>
        <input type="submit" class="btn btn-lg btn-primary btn-block" data-theme="b" value="<?php echo $t_registerme;?>" title="<?php echo $t_registerme;?>" />
      </div>    
      </form>
    </div>   