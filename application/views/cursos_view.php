<script src="<?php echo base_url() ?>application/assets/js/jquery-3.3.1.min.js"></script>

<form class="form-signin-grande" name = 'form_cursos' id = 'form_cursos' action="<?php echo base_url() ?>Cursos/cursos_post" method='POST'>
<div data-role="content"  id="div_scroll"> 

    <div class="clase_encabe" >
        Materia: <?php echo $lista_materias; ?>
        <button type="submit" class="btn boton" data-theme="b" value="Buscar" title="Filtrar">Buscar</button>
		<?php
	       echo '<input type="button" id="btn_listar"  name="btn_listar" class="btn boton" data-theme="b" value="Listar" title="Descargar CSV">';
		?>
        <a href="<?php echo base_url() ?>Main/Principal" class="btn boton pull-right" role="button"> Volver </a></br>
    </div>
    <div id = "row"><div id = "col" class="linea_angosta"></div></div>
    <?php if (($error == '') && (count($activos) > 0)): ?> 
    <table class="table table-striped table-bordered table-responsive table-hover" id="tabla_descargas">
    <thead>
    <tr>
        <th style='padding:3px' width="02%">Cuat</th>
        <th style='padding:3px' width="05%">Comisi&oacute;n</th>
        <th style='padding:3px' width="02%">Sede</th>
        <th style='padding:3px' width="13%">Materia</th>
        <th style='padding:3px' width="15%">Horario</th>
        <th style='padding:3px' width="<?php echo ($puede_descargar?'07%':'08%')?>">Aula</th>
 <!--        <th style='padding:3px' width="< ?php echo ($puede_descargar?'05%':'06%')?>">Ingresantes</th>
        <th style='padding:3px' width="< ?php echo ($puede_descargar?'05%':'06%')?>">Viejos</th>
        <th style='padding:3px' width="< ?php echo ($puede_descargar?'08%':'10%')?>">Total Alu.</th> -->
        <th style='padding:3px' width="<?php echo ($puede_descargar?'15%':'30%')?>">Catedra</th>
        <th style='padding:3px' width="05%">Moodle</th>
        <?php if ($puede_descargar) {
          echo "<th style='padding:3px' width='10%'>Listado Alumnos</th>"; 
          echo "<th style='padding:3px' width='10%'>PreActa</th>";
        }
        ?>
    </tr>        
    </thead>
    <tbody>
 <?php
  foreach ($activos as $item=>$fields)  
  { 
    echo "<tr>";
    echo "<td class = 'disable-selection'>".$fields['cuat']."</td>";
    echo "<td class = 'disable-selection'>".$fields['comision']."</td>";
    echo "<td class = 'disable-selection'>".$fields['sede']."</td>";
    echo "<td class = 'disable-selection'>".$fields['materia'].' - '.$fields['d_materia']."</td>";
    echo "<td class = 'disable-selection'>".$fields['horario'].' - '.$fields['d_horario']."</td>";
    echo "<td class = 'disable-selection'>".$fields['aula']."</td>";
/*    echo "<td class = 'disable-selection'>".$fields['c_nuevos']."</td>";
    echo "<td class = 'disable-selection'>".$fields['c_viejos']."</td>";
    echo "<td class = 'disable-selection'>".$fields['c_total']."</td>";*/
    echo "<td class = 'disable-selection'>".$fields['catedra']."</td>";
    if (isset($fields['id_campus']) && ($fields['id_campus'] <> 0) && ($fields['id_campus'] != '')) {
      echo "<td class = 'disable-selection'><a href='https://cbccampusvirtual.uba.ar/course/view.php?id=".$fields['id_campus']."' target='_blank'>".$fields['id_campus']."</a></td>";
    }  else {
      echo "<td class = 'disable-selection'></td>";
    }
    if ($puede_descargar) {
    echo "<td class = 'disable-selection'>".((($fields['c_total'] > 0) && $puede_descargar) ? '<a href="curso2pdf?comision='.$fields['comision'].'&&tipo_listado=0&&destino=D" target="_blank">
    <img border="0" alt="Descargar" src="'.base_url().'application/assets/img/download-button.png"></a>&nbsp;&nbsp;'.
    '<a href="curso2pdf?comision='.$fields['comision'].'&&tipo_listado=0&&destino=I" target="_blank">
    <img border="0" alt="Imprimir" src="'.base_url().'application/assets/img/printer-16.png">
    </a>&nbsp;&nbsp;'.
    '<a href="curso2xls?comision='.$fields['comision'].'&&tipo_listado=0&&destino=I" target="_blank">
    <img border="0" alt="Excel" src="'.base_url().'application/assets/img/excel_icon.png">
    </a>' : '') ."</td>";
    echo "<td class = 'disable-selection'>".'<a href="curso2pdf?comision='.$fields['comision'].'&&tipo_listado=1&&destino=D" target="_blank">
    <img border="0" alt="Descargar" src="'.base_url().'application/assets/img/download-button.png">
    </a>&nbsp;&nbsp;';
    echo '<a href="curso2pdf?comision='.$fields['comision'].'&&tipo_listado=1&&destino=I" target="_blank">
    <img border="0" alt="Imprimir" src="'.base_url().'application/assets/img/printer-16.png">
    </a>'."</td>";
    }
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
	<input type="hidden" id="descargar" name="descargar" value="-1" />  
  </form>
 <script>

$(document).ready(function() {

/*  $('#tabla_descargas').on('click', '.clickable-row', function(event) {
  if($(this).hasClass('active')){
    $(this).removeClass('active'); 
  } else {
    $(this).addClass('active').siblings().removeClass('active');
  }
});*/

  $( "tr" ).dblclick(function() {
    var $this = $(this);
    var $tr = $this.closest("tr");
    document.getElementById("comision").value = $tr.find('.c_comision').text();
    document.getElementById("c_total").value = $tr.find('.c_c_total').text();
    document.getElementById("materia").value = $tr.find('.c_materia').text();
    document.getElementById("horario").value = $tr.find('.c_horario').text();
    document.getElementById("aula").value = $tr.find('.c_aula').text();
    document.getElementById("esgrilla").value = 'N';
    document.getElementById('form_cursos').submit();    
 });        
});
    
/*$.post('< ?=base_url();?>Admin/desaprobar_lista', { selection: list }, function(result,status,xhr)  {
                        $.redirect('mostrar_salida', {'texto': result});
                    },"text");*/
					
	$("#btn_listar").click(function(){
	   var descarga = $('#materias option:selected').val();
	   $("#descargar").val(descarga);
	   // decargar sede+materia
	   /*
	   var _url = '< ?php echo base_url() ?>Cursos/getCursosXLS?materia='+selectedValue
	   console.log(_url);
	   $.ajax({
          type: "GET",
          url: _url,
          contentType: "application/json; charset=utf-8",
          dataType: "json",
		  cache: false,
		  success: function (response,status) {
			if(response.status === "success") {
				alert('Se ha generado e inicado la descarga del archivo');
			}
		  },
		  error: function(response, status) {
		  console.log(status);
			alert('No se generar el listado para la/s materia/s seleccionada/s ');
		  }
       }); 
	   */
	    document.getElementById('form_cursos').submit();   
	   //
	});				

</script>