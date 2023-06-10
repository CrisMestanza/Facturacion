<?php
//error_reporting(E_ALL);

/*AQUI COLOCAMOS EL NOMBRE DEL ARCHIVO GENERADO LO RECOGEMOS POR POST*/
$rucemisor='20601733022';
$tipoComp='01';
$serieComp='F111';
$numeroComp='24';

//Procedimiento para enviar comprobante a la SUNAT
class feedSoap extends SoapClient
{

    public $XMLStr = "";

    public function setXMLStr($value)
    {
        $this->XMLStr = $value;
    }

    public function getXMLStr()
    {
        return $this->XMLStr;
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $request = $this->XMLStr;

        $dom = new DOMDocument('1.0');

        try
        {
            $dom->loadXML($request);
        } catch (DOMException $e) {
            die($e->code);
        }

        $request = $dom->saveXML();

        //Solicitud
        return parent::__doRequest($request, $location, $action, $version, $one_way = 0);
    }

    public function SoapClientCall($SOAPXML)
    {
        return $this->setXMLStr($SOAPXML);
    }
}

function soapCall($wsdlURL, $callFunction = "", $XMLString)
{
    $client = new feedSoap($wsdlURL, array('trace' => true));
    $reply  = $client->SoapClientCall($XMLString);
    $client->__call("$callFunction", array(), array());
    return $client->__getLastResponse();
}

//Estructura del XML para la conexión
$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
 <soapenv:Header>
     <wsse:Security>
         <wsse:UsernameToken Id="ABC-123">
             <wsse:Username>20601733022MILI1989</wsse:Username>
             <wsse:Password>olookeria</wsse:Password>
         </wsse:UsernameToken>
     </wsse:Security>
 </soapenv:Header>

 <soapenv:Body>
       <ser:getStatus>   
            <rucComprobante>'.$rucemisor.'</rucComprobante>   
            <tipoComprobante>'.$tipoComp.'</tipoComprobante>    
            <serieComprobante>'.$serieComp.'</serieComprobante>    
            <numeroComprobante>'.$numeroComp.'</numeroComprobante>  
        </ser:getStatus> 

 </soapenv:Body>
</soapenv:Envelope>';

//URL para enviar las solicitudes a SUNAT
//$wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
$wsdlURL ='https://www.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl';
//Realizamos la llamada a nuestra función
$result = soapCall($wsdlURL, $callFunction = "getStatus", $XMLString);

//Respuesta Rapida del Estado del CDR
echo $result;