<div data-role="content" id="contenido_pagina">
  <form class="form-signin-mediano" name = 'form_bancario' id = 'form_bancario' action="<?php echo base_url() ?>datos_bancarios/datos_bancarios_post" method='post'>

      <ul class="nav nav-tabs">
        <li <?php if (!isset($tab_activa) or ($tab_activa < 2))  {echo ' class = "active"';} ?>><a data-toggle="tab" href="#paypal">PayPal</a></li>
        <li <?php if ($tab_activa == 2)  {echo ' class = "active"';} ?>><a data-toggle="tab" href="#residente_argentino"><?php echo $t_datos_crediticios;?></a></li>
      </ul>

      <div class="tab-content">
        <div id="paypal" class="tab-pane fade <?php if (!isset($tab_activa) or ($tab_activa < 2))  {echo 'in active';} ?>">
<!--           <input type="hidden" name="ui" id="ui" value="<?php echo $user_id;?>"  /> -->
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="usuario_paypal" class="control-label"><?php echo $t_usuario_paypal;?></label>  
              <input type="text" class="form-control" name="usuario_paypal" id="usuario_paypal"  tabindex="1"  placeholder="<?php echo $t_usuario_paypal;?>" autofocus="" value="<?php if (isset($usuario_paypal)) {echo $usuario_paypal;} ?>"/>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="email_paypal" class="control-label"><?php echo $t_mail_paypal;?></label>
              <input type="text" class="form-control" name="email_paypal" id="email_paypal"  tabindex="2"  placeholder="<?php echo $t_mail_paypal;?>" autofocus="" value="<?php if (isset($email_paypal)) {echo $email_paypal;} ?>"/>
             </div> 
          </div>  
<!--         <input type="hidden" name="grabar" value="si" /> -->
        </div>    
        <div id="residente_argentino" class="tab-pane fade <?php if ($tab_activa == 2)  {echo 'in active';} ?>">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="titular" class="control-label"><?php echo $t_titular;?></label>  
              <input type="text" class="form-control" name="titular" id="titular"  tabindex="1"  placeholder="<?php echo $t_titular;?>"  autofocus="" value="<?php if (isset($titular)) {echo $titular;} ?>"/>
            </div>
          </div>     
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="entidad" class="control-label"><?php echo $t_entidad;?></label>  
              <input type="text" class="form-control" name="entidad" id="entidad"  tabindex="1"  placeholder="<?php echo $t_entidad;?>"  autofocus="" value="<?php if (isset($entidad)) {echo $entidad;} ?>"/>
            </div>
          </div>               
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
<!--               <label for="condition" class="control-label"><?php echo $t_condition;?></label>
              <input type="text" class="form-control" name="condition" id="condition"  tabindex="7"  placeholder="<?php echo $t_condition;?>" value="<?php if (isset($condition)) {echo $condition;} ?>" /> -->

<!--             <div class="form-inline">
                <label for="condition" class="control-label"><?php echo $t_condition;?></label>
                <label class="radio">
                    <input value="P" type="radio"><?php echo $t_condition;?>
                </label>
                <label class="radio">
                    <input value="E" type="radio"><?php echo $t_condition;?>
                </label>
            </div>-->
              <label class="control-label"><?php echo $t_t_cuenta;?></label>
              <?php $attributes = 'class="form-control select_styled" id="t_cuenta"';
                echo form_dropdown('t_cuenta', array('Caja de Ahorro', 'Cuenta Corriente Pesos', 'Cuenta Corriente USD', 'Caja Ahorro USD', 'Paypal', 'Otra'), array(0 ), $attributes);?>

            </div>
           <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <label for="n_cuenta" class="control-label"><?php echo $t_n_cuenta;?></label>
              <input type="text" class="form-control" name="n_cuenta" id="n_cuenta"  tabindex="3"  placeholder="<?php echo $t_n_cuenta;?>" value="<?php if (isset($n_cuenta)) {echo $n_cuenta;} ?>" />
            </div>
          </div>     
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <label for="cbu" class="control-label">CBU</label>
              <input type="text" class="form-control" name="cbu" id="cbu"  tabindex="3"  placeholder="CBU" value="<?php if (isset($cbu)) {echo $cbu;} ?>" />
            </div>
          </div>         
        </div>
      </div>
      <?php if ($error): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible">'.$error."</div><br>" ?> 
      <?php endif; ?>
      <?php if ($mensaje_ok): ?>
        <?php echo '<div class="alert alert-success">'.$mensaje_ok."</div><br>" ?> 
      <?php endif; ?>
      <div>
        <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="<?php echo $t_save;?>" title="<?php echo $t_save;?>"><?php echo $t_save;?></button>
        <a href="<?php echo base_url() ?>Developer/principal" class="btn btn-lg btn-default pull-right" role="button"><?php echo $t_cancelar;?></a>
     </div>
    </form>
  </div>   