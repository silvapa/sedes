<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>application/assets/js/jquery-3.3.1.min.js"></script>
<div data-role="content"  id="div_scroll"> 
    <div id = "row"><div id = "col" class="linea_angosta"></div>
    <table class="table table-striped table-bordered table-responsive table-hover" id="tabla_descargas">
    <thead>
    <tr>
        <th colspan="8" style='padding:3px;text-align="center"'>REGISTROS ALTA BAJA CARGADOS: <?php echo count($alumnos); ?></th>
    </tr>
    <tr>
        <th style='padding:3px' width="05%">A&ntilde;o</th>
        <th style='padding:3px' width="08%">Clave</th>
        <th style='padding:3px' width="12%">DNI</th>
        <th style='padding:3px' width="40%">Apellido Nombre</th>
        <th style='padding:3px' width="05%">Sede</th>
        <th style='padding:3px' width="10%">Materia</th>
        <th style='padding:3px' width="10%">Horario</th>
        <th style='padding:3px' width="10%">Aula</th>

    </tr>        
    </thead>
    <tbody>
        <?php
        foreach ($alumnos as $item=>$fields)  
        { 
            echo "<tr>";
            echo "<td class = 'c_anio disable-selection'>".$fields['anio']."</td>";
            echo "<td class = 'c_clave disable-selection'>".$fields['clave']."</td>";
            echo "<td class = 'c_dni disable-selection'>".$fields['dni']."</td>";
            echo "<td class = 'c_apellido disable-selection'>".$fields['apellido']."</td>";
            echo "<td class = 'c_nombre disable-selection'>".$fields['sede']."</td>";
            echo "<td class = 'disable-selection'>".$fields['materia']."</td>";
            echo "<td class = 'disable-selection'>".$fields['horario']."</td>";
            echo "<td class = 'disable-selection'>".$fields['aula']."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
 </table>
 <button type="button" id="buttonCerrar"  onClick="doVolver()" class="btn boton pull-right" data-theme="b" style="margin:20px" value="Cerrar" title="Cerrar">Cerrar</button>
 </div>

 <script type="text/javascript">
   function doVolver(){
    window.location.href = "<?php echo base_url().'AltaBaja/consultar';?>";
   }

 </script>