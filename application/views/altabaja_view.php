<script src="<?php echo base_url() ?>application/assets/js/jquery-3.3.1.min.js"></script>

<form class="form-signin-grande" name = 'form_total' id = 'form_total' action="<?php echo base_url() ?>AltaBaja/altabaja_post" method='POST'>
<div data-role="content"  id="div_scroll"> 
 
<input type='hidden' name='accion'  id='accion' value="<?php echo $accion;?>">
        <input type='hidden' name='dni_activo'  id='dni_activo' value="<?php echo $dni_activo;?>">
        <input type='hidden' name='anio_activo'  id='anio_activo' value="<?php echo $anio_activo;?>">
        <input type='hidden' name='clave_activo'  id='clave_activo' value="<?php echo $clave_activo;?>">

        <?php if ((count($datos) == 0) or ($error != '') ): ?>

    <div class="clase_encabe">
            DNI:
            <input type='text' name='dni' id='dni' value="" placeholder="D.N.I." <?php if (!(isset($dni_activo) or ($dni_activo==0))) {echo "autofocus";} ?> >
            <button type="submit" class="btn boton" data-theme="b" value="Buscar" onclick="LimpiarClave()" title="Buscar">Buscar</button>
            <a href="<?php echo base_url() ?>AltaBaja/listado" class="btn boton" role="button">Cargados</a>
        <a href="<?php echo base_url() ?>Main/Principal" class="btn boton pull-right" role="button"> Volver </a></br>

    </div>
    <?php endif; ?>

    <div id = "row"><div class="linea_angosta"></div></div>
    <?php if ( (count($datos) > 0)): ?> 
        <div class="row texto_cabecera" style="margin-right: 0px;margin-left: 0px;">
            <?php
            echo $datos[0]['apellido'].", ".$datos[0]['nombre']
            ?>

        </div>
        <div id = "row"><div class="Lines4"></div></div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4" > 


         <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Datos del alumno</h4>
                <div id = "row"><div id = "col" class="linea_angosta"></div></div><br>
                  <div class="row card-text">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>CLAVE:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p style="font-size: 17px"><b><?php echo $datos[0]['clave']."/".$datos[0]['anio']; ?></b></p>
                    </div>   
                  </div>
                  <div class="row card-text">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>DNI:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p style="font-size: 17px"><b><?php echo $dni_activo; ?></b></p>
                    </div>   
                  </div>
                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>CARRERA:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 

					   <?php 
					      $strcarrera = "";
					      for($x=0; $x<count($carreras); $x++){
						     $unacarrera = $carreras[$x];
							 $strcarrera .= $unacarrera['carrera']." - ".$unacarrera['nombre']."<br>";
							 
						    
						  }
					   ?>
					   <p><?php echo $strcarrera; ?> </p>
                    </div>   
                  </div>      

                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>TITULO:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p><?php echo $titulo; ?></p>
                    </div>   
                  </div>      

                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>BAJA:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p><?php if ($baja=='T') { echo "Sí";}else{  echo "NO";} ?></p>
                    </div>   
                  </div>     

                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>REGULAR:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p><?php if ($regular=='T') { echo "Sí";}else{  echo "NO";} ?></p>
                    </div>   
                  </div>     

                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'>UBA XXI:</p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p><?php echo $cursa_uba_xxi; ?></p>
                    </div>   
                  </div>     

                  <div class="row" style="margin-top: 10px">
                    <div class="col-xs-4 col-sm-4 col-md-4" style="padding-right: 0px;"> 
                        <p class = 'clase_label'></p>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8"> 
                       <p></p>
                    </div>   
                  </div> 

            </div>
        </div>

    </div>
        <?php
           if (isset($cursos[0])) {
               $curso = $cursos[0];
               $s1 = $curso['sede'];
               $m1 = $curso['materia'];
               $h1 = $curso['horario'];
               $a1 = $curso['aula'];
            }else{
               $s1 = "";
               $m1 = "";
               $h1 = "";
               $a1 = "";
            }
            if (isset($cursos[1])) {
                $curso = $cursos[1];
                $s2 = $curso['sede'];
                $m2 = $curso['materia'];
                $h2 = $curso['horario'];
                $a2 = $curso['aula'];
             }else{
                $s2 = "";
                $m2 = "";
                $h2 = "";
                $a2 = "";
             }
             if (isset($cursos[2])) {
                $curso = $cursos[2];
                $s3 = $curso['sede'];
                $m3 = $curso['materia'];
                $h3 = $curso['horario'];
                $a3 = $curso['aula'];
             }else{
                $s3 = "";
                $m3 = "";
                $h3 = "";
                $a3 = "";
             }
             if (isset($cursos[3])) {
                $curso = $cursos[3]; 
                $s4 = $curso['sede'];
                $m4 = $curso['materia'];
                $h4 = $curso['horario'];
                $a4 = $curso['aula'];
             }else{
                $s4 = "";
                $m4 = "";
                $h4 = "";
                $a4 = "";
             }
        ?>

