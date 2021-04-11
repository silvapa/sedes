<form class="form-signin-grande" name = 'form_total' id = 'form_total' action="<?php echo base_url() ?>Emails/constancias_post" method='POST'>
<div data-role="content"  id="div_scroll"> 
 
<input type='hidden' name='accion'  id='accion' value="<?php echo $accion;?>">
        <input type='hidden' name='dni_activo'  id='dni_activo' value="<?php echo $dni_activo;?>">
        <input type='hidden' name='anio_activo'  id='anio_activo' value="<?php echo $anio_activo;?>">
        <input type='hidden' name='clave_activo'  id='clave_activo' value="<?php echo $clave_activo;?>">

        <?php if ((count($datos) == 0) or ($error != '') ): ?>

    <div class="clase_encabe">
            DNI:
            <input type='text' name='dni' id='dni' value="" placeholder="D.N.I." <?php if (!(isset($dni_activo) or ($dni_activo==0))) {echo "autofocus";} ?> >
            <button type="submit" class="btn boton" data-theme="b" value="Buscar" onclick="LimpiarClave()" title="Buscar">Buscar</button>
            <a href="<?php echo base_url() ?>reportes/Alumnos_sin_mails.xls" target="_blank"> Listado Alumnos Sin Mail </a>
        <a href="<?php echo base_url() ?>Main/Principal" class="btn boton pull-right" role="button"> Volver </a></br>

    </div>
    <?php endif; ?>



    <div id = "row"><div class="linea_angosta"></div></div>
    <?php if ( (count($datos) > 0)): ?> 
        <div class="row texto_cabecera" style="margin-right: 0px;margin-left: 0px;">
            <?php
            echo $datos[0]['apellido'].", ".$datos[0]['nombre']
            ?>

        </div>
        <div id = "row"><div class="Lines4"></div></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4" > 


         <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Datos del alumno</h4>
                <div id = "row"><div id = "col" class="linea_angosta"></div></div><br>
                  <div class="row card-text">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>CLAVE:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p style="font-size: 17px"><b><?php echo $datos[0]['clave']."/".$datos[0]['anio']; ?></b></p>
                    </div>   
                  </div>
                  <div class="row card-text">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>DNI:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p style="font-size: 17px"><b><?php echo $datos[0]['dni']; ?></b></p>
                    </div>   
                  </div>
                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>CARRERA:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p>
                       <?php echo $datos[0]['carrera'] ." - ".$d_carrera; ?>
                       </p>
                    </div>   
                  </div>      

            </div>
        </div>




    </div>

<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
        <div class="col-xs-12 col-sm-12 col-md-8"> 
         <div class="card">
           <div class="card-body">
              <h4 class="card-title text-center">El alumno informa</h4>
              <div id = "row"><div id = "col" class="linea_angosta"></div></div><br>
                <div class="row card-text">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                            <div class = "text"  >
                                <br>
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" maxlength="100" size="100">
                        </div>
                    </div> 

                </div>                   
            </div>                     
            </div>                   

            <?php if ($error == '')  {
            echo '<div class="row contenedor_botones">';
            if ($puede_escribir) {
                echo '<button type="button" class="btn boton"  onclick="validateForm()" data-theme="b" style="margin:20px" value="Grabar" title="Grabar">Grabar</button><br>';
                echo '<button type="button" class="btn boton"  onclick="LimpiarForm()" data-theme="b" style="margin:20px" value="Limpiar" title="Limpiar">Limpiar</button><br>';
                echo '<a href='.base_url().'Emails/consultar class="btn boton" style="margin:20px" role="button"> Cancelar </a>';                
            }
            else {
                echo '<a href='.base_url().'Emails/consultar class="btn boton" style="margin:20px" role="button"> Buscar Otro </a>';
            }
            echo '</div>';
            };    
            ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <?php echo '<div class="alert alert-danger alert-dismissible text-center">'.$error."</div>" ?> 
      <?php endif; ?>
      <?php if ($mensaje): ?>
      <?php echo '<div class="alert alert-info alert-dismissible text-center">'.$mensaje."</div>" ?> 
      <?php endif; ?>
</div>
</form>

<script type="text/javascript">

function confirmar(){
	if (confirm('¿Estas seguro de reinicializar los datos cargados?')) {
		return true;
    }
	else {
		return false;
    }
}

function LimpiarForm() {
  document.getElementById("email").value="";
}

function validarEmail() {
    var texto = document.getElementById("email").value;
    var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    if (regex.test(texto)) {
        //alert("La dirección de email " + texto + " es correcta.");
        return true;
    } else {
        //alert("La dirección de email es incorrecta.");
        return false;
    }
}

function validateForm() {
   var accion = document.getElementById('accion').value;
   if (accion == 'G')  {
        if (validarEmail() ){
            document.getElementById('form_total').submit();
            return true;
        }else{
            alert('El email ingresado no es válido');  
            return false;
        }
   }else{
        if (document.getElementById("email")== null)   {
            document.getElementById('form_total').submit();
            return true;
        }
   }

} 

function LimpiarClave() {
    document.getElementById('accion').value = 'B';
}

</script>
