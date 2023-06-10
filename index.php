<?php 
   require_once('header.php');
   ?>
   <link rel="stylesheet" type="text/css" href="css/widget.css">
<!-- begin #content -->
<div  class="panel-group">
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
   <div class="snippets bootdey">
      <div class="row">
         <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-facebook rounded">
               <span class="mini-stat-icon"><i class="glyphicon glyphicon-open fg-facebook"></i></span>
               <div class="mini-stat-info">
                  <span id="v-t1">0</span>
                  Total de Facturas Registradas
               </div>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-twitter rounded">
               <span class="mini-stat-icon"><i class="glyphicon glyphicon-open-file fg-twitter"></i></span>
               <div class="mini-stat-info">
                  <span id="v-t2">0</span>
                  Total de Boletas de Venta Registradas
               </div>
            </div>
         </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-googleplus rounded">
               <span class="mini-stat-icon"><i class="fa fa-eject fg-googleplus"></i></span>
               <div class="mini-stat-info">
                  <span id="v-t3">0</span>
                  Total de Notas de Crédito Registradas
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix bg-bitbucket rounded">
               <span class="mini-stat-icon"><i class="glyphicon glyphicon-cloud-upload fg-bitbucket"></i></span>
               <div class="mini-stat-info">
                  <span id="v-t4">0</span>
                  Total de Notas de Débito Registradas
               </div>
            </div>
         </div>
      </div>

       <!-- begin row -->            
      <div class="row">
         <!-- begin col-4 -->
         <div class="col-md-4">
            <div class="panel panel-inverse" data-sortable-id="index-1">
               <div class="panel-heading">
                  <h4 class="panel-title">Grafico de Ventas</h4>
               </div>
               <div class="panel-body">
               <canvas id="oilChart" width="600" height="400"></canvas>

               </div>
            </div>
         </div>
         <!-- end col-4 -->

         <!-- begin col-4 -->
         <div class="col-md-8">
            <div class="panel panel-inverse" data-sortable-id="index-1">
               <div class="panel-heading">
                  <h4 class="panel-title">Resumén Comprobantes Electrónicos</h4>
               </div>
               <div class="panel-body">
                  <table style="font-size:12px;" id="tb-lista" class="display responsive table table-striped table-bordered" width="100%" >

                     

                  </table>
               </div>
            </div>
         </div>
         <!-- end col-4 -->
      </div>
      <!-- end row -->


      <!-- begin row -->            
      <div class="row">
         <!-- begin col-4 -->
         <div class="col-md-4">
            <div class="panel panel-inverse" data-sortable-id="index-1">
               <div class="panel-heading">
                  <h4 class="panel-title">Comprobantes Electrónicos - Enviados</h4>
               </div>
               <div class="panel-body">
                  <div id="chartContainer1">
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-4 -->
         <!-- begin col-4 -->
         <div class="col-md-4">
            <div class="panel panel-inverse" data-sortable-id="flot-chart-5">
               <div class="panel-heading">
                  <h4 class="panel-title">Comprobantes Electrónicos - No Enviados</h4>
               </div>
               <div class="panel-body">
                  <div id="chartContainer2">
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-4 -->
         <!-- begin col-4 -->
         <div class="col-md-4">
            <div class="panel panel-inverse" data-sortable-id="flot-chart-6">
               <div class="panel-heading">
                  <h4 class="panel-title ">Comprobantes Electrónicos - Con Errores</h4>
               </div>
               <div class="panel-body">
                  <div id="chartContainer3">
                  </div>
               </div>
            </div>
         </div>
         <!-- end col-4 -->
      </div>
      <!-- end row -->
   </div>
</div>
<!-- end #content -->
<?php 
   require_once('footer.php');
   ?>

<script src="js/js.dashboard0.js"></script>