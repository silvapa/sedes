<form class="form-signin-grande" name = 'form_total' id = 'form_total' action="<?php echo base_url() ?>Constancias/constancias_post" method='POST'>
<div data-role="content"  id="div_scroll"> 
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
    </div>
    <div id = "row"><div id = "col" class="linea_angosta"></div></div>
    <?php if (($error == '') && (count($datos) > 0)): ?> 
        <div class="row texto_cabecera">
            <div class="col-xs-8 col-sm-8 col-md-8"> 
            <?php
                echo "<p align='left' style='margin-left: 10px;'>Alumno: ".$datos[0]['apellido'].", ".$datos[0]['nombre']."</p>";
            ?>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4"> 
            <?php
                echo "<p align='right' style='margin-right: 10px;'>DNI: ".$datos[0]['dni']."</p>";
  /*               echo "<input type='hidden' name='clave' id='clave' value=".$datos[0]['clave'].">"; 
                echo "<input type='hidden' name='anio'  id='anio' value=".$datos[0]['anio'].">"; */
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4" > 


         <div class="card">
<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
            <div class="card-body">
              <h4 class="card-title">Datos del alumno</h4>
                <div class="row card-text">
                     <div class="col-xs-4 col-sm-4 col-md-4"> 
                        <p class = 'clase_label'>Carrera:</p>
                     </div>
                     <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p><?php echo $datos[0]['carrera']." - ".$datos[0]['d_carrera']; ?></p>
                     </div>   
                </div>      
                <div class="row" style="margin-top: 15px">
                    <div class="col-xs-4 col-sm-4 col-md-4"> 
                        <p class = 'clase_label'>Opción 1:</p>
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

                <div class="row" style="margin-top: 15px">
                    <div class="col-xs-4 col-sm-4 col-md-4"> 
                        <p class = 'clase_label'>Opción 2:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <?php 
                            if (isset($datos[0]['sede2']) && ($datos[0]['sede2'] > 0)) {
                                echo '<p>'.$datos[0]['sede2']." - ".$datos[0]['d_sede2'].'</p>'; 
                                echo '<p>TURNO '.$datos[0]['turno2']." - ".$datos[0]['d_turno2'].'</p>';
                            } else {
                                echo '<p>No seleccionada</p>'; 
                            }
                            ?>                        
                     </div>   
                </div>      


  
            </div>
</div>




            </div>

<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
             <div class="col-xs-8 col-sm-8 col-md-8"> 
         <div class="card">
           <div class="card-body">
              <h4 class="card-title">El alumno presenta la siguiente documentacion</h4>
                <div class="row card-text">
                    <div class="col-xs-8 col-sm-8 col-md-8">
                     <div class = "radio"  >
                        <label><input type = "radio" name = "rcondicion" value = "1" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 1)) echo "checked";?> <?php if ((isset($datos[0]['dni']) and ($dni_activo <> 0))) {echo "autofocus";} ?>>Titulo legalizado por UBA</label>
                    </div>
                    <div class = "radio">
                        <label><input type = "radio" name = "rcondicion" value = "2" <?php if(isset($datos[0]['rcondicion']) & ($datos[0]['rcondicion'] == 2)) echo "checked"?>>Titulo sin legalizar o constancia</label>
                    </div> 
                   <?php
                    if (isset($datos[0]['trabaja'])) {
                        if ($datos[0]['trabaja'] == 0) { 
                            echo "<br><p><b>NO TRABAJA</b></p>";
                        } else
                        { 
                            echo "<p><b>TRABAJA</b></p>";
                            echo "<div class = 'custom-control custom-checkbox'>";
                            echo "    <input type='checkbox' class='custom-control-input' name='cbx_trabaja' id='cbx_trabaja' value = '1'";
                            if (isset($datos[0]['rtrabaja']) & ($datos[0]['rtrabaja'] == 1)){ 
                                echo " checked ";
                            };
                            echo "    />";
                            echo "    <label class='custom-control-label' for ='cbx_trabaja'>Presenta certificado de trabajo</label>";
                            echo "</div>";
                        }
                    }
                    ?>

                <?php
                if ((isset($datos[0]['debe']) && ($datos[0]['debe'] == 2))) {
                    echo "<p><b>CERTIFICADO DE IDIOMA</b></p>";
                    echo '<div class = "radio"  >';
                    if (isset($datos[0]['presenta']) && ($datos[0]['presenta'] == 0)){
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type = "radio" name = "presenta" value = "0" '. $checked.'>No corresponde</label></div>';
                    echo '<div class = "radio"  >';
                    if (isset($datos[0]['presenta']) && ($datos[0]['presenta'] == 1)){
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type = "radio" name = "presenta" value = "1" '. $checked.'>PRESENTA certificado</label></div>';
                    echo '<div class = "radio"  >';
                    if (isset($datos[0]['presenta']) && ($datos[0]['presenta'] == 2)){
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    echo '<label><input type = "radio" name = "presenta" value = "2" '. $checked.'>NO PRESENTA certificado</label></div>';
                echo '</div><br>';

                }
                ?>


                   </div>                     


                    <div class="col-xs-4 col-sm-4 col-md-4"> 
                        <?php if (isset($datos[0]['sede1']) && ($datos[0]['sede1'] > 0)) {
                           
                            echo '<button type="submit" class="btn boton" data-theme="b" style="margin:20px"  value="Grabar" title="Grabar">Grabar</button><br>';
                            echo '<a href="<?php echo base_url() ?>Constancias/Consultar" class="btn boton" style="margin:20px" role="button"> Cancelar </a>';
                            echo '<br>';
                            
                        };    
                        ?>
        </div>
                 </div>
            

            </div>
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

function LimpiarClave() {
 /*   document.getElementById('clave').value = -1;
    document.getElementById('clave').innerHTML = -1;*/
    document.getElementById('accion').value = 'B';
//    document.getElementById('accion').innerHTML = 'B';    
}

</script>
