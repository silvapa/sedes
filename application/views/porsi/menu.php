<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" manifest="cache.manifest">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" href="<?php echo base_url() ?>application/assets/css/style.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo base_url() ?>application/assets/css/table.css" rel="stylesheet" />
  <script src="<?php echo base_url() ?>application/assets/js/jquery.min.js"></script>  
  <link href="<?php echo base_url() ?>application/assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/ico">   
  <title> Panel de sedes </title>
</head>

<style>
  body {
      font-family: Calibri, Arial, Helvetica, Verdana  ! important;
      background-color: #fff; /*#5c8f44;*/
  }
</style> 


<body>
<nav class="navbar navbar-new navbar-static-top navbar-top" role="navigation">
    <div class="container-fluid">
        <!-- logo -->
        <div class="navbar-header">
          <a class="navbar-brand navbar-brand-header" href="#"><img src="<?php echo base_url(); ?>application/assets/img/LogoCultivar.ico" alt="logo" /> <? echo $titulo_menu;?> </a>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
<!--                <span class="icon-bar"></span>-->
          </button>
        </div>
        <!-- menu -->
        <div class="collapse navbar-collapse navbar-right" id="navbar1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?php echo base_url(); ?>Main/principal">Inicio</a></li>
<!--                 <li>
                <div class="dropdown">
                  <button class="dropbtn">Archivos
                    <i class="fa fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content">
                    <a href="< ?php echo base_url(); ?>Archivos/descargas">Descargas</a>
                    <a href="< ?php echo base_url(); ?>Archivos/cargas">Cargas</a>
                    <a href="< ?php echo base_url(); ?>Archivos/instaladores">Instaladores</a>
                  </div>
                </div></li> -->
 
                

                <?php  
                /*
                  if (in_array('3W',$permisos) || in_array('3R',$permisos) || in_array('3W',$permisos) || in_array('3R',$permisos)) {
                    echo '<li><div class="dropdown">';
                    echo '  <button class="dropbtn">Constancias';
                    echo '    <i class="fa fa-caret-down"></i>';
                    echo '  </button>';
                    echo '  <div class="dropdown-content">';
                    if (in_array('3W',$permisos) || in_array('3R',$permisos)) { */
                    // echo'<a href="'.base_url().'Constancias/consultar" style="text-shadow:2px 2px 8px #000"><strong>Total '.date('y').'</strong></a>';
                    /*}               
                    if (in_array('3W',$permisos) || in_array('3R',$permisos)) {
                      //echo '<a href="'.base_url().'Constancias/reporte" style="text-shadow:2px 2px 8px #000"><strong>Reporte</strong></a>';
                    }               
                    echo '  </div>';
                    echo '</div></li>';
                  }
                  */
                  if (in_array('4R',$permisos) || (in_array('4D',$permisos))) {
                    echo '<li><a href="'.base_url().'Cursos/consultar" style="text-shadow:2px 2px 8px #000"><strong>Cursos</strong></a></li>';
                  }
                  if (in_array('2R',$permisos)) {
                    echo '<li><a href="'.base_url().'Padron/consultar" style="text-shadow:2px 2px 8px #000"><strong>Padron</strong></a></li>';
                  }
                  if (in_array('5L',$permisos) || in_array('5R',$permisos) || in_array('5W',$permisos)) {
                    echo '<li><a href="'.base_url().'Emails/consultar" style="text-shadow:2px 2px 8px #000"><strong>Emails</strong></a></li> ';
                  }
                  if ( in_array('6W',$permisos)) {
                    echo '<li><a href="'.base_url().'AltaBaja/consultar" style="text-shadow:2px 2px 8px #000"><strong>AltaBaja</strong></a></li> ';
                  }
                ?>
                <li><a href="<?php echo base_url(); ?>usuarios/logout">Salir</a></li>                
            </ul>
        </div>
    </div>
</nav>
<div id = "row"><div id = "col" class="Lines1"></div></div>
<div id = "row"><div id = "col" class="Lines2"></div></div>
