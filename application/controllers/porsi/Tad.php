<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tad extends CI_Controller {

    function __construct()
    {
        parent::__construct();

     if ( ! ($this->session->userdata('logueado')))
        { 
            redirect('usuarios/iniciar_sesion');
        }
    else 
        {
        $this->load->model('Tad_model');
        $this->load->model('Usuario_model');
        $this->load->model('Lectivo_model');
        $this->permisos = array_column($this->Usuario_model->getPermisos($this->session->userdata('usuario_id')),'appermiso');
        $this->load->library('Funcs_lib');
        $this->load->library('Upload');
        $this->load->library('form_validation');
    //		$this->load->library('Sendmail'); 
        $config = array(
          'allowed_types' => 'csv|xls|xlsx',
          'upload_path' 	=> './tad',            /* Crear carpeta sedes/tad */
          'max_size' 		=> 1500000,
          'remove_spaces' => TRUE,
          );
        $this->upload->initialize($config);
        set_time_limit (0);
        ini_set('memory_limit', '-1');
      }   
    }
 
public function index() {
    echo "<h1>".APP_TITLE."</h1>";
  die();
}


public function consultar() {

	$error = '';
	$mensaje = '';
	$this->inicializar_consulta($error,$mensaje);
}

public function Traducir_Estado_Mail($estado,$t_tramite,$t_mail){
  if (($estado == null) or ($t_mail == null)) {
    return 'No corresponde enviar';
  }
  else {
    switch ($estado) {
      case 'P':
          return 'Pendiente de Envio';
          break;
      case 'S':
          return "Enviado";
          break;
      case 'N':
          return "Error al enviar";
          break;
      }
      return $estado;
  }
}

public function Traducir_Nombre_Mail($t_mail,$t_tramite){
  if ($t_tramite == 'I') {
    switch ($t_mail) {
      case '1':
          return 'En guarani plan 1000 (hacer ddjj)';
          break;
      case '2':
          return "Ya esta en guarani plan 2000";
          break;
      case 'R':
          return "Ingreso mas de un tramite";
          break;
      case 'P':
          return "En padron (hacer rematriculacion)";
          break;
      default:
        return $t_mail;
      }
  }
  else {
    switch ($t_mail) {
      case 'E':
          return "Ya esta en Guarani";
          break;
      default:
        return $t_mail;
      }
    }
}

public function inicializar_consulta($error,$mensaje) {
  $datos = array();
	$data['error'] = $error;
	$data['mensaje'] = $mensaje;
	$data['accion'] = 'B';  // Va a buscar
	$data['tad'] = $datos;
  $data2['permisos'] = $this->permisos;
	$data2['titulo_menu'] = 'Consulta de TADs';
	$this->load->view('menu.php',$data2);
	$this->load->view('tad_view.php',$data);
}

public function obtener_where_tad($dni, $apellido, $nombre, $email, $estado) {  
  $where = '';
  if ($dni != '') {
      $where = ' NUMERO_DOCUMENTO = '.$dni;
  } 
  if ($nombre != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' NOMBRE_SOLICITANTE = "'.$nombre.'"';
  }	
  if ($estado != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . " estado = '".$estado."'";
  }	
  if ($apellido != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' APELLIDO_SOLICITANTE like "'. $apellido . '%"';
  }	
  if ($email != '') {
      if ($where != '') { $where = $where . ' and ';}
      $where = $where  . ' EMAIL like "'. $email . '%"';
  }
  return $where;
} 

public function Consulta_post() {  

  if ($this->input->post())  {
    $nombre = $this->input->post('nombre');
    $apellido = $this->input->post('apellido');
    $dni  = $this->input->post('dni');
    $email = $this->input->post('email');
    $activo  = $this->input->post('estado');
    if ($this->input->post('id_Expediente') != null) {
      $expediente  = $this->input->post('id_Expediente');
    }
    else {
      $expediente = '';
    }
    $data2['titulo_menu'] = 'Consulta de TADs';
    $data2['permisos'] = $this->permisos;
    $data['error'] = '';
    $data['mensaje'] = '';
    if ($expediente == ''){
      $w_tad =  $this->obtener_where_tad($dni, $apellido, $nombre, $email, $activo);
      $datos = $this->Tad_model->Get_Tads($w_tad,-1);  
      // Si no hay alumnos, debo informar error y mostrar solo los criterios de busqueda
      // Si hay mas de un alumno, debo mostrar la grilla para que elija
      if ((count($datos) == 0) or (count($datos) > 1)) { 
          if (count($datos) == 0) { 
              $data['error'] = 'Tramite no encontrado';
          } 
  /*            $cuantos = count($datos);
          for ($i = 0; $i < $cuantos;$i++ ) { 
              $datos[$i]['email'] = mb_convert_encoding($datos[$i]['email'], "UTF-8", "iso-8859-1"); 
              $datos[$i]['activo'] = mb_convert_encoding($datos[$i]['activo'], "UTF-8", "iso-8859-1"); 
          }*/
          $data['esgrilla'] = 'S';			
          $data['tad'] = $datos;
          $this->load->view('menu.php',$data2);
          $this->load->view('tad_view', $data);
          return;
      }
    }
    if ($expediente == '') {
      $expediente = $datos[0]['Expediente'];
    }

    $datos =  $this->Tad_model->Get_un_Tad($expediente,1); 
    if (count($datos) > 0) {
      $estado_mail = $datos[0]['mail_enviado_cbc'];
      if (($datos[0]['t_tramite'] == 'R') && ($datos[0]['mail_enviado_cbc'] == null) && 
          ($datos[0]['t_coincidencia'] == 'D') && ($datos[0]['en_padron'] == 'R')){
            $estado_mail = 'P';
      }   

      $datos[0]['d_t_mail_enviar_cbc'] = $this->Traducir_Nombre_Mail($datos[0]['t_mail_enviar_cbc'],$datos[0]['t_tramite']);
      $datos[0]['d_mail_enviado_cbc'] = $this->Traducir_Estado_Mail($estado_mail,$datos[0]['t_tramite'],$datos[0]['t_mail_enviar_cbc']);
      if ($datos[0]['guardado_exitoso']) {
        $datos[0]['guardado_exitoso'] = 'Si';
      } 
      else {
        $datos[0]['guardado_exitoso'] = 'No';
      } 
      if ($datos[0]['email_enviado']) {
        $datos[0]['email_enviado'] = 'Si';
      } 
      else {
        $datos[0]['email_enviado'] = 'No';
      } 
      if ($datos[0]['mail_enviado_cbc']) {
        $datos[0]['mail_enviado_cbc'] = 'Si';
      } 
      else {
        $datos[0]['mail_enviado_cbc'] = 'No';
      } 
    }
    $data['tad'] = $datos[0];
    $data['tab_activa'] = 1;
    $data2['titulo_menu'] = 'Consulta de TADs';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('tad_detalle_view', $data);
    return;
  }
  // Si hay no dni ingresado y no hay d_usuario, es porque toco buscar pero no ingreso datos a buscar
  else 
  {
    $datos = array();
    $data['tad'] = $datos;
    $data2['titulo_menu'] = 'Consulta de TADs';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('tad_view', $data);
  }
}


public function leer_errores_tad1() {
	$error = '';
	$this->iniciar_lectura($error);
}

public function iniciar_lectura($error) {
  //	$sedenombre = $this->session->userdata('nombre');
    $data['error'] = $error;
  //	$data2['nombre'] = $sedenombre;
    $data2['titulo_menu'] = 'Errores TAD 1';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('errores_tad_view.php',$data);
    $this->load->view('footer.php');
  }

  public function reprocesar_tad1() {
    $error = '';
    $aviso = '';
    $this->iniciar_reproceso($error,$aviso);
  }
  
  public function iniciar_reproceso($error,$aviso) {
    //	$sedenombre = $this->session->userdata('nombre');
      $data['error'] = $error;
      $data['aviso'] = $aviso;
    //	$data2['nombre'] = $sedenombre;
      $data2['titulo_menu'] = 'Reproceso casos a Revisar de TAD 1';
      $data2['permisos'] = $this->permisos;
      $this->load->view('menu.php',$data2);
      $this->load->view('reprocesotad_view.php',$data);
      $this->load->view('footer.php');
    }
  
public function cargas_ddjj() {
  $error = '';
  $this->iniciar_carga_ddjj($error);
}

public function iniciar_carga_ddjj($error) {
  //	$sedenombre = $this->session->userdata('nombre');
    $data['error'] = $error;
  //	$data2['nombre'] = $sedenombre;
    $data2['titulo_menu'] = 'Importar TAD DDJJ';
    $data2['permisos'] = $this->permisos;
    $this->load->view('menu.php',$data2);
    $this->load->view('subirtad_ddjj_view.php',$data);
    $this->load->view('footer.php');
}
  

public function cargas() {
	$error = '';
	$this->iniciar_carga($error);
}

public function iniciar_carga($error) {
//	$sedenombre = $this->session->userdata('nombre');
	$data['error'] = $error;
//	$data2['nombre'] = $sedenombre;
	$data2['titulo_menu'] = 'Importar TAD';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('subirtad_view.php',$data);
	$this->load->view('footer.php');
}

function cargas_post() {  
  $nombre_original = $_FILES["userfile"]["name"];
  if($this->upload->do_upload("userfile")) {
      $data = array('upload_data' => $this->upload->data());
      $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
      $full_file_name = $upload_data['full_path'];
      $file_name = $upload_data['file_name'];
      
      // Una vez subido el archivo, hay que importarlo en la tabla temporaria de tads

      // Si la tabla temporaria tiene filas borrar esas filas
      $this->Tad_model->Truncar_tabla('tad1_tmp');
      // Insertar el archivo en tad_archivos y obtener el id insertado
      $id_archivo = $this->Tad_model->InsertarArchivo($file_name,$nombre_original);
      if ($id_archivo < 0){
          $error = 'Error al insertar nombre de archivo';
          $this->iniciar_carga($error);
          return;
      }
      
      // Leer las filas del archivo csv e insertarlas en la tabla temporal. 
      $error = $this->importar_tad1($full_file_name, $id_archivo);
      // Si hay error de formato (mas o menos campos de los esperados) reportar error
      if ($error != '') {
          $this->iniciar_carga($error);
          return;
      }
      if ($this->Tad_model->LoteYaProcesado()) {
        $error = "Expedientes de este archivo ya fueron subidos";
        $this->iniciar_carga($error);
        return;
      }

      // Si no hay error, insertarlos en la tabla definitiva en estado I (inicial) y borrarlos de la tabla temporal
      $filas_insertadas = $this->Tad_model->InsertarEnTad($id_archivo);
      if ($filas_insertadas < 1) {
          $error = "Error al insertar archivo ".$file_name." en tabla definitiva";
          $this->iniciar_carga($error);
          return;
      }
      $resultado = $this->Tad_model->Numeros_archivo($id_archivo);
      $data['filas_insertadas'] = $filas_insertadas;
      $data['resultado'] = $resultado[0];
      $data['original'] = $nombre_original;
      $data['t_tramite'] = 'I';
      $data2['permisos'] = $this->permisos;
      $data2['titulo_menu'] = 'Importar TAD';
      $this->load->view('menu.php',$data2);
      $this->load->view('subirtad_success', $data);
      $this->load->view('footer.php');
}
else{
  $error = $this->upload->display_errors();
  $this->iniciar_carga($error);
} 
}


public function fputcsv2($handle, $row, $fd=';', $quot='"')
{
   $str='';
   $i = 0;
   foreach ($row as $cell) {
       if ($i == 0) {
        $cell = substr($cell,4);
        $i++;
       }
       $cell=str_replace(Array($quot,        "\n"),
                         Array($quot.$quot,  ''),
                         $cell);
       if (strchr($cell, $fd)!==FALSE || strchr($cell, $quot)!==FALSE) {
           $str.=$quot.$cell.$quot.$fd;
       } else {
           $str.=$cell.$fd;
       }
   }
   fputs($handle, substr($str, 0, -1)."\n");
   return strlen($str);
}

public function generar_csv_tad_ddjj(){
  $this->mostrar_csv_tad_ddjj('','');
}

public function generar_csv_tad1(){
  $this->mostrar_csv_tad1('','');
}

public function mostrar_csv_tad_ddjj($error,$aviso){
  $data['error'] = $error;
  $data['aviso'] = $aviso;
  $data2['t_tramite'] = 'J';
	$data2['titulo_menu'] = 'Generar TAD DDJJ';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('generar_tad1_view.php',$data);
	$this->load->view('footer.php');
  return;
}
public function mostrar_csv_tad1($error,$aviso){
  $data['error'] = $error;
  $data['aviso'] = $aviso;
  	$data2['t_tramite'] = 'I';
	$data2['titulo_menu'] = 'Generar TAD 1';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('generar_tad1_view.php',$data);
	$this->load->view('footer.php');
  return;
}

public function listar_csv_revisar_tad1(){
  $this->mostrar_csv_revisar_tad1('','');
}

public function mostrar_csv_revisar_tad1($error,$aviso){
  $data['error'] = $error;
  $data['aviso'] = $aviso;
	$data2['titulo_menu'] = 'Listar casos a revisar de TAD';
	$data2['permisos'] = $this->permisos;
	$this->load->view('menu.php',$data2);
	$this->load->view('r_tad_view.php',$data);
	$this->load->view('footer.php');
  return;
}

public function descargar_archivo($archivo,$nombre_fichero) {
  $fichero_local = $archivo;
  //compruebo, por si acaso, que el fichero exista en el sistema
  if( file_exists($fichero_local ) && is_file($fichero_local) ) {
  header('Cache-control: private');
  header('Content-Type: application/octet-stream; charset=iso-8859-1');
  header('Content-Length: '.filesize($fichero_local));
  header('Content-Disposition: filename='.$nombre_fichero);
  // flush content
  flush();
  //abrimos el fichero
  $file = fopen($fichero_local , "rb");
  //imprimimos el contenido del fichero al navegador
  print fread ($file, filesize($fichero_local ));
  //cerramos el fichero abierto
  fclose($file);
  }
  }

  
  public function generar_tad_ddjj(){
  
    if ($this->input->post())  {
      $t_tramite = $this->input->post('t_tramite');
      $estados_a_incluir = $this->input->post('estados_a_incluir');
      $tads = $this->Tad_model->obtener_tad($estados_a_incluir,$t_tramite); 
      if (count($tads) < 1) {
        $aviso = 'No hay tramites para exportar con las condiciones solicitadas ';
        $error = '';
        $this->mostrar_csv_tad_ddjj($error,$aviso);
        return;        
      }
      $date   = new DateTime(); 
      $tstamp = $date->format('Ymd-His');
      $filename = './tad/Tad_'.$t_tramite.'.csv';
      $nombrearchivo = 'Tad_'.$t_tramite.'_'.$tstamp.'.csv';
      if (file_exists($filename) ) {
          unlink($filename);
      }      
      if (!$handle = fopen($filename, 'wa')) {
        $error = 'Error al generar el csv '.$filename;
        $aviso = '';
        $this->mostrar_csv_tad_ddjj($error,$aviso);
        return;        
      }
      $cabecera = "Fecha caratulación;Expediente;Estado expediente;Documento FINUB;Repartición actual del expediente;Sector actual del expediente;Fecha de último pase;EMAIL;NOMBRE_SOLICITANTE;APELLIDO_SOLICITANTE;CUIT_CUIL;TIPO_DOCUMENTO;NUMERO_DOCUMENTO;DOC_ESTUDIOS_MEDIOS";
      $cabecera .= PHP_EOL;
      fwrite($handle, $cabecera);
      foreach($tads as $val) {
        if (substr($val['DOC_ESTUDIOS_MEDIOS'],-3) == '[5]') {
          $val['DOC_ESTUDIOS_MEDIOS'] = '[3]';
        }
        $renglon = implode(';',$val);
        $renglon .= PHP_EOL;
        fwrite($handle, $renglon);
      }
      $renglon = ' '.PHP_EOL;
      fwrite($handle, $renglon);
      fclose($handle);
      $this->Tad_model->cambiar_estado_tad($estados_a_incluir,$t_tramite);  
      $this->descargar_archivo($filename,$nombrearchivo);
      exit;      
    } 
    else {
      $error = 'Error al generar csv';
      $aviso = '';
      $this->mostrar_csv_tad_ddjj($error,$aviso);
      return;
    }
  
  }
  
public function generar_tad1(){
  
	if ($this->input->post())  {
    $t_tramite = $this->input->post('t_tramite');
	  $estados_a_incluir = $this->input->post('estados_a_incluir');
    $tads = $this->Tad_model->obtener_tad($estados_a_incluir,$t_tramite); 
    if (count($tads) < 1) {
      $aviso = 'No hay tramites para exportar con las condiciones solicitadas ';
      $error = '';
      $this->mostrar_csv_tad1($error,$aviso);
      return;        
    }
    $date   = new DateTime(); 
    $tstamp = $date->format('Ymd-His');
    $filename = './tad/Tad_'.$t_tramite.'.csv';
	  $nombrearchivo = 'Tad_'.$t_tramite.'_'.$tstamp.'.csv';
    if (file_exists($filename) ) {
        unlink($filename);
    }      
    if (!$handle = fopen($filename, 'wa')) {
      $error = 'Error al generar el csv '.$filename;
      $aviso = '';
      $this->mostrar_csv_tad1($error,$aviso);
      return;        
    }
    $cabecera = "Fecha caratulación;Expediente;Estado expediente;Documento FINUB;Repartición actual del expediente;Sector actual del expediente;Fecha de último pase;EMAIL;TELEFONO;NOMBRE_SOLICITANTE;APELLIDO_SOLICITANTE;RAZON_SOCIAL_SOLICITANTE;SEGUNDO_APELLIDO_SOLICITANTE;TERCER_APELLIDO_SOLICITANTE;SEGUNDO_NOMBRE_SOLICITANTE;TERCER_NOMBRE_SOLICITANTE;CUIT_CUIL;DOMICILIO;PISO;DPTO;CODIGO_POSTAL;BARRIO;COMUNA;ALTURA;PROVINCIA;DEPARTAMENTO;LOCALIDAD;TIPO_DOCUMENTO;NUMERO_DOCUMENTO;FECHA_NAC;GENERO;NACIONALIDAD;LUGAR_NAC_BAHRA_PROVINCIA;LUGAR_NAC_BAHRA_DPTO;LUGAR_NAC_BAHRA_LOCALIDAD;REQUIERE_CERTIF_ESP;DISCAPACIDAD;CARRERA_A_SEGUIR;TRABAJA;DOC_ESTUDIOS_MEDIOS;OPCION_MAT_ELECTIVA";
    $cabecera .= PHP_EOL;
    fwrite($handle, $cabecera);
    foreach($tads as $val) {
      if (substr($val['DOC_ESTUDIOS_MEDIOS'],-3) == '[5]') {
        $val['DOC_ESTUDIOS_MEDIOS'] = '[3]';
      }
      $renglon = implode(';',$val);
      $renglon .= PHP_EOL;
      fwrite($handle, $renglon);
    }
    $renglon = ' '.PHP_EOL;
    fwrite($handle, $renglon);
    fclose($handle);
    $this->Tad_model->cambiar_estado_tad($estados_a_incluir,$t_tramite);  
    $this->descargar_archivo($filename,$nombrearchivo);
    exit;      
/*      $cabecera = array("    Fecha caratulación","Expediente","Estado expediente","Documento FINUB","Repartición actual del expediente","Sector actual del expediente","Fecha de último pase","EMAIL","TELEFONO","NOMBRE_SOLICITANTE","APELLIDO_SOLICITANTE","RAZON_SOCIAL_SOLICITANTE","SEGUNDO_APELLIDO_SOLICITANTE","TERCER_APELLIDO_SOLICITANTE","SEGUNDO_NOMBRE_SOLICITANTE","TERCER_NOMBRE_SOLICITANTE","CUIT_CUIL","DOMICILIO","PISO","DPTO","CODIGO_POSTAL","BARRIO","COMUNA","ALTURA","PROVINCIA","DEPARTAMENTO","LOCALIDAD","TIPO_DOCUMENTO","NUMERO_DOCUMENTO","FECHA_NAC","GENERO","NACIONALIDAD","LUGAR_NAC_BAHRA_PROVINCIA","LUGAR_NAC_BAHRA_DPTO","LUGAR_NAC_BAHRA_LOCALIDAD","REQUIERE_CERTIF_ESP","DISCAPACIDAD","CARRERA_A_SEGUIR","TRABAJA","DOC_ESTUDIOS_MEDIOS","OPCION_MAT_ELECTIVA");
      array_unshift($tads, $cabecera);
      $this->Tad_model->cambiar_estado_tad1($estados_a_incluir,$t_tramite);  

      header('Content-Type: application/octet-stream; charset=iso-8859-1');
      header("Content-disposition: attachment; filename=tad1.csv"); 
      
      //preparar el wrapper de salida
      $outputBuffer = fopen("php://output", 'w');
       
      //volcamos el contenido del array en formato csv
      foreach($tads as $val) {
          $this->funcs_lib->fputcsv2($outputBuffer, $val, ";", '"'); 
      }
      //cerramos el wrapper
      fclose($outputBuffer);
      header_remove(); 
      exit;*/

/*
      $error = '';
      $aviso = 'Archivo generado correctamente';
      $this->mostrar_csv_tad1($error,$aviso);     
      return;     */
  } 
  else {
    $error = 'Error al generar csv';
    $aviso = '';
    $this->mostrar_csv_tad1($error,$aviso);
    return;
  }

}

public function CruzarConPadron($data,$t_tramite){
  $en_padron = 'N';
  $anio = 0;
  $clave = 0;
  $baja = 'N';
  $sancion = 'N';
  $dni = $data['NUMERO_DOCUMENTO'];
  $apellido = $data['APELLIDO_SOLICITANTE'];
  $apellido = ltrim(rtrim(strtoupper($apellido)));
  $ape3 = substr($apellido,0,3);
  $ape3 = $this->funcs_lib->eliminar_tildes($ape3);
  if ($t_tramite <> 'J') {
    $fnac = $data['FECHA_NAC'];
    $email = $data['EMAIL'];
  }
  $t_coincidencia = '';
  $cruce = array();

  // Cruzar dni y ape3 con padron
  $alumno = $this->Tad_model->existe_por_dni_y_ape($dni, $ape3);
  if (count($alumno) > 0) {
    if ($alumno[0]['SANCION'] == 1) {$sancion = 'S'; }
    if ($alumno[0]['BAJA'] == 1) {$baja = 'S'; }
    $en_padron = 'S';
    $anio = $alumno[0]['ANIO'];
    $clave = $alumno[0]['CLAVE'];
  }  
  else {
    // Si no esta, buscar por dni
    $alumno = $this->Tad_model->existe_por_dni($dni);
    //    Si esta ---> revisar
    if (count($alumno) > 0) {
      $en_padron = 'R';
      $anio = $alumno[0]['ANIO'];
      $clave = $alumno[0]['CLAVE'];
      $t_coincidencia = 'D';
    }  
    else {
      if ($t_tramite <> 'J') {
      //    Si no esta buscar por mail
        $alumno = $this->Tad_model->existe_por_mail($email);
      //Si esta ---> revisar
        if (count($alumno) > 0) {
          $en_padron = 'R';
          $anio = $alumno[0]['ANIO'];
          $clave = $alumno[0]['CLAVE'];
          $t_coincidencia = 'M';
        }  
        else {
          //    Si no esta y es extranjero, buscar por apellido y fecha nac
          if ($dni > 90000000) {
            $alumno = $this->Tad_model->existe_por_apellido_fnac($apellido,$fnac);
            //    Si esta ---> revisar
            if (count($alumno) > 0) {
              $en_padron = 'R';
              $anio = $alumno[0]['ANIO'];
              $clave = $alumno[0]['CLAVE'];
              $t_coincidencia = 'F';
            }
          }
        }
      }
    }
  }
  
  $cruce['t_coincidencia'] = $t_coincidencia;
  $cruce['en_padron'] = $en_padron;
  $cruce['anio'] = $anio;
  $cruce['clave'] = $clave;
  $cruce['baja'] = $baja;
  $cruce['sancion'] = $sancion;
  return $cruce;
}

public function CruzarConGuarani($data,$t_tramite){
  $en_guarani = 'N';
  $persona = 0;
  $t_coincidencia = null;
  $plan_guarani = null;
  $dni = $data['NUMERO_DOCUMENTO'];
  $apellido = $data['APELLIDO_SOLICITANTE'];
  $apellido = ltrim(rtrim(strtoupper($apellido)));
  $ape3 = substr($apellido,0,3);
  $ape3 = $this->funcs_lib->eliminar_tildes($ape3);
  if ($t_tramite <> 'J') {
    $fnac = $data['FECHA_NAC'];
    $email = $data['EMAIL'];
  }
  $cruce = array();

  // Cruzar dni y ape3 con padron
  $guarani = $this->Tad_model->existe_por_dni_Guarani($dni); 

  if (count($guarani) > 0) {
    // Si tiro un TAD1 y el alumno estaba en guarani, no hay que subir el tramite y hay que enviar un mail avisando fechas de inscrip o que haga cambio de requisitos
    $persona = $guarani[0]['persona'];
    $plan_guarani = $guarani[0]['plan_codigo'];
    $ape3_g = strtoupper(substr($guarani[0]['apellido'],0,3));
    $ape3_g = $this->funcs_lib->eliminar_tildes($ape3_g);
    if ($ape3_g == $ape3) {
      $en_guarani = 'S';
    } 
    else {
      $en_guarani = 'R';
      $t_coincidencia = 'D';
    }       
  }
  else {
    if ($t_tramite <> 'J') {
      // Cruzo por mail
      $guarani = $this->Tad_model->Get_Datos_Guarani_Mail($email); 
      if (count($guarani) > 0) {
        // Si tiro un TAD1 y el mail estaba en guarani, hay que marcar para revisar
        $persona = $guarani[0]['persona'];
        $plan_guarani = $guarani[0]['plan_codigo'];
        $en_guarani = 'R';
        $t_coincidencia = 'M';
      }       
      else {
        if ($dni > 90000000) {  
          $guarani = $this->Tad_model->Get_Datos_Guarani_ApeFec($apellido,$fnac); 
          if (count($guarani) > 0) {
            // Si tiro un TAD1 y la fecha de nac. + apellido estaba en guarani, hay que marcar para revisar
            $persona = $guarani[0]['persona'];
            $plan_guarani = $guarani[0]['plan_codigo'];
            $en_guarani = 'R';
            $t_coincidencia = 'F';
          }
        }
      }       
    }
  }
  $cruce['t_coincidencia_g'] = $t_coincidencia;
  $cruce['en_guarani']  = $en_guarani;
  $cruce['persona']     = $persona;
  $cruce['plan_codigo'] = $plan_guarani;
  return $cruce;
}

public function Convertir_a_array_asociativo($data) {
  $datos = array();
  $i = 0;
  $datos['Fecha_caratulacion'] = $data[$i++];
  $datos['Expediente'] = $data[$i++];
  $datos['Estado_expediente'] = $data[$i++];
  $datos['Documento_FINUB'] = $data[$i++];
  $datos['Reparticion_actual_del_expediente'] = $data[$i++];
  $datos['Sector_actual_del_expediente'] = $data[$i++];
  $datos['Fecha_de_ultimo_pase'] = $data[$i++];
  $datos['EMAIL'] = $data[$i++];
  $datos['TELEFONO'] = $data[$i++];
  $datos['NOMBRE_SOLICITANTE'] = $data[$i++];
  $datos['APELLIDO_SOLICITANTE'] = $data[$i++];
  $datos['RAZON_SOCIAL_SOLICITANTE'] = $data[$i++];
  $datos['SEGUNDO_APELLIDO_SOLICITANTE'] = $data[$i++];
  $datos['TERCER_APELLIDO_SOLICITANTE'] = $data[$i++];
  $datos['SEGUNDO_NOMBRE_SOLICITANTE'] = $data[$i++];
  $datos['TERCER_NOMBRE_SOLICITANTE'] = $data[$i++];
  $datos['CUIT_CUIL'] = $data[$i++];
  $datos['DOMICILIO'] = $data[$i++];
  $datos['PISO'] = $data[$i++];
  $datos['DPTO'] = $data[$i++];
  $datos['CODIGO_POSTAL'] = $data[$i++];
  $datos['BARRIO'] = $data[$i++];
  $datos['COMUNA'] = $data[$i++];
  $datos['ALTURA'] = $data[$i++];
  $datos['PROVINCIA'] = $data[$i++];
  $datos['DEPARTAMENTO'] = $data[$i++];
  $datos['LOCALIDAD'] = $data[$i++];
  $datos['TIPO_DOCUMENTO'] = $data[$i++];
  $datos['NUMERO_DOCUMENTO'] = $data[$i++];
  $fnac = $data[$i++];
  $dd = substr($fnac,0,2);
  $mm = substr($fnac,3,2);
  $yy = substr($fnac,6,4);
  $fnac = $yy . '-' . $mm . '-' . $dd;
  $datos['FECHA_NAC'] = $fnac;
  $datos['GENERO'] = $data[$i++];
  $datos['NACIONALIDAD'] = $data[$i++];
  $datos['LUGAR_NAC_BAHRA_PROVINCIA'] = $data[$i++];
  $datos['LUGAR_NAC_BAHRA_DPTO'] = $data[$i++];
  $datos['LUGAR_NAC_BAHRA_LOCALIDAD'] = $data[$i++];
  $datos['REQUIERE_CERTIF_ESP'] = $data[$i++];
  $datos['DISCAPACIDAD'] = $data[$i++];
  $datos['CARRERA_A_SEGUIR'] = $data[$i++];
  $datos['TRABAJA'] = $data[$i++];
  $datos['DOC_ESTUDIOS_MEDIOS'] = $data[$i++];
  $datos['OPCION_MAT_ELECTIVA'] = $data[$i++];
  $datos['mensaje'] = $data[$i++];
/*    $datos['NOMBRE_SOLICITANTE'] = mb_convert_encoding($datos['NOMBRE_SOLICITANTE'],"iso-8859-1", "UTF-8");
    $datos['APELLIDO_SOLICITANTE'] = mb_convert_encoding($datos['APELLIDO_SOLICITANTE'],"iso-8859-1", "UTF-8");
    $datos['LOCALIDAD'] = mb_convert_encoding($datos['LOCALIDAD'],"iso-8859-1", "UTF-8");
    $datos['DOMICILIO'] = mb_convert_encoding($datos['DOMICILIO'],"iso-8859-1", "UTF-8");*/
  return $datos;
}

public function Convertir_a_array_asociativo_ddjj($data) {
  $datos = array();
  $i = 0;
  $datos['Fecha_caratulacion'] = $data[$i++];
  $datos['Expediente'] = $data[$i++];
  $datos['Estado_expediente'] = $data[$i++];
  $datos['Documento_FINUB'] = $data[$i++];
  $datos['Reparticion_actual_del_expediente'] = $data[$i++];
  $datos['Sector_actual_del_expediente'] = $data[$i++];
  $datos['Fecha_de_ultimo_pase'] = $data[$i++];
  $datos['EMAIL'] = $data[$i++];
  $datos['NOMBRE_SOLICITANTE'] = $data[$i++];
  $datos['APELLIDO_SOLICITANTE'] = $data[$i++];
  $datos['CUIT_CUIL'] = $data[$i++];
  $datos['TIPO_DOCUMENTO'] = $data[$i++];
  $datos['NUMERO_DOCUMENTO'] = $data[$i++];
  $datos['DOC_ESTUDIOS_MEDIOS'] = $data[$i++];
  $datos['mensaje'] = $data[$i++];
/*    $datos['NOMBRE_SOLICITANTE'] = mb_convert_encoding($datos['NOMBRE_SOLICITANTE'],"iso-8859-1", "UTF-8");
    $datos['APELLIDO_SOLICITANTE'] = mb_convert_encoding($datos['APELLIDO_SOLICITANTE'],"iso-8859-1", "UTF-8");
    $datos['LOCALIDAD'] = mb_convert_encoding($datos['LOCALIDAD'],"iso-8859-1", "UTF-8");
    $datos['DOMICILIO'] = mb_convert_encoding($datos['DOMICILIO'],"iso-8859-1", "UTF-8");*/
  return $datos;
}

public function InsertarEnTemporal($datos,$id_archivo,$cruce,$t_tramite,$cruce_g){
    $datos['id_archivo_tad'] = $id_archivo;
    $datos['t_coincidencia'] = $cruce['t_coincidencia'];
    $datos['en_padron'] = $cruce['en_padron'];
    $datos['anio'] = $cruce['anio'];
    $datos['clave'] = $cruce['clave'];
    $datos['baja'] = $cruce['baja'];
    $datos['sancion'] = $cruce['sancion'];
    $datos['t_coincidencia_g'] = $cruce_g['t_coincidencia_g'];
    $datos['en_guarani'] = $cruce_g['en_guarani'];
    $datos['persona'] = $cruce_g['persona'];
    $datos['plan_codigo'] = $cruce_g['plan_codigo'];    
    $datos['t_tramite'] = $t_tramite;  
    $datos['estado'] = 'I';  
    $datos['mail_enviado_cbc'] = null;   

    $cuil = $datos['CUIT_CUIL'];
    $cuantos = $this->Tad_model->existe_por_cuil_tad_tmp($cuil,$t_tramite) + $this->Tad_model->existe_por_cuil_tad($cuil,$t_tramite);  

    // Si tiro un TAD1 y el alumno estaba en guarani, no hay que subir el tramite y hay que enviar un mail avisando fechas de inscrip o que haga cambio de requisitos
    if ($datos['en_guarani'] == 'S') {
      $datos['estado'] = 'N';   // No corresponde subir
      $datos['mail_enviado_cbc'] = 'P';   
      if ($datos['plan_codigo'] >= 2000) {
        $datos['t_mail_enviar_cbc'] = '2';            
      }
      else {
          $datos['t_mail_enviar_cbc'] = '1';            
      }
    } 

    if (($datos['estado'] <> 'N') && ($datos['en_padron'] == 'S')) {
      $datos['estado'] = 'N';   // No corresponde subir porque esta en padron de CBC
      $datos['mail_enviado_cbc'] = 'P';   
      $datos['t_mail_enviar_cbc'] = 'P';    
    }

    if (($datos['estado'] <> 'N') && ($cuantos > 0)) {
      $datos['estado'] = 'N';   // No corresponde subir porque ya habia tirado un tramite
  /*    $datos['mail_enviado_cbc'] = 'P';   
      $datos['t_mail_enviar_cbc'] = 'R';  */          
    }

    if (($datos['estado'] <> 'N') && (($datos['en_guarani'] == 'R') || ($datos['en_padron'] == 'R'))) {
      $datos['estado'] = 'R';   // revisar
    }

    return ($this->Tad_model->InsertarEnTemporal($datos) > 0);
}

public function InsertarEnTemporal_ddjj($datos,$id_archivo,$cruce,$t_tramite,$cruce_g){
  $datos['id_archivo_tad'] = $id_archivo;
  $datos['t_coincidencia'] = $cruce['t_coincidencia'];
  $datos['en_padron'] = $cruce['en_padron'];
  $datos['anio'] = $cruce['anio'];
  $datos['clave'] = $cruce['clave'];
  $datos['baja'] = $cruce['baja'];
  $datos['sancion'] = $cruce['sancion'];
  $datos['t_coincidencia_g'] = $cruce_g['t_coincidencia_g'];
  $datos['en_guarani'] = $cruce_g['en_guarani'];
  $datos['persona'] = $cruce_g['persona'];
  $datos['plan_codigo'] = $cruce_g['plan_codigo'];    
  $datos['t_tramite'] = $t_tramite;  
  $datos['estado'] = 'I';  
  $datos['mail_enviado_cbc'] = null;   

  $cuil = $datos['CUIT_CUIL'];
  $cuantos = $this->Tad_model->existe_por_cuil_tad_tmp($cuil,$t_tramite) + $this->Tad_model->existe_por_cuil_tad($cuil,$t_tramite);  

  // Si tiro un TAD ddjj y el alumno estaba en guarani, no hay que subir el tramite y hay que enviar un mail avisando fechas de inscrip o que haga cambio de requisitos
  if ($datos['en_guarani'] == 'S') {
    if ($datos['plan_codigo'] >= 2000) {
        $datos['estado'] = 'N';   // No corresponde subir requisito, el alumno ya esta en plan 2000
        if ($datos['en_padron'] == 'N') { // Si estaba en plan 2000 y no figuraba en padron, es un total21. No necesitaba tirar cambio de requisito 
          $datos['mail_enviado_cbc'] = 'P';   
          $datos['t_mail_enviar_cbc'] = 'X';  //2000nopadtot
        }
        else { // Si estaba en plan 2000 y figuraba en padron, no correspondia hacer cambio de requisito
          $datos['mail_enviado_cbc'] = 'P';   
          $datos['t_mail_enviar_cbc'] = 'Q';  //2000padtot
        }          
    }
    else {  // Es un plan 1000
      if ($datos['en_padron'] == 'S') { // Si estaba en plan 1000 y figuraba en padron 
          $datos['estado'] = 'R';   // Revisar porque no deberia pasar que esté en plan 1000 y en padron
          $datos['t_coincidencia'] = 'A';   // anomalia 
        }
      else {
        // hay que generar el cambio de requisito 
        $datos['estado'] = 'I';
      }    
    }
  } 
  else { // Si no está en guarani
    if ($datos['en_guarani'] == 'N') {
      $datos['estado'] = 'N';
      if ($datos['en_padron'] == 'S') { // Si estaba padron y no en guarani y tiro ddjj, hay que subirlo como rematriculacion
        // generar rematriculacion
        $datos['t_coincidencia'] = 'R';   // Rematricular
      }
      else {
        // hay que avisar que tendria que haber tirado tad de inscripcion
        $datos['mail_enviado_cbc'] = 'P';   
        $datos['t_mail_enviar_cbc'] = 'O';  // Noguaranopadtot
      }    
    }
  }

  if (($datos['estado'] <> 'N') && ($cuantos > 0)) {
    $datos['estado'] = 'N';   // No corresponde subir porque ya habia tirado un tramite
    $datos['mail_enviado_cbc'] = 'P';   
    $datos['t_mail_enviar_cbc'] = 'R';    // masde1
  }

  if (($datos['estado'] <> 'N') && (($datos['en_guarani'] == 'R') || ($datos['en_padron'] == 'R'))) {
    $datos['estado'] = 'R';   // revisar
  }

  return ($this->Tad_model->InsertarEnTemporal_ddjj($datos) > 0);
}


public function importar_tad1($full_file_name, $id_archivo) {
$k_dni = 28;
$k_cuil = 16;
$k_expediente = 1;
$k_fecha_ult_pase = 6;
$k_nombre = 9;
$k_apellido = 10;
$k_idioma = 35;
$k_discap = 36;
$k_carrera = 37;
$k_trabaja = 38;
$k_condicion = 39;
$k_fecha_nac = 29;
$k_fila_titulos = 1;
$k_delimitador = ";"; //\t";
$t_tramite = 'I';    // Tramite de Inscripcion a UBA - Tad 1 "I"

$file_name = basename($full_file_name);  
$file_name_f = dirname($full_file_name).'/formato_'.$file_name;
$mensaje_error = '';

$date   = new DateTime(); //this returns the current date time
$tstamp = $date->format('Ymd-His');
$ok = true;

$fp_formato = fopen($file_name_f, 'w');  

if (($handle = fopen($full_file_name, "r")) !== FALSE) {  
  $i = 0;
  while (($data = fgetcsv($handle, 0, $k_delimitador)) !== FALSE) {  
    $i++;
    $error = '';
    if (($i > $k_fila_titulos) && isset($data[$k_dni])){
      $dni = $data[$k_dni];
      $cuil= $data[$k_cuil];
      $dni_en_cuil = substr($cuil,2,8);
      if ($dni <> $dni_en_cuil) {
        $dni = $dni_en_cuil;
        $data[$k_dni] = $dni_en_cuil;
      }    
      if (rtrim($data[$k_idioma]) == '') { $data[$k_idioma] = 'No';}     // Certif.Idioma
      if (rtrim($data[$k_discap]) == '') { $data[$k_discap] = 'No';}     // Discapacitado
      if (rtrim($data[$k_trabaja]) == '') { $data[$k_trabaja] = 'No';}   // Trabaja
      $data[$k_nombre]   = $this->funcs_lib->eliminar_tildes($data[$k_nombre]);
      $data[$k_apellido] = $this->funcs_lib->eliminar_tildes($data[$k_apellido]);
      $data[$k_nombre]   = ltrim(rtrim(strtoupper($data[$k_nombre])));
      $data[$k_apellido] = ltrim(rtrim(strtoupper($data[$k_apellido])));
//      echo $i;
      if ((count($data) != $cant_campos) || (!(is_numeric($cuil)))  || (!(is_numeric($dni)))   || ($dni_en_cuil != $dni) || (rtrim($data[$k_condicion]) == ''))  {
        if (count($data) != $cant_campos) {
          $error =  'Registro desplazado';
        } 
        else {
          if (!(is_numeric($cuil))) {
              $error = 'CUIL no numerico';  
          } 
          else {
            if (!(is_numeric($dni))) {
              $error = 'DNI no numerico';  
            } 
            else { 
              if (rtrim($data[$k_condicion]) == '') {
                  $error =  'Condicion no indicada';  
              } 
              else {
                $error = 'DNI y CUIL no concuerdan: '.$dni_en_cuil.' y '.$dni;  
              }
            }
          }            
        }
        $ok = false;
        $mensaje_error = 'Error/es de formato en el archivo de entrada: '.$error.' (fila '.$i.')';
      }
      $data[] = $error;
    } 
    else {
      if ($i == $k_fila_titulos) {
        $cant_campos = count($data);
      }
    }

    if ($i > $k_fila_titulos) { 
        if ($error <> '') {
            fputcsv($fp_formato, $data, ";", '"'); 
        }
        if ($ok) {
            $datos = $this->Convertir_a_array_asociativo($data);
//            $ape3 = substr($datos['APELLIDO_SOLICITANTE'],0,3);
//            $guarani = $this->Tad_model->existe_por_dni_Guarani($dni); 
            $cruce_g = $this->CruzarConGuarani($datos,$t_tramite);
            $cruce = $this->CruzarConPadron($datos,$t_tramite);
            if (!($this->InsertarEnTemporal($datos,$id_archivo,$cruce,$t_tramite,$cruce_g))) {
                $mensaje_error = ltrim($mensaje_error . '  ') . "Error al insertar fila ".$i." en tabla temporal";
                $data[] = "Error al insertar fila ".$i." en tabla temporal";
                fputcsv($fp_formato, $data, ";", '"'); 
                fclose($handle);  
                fclose($fp_formato);  
                return $mensaje_error;
            }
        }
    }
  }	 
}  
fclose($handle);  
fclose($fp_formato);  
return $mensaje_error;
}  

public function importar_tad_ddjj($full_file_name, $id_archivo) {
  $k_dni = 12;
  $k_cuil = 10;
  $k_expediente = 2;
  $k_fecha_ult_pase = 7;
  $k_nombre = 8;
  $k_apellido = 9;
  $k_condicion = 13;
  $k_fila_titulos = 1;
  $k_delimitador = ";"; //\t";
  $t_tramite = 'J';    // Tramite de ddjj - Tad ddjj "J"
  
  $file_name = basename($full_file_name);  
  $file_name_f = dirname($full_file_name).'/formato_'.$file_name;
  $mensaje_error = '';
  
  $date   = new DateTime(); //this returns the current date time
  $tstamp = $date->format('Ymd-His');
  $ok = true;
  
  $fp_formato = fopen($file_name_f, 'w');  
  
  if (($handle = fopen($full_file_name, "r")) !== FALSE) {  
    $i = 0;
    while (($data = fgetcsv($handle, 0, $k_delimitador)) !== FALSE) {  
      $i++;
      $error = '';
      if (($i > $k_fila_titulos) && isset($data[$k_dni])){
        $dni = $data[$k_dni];
        $cuil= $data[$k_cuil];
        $dni_en_cuil = substr($cuil,2,8);
        if ($dni <> $dni_en_cuil) {
          $dni = $dni_en_cuil;
          $data[$k_dni] = $dni_en_cuil;
        }    
        $data[$k_nombre]   = $this->funcs_lib->eliminar_tildes($data[$k_nombre]);
        $data[$k_apellido] = $this->funcs_lib->eliminar_tildes($data[$k_apellido]);
        $data[$k_nombre]   = ltrim(rtrim(strtoupper($data[$k_nombre])));
        $data[$k_apellido] = ltrim(rtrim(strtoupper($data[$k_apellido])));
  
        if ((count($data) != $cant_campos) || (!(is_numeric($cuil)))  || (!(is_numeric($dni)))   || ($dni_en_cuil != $dni) || (rtrim($data[$k_condicion]) == ''))  {
          if (count($data) != $cant_campos) {
            $error =  'Registro desplazado';
          } 
          else {
            if (!(is_numeric($cuil))) {
                $error = 'CUIL no numerico';  
            } 
            else {
              if (!(is_numeric($dni))) {
                $error = 'DNI no numerico';  
              } 
              else { 
                if (rtrim($data[$k_condicion]) == '') {
                    $error =  'Condicion no indicada';  
                } 
                else {
                  $error = 'DNI y CUIL no concuerdan: '.$dni_en_cuil.' y '.$dni;  
                }
              }
            }            
          }
          $ok = false;
          $mensaje_error = 'Error/es de formato en el archivo de entrada: '.$error.' (fila '.$i.')';
        }
        $data[] = $error;
      } 
      else {
        if ($i == $k_fila_titulos) {
          $cant_campos = count($data);
        }
      }
  
      if ($i > $k_fila_titulos) { 
          if ($error <> '') {
              fputcsv($fp_formato, $data, ";", '"'); 
          }
          if ($ok) {
              $datos = $this->Convertir_a_array_asociativo_ddjj($data);
  //            $ape3 = substr($datos['APELLIDO_SOLICITANTE'],0,3);
  //            $guarani = $this->Tad_model->existe_por_dni_Guarani($dni); 
              $cruce_g = $this->CruzarConGuarani($datos,$t_tramite);
              $cruce = $this->CruzarConPadron($datos,$t_tramite);
              if (!($this->InsertarEnTemporal_ddjj($datos,$id_archivo,$cruce,$t_tramite,$cruce_g))) {
                  $mensaje_error = ltrim($mensaje_error . '  ') . "Error al insertar fila ".$i." en tabla temporal";
                  $data[] = "Error al insertar fila ".$i." en tabla temporal";
                  fputcsv($fp_formato, $data, ";", '"'); 
                  fclose($handle);  
                  fclose($fp_formato);  
                  return $mensaje_error;
              }
          }
      }
    }	 
  }  
  fclose($handle);  
  fclose($fp_formato);  
  return $mensaje_error;
  }  
  
public function listar_tad(){
  {
   $t_tramite = 'I';
   $file_name = 'revisar_'.date('Ymd').'.csv'; 
   $dde  = $_GET["fechaInicio"];
   $hta  = $_GET["fechaFin"];
 
   $timestamp = strtotime($dde);
   $dde = date("d-m-Y", $timestamp);
    
   $timestamp = strtotime($hta);
   $hta_orig = date("d-m-Y", $timestamp);
   $hta = date("d-m-Y", strtotime($hta_orig.' +1 day'));
 
   $tads = $this->Tad_model->R_tad_revisar($t_tramite,$dde,$hta);

 if (count($tads) < 1) {
    $aviso = 'No hay tramites para revisar';
    $error = '';
    $this->mostrar_csv_revisar_tad1($error,$aviso);
    return;        
  }
  $date   = new DateTime(); 
  $tstamp = $date->format('Ymd-His');
  $filename = './tad/Revisar.csv';
  $nombrearchivo = 'revisar_'.$tstamp.'.csv';
  if (file_exists($filename) ) {
      unlink($filename);
  }      
  if (!$handle = fopen($filename, 'wa')) {
    $error = 'Error al generar el csv '.$filename;
    $aviso = '';
    $this->mostrar_csv_tad1($error,$aviso);
    return;        
  }
  $cabecera = "Expediente;Fecha Caratulacion;APELLIDO_SOLICITANTE;NOMBRE_SOLICITANTE;EMAIL;TELEFONO; CUIT_CUIL;NUMERO_DOCUMENTO;FECHA_NAC;GENERO;NACIONALIDAD;CARRERA_A_SEGUIR;En Guarani?;coincidencia Guarani;Plan;DNI en Guarani;Apellido en Guarani;Nombre en Guarani;CUIL en Guarani;F.Nac. en Guarani;Persona;En Padron?;coincidencia Padron;clave;anio;DNI en Padtot;Apellido en Padtot;Nombre en Padtot;CUIL en Padtot;F.Nac. en Padtot;baja;sancion;t_tramite";
  $cabecera .= PHP_EOL;
  fwrite($handle, $cabecera);
  foreach($tads as $val) {
    $en_padron = substr($val['en_padron'],0,1);
    $en_guarani = substr($val['en_guarani'],0,1);

    $val['fnac_p'] = null;
    if (($en_padron == 'S') or  ($en_padron == 'R')) {
      $anio = $val['anio'];
      $clave = $val['clave'];
      $datos_padron = $this->Lectivo_model->Datos_Padron($anio,$clave);

      if (count($datos_padron) > 0) {
          $val['dni_p'] = $datos_padron[0]['dni'];  
          $val['apellido_p'] = /*mb_convert_encoding(*/$datos_padron[0]['apellido']; //, "UTF-8", "iso-8859-1"); 
          $val['nombre_p'] = /*mb_convert_encoding(*/$datos_padron[0]['nombre']; //, "UTF-8", "iso-8859-1");  
          $val['cuil_p'] = $datos_padron[0]['cuil'];  
          $val['fnac_p'] =  (($datos_padron[0]['fecha_naci'] != '') && ($datos_padron[0]['fecha_naci'] != '0000-00-00')) ?$datos_padron[0]['fecha_naci']:'';  
      }
    }
    $val['fnac_g'] = null;
    $persona = $val['persona'];
    if ((($en_guarani == 'S') or  ($en_guarani == 'R')) && ($persona)){
      $datos_guarani = $this->Tad_model->Datos_Guarani($persona);
      if (count($datos_guarani) > 0) {
          $val['dni_g'] = $datos_guarani[0]['dni'];  
          $val['apellido_g'] = /*mb_convert_encoding(*/$datos_guarani[0]['apellido']; //, "UTF-8", "iso-8859-1"); 
          $val['nombre_g'] = /*mb_convert_encoding(*/$datos_guarani[0]['nombre']; //, "UTF-8", "iso-8859-1");  
          $val['cuil_g'] = $datos_guarani[0]['cuil'];  
          $val['fnac_g'] =  (($datos_guarani[0]['fechanac'] != '') && ($datos_guarani[0]['fechanac'] != '0000-00-00')) ?$datos_guarani[0]['fechanac']:'';  
      }
    }

    $renglon = implode(';',$val);
    $renglon = $renglon. PHP_EOL;
    fwrite($handle, $renglon);
  }
  $renglon = ' '.PHP_EOL;
  fwrite($handle, $renglon);
  fclose($handle);
  $this->descargar_archivo($filename,$nombrearchivo);
  exit;      
} 
}

public function reproceso_tad1(){
  $t_tramite = 'I';
  $mensaje_error = '';
  $aviso = '';
  $revisar = $this->Tad_model->get_expedientes_estado('R',$t_tramite);
  $total = 0;
  $en_padron = 0;
  $a_revisar = 0;
  $en_guarani = 0;
 
  foreach ($revisar as $datos) {
    $total ++;

    $cruce_g = $this->CruzarConGuarani($datos,$t_tramite);
    $cruce = $this->CruzarConPadron($datos,$t_tramite);

    $datos['t_coincidencia'] = $cruce['t_coincidencia'];
    $datos['en_padron'] = $cruce['en_padron'];
    $datos['anio'] = $cruce['anio'];
    $datos['clave'] = $cruce['clave'];
    $datos['baja'] = $cruce['baja'];
    $datos['sancion'] = $cruce['sancion'];
    $datos['t_tramite'] = $t_tramite;     
    $datos['t_coincidencia_g'] = $cruce_g['t_coincidencia_g'];
    $datos['en_guarani'] = $cruce_g['en_guarani'];
    $datos['persona'] = $cruce_g['persona'];
    $datos['plan_codigo'] = $cruce_g['plan_codigo'];    
    $datos['t_tramite'] = $t_tramite;  
    $datos['estado'] = 'I';  
    $datos['mail_enviado_cbc'] = null;   
    $datos['t_mail_enviar_cbc'] = null;   

    
    // Si tiro un TAD1 y el alumno estaba en guarani, no hay que subir el tramite y hay que enviar un mail avisando fechas de inscrip o que haga cambio de requisitos
    if ($datos['en_guarani'] == 'S') {
      $en_guarani ++;   
      $datos['estado'] = 'N';   // No corresponde subir
      $datos['mail_enviado_cbc'] = 'P';   
      if ($datos['plan_codigo'] >= 2000) {
        $datos['t_mail_enviar_cbc'] = '2';            
      }
      else {
          $datos['t_mail_enviar_cbc'] = '1';            
      }
    } 

    if (($datos['estado'] <> 'N') && ($datos['en_padron'] == 'S')) {
      $datos['estado'] = 'N';   // No corresponde subir porque esta en padron de CBC
      $en_padron ++;   
/*      $datos['mail_enviado_cbc'] = 'P';   
      $datos['t_mail_enviar_cbc'] = 'P';    */
    }

    if (($datos['estado'] <> 'N') && (($datos['en_guarani'] == 'R') || ($datos['en_padron'] == 'R'))) {
      $a_revisar ++;
      $datos['estado'] = 'R';   // revisar
    }


    if ($this->Tad_model->ActualizarEstadoTad($datos['Expediente'],$datos,$t_tramite,$datos['estado']) < 0) {
      $mensaje_error = "Error al actualizar expediente ".$datos['Expediente']." en tad1";
      $aviso = '';
//      $datos[] = "Error al actualizar expediente ".$data['Expediente']." en tad1";
      $this->iniciar_reproceso($mensaje_error,$aviso);
      return;
    }
  }
  $aviso = 'Se actualizaron '.$total.' de los cuales '.$a_revisar.' quedaron por revisar, '.$en_guarani.' estaban en guarani y '.$en_padron." estaban en padron";
  $this->iniciar_reproceso($mensaje_error,$aviso);
  return;
}

function cargas_ddjj_post() {  
  $nombre_original = $_FILES["userfile"]["name"];
  if($this->upload->do_upload("userfile")) {
      $data = array('upload_data' => $this->upload->data());
      $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
      $full_file_name = $upload_data['full_path'];
      $file_name = $upload_data['file_name'];
      
      // Una vez subido el archivo, hay que importarlo en la tabla temporaria de tads

      // Si la tabla temporaria tiene filas borrar esas filas
      $this->Tad_model->Truncar_tabla('tadddjj_tmp');
      // Insertar el archivo en tad_archivos y obtener el id insertado
      $id_archivo = $this->Tad_model->InsertarArchivo($file_name,$nombre_original);
      if ($id_archivo < 0){
          $error = 'Error al insertar nombre de archivo';
          $this->iniciar_carga_ddjj($error);
          return;
      }
      
      // Leer las filas del archivo csv e insertarlas en la tabla temporal. 
      $error = $this->importar_tad_ddjj($full_file_name, $id_archivo);
      // Si hay error de formato (mas o menos campos de los esperados) reportar error
      if ($error != '') {
          $this->iniciar_carga_ddjj($error);
          return;
      }
      if ($this->Tad_model->LoteYaProcesado_ddjj()) {
        $error = "Expedientes de este archivo ya fueron subidos";
        $this->iniciar_carga_ddjj($error);
        return;
      }

      // Si no hay error, insertarlos en la tabla definitiva en estado I (inicial) y borrarlos de la tabla temporal
      $filas_insertadas = $this->Tad_model->InsertarEnTad_ddjj($id_archivo);
      if ($filas_insertadas < 1) {
          $error = "Error al insertar archivo ".$file_name." en tabla definitiva";
          $this->iniciar_carga_ddjj($error);
          return;
      }
      $resultado = $this->Tad_model->Numeros_archivo_ddjj($id_archivo);
      $data['filas_insertadas'] = $filas_insertadas;
      $data['resultado'] = $resultado[0];
      $data['original'] = $nombre_original;
      $data['t_tramite'] = 'J';
      $data2['permisos'] = $this->permisos;
      $data2['titulo_menu'] = 'Importar TAD DDJJ';
      $this->load->view('menu.php',$data2);
      $this->load->view('subirtad_success', $data);
      $this->load->view('footer.php');
}
else{
  $error = $this->upload->display_errors();
  $this->iniciar_carga_ddjj($error);
} 
}


/*  public function descargas() {   
	//leer configuracion sede
//	$archivo = file("sconfig.ini"); 
//	list($sede, $sedenombre) = explode(',',$archivo[0]);
	$sede = $this->session->userdata('sede');
	$sedenombre = $this->session->userdata('nombre');
	//--------------------------------------------------
	$fechaactual = date("d/m/Y");
	//--------------------------------------------------
	$tabla = "";
	//leer sistemas disponibles para descarga
	$archivo = file(APPPATH."/dwfiles.ini"); 
	$lineas = count($archivo); 
	for($i=1; $i < $lineas; $i++) {
	   list($sd, $fdde, $fhta, $sistema, $descripcion, $alink) = explode(',',$archivo[$i]);
	   $fechaok = $this->funcs_lib->fechaOk($fdde, $fhta);
	   //$fechaok = true;
	   if (  (($sd == $sede) || ($sd == 0)) && $fechaok )  {
			$tabla .= "<tr>" ;
			$tabla .="<td class='col-xs-1'>".$fdde."</td>"."<td class='col-xs-8'>".$descripcion."</td>";
		   	if ($sd==0) {
			 	$tabla .="<td class='col-xs-2'><a href="."'../comun/".trim($alink)."'>".$sistema."</a></td>";
		   	}else{
			 	$tabla .="<td class='col-xs-2'><a href="."'../descargas/sede".$sede."/".trim($alink)."'>".$sistema."</a></td>";
		   	}
		   	$tabla .="<td class='col-xs-1'>".$fhta."</td>";
		   	$tabla.="</tr>";
	   }
	}
	$data['tabla'] = $tabla;
	$data['nombre'] = $sedenombre;
	$data['sede'] = $sede;
	$data2['permisos'] = $this->permisos;
	$data2['titulo_menu'] = 'Descargas';
	$this->load->view('menu.php',$data2);
	$this->load->view('descargas.php',$data);
	$this->load->view('footer.php');
  }       
  
  public function InsertarEnTemporal2($datos,$id_archivo,$cruce,$t_tramite,$guarani){
  $datos['id_archivo_tad'] = $id_archivo;
  $datos['t_coincidencia'] = $cruce['t_coincidencia'];
  $datos['en_padron'] = $cruce['en_padron'];
  $datos['anio'] = $cruce['anio'];
  $datos['clave'] = $cruce['clave'];
  $datos['baja'] = $cruce['baja'];
  $datos['sancion'] = $cruce['sancion'];
  $datos['t_tramite'] = $t_tramite;  
  $datos['estado'] = 'I';  
  $datos['mail_enviado_cbc'] = 'N';   
  $ape3 = substr($datos['APELLIDO_SOLICITANTE'],0,3);
  $mail = $datos['EMAIL'];
  $dni = $datos['NUMERO_DOCUMENTO'];
  $fnac = $datos['FECHA_NAC'];
  $apellido = $datos['APELLIDO_SOLICITANTE'];
  $cuil = $datos['CUIT_CUIL'];
  $cuantos = $this->Tad_model->existe_por_cuil_tad_tmp($cuil,$t_tramite) + $this->Tad_model->existe_por_cuil_tad($cuil,$t_tramite);  

  if (count($guarani) > 0) {
    // Si tiro un TAD1 y el alumno estaba en guarani, no hay que subir el tramite y hay que enviar un mail avisando fechas de inscrip o que haga cambio de requisitos
    if ($guarani[0]['apellido'] >= $ape3) {
      $datos['estado'] = 'N';   // No corresponde subir
      $datos['mail_enviado_cbc'] = 'P';   
      if ($guarani[0]['plan_codigo'] >= 2000) {
        $datos['t_mail_enviar_cbc'] = '2';            
      }
      else {
          $datos['t_mail_enviar_cbc'] = '1';            
      }
    }       
    else {
      $datos['estado'] = 'R';   // revisar
      $datos['t_coincidencia'] == 'D';
    }
  }
  else { // Cruzo por mail
    $guarani = $this->Tad2_model->Get_Datos_Guarani_Mail($mail); 
    if (count($guarani) > 0) {
      // Si tiro un TAD1 y el mail estaba en guarani, hay que marcar para revisar
      $datos['estado'] = 'R';   // revisar
      $datos['t_coincidencia'] == 'M';
    }       
    else {
      if ($dni > 90000000) {  
        $guarani = $this->Tad2_model->Get_Datos_Guarani_ApeFec($apellido,$fnac); 
        if (count($guarani) > 0) {
           // Si tiro un TAD1 y la fecha de nac. + apellido estaba en guarani, hay que marcar para revisar
          $datos['estado'] = 'R';   // revisar
          $datos['t_coincidencia'] == 'F';
        }
      }       
    }
  }

  // Si tiro un TAD1 y el alumno estaba en padron, hay que enviar un mail avisando que tire un TAD2
  if ($t_tramite == 'I') {
    if (($datos['en_padron'] == 'S') && (($datos['estado'] == 'I') || ($datos['estado'] == 'G'))) {
      // Marcar el expediente para enviar mail de tipo P ("El alumno esta en padron y tiro TAD1")
      $datos['mail_enviado_cbc'] = 'P';   
      $datos['t_mail_enviar_cbc'] = 'P';    
    }
  }
  if ($cuantos > 0) {
    $datos['estado'] = 'N';   // No corresponde subir porque ya habia tirado un tramite
    $datos['mail_enviado_cbc'] = 'P';   
    $datos['t_mail_enviar_cbc'] = 'R';            
  }
  return ($this->Tad_model->InsertarEnTemporal($datos) > 0);
}

  
  
  */
/*public function errores_post(){
  
  if($this->upload->do_upload("userfile")) {
    $data = array('upload_data' => $this->upload->data());
    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
    $full_file_name = $upload_data['full_path'];
    $file_name = $upload_data['file_name'];
    
    // Una vez subido el archivo, hay que leer tanto la solapa exitoso como la de errores

    
    // Leer las filas del archivo csv e insertarlas en la tabla temporal. 
    $error = $this->importar_tad1($full_file_name, $id_archivo);
    // Si hay error de formato (mas o menos campos de los esperados) reportar error
    if ($error != '') {
        $this->iniciar_carga($error);
        return;
    }

    // Si no hay error, insertarlos en la tabla definitiva en estado I (inicial) y borrarlos de la tabla temporal
    $filas_insertadas = $this->Tad_model->InsertarEnTad($id_archivo);
    if ($filas_insertadas < 1) {
        $error = "Error al insertar archivo ".$file_name." en tabla definitiva";
        $this->iniciar_carga($error);
        return;
    }
    $resultado = $this->Tad_model->Numeros_archivo($id_archivo);
    $data['filas_insertadas'] = $filas_insertadas;
    $data['resultado'] = $resultado[0];
    $data2['permisos'] = $this->permisos;
    $data2['titulo_menu'] = 'Importar TAD';
    $this->load->view('menu.php',$data2);
    $this->load->view('subirtad_success', $data);
    $this->load->view('footer.php');
}
else{
  $error = $this->upload->display_errors();
  $this->iniciar_carga($error);
} 
}


public function reproceso_tad1(){
  $t_tramite = 'I';
  $mensaje_error = '';
  $aviso = '';
  $revisar = $this->Tad_model->get_expedientes_estado('R',$t_tramite);
  $total = 0;
  $en_padron = 0;
  $a_revisar = 0;
  $en_guarani = 0;
  foreach ($revisar as $data) {
    $total ++;
    $mail = $data['EMAIL'];
    $dni = $data['NUMERO_DOCUMENTO'];
    $fnac = $data['FECHA_NAC'];
    $apellido = $data['APELLIDO_SOLICITANTE'];
    $ape3 = substr($apellido,0,3);
    $guarani = $this->Tad_model->existe_por_dni_Guarani($dni);
    $cruce = $this->CruzarConPadron($data);
    $datos['t_coincidencia'] = $cruce['t_coincidencia'];
    $datos['en_padron'] = $cruce['en_padron'];
    $datos['anio'] = $cruce['anio'];
    $datos['clave'] = $cruce['clave'];
    $datos['baja'] = $cruce['baja'];
    $datos['sancion'] = $cruce['sancion'];
    $datos['t_tramite'] = $t_tramite;     
    $datos['estado'] = 'I';  
    $datos['mail_enviado_cbc'] = 'N';   
    $datos['t_mail_enviar_cbc'] = null;   

    if (count($guarani) > 0) {
      // Si tiro un TAD1 y el alumno estaba en guarani, no hay que subir el tramite y hay que enviar un mail avisando fechas de inscrip o que haga cambio de requisitos
      if ($guarani[0]['apellido'] >= $ape3) {
        $datos['estado'] = 'N';   // No corresponde subir
        $en_guarani ++;
        $datos['mail_enviado_cbc'] = 'P';   
        if ($guarani[0]['plan_codigo'] >= 2000) {
          $datos['t_mail_enviar_cbc'] = '2';            
        }
        else {
            $datos['t_mail_enviar_cbc'] = '1';            
        }
      }       
      else {
        $datos['estado'] = 'R';   // revisar
        $datos['t_coincidencia'] == 'D';
      }
    }
    else { // Cruzo por mail
      $guarani = $this->Tad2_model->Get_Datos_Guarani_Mail($mail); 
      if (count($guarani) > 0) {
        // Si tiro un TAD1 y el mail estaba en guarani, hay que marcar para revisar
        $datos['estado'] = 'R';   // revisar
        $datos['t_coincidencia'] == 'M';
      }       
      else {
        if ($dni > 90000000) {  
          $guarani = $this->Tad2_model->Get_Datos_Guarani_ApeFec($apellido,$fnac); 
          if (count($guarani) > 0) {
            // Si tiro un TAD1 y la fecha de nac. + apellido estaba en guarani, hay que marcar para revisar
            $datos['estado'] = 'R';   // revisar
            $datos['t_coincidencia'] == 'F';
          }
        }       
      }
    }


    // Si tiro un TAD1 y el alumno estaba en padron, hay que enviar un mail avisando que tire un TAD2
    if ($t_tramite == 'I') {
      if (($datos['en_padron'] == 'S') && (($datos['estado'] == 'I') || ($datos['estado'] == 'G'))) {
        // Marcar el expediente para enviar mail de tipo P ("El alumno esta en padron y tiro TAD1")
        $datos['mail_enviado_cbc'] = 'P';   
        $datos['t_mail_enviar_cbc'] = 'P'; 
        $en_padron ++;   
      }
    }


    if (($datos['estado'] == 'R') || ((($datos['estado'] == 'I') || ($datos['estado'] == 'G')) && ($datos['en_padron'] == 'R'))) {
      $a_revisar ++;
    }
    if ($this->Tad_model->ActualizarEstadoTad($data['Expediente'],$datos,$t_tramite,$datos['estado']) < 0) {
      $mensaje_error = "Error al actualizar expediente ".$data['Expediente']." en tad1";
      $data[] = "Error al actualizar expediente ".$data['Expediente']." en tad1";
      $this->iniciar_reproceso($mensaje_error,$aviso);
      return;
    }
  }
  $aviso = 'Se actualizaron '.$total.' de los cuales '.$a_revisar.' quedaron por revisar, '.$en_guarani.' estaban en guarani y '.$en_padron." estaban en padron";
  $this->iniciar_reproceso($mensaje_error,$aviso);
  return;
}



*/
  
 
}
