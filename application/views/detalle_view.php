
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<?php echo '<script src="'.base_url().'application/assets/js/jquery2.1.1/jquery.min.js"></script>';
      echo '<script src="'.base_url().'application/assets/js/rutinas_validacion.js"></script>';?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php function insert_doble_input($label1, $valor1, $label2, $valor2) {
  echo'<div class="row card-text"> ';
    echo '<div class="col-xs-4 col-sm-2 col-md-2" style="padding-right: 0px;">'; 
        echo '<p class = "clase_label">'.$label1.'</p>';
    echo '</div>';
    echo '<div class="col-xs-8 col-sm-2 col-md-2"> ';
      echo '<p class = "clase_valor">'.$valor1.'</p>';
    echo '</div>';   
    echo '<div class="col-xs-2 col-sm-2 col-md-2" style="padding-right: 0px;"> ';
        echo '<p class =  "clase_label">'.$label2.'</p>';
    echo '</div>';
    echo '<div class="col-xs-9 col-sm-6 col-md-6">'; 
      echo '<p class = "clase_valor">'.$valor2.'</p>';
    echo '</div>';   
  echo '</div> '; 
}
function insert_simple_input2($label1, $valor1) {
  echo'<div class="row card-text"> ';
    echo '<div class="col-xs-4 col-sm-2 col-md-2" style="padding-right: 0px;">'; 
        echo '<p class = "clase_label">'.$label1.'</p>';
    echo '</div>';
    echo '<div class="col-xs-8 col-sm-10 col-md-10"> ';
      echo '<p class = "clase_valor">'.$valor1.'</p>';
    echo '</div>';   
  echo '</div> '; 
}
?>

<?php function insert_simple_input($label1, $valor1) {
  echo'<div class="row card-text"> ';
    echo '<div class="col-xs-6 col-sm-6 col-md-6" style="padding-right: 0px;">'; 
        echo '<p class = "clase_label">'.$label1.':</p>';
    echo '</div>';
    echo '<div class="col-xs-6 col-sm-6 col-md-6"> ';
      echo '<p class = "clase_valor">'.$valor1.'</p>';
    echo '</div>';   
  echo '</div>';
}
?>