<div class= "loader-container" id="loader-container"><div class="loader" id="loader_wheel"></div></div>

        <div class="col-xs-12 col-sm-12 col-md-8"> 
         <div class="card">
           <div class="card-body">
              <h4 class="card-title text-center">Asignación Alumno</h4>

              <?php 
                if ($pedir_mail) { 

                  echo '  <div id = "row">';
                  echo '<div id = "col" class="linea_angosta"></div>';
                  echo '</div>';

                  echo '<div class="row card-text">';
                  echo '<div class="col-xs-12 col-sm-12 col-md-12">';
                        
                  $habilitado = ($puede_escribir ? '' : ' disabled '); 
                  echo '<div class = "text"  style="padding-top:2px">';
                  echo '    <label for="email">Email:</label>';
                  echo '    <input type="email" id="email" name="email" maxlength="100" size="100">';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>'; 
                }
              ?>

              <div id = "row">
                 <div id = "col" class="linea_angosta"></div>
              </div>
              <div class="row card-text">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <div class = "text"  >
                          <!-- <h4>&nbsp;&nbsp;SEDE&nbsp;&nbsp;MATERIA&nbsp;&nbsp;HORARIO&nbsp;&nbsp;AULA</h4> -->
                        <div class="col-sm-2">SEDE</div>
                        <div class="col-sm-2">MATERIA</div>
                        <div class="col-sm-2">HORARIO</div>
                        <div class="col-sm-2">AULA</div>
                        </div>
                    </div> 
              </div> 
              <div class="row card-text">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <div class = "text"  >
                           
                        <div class="col-sm-2"> <label id="s1"><?php	echo $s1; ?></label></div>
                        <div class="col-sm-2"> <label id="m1"><?php	echo $m1; ?></label></div>
                        <div class="col-sm-2"> <label id="h1"><?php	echo $h1; ?></label></div>
                        <div class="col-sm-2"> <label id="a1"><?php	echo $a1; ?></label></div>
                        <div class="col-sm-2"> <input type="checkbox" id="check1" name="check1" value="1"></div>
                           
                        </div>
                    </div> 
              </div> 
              <div class="row card-text">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <div class = "text"  >
                        <div class="col-sm-2"> <label id="s2"><?php	echo $s2; ?></label></div>
                        <div class="col-sm-2">  <label id="m2"><?php	echo $m2; ?></label></div>
                        <div class="col-sm-2">  <label id="h2"><?php	echo $h2; ?></label></div>
                        <div class="col-sm-2">  <label id="a2"><?php	echo $a2; ?></label></div>
                        <div class="col-sm-2">   <input type="checkbox" id="check2" name="check2" value="2"></div>
                        </div>
                    </div> 
              </div> 
              <div class="row card-text">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <div class = "text"  >
                        <div class="col-sm-2">   <label id="s3"><?php	echo $s3; ?></label></div>
                        <div class="col-sm-2">   <label id="m3"><?php	echo $m3; ?></label></div>
                        <div class="col-sm-2">   <label id="h3"><?php	echo $h3; ?></label></div>
                        <div class="col-sm-2">   <label id="a3"><?php	echo $a3; ?></label></div>
                        <div class="col-sm-2">    <input type="checkbox" id="check3" name="check3" value="3"></div>
                        </div>
                    </div> 
              </div> 
              <div class="row card-text">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <div class = "text"  >
                        <div class="col-sm-2"><label id="s4"><?php echo $s4 ?></label></div>
                        <div class="col-sm-2"><label id="m4"><?php echo $m4; ?></label></div>
                        <div class="col-sm-2"><label id="h4"><?php echo $h4; ?></label></div>
                        <div class="col-sm-2"><label id="a4"><?php echo $a4; ?></label></div>
                        <div class="col-sm-2">    <input type="checkbox" id="check4" name="check4" value="4"></div>
                        <?php 
                            if ($nocargar>0) { 
                              echo '<button type="button" class="btn boton"  onclick="borrarCursos()" data-theme="b" style="margin:20px;float:right" value="Borrar" title="Borrar Cursos" disabled>Borrar</button>';
                            }else{
                                echo '<button type="button" class="btn boton"  onclick="borrarCursos()" data-theme="b" style="margin:20px;float:right" value="Borrar" title="Borrar Cursos">Borrar</button>';
                            }
                        ?>
                        </div>
                    </div> 
              </div> 
              <div id = "row">
                 <div id = "col" class="linea_angosta"></div>
              </div>
              <div class="row card-text">
                    <div class="col-xs-12 col-sm-10 col-md-10">
                    <?php $habilitado = ($puede_escribir ? '' : ' disabled '); ?>
                        <div class = "text"  >
                            <label for="email">SEDE:</label>
                            <input type="number" id="sede" name="sede" min=1 max=44 maxlength="2" size="3" <?php if($sede!=3) { echo ' value="'.$sede.'" disabled';}?>>
                            <label for="email">MATERIA:</label>
                            <input type="number" id="materia" name="materia" min=3 max=74 maxlength="2" size="3">
                            <label for="email">HORARIO:</label>
                            <input type="number" id="horario" name="horario" min=100 max=999 maxlength="3" size="4">
                            <label for="email">AULA:</label>
                            <input type="number" id="aula" name="aula" maxlength="3" min=1 max=999 size="4">
                            <?php 
                            if ($nocargar>0) { 
                               echo '<button type="button" class="btn boton"  onclick="agregarCursos()" data-theme="b" style="margin:20px" value="Alta" title="Alta Curso" disabled>Alta</button>';
                            }else{
                                echo '<button type="button" class="btn boton"  onclick="agregarCursos()" data-theme="b" style="margin:20px" value="Alta" title="Alta Curso">Alta</button>';
                            }
                            ?>
                        </div>
                    </div> 
              </div> 


            </div>                     
            </div>                   

            <?php if ($error == '')  {
            echo '<div class="row contenedor_botones">';
            if ($puede_escribir) {
                if ($nocargar>0) { 
                    echo '<button type="button" id="buttonGrabar" class="btn boton" data-theme="b" style="margin:20px" value="Grabar" title="NO Grabar" disabled>NO Grabar</button>';
                }else{   
                    echo '<button type="button" id="buttonGrabar" class="btn boton" data-theme="b" style="margin:20px" value="Grabar" title="Grabar">Grabar</button>';

                    if (count($yacargado)>0) { 
                        echo '<button type="button" id="buttonConAltaBaja" class="btn boton" data-theme="c" style="margin:20px;background-color:red;color:white" value="ATENCION" title="Ya tiene altabaja previa">ATENCION</button>';
                     }
     
                }

                echo '<a href='.base_url().'AltaBaja/consultar  id="btn_cancelar" class="btn boton" style="margin:20px" role="button"> Cancelar </a>';                
            }
            else {
                echo '<a href='.base_url().'AltaBaja/consultar id="btn_otro" class="btn boton" style="margin:20px" role="button"> Buscar Otro </a>';
            }
            echo '</div>';
            };    
            ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <?php echo '<div class="alert alert-danger alert-dismissible text-center">'.$error."</div>" ?> 
      <?php endif; ?>
      <?php if ($mensaje): ?>
      <?php echo '<div class="alert alert-info alert-dismissible text-center">'.$mensaje."</div>" ?> 
      <?php endif; ?>
