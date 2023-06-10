<?php
require_once "../Repo/rpt-factura.php";
require_once "../Repo/ticket.php";
function RespuestaServidor($Json_Emp, $Json_Fac, $Tipo, $MensajeBD)
{

    foreach ($Json_Emp as $cpe) {$ruc_Emisor = $cpe['rucEmisor'];}

    if ( $Tipo == "Anulados") {
        foreach ($Json_Fac as $cabezera) {
            $TipoComprobante = $cabezera['tipDocBaja'];
            $SerieComp = $cabezera['serDocBaja'];
            $NumeroComp = $cabezera['numDocBaja'];
            $FechaReferencia = $cabezera['fecGeneracion'];
            $lote = $cabezera['numLote'];
            $fecharesultado = substr($FechaReferencia, 0, 4) . substr($FechaReferencia, 5, 2) . substr($FechaReferencia, 8, 2);
        }

        $documento_xml = $ruc_Emisor . '-RA-' . $fecharesultado . '-' . $lote;

        if (file_exists('../Xml/xml-firmados/' . $documento_xml . '.xml')) {
            $xml = base64_encode(file_get_contents('../Xml/xml-firmados/' . $documento_xml . '.xml'));

        } else {
            $xml = base64_encode("Error no se firmo el Comprobante Electrónico");
        }

        if (file_exists('../Ticket/' . $documento_xml . '.xml')) {
            $xmlrpta = base64_encode(file_get_contents('../Xml/xml-firmados/' . $documento_xml . '.xml'));

        } else {
            $xmlrpta = base64_encode("Error no se encontro respuesta de Sunat");
        }

        $lista[] = array('TipoComprobante' => $TipoComprobante,
            'SerieComprobante' => $SerieComp,
            'NumeroComprobante' => $NumeroComp,
            'Ticket' => $MensajeBD,
            'xmlRpta_Base64' => $xmlrpta,
            'Xml_Base64' => $xml,
            'TipoEnvio' => $Tipo
        );

        $json_string = json_encode($lista, JSON_UNESCAPED_UNICODE);
        
    } else  {

        foreach ($Json_Fac as $cpe) {
            $TipoComprobante = $cpe['tipComp'];
            $serieComp = $cpe['serieComp'];
            $numeroComp = $cpe['numeroComp'];
            $impresion = $cpe["impresion"];
        }

        $documento_xml = $ruc_Emisor . "-" . $TipoComprobante . "-" . $serieComp . "-" . $numeroComp;

        if (file_exists('../Xml/xml-firmados/' . $documento_xml . '.xml')) {
            $xml = base64_encode(file_get_contents('../Xml/xml-firmados/' . $documento_xml . '.xml'));

            $xmlHash = simplexml_load_file('../Xml/xml-firmados/' . $documento_xml . '.xml');

            /*Código Hash*/
            foreach ($xmlHash->xpath('ext:UBLExtensions//ext:UBLExtension//ext:ExtensionContent//ds:SignatureValue') as $hash) {}
            ;

            //PDF
            if ($impresion == "A4") {
                ConversionPdf($Json_Emp, $Json_Fac);
            } else if ($impresion == "Ticket") {
                ImpresionTicket($Json_Emp, $Json_Fac);
            }

        } else {
            $xml = base64_encode("Error no se firmo el Comprobante Electrónico");
        }

        if (file_exists('../Cdr/R-' . $documento_xml . '.xml')) {
            $cdr = base64_encode(file_get_contents('../Cdr/R-' . $documento_xml . '.xml'));
        } else {
            $cdr = base64_encode("No se encuentra la Constancia Sunat del Comprobante Electrónico");
        }

        if (file_exists('../Repo/cpe/' . $documento_xml . '.pdf')) {
            $pdf = base64_encode(file_get_contents('../Repo/cpe/' . $documento_xml . '.pdf'));
        } else {
            $pdf = base64_encode("No se encuentra la Representación Impresa del Comprobante Electrónico");
        }

        //Creamos el Json Respuesta:
        $lista[] = array('TipoComprobante' => $TipoComprobante,
            'SerieComprobante' => $serieComp,
            'NumeroComprobante' => $numeroComp,
            'Observaciones' => '',
            'BaseDatos' => $MensajeBD,
            'Aceptada_Sunat' => '',
            'Pdf_Base64' => $pdf,
            'Xml_Base64' => $xml,
            'Cdr_Base64' => $cdr,
            'Codigo_Hash' => $hash,
            'TipoEnvio' => $Tipo,
        );

        $json_string = json_encode($lista, JSON_UNESCAPED_UNICODE);

    }

    return $json_string;

}
