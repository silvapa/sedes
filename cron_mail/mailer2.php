<?php

  $httpdirs = "http://toushoracio.com.ar";
  $to = 'margarita@toushoracio.com.ar';
  //$to = 'dgrippo@gmail.com';
  
  $subject = "RESPUESTA CLIENTE";
  $myfile = fopen("logfile.txt", "a");

  // Para enviar un correo HTML, debe establecerse la cabecera Content-type
  $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
  $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Cabeceras adicionales
  $cabeceras .= 'Cc: Horacio <horacio@toushoracio.com.ar>' . "\r\n";
  $cabeceras .= 'Bcc: Daniel <itassets.com.ar@gmail.com>' . "\r\n";
  $cabeceras .= 'From: SMSClientes <toussoporte@itassets.com.ar>' . "\r\n";
	
  for ($x=0; $x<count($array_resp); $x++) { 
    $uno = $array_resp[$x];
	$cliente = $uno['nom'];
	$telefono = $uno['cel'];
	$respuesta =  $uno['men']."<br>";
	$respuesta .= "Respuesta enviada: ".$uno['hora'];
	
	$contenido = "--- RESPUESTA SMS CLIENTE ---   "."<br>";
	$contenido .= "CLIENTE  : " . $cliente. "   "."<br>";
	$contenido .= "TELEFONO : " . $telefono. "   "."<br>";
	$contenido .= "RESPUESTA: " . $respuesta. "   "."<br>"."<br>";
	$contenido .= "Email automatico enviado desde ". $httpdirs . " - No responder a este mail."."<br>";
	


	if (mail($to, $subject, $contenido, $cabeceras) ) {
	   $txt = "Mail enviado ".date('Y-m-d')." ".$cliente."\n";
	}else{
	   $txt = "NO SE ENVIO  ".date('Y-m-d')." ".$cliente."\n";
	}

	fwrite($myfile, $txt);
	sleep(3);
  }// for
  $txt = "==========================================================================================="."\r\n";
  fwrite($myfile, $txt);
  fclose($myfile);
  echo "FIN PROCESO";
?>