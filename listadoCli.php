
<?php 
require 'header.php';
?>
    <div class="contenedor">
    </div>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-body">


            <table style="font-size:12px;" id="tb-hos" class="display responsive nowrap" width="100%" >
          <thead >
              <tr>
                  <th >Código</th>
                  <th style="text-align: left;">..... | PDF XML CDR</th>                  
                  <th  style="text-align: center;">Comprobante</th>
                  <th style="text-align: center;">Fecha Emisión</th>
                  <th  style="text-align: center;">Documento </th>
                  <th  style="text-align: center;">Nombre ó Razón Social </th>
                  <th style="text-align: center;">Moneda</th>
                  <th style="text-align: center;">T.C.</th>
                  <th  style="text-align: center;">Pago</th>
                  <th  style="text-align: right;" >Total</th>
                  
              </tr>
          </thead>
          <tbody id="detalle-cab">
          </tbody>
        </table>

            </div>
        </div>
    </div>

    <?php 
   require 'footer.php'

?>

    <script type="text/javascript" src="js/listadoCli.js"></script>
