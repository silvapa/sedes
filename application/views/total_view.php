<form class="form-signin-grande" name = 'form_total' id = 'form_total' action="<?php echo base_url() ?>Constancias/constancias_post" method='POST'>
<div data-role="content"  id="div_scroll"> 

<input type='hidden' name='accion'  id='accion' value="<?php echo $accion;?>">
        <input type='hidden' name='dni_activo'  id='dni_activo' value="<?php echo $dni_activo;?>">

        <?php if ((count($datos) == 0) or ($error != '') /*((isset($datos[0]['presencial']) && ($datos[0]['presencial'] == 1)) && ((! (isset($datos[0]['sede1']))) or ($datos[0]['sede1'] == 0)))*/): ?>

    <div class="clase_encabe">
            DNI:
            <input type='text' name='dni' id='dni' value="" placeholder="D.N.I." <?php if (!(isset($dni_activo) or ($dni_activo==0))) {echo "autofocus";} ?> >
            <button type="submit" class="btn boton" data-theme="b" value="Buscar" onclick="LimpiarClave()" title="Buscar">Buscar</button>
            
        <a href="<?php echo base_url() ?>Main/Principal" class="btn boton pull-right" role="button"> Volver </a></br>
    </div>
    <?php endif; ?>


<!-- 
    <div class="clase_encabe">
        <input type='hidden' name='accion'  id='accion' value="<?php echo $accion;?>">
        <input type='hidden' name='dni_activo'  id='dni_activo' value="<?php echo $dni_activo;?>">
        <table class="table-responsive">
            <tr>
                <td>DNI:</td>
                <td><input type='text' name='dni' id='dni' value="" placeholder="D.N.I." <?php if (!(isset($dni_activo) or ($dni_activo==0))) {echo "autofocus";} ?> ></td>
                <td><button type="submit" class="btn boton" data-theme="b" value="Buscar" onclick="LimpiarClave()" title="Buscar">Buscar</button></td>
                <td><a href="<?php echo base_url() ?>Main/Principal" class="btn boton pull-right" role="button"> Volver </a><br></td>
            </tr>
        </table>
    </div> -->
    <div id = "row"><div class="linea_angosta"></div></div>
    <?php if (/*($error == '') &&*/ (count($datos) > 0)): ?> 
        <div class="row texto_cabecera" style="margin-right: 0px;margin-left: 0px;">
            <?php
            echo $datos[0]['apellido'].", ".$datos[0]['nombre']
            ?>

<!--             <div class="col-xs-8 col-sm-8 col-md-8"> 
            <?php
                //echo "<p align='left' style='margin-left: 10px;'>Alumno: ".$datos[0]['apellido'].", ".$datos[0]['nombre']."</p>";
            ?>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4"> 
            <?php
             //   echo "<p align='right' style='margin-right: 10px;'>DNI: ".$datos[0]['dni']."</p>";
            ?>
            </div> -->
        </div>
        <div id = "row"><div class="Lines4"></div></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4" > 


         <div class="card">
