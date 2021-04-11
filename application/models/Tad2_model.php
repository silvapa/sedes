<?php
 class Tad2_model extends CI_Model {

	  public function __construct() {
		parent::__construct();
	  }
	  
	  function Get_Tramites(){
	
		$dbInscripcion = $this->load->database('inscripcion', TRUE);  
		$select = "select * from rematricula where exportado=0 and date(fecha)<=date(now())";
		$query = $dbInscripcion->query($select);
		$result = $query->result_array();
		$dbInscripcion->close(); 
		return $result;
        /*
		$select = "SELECT * FROM `tad1` WHERE t_tramite='R' and en_padron='I' and en_guarani<>'G'";
		$query = $this->db->query($select);
		$result = $query->result_array();
		return $result;		
		*/	     
	  }

	  
	  function Get_Cuil_Padtot($anio, $clave){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select cuil from padtot where anio=$anio and clave=$clave";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		//$dbPadrones->close(); 
		//return $result;
		if ($result !== FALSE && $result->num_rows() > 0) {
          $data = $result->result_array();
        } else {
          $data = array();
        }
		$dbPadrones->close(); 
		return $data;	     
	  }

		  
	  function Get_Titulo_Padtot($anio, $clave){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select titulo from padtot where anio=$anio and clave=$clave";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		//$dbPadrones->close(); 
		//return $result;
		if ($result !== FALSE && $result->num_rows() > 0) {
          $data = $result->result_array();
        } else {
          $data = array();
        }
		$dbPadrones->close(); 
		return $data;	     
	  }

	
	  function Get_Datos_Padtot($anio, $clave){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select cuil, titulo,baja,sancion,nacionalidad from padtot where anio=$anio and clave=$clave";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
		/*
		if ($result !== FALSE && $result->num_rows() > 0) {
          $data = $result->result_array();
        } else {
          $data = array();
        }

		$dbPadrones->close(); 
		return $data;	   
				*/  
	  }

	
	  function Get_Datos_Guarani_Dni($dni){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select id_persona, dni,cuil,apellido,nombre from padguara where dni=$dni";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
		/*
        if ($result !== FALSE && $result->num_rows() > 0) {
          $data = $result->result_array();
        } else {
          $data = array();
        }
		$dbPadrones->close(); 
		return $data;	
		*/     
	  }

	  function Get_Datos_Guarani_Cuil($cuil){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select id_persona,dni,cuil,apellido,nombre from padguara where cuil=$cuil";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
		/*
        if ($result !== FALSE && $result->num_rows() > 0) {
          $data = $result->result_array();
        } else {
          $data = array();
        }
		$dbPadrones->close(); 
		return $data;
		*/
      }
	   
	  function Get_Datos_Guarani_Mail($mail){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select id_persona,dni,cuil,apellido,nombre from padguara where email='".$mail."'";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
		/*
        if ($result !== FALSE && $result->num_rows() > 0) {
          $data = $result->result_array();
        } else {
          $data = array();
        }
		$dbPadrones->close(); 
		return $data;  
		*/
	  }

	  function Get_Datos_Guarani_ApeFec($apellido, $nombre, $fechanac){
	  $data = array();
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select id_persona,dni,cuil,apellido,nombre from padguara where apellido='".$apellido."' and nombre='".$nombre."' and date(fechanac)='".$fechanac."'";
		//echo $select;

		$query = $dbPadrones->query($select);
		//$result = $query->result_array();
		//print_r($result);
		//exit;
		//$dbPadrones->close(); 
		//return $result;

		  if ($query !== FALSE && $query->num_rows() > 0) {
			$data = $query->result_array();
		  }
		  $dbPadrones->close(); 
		  return $data;	     

	  }
	
	  function Save_Expedienes($tad2_tmps){
		//print_r($tad2_tmps);
		//exit;
		$dbInscripcion = $this->load->database('inscripcion', TRUE);  
        try { 
           $this->db->trans_start();
		   $dbInscripcion->trans_start();
		   foreach($tad2_tmps as $key) {
		     $id = $key['tramite'];
		     $this->db->insert('tad2_tmp',$key);
             if ($this->db->affected_rows()==1) {
               // marcar como exportado en rematricula
               $exportado=1;
             }else{
               //  marcar como que no pasa en rematricula
			   $exportado=-1;
			   //print_r($this->db->error());
			   //print_r($key);
			   //exit;
             }
			 $data2 = array('exportado' => $exportado); 
			 $dbInscripcion->where('id', $id);
             $dbInscripcion->update('rematricula',$data2);			 
		   }// foreach
		   //exit;
		   
           $this->db->trans_commit();
		   $dbInscripcion->trans_commit();	   
        } catch(Exception $e) {
          $this->db->trans_rollback();
		  $dbInscripcion->trans_rollback();
        }
		$dbInscripcion->close(); 
      }

	  function Update_Expedienes($tad2_tmps){
		//print_r($tad2_tmps);
		//exit;
		
        try { 
           $this->db->trans_start();
		   foreach($tad2_tmps as $key) {
		     $id = $key['tramite'];
			 $data2 = array(
	              't_coincidencia'=> $key['t_coincidencia'],   
	              'estado'=> $key['estado'],
		          'en_padron' => $key['en_padron'],
	              'en_guarani'=> $key['en_guarani'],
		          'id_persona_guarani' => $key['id_persona_guarani']	 
			 ); 
			 $this->db->where('Expediente', $id);
             $this->db->update('tad1',$data2);			 
		   }// foreach
           $this->db->trans_commit();
        } catch(Exception $e) {
          $this->db->trans_rollback();
        }
 
      }




    function InsertarEnTad(){
        $campos = 'Fecha_caratulacion, Expediente, Estado_expediente, Documento_FINUB, Reparticion_actual_del_expediente, 
        Sector_actual_del_expediente, Fecha_de_ultimo_pase, EMAIL, TELEFONO, NOMBRE_SOLICITANTE, APELLIDO_SOLICITANTE, 
        RAZON_SOCIAL_SOLICITANTE, SEGUNDO_APELLIDO_SOLICITANTE, TERCER_APELLIDO_SOLICITANTE, SEGUNDO_NOMBRE_SOLICITANTE, 
        TERCER_NOMBRE_SOLICITANTE, CUIT_CUIL, DOMICILIO, PISO, DPTO, CODIGO_POSTAL, BARRIO, COMUNA, ALTURA, PROVINCIA, 
        DEPARTAMENTO, LOCALIDAD, TIPO_DOCUMENTO, NUMERO_DOCUMENTO, FECHA_NAC, GENERO, NACIONALIDAD, LUGAR_NAC_BAHRA_PROVINCIA, 
        LUGAR_NAC_BAHRA_DPTO, LUGAR_NAC_BAHRA_LOCALIDAD, REQUIERE_CERTIF_ESP, DISCAPACIDAD, CARRERA_A_SEGUIR, TRABAJA, 
        DOC_ESTUDIOS_MEDIOS, OPCION_MAT_ELECTIVA, mensaje, id_archivo_tad, t_coincidencia, estado, f_estado, en_padron, 
        clave, anio, baja, sancion, t_tramite, t_mail_enviar_cbc, mail_enviado_cbc ';
        $query = "Insert into tad1 (".$campos.") (select ".$campos." from tad2_tmp)";
        $this->db->query($query); 
        return ($this->db->affected_rows());
    }
 }
?>