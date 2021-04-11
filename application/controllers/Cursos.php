<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cursos extends CI_Controller {

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
		require_once 'application/libraries/print2/fpdf.php';
		//require_once 'application/libraries/print/fpdf.php';
		}   
    }
 
public function index() {
	echo "<h1>".APP_TITLE."</h1>";
  die();
}


function listaMaterias($materia){
	$lista = '<select name="materias" id="materias"class="select_styled" size='.'"'.'1'.'"'.'>';
	if ($materia == 0) {
		$lista .= '<option value="0" selected>Todas</option>';
	}
	else {
		$lista .= '<option value="0">Todas</option>';
	}
	$sede = $this->session->userdata('sede');
	//$sede = 10;
	$cuat = $this->session->userdata('cuat_actual');
	$cuat = 1;
	$result = $this->Lectivo_model->Get_Materias_Sede($sede,$cuat);
	if ($result)  {
		foreach ($result as $item=>$fields) { 
        $lista .=   '<option value='.'"'.$fields['codigo'].'"'.(($materia == $fields['codigo']) ? ' selected ': '').'>'.substr('  '.trim($fields['codigo']),-2).' - '. $fields['descripcion'].'</option>';          
      }
    }
   $lista .=  '</select>';
   return $lista;               
 }

public function obtener_where_grilla($materia, $cuat) {  
	$where = '';
	if ($this->session->userdata('sede') != 3) {
		$where = ' c.sede = '.$this->session->userdata('sede');
	}
	if ($materia != '0') {
		if ($where != '') {$where .= ' and ';}
		$where .= ' materia = '.$materia;
	}	
	if ($cuat != '') {
		if ($where != '') {$where .= ' and ';}
		//$where .= " ((cuat = ".$cuat." and anual = 0) or (anual = 1))";
		//$where .= " (cuat = ".$cuat.")";
	}	

	return $where;
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
	$pdf->Text(30,285,'Ciclo Básico Común - UBA');
  }

public function curso2pdf() {
	if (!isset($_GET['comision']) || !isset( $_GET['tipo_listado']) || !isset($_GET['destino'])) {
       return;
	}

	$comision = $_GET['comision'];
	$tipo_listado = $_GET['tipo_listado'];
	$destino = $_GET['destino'];

	$cuat = 1;//$this->session->userdata('cuat_actual');
	$anio = date("Y");
	$headers = $this->Lectivo_model->Get_cabecera_comision($cuat,$comision);
	$header = $headers[0];
	$alumnos = $this->Lectivo_model->Get_Alumnos_comision($cuat,$comision); 

	// ----------------------------------------------------------------------------------------------
	$cant_alumnos = count($alumnos);
	$cantlineas = 35;
	$pag = 0;
	$paginas = intval(($cant_alumnos - 1) / $cantlineas ) + 1;
	$index = 0;  // indice para array alumnos

	// INICIO PDF ------------------------------------------------------------------------------------
    $pdf = new FPDF("P","mm","A4");
    $pdf->SetMargins(10,10,10);
	$pdf->SetAutoPageBreak(false);

	for ($hh=0; $hh<$paginas; $hh++) {  
	  $pag++;  
	  $pdf->AddPage();
	  $pdf->Cell(190,280,'',1,1,'C');
	  $pdf->SetFont('Arial','B',16);
	  // titulo y logo
	  $pdf->Image(base_url().'application/assets/img/logo_uba.jpg',130,11,0);
	  $pdf->SetFont('Arial','B',18);
	  $pdf->Text(51,22,'Listado de Alumnos');	
	  $pdf->SetFont('Arial','B',12);
	  if ($cuat==0) {
		 $pdf->Text(64,30, ' Curso de Verano '.$anio);	
	  }else{
		  if ($cuat==1){
			$pdf->Text(64,30, '1er. Cuatrimestre de '.$anio);
		  }else{
			$pdf->Text(64,30, '2do. Cuatrimestre de '.$anio);
		  }
	  }
	  $pdf->SetLineWidth(0.2);
	  $pdf->Line(10, 34, 200, 34);
	  // header --------------------------------------------------------------------------------------
	  // Sede - Pagina
	  $pdf->Text( 11, 40, 'Sede: '.$header['sede'].' - '.$header['d_sede']);
	  $pdf->Text(177, 40, utf8_decode('Página').': '.str_pad($pag, 3,' ',STR_PAD_LEFT));
	  // Materia - Horario - Aula - Comision
	  $pdf->Text( 11, 46, 'Materia: '.$header['materia'].' - '.$header['d_materia']);
	  $pdf->Text( 11, 52, 'Aula: '.str_pad($header['aula'], 3,' ',STR_PAD_LEFT));
	  $pdf->Text( 30, 52, 'Horario: '.str_pad($header['horario'], 3,' ',STR_PAD_LEFT).' - '.$header['d_horario']);
	  $pdf->Text( 164, 52, utf8_decode('Comisión').': '.str_pad($comision, 6,' ',STR_PAD_LEFT));
	  $pdf->Line(10, 56, 200, 56);
	  $pdf->Text( 14, 62, 'DNI          APELLIDO Y NOMBRE');
	  $pdf->Line(10, 65, 200, 65);
	  $fila = 72;
	  $pdf->SetFont('Arial','',12);
	  // body PDF ------------------------------------------------------------------------------------
      for($jj=0; $jj<$cantlineas; $jj++){
		if ($index < $cant_alumnos){
			$unAlumno = $alumnos[$index];
			$pdf->Text( 11, $fila, $unAlumno['dni'].'    '.utf8_decode(trim($unAlumno['apellido'])).', '.utf8_decode(trim($unAlumno['nombre'])));
			$index++;
		 }else{
			$pdf->Text( 11, $fila, '');
		}
		$fila += 6;
	  }

	  // footer --------------------------------------------------------------------------------------
	  $pdf->Line(10, $fila, 200, $fila);
	  $fila += 5; 
	  $pdf->SetFont('Arial','b',10);
	  $pdf->Text(30, $fila, 'LISTADO SUJETO A CUMPLIMIENTO DE RESOLUCIONES (C.S.) 3421/88, 469/98 Y 931/98'); 
	// ----------------------------------------------------------------------------------------------
	} // loop paginas
	
	$fileName = 'Comision_'.$comision.'_Cuat_'.$cuat.'.pdf';
	if ($destino == 'D'){
		$pdf->Output($fileName,'D');
	}else{
		$pdf->Output($fileName,'I');
	}	
  }
 
