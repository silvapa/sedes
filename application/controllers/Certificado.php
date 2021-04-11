<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Certificado extends CI_Controller {

    function __construct() {
      parent::__construct();

      if ( ! ($this->session->userdata('logueado')))
          { 
              redirect('usuarios/iniciar_sesion');
          }
      else 
          {
        $t_listado = 0;
        $this->load->library('form_validation');
        $this->load->model('Lectivo_model'); 
        $this->load->model('Usuario_model');
        $this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
        $this->puede_descargar = in_array('4D',$this->permisos);
        require_once 'application/libraries/print2/fpdf.php';
      }   
    }
 
public function index() {
	echo "<h1>".APP_TITLE."</h1>";
  die();
}


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
	  $pdf->Cell(190,8,'LISTADO DE ALUMNOS',0,0,'C');
 
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
	//$pdf->Text(30,285,'Listado sujeto a verificacion regularidad alumno segun resoluciones CS(128/88)');
	$pdf->Text(30,285,'Ciclo Básico Común - UBA');
  }
 
  function getLetras($numero){
     $letras = $numero;
     switch ($numero){
        case '0':
          $letras = "CERO";
        break;
        case '1':
          $letras = "UNO";
        break;
        case '2':
          $letras = "DOS";
        break;
        case '3':
          $letras = "TRES";
        break;
        case '4':
          $letras = "CUATRO";
        break;
        case '5':
          $letras = "CINCO";
        break;
        case '6':
          $letras = "SEIS";
        break;
        case '7':
          $letras = "SIETE";
        break;
        case '8':
          $letras = "OCHO";
        break;
        case '9':
          $letras = "NUEVE";
        break;
        case '10':
          $letras = "DIEZ";
        break;
        case 'AP':
          $letras = "APROBADO";
        break;
        case 'A':
          $letras = "AUSENTE";
        break;
        case 'NR':
          $letras = "NR";
        break;
        case 'Reg.':
          $letras = "Reg.";
        break;
     }
     return $letras;
  }

