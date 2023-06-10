    <style>
       .center {
         margin-left: auto;
         margin-right: auto;
         display: block;
         font-weight: bold;
         text-align: center;
        }
    </style>

    <div class="modal fade" id="myModal2" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" >
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" >&times;</button>
                    <h4 id ="tipo-envio">  </h4>
                    <label style="display:none;" id ="envios-cpe"></label>

                </div>
                <div class="modal-body">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label class="center" id="cpe-id"></label>
                        <img class="center" src="imagenes/spinner.gif"   />

                    </div>
                </div>
                <div class="modal-footer">
                   <button style="display:none;" id="btn-cerrar" type="button" class="btn btn-danger pull-left" ><span class="glyphicon glyphicon-remove-sign"></span> Cerrar</button>
                </div>
            </div>
        </div>
    </div>