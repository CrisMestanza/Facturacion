<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title> Facturación</title>
<link rel="stylesheet" href="css/bootstrap.min.css"> 
<link rel="stylesheet" type="text/css" href="css/miestilo.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css"> 
<link rel="stylesheet" href="css/jquery-ui.min.css" />
<link rel="stylesheet" href="../utilerias/css/bootstrap-switch.css">

<style type="text/css">
    .iframe-container {    
       padding-bottom: 60%;
       padding-top: 30px; height: 0; overflow: hidden;
    }
 
    .iframe-container iframe,
    .iframe-container object,
    .iframe-container embed {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
</style>

</head>

<body class="container">
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">

      FACTURACIÓN
      <div class="btn-group pull-left">

         <div  class="dropdown">
          <button  class="btn btn-danger btn-xs dropdown-toggle " type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-home"></i> Ménu <span class="caret"></span></button>

             <ul  class="dropdown-menu" aria-labelledby="editar-600">
                 <li><a target="_blanck" href="http://dsigperu.net/facturadorsunat/"><span class="glyphicon glyphicon-home"></span>  Ménu Principal </a></li>
                 <li><a target="_blanck" href="#"><span class="glyphicon glyphicon-globe"></span>  Ver Video </a></li>
                 <li><a target="_blanck" href="javascript:abrir_aviso();"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></li>    
                 
              </ul>
          </div>
       </div>

      <button id="btn-enviar" type="button" class="btn btn-success pull-right"> <span class="glyphicon glyphicon-save"></span> Enviar </button>
      </div>
      <div class="panel-body">
      
      <form method="post">
        <div id="exito"></div>
           <div class="row">
                      
              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <div class="input-group">
                   <span class="input-group-addon">Operación: </span>
                   <select id="a-op" class="form-control" data-toggle="tooltip" -placement="top" title="Códigos de los motivos : 1 Conexión internet, 2. Fallas fluido eléctrico. 3.Desastres Naturales. 4. Robo. 5. Fallas en el sistema de emisión electrónica, 6 ventas por emisores itinerantes, 7 otros"> 
			         <option value="0101">Venta lnterna</option>
			         <option value="0200">Exportación</option>
		           </select>
                 </div>
              </div>

               <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <div class="input-group">
                   <span class="input-group-addon">Fecha: </span>
                   <input id="a-fecha"  type="text" class="form-control" placeholder="dd/mm/aaaa" data-toggle="tooltip" -placement="top" title="Fecha de emisión del comprobante de pago, nota de débito o nota de crédito: Ingrese la Fecha en Formato dd/mm/aaaa">
                  </div>
               </div>

              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <div class="input-group">
                   <span class="input-group-addon">Comprobante: </span>
                   <select id="a-comp" class="form-control" data-toggle="tooltip" -placement="top" title="Tipo de comprobante de pago, nota de débito o nota de crédito : Según catalogo N° 1 del Anexo 8. Solo se permite 01, 03,07,08 y 12"> 
			         <option value="01">Factura</option>
			         <option value="03">Boleta de Venta</option>
			         <option value="07">Nota de Crèdito</option>
			         <option value="08">Nota de Dèbito</option>
			         <option value="12">Ticket de Maquina Registradora</option>
		           </select>
                 </div>
              </div>

              <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <div class="input-group">
                   <span class="input-group-addon">Serie: </span>
                   <input  id="a-serie" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Número de serie del comprobante de pago, nota de credito o nota de debito y en el caso del ticket o cinta emitido por máquina registradora, el número de serie de fabricación de dicha máquina. Debe estar dentro del rango autorizado, salvo que se trate de tickets o cintas emitidos por máquina registradora. En los tickets o cintas emitidos por máquinas registradoras que no sustentan derecho a credito fiscal ni gasto o costo para efectos tributarios se indicará, en el campo respectivo, el importe total de las operaciones realizadas en el día y por máquina registradora.">
                  </div>
               </div>

               <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <div class="input-group">
                   <span class="input-group-addon">Nùmero: </span>
                   <input id="a-num"type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Número correlativo de cada nota de crédito, nota de débito o comprobante de pago y ticket o cinta emitido por máquina registradora a que se refiere el numeral 5.3 del artículo 4° del RCP. En los demás casos (tickets o cintas emitidos por máquinas registradoras que no sustenten derecho a crédito fiscal ni gasto o costo para efectos tributarios) registrar el número inicial del rango de tickets. En caso de los tickets o cintas emitidos por máquinas registradoras que no otorguen derecho a crédito fiscal ni costo o gasto para efectos tributarios, se indicará, en el campo respectivo, el importe total de las operaciones realizadas en el día y por máquina registradora">
                  </div>
               </div>


           </div>

           <div class="row">

              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                <div class="input-group">
                   <span class="input-group-addon">Tipo: </span>
                   <select  id="a-doc" class="form-control" data-toggle="tooltip" -placement="top" title="Tipo de documento de Identidad del adquirente o usuario"> 
			         <option value="0">Doc Trib No Dom. sin Ruc</option>
			         <option value="1">Doc Nacional de Identidad</option>
			         <option value="4">Carnet de Extranjeria</option>
			         <option value="6">Reg. Unico del Contribuyente</option>
			         <option value="7">Pasaporte</option>
			         <option value="7">Ced Diplomatica de Identidad</option>
		           </select>
                 </div>
              </div>

              <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <div class="input-group">
                   <span class="input-group-addon">Doc: </span>
                   <input  id="a-ndoc" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Número de documento de Identidad del adquirente o usuario. En caso sea RUC, deberá ser  válido.">
                  </div>
               </div>

              <div class="col-md-7 col-sm-12 col-xs-12 form-group">
                  <div class="input-group">
                   <span class="input-group-addon">Nombres ò Razòn: </span>
                   <input  id="a-raz" type="text" class="form-control" placeholder="" data-toggle="tooltip" -placement="top" title="Apellidos (paterno y materno) y nombres , denominación o razón social  del adquirente o usuario.">
                  </div>
               </div>
           </div>

           </div>


      </form>
     <div id="row">
    <div class="col-md-11 col-sm-12 col-xs-12 form-group">
         <button type="button" class="btn btn-primary pull-right" id="abrir_datos"><span class="glyphicon glyphicon-list-alt"></span> Datos Adicionales</button>
   </div>

    <div class="col-md-1 col-sm-12 col-xs-12 form-group">
         <button type="button" class="btn btn-success pull-right" id="btn-add"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
    </div>

</div>
<div class="panel-body">
    <div id="div1">
      <table id="example" class="table table-striped table-bordered table-hover table-responsive">
	      <thead>
		      <tr>
		        <th></th>
		        <th></th>			

			      <th>Código</th>
            <th>Unidad</th>
			      <th>Descripción</th>
            <th>Tributo</th>
            <th>Cantidad</th>
			      <th>Valor Unit.</th>
			      <th>Igv</th>			
			      <th>Precio Vta</th>
			      <th>Valor Vta</th>
	      	</tr>
	      </thead>
	      <tbody>		
	      </tbody>
      </table>
    </div>



        <form method="post">
            <div class="row">
              <div class="form-inline">
                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label for="">Gravada:</label>
                  <input  id="gravada" readonly="true" type="text" required class="form-control">
                </div>
              </div>

              <div class="form-inline">
                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label for="">Inafecta:</label>
                  <input  id="inafecta" readonly="true" type="text" required class="form-control">
                </div>
              </div>

                            <div class="form-inline">
                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label for="">Exonerada:</label>
                  <input  id="exonerada" readonly="true" type="text" required class="form-control">
                </div>
              </div>

                            <div class="form-inline">
                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label for="">Gratuita:</label>
                  <input  id="gratuita" readonly="true" type="text" required class="form-control">
                </div>
              </div>

                            <div class="form-inline">
                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label for="">Igv:</label>
                  <input  id="igv" readonly="true" type="text" required class="form-control">
                </div>
              </div>

                            <div class="form-inline">
                <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                  <label for="">Total:</label>
                  <input  id="total" readonly="true" type="text" required class="form-control">
                </div>
              </div>


            </div>
        </form>  
        </div>  
      </div>

    </div>
  </div>



<!-- DETALLE DEL SERVICIO Ó PRODUCTO  -->
<!-- Modal -->
<div class="modal fade" id="myModal-Detalle" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div  class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-info-sign"></span> Detalle del Servicio ó Producto</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
         <div id="exito-datos"></div>
          <form role="form">
            <div class="row">
                <div id="exito-a"></div>
                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                   <label >Código: </label>
                   <input name="0" type="text" class="form-control"  id="a-codigo-d" >
                  </div>

                  <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    <label ><span class="fa fa-toggle-off"></span> Movimiento</label>
                    <input name="1" id="a-mov" style="display: none;" type="text" class="form-control" >
                    <div class="row">
                      <div class="col-xs-9">
                        <input id="a-movimiento-d" type="checkbox" name="my-checkbox" checked data-on-text="Servicio" data-off-text="Producto"/>
                      </div>
                    </div>
                  </div>

            </div>

            <div class="form-group">
              <label >Descripción: </label>
              <input name="2" type="text" class="form-control"  id="a-detalle-d" >
            </div>

            <div class="form-group">
              <label >Tipo de Afectación:</label>
                   <select name="3" id="a-tributo-d" class="form-control" data-toggle="tooltip" -placement="top" title="Catálogo No. 07: Códigos de Tipo de Afectación del IGV "> 
               <option value="10">Gravado -  Operación Onerosa</option>
               <option value="11">Gravado – Retiro por premio</option>
               <option value="12">Gravado – Retiro por donación</option>
               <option value="13">Gravado – Retiro</option>
               <option value="14">Gravado – Retiro por publicidad</option>
               <option value="15">Gravado – Bonificaciones</option>
               <option value="16">Gravado – Retiro por entrega a trabajadores</option>
               <option value="17">Gravado – IVAP</option>
               <option value="20">Exonerado - Operación Onerosa</option>
               <option value="21">Exonerado – Transferencia Gratuita</option>
               <option value="30">Inafecto - Operación Onerosa</option>
               <option value="31">Inafecto – Retiro por Bonificación</option>
               <option value="32">Inafecto – Retiro</option>
               <option value="33">Inafecto – Retiro por Muestras Médica</option>
               <option value="34">Inafecto -  Retiro por Convenio Colectivo</option>
               <option value="35">Inafecto – Retiro por premio </option>
               <option value="36">Inafecto -  Retiro por publicidad</option>
               <option value="40">Exportación</option>

               </select>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <label >Cantidad: </label>
                    <input  name="4" type="text" onKeyPress="return soloNumeros(event)" class="form-control"  id="a-cantidad-d" >
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <label >Valor Unit.: </label>
                    <input  name="5" type="text" onKeyPress="return soloNumeros(event)" class="form-control"  id="a-valor-d" >
                </div>


                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <label >Igv: </label>
                    <input name="6" type="text" readonly="true" onKeyPress="return soloNumeros(event)" class="form-control"  id="a-igv-d" >
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                    <label >Total: </label>
                    <input name="7" type="text" readonly="true" onKeyPress="return soloNumeros(event)" class="form-control"  id="a-precio-d" >
                    <input name="8" id="a-valortotal-d" style="display: none;" type="text" class="form-control" >
                </div>


            </div>

            </form>

        </div>
        <div class="modal-footer">
          <button id="add-detalle" type="button" class="btn btn-success pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
          <button type="button" style="display: none;" class="btn btn-success pull-right" id="btn-update"><span class="glyphicon glyphicon-floppy-save"></span> Actualizar</button>

        </div>
      </div>
      
    </div>
</div>  

<!-- INFORMACIÒN ADICIONAL  -->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div  class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-info-sign"></span> Informaciòn Adicional </h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
         <div id="exito-datos"></div>
          <form role="form">
            <div class="form-group">
              <label >Comprobante a Modificar :</label>
                   <select  id="a-comp-m" class="form-control" data-toggle="tooltip" -placement="top" title="Tipo de comprobante de pago, nota de débito o nota de crédito : Según catalogo N° 1 del Anexo 8. Solo se permite 01, 03,07,08 y 12"> 
			         <option value=""></option>
			         <option value="01">Factura</option>
			         <option value="03">Boleta de Venta</option>
		           </select>
            </div>
            <div class="form-group">
              <label >Serie a Modificar: </label>
              <input  type="text" class="form-control"  id="a-ser-m" >
            </div>
            <div class="form-group">
              <label >Numero a Modificar: </label>
              <input  type="text" class="form-control"  id="a-num-m" >
            </div>
            </form>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cerrar</button>
        </div>
      </div>
      
    </div>
</div>



  <!-- Modal -->
<div class="modal fade" id="modal-aviso" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div  class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-info-sign"></span> Casos Practicos </h4>
        </div>
        <div class="modal-body" style="padding:20px 50px;">
          <form id="avido-lbl">
            <div class="form-group">
              <label >1.- Una factura física por 2,420 emitida en soles cuya operación se encuentra gravada con el IGV</label>
              <label>2.- Una Boleta de venta física por 1,300 emitida en soles cuya operación se encuentra gravada con el IGV y se encuentra identificado el cliente.</label>
              <label>3.- Una nota de crédito física por 470 emitida en soles cuya operación se encuentra gravada del IGV. La La factura relacionada es la de serie 0001 y número 1.</label>
              <label>4.- Una nota de débito física por penalidad emitido por 785 cuya operación se encuentra inafecta del IGV. La factura relacionada es la de serie 0001 y número 1.</label>
              <label>5.- Un ticket con derecho a crédito fiscal por el importe de 3,568 el mismo que se encuentra gravado con IGV.</label>
              <label>6.- Un consolidado de tickets sin derecho a crédito fiscal por un total de 5,823 (4,745.76 se encuentra gravado y 256 exonerado del IGV)</label>
              <label>7.- Una factura física emitida por 350 dólares estadounidenses de los cuales se encuentran gravados con IGV (Tipo de cambio S/ 3.404)</label>
              <label>8.- Una Boleta de venta física por 328 sin identificación</label>
              <label>9.- Una factura por 300 emitidos en nuevos soles, la misma que se encuentra exonerada del IGV.</label>
              <label>10.- Una factura física por transferencia gratuita de bienes gravada con IGV.</label>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cerrar</button>
        </div>
      </div>
      
    </div>
</div>

<div class="modal fade" id="myModalx" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div  class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-info-sign"></span> Informaciòn Adicional </h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
         <div id="exito-datos"></div>
          <form role="form">
   

            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Cerrar</button>
        </div>
      </div>
      
    </div>
</div>


<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"> ></script>
    <script>
        $(document).ready(function(){
        $("[name='my-checkbox']").bootstrapSwitch();
       })
    </script>
<script src="../utilerias/js/bootstrap-switch.js" type="text/javascript"></script>

<script type="text/javascript" src="js/jquery.tabletojson.js"></script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="js/facturacion.js"></script>
<script type="text/javascript" src="js/base64.js"></script>
 


</body>
</html> 