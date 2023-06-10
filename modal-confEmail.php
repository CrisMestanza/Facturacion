
    <div class="modal fade" id="myModal4" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" >
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4> Configurar Email  </h4>
                </div>
                <div class="modal-body">
                    <form role="form">
                            <div id="exito-e"></div>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Correo </label>
                                    <input id="b-correo" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Correo  Electrónico">                 
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Contraseña </label>
                                    <input id="b-clave" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Contraseña">                 
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Confirmar Contraseña </label>
                                    <input id="b-clave2" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Confirmar contraseña">                 
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Servidor </label>
                                    <input id="b-servidor" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Host del servidor">                 
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Puerto </label>
                                    <input id="b-puerto" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Correo  Electrónico">                 
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <label>HTML </label>
                                    <input id="b-html" type="checkbox" name="my-checkbox" checked data-on-text="Sí" data-off-text="No" />
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <label>Adjuntos</label>
                                    <input id="b-adjuntos" type="checkbox" name="my-checkbox" checked data-on-text="Sí" data-off-text="No" />
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <label>Autorización</label>
                                    <input id="b-ssl" type="checkbox" name="my-checkbox" checked data-on-text="Sí" data-off-text="No" />
                                </div>
                                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <label>Seguridad</label>
                                    <input id="b-email-p" type="checkbox" name="my-checkbox" checked data-on-text="ssl" data-off-text="tls" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Correo de Envío (Test): </label>
                                    <input id="b-correo-envio" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Correo Electrónico de envío">                 
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>CC(Copia) </label>
                                    <input id="b-correo-cc" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Correo con copia adjunta">                 
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>CCP (Copia Oculta) </label>
                                    <input id="b-correo-cco" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Correo con copia oculta">                 
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Asunto </label>
                                    <input id="b-asunto" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Asunto de Correo">                 
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label>Body</label>
                                    <textarea id="b-body" type="text" class="form-control" placeholder="Información de la cabezera" autocomplete="off" rows="6" cols="50"></textarea>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                    <label>Footer </label>
                                    <textarea id="b-footer" type="text" class="form-control" placeholder="Información del pie de página" autocomplete="off" rows="6" cols="50"></textarea>                
                                </div>


                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                   <button  id="btn-email"  type="button" class="btn btn-success pull-left" ><span class="glyphicon glyphicon-remove-sign"></span> Registrar</button>
                   <button  id="btn-cerrar" data-dismiss="modal" type="button" class="btn btn-danger pull-left" ><span class="glyphicon glyphicon-remove-sign"></span> Cerrar</button>
                   <button  id="btn-email-test"  type="button" class="btn btn-primary pull-rigth" ><span class="fa fa-envelope-o"></span> Enviar Correo de Prueba</button>
                </div>
            </div>
        </div>
    </div>