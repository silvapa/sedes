<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lectivo extends CI_Controller {

    function __construct()
    {
        parent::__construct();

     if ( ! ($this->session->userdata('logueado')))
        { 
            redirect('usuarios/iniciar_sesion');
        }
    else 
        {
		$this->load->library('form_validation');
		$this->load->model('Lectivo_model'); 
        $this->load->model('Usuario_model');
		$this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
		$this->form_validation->set_rules('dni', 'DNI', 'trim|max_length[8]');
		$this->form_validation->set_rules('anio', 'anio', 'trim|max_length[4]');
		$this->form_validation->set_rules('clave', 'Clave', 'trim|max_length[6]');
	}   
    }
 
public function index() {
    echo "<h1>".APP_TITLE."</h1>";
  die();
}

public function obtener_where($anio, $clave, $dni, $apellido, $nombre) {  
	$where = '';
	if ($dni != '') {
		$where = ' dni = '.$dni;
	}	
	if ($clave != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' clave = '.$clave;
	}	
	if ($anio != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' anio = '.$anio;
	}	
	if ($apellido != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' apellido like "'. $apellido . '%"';
	}	
	if ($nombre != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' nombre like "'. $nombre . '%"';
	}	
	return $where;
} 

public function obtener_where_grilla($anio, $clave, $dni, $apellido, $nombre) {  
	$where = '';
	if ($dni != '') {
		$where = ' dni >= '.$dni;
	}	
	if ($clave != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' clave >= '.$clave;
	}	
	if ($anio != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' anio = '.$anio;
	}	
	if ($apellido != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' apellido like "'. $apellido . '%"';
	}	
	if ($nombre != '') {
		if ($where != '') { $where = $where . ' and ';}
		$where = $where  . ' nombre like "'. $nombre . '%"';
	}	
	return $where;
} 
 
public function consultar() {
	$error = '';
	$this->inicializar_consulta($error);
}

public function completar_array($arreglo) {
	$long_arr = count($arreglo);
	$cuantos = 30;
    for ($i = $long_arr; $i < $cuantos; $i++)    {
		$arreglo[$i][0] = 0;
		$arreglo[$i][1] = 0;
		$arreglo[$i][2] = 0;
		$arreglo[$i][3] = '';
		$arreglo[$i][4] = '';
		$arreglo[$i][5] = 0;
		$arreglo[$i][6] = 0;
	}
}

public function inicializar_consulta($error) {
	$arreglo = array();
//	$this->completar_array($arreglo);
//	$sedenombre = $this->session->userdata('nombre');
	$data['error'] = $error;
	$data['esgrilla'] = 'S';	
	$cuantos = 30;
	if ($this->session->userdata('where_grilla') != null) {
		$where = $this->session->userdata('where_grilla');
		$arreglo = $this->Lectivo_model->Get_Activos($where,$cuantos);  
	}	

	$data['activos'] = $arreglo;
	$data['clave'] = 0;
//	$data2['nombre'] = $sedenombre;
	$data2['titulo_menu'] = 'Consulta de Lectivo';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('lectivo_view.php',$data);
//	$this->load->view('footer.php');
}

public function mostrar_grilla($anio, $clave, $dni, $apellido, $nombre) {  
	$cuantos = 30;
	$where = $this->obtener_where_grilla($anio, $clave, $dni, $apellido, $nombre);
	$this->session->set_userdata('where_grilla', $where);
	$activos = $this->Lectivo_model->Get_Activos($where,$cuantos);  
	$data['error'] = '';
	$data['esgrilla'] = 'S';			
	$data['activos'] = $activos;
	$data2['titulo_menu'] = 'Consulta de Lectivo';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('lectivo_view', $data);
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

public function grilla_post() {  
	if ($this->input->post())  {
		if ($this->form_validation->run()==FALSE) {
			$error = validation_errors();
			$this->inicializar_consulta($error);
		} 
		else 
		{
			$anio = $this->input->post('anio');
			$clave = $this->input->post('clave');
			$dni = $this->input->post('dni');
			$apellido = $this->input->post('apellido');
			$nombre = $this->input->post('nombre');
			$this->mostrar_grilla($anio, $clave, $dni, $apellido, $nombre);
/*			$cuantos = 30;
//			$activos = $this->Lectivo_model->Lectivo_por_dni($dni,$cuantos);  
			$where = $this->obtener_where_grilla($anio, $clave, $dni, $apellido, $nombre);
			$activos = $this->Lectivo_model->Get_Activos($where,$cuantos);  
			$data['error'] = '';
			$data['esgrilla'] = 'S';			
			$data['activos'] = $activos;
	//		$data2['nombre'] = $this->session->userdata('nombre');
			$data2['titulo_menu'] = 'Consulta de Lectivo';
			$this->load->view('menu.php',$data2);
			$this->load->view('lectivo_view', $data);
//			$this->load->view('footer.php');*/
		}
	}
	else { 
		redirect('usuarios/iniciar_sesion');  
	}		
}

public function lectivo_post() {  
	if ($this->input->post())  {
		if ($this->form_validation->run()==FALSE) {
			$error = validation_errors();
			$this->inicializar_consulta($error);
		} 
		else 
		{ 	$anio = $this->input->post('anio');
			$clave = $this->input->post('clave');
			$dni = $this->input->post('dni');
			$apellido = $this->input->post('apellido');
			$focused = $this->input->post('focused');
			$nombre = $this->input->post('nombre');
			$cuantos = 30;
			if ($this->input->post('esgrilla') == 'S') {
				$where = $this->obtener_where_grilla($anio, $clave, $dni, $apellido, $nombre);
				$this->session->set_userdata('where_grilla', $where);
				$activos = $this->Lectivo_model->Get_Activos($where,$cuantos);  
//				$activos = $this->Lectivo_model->Lectivo_por_dni($dni,$cuantos);  
				$data['error'] = '';
				if (count($activos) == 0) { 
					$data['error'] = 'No hay alumnos que cumplan con el criterio ingresado';
				}
				$data['esgrilla'] = 'S';			
				$data['activos'] = $activos;
//				$data2['nombre'] = $this->session->userdata('nombre');
				$data2['titulo_menu'] = 'Consulta de Lectivo';
				$data2['permisos'] = $this->permisos;
				$this->load->view('menu.php',$data2);
				$this->load->view('lectivo_view', $data);
				//			$this->load->view('footer.php');
			} 
			else {
				$data['error'] = '';
				$data['esgrilla'] = 'N';			
				$data['observados'] = '';
				$asignacion = array();
				$moodle = array();
				$data['activos'] = $asignacion;
				// Si no hay datos de busqueda ingresados, es porque va a iniciar la busqueda ahora
				if (($clave == '') && ($anio == '') && ($dni == '') && ($apellido == '') && ($nombre == '')) {
					$data['focused'] = $this->input->post('focused');			
					$clave = '';
					$anio = '';
					$dni = '';
					$apellido = '';
					$nombre = '';
				} 
				else {
					$data['focused'] = '';
					// Si hay datos de busqueda y no es grilla, debo obtener al alumno y luego su asignacion
					if (($clave == '') or ($anio == '')) {
						$where = $this->obtener_where($anio, $clave, $dni, $apellido, $nombre);
						$alumno = $this->Lectivo_model->Get_Activos($where,2); 
						if (count($alumno) != 1) { 
							$this->mostrar_grilla($anio, $clave, $dni, $apellido, $nombre);
							return;
						}
						else { 
							$anio = $alumno[0]['anio'];	
							$clave = $alumno[0]['clave'];
							$dni = $alumno[0]['dni'];
							$apellido = $alumno[0]['apellido'];
							$nombre = $alumno[0]['nombre'];						
						}
					} 

					if (($clave != '') && ($anio != '')) {
						$observados = $this->Lectivo_model->Observados_por_clave($anio,$clave); 
						$mostrar_asig = true;
						foreach ($observados as $item=>$fields) { 
							if ($fields['mostrar_asig'] == 'N')  { 
								$mostrar_asig = false;
							}
							if ($data['observados'] != '') { 
								$data['observados'] = $data['observados'] . '<br>';
							}
							$data['observados'] = $data['observados'] . $fields['descripcion'];
						}
						if ($mostrar_asig) {
							$asignacion = $this->Lectivo_model->Asignacion_por_clave($anio,$clave,$this->session->userdata('cuat_actual'));
							$moodle = $this->Lectivo_model->Matriculado_Moodle($anio,$clave);
						} 
					} 
					$data['error'] = '';
					if (count($asignacion) == 0) { 
						$rechazados = $this->Lectivo_model->Rechazados_por_clave($anio,$clave); 
						if (count($rechazados) != 0)  { 
							foreach ($rechazados as $item=>$fields) { 
								if ($data['error'] != '') { $data['error'] = $data['error'] . '<br>';}
								$data['error'] = $data['error'] . $fields['descripcion'];
							}							
						}
						else { 
//							$data['error'] = 'No registra asignacion';
						}
					}
					$data['clave'] = $clave;
					$data['anio'] = $anio;
					$data['dni'] = $dni;
					$data['apellido'] = $apellido;
					$data['nombre'] = $nombre;
					$data['activos'] = $asignacion;
					$data['moodle'] = $moodle;
				}
//				$data2['nom_usuario'] = $this->session->userdata('nombre');
				$data2['titulo_menu'] = 'Consulta de Lectivo';
				$data2['permisos'] = $this->permisos;
				$this->load->view('menu.php',$data2);
				$this->load->view('asigna_view', $data);
	//			$this->load->view('footer.php');
		}
	}
		
	}
	else { 
		redirect('usuarios/iniciar_sesion');  
	}		
}
 
}