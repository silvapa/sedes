<?php
if (!defined('BASEPATH'))
   exit('No direct script access allowed');
   
class Usuarios extends CI_Controller {
   public function __construct() {
      parent::__construct();
      $this->load->model('Usuario_model');
/*      $this->load->model('cultivar_model');*/
      $this->load->library('form_validation');       
      $this->session->set_userdata('user_lang','es');
      $this->form_validation->set_rules('login','login','required|trim');
      $this->form_validation->set_rules('contrasena','contraseña','required|trim');
      $this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
      /*   $this->config->set_item('language', IDIOMA_DEFAULT);*/
      date_default_timezone_set("America/Argentina/Buenos_Aires");
   }

public function index() {
  $this->iniciar_sesion();
}

/*public function admin() {
  $this->iniciar_sesion_admin();
}*/

function LimpiarSesion() {
  $this->session->unset_userdata('usuario_id');
  $this->session->unset_userdata('error');
  $this->session->unset_userdata('logueado');
  $this->session->unset_userdata('cuat_actual');
}

/*public function iniciar() {
  $this->mostrar_form_home();
}*/

public function iniciar_sesion() {
  $data = array();
  $data['error'] = '';
  $data['login'] = '';
  $data['password'] = '';  
  $data['admin'] = false;  

  $this->mostrar_form_iniciar_sesion($data);

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
	$data['usuarios'] = $datos;
  $data2['permisos'] = $this->permisos;
	$data2['titulo_menu'] = 'Consulta de Usuarios';
	$this->load->view('menu.php',$data2);
	$this->load->view('usuario_view.php',$data);
}

public function obtener_where_usuario($sede, $d_usuario, $login, $email, $activo) {  
  $where = '';
  if ($sede != '') {
      $where = ' sede = '.$sede;
  } 
  if ($login != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' login = "'.$login.'"';
  }	
  if ($activo != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' activo = '.$activo;
  }	
  if ($d_usuario != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' d_usuario like "'. $d_usuario . '%"';
  }	
  if ($email != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' email like "'. $email . '%"';
  }
  return $where;
} 

public function Nuevo(){
  $roles =  $this->Usuario_model->Get_Roles(-1,1); 
  $usuario = array();
  $data['error'] = '';
  $usuario['id_usuario'] = -1;
  $usuario['activo'] = 1;
  $data['tab_activa'] = 1;
  $data2['titulo_menu'] = 'Usuarios (Nuevo)';
  $data2['usuario'] = $usuario;
  $data2['roles'] = $roles;
  $data2['permisos'] = $this->permisos;
  $this->load->view('menu.php',$data2);
  $this->load->view('usuarios/registro_user_datos_view', $data);
  return;
}

public function Usuarios_post() {  
	
	if ($this->input->post())  {
    $login = $this->input->post('login');
    $d_usuario = $this->input->post('d_usuario');
    $sede  = $this->input->post('sede');
    $email = $this->input->post('email');
    $activo  = $this->input->post('activo');
    $data2['titulo_menu'] = 'Consulta de Usuarios';
    $data2['permisos'] = $this->permisos;
    $data['error'] = '';
    $data['mensaje'] = '';
    $w_usuario =  $this->obtener_where_usuario($sede, $d_usuario, $login, $email, $activo);
    $datos = $this->Usuario_model->Get_Usuarios($w_usuario,-1);  
    // Si no hay alumnos, debo informar error y mostrar solo los criterios de busqueda
    // Si hay mas de un alumno, debo mostrar la grilla para que elija
    if ((count($datos) == 0) or (count($datos) > 1)) { 
        if (count($datos) == 0) { 
            $data['error'] = 'Usuario no encontrado';
        } 
/*            $cuantos = count($datos);
        for ($i = 0; $i < $cuantos;$i++ ) { 
            $datos[$i]['email'] = mb_convert_encoding($datos[$i]['email'], "UTF-8", "iso-8859-1"); 
            $datos[$i]['activo'] = mb_convert_encoding($datos[$i]['activo'], "UTF-8", "iso-8859-1"); 
        }*/
        $data['esgrilla'] = 'S';			
        $data['usuarios'] = $datos;
        $this->load->view('menu.php',$data2);
        $this->load->view('usuario_view', $data);
        return;
    }
    else 
    {   $id_usuario = $datos[0]['id_usuario'];
        $roles =  $this->Usuario_model->Get_Roles($id_usuario,1); 
        $data['usuario'] = $datos[0];
        $data['roles'] = $roles;
        $data['tab_activa'] = 1;
        $data2['titulo_menu'] = 'Consulta de Usuarios';
        $data2['permisos'] = $this->permisos;
        $this->load->view('menu.php',$data2);
        $this->load->view('usuarios/registro_user_datos_view', $data);
        return;
    }
  }
  // Si hay no dni ingresado y no hay d_usuario, es porque toco buscar pero no ingreso datos a buscar
  else 
  {
    $datos = array();
    $data['usuarios'] = $datos;
    $data2['titulo_menu'] = 'Consulta de Usuarios';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('usuario_view', $data);
  }
}

public function mostrar_form_iniciar_sesion($data) {
//  $this->LimpiarSesion();
  $this->load->view('header_basico.php',Array("t_estilo_navbar" =>  'navbar-top'));
  $this->load->view('usuarios/iniciar_sesion', $data);
  $this->load->view('footer.php');
  $this->load->view('usuarios/footer_usuarios');
}


public function iniciar_sesion_post() {
  if ($this->input->post()) 
  { 
    //SI ALGO NO HA IDO BIEN NOS DEVOLVERÁ AL INDEX MOSTRANDO LOS ERRORES
    if ($this->form_validation->run()==FALSE) {
      $data['admin'] = false;
      $data['error'] = validation_errors();
      $data['login'] = $this->input->post('login');
      $this->security->xss_clean($data) ;
      $this->mostrar_form_iniciar_sesion($data);
    } 
    else 
    {
      $login = $this->input->post('login');
      $contrasena = $this->input->post('contrasena');
      $usuario = $this->Usuario_model->usuario_por_login($login, $contrasena);
      $cuat = $this->Usuario_model->cuat_actual();
      $error_usuario = false;
      if ($usuario) {
              $usuario_data = json_decode(json_encode($usuario), True);
              $xcuat = json_decode(json_encode($cuat), True);
              $cuat_actual = $xcuat['cuat_actual'];
              $nom_sede = $this->Usuario_model->getNombreSede($usuario_data['sede']);
//              $usuario_data['pass2'] = $contrasena;
              $this->session->set_userdata('usuario_id',$usuario_data['id_usuario']);
              $this->session->set_userdata('sede',$usuario_data['sede']);
              $this->session->set_userdata('nombre',$nom_sede);
              $this->session->set_userdata('logueado',true);
              $this->session->set_userdata('cuat_actual',$cuat_actual);
              $this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
              redirect('Main/principal');  
      }
      else 
      {
          $error_usuario = true;
          $this->session->set_userdata('logueado',false);          
          $data['error'] = 'Revisa los datos ingresados.';
          $this->mostrar_form_iniciar_sesion($data);
      }
    }
  }
  else 
  { redirect('usuarios/iniciar_sesion');  
  }
}

public function iniciar_sesion_admin_post() {

  if ($this->input->post()) 
  {
    //SI ALGO NO HA IDO BIEN NOS DEVOLVERÁ AL INDEX MOSTRANDO LOS ERRORES
    if ($this->form_validation->run()==FALSE) {
      $data['admin'] = true;
      $data['error'] = validation_errors();
      $data['email'] = $this->input->post('email');
      $this->mostrar_form_iniciar_sesion($data);
    } 
    else 
    {
      $estado = ' ';
      $email = $this->input->post('email');
      $contrasena = $this->input->post('contrasena');
      $usuario = $this->usuario_model->usuario_por_email_contrasena($email, $contrasena);
      $error_usuario = false;
      if ($usuario) {

        $estado = $usuario->estado;

        if ($estado == 'A') 
        {
          if ($usuario->profile == 'D') {
            $error_usuario = true;
            $data['error'] = 'No está autorizado a utilizar este módulo del sistema.';
          } 
          else /* si tiene accesos disponibles */
          {
            $usuario_data = json_decode(json_encode($usuario), True);
            $usuario_data['pass2'] = $contrasena;

            $this->session->set_userdata('logueado',TRUE);
            $this->session->set_userdata('perfil_activo', $usuario->profile);
            $this->session->set_userdata('developer_id',$usuario_data['user_id']);
            $this->session->set_userdata('version','U');
            redirect('Admin/principal');  

          }
        }
        else /* si no esta aprobado */
        {
          $error_usuario = true;
          switch ($estado) {
              case 'P':
                  $data['error'] = 'Tu mail ya está asociado a una solicitud de registro pendiente de aprobación.';
                  break;
              case 'E':
                  $data['error'] = 'Tu mail ya está asociado a una solicitud de registro pero aun no activo su cuenta.';
                  break;
              case 'R':
                  $data['error'] = 'Tu mail ya está asociado a una solicitud de registro que fue rechazada.';
                  break;
          }         
        }
      }
      else 
      {
          $error_usuario = true;
          $data['error'] = 'Revisa los datos ingresados.';
      }
      if ($error_usuario) {
        $data['email'] = $email;
        $data['admin'] = true;
        $this->mostrar_form_iniciar_sesion($data);
      }
    }
  }
  else 
  {
    redirect('usuarios/iniciar_sesion_admin');  
  }
}


  

/*   public function logueado() {
      if($this->session->userdata('logueado')){
         $data = array();
         $datos_usuario = $this->session->userdata('user_data');
         $data['nombre'] = $datos_usuario['nom'];
        $this->load->view('header.php',Array("t_app_title" => $this->lang->line("app_title"),"t_estilo_navbar"  =>  'navbar-top'));
             $this->load->view('usuarios/logueado', $data);
        $this->load->view('footer.php',Array("t_app_footer" => $this->lang->line("app_footer"),"t_contacto" => $this->lang->line("contacto")));         
      }else{
//         redirect('usuarios/iniciar_sesion');
        $this->load->view('header.php',Array("t_app_title" => $this->lang->line("app_title"),"t_estilo_navbar"  =>  'navbar-top'));
        $this->load->view('usuarios/iniciar_sesion', $data);
        $this->load->view('footer.php',Array("t_app_footer" => $this->lang->line("app_footer"),"t_contacto" => ''));
        $this->load->view('usuarios/footer_usuarios');

      }
   }*/

