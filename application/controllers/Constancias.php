<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Constancias extends CI_Controller {

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
        $this->load->model('Usuario_model');
		$this->load->model('Total_model'); 
		$this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
		$this->puede_escribir = in_array('3W',$this->permisos);
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

public function d_turno($turno) {
 switch ($turno) {
                            case 1: 
                                return "MA&ntilde;ANA";
                                break;
                            case 2: 
                                return "TARDE";
                                break;
                            case 3: 
                                return "NOCHE";
                                break;
                            default:
                                return $turno;
                            }
}
public function inicializar_consulta($error,$mensaje) {
    $datos = array();
	$data['error'] = $error;
	$data['mensaje'] = $mensaje;
	$data['accion'] = 'B';  // Va a buscar
	$data['dni_activo'] = 0;
	$data['datos'] = $datos;
	$data2['titulo_menu'] = 'Recepcion de Constancias';
	$data2['permisos'] = $this->permisos;
	$data['puede_escribir'] = $this->puede_escribir;
	$this->load->view('menu.php',$data2);
	$this->load->view('total_view.php',$data);
}
/*
public function mostrar_datos($dni) {  
    $datos = array();
	$datos = $this->Total_model->Total_por_dni($dni);  
	$data['error'] = '';
	$data['mensaje'] = '';
	$data['datos'] = $datos;
	$data2['titulo_menu'] = 'Recepcion de Constancias';
	$this->load->view('menu.php',$data2);
	$this->load->view('total_view', $data);
}
*/

public function Constancias_post() {  
	
	if ($this->input->post())  {
		{ 	$dni = $this->input->post('dni');
			$accion = $this->input->post('accion');
			$dni_activo = $this->input->post('dni_activo');
			
			$data['accion'] = 'B';
			$data['dni_activo'] = 0;

/*			$clave = $this->input->post('clave');
			$anio  = $this->input->post('anio');*/
			// Si hay dni_activo ingresada, es porque tiene que grabar los cambios
//			if (isset($clave) & ($clave > 0)) {
			if	(($accion == 'G') && (isset($dni_activo) && ($dni_activo > 0))) {
				$rtrabaja = $this->input->post('cbx_trabaja');
				$rcondicion = $this->input->post('rcondicion');
				$presenta = $this->input->post('presenta');
				$usuario = $this->session->userdata('usuario_id');
			/*	echo "1-".$anio." ";
				echo "2-".$clave." ";
				echo "3-".$rtrabaja." ";
				echo "4-".$rcondicion." ";
				echo "5-".$usuario." ";*/
				$data['error'] = '';
				$data['mensaje'] = '';
//				if ($this->Total_model->RegistrarConstancia($anio,$clave,$rtrabaja,$rcondicion,$presenta,$usuario)) {
				if ($this->Total_model->RegistrarConstancia($dni_activo,$rtrabaja,$rcondicion,$presenta,$usuario)) {	
					if (($rcondicion == '') or ($rtrabaja == '') or ($presenta == '')) {
						$data['mensaje'] = 'El registro del DNI '.$dni_activo.' fue reseteado correctamente';
					}
					else {
						$data['mensaje'] = 'El registro del DNI '.$dni_activo.' fue modificado correctamente';
					}
				} else {
					$data['error'] = 'Error al registrar la modificacion del DNI '.$dni_activo;
				}
				$datos = array();
			}
			else {
				$data['error'] = '';
				$data['mensaje'] = '';
				// Si hay dni ingresado pero no hay clave, es porque tiene que buscar
				if (($accion == 'B') && (isset($dni) & ($dni > 0))) { 			
					$datos = $this->Total_model->Total_por_dni($dni);  
		//			if (!isset($clave) or ($clave >= 0)) { 			
						if (count($datos) == 0) { 
							$data['error'] = 'Alumno no encontrado';
						} 
						else {
							$data['accion'] = 'G';
							$data['dni_activo'] = $datos[0]['dni'];

							$presencial = (isset($datos[0]['presencial']) && ($datos[0]['presencial'] == 1));
							
							if (!(isset($datos[0]['presencial'])) or (is_null($datos[0]['presencial']))) { 
								$data['error'] = 'Debe seleccionar sede y turno o elegir modalidad no presencial';
							} else {
								if (($presencial) && (!isset($datos[0]['sede1']) or ($datos[0]['sede1'] <= 0))) { 
									$data['error'] = 'Debe seleccionar sede y turno.';
								} 
							}	
							$datos[0]['d_turno1'] = $this->d_turno($datos[0]['turno1']);  
							$datos[0]['d_turno2'] = $this->d_turno($datos[0]['turno2']);  							
/*							if ($datos[0]['debe'] == 2) { 
								$data['mensaje'] = 'Debe presentar certificado de idioma. Presentarse en Subsecretaria de Planificacion.';
							} */
						}
//					}
				} 
				// Si hay no dni ingresado y no hay clave, es porque toco buscar pero no ingreso datos a buscar
				else {
					$datos = array();
				}
			}	
			$data['datos'] = $datos;
			$data2['titulo_menu'] = 'Recepcion de Constancias';
			$data2['permisos'] = $this->permisos;
			$data['puede_escribir'] = $this->puede_escribir;
            $this->load->view('menu.php',$data2);
            $this->load->view('total_view', $data);
		}
	}		
}


public function reporte() {
	$data2['titulo_menu'] = 'Reporte de Recepcion de Constancias';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('r_constancias_view.php');
}

/*
public function reporte2xls() {  
	require_once 'application/libraries/print/print2pdf.php';
	$sede = $this->session->userdata('sede');
	$header = $this->Total_model->R_constancias($sede);	
}
*/
}