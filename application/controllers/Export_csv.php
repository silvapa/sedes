<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_csv extends CI_Controller {
 
 public function __construct()
 {
  parent::__construct();
  $this->load->model('Total_model');
 }

 function traduce_condicion($condicion){
  switch ($condicion) {
    case 13:
        return 'Titulo legalizado por UBA';
        break;
    case 12:
      return 'Titulo sin legalizar';
        break;
    case 32:
      return 'Constancia de titulo en tramite';
        break;
    case 23:
      return 'Convalidacion legalizada';
        break;
    case 22:
      return 'Convalidacion sin legalizar';
        break;
    default:
      return '';
  }
 }

 function traduce_presenta($presenta){
  switch ($presenta) {
    case 4:
        return 'No corresponde';
        break;
    case 2:
      return 'Presenta certificado de idioma';
        break;
    default:
      return '';
  }
 }

 function traduce_debe($debe){
 if (isset($debe) && ($debe == 2)){ 
  return '2';
  }
  else { 
    return '';
  }
}

function traduce_rtrabaja($rtrabaja){
if (isset($rtrabaja) && ($rtrabaja == 2)){ 
  return 'Presenta certificado de trabajo';
 }
 else { 
   return '';
 }
}


 function index()
 {
  $data['total_data'] = $this->Total_model->R_constancias(3);
  $this->load->view('export_csv', $data);
 }

 function export()
 {
  $file_name = 'documentacion_'.date('Ymd').'.csv'; 
  $sede = $this->session->userdata('sede');
  $dde  = $_GET["fechaInicio"];
  $hta  = $_GET["fechaFin"];

  $timestamp = strtotime($dde);
  $dde = date("d-m-Y", $timestamp);
   
  $timestamp = strtotime($hta);
  $hta_orig = date("d-m-Y", $timestamp);
  $hta = date("d-m-Y", strtotime($hta_orig.' +1 day'));


   header("Content-Description: File Transfer"); 
   header("Content-Disposition: attachment; filename=$file_name"); 
   header("Content-Type: application/csv;");

      
     $total_data = $this->Total_model->R_constancias($sede,$dde,$hta);

  
     // file creation 
     $file = fopen('php://output', 'w');
     
     fputcsv($file, array("Documentacion gestionada por la sede"), ";");
     if ($dde == $hta_orig){
      fputcsv($file, array("Dia: ".$dde), ";");
     }
     else {
      fputcsv($file, array("Desde el ".$dde." al ".$hta_orig), ";");
     }
     fputcsv($file, array(""), ";");
     $header = array("Apellido","Nombre","DNI","Titulo secundario","Certif.Trabajo","Requiere cert.Idioma","Idioma","Fecha Gestion","Usuario"); 
     fputcsv($file, $header, ";");
     foreach ($total_data->result_array() as $key => $value)
     { 
      $rcondicion = $this->traduce_condicion($value['rcondicion']);
      $rtrabaja =  $this->traduce_rtrabaja($value['rtrabaja']);
      $debe =  $this->traduce_debe($value['debe']);
      $presenta =  $this->traduce_presenta($value['presenta']);

       fputcsv($file, array($value['apellido'],$value['nombre'],$value['dni'],$rcondicion,$rtrabaja,$debe,$presenta,$value['f_modif'],$value['d_usuario']), ";");
    //   fputcsv($file, $value, ";"); 
     }
     fclose($file); 
     exit; 
 }
 
  
}
