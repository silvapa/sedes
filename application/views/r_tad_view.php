<div data-role="content" id="contenido_pagina">
<form class="form-signin_inicio_sesion" name = 'form_r_tad' id = 'form_r_tad' onsubmit="return validateForm()" method="get" action="<?php echo base_url(); ?>Tad/listar_tad">

    <h3 class="form-signin-heading">Seleccione rango de fechas de caratulacion a listar</h3>
    <div id = "row"><div id = "col" class="Lines1"></div></div>
    <div id = "row"><div id = "col" class="Lines2"></div></div>
    <br>          
    <br>
    <br>          
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
            <label for="fechaInicio" class="control-label">Desde fecha</label>
            <input type="date" value ="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"),date("Y"))); ?>" 
            min="13-03-2020" max="<?php echo date("d.m.Y"); ?>" name="fechaInicio" id="fechaInicio" maxlength="10" required 
            tabindex="1" autocomplete="off" placeholder="Desde Fecha" />
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
            <label for="fechaFin" class="control-label">Hasta fecha</label>
            <input type="date" value ="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d"),date("Y"))); ?>"
            min="13-03-2020" max="<?php echo date("d.m.Y"); ?>" name="fechaFin" id="fechaFin" maxlength="10" required
            tabindex="1" autocomplete="off" placeholder="Hasta Fecha" />
        </div>
    </div>          
    <br>          
    <br>          
    <br>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila"> 
            <input type="submit" name="export" class="btn boton pull-left" value="Exportar" />
       </div>
        <div class="col-xs-6 col-sm-6 col-md-6 ancho_fila">    
            <a href="<?php echo base_url() ?>Main/Principal" class="btn boton pull-right" role="button"> Volver </a></br>
        </div>          
    </div>          
 
  </form>
  </div>


  <script type="text/javascript">

    function validateForm() {
        var errores = "";
        var fechaInicio = Date.parse(document.getElementById("fechaInicio").value);
        var fechaFin = Date.parse(document.getElementById("fechaFin").value);

        if (isNaN(fechaInicio)) {
//            errores += "Debe ingresar una Fecha de Inicio. ";
            return false;
        }

        if (isNaN(fechaFin)) {
//            errores += "Debe ingresar una Fecha de Fin. ";
            return false;
        }

        if(fechaInicio > fechaFin){
            errores += "Debe ingresar una Fecha de Inicio menor o igual a la de Fin. ";
        }    

        if (errores != "") {
            alert(errores);
            return false;
        }
        return true;
    }

  </script>