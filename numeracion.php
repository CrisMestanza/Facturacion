<?php 
require 'header.php';
?>

      <div class="panel-group">
         <div class="panel panel-default">
            <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card">
                           <table id="miTabla" class="table table-striped table-bordered"></table>
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
      <!-- DETALLE DEL SERVICIO Ó PRODUCTO  -->
       <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div  class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4><span class="glyphicon glyphicon-info-sign"></span> Numeración </h4>
                  </div>
                   <div class="modal-body" style="padding:40px 50px;">
                        <form>
                            <div id="msj-alert"></div>
                            <input type="text" id="a-id" style="display: none;">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Serie :</label>
                                <div class="col-sm-9">
                                    <input id="a-serie" type="text" class="form-control form-control-round" placeholder="F001" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Número :</label>
                                <div class="col-sm-9">
                                    <input id="a-numero" type="text" class="form-control form-control-round" placeholder="00000000" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo de Comprobate :</label>
                                <div class="col-sm-9">
                                  <select id="a-comp"  class="form-control" >                    
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dirección :</label>
                                <div class="col-sm-9">
                                  <select id="a-dir"  class="form-control "  >                    
                                  </select>
                                </div>
                            </div>





                        </form>

                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-sm-12">
                                <button id="btn-guardar" type="button" class="btn btn-primary btn-round "><span class="glyphicon glyphicon-floppy-disk"></span> Guardar Registro</button>
                                <button id="btn-cancelar" type="button" class="btn btn-danger btn-round " data-dismiss="modal"> <span class="fa fa-times"></span> Cerrar</button>
                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

<?php 
   require 'footer.php'

?>
<script type="text/javascript" src="js/numeracion.js"></script>