   public function cerrar_sesion() {
      $this->LimpiarSesion();
      $data = array();
      $this->load->view('header_basico.php',Array("t_estilo_navbar"  =>  'navbar-top'));
      $this->load->view('usuarios/iniciar_sesion', $data);
      $this->load->view('footer.php');
      $this->load->view('usuarios/footer_usuarios');

   }



public function verificar_login($user_id,$sid)
{
  $mensaje_error = '';
  $todo_ok = $this->usuario_model->cambiar_estado($user_id,'A',$sid);    
  $usuario = $this->usuario_model->usuario_datos ($user_id);
  $data['t_exit']= 'Aceptar';

  if ($todo_ok) {
        $data['titulo'] = 'Bienvenido'; 
//        $error = 'Correctamente registrado';

      if ($usuario->version == 'D') {
        if ((!($usuario->dias_de_prueba)) or ($usuario->dias_de_prueba < 0)) {
          $error = 'Con el fin de poder evaluar la aplicación, dispondrás de '.$usuario->accesos_pactados.' consultas a la Biblioteca de RindEs';
        } else {
          $error = 'Con el fin de poder evaluar la aplicación, dispondrás de '.$usuario->accesos_pactados.' consultas a la Biblioteca de RindEs a utilizar dentro de los próximos '.$usuario->dias_de_prueba.' días.';          
        }  
      } 
      else {
        if ((!($usuario->dias_de_prueba)) or ($usuario->dias_de_prueba < 0)) {
          $error = 'A partir de este momento, dispondrás de '.$usuario->accesos_pactados.' consultas a la Biblioteca de RindEs';
        } else {
          $error = 'A partir de este momento, dispondrás de '.$usuario->accesos_pactados.' consultas a la Biblioteca de RindEs a utilizar dentro de los próximos '.$usuario->dias_de_prueba.' días.';          
        }  
      } 
    }
    else
    {
        $data['titulo'] = 'Activación de cuenta'; 
        $error = "Lo sentimos! No fue posible verificar tu email!".
        '<br><br>Si deseas contactarnos, puedes enviar un mail a rindes@cultivaragro.com.ar y te responderemos a la brevedad.';
        $data['t_exit']= 'Salir';
    }
    $data['nom'] = '';
    $data['texto'] = $error; 
    $this->load->view('header_basico',Array("t_estilo_navbar"  =>  'navbar-top'));
    $this->load->view('usuarios/aviso_view', $data);          
    $this->load->view('footer.php');
}

public function cargar_post_en_array() {
	$arr_post = array(
		   'id_usuario' => $this->input->post('id_usuario'),
		   'd_usuario' => $this->input->post('d_usuario'),
		   'login' => $this->input->post('login'),
		   'password' => $this->input->post('pass'),
		   'sede' => $this->input->post('sede'),
		   'email' => $this->input->post('email'),
       'activo' => $this->input->post('activo'),
       'lista_roles'=> $this->input->post('lista_roles')
  );
  return $arr_post;
}


public function Registro_post() {  
  if ($this->input->post())  {
    $datos = $this->cargar_post_en_array();
    $id_usuario = $datos['id_usuario'];
    $data['error'] = '';
    if ($this->Usuario_model->usuario_nombre_repetido($datos['d_usuario'],$id_usuario)) { 
      $data['error'] = 'Error. Ya existe un usuario con el nombre ingresado';					
    } else {
      if ($this->Usuario_model->usuario_login_repetido($datos['login'],$id_usuario)) { 
        $data['error'] = 'Error. Ya existe un usuario con el login ingresado';					
      } else {
      if ($this->Usuario_model->usuario_repetido($datos['email'],$id_usuario)) { 
        $data['error'] = 'Error. Ya existe un usuario con el email ingresado';					
      }
    }
    }
    $lista_roles = $datos['lista_roles'];
    if ($data['error'] == '') {
      // Si el usuario ya existia es una actualizacion
      if ($id_usuario > 0) {
        $this->Usuario_model->actualizar_usuario($datos);
        $this->Usuario_model->actualizar_roles($id_usuario,$lista_roles);
      } else // Si el usuario no existia es una creacion
      {
        $id_usuario = $this->Usuario_model->insertar_usuario($datos);
        if ($lista_roles <> '') {
          $this->Usuario_model->insertar_roles($id_usuario,$lista_roles);
        }
      }
      $this->consultar();
      return;
    } else {
      $data['titulo_menu'] = 'Consulta de Usuarios';
      $data['roles'] = $lista_roles;
      $data['usuario'] = $datos;
      $data['tab_activa'] = 1;
      $data2['titulo_menu'] = 'Consulta de Usuarios';
      $data2['permisos'] = $this->permisos;
      $this->load->view('menu.php',$data2);
      $this->load->view('usuarios/registro_user_datos_view', $data);
      return;
    }
  } 
}


public function logout() {
      $this->LimpiarSesion();
      $this->session->sess_destroy();
      redirect(base_url());
    }    

 
}