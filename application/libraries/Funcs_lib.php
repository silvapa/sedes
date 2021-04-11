<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Funcs_lib {


  function ValidarDatos($campo){
    $ok = 0;
  //Array con las posibles cadenas a utilizar por un hacker
    $CadenasProhibidas = array("Content-Type:","MIME-Version:", "Content-Transfer-Encoding:","Return-path:","Subject:","From:","Envelope-to:","To:","bcc:","cc:", "UNION",   "DELETE","DROP","SELECT","INSERT","UPDATE","CRERATE","TRUNCATE","ALTER","INTO","DISTINCT","GROUP BY","WHERE"," RENAME","DEFINE","UNDEFINE","PROMPT","ACCEPT","VIEW","COUNT","HAVING","'",'"',"{","}","[","]","http://", "$", "&","*");

   foreach($CadenasProhibidas as $valor){ 
     if(strpos(strtolower($campo), strtolower($valor)) !== false){ 
	   $ok = $ok + 1;
     } 
   } 
   return $ok;
 } 

 function fputcsv2($handle, $row, $fd=';', $quot='"')
{
   $str='';
   $i = 0;
   foreach ($row as $cell) {
       if ($i == 0) {
        $cell = substr($cell,4);
        $i++;
       }
       $cell=str_replace(Array($quot,        "\n"),
                         Array($quot.$quot,  ''),
                         $cell);
       if (strchr($cell, $fd)!==FALSE || strchr($cell, $quot)!==FALSE) {
           $str.=$quot.$cell.$quot.$fd;
       } else {
           $str.=$cell.$fd;
       }
   }

   fputs($handle, substr($str, 0, -1)."\n");

   return strlen($str);
}


 function eliminar_tildes($cadena){

  //Codificamos la cadena en formato utf8 en caso de que nos de errores
//  $cadena = utf8_encode($cadena);
//  $cadena = utf8_decode($cadena);
  $cadena = str_replace(
    array('á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú'),
    array('a', 'A', 'e', 'E', 'i', 'I', 'o', 'O', 'u', 'U'),
    $cadena);
    return $cadena;
  }
      
 function fechaOk($fdde, $fhta){
    $fecha_actual = mktime(0,0,0,date('m'),date('d'),date('Y'));
    list($d,$m,$a) = explode("/",$fdde);
    $desde = mktime(0,0,0,$m,$d,$a);
    list($d,$m,$a) = explode("/",$fhta);
    $hasta = mktime(0,0,0,$m,$d,$a);
    return ( ($desde<=$fecha_actual) && ($fecha_actual<=$hasta));
  }

 function getNombreMes($mes){
   switch ($mes) {
     case 1: return "Enero";
     case 2: return "Febrero";
     case 3: return "Marzo";
     case 4: return "Abril";
     case 5: return "Mayo";
     case 6: return "Junio";
     case 7: return "Julio";
     case 8: return "Agosto";
     case 9: return "Septiembre";
     case 10: return "Octubre";
     case 11: return "Noviembre";
     case 12: return "Diciembre";
   }	 
 }
 
 function FechaString($fecha){
   list($dia,$mes,$anio) = explode('/',$fecha);
   return trim($dia)." de ".getNombreMes($mes)." de ".trim($anio);
 } 

  function Calcular_Cuil($dni, $sexo){
    return $dni+1;
  }
}