<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
            <div class="card-body">
                <h4 class="card-title text-center">Datos del alumno</h4>
                <div id = "row"><div id = "col" class="linea_angosta"></div></div><br>
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
                       <p><?php echo $datos[0]['carrera']." - ".$datos[0]['d_carrera']; ?></p>
                     </div>   
                </div>      

                <div class="row" style="margin-top: 10px">
                     <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'><?php if (isset($datos[0]['d_nacionalidad']) && ($datos[0]['d_nacionalidad'] != '')) {echo "NACIONALIDAD:";} ?></p>
                     </div>
                     <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p><?php echo $datos[0]['d_nacionalidad']; ?></p>
                     </div>   
                </div>      
                <?php if (isset($datos[0]['presencial']) && ($datos[0]['presencial'] == 1)): ?> 
                <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>OPCI&Oacute;N 1:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <?php 
                            if (isset($datos[0]['sede1']) && ($datos[0]['sede1'] > 0)) {
                                echo '<p>'.$datos[0]['sede1']." - ".$datos[0]['d_sede1'].'</p>'; 
                                echo '<p>TURNO '.$datos[0]['turno1']." - ".$datos[0]['d_turno1'].'</p>';
                            } else {
                                echo '<p>No seleccionada</p>'; 
                            }
                        ?>                        
                     </div>   
                </div>      

                <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>OPCI&Oacute;N 2:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <?php 
                            if (isset($datos[0]['sede2']) && ($datos[0]['sede2'] > 0)) {
                                echo '<p>'.$datos[0]['sede2']." - ".$datos[0]['d_sede2'].'</p>'; 
                                echo '<p>TURNO '.$datos[0]['turno2']." - ".$datos[0]['d_turno2'].'</p>';
                            } else {
                                echo '<p>No seleccionada</p><br>'; 
                            }
                            ?>                        
                     </div>   
                </div>      
                <?php endif; ?> 


                <?php if (isset($datos[0]['presencial']) &&  ($datos[0]['presencial'] == 0)): ?> 
                <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>MODALIDAD:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <?php 
                            echo '<p>No presencial</p>'; 
                        ?>                        
                     </div>   
                </div>      
                <?php endif; ?> 

                <?php if (!(isset($datos[0]['presencial'])) or (is_null($datos[0]['presencial']))): ?> 
                <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>MODALIDAD:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <?php 
                            echo '<p>No elegida</p>'; 
                        ?>                        
                     </div>   
                </div>      
                <?php endif; ?> 


            </div>
        </div>




    </div>

