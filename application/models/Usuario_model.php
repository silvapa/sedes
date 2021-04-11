<?php
class Usuario_model extends CI_Model {

 // var $array_estado_usuarios;

  public function __construct() {
      parent::__construct();
//      $this->load->dbforge(); 
 //     $this->array_estado_usuarios = array( "P"  => "Pendiente", "O"  => "Observado", "A" => "Aprobado", "R" => "Rechazado", "I" => "Inactivo", "E" => "Activacion pendiente");    
  }

  public function usuario_por_login($login,$contrasena){
    $this->db->select('id_usuario, sede, d_usuario as nombre');
    $this->db->from('usuarios');
    $this->db->where('login', $login);
    $this->db->where('password', $contrasena);
    $this->db->where('activo', 1);
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  
  public function Get_Usuarios($where, $cuantos){
  $select = "SELECT id_usuario,c.login,password,sede,d_usuario,email,activo,case when activo = 1 then 'Activo' else 'Inactivo' end as d_activo FROM usuarios c ";    
  if ($where != '') {
    $select = $select ."  where ".$where;
  }    
  $select = $select ." order by d_usuario ";
  if ($cuantos > 0) {
    $select = $select ." limit ".$cuantos;
  }    
  $query = $this->db->query($select);
  $result = $query->result_array();
  return $result;
}  

public function usuario_repetido($email, $user_id){
  $query = $this->db->query("SELECT d_usuario as nombre ".
  "FROM usuarios where lower(email) = '".strtolower($email)."' and id_usuario <> ".$user_id);
  $resultado = $query->result();
  return (!empty($resultado));
}

public function usuario_login_repetido($login, $user_id){
  $query = $this->db->query("SELECT d_usuario as nombre ".
  "FROM usuarios where upper(login) = '".strtoupper($login)."' and id_usuario <> ".$user_id);
  $resultado = $query->result();
  return (!empty($resultado));
}

public function usuario_nombre_repetido($d_usuario, $user_id){
  $query = $this->db->query("SELECT d_usuario as nombre ".
  "FROM usuarios where upper(d_usuario) = '".strtoupper($d_usuario)."' and id_usuario <> ".$user_id);
  $resultado = $query->result();
  return (!empty($resultado));
}

public function insertar_roles($id_usuario, $lista_roles){
  $query = $this->db->query("INSERT INTO usuario_rol ( id_usuario, id_rol) ".
  " (select ".$id_usuario.", id_rol from roles where id_rol in (".$lista_roles."))");
  return $this->db->query($query);
}

public function actualizar_roles($id_usuario, $lista_roles){
  $query = "delete from usuario_rol where id_usuario = ".$id_usuario;
  if ($lista_roles != '') {
    $query =  $query . " and id_rol not in (".$lista_roles.")";
  }
  $resultado = $this->db->query($query);
  if ($lista_roles != '') {
    $query = "INSERT INTO usuario_rol ( id_usuario, id_rol) ".
    " (select ".$id_usuario.", id_rol from roles where id_rol in (".$lista_roles.") ".
    " and id_rol not in (select id_rol from usuario_rol where id_usuario = ".$id_usuario."))";
    $resultado = $this->db->query($query);
  }
  return $resultado;
}


function insertar_usuario($usuario) {
  $data = array(
        'd_usuario' => $usuario['d_usuario'],
        'login' => $usuario['login'],
        'password' => $usuario['password'],
        'sede' => $usuario['sede'],
        'activo' => $usuario['activo'],
        'email' => $usuario['email']
  );
  $this->db->insert('usuarios', $data); 
  $insert_id = $this->db->insert_id(); 
  return $insert_id;
}
  
function actualizar_usuario($usuario) {
  $data = array(
        'd_usuario' => $usuario['d_usuario'],
        'login' => $usuario['login'],
        'password' => $usuario['password'],
        'sede' => $usuario['sede'],
        'activo' => $usuario['activo'],
        'email' => $usuario['email']
  );
  $this->db->where('id_usuario',  $usuario['id_usuario']);
  return $this->db->update('usuarios', $data);  
}


  public function cuat_actual(){
    $this->db->select('cuat_actual');
    $this->db->from('configuracion');
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }

 

  function getNombreSede($sede)
  { if ($sede) {      
      $query = $this->db->query("select descripcion from sedes where sede = ".$sede); 
      $result = $query->result_array();
      $row = $result[0];
      return $row['descripcion'];
    }
    else { return '';}
  }


  public function getPermisos($usuario){
    if (isset($usuario) && ($usuario != '')) {
/*      $query = $this->db->query("select concat(p.id_aplicativo,permiso) as appermiso from permisos p, aplicativos a 
      where a.id_aplicativo = p.id_aplicativo and a.activo = 1 and id_usuario = ".$usuario);
*/
      $query = $this->db->query("select distinct concat(p.id_aplicativo,p.permiso)  as appermiso
      from usuario_rol r, rol_permiso p, aplicativos a  
      where a.id_aplicativo = p.id_aplicativo and p.id_rol = r.id_rol and a.activo = 1 and id_usuario = ".$usuario);

      $result = $query->result_array();

    } else {
      $result = array();
    }
    
    return $result;
  }
  
  public function get_Roles($usuario,$ambito){
    if (isset($usuario) && ($usuario != '')) {
      $query = $this->db->query("select r.d_rol,r.id_rol,
      (select count(*) from usuario_rol u where u.id_rol = r.id_rol and u.id_usuario = ".$usuario.") as habilitado ".
      " from roles r where id_ambito = ".$ambito);
      $result = $query->result_array();
    } else {
      $result = array();
    }
    return $result;
  }
  
 public function usuario_datos ($user_id){
    $this->db->select('user_id, email, username as nom, password as pass, state as estado, profile, city, country_id as country, ocupacion, notes as notas, nombre_empresa, users.condition, accesos_pactados, dias_de_prueba, version');      
    $this->db->from('users');
    $this->db->where('user_id', $user_id);
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
 }

 public function get_id_usuario_por_nombre_mail($nom,$email){
    $this->db->select('user_id, email, username as nom, password as pass, state as estado, profile, city, country_id as country, ocupacion, notes as notas, nombre_empresa, users.condition, accesos_pactados, dias_de_prueba, version');  
    $this->db->from('users');
    $this->db->where('username', $nom);
    $this->db->where('email', $email);
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
 }
 public function usuario_por_email_contrasena($email, $contrasena){
    $this->db->select('user_id, email, username as nom, password as pass, state as estado, profile, city, country_id as country, ocupacion, notes as notas, nombre_empresa, users.condition, accesos_consumidos, accesos_pactados, dias_de_prueba, DATE(f_state) as f_state, DATEDIFF(SYSDATE(),f_state ) as dias_transcurridos, version');
    $this->db->from('users');
    $this->db->where('email', $email);
    $this->db->where('password', $contrasena);
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
 }

 public function usuario_por_mail($email){
    $this->db->select('username as nombre, state as estado, password as pass');
    $this->db->from('users');
    $this->db->where('email', $email);
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
 }


 public function usuario_repetido_version($email, $version_solicitada){
      $query = $this->db->query("SELECT state as estado, version FROM users where email = '".$email."'");
      $resultado = $query->result();
      if ((!($resultado)) or (empty($resultado))) {
        return '';
      } 
      else
      { $row = $resultado[0];
        $estado = $row->estado;
        $version = $row->version;
        // Si el usuario existe, ya era demo y solicita version lo permito
        if (($version == 'D') and ($version_solicitada == 'U')) {
          return 'cambio_version';
        } 
        else
        {
          switch ($estado) {
            case 'P':
                if ($version == 'D') {
                  return 'reenviar_mail';
                }
                else {
                  return 'Tu mail ya esta asociado a una solicitud de registro pendiente de aprobación';
                }
                break;
            case 'E':
                if ($version == 'D') {
                  return 'reenviar_mail';
                }
                else {
                  return 'Tu mail ya esta asociado a una solicitud de registro pero aun no activo su cuenta';
                }
                break;
            case 'A':
                return 'Tu mail ya esta asociado a un usuario';
                break;
            case 'R':
                return 'Tu mail ya esta asociado a una solicitud de registro que fue rechazada';
                break;
          }
        }         
     }
 }
  function insertar_usuario_inicial($nombre,$email,$password,$profile,$version) {
    $data = array(
          'username' => $nombre,
          'email' => $email,
          'password' => $password,
          'state' => 'P',
          'profile' => $profile,
          'version' => $version,
          'accesos_pactados' => 0,
          'dias_de_prueba'  => 0
    );
    if ($version == 'D') {
      $a_demo = $this->get_demo_default ();
      if ($a_demo) {
        $data['accesos_pactados'] = $a_demo->accesos_pactados;
        $data['dias_de_prueba'] = $a_demo->dias_de_prueba;
      }
    }
    return $this->db->insert('users', $data);  
  }  


function registrar_default_mensaje($mensaje, $t_mensaje) {
    $this->db->trans_start();
    $data = array(
          'mensaje' => $mensaje
    );
    $this->db->update('mensajes', $data);  
    $this->db->where('t_mensaje', $t_mensaje);  
//      return $this->db->affected_rows();
    $this->db->trans_complete();
    return ($this->db->trans_status() === TRUE);
  }    

function registrar_default_demo($accesos_pactados, $dias_de_prueba) {
    $this->db->trans_start();
    $data = array(
          'accesos_pactados' => $accesos_pactados,
          'dias_de_prueba' => $dias_de_prueba
    );
    $this->db->update('demo', $data);  
//      return $this->db->affected_rows();
    $this->db->trans_complete();
    return ($this->db->trans_status() === TRUE);
  }    
 function inc_accesos_usuario ($user_id) {
    $this->db->set('accesos_consumidos', 'accesos_consumidos + 1', FALSE);
    $this->db->where('user_id', $user_id);  
    return $this->db->update('users');  
  }    


function cambiar_version($nombre,$email,$password,$profile,$version) {
    $data = array(
          'username' => $nombre,
          'password' => $password,
          'state' => 'P',
          'profile' => $profile,
          'version' => $version,
          'accesos_consumidos' => 0,
          'accesos_pactados' => 0,
          'dias_de_prueba'  => 0
    );
    $this->db->where('email', $email);  
    return $this->db->update('users', $data);  
  }  

 function modificar_usuario_datos($nombre,$email,$password,$city,$country,$ocupacion,$user_id,$nombre_empresa,$condition) {
/*    $language = ($language != "") ? $language : $this->session->userdata('site_lang',0,1);*/
    $data = array(
          'username' => $nombre,
          'email' => $email,
          'password' => $password,
          'city' => $city,
          'country_id' => $country,
          'ocupacion' => $ocupacion,
          'nombre_empresa' => $nombre_empresa,
          'condition' => $condition
    );
    $this->db->where('user_id', $user_id);  
    return $this->db->update('users', $data);  
  }    


 function modificar_usuario_datos_registro($nombre,$email,$password,$profile,$city,$country,$notas,$nombre_empresa,$user_id) {
    /*$language = ($language != "") ? $language : $this->session->userdata('site_lang',0,1);*/
    $data = array(
          'username' => $nombre,
          'email' => $email,
          'password' => $password,
          'profile' => $profile,
          'city' => $city,
          'country_id' => $country,
          'nombre_empresa' => $nombre_empresa,
          'notes' => $notas
    );
    $this->db->where('user_id', $user_id);  
    return $this->db->update('users', $data);  
  }    


 function insertar_usuario_datos($nombre,$email,$password,$profile,$city,$country,$ocupacion,$notas) {
/*      $language = ($language != "") ? $language : $this->session->userdata('site_lang',0,1);*/
    $data = array(
          'username' => $nombre,
          'email' => $email,
          'password' => $password,
          'state' => 'P',
          'profile' => $profile,
          'city' => $city,
          'country_id' => $country,
          'ocupacion' => $ocupacion,
          'notes' => $notas
    );
    return $this->db->insert('users', $data);  
  }  


  public function cambiar_estado($id_user,$estado,$sid){
/*      $this->db->set('state',$estado);
      $this->db->where('user_id', $id_user);
      $this->db->update('users');     
      return $this->db->affected_rows();      */
      $this->db->trans_start();
      $datos = array(
              'state' => $estado
              );
      $this->db->set('f_state', 'NOW()', FALSE);
      if ($sid != '') {
        $this->db->set('sid', $sid, FALSE);
      }
      $this->db->where('user_id', $id_user);
      $this->db->update('users',$datos);
      $todo_ok = ($this->db->affected_rows() == '1');
      $this->db->trans_complete();
      $todo_ok = ($todo_ok) and ($this->db->trans_status() === TRUE);    
      return $todo_ok;  
   }

}