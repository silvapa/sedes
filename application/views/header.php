<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" manifest="cache.manifest">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link type="text/css" href="<?php echo base_url() ?>application/assets/css/style.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>application/assets/css/bootstrap.min.css" rel="stylesheet">
  <script src="<?php echo base_url() ?>application/assets/js/jquery.min.js"></script>  
  <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/ico">   
  <title> Sedes </title>
  </head>
<style>
  body {/*background-color: #ccc;*/
 /*   padding-top: 60px;
    padding-bottom: : 270px;*/
     font-family: Calibri, Arial, Helvetica, Verdana  ! important;
 /*    font-family: 'Lato' ! important;*/
 background-color: #5c8f44;
 /*  background-color: rgb(232, 241, 212);*/
  }
</style> 

<body>

  <nav class="navbar navbar-new navbar-static-top <?php echo $t_estilo_navbar;?>" role="navigation">
    <div class="container-fluid">
        <!-- logo -->
        <div class="navbar-header">
        <a class="navbar-brand navbar-brand-header" href="#">RindEs</a>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
          </button>        
        </div>
        <!-- menu -->
        <div class="collapse navbar-collapse navbar-right" id="navbar1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url();?>usuarios/logout">Salir</a></li>
            </ul>
        </div>        
    </div>
  </nav>
 <!-- <hr class="colorgraph_fina colorgraph_header">-->
  <!-- <div id="wrapper">-->
    <div class="row" style="padding-bottom:70px;">
