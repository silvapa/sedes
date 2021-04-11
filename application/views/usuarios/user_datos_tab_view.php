<div data-role="content" id="contenido_pagina">
    <form class="form-signin-mediano" name = 'form_registro' id = 'form_registro' action="<?php echo base_url() ?>registro_user_datos/datos_personales_post" method='post'>

      <ul class="nav nav-tabs">
        <li <?php if (!isset($tab_activa) or ($tab_activa < 2))  {echo ' class = "active"';} ?>><a data-toggle="tab" href="#login">Datos para ingreso</a></li>
        <li <?php if ($tab_activa == 2)  {echo ' class = "active"';} ?>><a data-toggle="tab" href="#personal">Datos personales</a></li>
      </ul>

      <div class="tab-content">
        <div id="login" class="tab-pane fade <?php if (!isset($tab_activa) or ($tab_activa < 2))  {echo 'in active';} ?>">
<!--           <input type="hidden" name="ui" id="ui" value="<?php echo $user_id;?>"  /> -->
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
          </div>          

<!--         <input type="hidden" name="grabar" value="si" /> -->
        </div>    
        <div id="personal" class="tab-pane fade <?php if ($tab_activa == 2)  {echo 'in active';} ?>">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
              <label for="nombre_empresa" class="control-label">Empresa/Apellido y nombre</label>  
              <input type="text" class="form-control" name="nombre_empresa" id="nombre_empresa"  tabindex="1"  placeholder="Empresa/Apellido y nombre"  autofocus="" value="<?php if (isset($nombre_empresa)) {echo $nombre_empresa;} ?>"/>
            </div>
          </div>     
          <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 ancho_fila">
              <label class="control-label">Empresa/Part.</label>
              <?php $attributes = 'class="form-control select_styled" id="condition"';
                echo form_dropdown('condition', array('P'=>'particular','E'=>'empresa'), array(0 => $condition), $attributes);?>

            </div>
           <div class="col-xs-9 col-sm-9 col-md-9 ancho_fila">    
              <label for="contact" class="control-label">Ocupación</label>  
              <?php $attributes = 'class="form-control select_styled" id="ocupacion"';
                echo form_dropdown('ocupacion', array(1=>'Productor agropecuario',2=>'Asesor',3=>'Estudiante',4=>'Otro'), array(0 => $ocupacion), $attributes);?>
            </div>
          </div>     
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
              <label for="city" class="control-label">Ciudad de residencia</label>
              <input type="text" class="form-control" name="city" id="city"  tabindex="7"  placeholder="Ciudad de residencia" value="<?php if (isset($city)) {echo $city;} ?>"  r/>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">
              <label class="control-label">País de residencia</label>
              <?php $attributes = 'class="form-control select_styled" id="country"';
                echo form_dropdown('country', $array_country, array(0 => $country), $attributes);?>
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
        <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="Guardar" title="Guardar">Guardar</button>
        <a href="<?php echo base_url() ?>Main/principal" class="btn btn-lg btn-default pull-right" role="button">Salir</a>
     </div>
    </form>
  </div>   