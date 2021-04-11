
<html>
<head>
    <title>Exportar a CSV</title>
    
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
 <div class="container box">
  <h3 align="center">Exportar a CSV</h3>
  <br />
  <form method="post" action="<?php echo base_url(); ?>export_csv/export">
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
       <h3 class="panel-title">Recepcion de documentacion</h3>
      </div>
      <div class="col-md-6" align="right">
       <input type="submit" name="export" class="btn btn-success btn-xs" value="Export to CSV" />
      </div>
     </div>
    </div>
    <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>Apellido</th>
        <th>Nombre</th>
        <th>DNI</th>
        <th>Titulo secundario</th>
        <th>Certif.Trabajo</th>
        <th>Requiere cert.Idioma</th>
        <th>Idioma</th>
        <th>Fecha Gestion</th>
        <th>Usuario</th>
       </tr>
       <?php
       foreach($total_data->result_array() as $row)
       {
        echo '
        <tr>
         <td>'.$row["apellido"].'</td>
         <td>'.$row["nombre"].'</td>
         <td>'.$row["dni"].'</td>';

         switch ($row["rcondicion"]) {
            case 13:
                echo '<td>T&iacute;tulo legalizado por UBA</td>';
                break;
            case 12:
                echo '<td>T&iacute;tulo sin legalizar</td>';
                break;
            case 32:
                echo '<td>Constancia de t&iacute;tulo en t&aacute;mite</td>';
                break;
            case 23:
                echo '<td>Convalidaci&oacute;n legalizada</td>';
                break;
            case 22:
                echo '<td>Convalidaci&oacute;n sin legalizar</td>';
                break;
            default:
                echo '<td></td>';
        }
        if (isset($row['rtrabaja']) && ($row['rtrabaja'] == 2)){ 
            echo '<td>Presenta certificado de trabajo</td>';
        }
        else { 
            echo '<td></td>';
        }

        if (isset($row['debe']) && ($row['debe'] == 2)){ 
            echo '<td>2</td>';
        }
        else { 
            echo '<td></td>';
        }
        switch ($row["presenta"]) {
            case 4:
                echo '<td>No corresponde</td>';
                break;
            case 122:
                echo '<td>Presenta certificado de idioma</td>';
                break;
            default:
                echo '<td></td>';
        }

         echo '<td>'.$row["f_modif"].'</td>
         <td>'.$row["d_usuario"].'</td>
        </tr>
        ';
       }
       ?>
      </table>
     </div>
    </div>
   </div>
  </form>
 </div>
</body>
</html>
