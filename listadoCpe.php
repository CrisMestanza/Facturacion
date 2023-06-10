
<?php 
require 'header.php';
?>
    <div class="contenedor">
    </div>
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-body">
            <label style="display: none;" id="n-codigo" ></label>


            <table style="font-size:12px;" id="tb-hos" class="display responsive nowrap" width="100%" >
          <thead >
              <tr>
                  <th >Código</th>
                  <th style="text-align: left;">..... | EMA PDF XML CDR</th>                  
                  <th  style="text-align: center;">Comprobante</th>
                  <th style="text-align: center;">Fecha Emisión</th>
                  <th  style="text-align: center;">Documento </th>
                  <th  style="text-align: center;">Nombre ó Razón Social </th>
                  <th style="text-align: center;">Moneda</th>
                  <th style="text-align: center;">T.C.</th>
                  <th  style="text-align: center;">Pago</th>
                  <th  style="text-align: right;" >Total</th>
                  <th  style="text-align: center;">Estado CDR</th>
                  <th  style="text-align: center;">Estado Correo</th>
                  <th  style="text-align: center;">Estado CPE</th>
                  
              </tr>
          </thead>
          <tbody id="detalle-cab">
          </tbody>
        </table>

            </div>
        </div>
    </div>

    <?php 
    require 'modal-envio.php';
    require 'modal-envEmail.php';
    require 'modal-comBaja.php';
    require 'modal-Errores.php';
    require 'footer.php';

?>

    <script type="text/javascript" src="js/listadoCpe.js"></script>
    <script type="text/javascript" src="js/archivos.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="js/procesos.js"></script>
    <script type="text/javascript" src="js/anulacion.js"></script>
