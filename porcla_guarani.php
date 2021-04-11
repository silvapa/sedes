<?php
header('Content-type: text/plain; charset=utf-8'); //'charset=iso-8859-15);//iso-8859-1
$base = 'PG';

$db_host='localhost';
if ($base == 'PG') {
  $db_user= 'dparras';//'mbaleani';
  $db_pass="79rF*2R";//'HTh*kOk5';
  $db='guarani3';
  $conn_string = "host=".$db_host." port=1111 dbname=".$db." user=".$db_user." password=".$db_pass;
  $coneccion = pg_connect($conn_string);
  if (!$coneccion) {
    echo "Error: No se pudo conectar a la base de datos." . PHP_EOL;
      exit;
  }
}
else {
  $db_user = 'root';
  $db_pass = '';
  $db='cbc_sede';
  $coneccion = mysqli_connect($db_host, $db_user, $db_pass, $db);
  if (!$coneccion) {
    echo "Error: No se pudo conectar a la base de datos." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
  }
}



const k_anio_r = 0;  // Col. AQ del csv
const k_clave_r = 1; // Col. AR del csv

const k_tipo = 7;
const k_comicat = 4;
const k_cuatturno = 1;
const k_cursada = 5;
const k_nota = 6;
const k_fecha = 9;
const k_fila_titulos = 1;


