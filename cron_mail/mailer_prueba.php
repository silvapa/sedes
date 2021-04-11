<?php 
   require '/var/www/html/sedes/cron_mail/PHPMailer-master/PHPMailerAutoload.php';
   include_once ('/var/www/html/sedes/cron_mail/sendmail.php');
   include('/var/www/html/sedes/cron_mail/mail_RE.php'); // deja el contenido del cuerpo del mail en la variable $contenido
   //----------------------------------------------------------------------------------
   $myfile = fopen("/var/www/html/sedes/cron_mail/logfile.txt", "a");
   //----------------------------------------------------------------------------------
   $debug = true;
   $httpdirs = "https://www.cbc.uba.ar";
   $tema = "REMATRICULACION-REINSCRIPCION 2021 RESULTADO";
   $from = "rematriculacion@cbc.uba.ar";

   $txt = "==========================================================================================="."\r\n";
   fwrite($myfile, $txt);	
   $txt = "INICIO ENVIO: ".date('d/m/Y H:i:s')."\r\n";
   fwrite($myfile, $txt);
	     $id = "PRUEBAAA";
		 $to = "mbaleani@gmail.com";
         $mensaje = $contenido;
		 $ahora = date('d/m/Y H:i:s');
		 $txt =  $id." ".$to." ".$ahora."\r\n"; 
		 $nombre_destinatario = "Nombre";
         $mensaje = str_replace("{nombre_alumno}", $nombre_destinatario, $mensaje);
		 if (mandar_mail($to, $from, $tema, $mensaje, $nombre_destinatario)) {
		     // actualizar tad1 con mail enviado 	
			 $txt.= " MAIL ENVIADO SATISFACTORIAMENTE"."\r\n";
		 }else{
		     // actualizar tad1 con mail no se pudo enviar
			 $txt.= " ERROR EN ENVIO DE MAIL"."\r\n";
		 }


         fwrite($myfile, $txt);	
		 $txt ="............................................................................................................."."\r\n";
		 fwrite($myfile, $txt);	
		// sleep(3);	 

   $txt = "FIN ENVIO: ".date('d/m/Y H:i:s')."\r\n";
   fwrite($myfile, $txt);	
   fclose($myfile);
?> 
