<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php echo '<script src="'.base_url().'application/assets/js/jquery2.1.1/jquery.min.js"></script>';
      echo '<script src="'.base_url().'application/assets/js/rutinas_validacion.js"></script>';?>
<form class="form-signin-mediano" name = 'form_registro' id = 'form_registro' autocomplete='off' action="<?php echo base_url() ?>Usuarios/Registro_post" method='POST'>
  <div data-role="content" id="contenido_pagina">

<?php
  $data = [
  'type'  => 'hidden',
  'name'  => 'id_usuario',
  'id'    => 'id_usuario',
  'value' => $usuario['id_usuario']
  ];
  echo form_input($data);
  $data = [
    'type'  => 'hidden',
    'name'  => 'activo',
    'id'    => 'activo',
    'value' => $usuario['activo']
    ];
    echo form_input($data);
    $data = [
      'type'  => 'hidden',
      'name'  => 'lista_roles',
      'id'    => 'lista_roles',
      'value' => ''
      ];
      echo form_input($data);    
  ?>
  
    <ul class="nav nav-pills">
      <li class="active"><a data-toggle="pill" href="#login_tab">Datos del usuario</a></li>
      <li><a data-toggle="pill" href="#permisos">Roles</a></li>
    </ul>

    <div class="tab-content" style="background-color: lavender;">
      <div id="login_tab" class="tab-pane fade in active">
        <div class="row">
          <div class="col-xs-12 ancho_fila">
            <label for="nom" class="control-label">Nombre de usuario</label>  
            <input type="text" autocomplete='off' class="form-control" name="d_usuario" id="d_usuario"  tabindex="1"  onkeyup="this.value = this.value.toUpperCase();" placeholder="Nombre de usuario" value="<?php if (isset($usuario['d_usuario'])) {echo $usuario['d_usuario'];} else {echo '';}?>"/>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3 ancho_fila">
            <label for="nom" class="control-label">Login</label>  
            <input type="text" class="form-control" name="login" id="login"  tabindex="2"  placeholder="Login" onkeyup="this.value = this.value.toUpperCase();" value="<?php if (isset($usuario['login'])) {echo $usuario['login'];} ?>"/>
          </div>
          <div class="col-xs-12 col-sm-3 ancho_fila">    
            <label for="pass" class="control-label">Contraseña</label>
            <input type="text" class="form-control" name="pass" id="pass"  tabindex="3"  placeholder="Contraseña" value="<?php if (isset($usuario['password'])) {echo $usuario['password'];} ?>" />
          </div>
          <div class="col-xs-12 col-sm-3 ancho_fila">
            <label for="nom" class="control-label">Sede</label>  
            <input type="text" class="form-control" name="sede" id="sede"  tabindex="4"  placeholder="Sede" value="<?php if (isset($usuario['sede'])) {echo $usuario['sede'];} ?>"/>
          </div>
          <div class="col-xs-12 col-sm-3 ancho_fila"><br>
            <input type="checkbox" id="cbx_activo" tabindex="5" name="cbx_activo" <?php if (isset($usuario['activo']) && ($usuario['activo'] == 1)){ echo " checked ";} ?> value="Activo">
            <label for="cbx_activo">Activo</label>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 ancho_fila">
            <label for="email" class="control-label">Email</label>
            <input type="text" class="form-control" name="email" id="email"  tabindex="6"  placeholder="Email" value="<?php if (isset($usuario['email'])) {echo $usuario['email'];} ?>"/>
            </div> 
        </div>  
      </div> 
      <div id="permisos" class="tab-pane fade">
        <div class="well" style="max-height: 300px;overflow: auto;">
          <div class="list-group checkbox-list-group" id="seleccion_roles" name = 'seleccion_roles'>
          <?php
          foreach ($roles as $item=>$fields) { 
            echo '<div class="list-group-item"  id = "a_'.$fields['id_rol'].
            ' name = "a_'.$fields['id_rol'].'"><label>&nbsp;<input type="checkbox" 
            id="cbx_'.$fields['id_rol'].'"'.($fields['habilitado']==1?' checked ':'').'><span class="list-group-item-text">'.
            $fields['d_rol'].'</span></label></div>';          }
          ?>
          </div>
        </div>
      </div>

    <?php if ($error): ?>
      <?php echo '<div class="alert alert-danger alert-dismissible">'.$error."</div>" ?> 
    <?php endif; ?>
    <?php if ((isset($mensaje_ok) && ($mensaje_ok != ''))): ?>
      <?php echo '<div class="alert alert-success">'.$mensaje_ok."</div><br>" ?> 
    <?php endif; ?>

    <?php 
      echo '<div class="row contenedor_botones">';
      echo '<button type="button" class="btn boton"  onclick="validateForm()" data-theme="b" style="margin:20px" value="Grabar" title="Grabar">Grabar</button><br>';
      echo '<a href='.base_url().'Usuarios/consultar class="btn boton" style="margin:20px" role="button"> Cancelar </a>';                
      echo '</div>';
    ?>
    </div>   <!--fin tab content -->

  </div>   <!--fin content -->
</form>

<script>

function Completo(field, pax) {
    if (!(CompletoDato (field, pax) )){
      field.focus();
      return false;
    } else {
      return true;
    } 
  }   

function validateIngresoCheckbox (radios) {
    for (i = 0; i < radios.length; ++ i) {
        if (radios [i].checked) return true;
    }
}

function validateForm() {
var ls_roles = '';
if (!(Completo (document.getElementById('d_usuario'),'Nombre de usuario') )){return false;}
if (!(Completo (document.getElementById('login'),'Login') )){return false;}
if (!(Completo (document.getElementById('pass'),'Password') )){return false;}
if (!(Completo (document.getElementById('sede'),'Sede') )){return false;}
if (document.getElementById("cbx_activo").checked) {
  $("#activo").val(1);
} else {
  $("#activo").val(0);
}
if (!(validarMail (document.getElementById('email'),true) )){return false;}

$('#seleccion_roles input:checked').each(function() {
    id_rol = this.id;
    id_rol = id_rol.replace("cbx_", "");
    if (ls_roles != '') {ls_roles = ls_roles + ',';}
    ls_roles = ls_roles + id_rol;
});
$("#lista_roles").val(ls_roles);
document.getElementById('form_registro').submit();
} 
</script>