<?php
require_once '../conexion.php';
$mysqli = conectar();

$data = file_get_contents("../../dsig/Json/20601733022-01-FF01-00000007.json");
$Json_Fac = json_decode("[" . $data . "]", JSON_UNESCAPED_UNICODE);
        /*LECTURA DEL ARCHIVO JSON*/
        /*-------------------------*/
        $ArrayId = array();
        $ArrayItem = array();
        $ArrayTipoUnidad = array();
        $ArrayDetalleBienServicio = array();
        $ArrayCodigoBienServicio = array();
        $ArrayCantidad = array();
        $ArrayValorVenta = array();
        $ArrayPrecioUnitario = array();
        $ArrayPrecioVenta = array();
        $ArrayTipoPrecioVenta = array();
        $ArrayIndicadorDscto = array();
        $ArrayDescuento = array();
        $ArrayAfectacionIgv = array();
        $ArrayIgv = array();
        $ArrayCat05 = array();
        $ArrayName05 = array();
        $ArrayTaxTypeCode05 = array();
        $ArrayCategoryCode05 = array();
        $ArrayValorTotal = array();
        $ArrayPorcentaje = array();

        //--------Sumatorias------//
        $TotalValorVta = 0;
        $TotalPrecioVta = 0;
        $TotalDescuentos = 0;
        $TotalOtrosCargos = 0;
        $TotalAnticipos = 0;
        $ImporteTotalVta = 0;

        $item = 1;
        $igv = 0;

        foreach ($Json_Fac as $cabezera) {

            $TipoOperacion = $cabezera['tipOperacion'];
            $FechaComprobante = $cabezera['fecEmision'];
            $FechaVencimiento = $cabezera['fecVencimiento'];
            $TipoComprobante = $cabezera['tipComp'];
            $serieComp = $cabezera['serieComp'];
            $numeroComp = $cabezera['numeroComp'];
            $NumComprobante = $serieComp . "-" . $numeroComp;
            $DomicilioFiscalEmisor = $cabezera['codLocalEmisor'];
            $TipoCliente = $cabezera['tipDocUsuario'];
            $codCliente = $cabezera['codCliente'];
            $RucCliente = $cabezera['numDocUsuario'];
            $NameCliente = $cabezera['rznSocialUsuario'];
            $TipoMoneda = $cabezera['tipMoneda'];
            $TipoCambio = $cabezera['tipCambio'];
            $Descuentosglobales = $cabezera['DsctoGlobal'];
            $SumatoriaOtrosCargos = $cabezera['otrosCargos'];
            $OperacionesGravadas = $cabezera['Gravada'];
            $OperacionesInafectas = $cabezera['Inafecta'];
            $OperacionesExoneradas = $cabezera['Exonerada'];
            $OperacionesBase = $OperacionesGravadas + $OperacionesInafectas + $OperacionesExoneradas;
            $OperacionesGratuitas = $cabezera['Gratuita'];
            $OperacionesAnticipo = $cabezera['Anticipo'];
            $SumatoriaIgv = $cabezera['mtoIgv'];
            $ImporteTotal = $cabezera['mtoTotal'];

            $codefechavence = "-";
            $UbigeoCliente = $cabezera['codUbigeoCliente'];
            $DepartamentoCliente = $cabezera['deptCliente'];
            $ProvinciaCliente = $cabezera['provCliente'];
            $DistritoCliente = $cabezera['distCliente'];
            $PaisCliente = $cabezera['codPaisCliente'];
            $DireccionCliente = $cabezera['desDireccionCliente'];
            $cdr = $cabezera['envioSunat'];
            $UrbanizacionCliente = '-';

            //Nota de Credito o debito
            $Cat09 = $cabezera['Cat09'];
            $Cat10 = $cabezera['Cat10'];
            $docRef = $cabezera['docRef'];

            //DatosAdicionales//
            $CodDir = $cabezera['CodDir'];
            $tipoPago = $cabezera['tipPago'];
            $idserie = $cabezera['idserie'];
            $numdias = $cabezera['numdias'];
            $accion = $cabezera['accion'];
            $dirEmp = $cabezera['dirEmp'];            
            $RucEmpresa = $cabezera['rucEmp'];

            foreach ($cabezera['items'] as $detalle) {
                $ArrayId[] = $detalle['CodItem'];
                $ArrayItem[] = $item;
                $ArrayTipoUnidad[] = $detalle['codUnidadMedida'];
                $ArrayDetalleBienServicio[] = utf8_decode($detalle['desItem']);
                $ArrayCodigoBienServicio[] = $detalle['codProducto'];
                $ArrayCantidad[] = $detalle['ctdUnidadItem'];
                $ArrayValorVenta[] = $detalle['mtoValorUnitario'];
                $ArrayPrecioVenta[] = $detalle['mtoPrecioVentaItem'];

                $ArrayTipoPrecioVenta[] = $detalle['tipPrecio']; /*Catalogo N°16*/
                $ArrayIndicadorDscto[] = 'false';
                $ArrayDescuento[] = $detalle['mtoDsctoItem']; /*DEscuento por Item*/
                $ArrayIgv[] = $detalle['mtoIgvItem']; /*Igv por Item*/

                $ArrayAfectacionIgv[] = $detalle['tipAfeIGV']; /*Catalogo N° 07*/

                if ($detalle['tipAfeIGV'] == '10') {
                    $tributocat5 = '1000';
                } else if ($detalle['tipAfeIGV'] == '11' || $detalle['tipAfeIGV'] == '12' || $detalle['tipAfeIGV'] == '13' || $detalle['tipAfeIGV'] == '14' || $detalle['tipAfeIGV'] == '15' || $detalle['tipAfeIGV'] == '16' || $detalle['tipAfeIGV'] == '17') {
                    $tributocat5 = '9996';
                } else if ($detalle['tipAfeIGV'] == '20') {
                    $tributocat5 = '9997';
                } else if ($detalle['tipAfeIGV'] == '21') {
                    $tributocat5 = '9996';
                } else if ($detalle['tipAfeIGV'] == '30') {
                    $tributocat5 = '9998';
                } else if ($detalle['tipAfeIGV'] == '31' || $detalle['tipAfeIGV'] == '32' || $detalle['tipAfeIGV'] == '33' || $detalle['tipAfeIGV'] == '34' || $detalle['tipAfeIGV'] == '35' || $detalle['tipAfeIGV'] == '36') {
                    $tributocat5 = '9996';
                } else if ($detalle['tipAfeIGV'] == '40') {
                    $tributocat5 = '9995';
                }

                if ($tributocat5 == '1000') {
                    $ArrayCat05[] = '1000';
                    $ArrayName05[] = 'IGV'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'VAT'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'S';

                } else if ($tributocat5 == '9995') {
                    $ArrayCat05[] = '9995';
                    $ArrayName05[] = 'EXP'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'FRE';
                    $ArrayCategoryCode05[] = 'G';
                } else if ($tributocat5 == '9996') {
                    $ArrayCat05[] = '9996';
                    $ArrayName05[] = 'GRAT'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'FRE'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'Z';
                } else if ($tributocat5 == '9997') {
                    $ArrayCat05[] = '9997';
                    $ArrayName05[] = 'EXO'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'VAT'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'E';
                } else if ($tributocat5 == '9998') {
                    $ArrayCat05[] = '9998';
                    $ArrayName05[] = 'INA'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'FRE'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'O';
                }

                $ArrayValorTotal[] = $detalle['mtoValorVentaItem'];
                $ArrayPrecioUnitario[] = $detalle['mtoPrecioVentaItem'] / $detalle['ctdUnidadItem']; //precio unitario
                $ArrayPorcentaje[] = $detalle['porcentajeIgv'];

                $TotalValorVta = $TotalValorVta + $detalle['mtoValorVentaItem'];
                $igv = $igv + $detalle['mtoIgvItem'];
                $TotalPrecioVta = $TotalPrecioVta + $detalle['mtoPrecioVentaItem'];

                $ImporteTotalVta = $ImporteTotalVta + $detalle['mtoPrecioVentaItem'];
                $item = $item + 1;

            }

        }
        
        if ($FechaVencimiento==''){
            $FechaVencimiento="0000-00-00";
        }
        echo $send_sunat;
 
   echo "qq";
            $llave = $RucEmpresa . '-' . $TipoComprobante . '-' . $serieComp . '-' . $numeroComp;

            if ($accion == true) {
                $sqlD = "DELETE FROM resumen WHERE llave='$llave'";
                $this->conexion->conexion->query($sqlD);
            }

            $hora = strftime("%Y-%m-%d-%H-%M-%S", time());
            //Registramos la Cabezera
            $sql = "INSERT INTO resumen VALUES(0,'$llave','$FechaComprobante','$FechaVencimiento','$hora','$codCliente','$CodDir',
            '$TipoMoneda','$TipoCambio','$tipoPago','$OperacionesExoneradas','$OperacionesInafectas','$OperacionesGravadas',
            '$OperacionesAnticipo','$SumatoriaIgv','$OperacionesGratuitas','$SumatoriaOtrosCargos','0',
            '$Descuentosglobales','$ImporteTotal','$cdr',0,'$docRef','$Cat09','$Cat10','$idserie','$numdias','$RucEmpresa',0,0,'')";
            
 
 echo $sql;

        
if ($mysqli->query($sql)=== TRUE){
    echo "Registro guardado con exito";
}else{
    echo "Error: " . $sql . "<br>". $mysqli->error;
}
       
