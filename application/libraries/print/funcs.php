<?php
  function ValidarDatos($campo){
    $ok = 0;
  //Array con las posibles cadenas a utilizar por un hacker
    $CadenasProhibidas = array("Content-Type:","MIME-Version:", "Content-Transfer-Encoding:","Return-path:","Subject:","From:","Envelope-to:","To:","bcc:","cc:", "UNION",   "DELETE","DROP","SELECT","INSERT","UPDATE","CRERATE","TRUNCATE","ALTER","INTO","DISTINCT","GROUP BY","WHERE"," RENAME","DEFINE","UNDEFINE","PROMPT","ACCEPT","VIEW","COUNT","HAVING","'",'"',"{","}","[","]","http://", "$", "&","*");

   foreach($CadenasProhibidas as $valor){ 
     if ( strpos(strtolower($campo), strtolower($valor)) !== false){ 
	   $ok = $ok + 1;
     }
   } 
   return $ok;
 } 

 function getEncrypt($cadena1, $cadena2){
   $string = $cadena1."-".$cadena2;
   $key = "M3RK3l4NG3L4";
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
 }
 
 function getDecrypt($string) {
   $result = '';
   $key = "M3RK3l4NG3L4";
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
 }

 
 
 
?>
