<?php 

$ruta_cdr='../Cdr/';
$ruta_zip='../Xml/xml-firmados/';
$Nombre_Archivo='20601733022-07-F111-00000002';
//require_once('../ws/lib/nusoap.php');
 require("Soap.php");
# construyo un cliente nusoap_client
//$client = new nusoap_client('https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl', 'wsdl');
 
 
# el servicio se llama recibir_contenido
# y recibe dos variables/parametros
# nombre_arhivo como quiero que se llame en el server.
# el string en base64
 

 


 //Estructura del XML para la conexión
$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
 <soapenv:Header>
     <wsse:Security>
         <wsse:UsernameToken Id="ABC-123">
             <wsse:Username>20601733022DSIG1989</wsse:Username>
             <wsse:Password>blas1984</wsse:Password>
         </wsse:UsernameToken>
     </wsse:Security>
 </soapenv:Header>
 <soapenv:Body>
     <ser:sendBill>
        <fileName>'.$Nombre_Archivo.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($ruta_zip.$Nombre_Archivo.'.zip')) . '</contentFile>
     </ser:sendBill>
 </soapenv:Body>
</soapenv:Envelope>';



//$wsdlURL = "https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl";
//$wsdlURL = "https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl";
$wsdlURL = "SunatProd.wsdl";

 /*    
sunat_status.php
$Client = new nusoap_client($wsdl, true);


$params = array('wsdl:service name' => 'billService');
$response =$Client->call('sendBill', $params);

if ($Client->getError())
{
    echo "<br/><br/>Error al llamar el metodo<br/> ".$oSoapClient->getError();
}
else
{

}  */

function soapCall($wsdlURL, $callFunction = "", $XMLString)
{
    $client = new feedSoap($wsdlURL, array('trace' => true));
    //$client=new Soaplient('');

    $reply  = $client->SoapClientCall($XMLString);

    //echo "REQUEST:\n" . $client->__getFunctions() . "\n";
    $client->__call("$callFunction", array(), array());



    //$request = prettyXml($client->__getLastRequest());
    //echo highlight_string($request, true) . "<br/>\n";
    return $client->__getLastResponse();
}

$result = soapCall($wsdlURL, $callFunction = "sendBill", $XMLString);

//Descargamos el Archivo Response
$archivo = fopen('C'.$Nombre_Archivo.'.xml','w+');
fputs($archivo,$result);
fclose($archivo);


/*LEEMOS EL ARCHIVO XML*/
$xml = simplexml_load_file('C'.$Nombre_Archivo.'.xml'); 
foreach ($xml->xpath('//applicationResponse') as $response){ }

/*AQUI DESCARGAMOS EL ARCHIVO CDR(CONSTANCIA DE RECEPCIÓN)*/
$cdr=base64_decode($response);

$archivo = fopen('R'.$Nombre_Archivo.'.zip','w+');
fputs($archivo,$cdr);
fclose($archivo);

$enlace = 'R'.$Nombre_Archivo.'.zip';
header ("Content-Disposition: attachment; filename=$enlace ");
header ("Content-Type: application/force-download");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);

/*Eliminamos el Archivo Response*/
unlink('C'.$Nombre_Archivo.'.xml');
?>