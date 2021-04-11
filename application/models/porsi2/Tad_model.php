<?php
class Tad_model extends CI_Model {

  public function __construct() {
      parent::__construct();
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

/*    $result = $query->result_array();
    $db2->close();  
    return $result;
*/

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
  public function InsertarEnTemporal($data){
      $this->db->insert('tad1_tmp',$data);
      return ($this->db->affected_rows());
  }


  public function R_tad_revisar($t_tramite,$dde,$hta){
    $this->db->select('Expediente,APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE,EMAIL,TELEFONO, CUIT_CUIL,NUMERO_DOCUMENTO,FECHA_NAC,GENERO,NACIONALIDAD,CARRERA_A_SEGUIR,t_coincidencia,clave,anio,baja,sancion,t_tramite ');
    $this->db->from('tad1');
    $this->db->where("en_padron = 'R'");
    $this->db->where("t_tramite = '".$t_tramite."'");
    $this->db->where("str_to_date(Fecha_caratulacion, '%d/%m/%Y') >= str_to_date('".$dde."', '%d-%m-%Y')");
    $this->db->where("str_to_date(Fecha_caratulacion, '%d/%m/%Y') < str_to_date('".$hta."', '%d-%m-%Y')");
    $this->db->order_by("APELLIDO_SOLICITANTE,NOMBRE_SOLICITANTE");
    $query = $this->db->get();
    if ($query) {
      return $query->result_array();
    } else {
      $data = array();
      return $data;
    }
  }


  public function ActualizarEstadoTad($expediente,$cruce,$t_tramite){
    $query = "update tad1 set en_padron = '".$cruce['en_padron']."'".
    ",t_coincidencia = '". $cruce['t_coincidencia'] ."'".
    ",en_padron = '". $cruce['en_padron']."'".
    ",anio = ".$cruce['anio'].
    ",clave = ".$cruce['clave'].
    ",baja = '".$cruce['baja']."'".
    ",sancion = '".$cruce['sancion']."'".
    ",t_mail_enviar_cbc = '".$cruce['t_mail_enviar_cbc']."'".
    ",mail_enviado_cbc = '".$cruce['mail_enviado_cbc']."'".
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
    $insert_id = $this->db->insert('tad_archivos',$data);
    return  $insert_id;
    }

    public function obtener_tad1($estados_a_incluir,$t_tramite){
    if ($t_tramite == 'I') {
	    $enpadron = 'N';
	  }else{
	    $enpadron = 'S';	 
	  }
  
      $campos = "Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
      Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL, TELEFONO, NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
      RAZON_SOCIAL_SOLICITANTE, SEGUNDO_APELLIDO_SOLICITANTE, TERCER_APELLIDO_SOLICITANTE, SEGUNDO_NOMBRE_SOLICITANTE, 
      TERCER_NOMBRE_SOLICITANTE, CUIT_CUIL, DOMICILIO, PISO, DPTO, CODIGO_POSTAL, BARRIO, COMUNA, ALTURA, PROVINCIA, 
      DEPARTAMENTO, LOCALIDAD, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, DATE_FORMAT(FECHA_NAC, '%d/%m/%Y'), GENERO, NACIONALIDAD, LUGAR_NAC_BAHRA_PROVINCIA, 
      LUGAR_NAC_BAHRA_DPTO, LUGAR_NAC_BAHRA_LOCALIDAD, REQUIERE_CERTIF_ESP, DISCAPACIDAD, CARRERA_A_SEGUIR, TRABAJA, 
      DOC_ESTUDIOS_MEDIOS, OPCION_MAT_ELECTIVA ";
    /*} else {
      $campos = 'Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
      Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL, TELEFONO, NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
      RAZON_SOCIAL_SOLICITANTE, SEGUNDO_APELLIDO_SOLICITANTE, TERCER_APELLIDO_SOLICITANTE, SEGUNDO_NOMBRE_SOLICITANTE, 
      TERCER_NOMBRE_SOLICITANTE, CUIT_CUIL, DOMICILIO, PISO, DPTO, CODIGO_POSTAL, BARRIO, COMUNA, ALTURA, PROVINCIA, 
      DEPARTAMENTO, LOCALIDAD, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, FECHA_NAC, GENERO, NACIONALIDAD ';
    }*/
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
      $query = $this->db->query("select ".$campos." from tad1 ".$condicion_estado." and t_tramite = '".$t_tramite."' and en_padron ='".$enpadron."' order by f_estado");
      if ($query->num_rows() > 0) {
        return $query->result_array();
      } else {
        $data = array();
        return $data;
      }
  
/*      $resultado = $query->result_array();
      return $resultado;*/
    } 

    public function cambiar_estado_tad1($estados_a_incluir,$t_tramite){
	 if ($t_tramite == 'I') {
	   $enpadron = 'N';
	 }else{
	   $enpadron = 'S';	 
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
      $query = "update tad1 set estado = 'G' ".$condicion_estado." and t_tramite = '".$t_tramite."' and en_padron ='".$enpadron."'";
      $this->db->query($query);
      return ($this->db->affected_rows());
    } 

    public function Numeros_archivo($id_archivo){
      $query = $this->db->query("select sum(case when en_padron = 'S' then 1 else 0 end) as enpadron, 
      sum(case when en_padron = 'S' and baja = 'S' then 1 else 0 end) as enbaja, 
      sum(case when en_padron = 'S' and sancion = 'S' then 1 else 0 end) as sancionados, 
      sum(case when en_padron = 'R' then 1 else 0 end) as revisar, 
      sum(case when en_padron = 'R' and t_coincidencia = 'D' then 1 else 0 end) as revisar_dni, 
      sum(case when en_padron = 'R' and t_coincidencia = 'F' then 1 else 0 end) as revisar_fnac, 
      sum(case when en_padron = 'R' and t_coincidencia = 'M' then 1 else 0 end) as revisar_mail, 
      sum(case when en_padron = 'N' then 1 else 0 end) as noenpadron, 
      count(*) as total
      from tad1_tmp where id_archivo_tad = $id_archivo");
      $resultado = $query->result_array();
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
        clave, anio, baja, sancion, t_tramite, t_mail_enviar_cbc, mail_enviado_cbc ';
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

/*      $result = $db2->get();
      print_r('Voy a imprimir resultado');
      print_r($result);
      if($result !== FALSE && $result->num_rows() > 0){
          $data = $result->result_array();
      }
      $db2->close();
      return $data;*/
      if ($query !== FALSE && $query->num_rows() > 0) {
        $data = $query->result_array();
      }
      $db2->close();  
      return $data;

 //     $result = $query->result_array();
//      $db2->close();  
//      return $result;
    }

    public function get_expedientes_estado($estado,$t_tramite){
      $data = array();
      $query =  $this->db->query("select * from tad1 where en_padron = '".$estado."' and t_tramite = '".$t_tramite."'"); 
      $result = $query->result_array();
      return $result;
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
      $db2->close();  
      if ($query) {
        return $query->result_array();
      } else {
        return $data;
      }

/*      $result = $query->result_array();
      $db2->close();  
      return $result;*/
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
      $db2->close();  
      if ($query) {
        return $query->result_array();
      } else {
        return $data;
      }

/*      $result = $query->result_array();
      $db2->close();  
      return $result;*/
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

      $db2->close();  
      if ($query) {
        return $query->result_array();
      } else {
        return $data;
      }
                        
/*      $result = $query->result_array();
      $db2->close();  
      return $result;*/
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