public function certificado2pdf() {

  if (!isset($_POST["apenom"]) || 
  !isset($_POST["dni"]) || 
  !isset($_POST["ocultar_ausentes"]) || 
  !isset($_POST["d_materia"]) || 
  !isset($_POST["comicat"]) || 
  !isset($_POST["tipo"]) || 
  !isset($_POST["nota"]) ||  
  !isset($_POST["fecha"]) || 
  !isset($_POST["autoridad_elegida"]) ) {
    return;
  }

  $apenom = utf8_decode(trim($_POST["apenom"]));
  $dni = $_POST["dni"];

  $sinausentes = trim($_POST["ocultar_ausentes"]);
  $aux_materias = $_POST["d_materia"];
  $aux_comicats = $_POST["comicat"];
  $aux_tipos = $_POST["tipo"];
  $aux_notas = $_POST["nota"];
  $aux_fechas = $_POST["fecha"];
  $autoridad = $_POST["autoridad_elegida"];
  /*
  if (isset($_POST["d_autoridad"])) {
    $autoridad = $_POST["d_autoridad"];
  }else { 
    $autoridad = $_POST["autoridad_elegida"];
  }
  */
  $destino = 'I';
  
  /*
  $sinausentes = 'N';
  $aux_materias = array("1-Quimica", "2-Ppio.Der.Latinoamericano", "3-Sociedad y Estado", "4-Ppio.Der.Latinoamericano", "5-Sociedad y Estado");
  $aux_comicats = array("50505", "24901", "52440", "24901", "52440");
  $aux_tipos = array("REG", "REG", "RES", "REG", "RES");
  $aux_notas = array("10", "A", "5", "A", "5");
  $aux_fechas = array("2020-07-01", "2019-12-05 00:00", "2018-07-08", "2019-12-05 00:00", "2018-07-08");
  */

  $materias = array();
  $comicats = array();
  $tipos = array();
  $notas = array();
  $fechas = array();

  if ( $sinausentes == 'S') {
    $jj = 0;
    for($x=0; $x<count( $aux_materias); $x++){
       if (trim($aux_notas[$x])!='A'){
        $materias[$jj] = $aux_materias[$x];
        $comicats[$jj] = $aux_comicats[$x];
        $tipos[$jj] = $aux_tipos[$x];
        $notas[$jj] = $aux_notas[$x];
        $fechas[$jj] = $aux_fechas[$x];      
        $jj++;
       }
    }
  }else{
    $materias = $aux_materias;
    $comicats = $aux_comicats;
    $tipos = $aux_tipos;
    $notas = $aux_notas;
    $fechas = $aux_fechas;
  }

  $len_materias = count($materias);
  $cantlineas = 22; 
  $sancion = false;
  $promedio = 0;
  $cant_notas = 0;
  $pag = 0;
  $paginas = intval((count($materias) - 1) / $cantlineas ) + 1;
 
  // INICIO PDF ------------------------------------------------------------------------------------
  $pdf = new FPDF('P','mm','A4');
	$pdf->SetMargins(10,10,10);
	$pdf->SetAutoPageBreak(false);

//---------------------------------------------------------------------------------------------------
// New Page
   $index = 0;
  for ($h=0; $h<$paginas; $h++) {  
   $pag++;  
   $pdf->AddPage();
   $pdf->Cell(190,280,'',1,1,'C');
   $pdf->SetFont('Arial','B',16);
   // titulo y logo
   $pdf->Image(base_url().'application/assets/img/logo_uba.jpg',130,11,0);
   $pdf->SetFont('Arial','B',16);
   $pdf->Text(11,25,'INFORME DE ACTIVIDAD '.utf8_decode("ACADÉMICA"));
   //------------------------------------------------------------------------------------------------
   // Header
   $pdf->SetFont('Arial','',10);
   $pdf->Text(20,37,'Alumno/a ');
   
   $nombre = $apenom;
   $pdf->SetFont('Arial','B',14);
   $pdf->Text(37,37,$nombre);  
   $pdf->SetFont('Arial','',10);
   $pdf->Text(11,43,'Nro '.utf8_decode('Inscripción'));
   $pdf->SetFont('Arial','B',14);
   $pdf->Text(37,43,$dni);  
   //------------------------------------------------------------------------------------------------
   // Texto header - linea separatoria con body
   $pdf->SetFont('Arial','',14);
   $pdf->Text(14,54,'Certifico que en la '.utf8_decode('Secretaría').' de Alumnos se encuentran registradas las siguientes');
   $pdf->Text(11,59,'calificaciones correspondientes a '.$nombre);
   $pdf->Text(11,64,'Nro de '.utf8_decode('Inscripción').' '.$dni.'.');
   $pdf->SetLineWidth(0.2);
   $pdf->Line(10, 68, 200, 68);
   $pdf->SetFont('Arial','B',12);
   $pdf->Text(11, 73,'      Materia                                                                       '.utf8_decode('Calificación').'   Acta/'.utf8_decode('Cát').'. Tipo   Fecha');
   $pdf->Line(10, 75, 200, 75);
   $fila = 80;
   $pdf->SetFont('Courier','',10);
   //------------------------------------------------------------------------------------------------
   // Body
   $pdf->SetLineWidth(0.1);
   
   for($j = 0; $j<$cantlineas; $j++){ 
  
     if ($index<$len_materias){ 
        
        if (( $sinausentes == 'S') && (trim($notas[$index])=='A')) {
           //$pdf->Text(11, $fila, '   ');  
        }else{
           if (trim($notas[$index])!='A' && trim($notas[$index])!='AP' && trim($notas[$index])!='' && trim($notas[$index])!='Reg.' && trim($notas[$index])!='NR') {
               $cant_notas++;
               $promedio += intval(trim($notas[$index]));
               $nota = str_pad(trim($notas[$index]),2,' ',STR_PAD_LEFT)."/".str_pad($this->getLetras(trim($notas[$index])),7,' ');
           }else{
               if (trim($notas[$index])=='Reg.') {
                 $nota = '   Reg.   ';
               }else{ 
                  if (trim($notas[$index])=='NR') {
                    $nota = '    NR    ';
                  }else{
                    $nota = str_pad($this->getLetras(trim($notas[$index])),10,' ');
                  }   
               }
           }
           //$renglon = "12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789"; 
           //$renglon = "12-12345678901234567890123456789012345678901234567 1234567890  123456789  123  dd/mm/aaaa";
           $mate = str_pad(utf8_decode(trim($materias[$index])),50,' ');
           $comi = str_pad(trim($comicats[$index]), 9,' ',STR_PAD_LEFT);
           $res = $tipos[$index];
           $fec = substr($fechas[$index],8,2)."/".substr($fechas[$index],5,2)."/".substr($fechas[$index],0,4);
           $renglon = $mate." ".$nota."  ".$comi."  ".$res."  ".$fec;
           $pdf->Text(11, $fila, $renglon);
           $fila += 1;
           $pdf->Line(10, $fila, 200, $fila);
           $fila +=4;
           $index++;
        }
     }else{
        $pdf->Text(11, $fila, '   ');  
        //$fila += 1;
        //$pdf->Line(11, $fila, 199, $fila);
        //$fila +=4;
        $fila +=5;
     }
   } // loop for renglon materia
   // Promedio 
   if ($pag==$paginas){
    if ($cant_notas>0) {
      $promedio_notas = round(($promedio/$cant_notas),2);
    }else{
      $promedio_notas = '-.-';
    }
    $fila = 190;
    $pdf->SetFont('Arial','B',10);   
    $pdf->Text(80,$fila,'Promedio: ' . $promedio_notas);
    $fila +=4;
   }else{
    $fila = 190;      
   }
   //------------------------------------------------------------------------------------------------
   // Box ponderacion calificaciones
   $pdf->SetXY(12,$fila);
   $pdf->SetLineWidth(0.4);
   $pdf->Cell(186,19,'',1,1,'C');
   $fila += 4;
   $pdf->SetFont('Arial','I',10);
   $pdf->Text(80,$fila,utf8_decode('Régimen').' de Calificaciones');
   $fila += 4;  

   $pdf->SetFont('Arial','B',8); 
   $pdf->Text( 20,$fila,'0/Cero Reprobado');
   $pdf->Text( 55,$fila,'3/Tres Insuficiente');
   $pdf->Text( 90,$fila,'6/Seis  Bueno');
   $pdf->Text(125,$fila,'9/Nueve Distinguido');
   $pdf->Text(160,$fila,'Reg./Regularizado'); 
   $fila += 4;  

   $pdf->Text( 20,$fila,'1/Uno Insuficiente');
   $pdf->Text( 55,$fila,'4/Cuatro Aprobado');
   $pdf->Text( 90,$fila,'7/Siete Bueno');
   $pdf->Text(125,$fila,'10/Diez Sobresaliente');
   $pdf->Text(160,$fila,'NR/No Regularizado');

   $fila += 4;
   $pdf->Text( 20,$fila,'2/Dos Insuficiente');
   $pdf->Text( 55,$fila,'5/Cinco Aprobado');
   $pdf->Text( 90,$fila,'8/Ocho  Distinguido');
   $pdf->Text(125,$fila,'');
   $pdf->Text(160,$fila,'');

   //------------------------------------------------------------------------------------------------
   // Este certificado ha sido ...
   $fila += 8;
   $pdf->SetFont('Arial','',10);
   $pdf->Text(12,$fila,'Este certificado ha sido extendido sobre la base de registros '.utf8_decode("informáticos."));
   $fila += 4;
   if ($sancion){
    $pdf->Text(12,$fila,'El alumno registra '.utf8_decode("sanción").' al momento de la '.utf8_decode('expedición').' del presente certificado.');
   }else{
    $pdf->Text(12,$fila,'El alumno no registra sanciones al '.utf8_decode('día').' de la fecha.');
   }
   $fila += 6; 
   if ($autoridad=="A quien corresponda") { 
     $pdf->Text(12,$fila,'A pedido del interesado y a solo efecto de ser presentado ante quien corresponda se extiende el presente certificado');
     $fila += 4; 
     $pdf->Text(12,$fila,'en Buenos Aires, a los '.$this->getDias().' '.utf8_decode('días').' del mes de '.$this->getMes().' de '.$this->getAnio());
   }else{
    $pdf->Text(12,$fila,'A pedido del interesado y a solo efecto de ser presentado ante '.$autoridad);
    $fila += 4; 
    $pdf->Text(12,$fila,'se extiende el presente certificado en Buenos Aires, a los '.$this->getDias().' '.utf8_decode('días').' del mes de '.$this->getMes().' de '.$this->getAnio());
   }
   // -----------------------------------------------------------------------------------------------
   // covid
   $fila += 4; 
   $pdf->SetFont('Arial','B',8);
   $pdf->Text(40,$fila,'- Documento expedido por este medio como '.utf8_decode('excepción').' por la pandemia COVID-19 -');
    // -----------------------------------------------------------------------------------------------
   // Footer
   $pdf->SetFont('Arial','',9);
   $pdf->Text(86,282,utf8_decode('Secretaría').' de Alumnos');
   $pdf->Text(88,286,'Ciclo '.utf8_decode('Básico Común'));

   $pdf->SetFont('Arial','',8);
   $pdf->Text(95,289,utf8_decode('Página').' '.$pag.' de '.$paginas);  
   //------------------------------------------------------------------------------------------------
   //------------------------------------------------------------------------------------------------
  }// loop pagina   
  
  if ($destino == 'D'){
	  $pdf->Output($apenom.'_'.$dni.'.pdf','D');
  }else{
	  $pdf->Output($apenom.'_'.$dni.'.pdf','I');
  }	
}

 function getDias(){
  return date('d');
 }

 function getMes(){
   $m = date('m');
   $mes = $m;
   switch ($m) {
       case 1:
        $mes = 'Enero';
       break;

       case 2:
        $mes = 'Febrero';
       break;
       
       case 3:
        $mes = 'Marzo';
       break;
       
       case 4:
        $mes = 'Abril';
       break;
       
       case 5:
        $mes = 'Mayo';
       break;
       
       case 6:
        $mes = 'Junio';
       break;
       
       case 7:
        $mes = 'Julio';
       break;
       
       case 8:
        $mes = 'Agosto';
       break;
       
       case 9:
        $mes = 'Septiembre';
       break;
       
       case 10:
        $mes = 'Octubre';
       break;
       
       case 11:
        $mes = 'Noviembre';
       break;
       
       case 12:
        $mes = 'Diciembre';
       break;
   }
   return $mes;
 }

 function getAnio(){
     return date('Y');
 }
}