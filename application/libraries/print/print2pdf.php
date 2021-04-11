<?php
 // error_reporting(0); 
 function Imprimir_Header($pdf, $pagina, $header_array, $comision, $tipo_listado){

   if ($tipo_listado==0){  
     $pdf->AddPage('P', 'A4');
     // recuadro pagina
     $pdf->Cell(190,35,'',1,1,'C');
     $pdf->SetFont('Arial','',14);
     $pdf->Cell(30,8,'D.N.I.',1,0,'C'); 
     $pdf->Cell(160,8,'APELLIDO Y NOMBRE',1,1,'C'); 
     $pdf->Cell(190,234,'',1,0,'C');

     // titulo
     $pdf->SetXY(11,11);
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(190,8,'LISTADO PROVISORIO DE ALUMNOS',0,0,'C');

     // comision - pagina
     $pdf->SetFont('Arial','',14);
     $texto = "Comision: ".$comision;
     $pdf->Text(11,21, $texto);
     $texto = "Pagina: ".$pagina;
     $pdf->Text(172,21, $texto);

     $header = $header_array[0];

     // sede - materia 
     $texto = "Sede: ".$header['sede']."-".$header['d_sede'];
     $pdf->Text(11,28, $texto);

     // sede - materia 
     $texto = "Materia: ".$header['materia']."-".$header['d_materia'];
     $pdf->Text(11,35, $texto);

     // horario - aula
     $texto = "Horario: ".$header['horario']."-".$header['d_horario'];
     $pdf->Text(11,42, $texto);
     $texto = "Aula: ".$header['aula'];
     $pdf->Text(165,42, $texto);

   }else{
    $pdf->AddPage('L', 'A4');
   }

 }

 function Imprimir_Footer($pdf){
   $pdf->Line(10,281,200,281);
   $pdf->Text(30,285,'Listado sujeto a verificacion regularidad alumno segun resoluciones CS(128/88) etc etc');
 }

/*---------------------------------------------------------------------------------------------------
  include('datosprueba.php');

  require('fpdf.php');
  $pagina = 0;
  $renglon = 0;
  $linea = 0;
  $blancos = "              ";
  
  $pdf = new FPDF();
  $pdf->SetMargins(10,10,10);
  $pdf->SetAutoPageBreak(false);

//---------------------------------------------------------------------------------------------------
  if ($tipo_listado==0){
    $maxrenglong = 37;
  }else{
    $maxrenglong = 21;
  }
  $renglon = $maxrenglong;

  $arrlength = count($alumnos);
  for($x = 0; $x < $arrlength; $x++) {
     $unalumno = $alumnos[$x];

     if ($renglon == $maxrenglong){
       if ($pagina>0){
         Imprimir_Footer($pdf);
       } 
       $pagina++;
       Imprimir_Header($pdf, $pagina, $header, $comision, $tipo_listado);
       $pdf->SetFont('Arial','',10);
       $renglon = 0;
       $linea = 59;
     }  
     // print datos dni, apellido, nombre
     $dni = substr($blancos.trim(strval($unalumno['dni'])), -14);

     $pdf->Text(12, $linea, $dni);
     $pdf->Text(42, $linea, trim($unalumno['apellido']).", ".trim($unalumno['nombre']));

     $linea += 6;
     $renglon++;
  }

  if ($renglon<$maxrenglong){
    Imprimir_Footer($pdf);
  }
  
  $pdf->Output();

//--------------------------------------------------------------------------------------------------*/

?>