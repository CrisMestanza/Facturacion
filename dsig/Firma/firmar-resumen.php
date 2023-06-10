<?php
class firmadoresumen{
function FirmarResumen($Json_In)
{
//Autor: Fernando Mamani Blas
//Web: www.dsigperu.net
//correo: contacto@dsigperu.net
//Leemos el JSON
 $dato = json_decode(base64_decode($Json_In), true);
   foreach ($dato as $cpe) {
      $documento_xml =$cpe['comprobanteElectronico'];
      $nom_cert = base64_decode($cpe['nomCertificado']);
      $clav_cert = base64_decode($cpe['clavCertificado']);
   } 

   $data = file_get_contents("../Json/601.json");
   $data = json_decode(utf8_decode($data),true);
   foreach ($data as $cpe) {
      $fecha =$cpe['fecGeneracion'];
      $lote = $cpe['numLote'];
      $fecharesultado=str_replace("-","",$fecha);
   }

//========================================================================================================================================
//firmado del documento
require_once('../xmlseclibs-master/xmlseclibs.php');
$file='../Xml/xml-firmados/'.substr($documento_xml,0,11).'-RC-'.$fecharesultado.'-'.$lote.'.xml';

$xml_semilla = '../Xml/xml-no-firmados/'.substr($documento_xml,0,11).'-RC-'.$fecharesultado.'-'.$lote.'.xml';
$ReferenceNodeName = 'ExtensionContent';
// Firmar Digitalmente XML de la semilla
$doc =new DOMDocument('1.0', 'ISO-8859-1');
$doc->formatOutput = FALSE; 
$doc->preserveWhiteSpace = TRUE;
$doc->load($xml_semilla);
$objDSig = new XMLSecurityDSig(TRUE);
$objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);
$options['prefix'] = '';
$options['prefix_ns'] = '';
$options['force_uri'] = TRUE;
$options['id_name'] = 'ID';
$objDSig->addReference($doc, XMLSecurityDSig::SHA1, array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'), $options);
$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type'=>'private'));
$pfx = file_get_contents("../Certificado/MPS20170412529762.pfx");
openssl_pkcs12_read($pfx, $key, "FernA1989DoBlas");
$objKey->loadKey($key["pkey"]);
$objDSig->add509Cert($key["cert"]);
$objDSig->sign($objKey, $doc->getElementsByTagName($ReferenceNodeName)->item(1));
//Guardamos el Documento
$doc->save($file);//$objDSig->sign($objKey, $doc->documentElement);
//========================================================================================================================================

//==================================================================================
$xml = $file;
$doc =new DOMDocument();
$doc->load($xml);
/*Modificar el Nodo ya creado solo para agregar la etiqueta*/
$oldChild = $doc->getElementsByTagName("Signature")->item(0);
$oldChild->parentNode->replaceChild($oldChild, $oldChild);
$oldChild->setAttribute("Id", "SignSUNAT");
//Guardamos el Documento

$doc->save($file);
//==================================================================================

  if (file_exists($file)) {
      require('../zip/pclzip.lib.php');
    $filename='../Xml/xml-firmados/'.substr($documento_xml,0,11).'-RC-'.$fecharesultado.'-'.$lote.'.zip';
    $archive = new PclZip($filename);
    $v_list = $archive->create($file,
                             PCLZIP_OPT_REMOVE_PATH, '../Xml/xml-firmados/');
    
    if ($v_list == 0) {
    	$r[0]='Error';
    }else{
    	$r[0]='Registrado';
    }

   } else {
      $r[0]='Error';
   }

   return $r;

}
}
?>