public function curso2xls() {
	/*
	require_once 'application/libraries/print/print2pdf.php';
	$comision = $_GET["comision"];
	$tipo_listado = $_GET["tipo_listado"];
	$destino = $_GET["destino"];
	$cuat = $this->session->userdata('cuat_actual');
	$header = $this->Lectivo_model->Get_cabecera_comision($cuat,$comision);
	$alumnos = $this->Lectivo_model->Get_Alumnos_comision($cuat,$comision);  
	*/
}


public function consultar() {

	$error = '';
	$this->inicializar_consulta($error);
}


public function inicializar_consulta($error) {
	$arreglo = array();
	$data['lista_materias'] = $this->listaMaterias(0);
	$data['error'] = $error;
	$data['esgrilla'] = 'S';			
	$data['activos'] = $arreglo;
	$data['clave'] = 0;
	$data2['titulo_menu'] = 'Consulta de Cursos';
	$data2['permisos'] = $this->permisos;
	$data['puede_descargar'] = $this->puede_descargar;
	$this->load->view('menu.php',$data2);
	$this->load->view('cursos_view.php',$data);
//	$this->load->view('footer.php');
}

public function mostrar_grilla($materia,$cuat) {  
	$cuantos = 0; //30;
	$cuat = 1; //$this->session->userdata('cuat_actual');
	$where = $this->obtener_where_grilla($materia,$cuat);
	$activos = $this->Lectivo_model->Get_Cursos($where,$cuantos);  
	$data['error'] = '';
	$data['esgrilla'] = 'S';			
	$data['activos'] = $activos;
	$data2['titulo_menu'] = 'Consulta de Cursos';
	$data2['permisos'] = $this->permisos;
	$data['puede_descargar'] = $this->puede_descargar;
	$this->load->view('menu.php',$data2);
	$this->load->view('cursos_view', $data);
}

