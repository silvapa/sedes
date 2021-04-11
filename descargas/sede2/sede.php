<?php
  error_reporting(0);
  include('../../include/funcs.php');
  function fechaOk($fdde, $fhta){
    $fecha_actual = mktime(0,0,0,date('m'),date('d'),date('Y'));
	list($d,$m,$a) = explode("/",$fdde);
    $desde = mktime(0,0,0,$m,$d,$a);
	list($d,$m,$a) = explode("/",$fhta);
	$hasta = mktime(0,0,0,$m,$d,$a);
    return ( ($desde<=$fecha_actual) && ($fecha_actual<=$hasta));
  }
  //leer configuracion sede
  $archivo = file("sconfig.ini"); 
  list($sede, $sedenombre) = explode(',',$archivo[0]);
  //--------------------------------------------------
  $fechaactual = date("d/m/Y");
  //--------------------------------------------------
  $tabla = "";
  $color0 ="#D6F7FC";
  $color1 ="#FF9966";
  $color2 ="#9999CC";
  $color3 ="#FFFFFF";
  $tabla = '<div style="border:1px black solid; width:725px; height:270px; overflow:auto;"><table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF">';
  $tabla.= "<tr bgcolor="."'".$color0."'>";
  $tabla .="<td><font size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>FECHA</font></td>";
  $tabla .="<td><font size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>SISTEMA</font></td>";
  $tabla .="<td><font size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>DESCARGAR</font></td>";
  $tabla .="<td><font size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>VALIDO HASTA</font></td>";
  $tabla.="</tr>";

  //leer sistemas disponibles para descarga
  $archivo = file("../dwfiles.ini"); 
  $lineas = count($archivo); 
  for($i=1; $i < $lineas; $i++) {
     list($sd, $fdde, $fhta, $sistema, $descripcion, $alink) = explode(',',$archivo[$i]);
     if (($sd==$sede) || ($sd==0) ) {
	   if ( fechaOk($fdde, $fhta) ) {
         $tabla .="<td><font color='"."#FFFFFF'"." size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>".$fdde."</font></td>";
         $tabla .="<td><font color='"."#FFFFFF'"." size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>".$descripcion."</font></td>";
	     if ($sd==0) {
	       $tabla .="<td><font color='"."#FFFFFF'"." size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'><a href="."'../comun/".trim($alink)."'>".$sistema."</a></font></td>";
	     }else{
	       $tabla .="<td><font color='"."#FFFFFF'"." size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'><a href="."'".trim($alink)."'>".$sistema."</a></font></td>";
	     }
         $tabla .="<td><font color='"."#FFFFFF'"." size='".'2'."' face='".'Arial, Helvetica, sans-serif'."'>".$fhta."</font></td>";
         $tabla.="</tr>";
	   }
	 }
  }
  $tabla.="</table></div>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Ciclo B&aacute;sico Com&uacute;n - Panel Descargas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="STYLESHEET" href="../include/estilos.css" type="text/css">
<script LANGUAGE="javaScript">
 function cerrar(){
   window.close();
 }

