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
                     <h4><span class="glyphicon glyphicon-info-sign"></span> Bienes y Servicios </h4>
                  </div>
                   <div class="modal-body" style="padding:40px 50px;">
                        <form>
                            <div id="msj-alert"></div>
                            <input type="text" id="a-id" style="display: none;">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Código :</label>
                                <div class="col-sm-9">
                                    <input id="a-cod" type="text" class="form-control form-control-round" placeholder="Código Interno" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Código Sunat :</label>
                                <div class="col-sm-9">
                                <input id="a-idsunat" type="text" style="display:none;" />
                                  <select id="a-codsunat"  style="width: 100%" class="itemCodSunat form-control "  name="itemCodSunat">
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Descripción :</label>
                                <div class="col-sm-9">
                                     <textarea id="a-det" type="text" class="form-control" placeholder="Detalle del Bien ó Servicio" autocomplete="off" rows="4" cols="50"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Unidad :</label>
                                <div class="col-sm-9">
                                <input id="a-id-und" style="display:none;" type="text" />
                                  <select id="a-und"  style="width: 100%"  class="itemUnidad form-control "  name="itemUnidad">
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Operación :</label>
                                <div class="col-sm-9">
                                   <select id="a-ope" class="form-control"  >
                                   </select>
                                </div>
                            </div>

                        <div class="row">
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <label >Impuesto %</label>
                               <select id="a-igv" class="form-control"  >
                                 <option value="0">0</option>
                                 <option value="18">18</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <label >Importe </label>
                              <input  name="5" type="text" onKeyPress="return soloNumeros(event)" class="form-control"  id="a-valor" >
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <label >Incluye Impuesto</label>
                              <select id="a-impuesto" class="form-control"  >
                                 <option value="1">SI</option>
                                 <option value="0">NO</option>
                              </select>
                           </div>
                           <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                              <label >Descuento % </label>
                              <input  type="text"  onKeyPress="return soloNumeros(event)" class="form-control"  id="a-descuento" >

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
<script type="text/javascript" src="js/items.js"></script>
