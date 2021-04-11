<link type="text/css" rel="stylesheet" href="<?php echo base_url().'application/assets/css/style.css'; ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url().'application/assets/css/table.css'; ?>" />

<div data-role="content"> 

<form class="form-signin-mediano" name = 'form_recalculo' id = 'form_recalculo' action="<?php echo base_url() ?>Admin/recalcular_post" method='POST'>
        <h4 class="form-signin-heading">Cálculo de valores estadísticos</h4> 
        <hr class="colorgraph">

  <h6 class ="titulo_form_tabla"><?php echo $distribucion_elegida; ?></h6>
  <input type="hidden" name="id_valor" value='<?php echo $id_valor; ?>'/>
  <input type="hidden" name="distribucion_elegida" value='<?php echo $distribucion_elegida; ?>'/>
  <table class="table table-striped table-bordered  table-xtra-condensed table-responsive flexigrid">
    <thead>
      <tr>
        <th>Valor</th>
        <th>Resultado</th>
      </tr>        
    </thead>
    <tbody>

 <?php
 $grey = false;
 $fields = array('media','CV','desvio','minimo','maximo','percentil_1','percentil_5','percentil_25','percentil_33','percentil_50','percentil_66','percentil_75','percentil_95','percentil_99');
  $t_fields = array('Media','Coeficiente de variación','Desvío','Mínimo','Máximo','Percentil 1','Percentil 5','Percentil 25','Percentil 33','Percentil 50','Percentil 66','Percentil 75','Percentil 95','Percentil 99');
  for($y=0;$y<14;$y++){
    echo "<tr>";
    if($grey){$color = 'background-color:#D1F5A9';} else {$color = '';}
    echo "<td style='padding:3px;".$color."'>".$t_fields[$y]."</td>";
/*    foreach ($v_actuales as $e) {  */
      if ($y == 1) {
//       echo "<td style='padding:3px;".$color."'><input type='hidden' name='o_".$fields[$y]."' value='".$v_actuales[$fields[$y]]."'>".floor((float)$v_actuales[$fields[$y]] * 100) . '%'."</td>";
       echo "<td style='padding:3px;".$color."'><input type='hidden' name='".$fields[$y]."' value='".$v_recalculados[$fields[$y]]."'>".floor((float)$v_recalculados[$fields[$y]] * 100) . '%'."</td>";
      } else
      {
//        echo "<td style='padding:3px;".$color."'><input type='hidden' name='o_".$fields[$y]."' value='".$v_actuales[$fields[$y]]."'>".$v_actuales[$fields[$y]]."</td>";
        echo "<td style='padding:3px;".$color."'><input type='hidden' name='".$fields[$y]."' value='".$v_recalculados[$fields[$y]]."'>".$v_recalculados[$fields[$y]]."</td>";
      }
/*    }*/
   //Cerramos columna
   echo "</tr>";
   $grey=!$grey;
  }
 ?>
 </tbody>
 </table>
      <?php if ($error): ?>
        <?php echo '<div class="alert alert-danger alert-dismissible">'.$error."</div>" ?> 
      <?php endif; ?>
      <?php if ($mensaje_ok): ?>
        <?php echo '<div class="alert alert-success">'.$mensaje_ok."</div><br>" ?> 
      <?php endif; ?>

<!--          <button type="submit" class="btn btn-lg btn-primary pull-left" data-theme="b" value="Reemplazar valores" title="Reemplazar valores">Reemplazar valores</button>  -->
         <a href='javascript:window.history.go(-1);' class="btn btn-lg btn-default pull-right" role="button">Salir</a>       
 </form>
    
</div>