</div>
</form>

<script type="text/javascript">

    $( document ).ready(function() {

      $("#loader-container").hide(); 

      var condicion = <?php echo $titulo; ?>;
      var regular = '<?php echo $regular; ?>';
      var baja = '<?php echo $baja; ?>';
	  var enguarani = '<?php echo $enguarani; ?>';

      if (enguarani==0){
       alert('EL ALUMNO NO ESTA EN GUARANI. DEBE REALIZAR MATRICULACION.');	 
	    $("#buttonGrabar").prop('disabled', true);
	  }
      if (condicion==4) {
          alert('EL ALUMNO CONDICIONAL DEBERÁ PRESENTAR DOCUMENTACIÓN FALTANTE.');
      }
      //if (regular=='F'){
      //    alert("ALUMNO NO REGULAR -- NO SE PUEDE ASIGNAR MATERIAS");
      //    window.location.href = "< ? php echo base_url().'AltaBaja/consultar';? >";
      //}
      if (baja=='T'){
          alert("ALUMNO DADO DE BAJA -- NO SE PUEDE ASIGNAR MATERIAS");
          window.location.href = "<?php echo base_url().'AltaBaja/consultar';?>";
      }

    });

    $("#buttonConAltaBaja").click(function(){
        <?php
         $cantact = 0;
         $altasbajas = "El Alumno tiene altabaja ya cargada:\\n";
         $altasbajasmaterias = "";
         foreach ($yacargado as $item=>$fields)  { 
            if ($fields['materia']>0) { 
               $cantact = $cantact + 1; 
               $altasbajasmaterias .= "SEDE: ".$fields['sede']." MATERIA:".$fields['materia']." HORARIO:".$fields['horario']." AULA:".$fields['aula']."\\n";
            }
         }
         if ($cantact==0) {
            $altasbajas = "SE SOLICITO LA BAJA A TODAS LAS MATERIAS.";
         }else{
            $altasbajas .= $altasbajasmaterias;
         }
         $altasbajas .= "\\n\\n"."ATENCION: Lo que ingrese y grabe aqui descarta TODO lo solicitado previamente!!!";
         if ($nocargar>0) {
            $altasbajas = "Este alumno no puede modificarse.";  
         }    
         echo 'alert("'.$altasbajas.'");';
        ?>
    });

    $("#buttonGrabar").click(function(){
        //alert('grabar');
      var accion = document.getElementById('accion').value;

      if (accion == 'G')  {
            <?php
            echo "var email = '';";
            if ($pedir_mail) { 
                echo "if (validarEmail() ){ ";
                echo " email = document.getElementById('email').value;";    
                echo "}else{ ";
                echo "    alert('El email ingresado no es válido');  ";
                echo "    return false; ";
                echo "} ";
                }
            ?>
            // ajax validacion datos cursos
            var s1 = document.getElementById("s1").innerHTML;    
            var m1 = document.getElementById("m1").innerHTML;    
            var h1 = document.getElementById("h1").innerHTML;    
            var a1 = document.getElementById("a1").innerHTML;    

            var s2 = document.getElementById("s2").innerHTML;    
            var m2 = document.getElementById("m2").innerHTML;    
            var h2 = document.getElementById("h2").innerHTML;    
            var a2 = document.getElementById("a2").innerHTML;    

            var s3 = document.getElementById("s3").innerHTML;    
            var m3 = document.getElementById("m3").innerHTML;    
            var h3 = document.getElementById("h3").innerHTML;    
            var a3 = document.getElementById("a3").innerHTML;    

            var s4 = document.getElementById("s4").innerHTML;    
            var m4 = document.getElementById("m4").innerHTML;    
            var h4 = document.getElementById("h4").innerHTML;    
            var a4 = document.getElementById("a4").innerHTML;  

              
            if (s1=="") s1="0";
            if (s2=="") s2="0";
            if (s3=="") s3="0";
            if (s4=="") s4="0";
            if (m1=="") m1="0";
            if (m2=="") m2="0";
            if (m3=="") m3="0";
            if (m4=="") m4="0";
            if (h1=="") h1="0";
            if (h2=="") h2="0";
            if (h3=="") h3="0";
            if (h4=="") h4="0";
            if (a1=="") a1="0";
            if (a2=="") a2="0";
            if (a3=="") a3="0";
            if (a4=="") a4="0";

            var datos = {
			'id_usuario': <?php echo $usuario; ?>,
            'anio': <?php echo $anio_activo; ?>,
            'clave' : <?php echo $clave_activo; ?>,
            'dni' :  <?php echo $dni_activo; ?>,
            'email' : email,    
            'sede1':s1,
            'mate1':m1,
            'hora1':h1,
            'aula1':a1,
            'sede2':s2,
            'mate2':m2,
            'hora2':h2,
            'aula2':a2,
            'sede3':s3,
            'mate3':m3,
            'hora3':h3,
            'aula3':a3,
            'sede4':s4,
            'mate4':m4,
            'hora4':h4,
            'aula4':a4
            };
            $("#loader-container").show(); 
        $.ajax({
                type: "GET",
                //url: '< ?php echo base_url() ?>AltaBaja/validar_cursos',
                url: '<?php echo base_url() ?>comun/validarw2.php',
                contentType: "application/json; charset=utf-8",
                data: datos,
                dataType: "json",
                success: function (dato, status) {
                    var mensaje =  dato['data'];
                    if (dato['success'] == true) {
                       alert("Exito: " + mensaje['message']);
                       window.location.href = "<?php echo base_url().'AltaBaja/consultar';?>";
                    }else{
                       alert(mensaje['message']);  
                    }
                    $("#loader-container").hide(); 
                },
                error: function(dato, status){
				console.log(status);
                  alert("Error al validar");
                  $("#loader-container").hide(); 
                }
         
        }); 

       }else{
            if (document.getElementById("email")== null)   {
                document.getElementById('form_total').submit();
                return true;
            }
       }    
  });


