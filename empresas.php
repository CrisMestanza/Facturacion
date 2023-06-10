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


<!-- DETALLE DE LAS DIRECCIONES ADICIONALES  -->
<div class="modal fade" id="myModal2">
   <!-- Nav pills -->
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div  class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="glyphicon glyphicon-info-sign"></span> Direcciones Adicionales</h4>
         </div>
         <div class="modal-body" style="padding:40px 50px;">
            <form>
               <div id="msj-alert-d"></div>
               <input type="text" id="a-id-d" style="display: none;">
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Dirección :</label>
                  <div class="col-sm-9">
                     <input id="a-dir-d" type="text" class="form-control form-control-round" placeholder="Dirección Fiscal" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">País :</label>
                  <div class="col-sm-9">
                     <input type="text" id="id-pais-d" style="display: none;">
                     <select id="a-pais-d"  style="width: 100%"  class="itemPais form-control "  name="itemPais">
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Departamento :</label>
                  <div class="col-sm-9">
                     <select class="form-control" id="a-dpt-d">
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Provincia :</label>
                  <div class="col-sm-9">
                     <select class="form-control" id="a-prov-d">
                     </select>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Distrito :</label>
                  <div class="col-sm-9">
                     <select class="form-control" id="a-dist-d">
                     </select>
                     <input type="text" style="display: none;" id="a-ubigeo-d">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label >N° Local</label>
                     <input  type="text" class="form-control"  id="a-local-d" >
                  </div>
                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                     <label >Telefono </label>
                     <input  type="text"  class="form-control"  id="a-tel-d" >
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12  form-group">
                     <label >Urbanización </label>
                     <input  type="text" class="form-control"  id="a-urb-d" >
                  </div>
               </div>
               <input type="text" id="a-cli-d" style="display: none;">
            </form>
            <table style="font-size:12px;" id="tb-dir" class="display responsive" width="100%" >
               <thead >
                  <tr>
                     <th  >Código</th>
                     <th  style="text-align: left;">|Edición</th>
                     <th  style="text-align: left;">Dirección</th>
                     <th  style="text-align: center;">Departamento</th>
                     <th  style="text-align: center;">Prvincia </th>
                     <th  style="text-align: center;">Distrito </th>
                  </tr>
               </thead>
               <tbody id="detalle-dir">
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <div class="form-group">
               <div class="col-sm-12">
                     <button id="btn-guardar-d" type="button" class="btn btn-primary btn-round "><span class="glyphicon glyphicon-floppy-disk"></span> Guardar Registro</button>
                     <button id="btn-cancelar-d" type="button" class="btn btn-danger btn-round " data-dismiss="modal"> <span class="fa fa-times"></span> Cerrar</button>
                     
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
   require 'modal-empresa.php';
   require 'footer.php';
   ?>
   <script type="text/javascript" src="js/dt.empresas.js"></script>
<script type="text/javascript" src="js/empresas.js"></script>
<script type="text/javascript" src="js/usuarios.js"></script>
<script type="text/javascript" src="js/dir-empresas.js"></script>