<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class sendmail{
   public function __construct() {
 	require_once 'PHPMailer/PHPMailerAutoload.php';
// 	require_once 'PHPMailer-master/src/PHPMailer.php';
  	date_default_timezone_set('America/Argentina/Buenos_Aires');
   }

 public function mandar_mail($to, $from, $reply_to, $tema, $mensaje, $nombre_destinatario){
 $mail = new PHPMailer;
 $mail->isSMTP();
 $mail->SMTPDebug = 3;
 $mail->Debugoutput = 'html';
 
 $mail->SMTPSecure =  "tls";  
 $mail->SMTPAuth = true;
 $mail->Username = $from;
 $mail->Password = CLAVE_ADMIN; 
 $mail->setFrom($from,APP_TITLE); 
 
 $mail->addReplyTo($reply_to,$reply_to);
 $mail->addAddress($to,$nombre_destinatario);
 $mail->Subject = $tema; 
 $mail->MsgHTML($mensaje);  
 $mail->AltBody = $mensaje; 
 $mail->CharSet = 'UTF-8';
 $mail->IsHTML(true); 

 $todo_ok = true;

 $mail->Host = 'smtp.gmail.com';  
 $mail->Port = 587; // 465; 
 if (!$mail->send()) {
	$todo_ok = false;
	redirect($mail->ErrorInfo);
	/*"Mailer Error: " . $mail->ErrorInfo;*/
 }  
 return ($todo_ok);
}
}