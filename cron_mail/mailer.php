<?php 
    include_once ('sendmail.php');
	include('mail_R1.html');
    $debug = true;
 // Trato de mandar el mail para el alumno:
    $httpdirs = "https://www.cbc.uba.ar";
	
	
    $dni = 27226823;
    $email = 'pablo.silva79@gmail.com';

    $contenido = "--- CAMPUS VIRTUAL ---\r\n\r\n";
    $contenido .= "Alumno DNI: " . $dni. "\r\n\r\n";
    $contenido .= "Accede a ". $httpdirs . " ingresando como invitado."."\r\n\r\n";
    
    $to = $email;
    $subject = "CBC-CAMPUS VIRTUAL";
    $msg = $contenido;

    if (mandar_mail($email, 'noresponder@cbc.uba.ar', $subject, $contenido, "DNI ".$dni)) {
    echo $dni."<br>";
    } else {
      echo 'todo mal';
    }

?> 
