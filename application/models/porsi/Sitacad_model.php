<?php
class Sitacad_model extends CI_Model {

  public function __construct() {
      parent::__construct();
  }

  function mes_en_letras ($mes) {
    $turno = $mes;
    switch ($mes) {    
      case '0':
        $turno = 'VER';
        break;
      case '1':
        $turno = 'ENE';
        break;
      case '2':
        $turno = 'FEB';
      break;
      case '3':
        $turno = 'MAR';
        break;
      case '4':
        $turno = 'ABR';
        break;
      case '5':
        $turno = 'MAY';
        break;
      case '6':
        $turno = 'JUN';
        break;
      case '7':
        $turno = 'JUL';
        break;
      case '8':
        $turno = 'AGO';
        break;
      case '9':
        $turno = 'SEP';
        break;
      case '10':
        $turno = 'OCT';
        break;
      case '11':
        $turno = 'NOV';
        break;
      case '12':
        $turno = 'DIC';
        break;
      }
    return $turno;
    }


  function estandariza_turnos ($result,$origen) {
    $i = 0;
    foreach ($result as $fields) {
      $tipo = $fields['tipo'];
      switch ($fields['tipo']) {
        case 'E':
          if ($origen == 'G') {
            $tipo = 'FIN';
          } else {
            $tipo = 'ESP';
          }
          $result[$i]['cuatturno'] = $this->mes_en_letras($fields['cuatturno']);
        break;

        case 'F':
          $tipo = 'FIN';
          $result[$i]['cuatturno'] = $this->mes_en_letras($fields['cuatturno']);
        break;
        case 'L':
            $tipo = 'LIB';
            $result[$i]['cuatturno'] = $this->mes_en_letras($fields['cuatturno']);
          break;
        case 'R':
        case 'C':
            $tipo = 'REG';
          break;
        case 'P':
          if ($result[$i]['cuatturno'] == 255 ) $result[$i]['cuatturno'] =  '';
          if ($result[$i]['aniocurso'] == 0 ) $result[$i]['aniocurso'] =  '';
          if ($result[$i]['comicat'] == 0 ) $result[$i]['comicat'] =  '';
          $tipo = 'RES';
          break;
      }
      $result[$i]['tipo'] = $tipo;
      $i++;
    } 
    return $result;
  }

  function estandariza_catedras ($result) {
    $i = 0;
    foreach ($result as $fields) {
      if (($fields['tipo'] == 'E') or ($fields['tipo'] == 'F') or ($fields['tipo'] == 'L') or ($fields['tipo'] == 'FIN') or ($fields['tipo'] == 'LIB') or ($fields['tipo'] == 'ESP') ) {
        $catedra = $fields['comicat'];
        $pos = strpos($catedra, '_');
        if ($pos !== false) {
          $catedra = substr($catedra,$pos + 1);
          $pos = strpos($catedra, '_');
          if ($pos !== false) {
            $catedra = substr($catedra,0,$pos);
          }
          $result[$i]['comicat'] = $catedra;
        }
      }
      $i++;
    } 
    return $result;
  }

  public function Sitacad_por_clave($anio,$clave){
  /*  $db3 = $this->load->database('guarani_cbc', TRUE);  
    $query =  $db3->query("select top 1 * from padron");    
    $result3 = $query->result_array();
    print_r($result3);
    $db3->close();  
*/
    $db2 = $this->load->database('sitacad', TRUE);  
    $query =  $db2->query("notas_sitacad @anio=$anio,@clave=$clave");
  /*  $query = $db2->query(
    "dbo.notas_regulares_sin_bajas @anio=$anio,@clave=$clave,@Incluir_notas_ant=1,@incluir_lectivo=0");
    $regulares = $query->result_array();
    $query = $db2->query(
        "dbo.notas_libfinesp_sin_bajas @anio=$anio,@clave=$clave,@Incluir_notas_ant=1");
    $examenes = $query->result_array();
    $query = $db2->query(
        "dbo.notas_resoluciones_sin_bajas @anio=$anio,@clave=$clave");
    $resoluciones = $query->result_array();

    $result = array_merge($regulares,$examenes,$resoluciones);*/
    $result1 = $query->result_array();
    $result1 = $this->estandariza_turnos($result1,'C');
    $db2->close();  
    $query = $this->db->query("SELECT anio_academico as aniocurso, cuat as cuatturno, sede, materia, m.descripcion as d_materia,
    case when tipo = 'E' then catedra else comision end as comicat, 
    case when tipo = 'C' then nota else '' end as cursada, case when (tipo <> 'C') or nota = 'A' then nota else '' end as nota ,
    tipo,'' as resolucion, fecha 
    from sitacad_guarani s left join materias m on s.materia = m.codigo 
    where anio = ".$anio." and clave = ".$clave." and origen <> 'X' order by 1,fecha");
    $result2 = $query->result_array();
    $result2 = $this->estandariza_turnos($result2,'G');
    $result2 = $this->estandariza_catedras($result2);
    $result = array_merge($result1,$result2);

    return $result;
  }

}