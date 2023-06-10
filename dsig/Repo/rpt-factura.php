<?php
require_once '../Repo/fpdf/fpdf.php';
require_once '../Funciones/nletras.php';

function ConversionPdf($Json_Emp,$Json_Fac){

$conteo = 0;
/*
$data = file_get_contents("../Json/20601733022.json");
$Json_Emp = json_decode($data, JSON_UNESCAPED_UNICODE);

$data = file_get_contents("../Json/20601733022-01-F001-00000124.json");
$Json_Fac = json_decode("[" . $data . "]", JSON_UNESCAPED_UNICODE);
*/

/*Información de la Empresa*/
foreach ($Json_Emp as $cabezera) {
    $RucEmpresa = $cabezera['rucEmisor'];
    $NameEmpresa = $cabezera['razEmisor'];
    $DireccionEmpresa = $cabezera['direccionEmisor'];
    $PaisEmpresa = $cabezera['paisEmisor'];
    $UbigeoEmpresa = $cabezera['ubigeoEmisor'];
    $DepartamentoEmpresa = $cabezera['depEmisor'];
    $ProvinciaEmpresa = $cabezera['provEmisor'];
    $DistritoEmpresa = $cabezera['distEmisor'];
    $ComercialEmpresa = $cabezera['comercialEmisor'];
    $TipoEmpresa = "6";
    $UrbanizacionEmpresa = $cabezera['urbEmisor'];
    $LocalEmpresa = '0001';
}

/*LECTURA DEL ARCHIVO JSON*/
/*-------------------------*/
$ArrayItem = array();
$ArrayTipoUnidad = array();
$ArrayDetalleBienServicio = array();
$ArrayCodigoBienServicio = array();
$ArrayCantidad = array();
$ArrayValorVenta = array();
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
    $fechaVencimiento = $cabezera['fecVencimiento'];
    $TipoComprobante = $cabezera['tipComp'];
    $serieComp = $cabezera['serieComp'];
    $numeroComp = $cabezera['numeroComp'];
    $NumComprobante = $serieComp . "-" . $numeroComp;
    $DomicilioFiscalEmisor = $cabezera['codLocalEmisor'];
    $TipoCliente = $cabezera['tipDocUsuario'];
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
    $UrbanizacionCliente = '-';

    foreach ($cabezera['items'] as $detalle) {
        // echo $detalle["ctdUnidadItem"];
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
        } else if ($detalle['tipAfeIGV'] == '10' || $detalle['tipAfeIGV'] == '11' || $detalle['tipAfeIGV'] == '12' || $detalle['tipAfeIGV'] == '13' || $detalle['tipAfeIGV'] == '14' || $detalle['tipAfeIGV'] == '15' || $detalle['tipAfeIGV'] == '16' || $detalle['tipAfeIGV'] == '17') {
            $tributocat5 = '9996';
        } else if ($detalle['tipAfeIGV'] == '20') {
            $tributocat5 = '9997';
        } else if ($detalle['tipAfeIGV'] == '21') {
            $tributocat5 = '9996';
        } else if ($detalle['tipAfeIGV'] == '30') {
            $tributocat5 = '9998';
        } else if ($detalle['tipAfeIGV'] == '32' || $detalle['tipAfeIGV'] == '33' || $detalle['tipAfeIGV'] == '34' || $detalle['tipAfeIGV'] == '35' || $detalle['tipAfeIGV'] == '36') {
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
        $ArrayPorcentaje[] = $detalle['porcentajeIgv'];

        $TotalValorVta = $TotalValorVta + $detalle['mtoValorVentaItem'];
        $igv = $igv + $detalle['mtoIgvItem'];
        $TotalPrecioVta = $TotalPrecioVta + $detalle['mtoPrecioVentaItem'];

        $ImporteTotalVta = $ImporteTotalVta + $detalle['mtoPrecioVentaItem'];
        $item = $item + 1;
    }

}

$documento_xml = $RucEmpresa . "-" . $TipoComprobante . "-" . $serieComp . "-" . $numeroComp;
//------ Importes Detalle ---------//
$TotalesIGV = number_format($igv, 2);
$CodigoCat15 = "1000";
$DetalleCat15 = "SON: MILS SOLES 00/100";