function f_mes_en_letras ($mes) {
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


  function f_estandariza_turnos ($tipo,$cuatturno) {
      switch ($tipo) {
        case 'E':
        case 'F':
        case 'L':
          $cuatturno = f_mes_en_letras($cuatturno);
        break;
        case 'R':
        case 'C':
//            $tipo = 'REG';
          break;
        case 'P':
          if ($cuaturno == 255 ) $cuatturno =  '';
          break;
      }
      return $cuatturno;
  }

  function f_estandariza_tipos ($tipo,$origen) {
    switch ($tipo) {
    case 'E':
        if ($origen == 'G') {
        $tipo = 'FIN';
        } else {
        $tipo = 'ESP';
        }
    break;
    case 'F':
        $tipo = 'FIN';
    break;
    case 'L':
        $tipo = 'LIB';
        break;
    case 'R':
    case 'C':
        $tipo = 'REG';
        break;
    case 'P':
        $tipo = 'RES';
        break;
    }
    return $tipo;
  }

  function f_estandariza_catedras ($tipo, $catedra) {
    if (($tipo == 'E') or ($tipo == 'F') or ($tipo == 'L') or ($tipo == 'FIN') or ($tipo == 'LIB') or ($tipo == 'ESP') ) {
      $pos = strpos($catedra, '_');
    if ($pos !== false) {
        $catedra = substr($catedra,$pos + 1);
        $pos = strpos($catedra, '_');
        if ($pos !== false) {
        $catedra = substr($catedra,0,$pos);
        }
      }
    }
    return $catedra;
  }

 
  function f_final_pendiente ($fields) {
    $anio_fp = 2019;
    $cuat_fp = 2;
    if ($fields[k_tipo] != 'REG') {
      return '';
    }
    if ($fields[k_cuatturno - 1] < 85) {
      $aniocurso = 2000 + $fields[k_cuatturno - 1];
    } else {
        if (($fields[k_cuatturno - 1] >= 85) && ($fields[k_cuatturno - 1] < 100)) {
          $aniocurso = 1900 + $fields[k_cuatturno - 1]; 
        } else {
          $aniocurso = $fields[k_cuatturno - 1]; 
        }
    } 
      // Si tiene una cursada en cond. de final y aun no aprobo la materia, la marco como FP (final pendiente) 
      // porque voy a mostrarla en los certificados como "Reg."
    if (($fields[k_tipo] == 'REG') and 
          (($aniocurso > $anio_fp) or (($aniocurso == $anio_fp) and ($fields[k_cuatturno] >= $cuat_fp))) and 
          (($fields[k_cursada] == 'Reg.') or ($fields[k_nota] == 'Reg.') or 
           ($fields[k_cursada] == 4) or ($fields[k_cursada] == 5) or ($fields[k_cursada] == 6)) and 
           (($fields[k_nota] == '') or ($fields[k_nota] == 'A') or (($fields[k_nota] >= 0 and $fields[k_nota] < 4) ) )) {
      return '*';
    }
    return '';
  }

  function sitacad_por_clave($anio, $clave, $coneccion, $incluir_xxi, $base){
    $data = array();
    if (($anio == '') || ($clave == '') || (!(is_numeric ($anio))) || (!(is_numeric ($clave)))) {
      return $data;
    }
    if ($base == 'PG') {
      $query = "SELECT distinct anio_academico as aniocurso, cuat as cuatturno, sede, materia,
    case when tipo = 'E' then catedra else cast(comision as varchar(6)) end as comicat, 
    case when tipo = 'C' then nota else '' end as cursada, case when (tipo <> 'C') or nota = 'A' then nota else '' end as nota ,
    tipo,'' as resolucion, fecha, origen  
    from negocio_uba.vw_sitacad_cbc s 
    left join negocio.sga_elementos m on CONCAT('CBC-',right(CONCAT('00',cast(s.materia as varchar(2))),3)) = m.codigo ".
    "where anio = ".$anio." and clave = ".$clave;
    }
    else {
        $query = "SELECT distinct anio_academico as aniocurso, cuat as cuatturno, sede, materia,
    case when tipo = 'E' then catedra else comision end as comicat, 
    case when tipo = 'C' then nota else '' end as cursada, case when (tipo <> 'C') or nota = 'A' then nota else '' end as nota ,
    tipo,'' as resolucion, fecha, origen  
    from sitacad_guarani s left join materias m on s.materia = m.codigo 
    where anio = ".$anio." and clave = ".$clave;
    }
    if (!($incluir_xxi)) {
      $query = $query ." and origen <> 'X'";
    } 
    $query = $query ." order by 1,fecha";
    if ($base == 'PG'){
      $data = pg_query($coneccion,$query);
    } 
    else {
      $data = $coneccion->query($query);
    }
    return $data;   
  }


function fputcsv2($handle, $row, $fd=';', $quot='"')
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
 
$file_name = "alumnos.csv";  
$file_name_w = 'sitacad.csv';

echo 'Leyendo '.$file_name."\r\n\r\n";
echo 'Generando '.$file_name_w ."\r\n\r\n";

$fp = fopen($file_name_w, 'w');  
$donde = 'g';
$incluir_xxi = false;
if (($handle = fopen($file_name, "r")) !== FALSE) {  
    $i = 0;
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {  
      $i++;
      if (($i > k_fila_titulos) && isset($data[k_clave_r])){
        $donde = 'g';

        $anio = $data[k_anio_r];
        $clave = $data[k_clave_r];
        if ($anio < 85) {
            $anio = $anio + 2000;
        } 
        else {
            if (($anio >= 85) && ($anio < 100)) {
                $anio = $anio + 1900;
            } 
        }
        echo $i.' ---> Clave: '.$clave.'/'.$anio."\r\n";
        $data = sitacad_por_clave($anio, $clave, $coneccion, $incluir_xxi,$base);
        /* obtener el array de objetos */
/*        while ($fila = $data->fetch_row()) {*/
          while ($fila = pg_fetch_row($data)) {
            $fila[k_cuatturno] = f_estandariza_turnos ($fila[k_tipo],$fila[k_cuatturno]);
            $fila[k_tipo]     = f_estandariza_tipos ($fila[k_tipo],'G');
            $fila[k_comicat]  = f_estandariza_catedras($fila[k_tipo],$fila[k_comicat]);
            $fila[k_cuatturno - 1] = $fila[k_cuatturno - 1] % 100;
//            $fila[k_fecha] = substr($fila[k_fecha],6,4).'/'.substr($fila[k_fecha],3,2).'/'.substr($fila[k_fecha],0,2) ;
            $fila['anio'] = $anio;
            $fila['clave'] = $clave;
            $fila['fp'] = f_final_pendiente($fila);
            fputcsv($fp, $fila, ",", '"'); 
          }
        
    }
    }
}  
fclose($handle);  
fclose($fp);  
if ($base == 'PG') {
  pg_close($base);
}  
else {
  mysqli_close($coneccion);
}  
echo "Proceso Finalizado";
?>
