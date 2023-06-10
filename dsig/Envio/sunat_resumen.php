<?php
class enviocperesumen{
function EnviarResumen($Json_In)
{
  require("Soap.php");
 /*AQUI COLOCAMOS EL NOMBRE DEL ARCHIVO GENERADO LO RECOGEMOS POR POST*/
  $dato = json_decode(base64_decode($Json_In), true);
   foreach ($dato as $cpe) {
      $ruc =$cpe['rucEmisor'];
      $usersol =$cpe['userSol'];
      $clavesol =$cpe['claveSol'];
      $servidor =$cpe['tipoServidor'];
      $Nombre_Archivo =$cpe['comprobanteElectronico'];
   } 

   $data = file_get_contents("../Json/601.json");
   $data = json_decode(utf8_decode($data),true);
   foreach ($data as $cpe) {
      $fecha =$cpe['fecGeneracion'];
      $lote = $cpe['numLote'];
      $fecharesultado=str_replace("-","",$fecha);
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
             <wsse:Username>'.$ruc.$usersol.'</wsse:Username>
             <wsse:Password>'.$clavesol.'</wsse:Password>
         </wsse:UsernameToken>
     </wsse:Security>
 </soapenv:Header>
 <soapenv:Body>
     <ser:sendSummary>
        <fileName>'.$ruc.'-RC-'.$fecharesultado.'-'.$lote.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($ruta_zip.$ruc.'-RC-'.$fecharesultado.'-'.$lote.'.zip')) . '</contentFile>
     </ser:sendSummary>
 </soapenv:Body>
</soapenv:Envelope>';

//URL para enviar las solicitudes a SUNAT
switch ($servidor) {
    case '1'://Produccion
        $wsdlURL = 'http://fervabi-001-site1.itempurl.com/Api-rest/20601733022/Envio/SunatProd.wsdl';
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


/*creamos Json*/
/*$tickets = array(); 
$tickets[] = array('Ticket'=> $result);
$json_string = json_encode($tickets);
$file = $ruta_cdr.$Nombre_Archivo.'-RA.json';
file_put_contents($file, $json_string);*/

$nuevo_fichero =$ticket.$ruc.'-RC-'.$fecharesultado.'-'.$lote.'.xml';

$archivo = fopen($nuevo_fichero,'w+');
fputs($archivo,$result);
fclose($archivo);

$archivozip=$ticket.base64_encode($ruc.'-RC-'.$fecharesultado.'-'.$lote).'.zip';
if (file_exists($archivozip)) {
   unlink($archivozip);
}

   /*Comprimimos un Zip del xml y cdr*/
    require('../zip/pclzip.lib.php');
    //$filename=$ticket.base64_encode($ruc.'-RC-'.$fecharesultado.'-'.$lote).'.zip';
    $archive = new PclZip($archivozip);
    $v_list = $archive->add($nuevo_fichero,
                             PCLZIP_OPT_REMOVE_PATH, '../Ticket/');

   if (file_exists($nuevo_fichero)) {
     $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
  
 return $r;
}
}
?>