<form class="form-signin-grande" name = 'form_asigna' id = 'form_asigna' action="<?php echo base_url() ?>Padron/consultar" method='POST'>
  <div data-role="content"  id="div_scroll"> 
    <ul class="nav nav-pills">
      <li class="active"><a data-toggle="pill" href="#ficha">Datos del alumno</a></li>
      <li><a data-toggle="pill" href="#Asignacion">Asignacion</a></li>
      <?php
      if (in_array('7R',$permisos) || (in_array('7C',$permisos))) {
        echo '<li><a data-toggle="pill" href="#Historial">Historial</a></li>';
      } 
      ?> 
      <button type="submit" class="btn boton pull-right" data-theme="b" value="Buscar" title="Buscar">Buscar Otro</button>
    </ul>
    <div class="tab-content" style="background-color: lavender;">

      <div id="ficha" class="tab-pane fade in active">
        <div class="card" style="background-color: #d9edf7;">
          <div class= <?php echo ($condicion == 3 ? '"card-header texto_cabecera_atencion"' : '"card-header texto_cabecera"');?> 
              <?php echo ($sancion == 'T' ? 'style = "color : red"' : '')?> >
              <?php echo $apellido.", ".$nombre;?>
              <?php echo '<p class="pull-right" style="font-size:16px">'.$calidad."</p>";?>
          
          </div>
          <div class="card-body">
            <?php               
            if ($condicion == 3) {
              echo '<p class="form-signin-heading" style="font-size:16px;color:darkred">Alumno en condicion 3</p>';
            }
            if ($condicion == 4) {
              echo '<div class="alert alert-danger">Debe presentar documentacion respaldatoria</div>' ;
            }
            $col = (count($total) > 0)?10:12;
            echo '<div class="row" style="margin-top: 10px;border: 0;border-top: 1px solid #e5e5e5; padding-top:5px"> ';
              echo '<div class="col-xs-12 col-sm-'.$col.' col-md-'.$col.'" style="padding-right: 0px;"> ';
                insert_doble_input('CLAVE:',$clave ."/". $anio,'CARRERA:',$carrera." - ".$d_carrera);
                insert_doble_input('DNI:',$dni,'',isset($carrera2)?$carrera2." - ".$d_carrera2:'');
                insert_doble_input('CUIL:',$cuil,'',isset($carrera3)?$carrera3." - ".$d_carrera3:'');
                insert_doble_input('CUAT.INGRESO:',$cuating,'',isset($carrera4)?$carrera4." - ".$d_carrera4:'');
                insert_doble_input('TITULO:',$condicion,'',isset($carrera5)?$carrera5." - ".$d_carrera5:'');
                insert_doble_input('FECHA NACIM.:',$fecha_naci,'','');
                insert_doble_input('REGULAR:',$regular,'','');
                insert_doble_input('BAJA:',$baja,'','');
                insert_doble_input('IDIOMA:',isset($idioma)?$idioma:'-','','');
                insert_doble_input('SEXO:',$sexo,'',''); 
                insert_simple_input2('NACIONALIDAD:',$d_nacionalidad);
              ?>  
              </div>
              <div class="col-xs-12 col-sm-2 col-md-2" style="padding-right: 0px;">        
                <?php if (count($total) > 0 ): ?>   
                  <div class="row" style="margin-top: 10px;border: 0;border-top: 1px solid #e5e5e5; padding-top:5px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>PAQUETE:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                      <?php echo '<p class = "clase_valor">'.$paquete.'</p>'; ?>                        
                    </div>   
                  </div>      
                <?php endif; ?> 
              </div>
            </div>
          </div>
        </div>
      </div> <!--  fIN DIV TAB Ficha -->
      
      <div id="Asignacion" class="tab-pane fade">
        <div class="card">
        <div class= <?php echo ($condicion == 3 ? '"card-header texto_cabecera_atencion"' : '"card-header texto_cabecera"');?> <?php echo ($sancion == 'T' ? 'style = "color : red"' : '')?> >
              <?php
                echo $apellido.", ".$nombre;
                ?>
              <?php
                echo '<p class="pull-right" style="font-size:16px">'.$calidad."</p>";
                ?>
                
              </div>
          <div class="card-body">
          <?php if (($error == '') && ((count($alumnos) > 0) || count($xxi) > 0)): ?>
            <div class="row">
            <?php $columna = (CUAT_LECTIVO != 1) ? 6 : 12;
              echo '<div class="col-xs-12 col-sm-"'.$columna.' style="margin-top: 10px">'; ?>
                <div class="row">
                  <table class="table table-striped table-bordered table-responsive" id="tabla_1">
                  <thead>
                  <tr>
                    <th colspan=7 style="text-align:center; font-size:16px">A s i g n a c i &oacute; n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("Y"); ?></th>
                  </tr>        
                  <tr style="text-align:center">
                      <th style='padding:3px' width="02%">Cuat</th>
                      <th style='padding:3px' width="05%">Sede</th>
                      <th style='padding:3px' width="35%">Materia</th>
                      <th style='padding:3px' width="25%">Horario</th>
                      <th style='padding:3px' width="05%">Aula</th>
                      <th style='padding:3px' width="10%">Comision</th>
                      <th style='padding:3px' width="20%">Catedra</th>
                  </tr>        
                  </thead>
                  <tbody>  
                    <?php
                    $cuantos = 0; 
                    $cuat = 0;
                      foreach ($alumnos as $item=>$fields) { 
                          if (($cuat == 2) && ($fields['cuat'] == 1) ) {
                            echo "<tr style='border-top-width:1px'>";
                          }
                          else {
                            echo "<tr>";
                          } 
                        //if ($fields['cuat'] == 1) {
                          $cuat = $fields['cuat'];
                          $cuantos++;
                          echo "<td class = 'disable-selection'>".$fields['cuat']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['sede']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['materia'].'-'.$fields['d_materia']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['horario'].'-'.$fields['d_horario']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['aula']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['comision']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['catedra']."</td>";
                          echo "</tr>";
                        //}
                      }
                      if ($cuantos < 7) {
                        for ($i = $cuantos; $i < 7; $i++)    {
                          echo "<tr>";
                          $cuantos++;
                          echo "<td class = 'disable-selection'>&nbsp</font></td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "</tr>";
                        }
                      }
                    ?>
                  </tbody>
                  </table>
                </div>
                <div class="row" style="margin-top: 10px">
                  <?php
                    $cuantos = 0;
                    $novedades = '';
                    foreach ($alumnos as $item=>$fields) { 
                        //if ($fields['cuat'] == 1) {
                          if ($fields['d_novedad'] != null) {
                            $novedades = $novedades . $fields['materia'].': '. $fields['d_novedad']. "<br>" ;
                            $cuantos ++;
                          }
                        //}
                      }
                      foreach ($xxi as $item=>$fields) { 
                        if (($fields['cuat'] == 1) || ($fields['cuat'] == 0)) {
                          if ($fields['d_novedad'] != null) {
                            $novedades = $novedades . $fields['materia'].': '. $fields['d_novedad']. "<br>" ;
                            $cuantos ++;
                          }
                        }
                      }
                      if (isset($moodle)) {
                        foreach ($moodle as $item=>$fields) { 
                          $novedades .= $fields['comision'].': ';
                          if ($fields['estado']=='SI') {
                            $novedades .= 'Matriculado en Moodle.';
                          }else{
                            if ($fields['estado']=='NO') {
                              $novedades .= 'En proceso de matriculaci&oacute;n en Moodle.';
                            }else{
                              $novedades .= 'En aula virtual Citep.';
                            }
                          }
                          $novedades .= "<br>" ;
                          $cuantos ++;
                    }                  
                      }
                      if ($cuantos != 0) {
                        echo '<div class="panel panel-info">';
                        echo '<div class="panel-heading"><b>Novedades Materias: </b></div>';
                        echo '<div class="panel-body">'.$novedades.'</div>';
                        echo '</div>';
                      }
                    ?>
                </div>            
              </div>
              <?php if (CUAT_LECTIVO != 1): ?>
              <div class="col-xs-12 col-sm-6" style="margin-top: 10px"> 
                <div class="row">
                  <table class="table table-striped table-bordered table-responsive" id="tabla_2">
                  <thead>
                  <tr>
                  <th colspan=5 style="text-align:center; font-size:16px">C u a t r i m e s t r e&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</th>
                  </tr>        
                  <tr style="text-align:center">
                  <th style='padding:3px' width="05%">Sede</th>
                      <th style='padding:3px' width="35%">Materia</th>
                      <th style='padding:3px' width="25%">Horario</th>
                      <th style='padding:3px' width="05%">Aula</th>
                      <th style='padding:3px' width="10%">Comision</th>
                      <th style='padding:3px' width="20%">Catedra</th>
                  </tr>        
                  </thead>
                  <tbody>
                  <?php
                    $cuantos = 0;
                      foreach ($alumnos as $item=>$fields) { 
                        if ($fields['cuat'] == 2) {
                          echo "<tr>";
                          $cuantos++;
                          echo "<td class = 'disable-selection'>".$fields['sede']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['materia'].'-'.$fields['d_materia']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['horario'].'-'.$fields['d_horario']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['aula']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['comision']."</td>";
                          echo "<td class = 'disable-selection'>".$fields['catedra']."</td>";
                          echo "</tr>";
                        }
                      }
                      if ($cuantos < 4) {
                        for ($i = $cuantos; $i < 4; $i++)    {
                          echo "<tr>";
                          $cuantos++;
                          echo "<td class = 'disable-selection'>&nbsp</font></td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "<td class = 'disable-selection'>&nbsp</td>";
                          echo "</tr>";
                        }
                      }
                    ?>
                    </tbody>
                  </table>
                </div>
                <div class="row" style="margin-top: 10px">
                  <?php
                    $cuantos = 0;
                    $novedades = '';
                    foreach ($alumnos as $item=>$fields) { 
                        if ($fields['cuat'] == 2) {
                          if ($fields['d_novedad'] != null) {
                            $novedades = $novedades . $fields['materia'].': '. $fields['d_novedad']. "<br>" ;
                            $cuantos ++;
                          }
                        }
                      }
                      foreach ($xxi as $item=>$fields) { 
                        if (($fields['cuat'] == 2) || ($fields['cuat'] == 0)) {
                          if ($fields['d_novedad'] != null) {
                            $novedades = $novedades . $fields['materia'].': '. $fields['d_novedad']. "<br>" ;
                            $cuantos ++;
                          }
                        }
                      }
                      if ($cuantos != 0) {
                        echo '<div class="panel panel-info">';
                        echo '<div class="panel-heading"><b>Novedades 2do cuatrimestre: </b></div>';
                        echo '<div class="panel-body">'.$novedades.'</div>';
                        echo '</div>';
                      }

                    ?>
                </div>
              </div>
              <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ((count($alumnos) == 0) && (count($xxi) == 0)) : ?>
              <?php echo '<div class="alert alert-info">El alumno no registra asignacion</div>' ?> 
            <?php endif; ?> 
            <?php if ($observados): ?>
              <?php echo '<div class="alert alert-info">'.$observados."</div>" ?> 
            <?php endif; ?>       
            <?php if ($error): ?>
              <?php echo '<div class="alert alert-danger">'.$error."</div>" ?> 
            <?php endif; ?>
          </div> <!--  fIN CARD BODY ASIGNACION -->
        </div> <!--  fIN CARD ASIGNACION -->
      </div> <!--  fIN DIV TAB ASIGNACION -->

      <?php if (in_array('7R',$permisos) || (in_array('7C',$permisos))): ?> 
      <div id="Historial" class="tab-pane fade">
        <div class="card" style="background-color: #d9edf7;">
          <div class="card-header texto_cabecera">

            <?php echo $apellido.", ".$nombre; ?>
