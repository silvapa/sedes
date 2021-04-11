<div data-role="content" id="contenido_pagina">
    <form class="form-signin_inicio_sesion" name = 'form_cargas' id = 'form_cargas' action="<?php echo base_url() ?>Tad/reproceso_tad1" method='POST'>
        <h3 class="form-signin-heading">Reproceso de casos a Revisar de TAD 1</h3>
        <div id = "row"><div id = "col" class="Lines1"></div></div>
        <div id = "row"><div id = "col" class="Lines2"></div></div>
 <!--        <p><b>Tramites a procesar</b></p>
        <div class = "radio"  >
            <label><input type = "radio" name = "estados_a_incluir" value = "I" < ?php if(isset($estados_a_incluir) && ($estados_a_incluir == 'I')) echo "checked";?>>Estado INICIADO</label>
        </div>
        <div class = "radio">
            <label><input type = "radio" name = "estados_a_incluir" value = "G" < ?php if(isset($estados_a_incluir) && ($estados_a_incluir == 'G')) echo "checked"?>>Estado GENERADO</label>
        </div> 
        <div class = "radio">
            <label><input type = "radio"  name = "estados_a_incluir" value = "T" < ?php if(isset($estados_a_incluir) && ($estados_a_incluir == 'T')) echo "checked"?>>Estado INICIADO y GENERADO</label>
        </div>  -->
        <br>
        <br>
        <?php if ($aviso): ?>
          <?php echo '<div class="alert alert-success">'.$aviso."</div>" ?> 
        <?php endif; ?>   
        <?php if ($error): ?>
          <?php echo '<div class="alert alert-danger">'.$error."</div>" ?> 
        <?php endif; ?>   
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
              <input type="submit" class="btn boton" data-theme="b" value='Reprocesar'/><br>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
                <a href="<?php echo base_url() ?>Main/Principal" class="btn boton" role="button">Salir</a>
            </div>
       </div>
    </form>
</div>   