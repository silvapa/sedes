<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php echo '<script src="'.base_url().'application/assets/js/rutinas_validacion.js"></script>';
      echo '<script src="'.base_url().'application/assets/js/jquery.inputmask.js"></script>';
?>
 <form class="form-signin-grande" name = 'form_Alumno' id = 'form_Alumno' action="<?php echo base_url() ?>Tad/Consulta_Post" method='POST'>
<div data-role="content"  id="div_scroll"> 
  <input type="hidden" id = 'esgrilla' name = 'esgrilla' value="<?php if (isset($esgrilla)) {echo $esgrilla;} ?>">
  <input type="hidden" id = 'id_Expediente' name = 'id_Expediente' value="<?php if (isset($id_Expediente)) {echo $id_Expediente;} ?>">
  <input type="hidden" id = 't_tramite' name = 't_tramite' value="<?php if (isset($t_tramite)) {echo $t_tramite;} ?>">
 <!--  <div class="clase_encabe" > -->
  <table class="table-responsive" id="tabla_descargas2">
    <thead>
    <tr>
    <td style='padding:2px' width="10%"><input type='text' class = 'blocked' name='dni' id='dni' value="<?php if (isset($dni)) {echo $dni;} ?>" placeholder="D.N.I."></td>
    <td style='padding:2px' width="20%"><input type='text' class = 'blocked' name='apellido' id='apellido' value="<?php if (isset($apellido)) {echo $apellido;} ?>" placeholder="Apellido"></td>
    <td style='padding:2px' width="20%"><input type='text' class = 'blocked' name='nombre' id='nombre' value="<?php if (isset($nombre)) {echo $nombre;} ?>" placeholder="Nombre"></td>
    <td style='padding:2px' width="28%"><input type='text' class = 'blocked' name='email' id='email' value="<?php if (isset($email)) {echo $email;} ?>" placeholder="Email"></td>
 
    <td style='padding:1px' width="16%" >
    <?php
    $c_estado = array('name' => 'estado', 'placeholder' => 'Estado', 'id' => 'estado',
     'class'         =>'select_styled',
     'style'         => 'width:100%');

    $ia_estados = array('' => 'Todos los estados', 'G'  => 'En proceso', 'N'  => 'No corresponde', 'P'  => 'Procesado OK', 'E'  => 'Procesado c/Error', 'R'  => 'En revision');
      echo form_dropdown($c_estado, $ia_estados,'');      
    ?>
    </td>

    <td style='padding:2px' width="03%"><button type="submit" class="btn boton" data-theme="b" value="Buscar" title="Buscar">Buscar</button></td>  
    <td style='padding:2px' width="03%"><a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Volver</a></td>  
    </tr>
    </thead>
    </table>

    <div id = "row"><div id = "col" class="linea_angosta"></div></div>
    <?php if (($error == '') && (count($tad) > 0)): ?>
    <table class="table table-striped table-bordered table-responsive table-hover" id="tabla_descargas">
    <thead>
    <tr>
        <th onclick="sortTable(0)" style='padding:3px' width="05%">DNI</th>
        <th onclick="sortTable(1)" style='padding:3px' width="16%">Apellido</th>
        <th onclick="sortTable(2)" style='padding:3px' width="16%">Nombre</th>
        <th onclick="sortTable(3)" style='padding:3px' width="25%">Email</th>
        <th onclick="sortTable(4)" style='padding:3px' width="10%">Estado</th>
        <th onclick="sortTable(5)" style='padding:3px' width="15%">Expediente</th>
        <th onclick="sortTable(6)" style='padding:3px' width="05%">Tipo TAD</th>
    </tr>        
    </thead>
    <tbody>
 <?php
 foreach ($tad as $item=>$fields)  
  { 
    echo "<tr>";
    echo "<td class = 'c_dni disable-selection'>".$fields['dni']."</td>";
    echo "<td class = 'c_apellido disable-selection'>".$fields['apellido']."</td>";
    echo "<td class = 'c_nombre disable-selection'>".$fields['nombre']."</td>";
    echo "<td class = 'c_email disable-selection'>".$fields['email']."</td>";
    echo "<td class = 'c_estado disable-selection'>".$fields['estado']."</td>";
    echo "<td class = 'c_Expediente disable-selection'>".$fields['Expediente']."</td>";
    echo "<td class = 'c_t_tramite disable-selection'>".$fields['t_tramite']."</td>";
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

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tabla_descargas");
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
    for (i = 1; i < (rows.length -1); i++) {
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

$(document).ready(function() {
  $( "tr" ).dblclick(function() {
    var $this = $(this);
    var $tr = $this.closest("tr");
    document.getElementById("dni").value = $tr.find('.c_dni').text();
    document.getElementById("apellido").value = $tr.find('.c_apellido').text();
    document.getElementById("nombre").value = $tr.find('.c_nombre').text();
    document.getElementById("email").value = $tr.find('.c_email').text();
    document.getElementById("estado").value = $tr.find('.c_estado').text();
    document.getElementById("id_Expediente").value = $tr.find('.c_Expediente').text();
    document.getElementById("t_tramite").value = $tr.find('.c_t_tramite').text();
    document.getElementById("esgrilla").value = 'N';
    document.getElementById('form_Alumno').submit();    
 });        
});
    
/*$.post('< ?=base_url();?>Admin/desaprobar_lista', { selection: list }, function(result,status,xhr)  {
                        $.redirect('mostrar_salida', {'texto': result});
                    },"text");*/

</script>