<div data-role="content" id="contenido_pagina">
      <form class="form-signin-mediano" name = 'form_registro' id = 'form_registro' action="<?php echo base_url() ?>registro_user_datos/user_datos_post" method='post'>

        <h3 class="form-signin-heading"><?php echo $t_register_title;?></h3>
        <hr class="colorgraph">

        <input type="text" class="form-control" name="nom" id="nom"  tabindex="1"  placeholder="<?php echo $t_name;?>" required="" autofocus="" value="<?php if (isset($nom)) {echo $nom;} ?>"/>
<!--         <input type="hidden" name="grabar" value="si" />
 -->
  <input type="hidden" name="ui" id="ui" value="<?php echo $user_id;?>"  />
        <input type="text" class="form-control" name="email" id="email"  tabindex="2"  placeholder="<?php echo $t_email;?>" required="" autofocus="" value="<?php if (isset($email)) {echo $email;} ?>"/>
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
            <input type="password" class="form-control" name="pass" id="pass"  tabindex="3"  placeholder="<?php echo $t_password;?>" value="<?php if (isset($pass)) {echo $pass;} ?>" required=""/>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
            <input type="password" class="form-control" name="pass2" id="pass2"  tabindex="4"  placeholder="<?php echo $t_password2;?>" value="<?php if (isset($pass2)) {echo $pass2;} ?>" required=""/>
          </div>
        </div>          
        <hr class="colorgraph_fina">
        <h4 class="form-signin-heading"><?php echo $t_datos_residenciales;?></h4>
        <div class="row">
          <div class="col-xs-9 col-sm-9 col-md-9 ancho_fila">
            <input type="text" class="form-control" name="address" id="address"  tabindex="5"  placeholder="<?php echo $t_address;?>" value="<?php if (isset($address)) {echo $address;} ?>" required=""/>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 ancho_fila">
            <input type="text" class="form-control" name="cp" id="cp"  tabindex="6"  placeholder="<?php echo $t_cp;?>" value="<?php if (isset($cp)) {echo $cp;} ?>" required=""/>
          </div>
        </div>          
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
            <input type="text" class="form-control" name="city" id="city"  tabindex="7"  placeholder="<?php echo $t_city;?>" value="<?php if (isset($city)) {echo $city;} ?>"  required=""/>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
<!--             <input type="text" class="form-control" name="country" id="country"  tabindex="8"  placeholder="<?php echo $t_country;?>" value="<?php if (isset($country)) {echo $country;} ?>"  required=""/>
 -->
          <?php $attributes = 'class="form-control select_styled" id="country"';
              echo form_dropdown('country', $array_country, array(0 => $country), $attributes); 
          ?>


          </div>
        </div>

         <br>         
        <?php if ($error): ?>
          <?php echo '<div class="alert alert-danger alert-dismissible"> <strong>Error</strong> '.$error."</div><br>" ?> 
        <?php endif; ?>
        <?php if ($mensaje_ok): ?>
          <?php echo '<div class="alert alert-success">'.$mensaje_ok."</div><br>" ?> 
        <?php endif; ?>

       <div>
         <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="<?php echo $t_registerme;?>" title="<?php echo $t_registerme;?>"><?php echo $t_registerme;?></button>
         <a href="<?php echo base_url() ?>Developer/principal" class="btn btn-lg btn-default pull-right" role="button"><?php echo $t_cancelar;?></a>
       </div>

<!--         <input type="submit" class="btn btn-lg btn-primary btn-block" data-theme="b" value="<?php echo $t_registerme;?>" title="<?php echo $t_registerme;?>" /> -->
      </div>    
      </form>
    </div>   