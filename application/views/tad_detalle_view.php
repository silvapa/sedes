<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php echo '<script src="'.base_url().'application/assets/js/jquery2.1.1/jquery.min.js"></script>';
      echo '<script src="'.base_url().'application/assets/js/rutinas_validacion.js"></script>';?>
<form class="form-signin-grande" name = 'form_registro' id = 'form_registro' autocomplete='off' action="<?php echo base_url() ?>Tad/consultar()" method='POST'>
  <div data-role="content" id="contenido_pagina">

    <ul class="nav nav-pills">
      <li class="active"><a data-toggle="pill" href="#login_tab"><?php echo ($tad['t_tramite'] == 'I') ? 'Tramite de INSCRIPCION':(($tad['t_tramite'] == 'R') ? 'Tramite de REMATRICULACION '.substr($tad['t_tramite'],-5) : 'Tramite de DDJJ'); ?> </a></li> 
      <li><a data-toggle="pill" href="#procesos">Procesamiento</a></li>
    </ul>

    <div class="tab-content" style="background-color: lavender;">
      <div id="login_tab" class="tab-pane fade in active">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-2 ancho_fila">
            <label for="fecha_caratulacion" class="control-label">Fecha de Caratulacion</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="fecha_caratulacion" id="fecha_caratulacion"  tabindex="1"  placeholder="Fecha de caratulacion" value="<?php if (isset($tad['Fecha_caratulacion'])) {echo $tad['Fecha_caratulacion'];} else {echo '';}?>"/>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 ancho_fila">
            <label for="expediente" class="control-label"<?php
              switch ($tad['estado']) {
                case 'R':
                    echo " style='color:orange'> Expediente EN REVISION (".$tad['estado'].")";
                    break;
                case 'I':
                  echo " style='color:blue'> Expediente NO PROCESADO AUN (".$tad['estado'].")";
                  break;
                case 'G':
                  echo " style='color:blue'> Expediente EN PROCESO (".$tad['estado'].")";
                  break;
                case 'N':
                  echo " style='color:red'> Expediente IGNORADO (".$tad['estado'].")";
                  break;
                case 'P':
                  echo " style='color:green'> Expediente PROCESADO OK (".$tad['estado'].")";
                  break;
                  case 'E':
                    echo " style='color:green'> Expediente PROCESADO c/ERROR (".$tad['estado'].")";
                    break;
                  default :
                  echo ">Expediente (".$tad['estado'].")";
                  break;
              }
              ?>
            </label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="expediente" id="expediente"  placeholder="Expediente" value="<?php if (isset($tad['Expediente'])) {echo $tad['Expediente'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-4 ancho_fila">
            <label for="apellido" class="control-label">Apellido</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="apellido" id="apellido"  placeholder="Apellido" value="<?php if (isset($tad['APELLIDO_SOLICITANTE'])) {echo $tad['APELLIDO_SOLICITANTE'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-3 ancho_fila">
            <label for="nombre" class="control-label">Nombre</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="nombre" id="nombre"  placeholder="nombre" value="<?php if (isset($tad['NOMBRE_SOLICITANTE'])) {echo $tad['NOMBRE_SOLICITANTE'];} else {echo '';}?>"/>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-2 ancho_fila">
            <label for="NUMERO_DOCUMENTO" class="control-label">D.N.I.</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="NUMERO_DOCUMENTO" id="NUMERO_DOCUMENTO"  placeholder="DNI" value="<?php if (isset($tad['NUMERO_DOCUMENTO'])) {echo $tad['NUMERO_DOCUMENTO'];} else {echo '';}?>"/>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 ancho_fila">
            <label for="CUIT_CUIL" class="control-label">C.U.I.L.</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="CUIT_CUIL" id="CUIT_CUIL"  placeholder="CUIL" value="<?php if (isset($tad['CUIT_CUIL'])) {echo $tad['CUIT_CUIL'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-4 ancho_fila">
            <label for="EMAIL" class="control-label">Email</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="EMAIL" id="EMAIL"  placeholder="Email" value="<?php if (isset($tad['EMAIL'])) {echo $tad['EMAIL'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-3 ancho_fila">
            <label for="TELEFONO" class="control-label">Telefono</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="TELEFONO" id="TELEFONO"  placeholder="Telefono" value="<?php if (isset($tad['TELEFONO'])) {echo $tad['TELEFONO'];} else {echo '';}?>"/>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-2 ancho_fila">
            <label for="FECHA_NAC" class="control-label">Fecha Nacimiento</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="FECHA_NAC" id="FECHA_NAC"  placeholder="Fecha Nacimiento" value="<?php if (isset($tad['FECHA_NAC'])) {echo $tad['FECHA_NAC'];} else {echo '';}?>"/>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 ancho_fila">
            <label for="nom" class="control-label">Genero</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="GENERO" id="GENERO"  placeholder="Genero" value="<?php if (isset($tad['GENERO'])) {echo $tad['GENERO'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-4 ancho_fila">
            <label for="GENERO" class="control-label">Carrera</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="CARRERA_A_SEGUIR" id="CARRERA_A_SEGUIR"  placeholder="Carrera" value="<?php if (isset($tad['CARRERA_A_SEGUIR'])) {echo $tad['CARRERA_A_SEGUIR'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-3 ancho_fila">
            <label for="NACIONALIDAD" class="control-label">Nacionalidad</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="NACIONALIDAD" id="NACIONALIDAD"  placeholder="Nacionalidad" value="<?php if (isset($tad['NACIONALIDAD'])) {echo $tad['NACIONALIDAD'];} else {echo '';}?>"/>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-1 ancho_fila">
            <label for="REQUIERE_CERTIF_ESP" class="control-label">Cert.Español</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="REQUIERE_CERTIF_ESP" id="REQUIERE_CERTIF_ESP"  placeholder="Cert.Español" value="<?php if (isset($tad['REQUIERE_CERTIF_ESP'])) {echo $tad['REQUIERE_CERTIF_ESP'];} else {echo '';}?>"/>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2 ancho_fila">
            <label for="DISCAPACIDAD" class="control-label">Discapacidad</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="DISCAPACIDAD" id="DISCAPACIDAD"  placeholder="Discapacidad" value="<?php if (isset($tad['DISCAPACIDAD'])) {echo $tad['DISCAPACIDAD'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-2 ancho_fila">
            <label for="TRABAJA" class="control-label">Trabaja</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="TRABAJA" id="TRABAJA" placeholder="Trabaja" value="<?php if (isset($tad['TRABAJA'])) {echo $tad['TRABAJA'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-4 ancho_fila">
            <label for="DOC_ESTUDIOS_MEDIOS" class="control-label">Condicion</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="DOC_ESTUDIOS_MEDIOS" id="DOC_ESTUDIOS_MEDIOS" placeholder="Condicion" value="<?php if (isset($tad['DOC_ESTUDIOS_MEDIOS'])) {echo $tad['DOC_ESTUDIOS_MEDIOS'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-3 ancho_fila">
            <label for="OPCION_MAT_ELECTIVA" class="control-label">Materia electiva</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="OPCION_MAT_ELECTIVA" id="OPCION_MAT_ELECTIVA" placeholder="Materia electiva" value="<?php if (isset($tad['OPCION_MAT_ELECTIVA'])) {echo $tad['OPCION_MAT_ELECTIVA'];} else {echo '';}?>"/>
          </div>
        </div>

      </div> 

      <div id="procesos" class="tab-pane fade">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-2 ancho_fila">
            <label for="Estado" class="control-label">Estado</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="Estado" id="Estado"  tabindex="1" value="<?php
              switch ($tad['estado']) {
                case 'R':
                  echo "EN REVISION (".$tad['estado'].")";
                  break;
                case 'I':
                  echo "NO PROCESADO AUN (".$tad['estado'].")";
                  break;
                case 'G':
                  echo "EN PROCESO (".$tad['estado'].")";
                  break;
                case 'N':
                  echo "IGNORADO (".$tad['estado'].")";
                  break;
                case 'P':
                  echo "PROCESADO OK (".$tad['estado'].")";
                  break;
                case 'E':
                  echo "PROCESADO c/ERROR (".$tad['estado'].")";
                  break;
                default :
                  echo "(".$tad['estado'].")";
                  break;
              }
              ?>"/>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2 ancho_fila">
            <label for="f_estado" class="control-label">Fecha estado</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="f_estado" id="f_estado" value="<?php if (isset($tad['f_estado'])) {echo $tad['f_estado'];} else {echo '';}?>"/>
          </div>
      <!--     <div class="col-xs-12 col-sm-6 col-md-4 ancho_fila">
          <label for="mensaje" class="control-label">Mensaje</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="mensaje" id="mensaje"  placeholder="mensaje" value="<?php if (isset($tad['mensaje'])) {echo $tad['mensaje'];} else {echo '';}?>"/>
          </div> -->
          <div class="col-sm-6 col-md-2 ancho_fila">
            <label for="d_mail_enviado_cbc" class="control-label">Envio de mail CBC</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="d_mail_enviado_cbc" id="d_mail_enviado_cbc" value="<?php if (isset($tad['d_mail_enviado_cbc'])) {echo $tad['d_mail_enviado_cbc'];} else {echo 'No se envio mail';}?>"/>
          </div>
          <div class="col-sm-6 col-md-6 ancho_fila">
            <label for="d_t_mail_enviar_cbc" class="control-label">Tipo de Mail CBC</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="d_t_mail_enviar_cbc" id="d_t_mail_enviar_cbc" value="<?php if (isset($tad['d_t_mail_enviar_cbc'])) {echo $tad['d_t_mail_enviar_cbc'];} else {echo '';}?>"/>
          </div>
        </div>
       <br>
        <div class="row">
          <div class="col-sm-12 col-md-2 ancho_fila">
            <label for="guardado_exitoso" class="control-label">Alta en Guarani</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="guardado_exitoso" id="guardado_exitoso" value="<?php if (isset($tad['guardado_exitoso'])) {echo $tad['guardado_exitoso'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-2 ancho_fila">
            <label for="fecha_subida_archivo" class="control-label">Fecha subida ASPIRANTES</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="fecha_subida_archivo" id="fecha_subida_archivo" value="<?php if (isset($tad['fecha_subida_archivo'])) {echo $tad['fecha_subida_archivo'];} else {echo '';}?>"/>
          </div>                    
          <div class="col-sm-12 col-md-2 ancho_fila">
            <label for="mail_enviado_cbc" class="control-label">Mail ASPIRANTES</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="email_enviado" id="email_enviado" value="<?php if (isset($tad['email_enviado'])) {echo $tad['email_enviado'];} else {echo '';}?>"/>
          </div>
          <div class="col-sm-12 col-md-6 ancho_fila">
            <label for="mensaje_error" class="control-label">Mensaje de error ASPIRANTES</label>  
            <input readonly type="text" autocomplete='off' class="form-control" name="mensaje_error" id="mensaje_error" value="<?php if (isset($tad['mensaje_error'])) {echo $tad['mensaje_error'];} else {echo '';}?>"/>
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
      echo '<a href='.base_url().'Tad/consultar class="btn boton" style="margin:20px" role="button"> Volver </a>';                
      echo '</div>';
    ?>
    </div>   <!--fin tab content -->

  </div>   <!--fin content -->
</form>
