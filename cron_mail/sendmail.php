<?php
 function mandar_mail($to, $from, $tema, $mensaje, $nombre_destinatario){
 //date_default_timezone_set('Etc/UTC');
 date_default_timezone_set('America/Argentina/Buenos_Aires');
 //require 'PHPMailer-master/PHPMailerAutoload.php';
 //Create a new PHPMailer instance
 $mail = new PHPMailer;
 //Tell PHPMailer to use SMTP
 $mail->isSMTP();
 //Enable SMTP debugging
 // 0 = off (for production use)
 // 1 = client messages
 // 2 = client and server messages
 $mail->SMTPDebug = 0;
 //Ask for HTML-friendly debug output
 $mail->Debugoutput = 'html';
 
  //Set the encryption system to use - ssl (deprecated) or tls
 $mail->SMTPSecure =  "tls";   // 'ssl';
 //Whether to use SMTP authentication
 $mail->SMTPAuth = true;
 //Username to use for SMTP authentication - use full email address for gmail
 $mail->Username = $from; 
 //Password to use for SMTP authentication
 $mail->Password = 'r3sult4d0'; 
 //Set who the message is to be sent from
 $mail->setFrom($from,$from); 
 //Set an alternative reply-to address
 $mail->addReplyTo($from,$from);
 //Set who the message is to be sent to
 $mail->addAddress($to,$nombre_destinatario);
 //Set the subject line
 
 $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
 $mail->Subject = $tema; //'CBC Confirma tu email';

 //Read an HTML message body from an external file, convert referenced images to embedded,
 //convert HTML into a basic plain-text alternative body
 //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
 $mail->MsgHTML($mensaje);  
 $mail->AltBody = $mensaje; 
 $mail->IsHTML(true); 
 //Replace the plain text body with one created manually
 //$mail->AltBody = 'Mensaje de prueba desde el biller replica';
 //Attach an image file
 //$mail->addAttachment('PHPMailer-master/examples/images/phpmailer_mini.png');
 //send the message, check for errors

 //Set the hostname of the mail server and SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission

$todo_ok = true;

// GMAIL SMTP MAIL SERVER:	
 $mail->Host = 'smtp-relay.gmail.com';  
 $mail->Port = 587; // 465; 

 //print_r($mail);
 
 if (!$mail->send()) {
/* 	// YAHOO SMTP MAIL SERVER:
 	$mail->Host = 'smtp.mail.yahoo.com';
	$mail->Port = 587;   //465;  // o 587
	if (!$mail->send()) {
		// HOTMAIL SMTP MAIL SERVER
	 	$mail->Host = 'smtp.live.com';
		$mail->Port = 587;  //25;   //465;  // o 25
		if (!$mail->send()) {
			// Ultimo intento por PHP mail
		    $headers = "From: ".$from. "\r\nReply-To: ".$from;
        	if (!mail($to, $tema, $mensaje, $headers)) {	
		  		$res = "Mailer Error: " . $mail->ErrorInfo;
		  	}
	  	}
	}*/
	$todo_ok = false;
	"Mailer Error: " . $mail->ErrorInfo;
 }  
 return ($todo_ok);
}

?>
