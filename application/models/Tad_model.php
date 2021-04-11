<?php
class Tad_model extends CI_Model {

  public function __construct() {
      parent::__construct();
      set_time_limit (0);
      ini_set('memory_limit', '-1');
  }

  public function Existe_en_guarani($dni){
    $data = array();

    if ($dni == '') {
      return $data;
    }
    if (!(is_numeric ($dni))) {
      return $data;
    }
    $db2 = $this->load->database('pg', TRUE);  
    $db2->query("SET search_path TO negocio");
    $query =  $db2->query("select apellido as APELLIDO, nombres as NOMBRE, anio_ingreso as ANIO, 
    clave as CLAVE, email 
    from vw_personas p left join negocio_uba.mdp_personas_claves_uba c on p.persona = c.persona 
    left join mdp_personas_contactos m on m.persona = p.persona and contacto_tipo = 'MP'
    where nro_documento = '".$dni."'"); 

    $result = $db2->get();
    if($result !== FALSE && $result->num_rows() > 0){
        $data = $result->result_array();
    }
    $db2->close();
    return $data;

 /*   $result = $query->result_array();
    $db2->close();  
    return $result;*/
  }

  public function Get_un_Tad($expediente,$t_tramite){
    if (($t_tramite == 'DDJJ') or ($t_tramite == 'J')) {
      $select = "SELECT * FROM tadddjj where Expediente = '".$expediente."'";
    } 
    else {
      $select = "SELECT * FROM tad1 where Expediente = '".$expediente."'";
    }
    $query = $this->db->query($select);
    $result = $query->result_array();
    return $result;
  }  


  public function Get_Tads($where, $cuantos){
      $select = "SELECT NUMERO_DOCUMENTO as dni,APELLIDO_SOLICITANTE as apellido,NOMBRE_SOLICITANTE as nombre,
      EMAIL as email,
      case  when estado = 'R' then 'En revision'
            when estado = 'G' or estado = 'I' then 'En proceso'
            when estado = 'N' then 'No corresponde'
            when estado = 'E' then 'Procesado c/error'
            when estado = 'P' then 'Procesado OK' else estado end as estado,
            Expediente,
            case when t_tramite = 'I' then '1' else '2' end as t_tramite 
            FROM tad1 c ";    
      if ($where != '') {
        $select = $select ."  where ".$where;
      }    
      $select = $select ."  UNION ";
      $select = $select ."SELECT NUMERO_DOCUMENTO as dni,APELLIDO_SOLICITANTE as apellido,NOMBRE_SOLICITANTE as nombre,
      EMAIL as email,
      case  when estado = 'R' then 'En revision'
            when estado = 'G' or estado = 'I' then 'En proceso'
            when estado = 'N' then 'No corresponde'
            when estado = 'E' then 'Procesado c/error'
            when estado = 'P' then 'Procesado OK' else estado end as estado,
            Expediente,
            'DDJJ' as t_tramite 
            FROM tadddjj c ";    
      if ($where != '') {
        $select = $select ."  where ".$where;
      }    

      $select = $select ." order by apellido,nombre ";
      if ($cuantos > 0) {
        $select = $select ." limit ".$cuantos;
      }    
      $query = $this->db->query($select);
      $result = $query->result_array();
      return $result;
    }  

  public function InsertarEnTemporal($data){
      $this->db->insert('tad1_tmp',$data);
      return ($this->db->affected_rows());
  }

  public function InsertarEnTemporal_ddjj($data){
  //  print_r($data);
    $this->db->insert('tadddjj_tmp',$data);
    return ($this->db->affected_rows());
}


  public function R_tad_revisar($t_tramite,$dde,$hta){
    $consulta = "select Expediente,Fecha_caratulacion,APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE,EMAIL,TELEFONO, CUIT_CUIL,NUMERO_DOCUMENTO,FECHA_NAC,GENERO,NACIONALIDAD,CARRERA_A_SEGUIR,
    case en_guarani when 'S' then 'SI' when 'N' then 'NO' when 'R' then 'Revisar' else en_guarani end as en_guarani,
    case t_coincidencia_g when 'D' then 'Por DNI' when 'M' then 'Por mail' when 'F' then 'Por F.Nac' else t_coincidencia_g end as t_coincidencia_g,
    plan_codigo,'' as dni_g,'' as apellido_g,'' as nombre_g,'' as cuil_g,SYSDATE() as fnac_g,persona,
    case en_padron when 'S' then 'SI' when 'N' then 'NO' when 'R' then 'Revisar' else en_padron end as en_padron,
    case t_coincidencia when 'D' then 'Por DNI' when 'M' then 'Por mail' when 'F' then 'Por F.Nac' else t_coincidencia end as t_coincidencia,
    clave,anio,0 as dni_p,'' as apellido_p,'' as nombre_p, '' as cuil_p,SYSDATE() as fnac_p, baja,sancion,
    t_tramite from tad1 ".
    "where t_tramite = 'I' and estado = 'R' ".
    " and str_to_date(Fecha_caratulacion, '%d/%m/%Y') >= str_to_date('".$dde."', '%d-%m-%Y') ".
    " and str_to_date(Fecha_caratulacion, '%d/%m/%Y') <  str_to_date('".$hta."', '%d-%m-%Y') ".
    " union ".
    "select Expediente,Fecha_caratulacion,APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE,EMAIL,'' as TELEFONO, CUIT_CUIL,NUMERO_DOCUMENTO,'' as FECHA_NAC,'' as GENERO,'' as NACIONALIDAD,'' as CARRERA_A_SEGUIR,
    case en_guarani when 'S' then 'SI' when 'N' then 'NO' when 'R' then 'Revisar' else en_guarani end as en_guarani,
    case t_coincidencia_g when 'D' then 'Por DNI' when 'M' then 'Por mail' when 'F' then 'Por F.Nac' else t_coincidencia_g end as t_coincidencia_g,
    plan_codigo,'' as dni_g,'' as apellido_g,'' as nombre_g,'' as cuil_g,SYSDATE() as fnac_g,persona,
    case en_padron when 'S' then 'SI' when 'N' then 'NO' when 'R' then 'Revisar' else en_padron end as en_padron,
    case t_coincidencia when 'D' then 'Por DNI' when 'M' then 'Por mail' when 'F' then 'Por F.Nac' 
    when 'R' then 'REMATRICULAR' when 'A' then 'Plan 1000 y en padron' else t_coincidencia end as t_coincidencia,
    clave,anio,0 as dni_p,'' as apellido_p,'' as nombre_p, '' as cuil_p,SYSDATE() as fnac_p, baja,sancion,
    t_tramite from tadddjj ".
    "where t_tramite = 'J' and estado = 'R' ".
    " and str_to_date(Fecha_caratulacion, '%d/%m/%Y') >= str_to_date('".$dde."', '%d-%m-%Y') ".
    " and str_to_date(Fecha_caratulacion, '%d/%m/%Y') <  str_to_date('".$hta."', '%d-%m-%Y') ".    
    " order by APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE";
    $query = $this->db->query($consulta);
/*    $this->db->select("Expediente,APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE,EMAIL,TELEFONO, CUIT_CUIL,NUMERO_DOCUMENTO,FECHA_NAC,GENERO,NACIONALIDAD,CARRERA_A_SEGUIR,
    case when estado = 'R' then 'En guarani por DNI' else t_coincidencia end as t_coincidencia,
    clave,anio,baja,sancion,t_tramite ");
    $this->db->from('tad1');
    $this->db->where("estado <> 'N'");
    $this->db->where("estado <> 'P'");
    $this->db->where("(en_padron = 'R' or estado = 'R')");
    $this->db->where("t_tramite = '".$t_tramite."'");
    $this->db->where("str_to_date(Fecha_caratulacion, '%d/%m/%Y') >= str_to_date('".$dde."', '%d-%m-%Y')");
    $this->db->where("str_to_date(Fecha_caratulacion, '%d/%m/%Y') < str_to_date('".$hta."', '%d-%m-%Y')");
    $this->db->order_by("APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE");*/
    //$query = $this->db->get();
    if ($query) {
      return $query->result_array();
    } else {
      $data = array();
      return $data;
    }
  }


  public function ActualizarEstadoTad($expediente,$cruce,$t_tramite,$estado){
    $query = "update tad1 set en_padron = '".$cruce['en_padron']."'".
    ",t_coincidencia = '". $cruce['t_coincidencia'] ."'".
    ",anio = ".$cruce['anio'].
    ",clave = ".$cruce['clave'].
    ",baja = '".$cruce['baja']."'".
    ",sancion = '".$cruce['sancion']."'".
    ",en_guarani = '". $cruce['en_guarani']."'".
    ",persona = '". $cruce['persona']."'".
    ",plan_codigo = '". $cruce['plan_codigo']."'".
    ",t_coincidencia_g = '". $cruce['t_coincidencia_g']."'".
    ",t_mail_enviar_cbc = '".$cruce['t_mail_enviar_cbc']."'".
    ",mail_enviado_cbc = '".$cruce['mail_enviado_cbc']."'".
    ",estado = '".$estado."'".    
    ",t_tramite = '". $t_tramite ."' where Expediente = '".$expediente."'";     
    $this->db->query($query);
    return ($this->db->affected_rows());
}

  public function Truncar_tabla($tabla){
 /*   $this->db->empty_table($tabla);
    echo $this->db->last_query();*/
    $this->db->truncate($tabla);
}

  public function InsertarArchivo($file_name,$nombre_original){
    $data = array(
        'd_archivo_tad' => $file_name,
        'd_archivo_orig' => $nombre_original);
    $this->db->insert('tad_archivos',$data);
    $insert_id = $this->db->insert_id();
    return  $insert_id;
    }

    public function obtener_tad($estados_a_incluir,$t_tramite){
      if ($t_tramite == 'J') {
        $tabla = 'tadddjj';
        $campos = "Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
        Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL,NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
        CUIT_CUIL, TIPO_DOCUMENTO, NUMERO_DOCUMENTO,DOC_ESTUDIOS_MEDIOS ";
      }
      else {
        $tabla = 'tad1';
        $campos = "Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
        Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL, TELEFONO, NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
        RAZON_SOCIAL_SOLICITANTE, SEGUNDO_APELLIDO_SOLICITANTE, TERCER_APELLIDO_SOLICITANTE, SEGUNDO_NOMBRE_SOLICITANTE, 
        TERCER_NOMBRE_SOLICITANTE, CUIT_CUIL, DOMICILIO, PISO, DPTO, CODIGO_POSTAL, BARRIO, COMUNA, ALTURA, PROVINCIA, 
        DEPARTAMENTO, LOCALIDAD, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, DATE_FORMAT(FECHA_NAC, '%d/%m/%Y'), GENERO, NACIONALIDAD, LUGAR_NAC_BAHRA_PROVINCIA, 
        LUGAR_NAC_BAHRA_DPTO, LUGAR_NAC_BAHRA_LOCALIDAD, REQUIERE_CERTIF_ESP, DISCAPACIDAD, CARRERA_A_SEGUIR, TRABAJA, 
        DOC_ESTUDIOS_MEDIOS, OPCION_MAT_ELECTIVA ";
  
      }
      
      if ($estados_a_incluir == 'I') {
        $condicion_estado = "where estado = 'I'";
      } 
      else {
        if ($estados_a_incluir == 'G') {
          $condicion_estado = "where estado = 'G'";
        }
        else {
            $condicion_estado = "where estado in ('G','I')";
        }
      }
      $query = $this->db->query("select ".$campos." from ".$tabla.' '.$condicion_estado." and t_tramite = '".$t_tramite."' order by f_estado");
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      } else {
        $data = array();
      }
      return $data;
    } 

