<?php

function ImpresionTicket($Json_Emp,$Json_Fac){

require_once '../Repo/fpdf/fpdf.php'; //incluimos la librería FPDF
require_once '../Funciones/nletras.php';
/*
$data = file_get_contents("../Json/20601733022.json");
$Json_Emp = json_decode($data, JSON_UNESCAPED_UNICODE);

$data = file_get_contents("../Json/test.json");
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
$ArrayPrecioUnitario = array();
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
    $tipopago = $cabezera['tipPago'];
    $obs = $cabezera['obs'];
    $saltos = $cabezera['saltosLinea'];

    foreach ($cabezera['items'] as $detalle) {
        // echo $detalle["ctdUnidadItem"];
        $ArrayItem[] = $item;
        $ArrayTipoUnidad[] = $detalle['codUnidadMedida'];
        $ArrayDetalleBienServicio[] = utf8_decode($detalle['desItem']);
        $ArrayCodigoBienServicio[] = $detalle['codProducto'];
        $ArrayCantidad[] = $detalle['ctdUnidadItem'];
        $ArrayValorVenta[] = $detalle['mtoValorUnitario'];
        $ArrayPrecioVenta[] = $detalle['mtoPrecioVentaItem'];
        $ArrayPrecioUnitario[] = $detalle['mtoPrecioVentaItem'] / $detalle['ctdUnidadItem'];
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

if ($TipoMoneda == 'PEN') {
    $tipomon = 'S/';
} elseif ($TipoMoneda == 'USD') {
    $tipomon = '$.';
}

$documento_xml = $RucEmpresa . "-" . $TipoComprobante . "-" . $serieComp . "-" . $numeroComp;

$pdf = new FPDF($orientation = 'P', $unit = 'mm', array(80, 400), true, 'UTF-8', false); // creamos el documento, en este caso es de 45 (milímetros) de ancho y 100 (milímetros) de alto

$pdf->AddPage(); //empezamos agregando una pagina.

$pdf->SetFont('Arial', 'B', 8); //Letra Arial para el titulo, negrita (Bold), tam. 8
$textypos = 0; //definimos la variable “textypos” que sirve para la posición Y del texto, lo que sera la altura, la posición X siempre es la misma.
$pdf->setY(5); //asignamos la posicion Y inicial.
$pdf->setX(10); //asignamos la posición X inicial.
$pdf->Cell(0, $textypos, utf8_decode($ComercialEmpresa), 0, 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 5); //Letra Arial, negrita (Bold), tam. 20
$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(0, $textypos, utf8_decode($NameEmpresa), 0, 0, 'C', 0);

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(2.5);
$pdf->setX(10);
$pdf->Cell(0, $textypos, utf8_decode($DireccionEmpresa), 0, 0, 'C', 0);

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(2);
$pdf->setX(10);
$pdf->Cell(0, $textypos, utf8_decode($DepartamentoEmpresa . ' ' . $ProvinciaEmpresa . ' ' . $DistritoEmpresa), 0, 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 6);
$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "RUC: " . $RucEmpresa, 0, 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(3);
$pdf->setX(10);

$textoCpe;
if ($TipoComprobante == '01') {
    $pdf->Cell(0, $textypos, utf8_decode('FACTURA ELECTRÓNICA'), 0, 0, 'C', 0);
    $textoCpe = utf8_decode('FACTURA ELECTRÓNICA');
} elseif ($TipoComprobante == '03') {
    $pdf->Cell(0, $textypos, utf8_decode('BOLETA DE VENTA ELECTRÓNICA'), 0, 0, 'C', 0);
    $textoCpe = utf8_decode('BOLETA DE VENTA ELECTRÓNICA');
} elseif ($TipoComprobante == '07') {
    $pdf->Cell(0, $textypos, utf8_decode('NOTA DE CREDITO ELECTRÓNICA'), 0, 0, 'C', 0);
    $textoCpe = utf8_decode('NOTA DE CREDITO ELECTRÓNICA');
} elseif ($TipoComprobante == '08') {
    $pdf->Cell(0, $textypos, utf8_decode('NOTA DE DEBITO ELECTRÓNICA'), 0, 0, 'C', 0);
    $textoCpe = utf8_decode('NOTA DE DEBITO ELECTRÓNICA');
}

$pdf->SetFont('Arial', 'B', 7);
$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(0, $textypos, $serieComp . '-' . $numeroComp, 0, 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(4);
$pdf->setX(4);
$pdf->Cell(5, $textypos, "ADQUIRIENTE");

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(2);
$pdf->setX(4);

if ($TipoCliente == 6) {
    $pdf->Cell(5, $textypos, "RUC: " . $RucCliente);
} else if ($TipoCliente == 1) {
    $pdf->Cell(5, $textypos, "DNI: " . $RucCliente);
}

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(2);
$pdf->setX(4);
$pdf->Cell(5, $textypos, utf8_decode($NameCliente));

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(3);
$pdf->setX(4);
$pdf->Cell(5, $textypos, utf8_decode("DIRECCIÓN DEL CLIENTE: "));
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(0);
$pdf->setX(28);
$pdf->Cell(28, $textypos, utf8_decode($DireccionCliente));

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(2);
$pdf->setX(4);
$pdf->Cell(5, $textypos, utf8_decode($DepartamentoCliente . ' ' . $ProvinciaCliente . ' ' . $DistritoCliente));

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2.5);
$pdf->setX(4);
$pdf->Cell(5, $textypos, utf8_decode("FECHA DE EMISIÓN: "));
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(0);
$pdf->setX(22);
$pdf->Cell(5, $textypos, $FechaComprobante);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(4);
$pdf->Cell(5, $textypos, "FECHA DE VENC.: ");
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(0);
$pdf->setX(20);
$pdf->Cell(5, $textypos, $fechaVencimiento);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(4);
$pdf->Cell(5, $textypos, utf8_decode("CONDICIÓN: "));
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(0);
$pdf->setX(16);
if ($tipopago == "01") {
    $pdf->Cell(5, $textypos, "CONTADO");
} else {
    $pdf->Cell(5, $textypos, utf8_decode("CRÉDITO"));
}

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(4);
$pdf->Cell(5, $textypos, "MONEDA: ");
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(0);
$pdf->setX(13);
if ($TipoMoneda == "PEN") {
    $pdf->Cell(5, $textypos, "SOLES");
} else {
    $pdf->Cell(5, $textypos, "DOLARES");
}

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(4);
$pdf->Cell(5, $textypos, utf8_decode("OBSERVACIÓN: "));
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(0);
$pdf->setX(20);
$pdf->Cell(20, $textypos, $obs);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(3);
$pdf->setX(4);
$pdf->Cell(4, $textypos, '[CANT.]');

$pdf->SetFont('Arial', 'B', 5);
$pdf->setX(13);
$pdf->Cell(13, $textypos, 'U/M');

$pdf->SetFont('Arial', 'B', 5);
$pdf->setX(20);
$pdf->Cell(20, $textypos, 'CODIGO');

$pdf->SetFont('Arial', 'B', 5);
$pdf->setX(34);
$pdf->Cell(34, $textypos, 'DESCRIPCION');

$pdf->SetFont('Arial', 'B', 5);
$pdf->setX(65);
$pdf->Cell(65, $textypos, 'P/U.');

$pdf->Ln(0);

$pdf->setX(2);
$pdf->Cell(5, $textypos, '__________________________________________________________________________');

$pdf->Ln(3);
$saltosLinea = 0;
$conteo = 0;
$saltoqr=0;
$pdf->SetFont('Arial', '', 5);

for ($j = 0; $j < count($ArrayItem); $j++) {

    $cadena = 0;

    $pdf->setX(6);
    $pdf->Cell(6, 0, number_format($ArrayCantidad[$j], 2));
    $pdf->setX(12);
    $pdf->Cell(12, 0, utf8_decode($ArrayTipoUnidad[$j]));
    $pdf->setX(22);
    $pdf->Cell(22, 0, utf8_decode($ArrayCodigoBienServicio[$j]));

    $pdf->setX(37);
    $pdf->Cell(37, 0, $tipomon . " " . number_format($ArrayPrecioUnitario[$j], 2), 0, 0, "R");

    if ($saltos == 1) {
        //sALTOS DE LINEA
        $filaini = 0;
        $filafin = 30;
        $retroceso = 15;

        $cadena = utf8_decode($ArrayDetalleBienServicio[$j]);

        $filaresultado = $filafin;
        $contarTotal = strlen($cadena);
        $final = round($contarTotal / $filafin, 0) + 10;
//

        for ($i = 1; $i <= $final; $i++) {

            $resultado = substr($cadena, $filaini, $filafin);
            $posicion = strripos($resultado, " ");

            //PRIMERA LINEA
            if ($i == 1) {
                $vacio = substr($cadena, $filafin - $retroceso, $retroceso);
            } else {
                $vacio = substr($cadena, ($filaini + $filaresultado) - $retroceso, $retroceso);
            }

            $salto = strripos($vacio, " ");
            if ($salto > 0) {
                $detalle = substr($cadena, $filaini, $posicion);
                if ($detalle != "") {
                    $pdf->setX(29);
                    $pdf->Cell(29, 0, $detalle );
                    $filaini = $posicion + $filaini;
                    $pdf->Ln(2);
                    $saltosLinea = 1 + $saltosLinea;
                    //esto es para que el qr no pierda su trayectoria
                    if ($conteo == 5) {
                        $saltoqr = $saltoqr + 6;
                        $conteo =0;
                    }else{
						$conteo = $conteo+1;
					}

                }
            } else {
                $detalle = substr($cadena, $filaini, $filafin);
                if ($detalle != "") {

                    $pdf->setX(29);
                    $pdf->Cell(29, 0, $detalle );
                    $filaini = $filafin + $filaini;
                    $pdf->Ln(2);
                    $saltosLinea = 1 + $saltosLinea;

                    //esto es para que el qr no pierda su trayectoria
                    if ($conteo == 5) {
                        $saltoqr = $saltoqr + 6;
                        $conteo =0;
                    }else{
						$conteo = $conteo+1;
					}


                }

            }

        }
//fin saltos linea
    } else {
        $pdf->setX(29);
        $pdf->Cell(29, 0, utf8_decode(substr($ArrayDetalleBienServicio[$j], 0, 30)));
        $pdf->Ln(2);

    }

}

$pdf->Ln(0);
$pdf->setX(2);
$pdf->Cell(5, $textypos, '__________________________________________________________________________');

if (number_format($OperacionesGravadas, 2) > 0) {
    $pdf->SetFont('Arial', 'B', 5);
    $textypos += 6;
    $pdf->setX(46);
    $pdf->Cell(46, $textypos, "GRAVADA " . $tipomon . " ");
    $pdf->SetFont('Arial', '', 5);
    $pdf->setX(37);
    $pdf->Cell(37, $textypos, number_format($OperacionesGravadas, 2, ".", ","), 0, 0, "R");
}

if (number_format($OperacionesExoneradas, 2) > 0) {
    $pdf->SetFont('Arial', 'B', 5);
    $textypos += 6;
    $pdf->setX(46);
    $pdf->Cell(46, $textypos, "EXONERADA " . $tipomon . " ");
    $pdf->SetFont('Arial', '', 5);
    $pdf->setX(37);
    $pdf->Cell(37, $textypos, number_format($OperacionesExoneradas, 2, ".", ","), 0, 0, "R");
}

if (number_format($OperacionesInafectas, 2) > 0) {
    $pdf->SetFont('Arial', 'B', 5);
    $textypos += 6;
    $pdf->setX(46);
    $pdf->Cell(46, $textypos, "INAFECTA " . $tipomon . " ");
    $pdf->SetFont('Arial', '', 5);
    $pdf->setX(37);
    $pdf->Cell(37, $textypos, number_format($OperacionesInafectas, 2, ".", ","), 0, 0, "R");
}

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(46);
$pdf->Cell(46, $textypos, "IGV " . $tipomon . " ");
$pdf->SetFont('Arial', '', 5);
$pdf->setX(37);
$pdf->Cell(37, $textypos, number_format($SumatoriaIgv, 2, ".", ","), 0, 0, "R");

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(46);
$pdf->Cell(46, $textypos, "TOTAL " . $tipomon . " ");
$pdf->SetFont('Arial', '', 5);
$pdf->setX(37);
$pdf->Cell(37, $textypos, number_format($ImporteTotal, 2, ".", ","), 0, 0, "R");

$pdf->Ln(2);
$pdf->setX(2);
$pdf->Cell(5, $textypos, '__________________________________________________________________________');

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "IMPORTE EN LETRAS", 0, 0, 'C', 0);

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(2);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "SON: " . MontoMonetarioEnLetras($ImporteTotalVta, $TipoMoneda), 0, 0, 'C', 0);
$pdf->Ln(2);
$pdf->setX(2);
$pdf->Cell(5, $textypos, '__________________________________________________________________________');
$pdf->SetFont('Arial', '', 5);
$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "Representacion impresa de la " . $textoCpe, 0, 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "www.exceservicios.com/consultacpe", 0, 0, 'C', 0);

$pdf->SetFont('Arial', '', 5);
$pdf->Ln(3);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "Autorizado mediante Resolucion de Intendencia", 0, 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 5);
$pdf->Ln(2);
$pdf->setX(10);
$pdf->Cell(0, $textypos, "Nro. 034-005-0005315", 0, 0, 'C', 0);

//Codigo HASH
if (file_exists('../Xml/xml-firmados/' . $documento_xml . '.xml')) {
    $xml = base64_encode(file_get_contents('../Xml/xml-firmados/' . $documento_xml . '.xml'));

    $xmlHash = simplexml_load_file('../Xml/xml-firmados/' . $documento_xml . '.xml');
    /*Código Hash*/
    foreach ($xmlHash->xpath('ext:UBLExtensions//ext:UBLExtension//ext:ExtensionContent//ds:Signature//ds:DigestValue') as $hash) {}
    ;
} else { $hash = "Sin Firma";
}

$pdf->Ln(2);
$pdf->SetFont('Arial', '', 5);
$pdf->setX(10);
$pdf->Cell(0, $textypos, $hash, 0, 0, 'C', 0);



$textypos = ($saltosLinea + 85 + $saltoqr);

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
$pdf->Image($filename, '25', $textypos, '30', '30', 'PNG');



$pdf->Output('../Repo/cpe/'.$documento_xml.'.pdf', 'F');
    
}