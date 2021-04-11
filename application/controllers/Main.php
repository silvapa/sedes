<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {

    function __construct()
    {
        parent::__construct();

     if ( ! ($this->session->userdata('logueado')))
        { 
            redirect('usuarios/iniciar_sesion');
        }
    else 
        {
        $this->load->model('Usuario_model');
//        $this->load->library('grocery_CRUD');
        $this->load->library('form_validation');
        $this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
        }   
    }
 
public function index() {
    echo "<h1>".APP_TITLE."</h1>";
  die();
}

public function principal() {   
	$data['nombre'] = $this->session->userdata('nombre');
  $data['titulo_menu'] = APP_TITLE;
  $data['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data);
	$this->load->view('principal.php');
	$this->load->view('footer.php');
  }        
  
  public function signup() {
	$this->load->view('header.php',Array("t_estilo_navbar"  =>  'navbar-top'));
  }        

  
}
