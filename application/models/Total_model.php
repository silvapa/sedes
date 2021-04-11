<?php
class Total_model extends CI_Model {

  public function __construct() {
      parent::__construct();
  }


  public function R_constancias($sede,$dde,$hta){
    $this->db->select('apellido,nombre,dni,'.
    'rcondicion,rtrabaja,debe,presenta,'.
    'f_modif,d_usuario ');
    $this->db->from('total');
    $this->db->join('usuarios','total.id_usuario = usuarios.id_usuario');
    $this->db->where('usuarios.sede = '.$sede);
    $this->db->where("f_modif >= str_to_date('".$dde."', '%d-%m-%Y')");
    $this->db->where("f_modif < str_to_date('".$hta."', '%d-%m-%Y')");
    return $this->db->get();
   }

/*  public function R_constancias($sede){
    $query = $this->db->query('select apellido,nombre,dni,'.
    'rcondicion,rtrabaja,debe,presenta,'.
    'presencial,f_modif,login '. 
    ' from total t left join usuarios u on t.id_usuario = u.id_usuario '.
    ' where u.sede = '.$sede);
    $result = $query->result_array();
//    return $this->db->get();
    return $result;
  }*/
      
  public function Total_por_dni($dni){
//    $this->db->select('anio,clave,apellido,nombre,dni,carrera,sede1,turno1,sede2,turno2,'.
    $this->db->select('apellido,nombre,dni,carrera,sede1,turno1,sede2,turno2,'.
    'trabaja,rtrabaja,condicion,rcondicion,debe,presenta,optapor,'.
    '(select nombre from carreras where carrera = total.carrera) as d_carrera,'.
    '(select descripcion from sedes where sede = total.sede1) as d_sede1,'.
    '(select descripcion from sedes where sede = total.sede2) as d_sede2,'.
    "case when total.nacionalid is null then '' else (select descripcion from paises where codigo = total.nacionalid) end as d_nacionalidad , ".
    'presencial ');
    $this->db->from('total');
    $this->db->where('dni = '. $dni);
    $query = $this->db->get();
    return $query->result_array();
  }
  
//  public function RegistrarConstancia($anio,$clave,$rtrabaja,$rcondicion,$usuario){
    public function RegistrarConstancia($dni,$rtrabaja,$rcondicion,$presenta,$usuario){    
    $this->db->trans_start();
    $data = array(
          'rtrabaja' => $rtrabaja,
          'rcondicion' => $rcondicion,
          'presenta' => $presenta,
          'id_usuario' => $usuario
    );
    $this->db->set('f_modif', 'NOW()', FALSE);
    $this->db->where('dni', $dni);  
/*    $this->db->where('anio', $anio);  
    $this->db->where('clave', $clave);  */
    $this->db->update('total', $data);  
    $todo_ok = ($this->db->affected_rows() == '1');
    $this->db->trans_complete();
    $todo_ok = ($todo_ok) and ($this->db->trans_status() === TRUE);    
    return $todo_ok;
  }
  

}