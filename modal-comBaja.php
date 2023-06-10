    <style>
       .center {
         margin-left: auto;
         margin-right: auto;
         display: block;
         font-weight: bold;
         text-align: center;
        }
    </style>

    <div class="modal fade" id="myModal-baja" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" >
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" >&times;</button>
                    <h4><span class="glyphicon glyphicon-info-sign"></span> Anulación</h4>
                </div>
                <div class="modal-body">
                    <div id="error-baja"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                         <label id="cod-baja" class="center"></label>
                         <label id="ticket-baja" class="center"></label>
                         <textarea id="a-com_baj" type="text" class="form-control" placeholder="Descripción de la baja" autocomplete="off" rows="4" cols="25"></textarea> 
                         <div id="div-baja" class="center"></div>
                       
                         <label id="rpta-baja" style="display: none;" class="center"></label>

                    </div>
                </div>
                <div class="modal-footer">
                     <button id="btn-ticket-e" onclick="LoadTicket_e();"  type="button" class="btn btn-success btn-round "><span class="fa fa-ticket"></span> Ticket</button>
                     <button id="btn-baja-e" onclick="LoadBaja_e();"  type="button" class="btn btn-primary btn-round "><span class="fa fa-cloud-upload"></span> Enviar</button>
                     
                     <button onclick="cerrar_baja();"  type="button" class="btn btn-danger btn-round " > <span class="fa fa-times"></span> Cerrar</button>
                     
                </div>
            </div>
        </div>
    </div>