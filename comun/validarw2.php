<?php
 error_reporting(0);
 /*
 foreach (getallheaders() as $nombre => $valor) {
    echo "$nombre: $valor\n";
 }
 */
 /*
 $referringpage = $_SERVER['HTTP_REFERER'];
 if ($referringpage!="https://www4.cbc.uba.ar/sedes/AltaBaja/altabaja_post") {
 //if ($referringpage!="http://localhost/sedes/AltaBaja/altabaja_post") {
   exit;
 }
*/
 $id_usuario = $_GET['id_usuario'];
 $anio = $_GET['anio'];
 $clave = $_GET['clave'];
 $dni = $_GET['dni'];
 $email = $_GET['email']."";

 $s1 = $_GET['sede1'];
 $m1 = $_GET['mate1'];
 $h1 = $_GET['hora1'];
 $a1 = $_GET['aula1'];
 
 $s2 = $_GET['sede2'];
 $m2 = $_GET['mate2'];
 $h2 = $_GET['hora2'];
 $a2 = $_GET['aula2'];
 
 $s3 = $_GET['sede3'];
 $m3 = $_GET['mate3'];
 $h3 = $_GET['hora3'];
 $a3 = $_GET['aula3'];
 
 $s4 = $_GET['sede4'];
 $m4 = $_GET['mate4'];
 $h4 = $_GET['hora4'];
 $a4 = $_GET['aula4'];
 
 $retorna = "";
 $lSeguir = true;
 $asigno = true;