function confirmar(){
	if (confirm('¿Estas seguro de reinicializar los datos cargados?')) {
		return true;
    }
	else {
		return false;
    }
}

function LimpiarForm() {
  document.getElementById("email").value="";
}

function validarEmail() {
    var texto = document.getElementById("email").value;
    var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    if (regex.test(texto)) {
        //alert("La dirección de email " + texto + " es correcta.");
        return true;
    } else {
        //alert("La dirección de email es incorrecta.");
        return false;
    }
}

function LimpiarClave() {
    document.getElementById('accion').value = 'B';
}

function borrarCursos(){
    //alert('borrar cursos');
    var checkBox1 = document.getElementById("check1");
    var checkBox2 = document.getElementById("check2");
    var checkBox3 = document.getElementById("check3");
    var checkBox4 = document.getElementById("check4");

    if (checkBox1.checked == true){
       document.getElementById("s1").innerHTML = "";    
       document.getElementById("m1").innerHTML = "";    
       document.getElementById("h1").innerHTML = "";    
       document.getElementById("a1").innerHTML = "";    
       checkBox1.checked = false;
    }
    if (checkBox2.checked == true){
       document.getElementById("s2").innerHTML = "";    
       document.getElementById("m2").innerHTML = "";    
       document.getElementById("h2").innerHTML = "";    
       document.getElementById("a2").innerHTML = "";    
       checkBox2.checked = false;
    }
    if (checkBox3.checked == true){
       document.getElementById("s3").innerHTML = "";    
       document.getElementById("m3").innerHTML = "";    
       document.getElementById("h3").innerHTML = "";    
       document.getElementById("a3").innerHTML = "";    
       checkBox3.checked = false;
    }
    if (checkBox4.checked == true){
       document.getElementById("s4").innerHTML = "";    
       document.getElementById("m4").innerHTML = "";    
       document.getElementById("h4").innerHTML = "";    
       document.getElementById("a4").innerHTML = "";    
       checkBox4.checked = false;
    }
}