<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
        <div class="col-xs-12 col-sm-12 col-md-8"> 
         <div class="card">
           <div class="card-body">
              <h4 class="card-title text-center">El alumno presenta la siguiente documentaci&oacute;n</h4>
              <div id = "row"><div id = "col" class="linea_angosta"></div></div><br>
                <div class="row card-text">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                    <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <p><b>T&Iacute;TULO SECUNDARIO</b></p>
                         <div class = "radio"  >
                            <label><input type = "radio" <?php echo $habilitado; ?> name = "rcondicion" value = "13" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 13)) echo "checked";?> <?php if ((isset($datos[0]['dni']) and ($dni_activo <> 0))) {echo "autofocus";} ?>>T&iacute;tulo legalizado por UBA</label>
                        </div>
                        <div class = "radio">
                            <label><input type = "radio" <?php echo $habilitado; ?> name = "rcondicion" value = "12" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 12)) echo "checked"?>>T&iacute;tulo sin legalizar</label>
                        </div> 
                        <div class = "radio">
                            <label><input type = "radio" <?php echo $habilitado; ?> name = "rcondicion" value = "32" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 32)) echo "checked"?>>Constancia de t&iacute;tulo en t&aacute;mite</label>
                        </div> 
                        <div class = "radio">
                            <label><input type = "radio" <?php echo $habilitado; ?> name = "rcondicion" value = "23" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 23)) echo "checked"?>>Convalidaci&oacute;n legalizada</label>
                        </div> 
                        <div class = "radio">
                            <label><input type = "radio" <?php echo $habilitado; ?> name = "rcondicion" value = "22" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 22)) echo "checked"?>>Convalidaci&oacute;n sin legalizar</label>
                        </div> 
                    </div> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                       <?php
                   /*     if (isset($datos[0]['trabaja'])) {
                            if ($datos[0]['trabaja'] == 0) { 
                                echo "<p class='text-center'><b>NO TRABAJA</b></p>";
                            } else
                            { 
*/
                                echo "<p><b>TRABAJA?</b></p>";
                                echo "<div class = 'custom-control custom-checkbox' >";
                                echo "    <input type='checkbox' " . ($puede_escribir ? '' : 'disabled ') . "class='custom-control-input'  name='cbx_trabaja' id='cbx_trabaja' value = '2'";
                                if (isset($datos[0]['rtrabaja']) && ($datos[0]['rtrabaja'] == 2)){ 
                                    echo " checked ";
                                };
                                echo "    />";
                                echo "    <label class='custom-control-label' for ='cbx_trabaja' style='font-weight: normal;'>Presenta certificado de trabajo</label>";
                                echo "</div>";
 /*                           }
                        }*/
                        ?>
                    </div> 
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <?php
                        if ((isset($datos[0]['debe']) && ($datos[0]['debe'] == 2))) {
                            echo "<p><b>CERTIFICADO DE IDIOMA</b></p>";
                            echo '<div class = "radio" >';
                            if (isset($datos[0]['presenta']) && ($datos[0]['presenta'] == 4)){
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }
                            $checked = ($puede_escribir ? $checked : $checked.' disabled ');
                            echo '<label><input type = "radio"  id = "presenta" name = "presenta" value = "4" '. $checked.'>No corresponde</label></div>';
                            echo '<div class = "radio"  >';
                            if (isset($datos[0]['presenta']) && ($datos[0]['presenta'] == 2)){
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }
                            $checked = ($puede_escribir ? $checked : $checked.' disabled ');
                            echo '<label><input type = "radio"  id = "presenta" name = "presenta" value = "2" '. $checked.'>PRESENTA certificado</label></div>';
                        /*    echo '<div class = "radio"  >';
                            if (isset($datos[0]['presenta']) && ($datos[0]['presenta'] == 1)){
                                $checked = 'checked';
                            } else {
                                $checked = '';
                            }
                            echo '<label><input type = "radio" name = "presenta" value = "1" '. $checked.'>NO PRESENTA certificado</label></div>';
                        */
                       // echo '</div><br>';

                        }
                        ?>
                    </div> 
                </div>                   
            </div>                     
            </div>                   

            <?php if ($error == '') /*(!(isset($datos[0]['presencial'])) or ($datos[0]['presencial'] != 1) or (($datos[0]['presencial'] == 1) && (isset($datos[0]['sede1']) && ($datos[0]['sede1'] > 0))))*/ {
            echo '<div class="row contenedor_botones">';
            if ($puede_escribir) {
                echo '<button type="button" class="btn boton"  onclick="validateForm()" data-theme="b" style="margin:20px" value="Grabar" title="Grabar">Grabar</button><br>';
                echo '<button type="button" class="btn boton"  onclick="LimpiarForm()" data-theme="b" style="margin:20px" value="Limpiar" title="Limpiar">Limpiar</button><br>';
                echo '<a href='.base_url().'Constancias/consultar class="btn boton" style="margin:20px" role="button"> Cancelar </a>';                
            }
            else {
                echo '<a href='.base_url().'Constancias/consultar class="btn boton" style="margin:20px" role="button"> Buscar Otro </a>';
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

function validateIngresoRadio (radios) {
    for (i = 0; i < radios.length; ++ i) {
        if (radios [i].checked) return true;
    }
}

function ResetRadio (radios) {
    for (i = 0; i < radios.length; ++ i) {
        radios [i].checked = false;
    }
}

function confirmar(){
	if (confirm('¿Estas seguro de reinicializar los datos cargados?')) {
		return true;
    }
	else {
		return false;
    }
}

function LimpiarForm() {
    ResetRadio (document.getElementsByName("rcondicion"));
    ResetRadio (document.getElementsByName("presenta"));
    document.getElementById("cbx_trabaja").checked = false;
    if (confirmar()) {
        document.getElementById('form_total').submit();
    }
}

function validateForm() {

  if (document.getElementsByName("rcondicion")== null)   {
      return true;
  }

  var accion = document.getElementById('accion').value;

   if (accion == 'G')  {
        if (!(validateIngresoRadio (document.getElementsByName("rcondicion")))) {
            alert("TITULO SECUNDARIO: Complete la documentación recibida");
            return false;
        }
        if (document.getElementById("presenta"))   {
            if (!(validateIngresoRadio (document.getElementsByName("presenta")))) {
                alert("IDIOMA: Complete la documentación recibida");
                return false;
            }
        }
  }
  document.getElementById('form_total').submit();
} 

function LimpiarClave() {
    document.getElementById('accion').value = 'B';
}

</script>
