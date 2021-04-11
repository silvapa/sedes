<?php
class Lectivo_model extends CI_Model {

  public function __construct() {
      parent::__construct();
  }

/*  public function Lectivo_por_dni($dni, $cuantos){
    $this->db->select('anio,clave,apellido,nombre,dni,carrera,condicion');
    $this->db->from('activos');
    $this->db->where('dni >= '. $dni);
    $this->db->limit($cuantos);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  public function Novedades_por_clave($anio,$clave){
    $query = $this->db->query("select o.novedad, o.descripcion  
     from lectivo o left join novedad e on o.novedad = e.codigo where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }

*/
  public function Observados_por_clave($anio,$clave){
    $query = $this->db->query("select o.estado, e.mostrar_asig, e.descripcion  
     from observados o left join estados e on o.estado = e.codigo where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }

  public function Rechazados_por_clave($anio,$clave){
    $query = $this->db->query("select o.estado, e.mostrar_asig, e.descripcion  
     from rechazados o left join estados e on o.estado = e.codigo where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }
  
  public function Asignacion_por_clave($anio,$clave,$cuat){
    //if ($cuat != -1) {
    //  $where = ' and c.cuat = '.$cuat;
    //}
    //else  {
      $where = '';
    //}
    $order_by = " order by cuat desc, sede, materia";

    $query = $this->db->query("select c.cuat,c.sede as sede, (select descripcion from sedes where sede = c.sede) as d_sede,
     c.materia, (select descripcion from materias where codigo = c.materia) as d_materia,
     c.horario, (select deschora from deschora where horario = c.horario) as d_horario, aula, 
     newcomi as comision, n.descripcion as d_novedad, catedra 
     from cursos c, lectivo l left join novedad n on l.novedad = n.codigo 
     where c.comision = l.curso and anio = ".$anio." and clave = ".$clave.$where.$order_by);

    $result = $query->result_array();
    return $result;
  }

/*  public function Datos_Padron($anio,$clave){
    $query = $this->db->query("select p.*, c.nombre as d_carrera, s.descripcion as d_nacionalidad 
    from padron p left join carreras c on p.carrera = c.carrera left join paises s on p.nacionalidad = s.codigo ". 
    " where p.anio = ".$anio." and p.clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }*/

  public function Datos_Padron($anio,$clave){
    $db2 = $this->load->database('sitacad', TRUE);
    $query = $db2->query("select p.cod_carrera as carrera, p.dni,p.apellido,p.nombre, 
        p.sancion,p.cuil, ltrim(str(dd_nac))+'/'+ltrim(str(mm_nac))+'/'+ltrim(str(aa_nac)) as fecha_naci,
        p.titulo,p.cuatin as cuating,p.sexo,case when regular = 1 then 'T' else 'F' end as regular,
        case when baja = 1 then 'T' else 'F' end as baja,
        c.descripcion as d_carrera, s.d_pais as d_nacionalidad,
        carrera2,
        carrera3,
        carrera4,
        carrera5,
        case when carrera2 is null then '' else (select descripcion from carreras where cod_carrera = carrera2) end as d_carrera2,  
        case when carrera3 is null then '' else (select descripcion from carreras where cod_carrera = carrera3) end as d_carrera3,  
        case when carrera4 is null then '' else (select descripcion from carreras where cod_carrera = carrera4) end as d_carrera4,  
        case when carrera5 is null then '' else (select descripcion from carreras where cod_carrera = carrera5) end as d_carrera5
        from padron p left join carreras c on p.cod_carrera = c.cod_carrera ".
        " left join rv_insc i on p.anio = i.anio and p.clave = i.clave 
          left join paises s on i.c_pais = s.c_pais ". 
        " where p.anio = ".$anio." and p.clave = ".$clave);
    $result = $query->result_array();
    $db2->close();      
    return $result;
}

  public function Get_historial($anio,$clave){
    $query = $this->db->query("select observacion from historial where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }

  public function Matriculado_Moodle($anio,$clave){
    $query = $this->db->query("select anio,clave,comision,estado from moodle where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }

  public function Cursa_XXI($anio,$clave){
    $query = $this->db->query("select cuat,materia from cursa_xxi where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }

  public function Pide_XXI($dni){
    $query = $this->db->query("select materia from pide_ubaxxi where dni = ".$dni);
    $result = $query->result_array();
    return $result;
  }

  public function Datos_Total($clave){
    $query = $this->db->query("select p.*, c.nombre as d_carrera, s.descripcion as d_nacionalidad,
    case when sede1 = 0 or sede1 is null then '' else (select descripcion from sedes where sede = p.sede1) end as d_sede1, 
    case when sede2 = 0 or sede2 is null then '' else (select descripcion from sedes where sede = p.sede2) end as d_sede2  
    from total p left join carreras c on p.carrera = c.carrera left join paises s on p.nacionalidad = s.codigo ". 
    " where p.clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }
  

  public function Get_Activos($where, $cuantos){
    $select = "select anio,clave,apellido,nombre,dni,carrera,condicion from activos ";
    if ($where != '') {
      $select = $select ."  where ".$where;
    }    
    if ($cuantos > 0) {
      $select = $select ." limit ".$cuantos;
    }    
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }

/*  public function Get_Alumnos($where_padron, $where_total, $cuantos){
    $select = "select anio,clave,apellido,nombre,dni,carrera,titulo as condicion from padron ";
    if ($where_padron != '') {
      $select = $select ."  where ".$where_padron;
    }    
    if ($where_total <> "false") {
      $select =  $select ." union select ".ANIO_TOTAL." as anio,clave,apellido,nombre,dni,carrera,condicion from total ";
      if ($where_total != '') {
        $select = $select ."  where ".$where_total;
      }    
    }
    if ($cuantos > 0) {
      $select = $select ." limit ".$cuantos;
    }    
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }
*/
  public function Get_Alumnos($where_padron, $where_total, $cuantos){
    $result1 = array();
    $result2 = array();
    $select = "select ";
    if ($cuantos > 0) {
      $select = $select ." top ".$cuantos;
    }    
        
    $select = $select . " anio,clave,apellido,nombre,dni,cod_carrera as carrera,titulo as condicion from padron ";
    if ($where_padron != '') {
      $select = $select ."  where ".$where_padron;
    }    
    
    $db2 = $this->load->database('sitacad', TRUE);
    $query = $db2->query($select);
    $result1 = $query->result_array();
    $db2->close();
 
    if ($where_total <> "false") {
      $select = "select ".ANIO_TOTAL." as anio,clave,apellido,nombre,dni,carrera,condicion from total ";
      if ($where_total != '') {
        $select = $select ."  where ".$where_total;
      }    
      if ($cuantos > 0) {
        $select = $select ." limit ".$cuantos;
      }    
      $query = $this->db->query($select);
      $result2 = $query->result_array();
    }
    $result = array_merge ($result2, $result1);

    $apellido  = array_column($result, 'apellido');
    $nombre = array_column($result, 'nombre');

  // Ordenar los datos con volumen descendiente, edición ascendiente
  // Agregar $datos como el último parámetro, para ordenar por la clave común
    array_multisort($apellido, SORT_ASC, $nombre, SORT_ASC, $result);

    return $result;
  }


  public function Get_Cursos($where, $cuat, $cuantos){
    $select = "SELECT newcomi as comision,materia,m.descripcion as d_materia,".
    "c.horario,deschora as d_horario,aula,nuevo as c_nuevos, cantidad as c_viejos, nuev2cuat as c_total, ".
    "c.catedra, c.id_campus, c.sede, c.cuat ".
    "FROM cursos c ".
    "left join sedes s on c.sede = s.sede ".
    "left join materias m on c.materia = m.codigo ".
    "left join deschora h on c.horario = h.horario";    
    if ($where != '') { 
       $where.= " c.cuat=".$cuat."  ";
    }

    if ($where != '') {
      $select = $select ."  where ".$where. " and newcomi <> 0 ";
    }    
    else {
      $select = $select ."  where newcomi <> 0 ";
    }    

    $select = $select ." order by 1 ";
    if ($cuantos > 0) {
      $select = $select ." limit ".$cuantos;
    }    

    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }  

  public function Get_Materias_Sede($sede,$cuat){
    // Falta agregar anuales cuando el cuat es 2
    $select = "SELECT * FROM materias WHERE codigo in (select materia from cursos where ";
    if ($sede != 3) {
      $select = $select." (sede = ".$sede.") and ";
    }
    $select = $select ." ((cuat = ".$cuat." and anual = 0) or (anual = 1))) order by codigo";
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }  

  public function Get_Alumnos_comision($cuat,$comision){
    $select = "SELECT apellido,nombre,dni FROM activos2 a, cursos c, lectivo l ".
    " WHERE a.anio = l.anio and a.clave = l.clave and c.comision = l.curso and c.newcomi = ".$comision ." and l.cuat = ".$cuat.
    " order by 1,2,3";
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }
  
  public function Get_cabecera_comision($cuat,$comision){
      $select = "SELECT c.sede,s.descripcion as d_sede,materia,m.descripcion as d_materia, ".
      "c.horario,deschora as d_horario,aula ".
      "FROM cursos c ".
      "left join sedes s on c.sede = s.sede ".
      "left join materias m on c.materia = m.codigo ".
      "left join deschora h on c.horario = h.horario ".
      " WHERE c.newcomi = ".$comision ." and c.cuat = ".$cuat;
      $query = $this->db->query($select);
      $result = $query->result_array();
      return $result;
    }
}