function validoAlta(s,m,h,a){
  // repite materias
  repiteMaterias = false;
  var m1 = document.getElementById("m1").innerHTML;
  var m2 = document.getElementById("m2").innerHTML;
  var m3 = document.getElementById("m3").innerHTML;
  var m4 = document.getElementById("m4").innerHTML;
  if (m1!="") {
     if (m1==m){
        repiteMaterias = true;
     }
  }
  if (m2!="") {
     if (m2==m){
        repiteMaterias = true;
     }
  }
  if (m3!="") {
      if (m3==m){
        repiteMaterias = true;
     }
  }
  if (m4!="") {
     if (m4==m){
        repiteMaterias = true;
     }
  }
  // repite horarios  
  repiteHorarios = false;
  var h1 = document.getElementById("h1").innerHTML;
  var h2 = document.getElementById("h2").innerHTML;
  var h3 = document.getElementById("h3").innerHTML;
  var h4 = document.getElementById("h4").innerHTML;
  if (h1!="") {
     if (h1==h){
        repiteHorarios = true;
     }
  }
  if (h2!="") {
     if (h2==h){
        repiteHorarios = true;
     }
  }
  if (h3!="") {
     if (h3==h){
        repiteHorarios = true;
     }
  }
  if (h4!="") {
     if (h4==h){
        repiteHorarios = true;
     }
  }

  errorendatos = ((s=="" && m=="" && h=="" && a=="") || (s!="" && m!="" && h!="" && a!=""));
  errorendatos = !(errorendatos);

  if (repiteMaterias) {
      alert('Revise carga: REPITE MATERIAS');
      return false;
  }
  if (repiteHorarios) {
      alert('Revise carga: REPITE HORARIOS');
      return false;
  }
  if (errorendatos) {
      alert('Revise carga: DATOS INCOMPLETOS');
      return false;
  }

  return true;
}

