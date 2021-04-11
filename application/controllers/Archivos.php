<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Archivos extends CI_Controller {

    function __construct()
    {
        parent::__construct();

     if ( ! ($this->session->userdata('logueado')))
        { 
            redirect('usuarios/iniciar_sesion');
        }
    else 
        {
		$this->load->library('Funcs_lib');
		$this->load->library('Upload');
		$this->load->library('form_validation');
		$this->load->library('Sendmail'); 
		$config = array(
			'allowed_types' => 'txt|zip|rar|doc|mdb|prg',
			'upload_path' 	=> './cargas/sede'.$this->session->userdata('sede'),
			'max_size' 		=> 1500000,
			'remove_spaces' => TRUE,
			);
		$this->upload->initialize($config);
		}   
    }
 
public function index() {
    echo "<h1>".APP_TITLE."</h1>";
  die();
}


  
public function cargas() {
	$error = '';
	$this->iniciar_carga($error);
}

public function iniciar_carga($error) {
//	$sedenombre = $this->session->userdata('nombre');
	$data['error'] = $error;
//	$data2['nombre'] = $sedenombre;
	$data2['titulo_menu'] = 'Cargas';
	$this->load->view('menu.php',$data2);
	$this->load->view('cargas_view.php',$data);
	$this->load->view('footer.php');
}


function cargas_post() {  
	if($this->upload->do_upload("userfile")) {
	//if (true) {
		$data = array('upload_data' => $this->upload->data());
		$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
		$sedenombre = $this->session->userdata('nombre');
		$nom = $this->session->userdata('sede');
        $from = EMAIL_ADMIN;
        $to = EMAIL_ADMIN;
        $subject = 'Archivo Subido de sede '. $sedenombre;
        $message = 'Se subio el archivo ' . $upload_data['file_name'];
		$reply_to = EMAIL_ADMIN;
		$this->sendmail->mandar_mail($to, $from, $reply_to, $subject, $message, $nom);
//		$data2['nombre'] = $sedenombre;
		$data2['titulo_menu'] = 'Cargas';
		$this->load->view('menu.php',$data2);
		$this->load->view('cargas_success', $data);
		$this->load->view('footer.php');
	}
	else{
		$error = $this->upload->display_errors();
		$this->iniciar_carga($error);
	} 
}

  public function descargas() {   
	//leer configuracion sede
//	$archivo = file("sconfig.ini"); 
//	list($sede, $sedenombre) = explode(',',$archivo[0]);
	$sede = $this->session->userdata('sede');
	$sedenombre = $this->session->userdata('nombre');
	//--------------------------------------------------
	$fechaactual = date("d/m/Y");
	//--------------------------------------------------
	$tabla = "";
	//leer sistemas disponibles para descarga
	$archivo = file(APPPATH."/dwfiles.ini"); 
	$lineas = count($archivo); 
	for($i=1; $i < $lineas; $i++) {
	   list($sd, $fdde, $fhta, $sistema, $descripcion, $alink) = explode(',',$archivo[$i]);
	   $fechaok = $this->funcs_lib->fechaOk($fdde, $fhta);
	   //$fechaok = true;
	   if (  (($sd == $sede) || ($sd == 0)) && $fechaok )  {
			$tabla .= "<tr>" ;
			$tabla .="<td class='col-xs-1'>".$fdde."</td>"."<td class='col-xs-8'>".$descripcion."</td>";
		   	if ($sd==0) {
			 	$tabla .="<td class='col-xs-2'><a href="."'../comun/".trim($alink)."'>".$sistema."</a></td>";
		   	}else{
			 	$tabla .="<td class='col-xs-2'><a href="."'../descargas/sede".$sede."/".trim($alink)."'>".$sistema."</a></td>";
		   	}
		   	$tabla .="<td class='col-xs-1'>".$fhta."</td>";
		   	$tabla.="</tr>";
	   }
	}
	$data['tabla'] = $tabla;
	$data['nombre'] = $sedenombre;
	$data['sede'] = $sede;
//	$data2['nombre'] = $sedenombre;
	$data2['titulo_menu'] = 'Descargas';
	$this->load->view('menu.php',$data2);
	$this->load->view('descargas.php',$data);
	$this->load->view('footer.php');
  }        
  
 
}
