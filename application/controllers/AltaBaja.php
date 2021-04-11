<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AltaBaja extends CI_Controller {

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
        $this->load->model('AltaBaja_model'); 
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
		$data2['titulo_menu'] = 'ALTA BAJA';
		$data2['permisos'] = $this->permisos;
		$data['puede_escribir'] = true;
		$this->load->view('menu.php',$data2);
		$this->load->view('altabaja_view.php',$data);
	}

	public function altabaja_post() {  
		
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
				$data['usuario'] = $this->session->userdata('usuario_id');
				if	(($accion == 'G') && (isset($dni_activo) && ($dni_activo > 0))) {
					$anio = $this->input->post('anio_activo');
					$clave = $this->input->post('clave_activo');
					$email = $this->input->post('email');

					$data['error'] = '';
					$data['mensaje'] = '';
					$datos = array();
				} 
				else { 
					$data['error'] = '';
					$data['mensaje'] = '';
					// Si hay dni ingresado pero no hay clave, es porque tiene que buscar
					if (($accion == 'B') && (isset($dni) & ($dni > 0))) { 		
						//$datos = $this->AltaBaja_model->Datos_Padron($dni);
						$datos = $this->AltaBaja_model->Datos_Padtot_Por_Dni($dni);
						$datocarreras = $this->AltaBaja_model->Get_Carreras_Padguara($dni);
						//print_r($datocarreras);
						//exit;
						$data['enguarani'] = count($datocarreras);
						if (count($datos) == 0) { 
							$data['error'] = 'Alumno no encontrado';
						} 
						else {
							$data['accion'] = 'G';
							$data['dni_activo'] = $datos[0]['dni'];
							$data['anio_activo'] = $datos[0]['anio'];
							$data['clave_activo'] = $datos[0]['clave'];
							$data['carreras'] = $datocarreras;
							//$data['carrera'] = $datos[0]['carrera'];
							//$data['d_carrera'] = $datos[0]['d_carrera'];
							$data['titulo'] = $datos[0]['titulo'];
							$data['regular'] = $datos[0]['regular'];
							$data['baja'] =  $datos[0]['baja'];
							$data['confirmo'] = "";
							$data['apro_uba_xxi'] =  "";
							$data['cursa_uba_xxi'] =  "";
							/*
							if ($datos[0]['anio']==2020) {
								$datoNC = $this->AltaBaja_model->Alumno_No_Confirmo_Segundo($datos[0]['anio'], $datos[0]['clave']);  
								if ($datoNC[0]['noconfirmo']==1){
									$data['confirmo'] = "NO";
								}else{
									$data['confirmo'] = "Sí";
								}
								
								$datas = $this->AltaBaja_model->Aprobo_XXI($datos[0]['anio'], $datos[0]['clave']);
								$uba_xxi = "";
								for ($x=0; $x<count($datas); $x++) {
									$uba_xxi .= $datas[$x]['materia']." ";
								}
								$data['apro_uba_xxi'] =  $uba_xxi;
							}else{
								$data['apro_uba_xxi'] =  "";
							}
							*/
							$datas = $this->AltaBaja_model->Cursa_XXI($datos[0]['anio'], $datos[0]['clave']);
							$uba_xxi = "";
							for ($x=0; $x<count($datas); $x++){
								$uba_xxi .= $datas[$x]['materia']." ";
							}
							$data['cursa_uba_xxi'] =  $uba_xxi;
							$cursos = $this->AltaBaja_model->Asignacion_por_clave($datos[0]['anio'], $datos[0]['clave'], 1);
						//	$cursos = $this->AltaBaja_model->Asignacion_por_clave($datos[0]['anio'], $datos[0]['clave'], $this->session->userdata('cuat_actual'));
							$data['sede'] = $this->session->userdata('sede');
							$data['cursos'] = $cursos;
							$data['cantmats'] = count($cursos);
							$cantmatscarrera = $this->AltaBaja_model->Get_Max_Materias($datos[0]['dni']);
 							if ($cantmatscarrera[0]['cantidad']==0){
							  $data['maxMats'] = 3;
							}else{
							  $data['maxMats'] = 4;
							}
							
							$data['pedir_mail'] = false;
							$datacargada = $this->AltaBaja_model->No_Cargar($datos[0]['anio'], $datos[0]['clave']);
							$data['nocargar'] = $datacargada[0]['cantidad'];
							$data['yacargado'] = $this->AltaBaja_model->Ya_Cargado($datos[0]['anio'], $datos[0]['clave']);
						}
					} 
					// Si hay no dni ingresado y no hay clave, es porque toco buscar pero no ingreso datos a buscar
					else {
						$datos = array();
					}
				}	
				$data['datos'] = $datos;
				$data2['titulo_menu'] = 'ALTA BAJA';
				$data2['permisos'] = $this->permisos;
				$data['puede_escribir'] = true;
				$this->load->view('menu.php',$data2);
				$this->load->view('altabaja_view', $data);
			}
		}		
	}


	public function listado(){
		$datas = $this->AltaBaja_model->Altabaja_Cargado($this->session->userdata('sede'));
		$data['alumnos'] = $datas;
		$data['sede_actual'] = $this->session->userdata('sede');
		$data2['titulo_menu'] = 'ALTA BAJA CARGADOS';
		$data2['permisos'] = $this->permisos;
		$data['puede_escribir'] = true;
		$this->load->view('menu.php',$data2);
		$this->load->view('altabaja_carga_view', $data);	
	}

	public function validar_cursos(){
		$ok = true;
		$errores_cursos = "";

		$anio = $_GET["anio"];
		$clave = $_GET["clave"];
		$dni = $_GET["dni"];
		$sede1 = $_GET["sede1"];
		$sede2 = $_GET["sede2"];
		$sede3 = $_GET["sede3"];
		$sede4 = $_GET["sede4"];

		$mate1 = $_GET["mate1"];
		$mate2 = $_GET["mate2"];
		$mate3 = $_GET["mate3"];
		$mate4 = $_GET["mate4"];

		$hora1 = $_GET["hora1"];
		$hora2 = $_GET["hora2"];
		$hora3 = $_GET["hora3"];
		$hora4 = $_GET["hora4"];

		$aula1 = $_GET["aula1"];
		$aula2 = $_GET["aula2"];
		$aula3 = $_GET["aula3"];
		$aula4 = $_GET["aula4"];

		
		if ($ok) {        
			$jsondata["success"] = true;
//    		$jsondata["data"] = array('message' =>  $sede1." ".$mate1." ".$hora1." ".$aula1." ".$sede2." ".$mate2." ".$hora2." ".$aula2." ".$sede3." ".$mate3." ".$hora3." ".$aula3." ".$sede4." ".$mate4." ".$hora4." ".$aula4);	  
    		$jsondata["data"] = array('message' =>  $errores_cursos);	  
	    }
	    else {
			$jsondata["success"] = false;
    		$jsondata["data"] = array('message' =>  "Error en cursos.");
	    }   
		header('Content-type: application/json; charset=utf-8');
  		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}

}