/* local */
/*
 $db_host="localhost";
 $db_user="root";
 $db_pass="";
 $db="cbc_sede";
 $coneccion = mysqli_connect($db_host, $db_user, $db_pass,$db);
*/
/* w2 */

 $db_host="localhost";
 $db_user="soporte";
 $db_pass="r3sult4d0";
 $db="cbc_sedes";
 $coneccion = mysqli_connect($db_host, $db_user, $db_pass,$db);

 $db_host2="localhost";
 $db_user2="soporte";
 $db_pass2="r3sult4d0";
 $db2="cbc_padrones";
 $coneccion2 = mysqli_connect($db_host2, $db_user2, $db_pass2, $db2);


 function insertarAsignacion($id_usuario,$anio,$clave,$s1,$m1,$h1,$a1,$s2,$m2,$h2,$a2,$s3,$m3,$h3,$a3,$s4,$m4,$h4,$a4) {
  global $coneccion;
  global $retorna;

   $resultado = true;
   $update = "update altabaja set activo=0, usuario_id=$id_usuario where anio=$anio and clave=$clave";
   $ressuper = mysqli_query($coneccion, $update);
   if (mysqli_errno($coneccion)!=0) {  
     $resultado = false;
     $retorna .= mysqli_errno($coneccion)." NO SE PUDO ACTUALIZAR EL CURSO"."\n";
   }

   //$mail = "'".filter_var( $email, FILTER_SANITIZE_EMAIL)."'";   
$qryinsert = "insert into altabaja(anio,clave,sede,materia,horario,aula,usuario_id) values ($anio, $clave, $s1, $m1, $h1, $a1,$id_usuario)";
    $ressuper = mysqli_query($coneccion, $qryinsert);
    if (mysqli_errno($coneccion)!=0) {  
      $resultado = false;
      $retorna .= mysqli_errno($coneccion)." NO SE PUDO GUARDAR EL CURSO: ".$s1." ".$m1." ".$h1." ".$a1."\n";
    }

    $qryinsert = "insert into altabaja(anio,clave,sede,materia,horario,aula,usuario_id) values ($anio, $clave, $s2, $m2, $h2, $a2, $id_usuario)";
    $ressuper = mysqli_query($coneccion, $qryinsert);
    if (mysqli_errno($coneccion)!=0) {  
      $resultado = false;
      $retorna .= mysqli_errno($coneccion)." NO SE PUDO GUARDAR EL CURSO: ".$s2." ".$m2." ".$h2." ".$a2."\n";
    }
   
    $qryinsert = "insert into altabaja(anio,clave,sede,materia,horario,aula,usuario_id) values ($anio, $clave, $s3, $m3, $h3, $a3, $id_usuario)";
    $ressuper = mysqli_query($coneccion, $qryinsert);
    if (mysqli_errno($coneccion)!=0) {  
      $resultado = false;
      $retorna .= mysqli_errno($coneccion)." NO SE PUDO GUARDAR EL CURSO: ".$s3." ".$m3." ".$h3." ".$a3."\n";
    }


    $qryinsert = "insert into altabaja(anio,clave,sede,materia,horario,aula,usuario_id) values ($anio, $clave, $s4, $m4, $h4, $a4, $id_usuario)";
    $ressuper = mysqli_query($coneccion, $qryinsert);
    if (mysqli_errno($coneccion)!=0) {  
      $resultado = false;
      $retorna .= mysqli_errno($coneccion)." NO SE PUDO GUARDAR EL CURSO: ".$s4." ".$m4." ".$h4." ".$a4."\n";
    }

   return $resultado;
 } 

 function superpone($ho1,$ho2) {
  global $coneccion;
  global $retorna;
   $qrysuper = "select count(*) as cantidad from superpone where hora1=$ho1 and hora2=$ho2";
   $ressuper = mysqli_query($coneccion, $qrysuper);
   if (mysqli_errno($coneccion)==0) {
     $rowsuper = mysqli_fetch_array($ressuper, MYSQLI_ASSOC);
	   if ($rowsuper['cantidad']>0) {
        $resultado = true;
		    $retorna .= "SUPERPONE HORARIOS: ".$ho1." ".$ho2."\n";
	   }else{
        $resultado = false;
	   }
   }else{
     $resultado = true;
     $retorna .= mysqli_errno($coneccion)." SUPERPONE HORARIOS: ".$ho1." ".$ho2."\n";
   }
   return $resultado;
 }
 
 function consecutivos($ho1,$ho2) {
  global $coneccion;
  global $retorna;
   $resultado = true;
   $qryconsec = "select count(*) as cantidad from consecutivos where hora1=$ho1 and hora2=$ho2";
   $resconsec = mysqli_query($coneccion, $qryconsec);
   if (mysqli_errno($coneccion)==0) {
      $rowconsec = mysqli_fetch_array($resconsec, MYSQLI_ASSOC);
      if ($rowconsec['cantidad']>0) {
            $resultado = true;
            $retorna .= "SEDES DISTINTAS HORARIOS CONSECUTIVOS: ".$ho1." ".$ho2."\n";
      }else{
            $resultado = false;
      }
   }else{
     $resultado = true;
     $retorna .= mysqli_errno($coneccion)." SEDES DISTINTAS HORARIOS CONSECUTIVOS: ".$ho1." ".$ho2."\n";
   }
   //return $resultado;
    $retorna .= "";
    return false;
 }
 
 function haycurso($se,$ma,$ho,$au) {
  global $coneccion;
  global $retorna;
   $resulta = 0;
   $qrycurso = "select comision as curso from cursos where cuat=1 and sede=$se and materia=$ma and horario=$ho and aula=$au";
   $rescurso = mysqli_query($coneccion, $qrycurso);
   if (mysqli_errno($coneccion)==0) {
     if (mysqli_num_rows($rescurso)>0){
        $rowcurso = mysqli_fetch_array($rescurso, MYSQLI_ASSOC);
		    $resulta = $rowcurso['curso'];
	 }else{
        $resulta = 0;
		    $retorna .= "CURSO INEXISTENTE: ".$se." ".$ma." ".$ho." ".$au."\n";
	 }
	 //mysqli_free_result($rowcurso);
   }else{
     $resulta = 0;
     $retorna .= mysqli_errno($coneccion)." CURSO INEXISTENTE: ".$se." ".$ma." ".$ho." ".$au."\n";
   }
   return $resulta;
 }
 
 function cursaUBAXXI($an,$cl,$ma) {
  global $coneccion;
  global $retorna;
   $resultado = false;
   $qryapro = "select count(*) as cantidad from cursa_xxi where anio=$an and clave=$cl and materia=$ma";
   $resapro = mysqli_query($coneccion, $qryapro);
   if (mysqli_errno($coneccion)==0) {
     $rowapro = mysqli_fetch_array($resapro);
	   if ($rowapro['cantidad']>0) {
       $resultado = true;
	   }else{
       $resultado = false;
	   }
   }else{
     $resultado = true;
     $retorna .= mysqli_errno($coneccion)." APROBO/CURSA UBA XXI: ".$ma."\n";
   }
   return $resultado;
 }

 /*
 function aproboUBAXXI($an,$cl,$ma) {
  global $coneccion;
  global $retorna;
   $resultado = false;
   $qryapro = "select count(*) as cantidad from cursa_xxi where anio=$an and clave=$cl and materia=$ma";
   $resapro = mysqli_query($coneccion, $qryapro);
   if (mysqli_errno($coneccion)==0) {
     $rowapro = mysqli_fetch_array($resapro);
	   if ($rowapro['cantidad']>0) {
       $resultado = true;
	   }else{
       $resultado = false;
	   }
   }else{
     $resultado = true;
     $retorna .= mysqli_errno($coneccion)." APROBO UBA XXI: ".$ma."\n";
   }
   return $resultado;
 }

 // Pide es que está cursando por uba xxi
 function pideUBAXXI($dni,$ma) {
  global $coneccion;
  global $retorna;
   $resultado = false;
   $qryapro = "select count(*) as cantidad from pide_ubaxxi where dni=$dni and materia=$ma";
   $resapro = mysqli_query($coneccion, $qryapro);
   if (mysqli_errno($coneccion)==0) {
      $rowapro = mysqli_fetch_array($resapro, MYSQLI_ASSOC);
      if ($rowapro['cantidad']>0) {
          $resultado = true;
      }else{
          $resultado = false;
      }
   }else{
     $resultado = true;
     $retorna .= mysqli_errno($coneccion)." PIDE UBA XXI: ".$ma."\n";
   }
   return $resultado;
 }
 */ 
 
