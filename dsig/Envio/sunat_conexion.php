<?php
class enviocpe{
function EnviarCpe($Json_Fac,$Json_Emp)
{
  require("Soap.php");
 /*AQUI COLOCAMOS EL NOMBRE DEL ARCHIVO GENERADO LO RECOGEMOS POR POST*/
   foreach ($Json_Emp as $cpe) {
      $ruc_Emisor = $cpe['rucEmisor'];
      $usersol  =base64_decode($cpe['userSol']);
      $clavesol = base64_decode($cpe['claveSol']);
      $servidor = $cpe['servidorSunat']; 
   } 


   foreach ($Json_Fac as $cpe) {
      $TipoComprobante =$cpe['tipComp'];
      $serieComp = $cpe['serieComp'];
      $numeroComp = $cpe['numeroComp'];      
         
   } 

 $Nombre_Archivo = $ruc_Emisor."-".$TipoComprobante."-".$serieComp."-".$numeroComp;

$ruta_cdr='../Cdr/';
$ruta_zip='../Xml/xml-firmados/';

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
     <ser:sendBill>
        <fileName>'.$Nombre_Archivo.'.zip</fileName>
        <contentFile>' . base64_encode(file_get_contents($ruta_zip.$Nombre_Archivo.'.zip')) . '</contentFile>
     </ser:sendBill>
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
      //  $wsdlURL = 'http://127.0.0.1/sifofacturacion/dsig/Envio/SunatBeta.wsdl';
        break;
}

//Realizamos la llamada a nuestra función
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
/*
header ("Content-Disposition: attachment; filename=$enlace ");
header ("Content-Type: application/force-download");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);*/

$nuevo_fichero = $ruta_cdr.$enlace;

if (!copy($enlace, $nuevo_fichero)) {
    
}

/*
$archivozip='../Ftp/'.base64_encode($Nombre_Archivo).'.zip';
if (file_exists($archivozip)) {
   unlink($archivozip);
}


    $zip = new ZipArchive();
    $filename = '../Ftp/'.base64_encode($Nombre_Archivo).'.zip';

    if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
    exit("cannot open <$filename>\n");
    }

    $zip->addFile('../Xml/xml-firmados/'.$Nombre_Archivo.'.zip', base64_encode($Nombre_Archivo).".zip");
    $zip->addFile($nuevo_fichero, base64_encode('R'.$Nombre_Archivo).'.zip');
    $zip->close();
*/

    /*Eliminamos el Archivo Response*/
    unlink($enlace);
    unlink('C'.$Nombre_Archivo.'.xml');
    //unlink('R'.$Nombre_Archivo.'.zip');


   if (file_exists($nuevo_fichero)) {


    //Extraemos el CDR ZIPEADO
    $zip = new ZipArchive;
    if ($zip->open($nuevo_fichero) === TRUE) {
       $zip->extractTo($ruta_cdr);
       $zip->close();
       $r[0]='Registrado';

     }else{
       $r[0]='Error';
       
     }   

   } else {
      $r[0]='Error';
   }
  
 return $r;
}
}
?>