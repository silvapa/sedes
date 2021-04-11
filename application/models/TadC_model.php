<?php
 class TadC_model extends CI_Model {

	  public function __construct() {
		parent::__construct();
	  }
	  
	  function Get_Tramites(){
		$dbInscripcion = $this->load->database('inscripcion', TRUE);  
		$select = "select * from carrera where exportado=0 and date(fecha)<date(now()) limit 5000";
		$query = $dbInscripcion->query($select);
		$result = $query->result_array();
		$dbInscripcion->close(); 
		return $result;
	  }

	  function Get_Datos_Guarani_Dni($dni){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select dni,cuil,apellido,nombre from padguara where dni=$dni";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
	  }
	  
	  function Get_Datos_Guarani_ID($id){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select dni,cuil,apellido,nombre from padguara where id_persona=$id";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
	  }

	  function Get_Datos_Guarani_Cuil($cuil){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select dni,cuil,apellido,nombre from padguara where cuil=$cuil";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
      }
	   
	  function Get_Datos_Guarani_Mail($mail){
	  	$dbPadrones = $this->load->database('padrones', TRUE);  
		$select = "select dni,cuil,apellido,nombre from padguara where email='".$mail."'";
		$query = $dbPadrones->query($select);
		$result = $query->result_array();
		$dbPadrones->close(); 
		return $result;
	  }

	  function Save_Expedienes($tadc_tmps){
		$dbInscripcion = $this->load->database('inscripcion', TRUE);  
        try { 
           $this->db->trans_start();
		   $dbInscripcion->trans_start();
		   foreach($tadc_tmps as $key) {
		     $id = $key['tramite'];
			 $unTad = array(
	  			'Fecha_caratulacion'=> $key['Fecha_caratulacion'],
	  			'Expediente'=>  $key['Expediente'],
	  			'Estado_expediente'=>  $key['Estado_expediente'],
	  	    	'Documento_FINUB'=>  $key['Documento_FINUB'],
	        	'Reparticion_actual_del_expediente'=>  $key['Reparticion_actual_del_expediente'],
	  			'Sector_actual_del_expediente'=>  $key['Sector_actual_del_expediente'],
	  			'Fecha_de_ultimo_pase'=>  $key['Fecha_de_ultimo_pase'],
	  			'EMAIL'=>  $key['EMAIL'],
		    	'NOMBRE_SOLICITANTE'=> $key['NOMBRE_SOLICITANTE'], 
	        	'APELLIDO_SOLICITANTE'=>  $key['APELLIDO_SOLICITANTE'],
		    	'CUIT_CUIL'=>  $key['CUIT_CUIL'],
	  			'TIPO_DOCUMENTO'=> $key['TIPO_DOCUMENTO'], 
	  			'NUMERO_DOCUMENTO'=>  $key['NUMERO_DOCUMENTO'],
		    	'GENERO'=>  $key['GENERO'],
				'carrera_baja'=>  $key['carrera_baja'],
	  			'carrera_alta'=>  $key['carrera_alta'],
	  			'tipo_de_accion'=> $key['tipo_de_accion'] 
			 );
		     $this->db->insert('tadc',$unTad);
             if ($this->db->affected_rows()==1) {
               // marcar como exportado en carrera
               $exportado=1;
             }else{
               //  marcar como que no pasa en carrera
			   $exportado=-1;
			   //print_r($key);
			   //exit;
             }
			 $data2 = array('exportado' => $exportado); 
			 $dbInscripcion->where('id', $id);
             $dbInscripcion->update('carrera',$data2);			 
		   }// foreach
           $this->db->trans_commit();
		   $dbInscripcion->trans_commit();	   
        } catch(Exception $e) {
          $this->db->trans_rollback();
		  $dbInscripcion->trans_rollback();
        }
		$dbInscripcion->close(); 
      }

 }
?>