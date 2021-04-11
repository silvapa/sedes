  <form class="form-signin-grande" name = 'form_descargas' id = 'form_descargas' action="<?php echo base_url() ?>Main/principal" method='POST'>
  <div data-role="content" id="div_scroll">
  <table class="table table-striped table-bordered table-responsive table-hover" id="tabla_descargas">
    <thead>
      <tr>
        <th class='col-xs-1'>Fecha</th>
        <th class='col-xs-8'>Sistema</th>
        <th class='col-xs-2'>Descargar</th>
        <th class='col-xs-1'>Validez</th>
      </tr>        
    </thead>
    <tbody>
  <?php echo $tabla;?>
  </tbody>
  </table>
  </div>  
</form>
