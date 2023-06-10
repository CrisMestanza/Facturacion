<!doctype html>
<html>
   <head>
      <meta http-equiv="Expires" content="0">
      <meta http-equiv="Last-Modified" content="0">
      <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <title> Facturación</title>
       <link rel="stylesheet" href="css/bootstrap.3.4.1.min.css">
       <link rel="stylesheet" href="css/jquery-ui.min.css" />
       <link rel="stylesheet" href="css/bootstrap-switch.css">
       <link rel="stylesheet" type="text/css" href="libs/select2/4.0.3/css/select2.min.css">
       <link href="css/toastr.min.css" rel="stylesheet"/>
       <link rel="stylesheet" type="text/css" href="css/miestilo.css">
       <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
       <link rel="stylesheet" href="css/jquery.dataTables.min.css">
       <link rel="stylesheet" href="css/responsive.dataTables.min.css">
       <link rel="stylesheet" href="libs/font-awesome-4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" type="text/css" href="libs/foo-table/css/jquery.dataTables.min.css">
       <link rel="stylesheet" type="text/css" href="libs/foo-table/css/footable.standalone.min.css">
      <link rel="stylesheet" href="css//nuevo.css">



   <body style="background-color: white;" >
   <div id="img-w" class="centerBody" style="display:none;">
     <div class="custom-loader"></div>
   </div>
   <div  id="container-body" style="display:none;">
      <header>
         <nav class="navbar navbar-default navbar-fixed-top ">
            <div class="container">
               <!-- Brand and toggle get grouped for better mobile display -->
               <div class="navbar-header">
                  <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                  <span class="sr-only">Navegación DSIGPERÚ S.A.C</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a href="#" class="navbar-brand">SIFO CLOUD</a>
               </div>
               <!-- Collection of nav links and other content for toggling -->
               <div id="navbarCollapse" class="collapse navbar-collapse">
                  <ul class="nav navbar-nav">
                     <li class="active"><a href="javascript: LoadDashboard();">Inicio</a></li>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Facturación
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           <li><a href="javascript: LoadEmitirCpe();">Emitir Comprobante</a></li>
                           <li><a href="javascript: LoadListado();">Resúmen de Comprobantes</a></li>
                                                     
                        </ul>
                     </li>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Anexos
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           <li><a href="javascript: LoadPersonas()">Registro de Clientes</a></li>
                           <li><a href="javascript: LoadItem()">Registro de Items</a></li>
                           <li><a href="javascript: LoadNumeracion_a()">Registro de Numeración</a></li>
                           <li><a href="javascript: LoadconfEmail()">Configurar Email</a></li>
                        </ul>
                     </li>
                     <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Empresa
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           <li><a href="javascript: LoadEmpresa_m()">Editar Empresa</a></li>
                           <li><a href="javascript: LoadUsuarios_Sunat_m()">Registro Certificado</a></li>
                        </ul>
                     </li>
                  </ul>
                  <button id="btn-enviar" type="button" class="btn btn-success navbar-btn"> <span class="glyphicon glyphicon-cloud"></span> Enviar </button>
                  <button id="btn-nuevo" type="button" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-refresh"></span> Reload </button>
                  <button id="btn-refrescar" type="button" class="btn btn-info navbar-btn"> <span class="glyphicon glyphicon-refresh"></span> Refrescar </button>
                  
                  <ul class="nav navbar-nav navbar-right">
                     <li><a href="javascript: loadSalir ()"><span class="glyphicon glyphicon-log-in"></span>Cerrar Sesión</a></li>
                  </ul>
               </div>
            </div>
         </nav>
         <div style="display:none"  id="n-codigo-doc" ></div>
      </header>
      

