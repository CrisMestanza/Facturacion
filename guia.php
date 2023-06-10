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
  background-color: #c0392b;
}
</style>


    <div class="contenedor">
      
   

    <div style=" width: 90%;" class="panel-group">
        <div class="panel panel-default">
            <div class="panel-body">
                <form method="post">
                    <div id="exito"></div>
                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Fecha de Emisión:</label>
                            <input id="a-fecha" type="text" class="form-control" placeholder="dd/mm/yyyy" data-toggle="tooltip" -placement="top" title="Fecha de emisión de Emisión">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Fecha de LLegada:</label>
                            <input id="a-fecha2" type="text" class="form-control" placeholder="dd/mm/yyyy" data-toggle="tooltip" -placement="top" title="Fecha de emisión de llegada">
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <input id="a-comp" style="display: none;" class="form-control">
                            <label>Serie:</label>
                            <select id="a-serie" class="form-control">
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Número</label>
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

                        <div  class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Modo de Traslado:</label>
                            <select id="a-mtraslado" class="form-control form-control">
                                <option value="01">Transporte Publico</option>
			                    <option value="02">Trasporte Privado</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Motivo de Traslado:</label>
                            <select id="a-atraslado" class="form-control form-control">
                                <option value="01">Venta</option>
			                    <option value="02">Compra</option>
                            </select>

                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                        <label>Unidad de Medida:</label>
                                  <input id="a-id-und" style="display:none;" type="text" />
                                  <select id="a-und"  style="width: 100%"  class="itemUnidad form-control "  name="itemUnidad">                    
                                  </select>
                        </div>

                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Peso Total:</label>
                            <input id="a-peso" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >

                        </div>

                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>N° Paquetes:</label>
                            <input id="a-paquetes" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
                        </div>

                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label>Observaciones:</label>
                            <input id="a-observaciones" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
                        </div>

                    </div>

                    <h3>Datos de Envio<h5> Dirección de entrega</h5></h3>

                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>País:</label>
                            <select id="a-pais"  style="width: 100%"  class="itemPais form-control "  name="itemPais">                    
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Departamento:</label>
                            <?php 
                                   require_once('model/conexion.php');
                                   $mysqli =  conectar();
                                   if($mysqli ->connect_errno)
                                   {
                                          echo "Fallo al conectar".$mysqli->connect_errno;
                                   }
                                   else
                                   {
                                   $myquery="SELECT * FROM catalogo_13_dpt WHERE estado=1";
                                    $resultado = $mysqli->query($myquery);
                                           echo '<select  id="a-dpt" class="form-control" data-toggle="tooltip" -placement="top" title="Departamento">';
                            
                                       while($fila = $resultado ->fetch_assoc()){
                                           echo '<option value="'.$fila['id'].'">'.$fila['detalle'].'</option>';
                                       }                           
                                           echo'</select>';
                                    }
                                 ?>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Provincia:</label>
                            <select class="form-control" id="a-prov">
                                     </select>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Distrito:</label>
                            <select class="form-control" id="a-dist">
                                     </select>
                                     <input type="text" style="display: none;" id="a-ubigeo">
                        </div>
                    </div>

                    <h5> Dirección de llegada</h5>

                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>País:</label>
                            <select id="a-pais-2"  style="width: 100%"  class="itemPais form-control "  name="itemPais">                    
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Departamento:</label>
                            <?php 
                                   require_once('model/conexion.php');
                                   $mysqli =  conectar();
                                   if($mysqli ->connect_errno)
                                   {
                                          echo "Fallo al conectar".$mysqli->connect_errno;
                                   }
                                   else
                                   {
                                   $myquery="SELECT * FROM catalogo_13_dpt WHERE estado=1";
                                    $resultado = $mysqli->query($myquery);
                                           echo '<select  id="a-dpt-2" class="form-control" data-toggle="tooltip" -placement="top" title="Departamento">';
                            
                                       while($fila = $resultado ->fetch_assoc()){
                                           echo '<option value="'.$fila['id'].'">'.$fila['detalle'].'</option>';
                                       }                           
                                           echo'</select>';
                                    }
                                 ?>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Provincia:</label>
                            <select class="form-control" id="a-prov-2">
                                     </select>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Distrito:</label>
                            <select class="form-control" id="a-dist-2">
                                     </select>
                                     <input type="text" style="display: none;" id="a-ubigeo-2">
                        </div>
                    </div> 

                    
                    <h3>Datos del Transportista</h3>

                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <label>Selección rápida del transportista:</label>
                            <select id="a-transportista" style="width: 100%" onchange="LoadClientes();" class="itemName form-control " name="itemName">
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Tipo Doc. Identidad *</label>
                            <?php 
                                   require_once('model/conexion.php');
                                   $mysqli =  conectar();
                                   if($mysqli ->connect_errno)
                                   {
                                          echo "Fallo al conectar".$mysqli->connect_errno;
                                   }
                                   else
                                   {
                                   $myquery="SELECT * FROM catalogo_06 WHERE estado=1";
                                    $resultado = $mysqli->query($myquery);
                                           echo '<select  id="a-tipo-t" class="form-control" data-toggle="tooltip" -placement="top" title="Catálogo No. 07: Códigos de Tipo de Afectación del IGV ">';
                            
                                       while($fila = $resultado ->fetch_assoc()){
                                           echo '<option value="'.$fila['id'].'">'.$fila['detalle'].'</option>';
                                       }                           
                                           echo'</select>';
                                    }
                                 ?>

                             
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Número:</label>
                            <input id="a-numero-t" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label>Nombre y/o razón social *</label>
                            <input id="a-razon-t" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >

                        </div>
                    </div>

                    <h3>Datos del Conductor</h3>

                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <label>Selección rápida de conductor:</label>
                            <select id="a-conductor" style="width: 100%" onchange="LoadClientes();" class="itemName form-control " name="itemName">
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Tipo Doc. Identidad *</label>
                            <?php 
                                   require_once('model/conexion.php');
                                   $mysqli =  conectar();
                                   if($mysqli ->connect_errno)
                                   {
                                          echo "Fallo al conectar".$mysqli->connect_errno;
                                   }
                                   else
                                   {
                                   $myquery="SELECT * FROM catalogo_06 WHERE estado=1";
                                    $resultado = $mysqli->query($myquery);
                                           echo '<select  id="a-tipo-c" class="form-control" data-toggle="tooltip" -placement="top" title="Catálogo No. 07: Códigos de Tipo de Afectación del IGV ">';
                            
                                       while($fila = $resultado ->fetch_assoc()){
                                           echo '<option value="'.$fila['id'].'">'.$fila['detalle'].'</option>';
                                       }                           
                                           echo'</select>';
                                    }
                                 ?>

                             
                        </div>

                        <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Número:</label>
                            <input id="a-numero-c" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Numero de placa del vehiculo *</label>
                            <input id="a-placa" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>Licencia del conductor</label>
                            <input id="a-licencia" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>N° placa semirremolque</label>
                            <input id="a-placa-s" type="text" class="form-control"  data-toggle="tooltip" -placement="top" >
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
                                    <input name="13" type="text" onKeyPress="return soloNumeros(event)" class="form-control" id="a-valor-d">
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
                                    <input name="8" id="a-valortotal-d" style="display: none;" type="text" class="form-control">
                                </div>
                            </div>

                            <input id="a-cod-d" style="display: none;" type="text" name="9">
                            <input name="10" id="a-sun-d" style="display: none;" type="text" class="form-control">
                            <input name="11" id="a-imp-d" style="display: none;" type="text" class="form-control">
                            <input name="12" id="a-tipo-d" style="display: none;" type="text" class="form-control">

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


 
    <?php 
   require 'footer.php'

?>
        <script type="text/javascript" src="js/dt.guia.js"></script>
        <script type="text/javascript" src="js/guia.js"></script>
