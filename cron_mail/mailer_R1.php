<?php 
   $db_host = "localhost";
   $db_user = "soporte";
   $db_pass = "r3sult4d0";
   $db = "cbc_sedes";
   $coneccion = mysqli_connect($db_host, $db_user, $db_pass,$db);
   require '/var/www/html/sedes/cron_mail/PHPMailer-master/PHPMailerAutoload.php';
   include_once ('/var/www/html/sedes/cron_mail/sendmail.php');
   include('/var/www/html/sedes/cron_mail/mail_RE.php'); // deja el contenido del cuerpo del mail en la variable $contenido
   //----------------------------------------------------------------------------------
   $myfile = fopen("/var/www/html/sedes/cron_mail/logfile.txt", "a");
   //----------------------------------------------------------------------------------
   $debug = true;
   $httpdirs = "https://www.cbc.uba.ar";
   $tema = "REMATRICULACION-REINSCRIPCION 2021 RESULTADO";
   $from = "rematriculacion1@cbc.uba.ar";

   $txt = "==========================================================================================="."\r\n";
   fwrite($myfile, $txt);	
   $txt = "INICIO ENVIO: ".date('d/m/Y H:i:s')."\r\n";
   fwrite($myfile, $txt);
   $sql = "select Expediente, APELLIDO_SOLICITANTE, NOMBRE_SOLICITANTE, EMAIL from tad1 where en_padron='R' and t_coincidencia='D' and   mail_enviado_cbc<>'S' and t_tramite='R' and t_mail_enviar_cbc='E' LIMIT 600";
//   $sql = "select Expediente, APELLIDO_SOLICITANTE, NOMBRE_SOLICITANTE, EMAIL from tad1 where en_padron='R' and t_coincidencia='X' and   mail_enviado_cbc='S' and t_tramite='R' and t_mail_enviar_cbc='E' LIMIT 600";
   $result = mysqli_query($coneccion, $sql); 
   if (mysqli_errno($coneccion)==0) {
	   while ($myrow =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	     $id = $myrow['Expediente'];
		 $to = $myrow['EMAIL'];
         $mensaje = $contenido;
		 $ahora = date('d/m/Y H:i:s');
		 $txt =  $id." ".$to." ".$ahora."\r\n"; 
		 $nombre_destinatario = $myrow['NOMBRE_SOLICITANTE'];
         $mensaje = str_replace("{nombre_alumno}", $nombre_destinatario, $mensaje);
		 if (mandar_mail($to, $from, $tema, $mensaje, $nombre_destinatario)) {
		     // actualizar tad1 con mail enviado 	
			 $txt.= " MAIL ENVIADO SATISFACTORIAMENTE"."\r\n";
			 $update = "update tad1 set mail_enviado_cbc='S', mensaje='".$ahora."' where Expediente='".$id."'";
		 }else{
		     // actualizar tad1 con mail no se pudo enviar
			 $txt.= " ERROR EN ENVIO DE MAIL"."\r\n";
			 $update = "update tad1 set mail_enviado_cbc='N', mensaje="."'Error envío mail: ".$ahora."' where Expediente='".$id."'";		 
		 }

		 $resultado = mysqli_query($coneccion, $update); 
		 if (mysqli_errno($coneccion)!=0) {
            $cod = mysqli_errno($coneccion);
			$txt.= " "."Error actualizar tabla tad1 update resultado envio mail: ".$cod."\r\n";
		 }

         fwrite($myfile, $txt);	
		 $txt ="............................................................................................................."."\r\n";
		 fwrite($myfile, $txt);	
		// sleep(3);	 

	   }
  }else{
     $txt = mysqli_errno($coneccion)."\r\n";;
	 fwrite($myfile, $txt);	
  }// error en select
   $txt = "FIN ENVIO: ".date('d/m/Y H:i:s')."\r\n";
   fwrite($myfile, $txt);	
   fclose($myfile);
   mysqli_close($coneccion);
?> 
