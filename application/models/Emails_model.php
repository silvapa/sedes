<?php
class Emails_model extends CI_Model {

  public function __construct() {
      parent::__construct();
  }

   public function ExisteEmail($email){
    $mail = $this->db->escape($email);
    $select = "select count(*) as cantidad from alumno_mail where email=$mail";
    $query = $this->db->query($select);
    $result = $query->result_array();
    return intval($result[0]['cantidad']);
   }


   public function ExisteAlumno($anio, $clave){
    $select = "select count(*) as cantidad from alumno_mail where anio=$anio and clave=$clave";
    $query = $this->db->query($select);
    $result = $query->result_array();
    return intval($result[0]['cantidad']);
   }

   private function getControl($anio, $clave){
      return md5(strval($anio).strval($clave).date('Y-m-d'));
   }

   public function RegistrarEmail($anio, $clave, $email, $usuario){    
    $this->db->trans_start();
    $control = $this->getControl($anio, $clave);
    $mail = $this->db->escape($email);

    $data = array(
          'anio' => $anio,
          'clave' => $clave,
          'email' => $mail,
          'control' => $control,
          'id_usuario' => $usuario
    );
    $this->db->set('f_modif', 'NOW()', FALSE);
    if ($this-> ExisteAlumno($anio, $clave)) {
      $this->db->where('anio', $anio);  
      $this->db->where('clave', $clave); 
      $this->db->update('alumno_mail', $data); 
    }else{ 
       $this->db->insert('alumno_mail', $data);  
    }
    $todo_ok = ($this->db->affected_rows() == '1');
    $this->db->trans_complete();
    $todo_ok = ($todo_ok) and ($this->db->trans_status() === TRUE);    
    return $todo_ok;
  }
  
  public function Get_Alumno_por_dni($dni){
    $select = "select a.anio, a.clave, a.apellido, a.nombre, a.dni, a.carrera, a.titulo as condicion from padron a, alumno_sin_mail b where a.dni=$dni and a.anio=b.anio and a.clave=b.clave";
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }

  public function Get_Carrera($carrera){
    $select = "select nombre from carreras where carrera=$carrera";
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }


}