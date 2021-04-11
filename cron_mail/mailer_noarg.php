<?php 
   $db_host = "localhost";
   $db_user = "soporte";
   $db_pass = "r3sult4d0";
   $db = "inscripcion";
   $coneccion = mysqli_connect($db_host, $db_user, $db_pass,$db);
   //   $ruta = '';
   $ruta = '/var/www/html/sedes/cron_mail/';
   require $ruta.'PHPMailer-master/PHPMailerAutoload.php';
   include_once ($ruta.'sendmail.php');
   include($ruta.'mail_noarg.php'); // deja el contenido del cuerpo del mail en la variable $contenido
   
   //----------------------------------------------------------------------------------
   $myfile = fopen($ruta."logfile.txt", "a");
   //----------------------------------------------------------------------------------

   $debug = true;
   $httpdirs = "https://www.cbc.uba.ar";
   $tema = "PREINSCRIPCION 2021 RESULTADO";
   $from = "noresponder@cbc.uba.ar";

   $txt = "==========================================================================================="."\r\n";
   fwrite($myfile, $txt);	
   $txt = "INICIO ENVIO - EXTRA212 TRAMITES ERRONEOS: ".date('d/m/Y H:i:s')."\r\n";
   fwrite($myfile, $txt);
   $sql = "SELECT * FROM extra121 WHERE verificado=2 and mail_enviado='N'";
   $result = mysqli_query($coneccion, $sql); 
   if (mysqli_errno($coneccion)==0) {
	   while ($myrow =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	     $id = $myrow['tramite'];
		 $to = $myrow['email'];
         $mensaje = $contenido;
		 $ahora = date('d/m/Y H:i:s');
		 $txt =  $id." ".$to." ".$ahora."\r\n"; 
		 $nombre_destinatario = $myrow['apellido'].", ".$myrow['nombre'];
         $mensaje = str_replace("{nombre_alumno}", $nombre_destinatario, $mensaje);
		 if (mandar_mail($to, $from, $tema, $mensaje, $nombre_destinatario)) {
		     // actualizar tad1 con mail enviado 	
			 $txt.= " MAIL ENVIADO SATISFACTORIAMENTE"."\r\n";
			 $update = "update extra121 set mail_enviado='S' where tramite=".$id;
		 }else{
		     // actualizar tad1 con mail no se pudo enviar
			 $txt.= " ERROR EN ENVIO DE MAIL"."\r\n";
			 $update = "update extra121 set mail_enviado='E' where tramite=".$id;		 
		 }

		 $resultado = mysqli_query($coneccion, $update); 
		 if (mysqli_errno($coneccion)!=0) {
            $cod = mysqli_errno($coneccion);
			$txt.= " "."Error actualizar tabla extra121 update resultado envio mail: ".$cod."\r\n";
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
