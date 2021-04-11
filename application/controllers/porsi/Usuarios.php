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

/*public function mostrar_form_home(
     
  $this->load->view('usuarios/home
     
  $this->load->view('footer.php');
     
  $this->load->view('usuarios/footer_usuarios');
}

public function iniciar_sesion_admin() {
  $data = array();
  $data['error'] = '';
  $data['login'] = '';
  $data['password'] = '';  
  $data['admin'] = true;  
  $this->mostrar_form_iniciar_sesion($data);
}
*/
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


public function logout() {
      $this->LimpiarSesion();
      $this->session->sess_destroy();
      redirect(base_url());
    }    

 
}