// Carreras de un dni
  function getCarreras($dni){
    global $coneccion2;
	global $retorna;
    $select = "select codigo_propuesta as carrera from padguara where dni=".$dni." and codigo_propuesta<>0 and plan_codigo>2000 and resultado_estado='A'";
	$resultado = mysqli_query($coneccion2, $select);
    if (mysqli_errno($coneccion2)==0) {
	  $rowapro = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
	 // $rowapro = mysqli_fetch_array($resultado,  MYSQLI_ASSOC);
    }else{
      $rowapro = array();
    }
    return $rowapro;
  }
 
// Materia de la grilla de una carrera
  function MateriaDeCarrera($ca, $ma){
    global $coneccion;
    global $retorna;
    $resultado = false;
    $qryapro = "select count(*) as cantidad from carrera_materia where carrera=$ca and materia=$ma and origen<>'E'";
    $resapro = mysqli_query($coneccion, $qryapro);
    if (mysqli_errno($coneccion)==0) {
      $rowapro = mysqli_fetch_array($resapro, MYSQLI_ASSOC);
      if ($rowapro['cantidad']>0) {
          $resultado = true;
      }else{
          $resultado = false;
      }
    }
    return $resultado;
  }  

// Materia de la Grilla. De alguna
   function MateriaGrilla($dni, $ma){
    global $retorna;
	$silatiene = 0;
    $carreras = getCarreras($dni);
	for($x=0; $x<count($carreras); $x++) {
	   $ca = $carreras[$x]['carrera'];
	   if (MateriaDeCarrera($ca, $ma)) {
	     $silatiene++;
	   }
	}
	return ($silatiene>0);
  }


  function pideLa($ma, $m1, $m2, $m3, $m4) {
    return (($ma==$m1) || ($ma==$m2) || ($ma==$m3) || ($ma==$m4));
  }

  function pideSuperpone($h1,$h2,$h3,$h4){
   $pS = ($h1!=0 && $h2!=0 && superpone($h1,$h2));
   $pS = ($pS || ($h1!=0 && $h3!=0 && superpone($h1,$h3)));
   $pS = ($pS || ($h1!=0 && $h4!=0 && superpone($h1,$h4)));
   $pS = ($pS || ($h2!=0 && $h3!=0 && superpone($h2,$h3)));
   $pS = ($pS || ($h2!=0 && $h4!=0 && superpone($h2,$h4)));
   $pS = ($pS || ($h3!=0 && $h4!=0 && superpone($h3,$h4)));
   return $pS;
  }  
  
  function pideConsecutivos($s1,$s2,$s3,$s4,$h1,$h2,$h3,$h4){
   $pC = false;
   if ($s1!=0 && $s2!=0 && $s1!=$s2){
     $pC = ($pC || consecutivos($h1, $h2));
   } 
   if ($s1!=0 && $s3!=0 && $s1!=$s3){
     $pC = ($pC || consecutivos($h1, $h3));
   } 
   if ($s1!=0 && $s4!=0 && $s1!=$s4){
     $pC = ($pC || consecutivos($h1, $h4));
   } 
   if ($s2!=0 && $s3!=0 && $s2!=$s3){
     $pC = ($pC || consecutivos($h2, $h3));
   } 
   if ($s2!=0 && $s4!=0 && $s2!=$s4){
     $pC = ($pC || consecutivos($h2, $h4));
   } 
   if ($s3!=0 && $s4!=0 && $s3!=$s4){
     $pC = ($pC || consecutivos($h3, $h4));
   } 
   return $pC;  
  }  
  
  function existeCurso($anio,$clave,$s1,$m1,$h1,$a1,$s2,$m2,$h2,$a2,$s3,$m3,$h3,$a3,$s4,$m4,$h4,$a4) {
   global $retorna; 
   $curso1 = -1;
   $curso2 = -1;
   $curso3 = -1;
   $curso4 = -1;
   $existe = false;
   
   if ($s1!=0 && $m1!=0 && $h1!=0) {
     $curso1 = haycurso($s1,$m1,$h1,$a1);
   }
   if ($s2!=0 && $m2!=0 && $h2!=0) {
     $curso2 = haycurso($s2,$m2,$h2,$a2);
   }
   if ($s3!=0 && $m3!=0 && $h3!=0) {
     $curso3 = haycurso($s3,$m3,$h3,$a3);
   }
   if ($s4!=0 && $m4!=0 && $h4!=0) {
     $curso4 = haycurso($s4,$m4,$h4,$a4);
   }
   
   if ($curso1!=0 && $curso2!=0 && $curso3!=0 && $curso4!=0) {
     $existe = true;
   }else{
     $existe = false;
   }  
   return $existe;
  }
  
  //=================================================================================================
  
  $asigno = true;
 
  // Por UBAXXI
  if ($m1!=0){
    if ( cursaUBAXXI($anio, $clave, $m1)){
    $retorna .= "Aprobo/Cursa por UBAXXI: ".$m1."\n";
    $asigno = false;
    }
  }
  if ($m2!=0){
    if ( cursaUBAXXI($anio, $clave, $m2)){
    $retorna .= "Aprobo/Cursa por UBAXXI: ".$m2."\n";
    $asigno = false;
    }
  }
  if ($m3!=0){
    if ( cursaUBAXXI($anio, $clave, $m3)){
    $retorna .= "Aprobo/Cursa por UBAXXI: ".$m3."\n";
    $asigno = false;
    }
  }
  if ($m4!=0){
    if ( cursaUBAXXI($anio, $clave, $m4)){
    $retorna .= "Aprobo/Cursa por UBAXXI: ".$m4."\n";
    $asigno = false;
    }
  }  
  // Not in Grilla
  if ($m1!=0){
     if (!MateriaGrilla($dni, $m1)){
       $retorna .= "Materia: ".$m1." no pertenece a la grilla de la carrera"."\n";
       $asigno = false;
	 }
  }
  if ($m2!=0){
     if (!MateriaGrilla($dni, $m2)){
       $retorna .= "Materia: ".$m2." no pertenece a la grilla de la carrera"."\n";
       $asigno = false;
	 }
  }
  if ($m3!=0){
     if (!MateriaGrilla($dni, $m3)){
        $retorna .= "Materia: ".$m3." no pertenece a la grilla de la carrera"."\n";
       $asigno = false;
	 }
  }
  if ($m4!=0){
     if (!MateriaGrilla($dni, $m4)){
       $retorna .= "Materia: ".$m4." no pertenece a la grilla de la carrera"."\n";
       $asigno = false;
	 }
  }
  
  // Superpone horarios en lo que solicita
  if (pideSuperpone($h1,$h2,$h3,$h4)){
    $asigno = false;
  }

  //Horarios consecutivos Sedes distintas
  // if (pideConsecutivos($s1,$s2,$s3,$s4,$h1,$h2,$h3,$h4) ) {
  //  $asigno = false;
  //}
 
  //Existe curso
  if (!existeCurso($anio,$clave,$s1,$m1,$h1,$a1,$s2,$m2,$h2,$a2,$s3,$m3,$h3,$a3,$s4,$m4,$h4,$a4)) {
    $asigno = false;
  }

  if ($asigno){ 
    if (insertarAsignacion($id_usuario,$anio,$clave, $s1,$m1,$h1,$a1, $s2,$m2,$h2,$a2, $s3,$m3,$h3,$a3, $s4,$m4,$h4,$a4) ){ 
       $retorna = "CURSOS: INGRESO OK";
	}else{ 
       $retorna = "CURSOS: INGRESO CON ERRORES"."\n".$retorna ;
    }
  }
  
  if ($asigno) {        
      $jsondata["success"] = true;
      $jsondata["data"] = array('message' => $retorna);	  
  }
  else {
      $jsondata["success"] = false;
      $jsondata["data"] = array('message' =>  $retorna);
  }   
  mysqli_close($coneccion);
  mysqli_close($coneccion2);

  header('Content-type: application/json; charset=utf-8');
  echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>