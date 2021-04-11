<?php
class AltaBaja_model extends CI_Model {

  public function __construct() {
      parent::__construct();
  }

  public function Get_Alumno_por_dni($dni){
    $select = "select * from padron where dni=".$dni;
    $db2 = $this->load->database('sitacad', TRUE);
    $query = $db2->query($select);
    $result = $query->result_array();
    $db2->close();
/*
    $query = $this->db->query("select p.*, c.nombre as d_carrera, s.descripcion as d_nacionalidad 
    from padron p left join carreras c on p.carrera = c.carrera left join paises s on p.nacionalidad = s.codigo ". 
    " where p.dni = ".$dni);
    $result = $query->result_array();
*/
    return $result;
  }

  public function Alumno_No_Confirmo_Segundo($anio, $clave){
    $query = $this->db->query("select count(*) as noconfirmo from observados where estado='NC' and anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;  
  }

  public function Datos_Padron($dni){
    $db2 = $this->load->database('sitacad', TRUE);
    $query = $db2->query("select p.cod_carrera as carrera, p.dni, p.anio, p.clave, p.apellido,p.nombre, 
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
        " where p.dni=".$dni);
    $result = $query->result_array();
    $db2->close();      
    return $result;
}

public function Datos_Padtot_Por_Dni($dni){
  //$db2 = $this->load->database('sitacad', TRUE);
  //$query = $db2->query("select * from padron where anio=".$anio." and clave=".$clave);
  //$result = $query->result_array();
  //$db2->close();      
  //return $result;
  	$dbPadrones = $this->load->database('padrones', TRUE);  
    $select = "select * from  padtot where dni=$dni";
	$query = $dbPadrones->query($select);
	$result = $query->result_array();
	$dbPadrones->close(); 
	return $result;
}

public function Datos_Padron_Por_Clave($anio, $clave){
  //$db2 = $this->load->database('sitacad', TRUE);
  //$query = $db2->query("select * from padron where anio=".$anio." and clave=".$clave);
  //$result = $query->result_array();
  //$db2->close();      
  //return $result;
  	$dbPadrones = $this->load->database('padrones', TRUE);  
    $select = "select * from  padtot where anio=$anio and clave=$clave";
	$query = $dbPadrones->query($select);
	$result = $query->result_array();
	$dbPadrones->close(); 
	return $result;
}

  public function Asignacion_por_clave($anio,$clave,$cuat){
    if ($cuat != -1) {
      $where = ' and c.cuat = '.$cuat;
    }
    else  {
      $where = '';
    }
    $query = $this->db->query("select c.cuat,c.sede as sede, (select descripcion from sedes where sede = c.sede) as d_sede,
     c.materia, (select descripcion from materias where codigo = c.materia) as d_materia,
     c.horario, (select deschora from deschora where horario = c.horario) as d_horario, aula, 
     newcomi as comision, n.descripcion as d_novedad, catedra 
     from cursos c, lectivo l left join novedad n on l.novedad = n.codigo 
     where c.comision = l.curso and anio = ".$anio." and clave = ".$clave.$where);
     //print_r($query);
     //exit;
    $result = $query->result_array();
    return $result;
  }

  public function Cursa_XXI($anio,$clave){
    $query = $this->db->query("select cuat,materia from cursa_xxi where anio = ".$anio." and clave = ".$clave);
    $result = $query->result_array();
    return $result;
  }

  public function Pide_XXI($anio,$clave){
    $query = $this->db->query("select materia from pide_ubaxxi where anio = ".$anio." and clave=".$clave);
    $result = $query->result_array();
    return $result;
  }
  

  public function Aprobo_XXI($anio, $clave){
    $query = $this->db->query("select * from apro_ubaxxi where anio = ".$anio." and clave=".$clave);
    $result = $query->result_array();
    return $result;
  }
  
  public function Get_Max_Materias($dni){
  	$dbPadrones = $this->load->database('padrones', TRUE);  
    $select = "select count(*) as cantidad from  padguara where dni=$dni and resultado_estado='A' and codigo_propuesta in (7,50,51,76,83,138,139)";
	$query = $dbPadrones->query($select);
	$result = $query->result_array();
	$dbPadrones->close(); 
	return $result;
  }

  public function Get_Carreras_Padguara($dni){
  	$dbPadrones = $this->load->database('padrones', TRUE);  
    $select = "select carreras.carrera, carreras.nombre from  padguara left join carreras on carrera=padguara.codigo_propuesta where dni=$dni and resultado_estado='A'";
	$query = $dbPadrones->query($select);
	$result = $query->result_array();
	$dbPadrones->close(); 
	return $result;
    /*
	$query = $dbPadrones->query($select);
	$result = $query->result_array();
	if ($result !== FALSE && $result->num_rows() > 0) {
       $data = $result->result_array();
    } else {
       $data = array();
    }
    $dbPadrones->close(); 
	return $data;	    
    */
  }
   

  public function Datos_Total($clave){
    $query = $this->db->query("select 2021 as anio, p.clave, p.dni, p.apellido, p.nombre, p.carrera, p.condicion as titulo, 'T' as regular, 'F' as baja, c.nombre as d_carrera, s.descripcion as d_nacionalidad 
    from total p left join carreras c on p.carrera = c.carrera left join paises s on p.nacionalidad = s.codigo ". 
    " where p.condicion=4 and p.dni = ".$clave);
    $result = $query->result_array();
    return $result;
  }

  public function Altabaja_Cargado($sede){
    $anio=0;
    $clave=0;
    $resultado_cargado = array();
    if ($sede==3){                                                                                                                                                                           
      $query = $this->db->query("select anio,clave,sede,materia,horario,aula from altabaja where activo=1 and materia<>0");
    }else{ 
      $query = $this->db->query("select anio,clave,sede,materia,horario,aula from altabaja where activo=1 and sede=".$sede." and materia<>0");
    }
    $result = $query->result_array();
    foreach($result as $cursada) {
       $alucargado = array();
       $anio = $cursada['anio'];
       $clave = $cursada['clave'];
       $alumno_registro = $this->Datos_Padron_Por_Clave($anio, $clave);
       $alucargado['anio'] = $anio;
       $alucargado['clave'] = $clave;
       $alucargado['apellido'] = $alumno_registro[0]['apellido'].", ".$alumno_registro[0]['nombre'];
       $alucargado['nombre'] = $alumno_registro[0]['nombre'];
       $alucargado['dni'] = $alumno_registro[0]['dni'];
       $alucargado['sede'] =  $cursada['sede'];
       $alucargado['materia'] = $cursada['materia'];
       $alucargado['horario'] = $cursada['horario'];
       $alucargado['aula'] = $cursada['aula'];
       array_push($resultado_cargado, $alucargado);
    }
    return $resultado_cargado;   
  }

  public function Ya_Cargado($anio,$clave){
    $resultado_cargado = array();
    $query = $this->db->query("select sede,materia,horario,aula,procesado from altabaja where activo=1 and anio=$anio and clave=$clave");
    $result = $query->result_array();
    return $result;
    /*
    foreach($result as $cursada) {
      $alucargado = array();
      $alucargado['sede'] =  $cursada['sede'];
      $alucargado['materia'] = $cursada['materia'];
      $alucargado['horario'] = $cursada['horario'];
      $alucargado['aula'] = $cursada['aula'];
      array_push($resultado_cargado, $alucargado);
    }
    return $resultado_cargado; 
    */
  }

  public function No_Cargar($anio,$clave){
    $resultado_cargado = array();
    $query = $this->db->query("select count(*) as cantidad from altabaja where procesado=5 and anio=$anio and clave=$clave");
    $result = $query->result_array();
    return $result;
    /*
    foreach($result as $cursada) {
      $alucargado = array();
      $alucargado['sede'] =  $cursada['sede'];
      $alucargado['materia'] = $cursada['materia'];
      $alucargado['horario'] = $cursada['horario'];
      $alucargado['aula'] = $cursada['aula'];
      array_push($resultado_cargado, $alucargado);
    }
    return $resultado_cargado; 
    */
  }
  
  public function MateriasCarrera($carrera, $materia){
    $query = $this->db->query("select count(*) as cantidad from carrera_materia where carrera=$carrera and materia=$materia and origen<>'E'");
    $result = $query->result_array();
    return $result;
  }

}