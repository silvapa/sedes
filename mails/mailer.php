<?php 
    include_once ('sendmail.php');
    $debug = true;
      // Trato de mandar el mail para el alumno:
    $httpdirs = "http://www.cbc.uba.ar";
    $dni = 22200611;
    $email = 'mbaleani@gmail.com';
//      $password = encrypt ($dni, $keyEncrypt);
    $contenido = "--- CAMPUS VIRTUAL ---\r\n\r\n";
    $contenido .= "Alumno DNI: " . $dni. "\r\n\r\n";
    $contenido .= "Accede a ". $httpdirs . " ingresando como invitado."."\r\n\r\n";
    
    $to = $email;
    $subject = "CBC-CAMPUS VIRTUAL";
    $msg = $contenido;

    if (mandar_mail($email, 'noresponder@cbc.uba.ar',/*'inscripciones@cbc.uba.ar',*/ $subject, $contenido, "DNI ".$dni)) {
    echo $dni."<br>";
    } else {
      echo 'todo mal';
    }

?> 