<!--               <a href="< ?php echo base_url() ?>Certificado/certificado2pdf" class="btn boton pull-right" id="pdf2" name = "pdf2" role="button"> Certificado </a></br>  -->
            <!-- <button type="submit" class="btn boton pull-right" data-theme="b" id="pdf3" name = "pdf3" title="Certificado">Certificado</button>  -->
            <?php if ((in_array('7C',$permisos)) && (count($sitacad) > 0)): ?> 
            <!-- <button type="button" class="btn boton pull-right" data-theme="b" id="pdf2" name = "pdf2" title="Certificado" onclick="f_imprimir_pdf();">Certificado</button>  -->

            <button type="button" class="btn boton pull-right" data-toggle="modal" data-target="#myModal">Certificado</button>

            <?php endif; ?> 
          </div>
          <div class="card-body">
            <?php if (count($sitacad) == 0): ?>
              <?php echo '<div class="alert alert-info">El alumno no registra historial academico</div>' ?> 
            <?php endif; ?>    
            <?php if (count($sitacad) > 0): ?> 

              <input type="checkbox" id="cbx_ausentes" name="cbx_ausentes" value="A">
              <label for="cbx_ausentes"> Ocultar Ausentes</label><br>

                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog"> 
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="btn boton pull-right" data-dismiss="modal">Cancelar</button>
                        <h4 class="modal-title">Destinatario del certificado</h4>
                      </div>
                      <div class="modal-body">

                      <div class = "radio">
                        <label><input type = "radio" name = "autoridad" id = "autoridad_a" value = "a" checked>A quien corresponda</label>
                      </div>
                      <div class = "radio">
                        <label><input type = "radio" name = "autoridad" id = "autoridad_o" value = "o" >Otro destinatario</label>
                      </div> 
                      <div class="ancho_fila" style="margin-left:40px" id="div_autoridad" hidden>
                        <label for="d_autoridad" style="font-weight:400">Entidad a quien va dirigido el certificado</label>  
                        <input type="text" autocomplete='off' class="form-control" name="d_autoridad" id="d_autoridad"  />
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn boton pull-right" data-dismiss="modal" data-theme="b" id="pdf2" name = "pdf2" title="Certificado" onclick="f_imprimir_pdf();">Certificado</button> 
                    </div>
                  </div>
                </div> 
              </div>
  

                <div class="row" style="margin-top: 10px">



                <table class="table table-striped  table-bordered table-responsive table-hover" id="tabla_sitacad" style="margin-top=10px"> 
                  <thead>
                  <tr>
                      <th colspan=11 style="text-align:center; font-size:16px">S i t u a c i o n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A c a d e m i c a</th>
                      </tr>        
                      <tr style="text-align:center">
                      <th onclick="sortTable(0)" style='padding:3px' width="10%">Año</th>
                      <th onclick="sortTable(1)" style='padding:3px' width="10%">Cuat/Turno</th>
                      <th onclick="sortTable(2)" style='padding:3px' width="05%">Sede</th>
                      <th onclick="sortTable(3)" style='padding:3px' width="05%">Cod.Mat.</th>
                      <th onclick="sortTable(4)" style='padding:3px' width="35%">Materia</th>
                      <th onclick="sortTable(5)" style='padding:3px' width="10%">Comisi&oacute;n/C&aacute;tedra</th>
                      <th onclick="sortTable(6)" style='padding:3px' width="05%">Cursada</th>
                      <th onclick="sortTable(7)" style='padding:3px' width="05%">Nota</th>
                      <th onclick="sortTable(8)" style='padding:3px' width="05%">Tipo</th>
                      <th onclick="sortTable(9)" style='padding:3px' width="09%">Resoluci&oacute;n</th>
                      <th onclick="sortTable(10)" style='padding:3px' width="01%">FP?</th>
                  </tr>        
                  </thead>
                  <tbody>
                    <?php
                    foreach ($sitacad as $item=>$fields) { 
                      $clase = (trim($fields['nota']) == 'A' ? ' ausente' : '');
                      echo "<tr>";
                      echo "<td name = 'h_aniocurso' class = 'disable-selection".$clase."'>".$fields['aniocurso']."</td>";
                      echo "<td name = 'h_cuatturno' class = 'disable-selection".$clase."'>".$fields['cuatturno']."</td>";
                      echo "<td name = 'h_sede' class = 'disable-selection".$clase."'>".$fields['sede']."</td>";//.' - '.$fields['d_materia']."</td>";
                      echo "<td name = 'h_materia' class = 'disable-selection".$clase."'>".$fields['materia']."</td>";//.' - '.$fields['d_horario']."</td>";
                      echo "<td name = 'h_d_materia' class = 'disable-selection".$clase."'>".$fields['d_materia']."</td>";//.' - '.$fields['d_horario']."</td>";
                      echo "<td name = 'h_comicat' class = 'disable-selection".$clase."'>".$fields['comicat']."</td>";//."</td>";
                      echo "<td name = 'h_cursada' class = 'disable-selection".$clase."'>".$fields['cursada']."</td>";//."</td>";
                      echo "<td name = 'h_nota' class = 'disable-selection".$clase."'>".str_pad(trim($fields['nota']),2,' ',STR_PAD_LEFT)."</td>";//."</td>";
                      echo "<td name = 'h_tipo' class = 'disable-selection".$clase."'>".$fields['tipo']."</td>";//."</td>";
                      echo "<td name = 'h_resolucion' class = 'disable-selection".$clase."'>".$fields['resolucion']."</td>";//."</td>";
                      echo "<td name = 'h_fp' class = 'disable-selection".$clase."'>".$fields['fp']."</td>";//."</td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>   <!--fin card body -->
        </div>    <!--fin card  -->
      </div>      <!--fin historial -->
      <?php endif; ?>  
    </div>      <!--fin tab content -->
  </div>        <!--fin content -->
</form>
<form id="form1" action="<?php echo base_url().'Certificado/certificado2pdf'; ?>"  method="POST" target="_blank" >
  <?php
    echo '<input type="hidden" name="apenom" value="'. $apellido.", ".$nombre. '">';
    echo '<input type="hidden" name="dni" value="'. $dni. '">';
    echo '<input type="hidden" name="ocultar_ausentes" id="ocultar_ausentes" value="N">';
    echo '<input type="hidden" name="autoridad_elegida" id="autoridad_elegida">';
    foreach ($sitacad as $item=>$fields) { 
      if (((isset($fields['nota']) && ($fields['nota'] != '')&& ($fields['nota'] != 'Reg.'))) || ($fields['fp'] == '*') || ($fields['cursada'] == 'NR')) {
        echo '<input type="hidden" name="d_materia[]" value="'. $fields['materia'].'-'.$fields['d_materia']. '">';
        if ($fields['cursada'] == 'NR') {
          echo '<input type="hidden" name="nota[]" value="'. $fields['cursada']. '">';
        } else {
          if ($fields['fp'] == '*') {
            echo '<input type="hidden" name="nota[]" value="Reg.">';
          } else {
            echo '<input type="hidden" name="nota[]" value="'. $fields['nota']. '">';
          }
        }  
        if (($fields['nota'] == 'AP') || (($fields['comicat'] == '') && ($fields['resolucion'] <> ''))) {
          echo '<input type="hidden" name="comicat[]" value="'. $fields['resolucion']. '">';
        } else {
          echo '<input type="hidden" name="comicat[]" value="'. $fields['comicat']. '">';
        }
        
        echo '<input type="hidden" name="tipo[]" value="'. $fields['tipo']. '">';
        echo '<input type="hidden" name="fecha[]" value="'. $fields['fecha']. '">';
      }
    }
  ?>
    <!--               <a href="< ?php echo base_url() ?>Certificado/certificado2pdf" class="btn boton pull-right" id="pdf2" name = "pdf2" role="button"> Certificado </a></br>  -->
    <!-- <button type="submit" class="btn boton pull-right" data-theme="b" id="pdf3" name = "pdf3" title="Certificado">Certificado</button>  -->
</form> 

<script>
function descargar(blob, nombre) {
    var a = document.createElement('a');
    /* Vamos a cargar los datos (siendo o no blob) en una matriz 
      y forzamos la creación de un nuevo blob */
    var url = window.URL.createObjectURL(
        new Blob([ blob ], { type: 'application/octet-stream' })
    );
    a.href = url;
    a.download = nombre + '.pdf';
    a.click();
    window.URL.revokeObjectURL(url);
}

function f_imprimir_pdf() {
  var element = document.getElementsByName("d_materia[]");
  if(typeof(element) != 'undefined' && element != null && element.length > 0){
    form1.submit();
  } else{
    alert('No hay calificaciones para incluir en el certificado');
  }
}  

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tabla_sitacad");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 2; i < (rows.length -1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("td")[n];
      y = rows[i + 1].getElementsByTagName("td")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

$("#pdf").click( function() {
  $url_api = "<?php echo base_url() ?>Certificado/certificado2pdf";
  var jsonString = <?php echo json_encode($sitacad); ?>;
  
  $.ajax(
  { 
      type: "POST",
      url: $url_api,
/*             contentType: "application/json; charset=utf-8",*/
      data : {'sitacad': jsonString}, //JSON.stringify(jsonString)}, //capturo array */
      contentType : 'application/pdf',
      processData: false,
      cache: false,
      success: function (data) {
        console.log(data);
//        descargar(data, "< ?php echo $apellido.' '.$nombre; ?>");    
        alert('Todo OK');
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.status);
          alert(xhr.responseText);
          alert(thrownError);
          alert('No se pudo generar el archivo');
      }
/*          error: function (msg) {
        alert('No se pudo generar el archivo');
        }*/
  } );
  event.stopPropagation();
});

$("input[name='autoridad']:radio").click(function(){
  var inputValue = $(this).attr("value");
  if (inputValue == 'a') {
      $('#div_autoridad').hide();
      $('#autoridad_elegida').val('A quien corresponda');
  }
  else {
    $('#div_autoridad').show();
    $("#autoridad_elegida").val($("#d_autoridad").val());
  }
  //alert($("#autoridad_elegida").val());
});


$("#d_autoridad").on("change", function(){
    //alert($(this).val());
    $("#autoridad_elegida").text($(this).val());
    $("#autoridad_elegida").val($(this).val());
});

$('#cbx_ausentes').on('change', function(){
  if ($(this).prop('checked')) {
      $('.ausente').hide();
      $('#ocultar_ausentes').val('S');
  }
  else {
      $('.ausente').show();
      $('#ocultar_ausentes').val('N');
  }
});

</script>