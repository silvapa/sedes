<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<form class="form-signin-grande" name = 'form_asigna' id = 'form_asigna' action="<?php echo base_url() ?>Lectivo/lectivo_post" method='POST'>
<input type="hidden" id = 'esgrilla' name = 'esgrilla' value="N">
<input type="hidden" id = 'focused' name = 'focused' value="<?php if (isset($focused)) {echo $focused;} ?>" >
<div data-role="content"  id="div_scroll"> 
  <table class=" table-responsive" id="t_datos">
    <thead>
    <tr>
    <td class="busq" style='padding:3px' width="05%"><input type='text' onClick="document.getElementById('focused').value = 'anio';" <?php if ((isset($clave)) && ($clave != '') && ($focused == '')) {echo "readonly='readonly'";} ?> name='anio' id='anio' value="<?php if (isset($anio)) {echo $anio;} ?>" placeholder="A&ntilde;o"></td>
    <td class="busq" style='padding:3px' width="08%"><input type='text' onClick="document.getElementById('focused').value = 'clave';"<?php if ((isset($clave)) && ($clave != '') && ($focused == '')) {echo "readonly='readonly'";} ?> name='clave' id='clave' value="<?php if (isset($clave)) {echo $clave;} ?>" placeholder="Clave"></td>
    <td class="busq" style='padding:3px' width="12%"><input type='text' onClick="document.getElementById('focused').value = 'dni';"<?php if ((isset($clave)) && ($clave != '') && ($focused == '')) {echo "readonly='readonly'";} ?> name='dni' id='dni' value="<?php if (isset($dni)) {echo $dni;} ?>" placeholder="D.N.I."></td>
    <td class="busq" style='padding:3px' width="30%"><input type='text' onClick="document.getElementById('focused').value = 'apellido';"<?php if ((isset($clave)) && ($clave != '') && ($focused == '')) {echo "readonly='readonly'";} ?> name='apellido' id='apellido' value="<?php if (isset($apellido)) {echo $apellido;} ?>" placeholder="Apellido"></td>
    <td class="busq" style='padding:3px' width="30%"><input type='text' onClick="document.getElementById('focused').value = 'nombre';"<?php if ((isset($clave)) && ($clave != '') && ($focused == '')) {echo "readonly='readonly'";} ?> name='nombre' id='nombre' value="<?php if (isset($nombre)) {echo $nombre;} ?>" placeholder="Nombre"></td>
    <td class="busq" style='padding:3px' width="05%"><button type="submit" class="btn boton" data-theme="b" value="Buscar" title="Buscar">Buscar</button></td>  
    <td style='padding:3px' width="05%"><a href="<?php echo base_url() ?>Lectivo/consultar" class="btn boton" role="button">Grilla</a></td>  
    <td style='padding:3px' width="05%"><a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Salir</a></td>  
    </tr>
  </thead>
  </table>
  <div id = "row"><div id = "col" class="linea_angosta"></div></div>
  <?php if (($error == '') && (count($activos) > 0)): ?>
 <table class="table">
    <tr>
      <td valign="top" width="50%">
        <table class="table table-striped table-bordered table-responsive" id="tabla_1">
        <thead>
        <tr>
          <th colspan=5 style="text-align:center; font-size:16px">C u a t r i m e s t r e&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</th>
        </tr>        
        <tr style="text-align:center">
            <th style='padding:3px' width="10%">Sede</th>
            <th style='padding:3px' width="20%">Materia</th>
            <th style='padding:3px' width="25%">Horario</th>
            <th style='padding:3px' width="5%">Aula</th>
            <th style='padding:3px' width="10%">Comision</th>
            <th style='padding:3px' width="10%">Catedra</th>
        </tr>        
        </thead>
        <tbody>  
          <?php
          $cuantos = 0;
            foreach ($activos as $item=>$fields) { 
              if ($fields['cuat'] == 1) {
                echo "<tr>";
                $cuantos++;
                echo "<td class = 'disable-selection'>".$fields['sede']."</td>";
                echo "<td class = 'disable-selection'>".$fields['materia'].'-'.$fields['d_materia']."</td>";
                echo "<td class = 'disable-selection'>".$fields['horario'].'-'.$fields['d_horario']."</td>";
                echo "<td class = 'disable-selection'>".$fields['aula']."</td>";
                echo "<td class = 'disable-selection'>".$fields['comision']."</td>";
                echo "<td class = 'disable-selection'>".$fields['comision']."</td>";                
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
      </td>
      <td valign="top"  width="50%">
        <table class="table table-striped table-bordered table-responsive" id="tabla_2">
        <thead>
        <tr>
        <th colspan=5 style="text-align:center; font-size:16px">C u a t r i m e s t r e&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</th>
        </tr>        
        <tr style="text-align:center">
            <th style='padding:3px' width="10%">Sede</th>
            <th style='padding:3px' width="20%">Materia</th>
            <th style='padding:3px' width="25%">Horario</th>
            <th style='padding:3px' width="5%">Aula</th>
            <th style='padding:3px' width="10%">Comision</th>
            <th style='padding:3px' width="10%">Catedra</th>
        </tr>        
        </thead>
        <tbody>
        <?php
          $cuantos = 0;
            foreach ($activos as $item=>$fields) { 
              if ($fields['cuat'] == 2) {
                echo "<tr>";
                $cuantos++;
                echo "<td class = 'disable-selection'>".$fields['sede']."</td>";
                echo "<td class = 'disable-selection'>".$fields['materia'].'-'.$fields['d_materia']."</td>";
                echo "<td class = 'disable-selection'>".$fields['horario'].'-'.$fields['d_horario']."</td>";
                echo "<td class = 'disable-selection'>".$fields['aula']."</td>";
                echo "<td class = 'disable-selection'>".$fields['comision']."</td>";
                echo "<td class = 'disable-selection'>".$fields['comision']."</td>";
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
       </td>
       </tr>

       <tr>
       <td valign="top" width="50%">
       <div class="centrado">
        <a class="btn boton centrado" data-toggle="collapse" href="#collapseCuat1" role="button" aria-expanded="false" aria-controls="collapseExample">
        Novedades
        </a>
        </div>
      </td>
      <td valign="top" width="50%">
      <div class="centrado">
        <a class="btn boton" data-toggle="collapse" href="#collapseCuat2" role="button" aria-expanded="false" aria-controls="collapseExample">
        Novedades
        </a>
        </div>
      </td>
       </tr>
      <tr>
      <td valign="top" width="50%">
      <div class="collapse" id="collapseCuat1">
        <div class="card card-body">
        <?php
          $cuantos = 0;
          $novedades = '>>';
          foreach ($activos as $item=>$fields) { 
              if ($fields['cuat'] == 1) {
                if ($fields['d_novedad'] != null) {
                  $novedades = $novedades . $fields['comision'].': '. $fields['d_novedad']. "<br>" ;
                  $cuantos ++;
                }
              }
            }
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

            if ($cuantos == 0) {
              echo '';
            }
            else {
              echo $novedades;
            }
          ?>
        </div>
      </div>          
      </td>
      <td valign="top" width="50%">
      <div class="collapse" id="collapseCuat2">
        <div class="card card-body">
        <?php
          $cuantos = 0;
          $novedades = '';
          foreach ($activos as $item=>$fields) { 
              if ($fields['cuat'] == 2) {
                if ($fields['d_novedad'] != null) {
                  $novedades = $novedades . $fields['comision'].': '. $fields['d_novedad']. "<br>" ;
                  $cuantos ++;
                }
              }
            }
            if ($cuantos == 0) {
              echo '';
            }
            else {
              echo $novedades;
            }
          ?>
        </div>
      </div>          
      </td>
       </tr>
       
       </table>

       <?php endif; ?>
       <?php if ($observados): ?>
        <?php echo '<div class="alert alert-info">'.$observados."</div>" ?> 
      <?php endif; ?>       
      <?php if ($error): ?>
        <?php echo '<div class="alert alert-danger">'.$error."</div>" ?> 
      <?php endif; ?>
      </div>
  </form>
 <script>

$(document).ready(function() {
  $focused = document.getElementById("focused").value;
  if ($focused != ''){
    document.getElementById($focused).focus();
  }

//  document.getElementById("anio").addEventListener("click", function () {
  $(".busq").on('click', function(event){
    event.stopPropagation();
    event.stopImmediatePropagation();
    
    if(document.getElementById("anio").readOnly) {
      document.getElementById("anio").value = '';
      document.getElementById("clave").value = '';
      document.getElementById("dni").value = '';
      document.getElementById("apellido").value = '';
      document.getElementById("nombre").value = '';
      document.getElementById('form_asigna').submit();    
    }
  });

});
    
/*$.post('< ?=base_url();?>Admin/desaprobar_lista', { selection: list }, function(result,status,xhr)  {
                        $.redirect('mostrar_salida', {'texto': result});
                    },"text");*/

</script>