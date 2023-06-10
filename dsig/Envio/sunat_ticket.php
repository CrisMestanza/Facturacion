<?php
class enviocpeticket{
function EnviarTicket($Json_Fac,$Json_Emp)
{
  require("Soap.php");
 /*AQUI COLOCAMOS EL NOMBRE DEL ARCHIVO GENERADO LO RECOGEMOS POR POST*/
 foreach ($Json_Emp as $cpe) {
    $ruc_Emisor = $cpe['rucEmisor'];
    $usersol  =base64_decode($cpe['userSol']);
    $clavesol = base64_decode($cpe['claveSol']);
    $servidor = $cpe['servidorSunat']; 
 } 

 foreach ($Json_Fac as $cabezera) {

    $FechaReferencia= $cabezera['fecGeneracion'];
    $lote= $cabezera['numLote'];
    $fecharesultado= substr($FechaReferencia, 0,4).substr($FechaReferencia, 5,2).substr($FechaReferencia, 8,2);
 }


$ruta_cdr='../Cdr/';
$ruta_zip='../Xml/xml-firmados/';
$ticket='../Ticket/';

function soapCall($wsdlURL, $callFunction = "", $XMLString)
{
    $client = new feedSoap($wsdlURL, array('trace' => true));
    $reply  = $client->SoapClientCall($XMLString);

    //echo "REQUEST:\n" . $client->__getFunctions() . "\n";
    $client->__call("$callFunction", array(), array());
    //$request = prettyXml($client->__getLastRequest());
    //echo highlight_string($request, true) . "<br/>\n";
    return $client->__getLastResponse();
}

//Estructura del XML para la conexión
$XMLString = '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
 <soapenv:Header>
     <wsse:Security>
         <wsse:UsernameToken Id="ABC-123">
             <wsse:Username>'.$ruc_Emisor.$usersol.'</wsse:Username>
             <wsse:Password>'.$clavesol.'</wsse:Password>
         </wsse:UsernameToken>
     </wsse:Security>
 </soapenv:Header>
 <soapenv:Body>
     <ser:sendSummary>
        <fileName>'.$ruc_Emisor.'-RA-'.$fecharesultado.'-'.$lote.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($ruta_zip.$ruc_Emisor.'-RA-'.$fecharesultado.'-'.$lote.'.zip')) . '</contentFile>
     </ser:sendSummary>
 </soapenv:Body>
</soapenv:Envelope>';

//URL para enviar las solicitudes a SUNAT
switch ($servidor) {
    case '1'://Produccion
        $wsdlURL = 'http://127.0.0.1/aplicaciones/facturacion/dsig/Envio/SunatProd.wsdl';
        break;
    case '2'://HOmlgacion
        $wsdlURL = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService?wsdl';
        break;
    case '3'://Beta
        $wsdlURL = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
        break;
}

//Realizamos la llamada a nuestra función
$result = soapCall($wsdlURL, $callFunction = "sendSummary", $XMLString);



$nuevo_fichero =$ticket.$ruc_Emisor .'-RA-'.$fecharesultado.'-'.$lote.'.xml';

$archivo = fopen($nuevo_fichero,'w+');
fputs($archivo,$result);
fclose($archivo);

if (file_exists($nuevo_fichero)) {
    /*LEEMOS EL ARCHIVO XML*/
   $xml = simplexml_load_file($nuevo_fichero ); 
    foreach ($xml->xpath('//ticket') as $response){
        $r[0]=$response; 
    }
      
   } else {
      $r[0]='Error';
 }


 return $r;
}
}
?>