<!-- DETALLE DEL CLIENTE  -->
<div class="modal fade" id="myModal">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div  class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4><span class="glyphicon glyphicon-info-sign"></span> Información de la Empresa</h4>
         </div>
         <div class="modal-body" style="padding:40px 50px;">
            <form>
               <div id="msj-alert"></div>
               <input type="text" id="a-id" style="display: none;">

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">N° Documento:</label>
                  <div class="col-sm-9">
                     <input id="a-doc" type="text" class="form-control form-control-round" placeholder="Documento (Dni, Ruc ó OTros)" autocomplete="off">
                  </div>
               </div>
               

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nombres y Apellidos (Representante):</label>
                  <div class="col-sm-9">
                     <input id="a-nom" type="text" class="form-control form-control-round" placeholder="Nombre del representante legal" autocomplete="off">
                  </div>
               </div>


               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">N° Ruc:</label>
                  <div class="col-sm-9">
                     <input id="a-ruc" type="text" class="form-control form-control-round" placeholder="Ruc del contribuyente" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nombre ó razón :</label>
                  <div class="col-sm-9">
                     <input id="a-raz" type="text" class="form-control form-control-round" placeholder="Nombre ó razón Social" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Dirección :</label>
                  <div class="col-sm-9">
                     <input id="a-dir" type="text" class="form-control form-control-round" placeholder="Dirección Fiscal" autocomplete="off">
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">País :</label>
                  <div class="col-sm-9">
                      <input type="text" id="id-pais" style="display: none;">
                     <select id="a-pais"  style="width: 100%"  class="itemPais form-control "  name="itemPais">
                     </select>
                  </div>
               </div>



               <div class="row">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <label >Departamento :</label>
                  <div >
                     <select class="form-control" id="a-dpt">
                     </select>
                  </div>
                  </div>
                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  <label >Provincia :</label>
                  <div >
                     <select class="form-control" id="a-prov">
                     </select>
                  </div>
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12  form-group">
                  <label >Distrito :</label>
                  <div >
                     <select class="form-control" id="a-dist">
                     </select>
                     <input type="text" style="display: none;" id="a-ubigeo">
                  </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label >N° Local</label>
                     <input  type="text" class="form-control"  id="a-local" >
                  </div>
                  <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                     <label >Email </label>
                     <input  type="text"  class="form-control"  id="a-email" >
                  </div>
                  <div class="col-md-4 col-sm-12 col-xs-12  form-group">
                     <label >Contraseña </label>
                     <input  type="text" class="form-control"  id="a-clave2" >
                  </div>

               </div>

               <div class="row">
               <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                     <label >Celular </label>
                     <input  type="text"  class="form-control"  id="a-cel" >
                  </div>
                  
                  <div class="col-md-5 col-sm-12 col-xs-12  form-group">
                     <label >Urbanización </label>
                     <input  type="text" class="form-control"  id="a-urb" >
                  </div>

                  <div class="col-md-4 col-sm-12 col-xs-12  form-group">
                     <label >Telefono </label>
                     <input  type="text" class="form-control"  id="a-tel" >
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