/*public function novedades() { 
	$anio = $_GET["anio"]; 
	$clave = $_GET["clave"]; 
	$novedades = $this->Lectivo_model->Novedades_por_clave($anio,$clave);  
	$data['error'] = '';
	$data['esgrilla'] = 'N';			
	$data['novedades'] = $novedades;
	$data2['titulo_menu'] = 'Consulta de Lectivo';
	$this->load->view('menu.php',$data2);
	$this->load->view('lectivo_view', $data);
}*/


 public function cursos_post() {  
	
	if ($this->input->post())  {
		$materia = $this->input->post('materias');
		$focused = $this->input->post('focused');
		$descarga =  $this->input->post('descargar');	
	    if ($descarga>-1){
		  $cuat = '1';
	      $where = $this->obtener_where_grilla($materia,$cuat);
          $activos = $this->Lectivo_model->Get_Cursos($where,$cuat,0);  	  
          if (count($activos)>0) {
	         $filename = $this->generar_reporte($activos);
	         $this->descargar_reporte($filename);
	      }
		}

		$cuantos = 0; //30;
		//$cuat = $this->session->userdata('cuat_actual');
		$cuat = '1';
		$where = $this->obtener_where_grilla($materia,$cuat);

		$activos = $this->Lectivo_model->Get_Cursos($where,$cuat,$cuantos);  
		$data['error'] = '';
		if (count($activos) == 0) { 
			$data['error'] = 'No hay cursos que cumplan con el criterio ingresado';
		}
		$data['esgrilla'] = 'S';			
		$data['activos'] = $activos;
		$data['lista_materias'] = $this->listaMaterias($materia);
		$data2['permisos'] = $this->permisos;
		$data['puede_descargar'] = false; //true; //$this->puede_descargar;
	
		$data2['titulo_menu'] = 'Consulta de Cursos';
		$this->load->view('menu.php',$data2);
		$this->load->view('cursos_view', $data);

	}		
 }

//------------------------------------------------------------------------------------
	public function generar_reporte($registros) {  
		$filename = '';
		try {
			$filename = "reportes/cursosgrilla_".trim($this->session->userdata('usuario_id'))."_tmp.csv";
			if (file_exists($filename)) {
				unlink($filename);
			}
			$file = fopen($filename,"w");
			$cabecera = "Comision;Cuat.;Sede;Materia;;Horario;;Aula;Catedra"."\n";
			fwrite($file, $cabecera);
			$arrlen = count($registros);
			for ($i=0; $i<$arrlen; $i++){ 
				$row = $registros[$i];
				$line = $row['comision'].";";
				$line .= $row['cuat'].";";
				$line .= $row['sede'].";";
				$line .= $row['materia'].";";
				$line .= $row['d_materia'].";";
				$line .= $row['horario'].";";
				$line .= $row['d_horario'].";";
				$line .= $row['aula'].";";
				$line .= mb_convert_encoding($row['catedra'],'utf-16','utf-8').";";
				$line .= "\n";
			    fwrite($file, $line);
			}
			fclose($file);
		}catch(Exception $e) {
		  echo 'Error: '.$e->getMessage();
		}
		return $filename;
	}

	public function descargar_reporte($archivo) {
		$fichero_local = $archivo;
		//nombre del fichero que se descargará el usuario
		$nombre_fichero = "cursosgrilla_".trim($this->session->userdata('usuario_id')).".csv"; 
		//compruebo, por si acaso, que el fichero exista en el sistema
		if( file_exists($fichero_local ) && is_file($fichero_local) ) { 
			header('Cache-control: private');
			header('Content-Type: application/octet-stream; charset=iso-8859-1'); 
			header('Content-Length: '.filesize($fichero_local));
			header('Content-Disposition: filename='.$nombre_fichero);
			// flush content
			flush();
			 //abrimos el fichero
			 $file = fopen($fichero_local , "rb");
			 //imprimimos el contenido del fichero al navegador
			 print fread ($file, filesize($fichero_local )); 
			 //cerramos el fichero abierto
			 fclose($file);
		} 
	}
	
	public function getCursosXLS(){
	  $materia = $_GET['materia'];
	  $cuat = '1';
	  $where = $this->obtener_where_grilla($materia,$cuat);
      $activos = $this->Lectivo_model->Get_Cursos($where,$cuat,0);  	  
      if (count($activos)>0) {
	    $filename = $this->generar_reporte($activos);
	    $this->descargar_reporte($filename);
	  }
    }

}