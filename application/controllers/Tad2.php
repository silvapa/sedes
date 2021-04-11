<?php 
 defined('BASEPATH') OR exit('No direct script access allowed');
 class Tad2 extends CI_Controller {

    function __construct()
    {
        parent::__construct();

     if ( ! ($this->session->userdata('logueado')))
        { 
            redirect('usuarios/iniciar_sesion');
        }
    else 
        {
        $this->load->model('Tad2_model');
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
  
  public function Formulario(){
  
  }
  
  public function ReProcesa_Tad2() { //Rematricula_a_Tad2(){
   $rematriculados = $this->Tad2_model->Get_Tramites();
   $tad2_tmps = array();
   foreach($rematriculados as $key) {
      $cuil = trim($key['CUIT_CUIL']);
	  //$dni = substr($cuil, 2, 8);
	  $dni = $key['NUMERO_DOCUMENTO'];
	  //echo $cuil." ".$dni."<br>";
	  $coincidencia = '';
	  $en_guarani = '';
	  $en_padron = '';
	  $id_persona = 0;
	  $datos_guarani_dni = $this->Tad2_model->Get_Datos_Guarani_Dni($dni);
	  if (count($datos_guarani_dni)>0) {
        $en_guarani = 'G';
		$guarani = $datos_guarani_dni[0];
		$id_persona = $guarani['id_persona'];
		$apeGuarani = $this->Standarizar($guarani['apellido']);
		// Existe dni y es otra persona         -> coincidencia = 'd'
		if (substr($apeGuarani,0,3)!=substr($key['APELLIDO_SOLICITANTE'],0,3) ) {
			  $coincidencia = 'd';
		}
		// Existe dni y es la misma persona     -> coincidencia = 'D'  => MAIL PARA RECUPERAR CREDENCIALES
		if (substr($apeGuarani,0,3)==substr($key['APELLIDO_SOLICITANTE'],0,3) ) {
			$coincidencia = 'D';
		}	  
	  }else{ 
	    // busco el alumno en guaraní por cuil	  
	    $datos_guarani_cuil = $this->Tad2_model->Get_Datos_Guarani_Cuil($cuil); 
	    if (count($datos_guarani_cuil)>0) {
          $en_guarani = 'G';
          $guarani = $datos_guarani_cuil[0];
		  $id_persona = $guarani['id_persona'];
		  $apeGuarani = $this->Standarizar($guarani['apellido']);
		  // Existe cuil y es otra persona         -> coincidencia = 'c'
		  if (substr($apeGuarani,0,3)!=substr($key['APELLIDO_SOLICITANTE'],0,3) ) {
			  $coincidencia = 'c';
		  }
		  // Existe cuil y es la misma persona     -> coincidencia = 'C'
		  if (substr($apeGuarani,0,3)==substr($key['APELLIDO_SOLICITANTE'],0,3) ) {
			$coincidencia = 'C';
		  }	  
	    } 
	  } // en guarani por dni o por cuil
	  // busco el mail en guaraní
	  $email = trim($key['EMAIL']);
	  if ($coincidencia=='') {
	    $datos_guarani_mail = $this->Tad2_model->Get_Datos_Guarani_Mail($email); 
	    if (count($datos_guarani_mail)>0) {	  
            $guarani = $datos_guarani_mail[0];
		    $id_persona = $guarani['id_persona'];
            $en_guarani = 'G';
            $coincidencia = 'M';
	    }
	  } // en guarani por mail
	  // busco por apellido y fecha nacimiento -> coincidencia = F
	  if ($dni>"90000000"){
	    $fechanac = trim($key['FECHA_NAC']);	  
	    if ($coincidencia=='' && $fechanac!='') {
	      $apellido = $key['APELLIDO_SOLICITANTE'];
		  $nombre =  $key['NOMBRE_SOLICITANTE'];
	      $datos_guarani_apefec = $this->Tad2_model->Get_Datos_Guarani_ApeFec($apellido, $nombre, $fechanac);
	      if (count($datos_guarani_apefec)>0) {	  
            $guarani = $datos_guarani_apefec[0];
		    $id_persona = $guarani['id_persona'];
	        $en_guarani = 'G';
			$coincidencia = 'F';
	      }
	    }
	  } // dni 90000000
	  if ($coincidencia != '') {
	    $estado = 'R';
	  }else{
	    $estado = 'P';
	  }
	  $unTad2 = array(
	    'tramite'=> $key['Expediente'],
	    't_coincidencia'=> $coincidencia,   
	    'estado'=> $estado,
		'en_padron' => 'I',
	    'en_guarani'=> $en_guarani,
		'id_persona_guarani' => $id_persona	  
	  );
	  
	  array_push($tad2_tmps, $unTad2);
   } // foreach	    
   $this->Tad2_model->Update_Expedienes($tad2_tmps);
   
       $data['error'] = '';
    $data['aviso'] = '';
	$data2['titulo_menu'] = '';
	$data2['permisos'] = $this->permisos;
	$data2['t_tramite'] = '';
	$this->load->view('menu.php',$data2);
	$this->load->view('footer.php');
   
  }// Reproceso tad2
   
  public function Rematricula_a_Tad2(){
     $this->Tad_model->Truncar_tabla('tad2_tmp');
    // levanta trámites ingresados en la tabla rematricula que no hayan sido exportados aún.
    $rematriculados = $this->Tad2_model->Get_Tramites();
	// estandariza los datos para que puedan insertarse en tad2_tmp (los que no se puedan quedan con expediente vacío) todos con en rematricula.exportado = 1)
	$tad2_tmps = $this->Convert2Tad2($rematriculados);
	//print_r($tad2_tmps);
    //exit;
	// pasaje desde tad2_tmp a tad2 (los que no pasen se marcan en rematricula.exportado con diferentes códigos)
	$this->Tad2_model->Save_Expedienes($tad2_tmps);
	// pasar a tabla Tad1
	$this->Tad2_model->InsertarEnTad();
	
    $data['error'] = '';
    $data['aviso'] = '';
	$data2['titulo_menu'] = 'Exportar TAD 2';
	$data2['permisos'] = $this->permisos;
	$data2['t_tramite'] = 'R';
	$this->load->view('menu.php',$data2);
	$this->load->view('generar_tad1_view.php',$data);
	$this->load->view('footer.php');
  }
  
  public function Convert2Tad2($rematriculados){
 // print_r($rematriculados);
 // exit;
   $tad2_tmps = array();
   $cardesc ='Iniciación';
   if (mb_detect_encoding($cardesc, 'utf-8', true) === false) {
	 $cardesc = mb_convert_encoding($cardesc, 'utf-8', 'iso-8859-1');
   }		
   foreach($rematriculados as $key) {
      $datos_padron = $this->Tad2_model->Get_Datos_Padtot($key['anio'], $key['clave']); 

   	  if (trim($key['cuil'])=='' || trim($key['cuil'])=='0'){
	    if ($datos_padron[0]['cuil']!=0) {
		   $cuil = $datos_padron[0]['cuil'];
		}else{
	       $cuil = $this->getCuit($key['dni'], $key['genero']);
		}
	  }else{
	    if ($this->cuilValido($key['cuil']) ) {
	       $cuil = $key['cuil'];
		}else{
	       $cuil = $this->getCuit($key['dni'], $key['genero']);
		}
	  }
	  $estudios_medios = $this->getEstudiosMedios($datos_padron[0]['titulo']);
	  $baja = $datos_padron[0]['baja'];
      $sancion = $datos_padron[0]['sancion'];
	  $nacionalidad = ($datos_padron[0]['nacionalidad']==1?'Argentina':'');
	  $coincidencia = '';
	  $enpadron = 'S';
	  $tipo_mail = '';
	  $estado = 'I';
	  // busco el alumno en guaraní por dni
	  $dni = trim($key['dni']);
	  $datos_guarani_dni = $this->Tad2_model->Get_Datos_Guarani_Dni($dni);
	  //print_r($datos_guarani_dni);

	  if (count($datos_guarani_dni)>0) {
		  $guarani = $datos_guarani_dni[0];
		  //print_r($guarani);
		  //echo $guarani['apellido'];
		  $apeGuarani = $this->Standarizar($guarani['apellido']);
		  //echo $apeGuarani;
		  //exit;
		  // Existe dni y es otra persona         -> coincidencia = 'd'
		  if (substr($apeGuarani,0,3)!=substr($key['apellido'],0,3) ) {
			  $coincidencia = 'd';
			  $tipo_mail = '';
		  }
		  // Existe dni y es la misma persona     -> coincidencia = 'D'  => MAIL PARA RECUPERAR CREDENCIALES
		  if (substr($apeGuarani,0,3)==substr($key['apellido'],0,3) ) {
			$coincidencia = 'D';
			$tipo_mail = 'E';
		  }	  
	  }else{ 
	    // busco el alumno en guaraní por cuil	  
	    $datos_guarani_cuil = $this->Tad2_model->Get_Datos_Guarani_Cuil($cuil); 
	    if (count($datos_guarani_cuil)>0) {
		  $guarani = $datos_guarani_cuil[0];
		  $apeGuarani = $this->Standarizar($guarani['apellido']);
		  // Existe cuil y es otra persona         -> coincidencia = 'c'
		  if (substr($apeGuarani,0,3)!=substr($key['apellido'],0,3) ) {
			  $coincidencia = 'c';
			  $tipo_mail = '';
		  }
		  // Existe cuil y es la misma persona     -> coincidencia = 'C'
		  if (substr($apeGuarani,0,3)==substr($key['apellido'],0,3) ) {
			$coincidencia = 'C';
			$tipo_mail = '';
		  }	  
	    } 
	  }
	  // busco el mail en guaraní
	  $email = trim($key['email']);
	  if ($coincidencia=='') {
	    $datos_guarani_mail = $this->Tad2_model->Get_Datos_Guarani_Mail($email); 
	    if (count($datos_guarani_mail)>0) {	  
			$coincidencia = 'M';
			$tipo_mail = '';
	    }
	  }
	  // busco por apellido y fecha nacimiento -> coincidencia = F
	  $fechanac = trim($key['fechanac']);	  
	  if ($coincidencia=='' && $fechanac!='') {
	    $apellido = $key['apellido'];
		$nombre =  $key['nombre'];
	    $datos_guarani_apefec = $this->Tad2_model->Get_Datos_Guarani_ApeFec($apellido, $nombre, $fechanac);
	    if (count($datos_guarani_apefec)>0) {	  
			$coincidencia = 'F';
			$tipo_mail = '';
	    }
	  }
	  // Si coincidencia != '' enpadron = 'R'
	  if ($coincidencia != ''){
	    $enpadron = 'R';
		$estado = 'R';
	  }
	  
     $unTad2 = array(
	  'tramite'=> $key['id'],
	  'Fecha_caratulacion'=> date('d/m/Y H:i'),
	  'Expediente'=> 'EX-'.$key['anio'].'-'.substr('000000'.trim($key['clave']), -6).'-REM-'.substr('00000'.trim($key['id']),-5),
	  'Estado_expediente'=> $cardesc,
	  'Documento_FINUB'=> 'PV-'.$key['anio'].'-'.substr('000000'.trim($key['clave']), -6).'-REM-'.substr('00000'.trim($key['id']),-5),
	  'Reparticion_actual_del_expediente'=> 'DI#SG_CBC',
	  'Sector_actual_del_expediente'=> 'GUARANI',
	  'Fecha_de_ultimo_pase'=> date('d/m/Y', strtotime('01/01/'.$key['anio'])),
	  'EMAIL'=> $key['email'],
	  'TELEFONO'=> $key['telefono'],
	  'NOMBRE_SOLICITANTE'=> $key['nombre'],
	  'APELLIDO_SOLICITANTE'=> $key['apellido'],
	  'RAZON_SOCIAL_SOLICITANTE'=> '',
	  'SEGUNDO_APELLIDO_SOLICITANTE'=> '',
	  'TERCER_APELLIDO_SOLICITANTE'=> '',
	  'SEGUNDO_NOMBRE_SOLICITANTE'=> '',
	  'TERCER_NOMBRE_SOLICITANTE'=> '',
	  'CUIT_CUIL'=> $cuil,
	  'DOMICILIO'=> '',
	  'PISO'=> '',
	  'DPTO'=> '',
	  'CODIGO_POSTAL'=> 0,
	  'BARRIO'=> '',
	  'COMUNA'=> '',
	  'ALTURA'=> '',
	  'PROVINCIA'=> '',
	  'DEPARTAMENTO'=> '',
	  'LOCALIDAD'=> '',
	  'TIPO_DOCUMENTO'=> 'DU',
	  'NUMERO_DOCUMENTO'=> $key['dni'],
	  'FECHA_NAC'=> $key['fechanac'],
	  'GENERO'=> $key['genero'],
	  'NACIONALIDAD'=> '',
	  'LUGAR_NAC_BAHRA_PROVINCIA'=> '',
	  'LUGAR_NAC_BAHRA_DPTO'=> '',
	  'LUGAR_NAC_BAHRA_LOCALIDAD'=>'',
	  'REQUIERE_CERTIF_ESP'=> 'No',
	  'DISCAPACIDAD'=> 'No',
	  'CARRERA_A_SEGUIR'=> '['.$key['carrera'].']',
	  'TRABAJA'=> 'No',
	  'DOC_ESTUDIOS_MEDIOS'=> $estudios_medios,
	  'OPCION_MAT_ELECTIVA'=> '',
	  'mensaje'=> '',
	  'id_archivo_tad' => 0,
	  't_coincidencia'=> $coincidencia,   
	  'estado'=> $estado,
	  'f_estado'=> date('Y-m-d H:i:s'),
	  'en_padron'=> $enpadron,
	  'clave'=> $key['clave'],
	  'anio'=> $key['anio'],
	  'baja'=> $baja,
	  'sancion'=> $sancion,
	  't_tramite'=> 'R',
	  't_mail_enviar_cbc'=> $tipo_mail,
	  'mail_enviado_cbc'=> '' 
    );
	// paso datos que se deben validar

	array_push($tad2_tmps, $unTad2);
   } // foreach

   return $tad2_tmps;
  }
  
    public function getEstudiosMedios($condicion){
	  switch ($condicion) {
		case 0:
			  return '[3]';
			  break;
		case 1:
			  return '[1]'; 
			  break;
		case 2:
			  return '[3]';
			  break;
		case 3:
			  return '[4]';
			  break;
		case 4:
			  return '[3]';
			  break;
	   }
   }
  
  function Standarizar($apellido){
    $apellido = str_replace("á", "a", $apellido); 
    $apellido = str_replace("é", "a", $apellido); 
	$apellido = str_replace("í", "i", $apellido); 
	$apellido = str_replace("ó", "o", $apellido); 
	$apellido = str_replace("ú", "u", $apellido);
	$apellido = strtoupper($apellido); 	
	return $apellido;
  }
  
 public function getCuit($dni, $sexo){
  $sexo = strtoupper($sexo);

  if ($sexo == 'F'){
    $XY = '27';
    $result_cuit = 27;
  }else{
	if ($sexo == 'M'){
	    $XY = '20';
	    $result_cuit = 20;
	}else{
	    $XY = '11';
	    $result_cuit = 11;
	}
  }

  $cuit_nro = $XY.substr("00000000".$dni,-8);
  $codes = "5432765432";

  $resultado = 0;	
  $x = 0;
  while ($x < 10) {
	$digitoValidador   = intval(substr($codes, $x, 1));
	 
	$digito            = intval(substr($cuit_nro, $x, 1));
	$digitoValidacion  = $digitoValidador * $digito;

	$resultado         = $resultado + $digitoValidacion;
	$x = $x + 1;
  }

  $div = $resultado - (intval($resultado/11)*11);
  $resultado = 11 - $div;
 
  if ($resultado == 11){
    $resultado = 0;
  }
  if ($resultado == 10){  
	if ($sexo == 'F'){
	    $result_cuit = 20;
	    $resultado = 4;
	
	}else{
	   if ($sexo == 'M'){
		    $result_cuit = 23;
	   	    $resultado = 9;
        }
    }
  }

  $result_cuit =  $result_cuit.substr("00000000".$dni,-8).$resultado;

  return $result_cuit; 

  } // aCalcular_Cuil 

  function cuilValido($cuil){
    $xcuil=$cuil."";
    if (preg_match ("/^[0-9]+$/", $xcuil)) {
	  if (strlen($xcuil)==11) {
	    return true;
	  }
	}
	return false;
  }// cuil Valido
  
 }
  
?>  