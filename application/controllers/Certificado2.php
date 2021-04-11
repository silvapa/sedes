<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Certificado extends CI_Controller {

    function __construct()
    {
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
		require_once 'application/libraries/print/fpdf.php';
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
 

public function certificado2pdf() {

/*  print_r($_POST["apenom"]);
    print_r($_POST["dni"]);
    print_r($_POST["ocultar_ausentes"]);
    print_r($_POST["d_materia"]);
    print_r($_POST["comicat"]);
    print_r($_POST["tipo"]);
    print_r($_POST["nota"]);
    print_r($_POST["fecha"]);*/

	//$comision = $_GET["comision"];
	//$tipo_listado = $_GET["tipo_listado"];
    //$destino = $_GET["destino"];
    $comision = 22107;
	$tipo_listado = 0;
    $destino = 'I';
	$cuat = $this->session->userdata('cuat_actual');
	//$header = $this->Lectivo_model->Get_cabecera_comision($cuat,$comision);
    //$alumnos = $this->Lectivo_model->Get_Alumnos_comision($cuat,$comision); 
    
    $sancion = false;
    $promedio = 0;
    $pag = 1;
    $paginas = 1;
	$pdf = new FPDF('P','mm','A4');
	$pdf->SetMargins(10,10,10);
	$pdf->SetAutoPageBreak(false);


//---------------------------------------------------------------------------------------------------
   // New Page
   $pdf->AddPage();
   $pdf->Cell(190,280,'',1,1,'C');
   $pdf->SetFont('Arial','B',16);
   // titulo y logo
   $pdf->Image(base_url().'application/assets/img/logo_uba.jpg',130,11,0);
   $pdf->SetFont('Arial','B',16);
   $pdf->Text(11,25,'INFORME DE ACTIVIDAD ACADEMICA');
   //------------------------------------------------------------------------------------------------
   // Header
   $pdf->SetFont('Arial','',10);
   $pdf->Text(20,37,'Alumno/a ');
   $dni = 22600211;
   $nombre = "Baleani, Mariana Beatriz";
   $pdf->SetFont('Arial','B',14);
   $pdf->Text(37,37,$nombre);  
   $pdf->SetFont('Arial','',10);
   $pdf->Text(11,43,'Nro Inscripcion ');
   $pdf->SetFont('Arial','B',14);
   $pdf->Text(37,43,$dni);  
   //------------------------------------------------------------------------------------------------
   // Texto header - linea separatoria con body
   $pdf->SetFont('Arial','',14);
   $pdf->Text(14,54,'Certifico que en la Secretaria de Alumnos se encuentran registradas las siguientes');
   $pdf->Text(11,59,'calificaciones correspondientes a '.$nombre);
   $pdf->Text(11,64,'Nro de inscripcion '.$dni.'.-');
   $pdf->SetLineWidth(0.8);
   $pdf->Line(11, 68, 199, 68);
   $pdf->SetFont('Arial','B',12);
   $pdf->Text(11, 73,'Materia                              Calificacion         Acta/Cat.       Tipo        Fecha');
   $pdf->Line(11, 75, 199, 75);
   //------------------------------------------------------------------------------------------------
   // Body



   // Promedio 
   if ($pag==$paginas){
    $fila = 220;
    $pdf->SetFont('Arial','B',10);   
    $pdf->Text(80,$fila,'Promedio: '.$promedio);
    $fila +=4;
   }else{
    $fila = 220;      
   }
   //------------------------------------------------------------------------------------------------
   // Box ponderacion calificaciones
   $pdf->SetXY(12,$fila);
   $pdf->SetLineWidth(0.4);
   $pdf->Cell(186,19,'',1,1,'C');
   $fila += 4;
   $pdf->SetFont('Arial','I',10);
   $pdf->Text(80,$fila,'Regimen de Calificaciones');
   $fila += 4;  
   $pdf->SetFont('Arial','B',8); 
   $pdf->Text( 20,$fila,'0/Cero Burro');
   $pdf->Text( 55,$fila,'1/Uno  Que mal');
   $pdf->Text( 90,$fila,'2/Dos  Insuficiente');
   $pdf->Text(125,$fila,'3/Tres Insuficiente');
   $pdf->Text(160,$fila,'4/Cuatro Zafaste');
   $fila += 4;  
   $pdf->Text( 20,$fila,'5/Cinco Aprobado');
   $pdf->Text( 55,$fila,'6/Seis  Aprobado');
   $pdf->Text( 90,$fila,'7/Siete Bueno');
   $pdf->Text(125,$fila,'8/Ocho  Bien!!!');
   $pdf->Text(160,$fila,'9/Nueve Idolo');
   $fila += 4;
   $pdf->Text(160,$fila,'10/Diez Master'); 
   //------------------------------------------------------------------------------------------------
   // Este certificado ha sido ...
   $fila += 7;
   $pdf->SetFont('Arial','',10);
   $pdf->Text(12,$fila,'Este certificado ha sido extendido sobre la base de registros informaticos.');
   $fila += 4;
   if ($sancion){
    $pdf->Text(12,$fila,'El alumno registra sancion al momento de la expedicion del presente certificado.');
   }else{
    $pdf->Text(12,$fila,'El alumno no registra sancion al momento de la expedicion del presente certificado.');
   }
   $fila += 6; 
   $pdf->Text(12,$fila,'A pedido del interesado y a solo efecto de ser presentado ante quien corresponda se extiende el presente certificado');
   $fila += 4; 
   $pdf->Text(12,$fila,'en Buenos Aires, a los '.$this->getDias().' dias del mes de '.$this->getMes().' de '.$this->getAnio());
   // -----------------------------------------------------------------------------------------------
   // covid
   $fila += 4; 
   $pdf->SetFont('Arial','B',8);
   $pdf->Text(40,$fila,'- Documento expedido por este medio como excepcion de la pandemia COVID-19 -');
    // -----------------------------------------------------------------------------------------------
   // Footer
   $pdf->SetFont('Arial','',12);
   $pdf->Text(60,285,'Secretaria de Alumnos - Ciclo Basico Comun');
   $pdf->SetFont('Arial','',8);
   $pdf->Text(95,289,'Pagina '.$pag.' de '.$paginas);  
   //------------------------------------------------------------------------------------------------
   //------------------------------------------------------------------------------------------------
   if ($destino == 'D'){
	  $pdf->Output($comision.'_c'.$cuat.'.pdf','D');
   }else{
	  $pdf->Output('I');
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