</script>
<style type="text/css">
.Estilo17 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #000000;
}
</style>
</head>
<body>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#006B61">
  <!--DWLayoutTable-->
  <form name="form0" action="inicio.php" method="post" onSubmit="return validateForm();">
  <tr> 
    <td height="132" colspan="5" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <!--DWLayoutTable-->
      <tr> 
        <td width="16" height="80" valign="top" background="../image/topIzq.gif" bgcolor="#FFFFFF"><!--DWLayoutEmptyCell-->&nbsp;</td>
            <td width="658" align="left" valign="middle" background="../image/topfondo.gif" bgcolor="#FFFFFF"> 
              <div align="left" class="Estilo4"> 
                <p align="left" class="Estilo7"><em><font color="#FFFFFF">CICLO 
                B&Aacute;SICO COM&Uacute;N</font> </em></p>
              </div></td>
            <td width="87" valign="top"><img src="../image/logoubalectivo.jpg" width="87" height="80"></td>
            <td width="19" valign="top"  background="../image/topder.gif" bgcolor="#FFFFFF"><!--DWLayoutEmptyCell-->&nbsp;</td>
          </tr>
      <tr> 
        <td height="52" colspan="4" valign="middle" background="../image/topMid.gif"><div align="center" class="Estilo6"><font color="#FFFFFF" size="5"><?php echo "Sede: ".$sede." - ".$sedenombre; ?></font></div></td>
          </tr>
    </table></td>
    </tr>
  <tr> 
    <td height="24" colspan="3" align="center" valign="middle" background="../image/btnmenu.gif" class="Estilo4"><?php echo FechaString($fechaactual); ?></td>
    <td colspan="2" align="center" valign="middle" background="../image/btnmenu.gif"><div align="right">
      <input type="button" name="Submit" value="Salir" onClick="cerrar()">
      
    </div></td>
    </tr>
  <tr align="center" valign="middle"> 
    <td height="4" colspan="5" valign="top"> 
      <div align="center"><img src="../image/BLKLINED.gif" width="780" height="2" align="middle"></div></td>
    </tr>
  <tr align="center" valign="middle">
    <td width="20" height="1"></td>
    <td width="34"></td>
    <td width="666"></td>
    <td width="42"></td>
    <td width="18"></td>
  </tr>
  
  <tr align="center" valign="middle">
    <td height="52" colspan="5" align="center" valign="middle" bgcolor="#006B61"><div align="justify" class="Estilo11">
      <p align="center" valign="middle">PANEL DESCARGAS: SISTEMAS DISPONIBLES PARA LA SEDE</p>
      </div></td>
    </tr>
  
  <tr align="center" valign="middle">
    <td height="53" colspan="2" align="center" valign="middle"><a href="../../image/textohelp.png" target="_blank"><img src="../image/HELP.PNG" alt="C&oacute;mo utilizar esta p&aacute;gina" width="34" height="31" border="0"></a></td>
    <td colspan="3" rowspan="4" valign="top"><div align="left"><?php echo $tabla;?></div></td>
    </tr>
  <tr align="center" valign="middle">
    <td height="53" colspan="2" align="center" valign="middle"><?php echo "<a href='"."../../cargas/sede".trim($sede)."/enviar.php"."'>"; ?><img src="../image/CASITA.PNG" alt="Enviar archivos a Planificaci&oacute;n" width="34" height="31" border="0"></a></td>
    </tr>
  <tr align="center" valign="middle">
    <td height="53" colspan="2" align="center" valign="middle"><a href="mailTo:planificacion@cbc.uba.ar"><img src="../image/IMAGES.JPG" alt="Enviar mail a Planificaci&oacute;n" width="34" height="31" border="0"></a></td>
    </tr>
  <tr align="center" valign="middle">
<td height="111" colspan="2" valign="top"><a href="../instaladores/instaladores.php"><img src="../image/instaladores.JPG" alt="Instaladores desde Cero" width="34" height="34" border="0"></a></td>    </tr>
  <tr align="center" valign="middle">
    <td height="4" colspan="5" align="center" valign="middle"> <div align="center"><img src="../image/BLKLINED.gif" width="780" height="2" align="middle"></div></td>
    </tr>
  <tr align="center" valign="middle">
    <td height="1"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

  <tr align="center" valign="middle">
    <td height="55" valign="top" background="../image/bottomLeft.gif"><!--DWLayoutEmptyCell-->&nbsp;</td>
    <td colspan="3" align="center" valign="middle" background="../image/bottomfondo.gif"> 
      <p align="center" class="Estilo15 Estilo17">Subsecretar&iacute;a de Planificaci&oacute;n - CBC </p></td>
    <td valign="top" background="../image/bottomRight.gif"><!--DWLayoutEmptyCell-->&nbsp;</td>
    </tr>
  <tr align="center" valign="middle">
    <td height="16" colspan="5" valign="top" bgcolor="#FFFFFF"> <div align="center"><font size="2" face="AvantGarde Bk BT">www3.cbc.uba.ar</font></div></td>
    </tr>
  </form>
</table>
</body>
</html>
