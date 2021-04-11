<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<?php echo '<script src="'.base_url().'application/assets/js/rutinas_validacion.js"></script>';
      echo '<script src="'.base_url().'application/assets/js/jquery.inputmask.js"></script>';
?>
 <form class="form-signin-grande" name = 'form_Alumno' id = 'form_Alumno' action="<?php echo base_url() ?>Usuarios/Usuarios_Post" method='POST'>
<div data-role="content"  id="div_scroll"> 
  <input type="hidden" id = 'esgrilla' name = 'esgrilla' value="<?php if (isset($esgrilla)) {echo $esgrilla;} ?>">
  <input type="hidden" id = 'id_usuario' name = 'id_usuario' value="<?php if (isset($id_usuario)) {echo $id_usuario;} ?>">
 <!--  <div class="clase_encabe" > -->
  <table class="table-responsive" id="tabla_descargas2">
    <thead>
    <tr>
    <td style='padding:2px' width="10%"><input type='text' class = 'blocked' name='login' id='login' value="<?php if (isset($login)) {echo $login;} ?>" placeholder="Login"  onfocusout="f_estandarizar_login(this)"></td>
    <td style='padding:2px' width="31%"><input type='text' class = 'blocked' name='d_usuario' id='d_usuario' value="<?php if (isset($d_usuario) && ($d_usuario != 0)) {echo $d_usuario;} ?>" placeholder="Usuario"></td>
    <td style='padding:2px' width="10%"><input type='text' class = 'blocked' name='sede' id='sede' value="<?php if (isset($sede)) {echo $sede;} ?>" placeholder="Sede"></td>
<!--     <td style='padding:2px' width="10%"><input type='text' class = 'blocked' name='activo' id='activo' value="< ?php if (isset($activo)) {echo $activo;} ?>" placeholder="Activo"></td>
 -->
    <td style='padding:1px' width="10%" >
    <?php
    $c_activo = array('name' => 'activo', 'placeholder' => 'Estado', 'id' => 'activo',
     'class'         =>'select_styled',
     'style'         => 'width:100%');

    $ia_estados = array('' => 'Todos los estados', '1'  => 'Activo', '0'  => 'Inactivo');
      echo form_dropdown($c_activo, $ia_estados,'');      
    ?>
    </td>




    <td style='padding:2px' width="30%"><input type='text' class = 'blocked' name='email' id='email' value="<?php if (isset($email)) {echo $email;} ?>" placeholder="Email"></td>
    <td style='padding:2px' width="03%"><button type="submit" class="btn boton" data-theme="b" value="Buscar" title="Buscar">Buscar</button></td>  
    <td style='padding:2px' width="03%"><a href="<?php echo base_url() ?>Usuarios/Nuevo" class="btn boton" role="button">Nuevo</a></td>  
    <td style='padding:2px' width="03%"><a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Volver</a></td>  
    </tr>
    </thead>
    </table>

    <div id = "row"><div id = "col" class="linea_angosta"></div></div>
    <?php if (($error == '') && (count($usuarios) > 0)): ?>
    <table class="table table-striped table-bordered table-responsive table-hover" id="tabla_descargas">
    <thead>
    <tr>
        <th onclick="sortTable(0)" style='padding:3px' width="09%">Login</th>
        <th onclick="sortTable(1)" style='padding:3px' width="28%">Usuario</th>
        <th onclick="sortTable(2)" style='padding:3px' width="09%">Sede</th>
        <th onclick="sortTable(3)" style='padding:3px' width="09%">Estado</th>
        <th onclick="sortTable(4)" style='padding:3px' width="42%">Email</th>
    </tr>        
    </thead>
    <tbody>
 <?php
 foreach ($usuarios as $item=>$fields)  
  { 
    echo "<tr>";
    echo "<td class = 'c_login disable-selection'>".$fields['login']."</td>";
    echo "<td class = 'c_d_usuario disable-selection'>".$fields['d_usuario']."</td>";
    echo "<td class = 'c_sede disable-selection'>".$fields['sede']."</td>";
    echo "<td class = 'c_activo disable-selection'>".$fields['d_activo']."</td>";
    echo "<td class = 'c_email disable-selection'>".$fields['email']."</td>";
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
  $('#sede').inputmask("9{1,2}"); 
  $( "tr" ).dblclick(function() {
    var $this = $(this);
    var $tr = $this.closest("tr");
    document.getElementById("login").value = $tr.find('.c_login').text();
    document.getElementById("d_usuario").value = $tr.find('.c_d_usuario').text();
    document.getElementById("sede").value = $tr.find('.c_sede').text();
    document.getElementById("email").value = $tr.find('.c_email').text();
    document.getElementById("activo").value = $tr.find('.c_activo').text();
    document.getElementById("esgrilla").value = 'N';
    document.getElementById('form_Alumno').submit();    
 });        
});
    
/*$.post('< ?=base_url();?>Admin/desaprobar_lista', { selection: list }, function(result,status,xhr)  {
                        $.redirect('mostrar_salida', {'texto': result});
                    },"text");*/

</script>