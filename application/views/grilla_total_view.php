<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php echo '<script src="'.base_url().'application/assets/js/rutinas_validacion.js"></script>';
      echo '<script src="'.base_url().'application/assets/js/jquery.inputmask.js"></script>';
?>

 <form class="form-signin-grande" name = 'form_Alumno' id = 'form_Alumno' action="<?php echo base_url() ?>Padron/padron_actual_post" method='POST'>
<div data-role="content"  id="div_scroll"> 
  <input type="hidden" id = 'esgrilla' name = 'esgrilla' value="<?php if (isset($esgrilla)) {echo $esgrilla;} ?>">
 <!--  <div class="clase_encabe" > -->
  <table class="table-responsive" id="tabla_descargas2">
    <thead>
    <tr>
    <td style='padding:2px' width="10%"><input type='text' class = 'blocked' name='clave' id='clave' value="<?php if (isset($clave) && ($clave != 0)) {echo $clave;} ?>" placeholder="Clave"></td>
    <td style='padding:2px' width="12%"><input type='text' class = 'blocked' name='dni' id='dni' value="<?php if (isset($dni)) {echo $dni;} ?>" placeholder="D.N.I."></td>
    <td style='padding:2px' width="35%"><input type='text' class = 'blocked' name='apellido' id='apellido' value="<?php if (isset($apellido)) {echo $apellido;} ?>" placeholder="Apellido"></td>
    <td style='padding:2px' width="35%"><input type='text' class = 'blocked' name='nombre' id='nombre' value="<?php if (isset($nombre)) {echo $nombre;} ?>" placeholder="Nombre"></td>
    <td style='padding:2px' width="04%"><button type="submit" class="btn boton" data-theme="b" value="Buscar" title="Buscar">Buscar</button></td>  
    <td style='padding:2px' width="04%"><a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Volver</a></td>  
    </tr>
    </thead>
    </table>

    <div id = "row"><div id = "col" class="linea_angosta"></div></div>
    <?php if (($error == '') && (count($alumnos) > 0)): ?>
    <table class="table table-striped table-bordered table-responsive table-hover" id="tabla_descargas">
    <thead>
    <tr>
        <th style='padding:3px' width="08%">Clave</th>
        <th style='padding:3px' width="12%">DNI</th>
        <th style='padding:3px' width="34%">Apellido</th>
        <th style='padding:3px' width="34%">Nombre</th>
        <th style='padding:3px' width="07%">Carrera</th>
        <th style='padding:3px' width="08%">CUIL</th>
        <th style='padding:3px' width="08%">Grupo</th>
        <th style='padding:3px' width="12%">S1</th>
        <th style='padding:3px' width="34%">T1</th>
        <th style='padding:3px' width="34%">S2</th>
        <th style='padding:3px' width="07%">T2</th>
        <th style='padding:3px' width="08%">Cursa</th>
    </tr>        
    </thead>
    <tbody>
 <?php
 foreach ($alumnos as $item=>$fields)  
  { 
    echo "<tr>";
    echo "<td class = 'c_clave disable-selection'>".$fields['clave']."</td>";
    echo "<td class = 'c_dni disable-selection'>".$fields['dni']."</td>";
    echo "<td class = 'c_apellido disable-selection'>".$fields['apellido']."</td>";
    echo "<td class = 'c_nombre disable-selection'>".$fields['nombre']."</td>";
    echo "<td class = 'disable-selection'>".$fields['carrera']."</td>";
    echo "<td class = 'disable-selection'>".$fields['cuil']."</td>";
    echo "<td class = 'disable-selection'>".$fields['grupo']."</td>";
    echo "<td class = 'disable-selection'>".$fields['sede1']."</td>";
    echo "<td class = 'disable-selection'>".$fields['turno1']."</td>";
    echo "<td class = 'disable-selection'>".$fields['sede2']."</td>";
    echo "<td class = 'disable-selection'>".$fields['turno2']."</td>";
    echo "<td class = 'disable-selection'>".$fields['opta']."</td>";
    echo "</tr>";
  }
 ?>
 </tbody>
 </table>
 <?php endif; ?>

 <?php if ($error): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible">'.$error."</div>" ?> 
      <?php endif; ?>
      </div>
  </form>
 <script>

$(document).ready(function() {
  $('#clave').inputmask("9{1,6}"); 
  $('#dni').inputmask("9{1,8}"); 
/*  $( "tr" ).dblclick(function() {
    var $this = $(this);
    var $tr = $this.closest("tr");
    document.getElementById("clave").value = $tr.find('.c_clave').text();
    document.getElementById("dni").value = $tr.find('.c_dni').text();
    document.getElementById("apellido").value = $tr.find('.c_apellido').text();
    document.getElementById("nombre").value = $tr.find('.c_nombre').text();
    document.getElementById("esgrilla").value = 'N';
    document.getElementById('form_Alumno').submit();    
 });        */
});
    
/*$.post('< ?=base_url();?>Admin/desaprobar_lista', { selection: list }, function(result,status,xhr)  {
                        $.redirect('mostrar_salida', {'texto': result});
                    },"text");*/

</script>