<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" manifest="cache.manifest">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" href="<?php echo base_url() ?>application/assets/css/style.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>application/assets/css/bootstrap.min.css" rel="stylesheet">
  <script src="<?php echo base_url() ?>application/assets/js/jquery.min.js"></script>  
  <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/ico">   
  <title> RindEs </title>
</head>

<style>
  body {
      font-family: Calibri, Arial, Helvetica, Verdana  ! important;
      background-color: #aef58d;
  }
</style> 

<body>
  <nav class="navbar navbar-new navbar-static-top navbar-top" role="navigation">
    <div class="container-fluid">
        <!-- logo -->
        <div class="navbar-header">
          <a class="navbar-brand navbar-brand-header" href="#"><img src="<?php echo base_url(); ?>application/assets/img/LogoCultivar.ico" alt="logo" /> RindEs </a>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
          </button>
        </div>
        <!-- menu -->
        <div class="collapse navbar-collapse navbar-right" id="navbar1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url(); ?>usuarios/iniciar_sesion">Iniciar Sesión</a></li> 
<!--               <li><a href="<?php echo base_url(); ?>contacto/contactar">Contacto</a></li>     -->       
            </ul>
        </div>
    </div>
</nav>

    <div class="container container-home" id="contenido_pagina">

      <!-- Jumbotron Header -->
      <header class="jumbotron" id="header_jumbotron">
        <h1 class="display-3 brand-home">RindEs</h1>
        <p class="lead">RindEs (Rindes Esperables) es una aplicación ...
        Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
<!--         <a href="#" class="btn btn-primary btn-lg">Call to action!</a> -->
      </header>

      <!-- Page Features -->
      <div class="row text-center">

        <div class="col-sm-4 col-xs-12">
          <div class="card">
<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
            <div class="card-body">
              <h4 class="card-title">Versión de Evaluación</h4>
              <p class="card-text">Si querés probar la aplicación, podés hacerlo en forma gratuita accediendo a algunas distribuciones seleccionadas.</p>
            </div>
            <div class="card-footer">
              <a href="<?php echo base_url(); ?>registro_user_datos/registrar_demo" class="btn btn-primary">Solicitar DEMO</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-xs-12">
          <div class="card">
<!--             <img class="card-img-top" src="http://placehold.it/500x325" alt=""> -->
            <div class="card-body">
              <h4 class="card-title">Versión Registrada</h4>
              <p class="card-text">La licencia de uso te permitirá realizar consultas a la biblioteca completa de RindEs. Al solicitar la licencia, te llegará un mail con los detalles para comprarla.</p>
            </div>
            <div class="card-footer">
              <a href="<?php echo base_url(); ?>registro_user_datos/registrar" class="btn btn-primary">Solicitar Licencia</a>
            </div>
          </div>
        </div>
        <div class="col-sm-4 col-xs-12">
          <div class="card">
          <img class="card-img-top" src="<?php echo base_url(); ?>assets/img/login.png" alt="logo">
            <div class="card-body">
              <h4 class="card-title">¿Ya sos usuario?</h4>
            </div>
            <div class="card-footer">
              <a href="<?php echo base_url(); ?>usuarios/iniciar_sesion" class="btn btn-primary">Iniciar Sesión</a>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->