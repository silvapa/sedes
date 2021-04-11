<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Emails extends CI_Controller {

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
		$this->load->model('Emails_model'); 
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

	public function consultar() {

		$error = '';
		$mensaje = '';
		$this->inicializar_consulta($error,$mensaje);
	}

	public function inicializar_consulta($error,$mensaje) {
		$datos = array();
		$data['error'] = $error;
		$data['mensaje'] = $mensaje;
		$data['accion'] = 'B';  // Va a buscar
		$data['dni_activo'] = 0;
		$data['anio_activo'] = 0;
		$data['clave_activo'] = 0;
		$data['d_carrera'] = "";
		$data['datos'] = $datos;
		$data2['titulo_menu'] = 'Actualización de Email';
		$data2['permisos'] = $this->permisos;
		$data['puede_escribir'] = true;
		$this->load->view('menu.php',$data2);
		$this->load->view('emails_view.php',$data);
	}

	public function obtener_where_total($anio, $clave, $dni, $apellido, $nombre) {  
		$where = '';
		if (($anio != '') && ($anio != ANIO_TOTAL)) {
			$where = "false";
		} else {
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
		}
		return $where;
	} 

	public function obtener_where_padron($anio, $clave, $dni, $apellido, $nombre) {  
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

	public function Constancias_post() {  
		
		if ($this->input->post())  {
			{ 	$dni = $this->input->post('dni');
				$accion = $this->input->post('accion');
				$dni_activo = $this->input->post('dni_activo');
				$anio_activo = $this->input->post('anio_activo');
				$clave_activo = $this->input->post('clave_activo');
				
				$data['accion'] = 'B';
				$data['dni_activo'] = 0;
				$data['anio_activo'] = 0;
				$data['clave_activo'] = 0;
				$data['d_carrera'] = "";
				
				if	(($accion == 'G') && (isset($dni_activo) && ($dni_activo > 0))) {
					$anio = $this->input->post('anio_activo');
					$clave = $this->input->post('clave_activo');
					$email = $this->input->post('email');
					$usuario = $this->session->userdata('usuario_id');
					$data['error'] = '';
					$data['mensaje'] = '';
					if ($this->Emails_model->ExisteEmail($email)==0) { 

						if ($this->Emails_model->RegistrarEmail($anio, $clave, $email, $usuario)) {	
							$data['mensaje'] = 'El mail fue grabado correctamente';
						} else {
							$data['error'] = 'Error al registrar el email del alumno';
						}
				    }else{
						$data['error'] = 'Error. Ya existe un alumno con el email ingresado';					
					}
					$datos = array();
				} 
				else {
					$data['error'] = '';
					$data['mensaje'] = '';
					// Si hay dni ingresado pero no hay clave, es porque tiene que buscar
					if (($accion == 'B') && (isset($dni) & ($dni > 0))) { 			
						$datos = $this->Emails_model->Get_Alumno_por_dni($dni);  
		
						if (count($datos) == 0) { 
							$data['error'] = 'Alumno no encontrado';
						} 
						else {
							$data['accion'] = 'G';
							$data['dni_activo'] = $datos[0]['dni'];
							$data['anio_activo'] = $datos[0]['anio'];
							$data['clave_activo'] = $datos[0]['clave'];
							$datas = $this->Emails_model->Get_Carrera($datos[0]['carrera']);
							$data['d_carrera'] = $datas[0]['nombre'];
							$dato[0]['d_carrera'] = $datas[0]['nombre'];
						}
					} 
					// Si hay no dni ingresado y no hay clave, es porque toco buscar pero no ingreso datos a buscar
					else {
						$datos = array();
					}
				}	
				$data['datos'] = $datos;
				$data2['titulo_menu'] = 'Actualización de Email';
				$data2['permisos'] = $this->permisos;
				$data['puede_escribir'] = true;
				$this->load->view('menu.php',$data2);
				$this->load->view('emails_view', $data);
			}
		}		
	}

}