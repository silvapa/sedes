<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Padron extends CI_Controller {

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
        $this->load->model('Sitacad_model');
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

public function consultar_total() {
	$error = '';
	$mensaje = '';
	$this->inicializar_consulta_total($error,$mensaje);
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

public function inicializar_consulta_total($error,$mensaje) {
    $datos = array();
	$data['error'] = $error;
	$data['mensaje'] = $mensaje;
	$data['accion'] = 'B';  // Va a buscar
	$data['dni_activo'] = 0;
	$data['alumnos'] = $datos;
	$data2['titulo_menu'] = 'Consulta de Padron Actual';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('grilla_total_view.php',$data);
}

public function inicializar_consulta($error,$mensaje) {
    $datos = array();
	$data['error'] = $error;
	$data['mensaje'] = $mensaje;
	$data['accion'] = 'B';  // Va a buscar
	$data['dni_activo'] = 0;
	$data['alumnos'] = $datos;
	$data2['titulo_menu'] = 'Consulta de Padron';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('alumno_view.php',$data);
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
//        	$apellido = mb_convert_encoding($apellido, "iso-8859-1", "UTF-8");
        	$apellido = $apellido;
		$where = $where  . " apellido like '". $apellido . "%'";
	}	
	if ($nombre != '') {
        	if ($where != '') { $where = $where . ' and ';}
//        	$nombre = mb_convert_encoding($nombre, "iso-8859-1", "UTF-8");
		$nombre = $nombre;
		$where = $where  . " nombre like '". $nombre . "%'";
	}	
	return $where;
} 


public function Padron_post() {  
	
	if ($this->input->post())  {
        $dni = $this->input->post('dni');
        $clave = $this->input->post('clave');
        $anio  = $this->input->post('anio');
        $apellido = $this->input->post('apellido');
        $nombre  = $this->input->post('nombre');
        $data2['titulo_menu'] = 'Consulta de Padron';
        $data2['permisos'] = $this->permisos;
        $data['error'] = '';
        $data['mensaje'] = '';
        $w_padron =  $this->obtener_where_padron($anio, $clave, $dni, $apellido, $nombre);
        $w_total =  $this->obtener_where_total($anio, $clave, $dni, $apellido, $nombre);
        $datos = $this->Lectivo_model->Get_Alumnos($w_padron,$w_total,30);  
        // Si no hay alumnos, debo informar error y mostrar solo los criterios de busqueda
        // Si hay mas de un alumno, debo mostrar la grilla para que elija
        if ((count($datos) == 0) or (count($datos) > 1)) { 
            if (count($datos) == 0) { 
                $data['error'] = 'Alumno no encontrado';
            } 
            $cuantos = count($datos);
            for ($i = 0; $i < $cuantos;$i++ ) { 
/*               $datos[$i]['apellido'] = mb_convert_encoding($datos[$i]['apellido'], "UTF-8", "iso-8859-1"); 
                $datos[$i]['nombre'] = mb_convert_encoding($datos[$i]['nombre'], "UTF-8", "iso-8859-1"); */
                $datos[$i]['apellido'] = $datos[$i]['apellido']; 
                $datos[$i]['nombre'] = $datos[$i]['nombre']; 
            }
            $data['esgrilla'] = 'S';			
            $data['alumnos'] = $datos;
            $this->load->view('menu.php',$data2);
            $this->load->view('alumno_view', $data);
            return;
        }
        else 
        {   $clave = $datos[0]['clave'];
            $anio = $datos[0]['anio'];

            $data['observados'] = '';
            $observados = $this->Lectivo_model->Observados_por_clave($anio,$clave); 
            $mostrar_asig = true;
            foreach ($observados as $item=>$fields) { 
                if ($fields['mostrar_asig'] == 'N')  { 
                    $mostrar_asig = false;
                }
                if ($data['observados'] != '') { $data['observados'] = $data['observados'] . '<br>';}
                $data['observados'] = $data['observados'] . $fields['descripcion'];
            }
            if ($mostrar_asig) {
                $asignacion = $this->Lectivo_model->Asignacion_por_clave($anio,$clave,$this->session->userdata('cuat_actual'));  
                $moodle = $this->Lectivo_model->Matriculado_Moodle($anio,$clave);
            } 
            else {
                $asignacion = array();  
                $moodle = array(); 
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
            $datos_padron = $this->Lectivo_model->Datos_Padron($anio,$clave);
            if ($anio == ANIO_TOTAL) {
                $datos_total = $this->Lectivo_model->Datos_Total($clave);
            }
            else {
                $datos_total = array();
            }
            // Para simplificar la view, unifico los datos de padron y total
            if (count($datos_padron) > 0) {
                $data['carrera'] = $datos_padron[0]['carrera'];
																															   
                $data['carrera2'] = $datos_padron[0]['carrera2'];
																																 
                $data['carrera3'] = $datos_padron[0]['carrera3'];
																																 
                $data['carrera4'] = $datos_padron[0]['carrera4'];
																																 
                $data['carrera5'] = $datos_padron[0]['carrera5'];
																																 
                $data['dni'] = $datos_padron[0]['dni'];  
																											  
																										   
                $data['sancion']= $datos_padron[0]['sancion'];  
                $data['calidad']='En padron ';
																														
                $data['cuil'] = $datos_padron[0]['cuil'];  
																																																	 
                $data['fecha_naci'] =  (($datos_padron[0]['fecha_naci'] != '') && ($datos_padron[0]['fecha_naci'] != '0000-00-00')) ?$datos_padron[0]['fecha_naci']:'';  
                $data['condicion'] = $datos_padron[0]['titulo'];  
                $data['cuating'] = $datos_padron[0]['cuating'];  
                $data['sexo'] = ($datos_padron[0]['sexo'] == 'F' ? 'Femenino' : ($datos_padron[0]['sexo'] == 'M' ? 'Masculino' : ''));
                $data['regular'] = ($datos_padron[0]['regular'] == 'T' ? 'Si' : ($datos_padron[0]['regular'] == 'F' ? 'No' : ''));
                $data['baja'] = ($datos_padron[0]['baja'] == 'T' ? 'Si' : ($datos_padron[0]['baja'] == 'F' ? 'No' : ''));

                $data['d_carrera'] = $datos_padron[0]['d_carrera'];
                $data['d_carrera2'] = $datos_padron[0]['d_carrera2'];
                $data['d_carrera3'] = $datos_padron[0]['d_carrera3'];
                $data['d_carrera4'] = $datos_padron[0]['d_carrera4'];
                $data['d_carrera5'] = $datos_padron[0]['d_carrera5'];
                $data['apellido'] = $datos_padron[0]['apellido']; 
                $data['nombre'] = $datos_padron[0]['nombre'];  
                $data['d_nacionalidad']= $datos_padron[0]['d_nacionalidad']; 

              
/*              $data['d_carrera']  = mb_convert_encoding($datos_padron[0]['d_carrera'], "UTF-8", "iso-8859-1");                
                $data['d_carrera2'] = mb_convert_encoding($datos_padron[0]['d_carrera2'], "UTF-8", "iso-8859-1");                
                $data['d_carrera3'] = mb_convert_encoding($datos_padron[0]['d_carrera3'], "UTF-8", "iso-8859-1");                
                $data['d_carrera4'] = mb_convert_encoding($datos_padron[0]['d_carrera4'], "UTF-8", "iso-8859-1");                
                $data['d_carrera5'] = mb_convert_encoding($datos_padron[0]['d_carrera5'], "UTF-8", "iso-8859-1"); 
                $data['apellido']   = mb_convert_encoding($datos_padron[0]['apellido'], "UTF-8", "iso-8859-1"); 
                $data['nombre']     = mb_convert_encoding($datos_padron[0]['nombre'], "UTF-8", "iso-8859-1");  
                $data['d_nacionalidad']=mb_convert_encoding($datos_padron[0]['d_nacionalidad'], "UTF-8", "iso-8859-1"); */
                }
            else {
                $data['carrera'] = $datos_total[0]['carrera'];
                $data['d_carrera'] = $datos_total[0]['d_carrera'];                
                $data['carrera2'] = null;
                $data['d_carrera2'] = ''; 
                $data['carrera3'] = null;
                $data['d_carrera3'] = ''; 
                $data['carrera4'] = null;
                $data['d_carrera4'] = ''; 
                $data['carrera5'] = null;
                $data['d_carrera5'] = ''; 
                $data['dni'] = $datos_total[0]['dni'];  
                $data['apellido'] = $datos_total[0]['apellido'];  
                $data['nombre'] = $datos_total[0]['nombre'];  
                $data['sancion']='F';
                $data['calidad']='En Total '.ANIO_TOTAL.' ';
                $data['d_nacionalidad']=$datos_total[0]['d_nacionalidad']; // VER EN MODELO
                $data['cuil'] = '';  // El total no tiene cuil
                $data['fecha_naci'] = (($datos_total[0]['fecha_naci'] != '') && ($datos_total[0]['fecha_naci'] != '0000-00-00')) ?date("d/m/Y", strtotime($datos_total[0]['fecha_naci'])):'';   
                $data['condicion'] = $datos_total[0]['condicion'];  
                $data['cuating'] = 1;  // El total no tiene cuating
                $data['sexo'] = ($datos_total[0]['sexo'] == 'F' ? 'Femenino' : ($datos_total[0]['sexo'] == 'M' ? 'Masculino' : ''));
                $data['regular'] = 'Si';
                $data['baja'] = 'No';
            }
            $novedades = array();
            if (count($datos_total) > 0) {
/*                $presencial = (isset($datos_total[0]['presencial']) && ($datos_total[0]['presencial'] == 1));*/
                $total['msg_presencial'] = '';
 /*               if (!(isset($datos_total[0]['presencial'])) or (is_null($datos_total[0]['presencial']))) { 
                    $total['msg_presencial'] = 'Debe seleccionar sede y turno o elegir modalidad no presencial';
                } else {
                    if (($presencial) && (!isset($datos_total[0]['sede1']) or ($datos_total[0]['sede1'] <= 0))) { 
                        $total['msg_presencial'] = 'Debe seleccionar sede y turno.';
                    } 
                }	*/
                $total['sede1'] = $datos_total[0]['sede1']; 
                $total['sede2'] = $datos_total[0]['sede2']; 
                $total['d_sede1'] = $datos_total[0]['d_sede1']; 
                $total['d_sede2'] = $datos_total[0]['d_sede2']; 
                $total['turno1'] = $datos_total[0]['turno1']; 
                $total['turno2'] = $datos_total[0]['turno2']; 
                $total['d_turno1'] = $this->d_turno($datos_total[0]['turno1']);  
                $total['d_turno2'] = $this->d_turno($datos_total[0]['turno2']);  
                $data['debe'] = $datos_total[0]['debe'];
                $data['presenta'] = ($datos_total[0]['presenta'] == 1 ? 'Si' : ($datos_total[0]['presenta'] == '0' ? 'No' : '-'));
                $data['trabaja'] = ($datos_total[0]['trabaja'] == 1 ? 'Si' : ($datos_total[0]['trabaja'] == '0' ? 'No' : '-'));
                $data['paquete'] = $datos_total[0]['paquete'];
                for ($i = 1; $i<= 9; $i++) {
                    if (($datos_total[0]['AXXI'.$i] != '') && ($datos_total[0]['AXXI'.$i] != 0)) {
                        $novedades []= array("materia" => $datos_total[0]['AXXI'.$i],"d_novedad"=> 'Declara aprobada por UBAXXI',"cuat" => 0);
                    }
                }

                
            } else {
                $total = array();
            }

            $historial = $this->Lectivo_model->Get_historial($anio,$clave);
            //$cursa_xxi = $this->Lectivo_model->Cursa_XXI($anio,$clave);
            $cursa_xxi = $this->Lectivo_model->Pide_XXI($data['dni']);
            $sitacad = $this->Sitacad_model->Sitacad_por_clave($anio,$clave);
            foreach ($cursa_xxi as $item=>$fields) { 
               $novedades []= array("materia" => $fields['materia'],"d_novedad"=> 'Inscripto a cursar por UBAXXI',"cuat" => $this->session->userdata('cuat_actual'));
            }
            $data['clave'] = $clave;
            $data['anio'] = $anio;
            $data['total'] = $total;
            $data['alumnos'] = $asignacion;
            $data['xxi'] = $novedades;
            $data['historial'] = $historial;
            $data['moodle'] = $moodle;
            $data['sitacad'] = $sitacad;
        }
        $data2['titulo_menu'] = 'Consulta de Alumnos';
        $data2['permisos'] = $this->permisos;
        $this->load->view('menu.php',$data2);
        $this->load->view('detalle_view', $data);
        return;
          
    }
    // Si hay no dni ingresado y no hay clave, es porque toco buscar pero no ingreso datos a buscar
    else 
    {
        $datos = array();
    }
    $data['datos'] = $datos;
    $data2['titulo_menu'] = 'Consulta de Padron';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('detalle_view', $data);
}


public function padron_actual_post() {  
	
	if ($this->input->post())  {
        $dni = $this->input->post('dni');
        $clave = $this->input->post('clave');
        $apellido = $this->input->post('apellido');
        $nombre  = $this->input->post('nombre');
        $data2['titulo_menu'] = 'Consulta de Padron Actual';
        $data2['permisos'] = $this->permisos;
        $data['error'] = '';
        $data['mensaje'] = '';
        $w_total =  $this->obtener_where_total('', $clave, $dni, $apellido, $nombre);
        $datos = $this->Lectivo_model->Get_Alumnos_padron_actual($w_total,100);  
        // Si no hay alumnos, debo informar error y mostrar solo los criterios de busqueda
        // Si hay mas de un alumno, debo mostrar la grilla para que elija
/*        if ((count($datos) == 0) or (count($datos) > 1)) { */
            if (count($datos) == 0) { 
                $data['error'] = 'Alumno no encontrado';
            } 
            $cuantos = count($datos);
/*            for ($i = 0; $i < $cuantos;$i++ ) { 
                $datos[$i]['apellido'] = mb_convert_encoding($datos[$i]['apellido'], "UTF-8", "iso-8859-1"); 
                $datos[$i]['nombre'] = mb_convert_encoding($datos[$i]['nombre'], "UTF-8", "iso-8859-1"); 
            }*/
            $data['esgrilla'] = 'S';			
            $data['alumnos'] = $datos;
            $this->load->view('menu.php',$data2);
            $this->load->view('grilla_total_view', $data);
            return;
/*        }
        else 
        {   $clave = $datos[0]['clave'];
//            $anio = $datos[0]['anio'];

            $mostrar_asig = false;
            $asignacion = array();  
            $moodle = array(); 

            $data['error'] = '';
            $datos_padron = array();
            $datos_total = $this->Lectivo_model->Datos_Padron_Actual($clave);
            // Para simplificar la view, unifico los datos de padron y total
                $data['carrera'] = $datos_total[0]['carrera'];
                $data['d_carrera'] = $datos_total[0]['d_carrera'];                
                $data['carrera2'] = null;
                $data['d_carrera2'] = ''; 
                $data['carrera3'] = null;
                $data['d_carrera3'] = ''; 
                $data['carrera4'] = null;
                $data['d_carrera4'] = ''; 
                $data['carrera5'] = null;
                $data['d_carrera5'] = ''; 
                $data['dni'] = $datos_total[0]['dni'];  
                $data['apellido'] = $datos_total[0]['apellido'];  
                $data['nombre'] = $datos_total[0]['nombre'];  
                $data['sancion']='F';
                $data['calidad']='En Total '.ANIO_TOTAL.' ';
                $data['d_nacionalidad']=$datos_total[0]['d_nacionalidad']; // VER EN MODELO
                $data['cuil'] = '';  // El total no tiene cuil
                $data['fecha_naci'] = (($datos_total[0]['fecha_naci'] != '') && ($datos_total[0]['fecha_naci'] != '0000-00-00')) ?date("d/m/Y", strtotime($datos_total[0]['fecha_naci'])):'';   
                $data['condicion'] = $datos_total[0]['condicion'];  
                $data['cuating'] = 1;  // El total no tiene cuating
                $data['sexo'] = ($datos_total[0]['sexo'] == 'F' ? 'Femenino' : ($datos_total[0]['sexo'] == 'M' ? 'Masculino' : ''));
                $data['regular'] = 'Si';
                $data['baja'] = 'No';

            $novedades = array();
            if (count($datos_total) > 0) {
                $total['msg_presencial'] = '';
 /*               if (!(isset($datos_total[0]['presencial'])) or (is_null($datos_total[0]['presencial']))) { 
                $total['sede1'] = $datos_total[0]['sede1']; 
                $total['sede2'] = $datos_total[0]['sede2']; 
                $total['d_sede1'] = $datos_total[0]['d_sede1']; 
                $total['d_sede2'] = $datos_total[0]['d_sede2']; 
                $total['turno1'] = $datos_total[0]['turno1']; 
                $total['turno2'] = $datos_total[0]['turno2']; 
                $total['d_turno1'] = $this->d_turno($datos_total[0]['turno1']);  
                $total['d_turno2'] = $this->d_turno($datos_total[0]['turno2']);  
                $data['debe'] = $datos_total[0]['debe'];
                $data['presenta'] = ($datos_total[0]['presenta'] == 1 ? 'Si' : ($datos_total[0]['presenta'] == '0' ? 'No' : '-'));
                $data['trabaja'] = ($datos_total[0]['trabaja'] == 1 ? 'Si' : ($datos_total[0]['trabaja'] == '0' ? 'No' : '-'));
                $data['paquete'] = $datos_total[0]['paquete'];
                for ($i = 1; $i<= 9; $i++) {
                    if (($datos_total[0]['AXXI'.$i] != '') && ($datos_total[0]['AXXI'.$i] != 0)) {
                        $novedades []= array("materia" => $datos_total[0]['AXXI'.$i],"d_novedad"=> 'Declara aprobada por UBAXXI',"cuat" => 0);
                    }
                }

                
            } else {
                $total = array();
            }

            $data['clave'] = $clave;
            $data['total'] = $total;
        }
        $data2['titulo_menu'] = 'Consulta de Alumnos';
        $data2['permisos'] = $this->permisos;
        $this->load->view('menu.php',$data2);
        $this->load->view('grilla_total_view', $data);
        return;*/
    }
    // Si hay no dni ingresado y no hay clave, es porque toco buscar pero no ingreso datos a buscar
    else 
    {
        $datos = array();
    }
    $data['alumnos'] = $datos;
    $data2['titulo_menu'] = 'Consulta de Padron Actual';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('grilla_total_view', $data);
}

}