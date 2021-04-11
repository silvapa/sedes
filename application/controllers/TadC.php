<?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
 class TadC extends CI_Controller {

    function __construct()
    {
        parent::__construct();

     if ( ! ($this->session->userdata('logueado')))
        { 
            redirect('usuarios/iniciar_sesion');
        }
    else 
        {
        $this->load->model('TadC_model');
		$this->load->model('Tad_model');
        $this->load->model('Usuario_model');
        $this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
        $this->load->library('Funcs_lib');
        $this->load->library('Upload');
        $this->load->library('form_validation');
        }   
    }
 
  public function index() {
    echo "<h1>".APP_TITLE."</h1>";
    die();
  }
  
  public function Carrera_a_TadC(){
    // levanta trámites ingresados en la tabla carrera
    $solicitudes = $this->TadC_model->Get_Tramites();
	$tadc_tmp = $this->Convert2TadC($solicitudes);
//print_r($tadc_tmp);
//exit;
	// pasar a tabla TadC
	$this->TadC_model->Save_Expedienes($tadc_tmp);
	//
    $data['error'] = '';
    $data['aviso'] = '';
	$data2['titulo_menu'] = 'Exportar TAD C';
	$data2['permisos'] = $this->permisos;
	$data2['t_tramite'] = 'C';
	$this->load->view('menu.php',$data2);
	//$this->load->view('generar_tad1_view.php',$data);
	$this->load->view('footer.php');
  }
  
  public function Convert2TadC($solicitudes){
   $tadC_tmps = array();
   $cardesc ='Iniciación';
   if (mb_detect_encoding($cardesc, 'utf-8', true) === false) {
	 $cardesc = mb_convert_encoding($cardesc, 'utf-8', 'iso-8859-1');
   }		
   foreach($solicitudes as $key) {
	 $dni = trim($key['dni']);
	 $id_guarani = trim($key['id_guarani']);
	 $datos_guarani_dni = $this->TadC_model->Get_Datos_Guarani_ID($id_guarani);
	 if (count($datos_guarani_dni)>0) {
	    $guarani = $datos_guarani_dni[0];
	    $cuil = $guarani['cuil'];
	  	$estado = 'I';	 
		$carreradesde = $key['carrera'];
		$carrerahasta = $key['carrhasta'];
		$carrerasimultanea = $key['carrsimultanea'];
	    $unTadC = array(
	  		'tramite'=> $key['id'],
	  		'Fecha_caratulacion'=> date('d/m/Y H:i'),
	  		'Expediente'=> '',
	  		'Estado_expediente'=> $cardesc,
	  	    'Documento_FINUB'=> '',
	        'Reparticion_actual_del_expediente'=> 'DI#SG_CBC',
	  		'Sector_actual_del_expediente'=> 'GUARANI',
	  		'Fecha_de_ultimo_pase'=> date('d/m/Y H:i'),
	  		'EMAIL'=> $key['email'],
		    'NOMBRE_SOLICITANTE'=> $key['nombre'],
	        'APELLIDO_SOLICITANTE'=> $key['apellido'],
		    'CUIT_CUIL'=> $cuil,
	  		'TIPO_DOCUMENTO'=> 'DU',
	  		'NUMERO_DOCUMENTO'=> $key['dni'],
		    'GENERO'=> $key['genero'],
			'carrera_baja'=> '',
	  		'carrera_alta'=> '',
	  		'tipo_de_accion'=> '',
	  		'estado'=> $estado,
	  		'f_estado'=> date('d/m/Y H:i'),
	  		'revisar'=> 'No' 
    	);	
	 }// datos guarani
	 if ($carreradesde!=0) {
  		$unTadC['Expediente'] = 'EX-'.substr('0000000'.trim($key['id_guarani']), -7).'-CCA-'.substr('00000'.trim($key['id']),-5);
  	    $unTadC['Documento_FINUB'] =  'PV-'.substr('0000000'.trim($key['id_guarani']), -7).'-CCA-'.substr('00000'.trim($key['id']),-5);
	 	$unTadC['carrera_baja'] = '['.$key['carrera'].']';
		$unTadC['carrera_alta'] = '['.$key['carrhasta'].']';
		$unTadC['tipo_de_accion'] = 'C';
 	    array_push($tadC_tmps, $unTadC);		
	 }
	 if ($carrerasimultanea!=0) {
	   	$unTadC['Expediente'] = 'EX-'.substr('0000000'.trim($key['id_guarani']), -7).'-SCA-'.substr('00000'.trim($key['id']),-5);
  	    $unTadC['Documento_FINUB'] =  'PV-'.substr('0000000'.trim($key['id_guarani']), -7).'-SCA-'.substr('00000'.trim($key['id']),-5);
	 	$unTadC['carrera_baja'] = '['.$key['carrera'].']';
		$unTadC['carrera_alta'] = '['.$key['carrsimultanea'].']';
		$unTadC['tipo_de_accion'] = 'S';
 	    array_push($tadC_tmps, $unTadC);		
	 }	 
   } // foreach
   return $tadC_tmps;
  }
  
 }
?>  