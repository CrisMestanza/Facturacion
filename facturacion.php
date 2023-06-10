<?php 
require 'header.php';
?>

<style type="text/css">
    
.contenedor {

  display: flex;
  justify-content: center;
  align-items: center;
}
table thead {
  color: #fff;
  background-color: #337ab7;
}
</style>


    <div class="contenedor">
      
   

    <div style=" width: 90%;" class="panel-group">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post">
                    <div id="exito"></div>
                    <div class="row">

                       <label style="display: none;" id="n-codigo" >
								            <?php  if (isset($_GET['codigo'])) {
                                                       echo $_GET['codigo'];
                                                  } else {
												       echo 0;
											      }
											?>
						</label>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Comprobantfe:</label>
                            <select id="a-tipocomp" class="form-control form-control-round">
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Fecha de Emisión:</label>
                            <input id="a-fecha" type="text" class="form-control" placeholder="dd/mm/yyyy" data-toggle="tooltip" -placement="top" title="Fecha de emisión del comprobante de pago"autocomplete="off">
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <input id="a-comp" style="display: none;" class="form-control">
                            <label>Serie:</label>
                            <select id="a-serie" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Número</label>
                            <input id="a-dirEmp" style="display: none;" class="form-control">
                            <input id="a-num" style="text-align: center;" readonly="true" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Número correlativo del comprobante de pago ">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <label>Cliente:</label>
                            <input id="a-idcliente" style="display: none;" class="form-control">
                            <select id="a-cliente" style="width: 100%" onchange="LoadClientes();" class="itemName form-control " name="itemName">
                            </select>

                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <label>Dirección:</label>
                            <select id="a-direccion"  class="form-control form-control-round">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div id="v-referencia" style="display: none;" class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Referencia del Comprobante:</label>
                            <div class="input-group">
                                <input id="a-ref-cpe" type="text" style="display:none;">
                                <input id="a-referencia" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Referencia del Comprobante Electrónico">
                            
                                <div class="input-group-btn">
                                     <button id="btn-ref" class="form-control btn btn-default btn-sm btn-warning" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div id="v-fecha-v" class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Fecha Vencimiento:</label>
                            <input id="a-fecha-v" type="text" class="form-control" placeholder="dd/mm/yyyy" data-toggle="tooltip" -placement="top" title="Fecha de emisión del comprobante de pago">
                        </div>

                        <div id="v-nota" style="display: none;" class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Motivo de la Nota: </label>
                            <select id="a-nota" class="form-control" data-toggle="tooltip" -placement="top" title="C">
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Moneda:</label>
                            <select id="a-moneda" onchange="ValidaMoneda();" class="form-control form-control-round">
                            </select>'

                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>T.C</label>
                            <input id="a-tc" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Tipo de Cambio ">
                        </div>
                        <div id="v-pago" class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Forma de Pago:</label>
                            <select id="a-pago" class="form-control" data-toggle="tooltip" -placement="top" title="C">
                            </select>
                        </div>
                        <div id="v-dia" style="display: none;" class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Dias</label>
                            <input id="a-dias" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Días del Crédito">
                        </div>


                        
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <label>Observación</label>
                            <input id="a-obs" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Días del Crédito">
                        </div>



                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Impresión:</label>
                            <input id="a-saltos" style="display: none;" type="text" >
                            <select id="a-print" class="form-control" data-toggle="tooltip" -placement="top" title="C">
                            </select>
                        </div>

                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>¿Enviar?:</label>
                            <input id="a-envio" type="checkbox" name="my-checkbox" checked data-on-text="Sí" data-off-text="No" />
                        </div>

                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <button type="button" class="btn btn-success pull-right" id="btn-add"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
                        </div>
                    </div>
                    <div id="bd-tabla">
                        <table width="10O%" id="example" style="" class="table table-striped  table-responsive  table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%"></th>
                                    <th width="2%"></th>
                                    <th style="display:none;">Código</th>
                                    <th width="5%">Unidad</th>
                                    <th width="42%">Descripción</th>
                                    <th width="4%">Tributo</th>
                                    <th width="9%">Cantidad</th>
                                    <th width="9%">Precio Unitario</th>
                                    <th width="9%">Sub Total</th>
                                    <th width="9%">Igv</th>
                                    <th width="9%">Precio de Venta</th>
                                    <th style="display:none;">Valor Vta</th>
                                    <th style="display:none;">cod producto</th>
                                    <th style="display:none;">cod sunat</th>
                                    <th style="display:none;">inpuesto</th>
                                    <th style="display:none;">aplica impuesto</th>
                                </tr>
                            </thead>
                            <tbody id="detalle-factura">
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="col-md-12">
                        <table id="totales" border="0" cellspacing="0">
                            <tbody>
                                <tr style="display: none;"></tr>

                                <tr>
                                    <td class="text-right">
                                        <strong>Exonerada : </strong>
                                    </td>
                                    <td id="exonerada" class="text-right rejilla"></td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <strong>Inafecta : </strong>
                                    </td>
                                    <td id="inafecta" class="text-right rejilla"></td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <strong>Gravada : </strong>
                                    </td>
                                    <td id="gravada" class="text-right rejilla"></td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <strong>IGV : </strong>
                                    </td>
                                    <td id="igv" class="text-right rejilla"></td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <strong>Gratuita : </strong>
                                    </td>
                                    <td id="gratuita" class="text-right rejilla"></td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <strong>Otros Cargos : </strong>
                                    </td>
                                    <td id="otros" class="text-right rejilla"></td>
                                </tr>
                                <tr>
                                    <td class="text-right">
                                        <strong>Descuentos : </strong>
                                    </td>
                                    <td id="descuentos" class="text-right rejilla"></td>
                                </tr>

                                <tr>
                                    <td class="text-right">
                                        <strong>Totales : </strong>
                                    </td>
                                    <td id="total" class="text-right rejilla"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- DETALLE DEL SERVICIO Ó PRODUCTO  -->
    <!-- Modal -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal-Detalle" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-info-sign"></span> Detalle del Servicio ó Producto</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <div id="exito-datos"></div>
                    <div class="panel-body">
                        <form role="form">
                            <div id="exito-a"></div>
                            <div class="row">

                                <input id="a-id-d" style="display: none;" type="text" name="1">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label>Descripción: </label>
                                    <input id="a-cod-items" style="display: none;" type="text" name="0">
                                    <select onchange="LoadItems();" style="width: 100%" id="a-detalle-d" class="itemBien form-control" name="itemBien"></select>
                                </div>

                            </div>

                            <div class="row">
                                <input id="a-tributo-d" style="display: none;" type="text" name="3">
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Cantidad: </label>
                                    <input name="4" type="text" onKeyPress="return soloNumeros(event)" class="form-control" id="a-cantidad-d">
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Importe: </label>
                                    <input name="13"  type="text" onKeyPress="return soloNumeros(event)" class="form-control" id="a-valor-d">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Sub Total: </label>
                                    <input name="5" type="text" readonly="true" onKeyPress="return soloNumeros(event)" class="form-control" id="a-subtotal-d">
                                </div>

                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Igv: </label>
                                    <input name="6" type="text" readonly="true" onKeyPress="return soloNumeros(event)" class="form-control" id="a-igv-d">
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <label>Total: </label>
                                    <input name="7" type="text" readonly="true" onKeyPress="return soloNumeros(event)" class="form-control" id="a-precio-d">
                                    <input name="8" style="display: none;" id="a-valortotal-d" type="text" class="form-control">
                                </div>
                            </div>

                            <input id="a-cod-d" style="display: none;" type="text" name="9">
                            <input name="10" id="a-sun-d" style="display: none;" type="text" class="form-control">
                            <input name="11" id="a-imp-d" style="display: none;" type="text" class="form-control">
                            <input name="12" id="a-tipo-d" style="display: none;" type="text" class="form-control">
                            <input name="14" id="a-itemid" style="display: none;" type="text" class="form-control">
                            <input name="15" id="a-itemdet" style="display: none;" type="text" class="form-control">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add-detalle" type="button" class="btn btn-success pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
                    <button type="button" style="display: none;" class="btn btn-success pull-right" id="btn-update"><span class="glyphicon glyphicon-floppy-save"></span> Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- INFORMACIÒN ADICIONAL  -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-info-sign"></span> Comprobante Electrónico de Referencia </h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                        <label>Seleccione el Comprobante</label>
                        <div class="input-group">

                            <select id="a-txt-bref" class="form-control" data-toggle="tooltip" -placement="top">
                                <option value="01">FACTURA</option>
                                <option value="03">BOLETA DE VENTA</option>
                            </select>
                            <div class="input-group-btn">
                                <button id="btn-buscar-ref" class="form-control  btn btn-default btn-sm btn-primary" type="button"><i class="glyphicon glyphicon-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                    <table style="font-size:12px;" id="tb-nota" class="display responsive" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: left;">..... </th>
                                <th style="text-align: center;">Comprobante</th>
                                <th style="text-align: center;">Fecha Emisión</th>
                                <th style="text-align: center;">Documento </th>
                                <th style="text-align: center;">Nombre ó Razón Social </th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="detalle-nota">
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php 
     require 'modal-envio.php';
     require 'modal-envEmail.php';
     require 'footer.php';
    ?>


       <script type="text/javascript" src="js/archivos.js"></script>
        <script type="text/javascript" src="js/fechas.js"></script>
        <script type="text/javascript" src="js/dt.facturacion.js"></script>
        <script type="text/javascript" src="js/facturacion.js"></script>
        <script type="text/javascript" src="js/notas.js"></script>
        <script type="text/javascript" src="js/procesos.js"></script>