$pdf = new FPDF();
$pdf->AddPage();

require_once '../Funciones/varios.php';
//************* Cabezera de la Representación Impresa *****************//
$pdf->Image('../Repo/img/factura1.jpg', '0', '5', '210', '300', 'JPG');
// $pdf->Image('../Repo/img/logo1.jpg','2','1','130','45','JPG');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 22);
$pdf->Cell(135);
$pdf->Cell(0, 0, utf8_decode($RucEmpresa), 0, 0, 'L', 0);

$pdf->Ln(22);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(137);
$pdf->Cell(0, 0, $serieComp . '-' . NumeroCeros($numeroComp), 0, 0, 'L', 0);

$pdf->Ln(10.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10);
$pdf->Cell(0, 0, utf8_decode($NameCliente), 0, 0, 'L', 0);

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10);
$pdf->Cell(0, 0, utf8_decode($DireccionCliente) . ' - ' . utf8_decode($DepartamentoCliente) . ' - ' . utf8_decode($ProvinciaCliente) . ' - ' . utf8_decode($DistritoCliente), 0, 0, 'L', 0);

$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10);
$pdf->Cell(0, 0, $RucCliente, 0, 0, 'L', 0);

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60);
$pdf->Cell(0, 0, fechaconvertir($FechaComprobante), 0, 0, 'L', 0);

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(93);
$pdf->Cell(0, 0, utf8_decode($TipoMoneda), 0, 0, 'L', 0);

$pdf->Ln(0);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(120);
$pdf->Cell(0, 0, utf8_decode("CONTADO"), 0, 0, 'L', 0);

if ($fechaVencimiento == !'') {
    $pdf->Ln(0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(175);
    $pdf->Cell(0, 0, fechaconvertir($fechaVencimiento), 0, 0, 'L', 0);
}

$pdf->Ln(15.5);

if ($TipoMoneda == 'PEN') {
    $tipomon = 'S/';
} elseif ($TipoMoneda == 'USD') {
    $tipomon = '$.';
}

$saltosLinea = 0;
$lineas =0;
//************** DETALLE DE LA FACTURA ELECTRÓNICA ******************* //
for ($j = 0; $j < count($ArrayItem); $j++) {
    $saltosPdf = 0;
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(-3);
    $pdf->Cell(6, 0, utf8_decode($ArrayTipoUnidad[$j]), 0, 0, 'L', 0);


    $pdf->Ln(0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(151, 0, number_format($ArrayCantidad[$j], 2), 0, 0, 'R', 0);

    $pdf->Ln(0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(170, 0, number_format($ArrayPrecioVenta[$j] / $ArrayCantidad[$j], 2), 0, 0, 'R', 0);

    $pdf->Ln(0);
    $pdf->SetFont('Arial', '', 8);
    //$pdf->Cell(195);
    $pdf->Cell(192, 0, number_format($ArrayPrecioVenta[$j], 2), 0, 0, 'R', 0);


    $pdf->Ln(0);
    $pdf->SetFont('Arial', '', 8);
    $cadena = utf8_decode($ArrayDetalleBienServicio[$j]);



    //sALTOS DE LINEA

    $filaini = 0;
    $filafin = 50;
    $retroceso = 15;

    $filaresultado = $filafin;
    $contarTotal = strlen($cadena);
    $final = round($contarTotal / $filafin, 0) + 10;
    //

    for ($i = 1; $i <= $final; $i++) {

        $resultado = substr($cadena, $filaini, $filafin);
        $posicion = strripos($resultado, " ");

        if ($i == 1) {
            $vacio = substr($cadena, $filafin - $retroceso, $retroceso);
        } else {
            $vacio = substr($cadena, ($filaini + $filaresultado) - $retroceso, $retroceso);
        }

        $salto = strripos($vacio, " ") . "</br>";
        if ($salto > 0) {
            $detalle = substr($cadena, $filaini, $posicion);
            if ($detalle != "") {
                $pdf->Cell(8);
                $pdf->Cell(0, 0, $detalle, 0, 0, 'L', 0);
                $filaini = $posicion + $filaini;
                $pdf->Ln(4);
                $saltosLinea = 4 + $saltosLinea;
                $saltosPdf = 4 + $saltosLinea;
            }
        } else {
            $detalle = substr($cadena, $filaini, $filafin);
            if ($detalle != "") {
                $pdf->Cell(8);
                $pdf->Cell(0, 0, $detalle, 0, 0, 'L', 0);
                $filaini = $filafin + $filaini;
                $pdf->Ln(4);
                $saltosLinea = 4 + $saltosLinea;
                $saltosPdf = 4 + $saltosLinea;
            }

        }

    }
    //fin salos lines
    $pdf->Ln(0);
    $pdf->Ln(-$saltosPdf + 4);
    $pdf->Ln($saltosLinea);
    $conteo = $conteo + $saltosLinea;

    if($j>1){
      $m=$j;
      $lineas=$lineas+(8*$m);
    } else if($j==1){
      $lineas=8;
   } else if($j==0){
      $lineas=0;
    }

}

$TotalFila =  (165+$lineas - $conteo);

//Numero en Letras
$pdf->Ln($TotalFila);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(-5);
$pdf->Cell(0, 0, 'SON: ' . MontoMonetarioEnLetras($ImporteTotalVta, $TipoMoneda), 0, 0, 'L', 0);

$PosIm = "192";

//otros cargos
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format(0, 2), 0, 0, 'R', 0);

//descuento Global
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format(0, 2), 0, 0, 'R', 0);

//operacion gratuita
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format(0, 2), 0, 0, 'R', 0);

