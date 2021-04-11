<?php 
   $db_host = "localhost";
   $db_user = "soporte";
   $db_pass = "r3sult4d0";
   $db = "cbc_sedes";
   $coneccion = mysqli_connect($db_host, $db_user, $db_pass,$db);
  
   require '/var/www/html/sedes/mails/PHPMailer-master/PHPMailerAutoload.php';
   include_once ('/var/www/html/sedes/mails/sendmail.php');

   $t_mail = "MD01";
   $generar_log = false;
   include "mail_MD01.php"; // cuerpo del mail a enviar

	//---------------------------------------------------------------------------------
   $myfile = fopen("logfile".$t_mail.".txt", "a");
   //----------------------------------------------------------------------------------
   $debug = true;
   $httpdirs = "https://www.cbc.uba.ar";
   $tema = "Campus Virtual CBC";  // titulo del mail
   $from = "noresponder@cbc.uba.ar";  //cuenta de mail origen

   if ($generar_log) {
    $txt = "==========================================================================================="."\r\n";
    fwrite($myfile, $txt);	
    $txt = "INICIO ENVIO: ".date('d/m/Y H:i:s')."\r\n";
    fwrite($myfile, $txt);
   }
   $sql = "select * from mailer where t_mail = '".$t_mail."' and estado = 'P'"; // query para levantar desde tad1
   $result = mysqli_query($coneccion, $sql); 
   if (mysqli_errno($coneccion)==0) {
    
    while ($myrow =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
     $mensaje = $contenido;
     $id = $myrow['id'];
		 $to = $myrow['email'];
		 $ahora = date('d/m/Y H:i:s');
		 $txt =  $id." ".$to." ".$ahora."\r\n"; 
		 $campo1 = $myrow['campo1'];
		 $campo2 = $myrow['campo2'];
		 $campo3 = $myrow['campo3'];
		 $campo4 = $myrow['campo4'];
     $nombre_destinatario = $campo2;
       if (($campo1 <> null) && ($campo1 <> '')) {
         $mensaje = str_replace("{campo1}", $campo1, $mensaje);
       }
       if (($campo2 <> null) && ($campo2 <> '')) {
         $mensaje = str_replace("{campo2}", $campo2, $mensaje);
       }
       if (($campo3 <> null) && ($campo3 <> '')) {
         $mensaje = str_replace("{campo3}", $campo3, $mensaje);
       }
       if (($campo4 <> null) && ($campo4 <> '')) {
         $mensaje = str_replace("{campo4}", $campo4, $mensaje);
       }
      if (mandar_mail($to, $from, $tema, $mensaje, $nombre_destinatario)) {       
		     // actualizar tad1 con mail enviado AGREGAR CAMPOS A ACTUALIZAR
			 $txt.= " MAIL ENVIADO SATISFACTORIAMENTE"."\r\n";
			 $update = "update mailer set estado='S', mensaje='".$ahora."' where id='".$id."'";
		 }else{
		     // actualizar tad1 con mail no se pudo enviar AGREGAR CAMPOS A ACTUALIZAR
			 $txt.= " ERROR EN ENVIO DE MAIL"."\r\n";
			 $update = "update mailer set estado='N', mensaje="."'Error envio mail: ".$ahora."' where id='".$id."'";		 
		 }
		 $resultado = mysqli_query($coneccion, $update); 
		 if (mysqli_errno($coneccion)!=0) {
            $cod = mysqli_errno($coneccion);
		      	$txt.= " "."Error actualizar tabla mailer update resultado envio mail: ".$cod."\r\n";
		 }
     if ($generar_log) {
      fwrite($myfile, $txt);	
		  $txt ="............................................................................................................."."\r\n";
		  fwrite($myfile, $txt);	
     }
		 sleep(3);	 
	   }
  }else{
    if ($generar_log) {
     $txt = mysqli_errno($coneccion)."\r\n";;
	  fwrite($myfile, $txt);	
    }
  }// error en select
  if ($generar_log) {
    $txt = "FIN ENVIO: ".date('d/m/Y H:i:s')."\r\n";
    fclose($myfile);
  }
   mysqli_close($coneccion);
?> 