function agregarCursos(){
    <?php echo 'var maxMats ='.$maxMats.';' ?>
    var s1 = document.getElementById("s1").innerHTML;
    var s2 = document.getElementById("s2").innerHTML;
    var s3 = document.getElementById("s3").innerHTML;
    var s4 = document.getElementById("s4").innerHTML;
    
    var m1 = document.getElementById("m1").innerHTML;
    var m2 = document.getElementById("m2").innerHTML;
    var m3 = document.getElementById("m3").innerHTML;
    var m4 = document.getElementById("m4").innerHTML;
    
    var ma = document.getElementById("materia").value;

    var cantMats = 0;
    if (s1!="") cantMats = cantMats + 1;
    if (s2!="") cantMats = cantMats + 1;
    if (s3!="") cantMats = cantMats + 1;
    if (s4!="") cantMats = cantMats + 1;

    if ((cantMats<maxMats) || (cantMats==3 && (ma==48 || m1==48 || m2==48 || m3==48 || m4==48) )) {
        //alert('agrego un curso');
        var se = document.getElementById("sede").value;

        var ho = document.getElementById("horario").value;
        var au = document.getElementById("aula").value;
        if (validoAlta(se,ma,ho,au))  {
            if (s1=="") {
                document.getElementById("s1").innerHTML = se;
                document.getElementById("m1").innerHTML = ma;
                document.getElementById("h1").innerHTML = ho;
                document.getElementById("a1").innerHTML = au;

            }else{
                if (s2==""){
                    document.getElementById("s2").innerHTML = se;
                    document.getElementById("m2").innerHTML = ma;
                    document.getElementById("h2").innerHTML = ho;
                    document.getElementById("a2").innerHTML = au;
                }else{
                    if (s3==""){
                        document.getElementById("s3").innerHTML = se;
                        document.getElementById("m3").innerHTML = ma;
                        document.getElementById("h3").innerHTML = ho;
                        document.getElementById("a3").innerHTML = au;
                    }else{
                        document.getElementById("s4").innerHTML = se;
                        document.getElementById("m4").innerHTML = ma;
                        document.getElementById("h4").innerHTML = ho;
                        document.getElementById("a4").innerHTML = au;
                    } 
                }
            }
        
        }else{
            alert('Curso a agregar con datos inválidos');
        }

    }else{
        alert('NO SE PUEDEN CARGAR MÁS MATERIAS: máximo posible cargado');
    }
    <?php 
         if ($sede==3){
            echo 'document.getElementById("sede").value = "";';         
         }
    ?>
    document.getElementById("materia").value = "";
    document.getElementById("horario").value = "";
    document.getElementById("aula").value = "";    
}

</script>
