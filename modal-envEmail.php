    <style>
       .center {
         margin-left: auto;
         margin-right: auto;
         display: block;
         font-weight: bold;
         text-align: center;
        }
    </style>

    <div class="modal fade" id="myModal3" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" >
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" >&times;</button>
                    <h4><span class="glyphicon glyphicon-info-sign"></span> Enviar Correo</h4>
                </div>
                <div class="modal-body">
                    <div id="error-correo"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                         <label class="center">Correo Electrónico</label>
                         <input type="text" id="a-cpe-correo" style="display: none;">
                         <input  type="text" class="form-control center"  id="a-correo-e" >
                         <div id="div-correo" class="center">
    
                         </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-correo-e" onclick="LoadCorreo_e();"  type="button" class="btn btn-primary btn-round "><span class="fa fa-envelope-o"></span> Enviar</button>
                     <button  type="button" class="btn btn-danger btn-round " data-dismiss="modal"> <span class="fa fa-times"></span> Cerrar</button>
                     
                </div>
            </div>
        </div>
    </div>