//operacion gravada
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format($OperacionesGravadas, 2), 0, 0, 'R', 0);

//operacion exonerada
$pdf->Ln(4.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format($OperacionesExoneradas, 2), 0, 0, 'R', 0);

//operacion inafecta
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format($OperacionesInafectas, 2), 0, 0, 'R', 0);

//igv
$pdf->Ln(3.7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format($TotalesIGV, 2), 0, 0, 'R', 0);

//importe Total
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($PosIm - 15, 0, $tipomon, 0, 0, 'R', 0);
$pdf->Ln(0);
$pdf->Cell($PosIm, 0, number_format($ImporteTotalVta, 2), 0, 0, 'R', 0);

//Codigo HASH
if (file_exists('../Xml/xml-firmados/' . $documento_xml . '.xml')) {
    $xml = base64_encode(file_get_contents('../Xml/xml-firmados/' . $documento_xml . '.xml'));

    $xmlHash = simplexml_load_file('../Xml/xml-firmados/' . $documento_xml . '.xml');
    /*Código Hash*/
    foreach ($xmlHash->xpath('ext:UBLExtensions//ext:UBLExtension//ext:ExtensionContent//ds:Signature//ds:DigestValue') as $hash) {}
    ;
} else { $hash = "Sin Firma";
}

$pdf->Ln(-22);


/*Información del Comprobante*/
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(162, 0, utf8_decode("Representación Impresa de la Factura Electrónica "), 0, 0, 'C', 0);

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(162, 0, utf8_decode("Autorizado mediante resolución N° 0540050001122 "), 0, 0, 'C', 0);

$pdf->Ln(2.5);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(162, 0, utf8_decode("Consulta del Comprobante Electrónico: https://excelservicios.com/consultacpe/"), 0, 0, 'C', 0);

$pdf->Ln(2.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(162, 0, $hash, 0, 0, 'C', 0);

require "../Repo/phpqrcode/qrlib.php";
$dir = 'temp/';
if (!file_exists($dir)) {
    mkdir($dir);
}

$filename = $dir . 'test.png';
$tamaño = 10;
$level = 'L';
$framSize = 2;
$contenido = $RucEmpresa . '|' . $TipoComprobante . '|' . $serieComp . '|' . $numeroComp . '|' . $igv . '|' . $ImporteTotalVta . '|' . $FechaComprobante . '|' . $TipoCliente . '|' . $hash;

QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
$pdf->Image($filename, '4', '245', '35', '35', 'PNG');

$pdf->Output('../Repo/cpe/'.$documento_xml.'.pdf', 'F');
//$pdf->output();

}