    public function cambiar_estado_tad($estados_a_incluir,$t_tramite){
      if ($t_tramite == 'J') {
        $tabla = 'tadddjj';
      }
      else {
        $tabla = 'tad1';
      }

      if ($estados_a_incluir == 'I') {
        $condicion_estado = "where estado = 'I'";
      } 
      else {
        if ($estados_a_incluir == 'G') {
          $condicion_estado = "where estado = 'G'";
        }
        else {
            $condicion_estado = "where estado in ('G','I')";
        }
      }
      $query = "update ".$tabla." set estado = 'G' ".$condicion_estado." and t_tramite = '".$t_tramite."'";
      $this->db->query($query);
      return ($this->db->affected_rows());
    } 

    public function Numeros_archivo($id_archivo){
/*      $query = $this->db->query("select sum(case when en_padron = 'S' and estado <> 'N' and estado <> 'R' then 1 else 0 end) as enpadron, 
      sum(case when en_padron = 'S'  and estado <> 'N' and estado <> 'R' and baja = 'S' then 1 else 0 end) as enbaja, 
      sum(case when en_padron = 'S'  and estado <> 'N' and estado <> 'R' and sancion = 'S' then 1 else 0 end) as sancionados, 
      sum(case when en_padron = 'R'   or estado  = 'R' then 1 else 0 end) as revisar, 
      sum(case when en_padron = 'R'  and estado <> 'N' and estado <> 'R' and t_coincidencia = 'D' then 1 else 0 end) as revisar_dni, 
      sum(case when en_padron = 'R'  and estado <> 'N' and estado <> 'R' and t_coincidencia = 'F' then 1 else 0 end) as revisar_fnac, 
      sum(case when en_padron = 'R'  and estado <> 'N' and estado <> 'R' and t_coincidencia = 'M' then 1 else 0 end) as revisar_mail, 
      sum(case when    estado = 'R'  then 1 else 0 end) as revisar_guarani, 
      sum(case when en_padron = 'N'  and estado <> 'N' and estado <> 'R' then 1 else 0 end) as noenpadron, 
      sum(case when estado = 'N' and (t_mail_enviar_cbc is null or t_mail_enviar_cbc <> 'R') then 1 else 0 end) as enguarani, 
      sum(case when estado = 'N' and t_mail_enviar_cbc = 'R' then 1 else 0 end) as repetido, 
      count(*) as total
      from tad1_tmp where id_archivo_tad = $id_archivo");*/
      $query = $this->db->query("select sum(case when en_padron = 'S' and estado <> 'N' and estado <> 'R' then 1 else 0 end) as enpadron, 
      sum(case when en_padron = 'S'  and estado <> 'N' and estado <> 'R' and baja = 'S' then 1 else 0 end) as enbaja, 
      sum(case when en_padron = 'S'  and estado <> 'N' and estado <> 'R' and sancion = 'S' then 1 else 0 end) as sancionados, 
      sum(case when estado = 'R' then 1 else 0 end) as revisar, 
      sum(case when en_padron = 'R' and en_guarani <> 'R' and estado = 'R' and t_coincidencia = 'D' then 1 else 0 end) as revisar_dni, 
      sum(case when en_padron = 'R' and en_guarani <> 'R' and estado = 'R' and t_coincidencia = 'F' then 1 else 0 end) as revisar_fnac, 
      sum(case when en_padron = 'R' and en_guarani <> 'R' and estado = 'R' and t_coincidencia = 'M' then 1 else 0 end) as revisar_mail, 
      sum(case when en_guarani = 'R' and estado = 'R' and t_coincidencia_g = 'D' then 1 else 0 end) as revisar_g_dni, 
      sum(case when en_guarani = 'R' and estado = 'R' and t_coincidencia_g = 'F' then 1 else 0 end) as revisar_g_fnac, 
      sum(case when en_guarani = 'R' and estado = 'R' and t_coincidencia_g = 'M' then 1 else 0 end) as revisar_g_mail, 
      sum(case when en_padron = 'N'  and estado = 'R' then 1 else 0 end) as noenpadron, 
      sum(case when estado = 'N' and en_guarani = 'S' then 1 else 0 end) as enguarani, 
      sum(case when estado = 'N' and t_mail_enviar_cbc = 'R' then 1 else 0 end) as repetido, 
      count(*) as total
      from tad1_tmp where id_archivo_tad = $id_archivo");

      if ($query) {
        $resultado = $query->result_array();
      } else {
        $resultado = array();
      }
      
      return $resultado;
    }

    public function InsertarEnTad($id_archivo){
        $campos = 'Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
        Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL, TELEFONO, NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
        RAZON_SOCIAL_SOLICITANTE, SEGUNDO_APELLIDO_SOLICITANTE, TERCER_APELLIDO_SOLICITANTE, SEGUNDO_NOMBRE_SOLICITANTE, 
        TERCER_NOMBRE_SOLICITANTE, CUIT_CUIL, DOMICILIO, PISO, DPTO, CODIGO_POSTAL, BARRIO, COMUNA, ALTURA, PROVINCIA, 
        DEPARTAMENTO, LOCALIDAD, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, FECHA_NAC, GENERO, NACIONALIDAD, LUGAR_NAC_BAHRA_PROVINCIA, 
        LUGAR_NAC_BAHRA_DPTO, LUGAR_NAC_BAHRA_LOCALIDAD, REQUIERE_CERTIF_ESP, DISCAPACIDAD, CARRERA_A_SEGUIR, TRABAJA, 
        DOC_ESTUDIOS_MEDIOS, OPCION_MAT_ELECTIVA, mensaje, id_archivo_tad, t_coincidencia, estado, f_estado, en_padron, 
        clave, anio, baja, sancion, t_tramite, t_mail_enviar_cbc, mail_enviado_cbc,
        t_coincidencia_g,en_guarani,persona,plan_codigo ';
        $query = "Insert into tad1 (".$campos.") (select ".$campos." from tad1_tmp where id_archivo_tad = ".$id_archivo.")";
        $this->db->query($query); 
        return ($this->db->affected_rows());
    }
    
    public function LoteYaProcesado(){
        $query = $this->db->query("select count(*) as cuantos from tad1 where expediente in (select expediente from tad1_tmp)");
        $resultado = $query->result();
        if ((!($resultado)) or (empty($resultado))) {
          return false;
        } 
        else
        { $row = $resultado[0];
          return ($row->cuantos > 0);
        }
    }

    public function Numeros_archivo_ddjj($id_archivo){
      $query = $this->db->query("select sum(case when en_padron = 'S' and estado <> 'N' and estado <> 'R' then 1 else 0 end) as enpadron, 
      sum(case when en_padron = 'S'  and estado <> 'N' and estado <> 'R' and baja = 'S' then 1 else 0 end) as enbaja, 
      sum(case when en_padron = 'S'  and estado <> 'N' and estado <> 'R' and sancion = 'S' then 1 else 0 end) as sancionados, 
      sum(case when estado = 'R' then 1 else 0 end) as revisar, 
      sum(case when en_padron = 'R' and en_guarani <> 'R' and estado = 'R' and t_coincidencia = 'D' then 1 else 0 end) as revisar_dni, 
      sum(case when en_padron = 'R' and en_guarani <> 'R' and estado = 'R' and t_coincidencia = 'F' then 1 else 0 end) as revisar_fnac, 
      sum(case when en_padron = 'R' and en_guarani <> 'R' and estado = 'R' and t_coincidencia = 'M' then 1 else 0 end) as revisar_mail, 
      sum(case when en_guarani = 'R' and estado = 'R' and t_coincidencia_g = 'D' then 1 else 0 end) as revisar_g_dni, 
      sum(case when en_guarani = 'R' and estado = 'R' and t_coincidencia_g = 'F' then 1 else 0 end) as revisar_g_fnac, 
      sum(case when en_guarani = 'R' and estado = 'R' and t_coincidencia_g = 'M' then 1 else 0 end) as revisar_g_mail, 
      sum(case when en_padron = 'N'  and estado = 'R' then 1 else 0 end) as noenpadron, 
      sum(case when estado = 'N' and en_guarani = 'S' then 1 else 0 end) as enguarani, 
      sum(case when estado = 'N' and t_mail_enviar_cbc = 'R' then 1 else 0 end) as repetido, 
      count(*) as total
      from tadddjj_tmp where id_archivo_tad = $id_archivo");

      if ($query) {
        $resultado = $query->result_array();
      } else {
        $resultado = array();
      }
      
      return $resultado;
    }

    public function InsertarEnTad_ddjj($id_archivo){
        $campos = 'Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
        Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL, NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
        CUIT_CUIL, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, DOC_ESTUDIOS_MEDIOS, mensaje, id_archivo_tad, t_coincidencia, estado, f_estado, en_padron, 
        clave, anio, baja, sancion, t_tramite, t_mail_enviar_cbc, mail_enviado_cbc,
        t_coincidencia_g,en_guarani,persona,plan_codigo ';
        $query = "Insert into tadddjj (".$campos.") (select ".$campos." from tadddjj_tmp where id_archivo_tad = ".$id_archivo.")";
        $this->db->query($query); 
        return ($this->db->affected_rows());
    }
    
    public function LoteYaProcesado_ddjj(){
        $query = $this->db->query("select count(*) as cuantos from tadddjj where expediente in (select expediente from tadddjj_tmp)");
        $resultado = $query->result();
        if ((!($resultado)) or (empty($resultado))) {
          return false;
        } 
        else
        { $row = $resultado[0];
          return ($row->cuantos > 0);
        }
    }
  
	  function Datos_Guarani($persona){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
  		$select = "select dni,cuil,apellido,nombre,fechanac
                from padguara 
                where id_persona=".$persona;
  		$query = $dbPadrones->query($select);
	  	$result = $query->result_array();
  		$dbPadrones->close(); 
	  	return $result;
	  }

	  function Get_Datos_Guarani_Mail($mail){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
  		$select = "select dni,cuil,apellido,nombre,plan_codigo,id_persona as persona  
                from padguara 
                where email='".$mail."'";
  		$query = $dbPadrones->query($select);
	  	$result = $query->result_array();
  		$dbPadrones->close(); 
	  	return $result;
	  }
	  function Get_Datos_Guarani_ApeFec($apellido, $fechanac){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
  		$select = "select dni,cuil,apellido,nombre,plan_codigo,id_persona as persona  
                from padguara 
                where apellido='".str_replace ($apellido,"'","''")."' and date(fechanac)='".$fechanac."'";
	  	$query = $dbPadrones->query($select);
		  $result = $query->result_array();
		  $dbPadrones->close(); 
		  return $result;
	  }

    function existe_por_dni_Guarani($dni){
      // Si ya está en plan 2000 muestro ese registro. Si no hay plan 2000, va a mostrar plan 1000
      // (por eso el order by plan_codigo desc)
/*      $ape3 = str_replace ("'","''",$ape3);*/
      $data = array();
      if ($dni == '') {
        return $data;
      }
      if (!(is_numeric ($dni))) {
        return $data;
      }
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
      $select = "select dni,cuil,ucase(apellido) as apellido,ucase(nombre) as nombre,plan_codigo,id_persona as persona 
                from padguara where dni=$dni order by plan_codigo desc limit 1"; 

      $query = $dbPadrones->query($select);
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      $dbPadrones->close(); 
      return $data;	     
	  }

    public function existe_por_dni_y_ape($dni, $ape3){
      $ape3 = str_replace ("'","''",$ape3);
      $data = array();
  
      if ($dni == '') {
        return $data;
      }
      if (!(is_numeric ($dni))) {
        return $data;
      }
      $db2 = $this->load->database('sitacad', TRUE);  
      $query =  $db2->query("select apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, anio as ANIO, 
      clave as CLAVE, sancion as SANCION, baja as BAJA, TITULO, sexo  
      from padron 
      where dni = $dni and apellido like '$ape3%'"); 

      if ($query !== FALSE && $query->num_rows() > 0) {
          $data = $query->result_array();
      }
      $db2->close();  
      return $data;

/*      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      $db2->close();  
      return $data;
*/
 //     $result = $query->result_array();
//      $db2->close();  
//      return $result;
    }

    public function get_expedientes_estado($estado,$t_tramite){
      $data = array();
      $query =  $this->db->query("select * from tad1 where estado = '".$estado."' and t_tramite = '".$t_tramite."'"); 
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      return $data;
    }    

    public function existe_por_cuil_tad($cuil,$t_tramite){
      $cuantos = 0;
      if ($t_tramite == 'J') {
        $query =  $this->db->query("select count(*) as cuantos from tadddjj where CUIT_CUIL = ".$cuil); 
      }
      else {
        $query =  $this->db->query("select count(*) as cuantos from tad1 where CUIT_CUIL = ".$cuil." and t_tramite = '".$t_tramite."'"); 
      }        
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
        $cuantos = $data[0]['cuantos'];
      }
      return $cuantos;
    }    

    public function existe_por_cuil_tad_tmp($cuil,$t_tramite){
      $cuantos = 0;
      if ($t_tramite == 'J') {
        $query =  $this->db->query("select count(*) as cuantos from tadddjj_tmp where CUIT_CUIL = ".$cuil); 
      }
      else {
        $query =  $this->db->query("select count(*) as cuantos from tad1_tmp where CUIT_CUIL = ".$cuil." and t_tramite = '".$t_tramite."'"); 
      }        
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
        $cuantos = $data[0]['cuantos'];
      }
      return $cuantos;
    }    

    public function existe_por_dni($dni){
      $data = array();
  
      if ($dni == '') {
        return $data;
      }
      if (!(is_numeric ($dni))) {
        return $data;
      }
      $db2 = $this->load->database('sitacad', TRUE);  
      $query =  $db2->query("select apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, anio as ANIO, 
      clave as CLAVE, sancion as SANCION, baja as BAJA, TITULO, sexo  
      from padron 
      where dni = $dni"); 
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      $db2->close();  
      return $data;
  }

    public function existe_por_mail($email){
      $data = array();
  
      if ($email == '') {
        return $data;
      }
      $email = strtolower($email);
      $db2 = $this->load->database('sitacad', TRUE);  
      $query =  $db2->query("select apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, 
      p.anio as ANIO, p.clave as CLAVE, sancion as SANCION, baja as BAJA, p.TITULO, p.sexo  
      from padron p left join rv_insc i on p.anio = i.anio and p.clave = i.clave 
      where i.email = '$email'"); 
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      $db2->close();  
      return $data;
    }


    public function existe_por_apellido_fnac($apellido, $fnac){
/*      $dd = substr($fnac,0,2);
      $mm = substr($fnac,3,2);
      $yy = substr($fnac,6,4);*/
    
      $yy = substr($fnac,0,4);
      $mm = substr($fnac,5,2);
      $dd = substr($fnac,8,2);      
      $data = array();
        
      if (($dd == '') || ($mm == '') || ($yy == '')) {
        return $data;
      }
      if ((!(is_numeric ($dd))) || (!(is_numeric ($mm))) || (!(is_numeric ($yy)))) {
        return $data;
      }
      $apellido = str_replace ("'","''",$apellido);
      $db2 = $this->load->database('sitacad', TRUE);  
      $query =  $db2->query("select dni,apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, anio as ANIO, 
                clave as CLAVE, sancion as SANCION, baja as BAJA, TITULO 
                from padron 
                where apellido = '$apellido' and dd_nac = $dd and mm_nac = $mm and aa_nac = $yy"); 

      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      $db2->close();  
      return $data;
    }


    // Traducir a API
  /*
  function existe_por_apellido_fnac($apellido, $fnac, $coneccion){
  $dd = substr($fnac,0,2);
  $mm = substr($fnac,3,2);
  $yy = substr($fnac,6,4);
  $data = array();

  if (($dd == '') || ($mm == '') || ($yy == '')) {
    return $data;
  }
  if ((!(is_numeric ($dd))) || (!(is_numeric ($mm))) || (!(is_numeric ($yy)))) {
    return $data;
  }
  $apellido = str_replace ("'","''",$apellido);
  $query = "select dni,apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, anio as ANIO, 
            clave as CLAVE, sancion as SANCION, baja as BAJA, TITULO 
            from padron 
            where apellido = '$apellido' and dd_nac = $dd and mm_nac = $mm and aa_nac = $yy"; 

  $result = odbc_exec($coneccion,$query); 
  if (!$result) {
    echo 'Consulta ejecutada: '.$query."\r\n\r\n";;
    echo odbc_errormsg($coneccion);
    die;
  }
  while (odbc_fetch_row($result)) {
      $data[]=array('APELLIDO' => odbc_result ($result, "APELLIDO"), 
                    'NOMBRE'=> odbc_result ($result, "NOMBRE"), 
                    'COD_CARRERA'=> odbc_result ($result, "COD_CARRERA"), 
                    'ANIO'=> odbc_result ($result, "ANIO"), 
                    'CLAVE'=> odbc_result ($result, "CLAVE"), 
                    'BAJA'=> odbc_result ($result, "BAJA"), 
                    'SANCION'=> odbc_result ($result, "SANCION"), 
                    'TITULO'=> odbc_result ($result, "TITULO"), 
                    'CONDICION_TAD'=> traduce_condicioncbc_a_tad(odbc_result ($result, "TITULO")), 
                    'DNI'=> odbc_result ($result, "DNI"));
  }
  return $data;   
}

function existe_por_dni_y_ape($dni, $ape3, $coneccion){
    $ape3 = str_replace ("'","''",$ape3);
    $data = array();

    if ($dni == '') {
      return $data;
    }
    if (!(is_numeric ($dni))) {
      return $data;
    }

    $query = "select apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, anio as ANIO, 
              clave as CLAVE, sancion as SANCION, baja as BAJA, TITULO 
              from padron 
              where dni = $dni and apellido like '$ape3%'"; 
    $result = odbc_exec($coneccion,$query); 
    if (!$result) {
      echo 'Consulta ejecutada: '.$query."\r\n\r\n";;
      echo odbc_errormsg($coneccion);
      die;
    }
    while (odbc_fetch_row($result)) {
      $data[]=array('APELLIDO' => odbc_result ($result, "APELLIDO"), 
                    'NOMBRE'=> odbc_result ($result, "NOMBRE"), 
                    'COD_CARRERA'=> odbc_result ($result, "COD_CARRERA"), 
                    'ANIO'=> odbc_result ($result, "ANIO"), 
                    'CLAVE'=> odbc_result ($result, "CLAVE"), 
                    'BAJA'=> odbc_result ($result, "BAJA"), 
                    'TITULO'=> odbc_result ($result, "TITULO"), 
                    'CONDICION_TAD'=> traduce_condicioncbc_a_tad(odbc_result ($result, "TITULO")), 
                    'SANCION'=> odbc_result ($result, "SANCION"));
    }
    return $data;   
  }

  function existe_por_dni($dni, $coneccion){
    $data = array();
    if ($dni == 'DU') {
      return $data;
    }
    if ($dni == '') {
      return $data;
    }
    if (!(is_numeric ($dni))) {
      return $data;
    }

    $query = "select apellido as APELLIDO, nombre as NOMBRE, cod_carrera as COD_CARRERA, anio as ANIO, 
              clave as CLAVE, sancion as SANCION, baja as BAJA, TITULO 
              from padron 
              where dni = $dni"; 
    $result = odbc_exec($coneccion,$query); 
    if (!$result) {
      echo odbc_errormsg($coneccion);
      echo 'Consulta ejecutada: '.$query."\r\n\r\n";;
      die;
    }

    while (odbc_fetch_row($result)) {
      $data[]=array('APELLIDO' => odbc_result ($result, "APELLIDO"), 
                    'NOMBRE'=> odbc_result ($result, "NOMBRE"), 
                    'COD_CARRERA'=> odbc_result ($result, "COD_CARRERA"), 
                    'ANIO'=> odbc_result ($result, "ANIO"), 
                    'CLAVE'=> odbc_result ($result, "CLAVE"), 
                    'BAJA'=> odbc_result ($result, "BAJA"), 
                    'TITULO'=> odbc_result ($result, "TITULO"), 
                    'CONDICION_TAD'=> traduce_condicioncbc_a_tad(odbc_result ($result, "TITULO")), 
                    'SANCION'=> odbc_result ($result, "SANCION"));
    }
    return $data;   
  }

  */


}