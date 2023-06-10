<?php
   /*Información de la Empresa*/
   $data = file_get_contents("../Json/20601733022.json");   
   $Json_Emp = json_decode($data, JSON_UNESCAPED_UNICODE);

   $Json_In = file_get_contents("../Json/20601733022-09-T001-00000001.json");
   $Json_Fac = json_decode("[".$Json_In."]",JSON_UNESCAPED_UNICODE);

/*Información de la Empresa*/
foreach ($Json_Emp as $cabezera) {
  $RucEmpresa = $cabezera['rucEmisor'];
  $NameEmpresa = $cabezera['razEmisor'];
  $DireccionEmpresa =$cabezera['direccionEmisor'];
  $PaisEmpresa =$cabezera['paisEmisor'];
  $UbigeoEmpresa =$cabezera['ubigeoEmisor'];
  $DepartamentoEmpresa =$cabezera['depEmisor'];
  $ProvinciaEmpresa =$cabezera['provEmisor'];
  $DistritoEmpresa =$cabezera['distEmisor'];
  $ComercialEmpresa =$cabezera['comercialEmisor'];
  $TipoEmpresa="6";
  $UrbanizacionEmpresa=$cabezera['urbEmisor'];
  $LocalEmpresa='0001';
}

/*LECTURA DEL ARCHIVO JSON*/
/*-------------------------*/
$item=1;
$ArrayItem = array();
$ArraycodProducto = array();
$ArraycodItem= array();
$ArrayDetalleBienServicio = array();
$ArrayUnidad= array();
$ArrayCantidad = array();
$ArraycodSunat = array();

$UBLVersion="2.1";

foreach($Json_Fac as $cabezera){
         $a1 =$cabezera['fecEmision'];
         $a2=$cabezera['horaEmision'];
         $a3 =$cabezera['tipComp'];
         $a4 =$cabezera['serieComp'];
         $a5 =$cabezera['numeroComp'];
         $NumComprobante=$cabezera['serieComp']."-".$cabezera['numeroComp'];
         $a6 =$cabezera['observaciones'];
         $a7=$cabezera['serienumReferencia'];
         $a8=$cabezera['tipocompReferencia'];
         $a9=$cabezera['detcompReferencia'];
         $a10 =$cabezera['numdocDam'];         
         $a11 =$cabezera['tipodocDam'];
         $a12 =$cabezera['numdocRelacionado'];
         $a13=$cabezera['tipodocRelacionado'];         
         $a14 =$cabezera['numdocScop'];         
         $a15 =$cabezera['tipodocScop'];
         $a16=$cabezera['tipDocDestinatario'];
         $a17 =$cabezera['numDocDestinatario'];
         $a18=$cabezera['rznSocialDestinatario'];
         $a19=$cabezera['tipDocProveedor'];
         $a20=$cabezera['numDocProveedor'];
         $a21 =$cabezera['rznSocialDestinatario'];
         $a22=$cabezera['motivoTraslado'];
         $a23=$cabezera['descripcionTraslado'];
         $a24=$cabezera['indicadorTransbordo'];
         $a25=$cabezera['pesoBruto'];
         $a26=$cabezera['unidadMedida'];
         $a27=$cabezera['numeroBultos'];
         $a28=$cabezera['modalidadTraslado'];
         $a29=$cabezera['fechainicioTraslado'];
         $a30 =$cabezera['fechaentregaBien'];    
         $a31 =$cabezera['rucTransportista'];
         $a32=$cabezera['tipodocTransportista'];
         $a33 =$cabezera['razonTransportista'];
         $a34 =$cabezera['numeroPlaca'];
         $a35 =$cabezera['numeroplacaSecundario'];
         $a36 =$cabezera['ubigeoLlegada'];
         $a37=$cabezera['direccionLlegada'];
         $a38=$cabezera['numeroContenedor'];
         $a39=$cabezera['ubigeoPartida'];
         $a40 =$cabezera['direccionPartida'];
         $a41 =$cabezera['codigoPuerto'];        



         foreach($cabezera['items'] as $detalle) {
              // echo $detalle["ctdUnidadItem"];
               $ArrayItem[] =$item;
               $ArraycodItem[] =$detalle['CodItem'];
               $ArrayDetalleBienServicio[] =utf8_decode($detalle['desItem']);
               $ArrayUnidad[] =$detalle['codUnidadMedida'];
               $ArrayCantidad[] =$detalle['ctdUnidadItem'];               
               $ArrayCodProducto[] =$detalle['codProducto'];
               $ArraycodSunat[] =$detalle['codigoSunat'];
         }

}


/**************************************** XML UBL 2.0 *******************************************************/
/**************************************** XML UBL 2.0 *******************************************************/

$xml = new DomDocument('1.0', 'utf-8');
$xml->standalone = false;
$Invoice = $xml->createElement('DespatchAdvice');
$Invoice = $xml->appendChild($Invoice);
// Set the attributes.
$Invoice->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
$Invoice->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$Invoice->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$Invoice->setAttribute('xmlns:ccts',"urn:un:unece:uncefact:documentation:2"); 
$Invoice->setAttribute('xmlns:ds',"http://www.w3.org/2000/09/xmldsig#"); 
$Invoice->setAttribute('xmlns:ext',"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"); 
$Invoice->setAttribute('xmlns:qdt',"urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2"); 
$Invoice->setAttribute('xmlns:udt',"urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
$Invoice->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");


$UBLExtension=$xml->createElement('ext:UBLExtensions'); 
$UBLExtension =$Invoice ->appendChild($UBLExtension); 


//Ubl-Firma
$extFirma=$xml->createElement('ext:UBLExtension'); 
$extFirma =$UBLExtension ->appendChild($extFirma);

$contentsFirma=$xml->createElement('ext:ExtensionContent'); 
$contentsFirma =$extFirma->appendChild($contentsFirma);


//------------------------ -----------------------//
//Informacion del comprobante y Version
$UBLVersion=$xml->createElement('cbc:UBLVersionID'); 
$UBLVersion =$Invoice ->appendChild($UBLVersion);
$value = $xml->createTextNode('2.1');
$value = $UBLVersion->appendChild($value);

$CBCCustomization=$xml->createElement('cbc:CustomizationID'); 
$CBCCustomization =$Invoice ->appendChild($CBCCustomization); 
$value = $xml->createTextNode('2.0');
$value = $CBCCustomization->appendChild($value);


$CBCid=$xml->createElement('cbc:ID'); 
$CBCid =$Invoice ->appendChild($CBCid); 
$value = $xml->createTextNode($a4."-".$a5);
$value = $CBCid->appendChild($value);



//Fecha de Emisión
$CBCIssueDate=$xml->createElement('cbc:IssueDate'); 
$CBCIssueDate =$Invoice ->appendChild($CBCIssueDate);
$value = $xml->createTextNode($a1);
$value = $CBCIssueDate->appendChild($value); 

//Hora de Envío
$CBCIssueTime=$xml->createElement('cbc:IssueTime'); 
$CBCIssueTime =$Invoice ->appendChild($CBCIssueTime);
$value = $xml->createTextNode($a2);
$value = $CBCIssueTime->appendChild($value); 

//tipo
$x=$xml->createElement('cbc:DespatchAdviceTypeCode'); 
$x =$Invoice ->appendChild($x);
$value = $xml->createTextNode("09");
$value = $x->appendChild($value); 

$x=$xml->createElement('cac:Signature'); 
$x =$Invoice ->appendChild($x);

$y=$xml->createElement('cbc:ID'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);

$y=$xml->createElement('cbc:Note'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);

$y=$xml->createElement('cac:SignatoryParty'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cac:PartyIdentification'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:ID'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);


$z=$xml->createElement('cac:PartyName'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:Name'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);

$y=$xml->createElement('cac:DigitalSignatureAttachment'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cac:ExternalReference'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:URI'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);

$x=$xml->createElement('cac:DespatchSupplierParty'); 
$x =$Invoice ->appendChild($x);

$y=$xml->createElement('cbc:CustomerAssignedAccountID'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);
$y->setAttribute('schemeID',"mm");

$y=$xml->createElement('cac:Party'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cac:PartyIdentification'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:RegistrationName'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);

$x=$xml->createElement('cac:DeliveryCustomerParty'); 
$x =$Invoice ->appendChild($x);

$y=$xml->createElement('cbc:CustomerAssignedAccountID'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);
$y->setAttribute('schemeID',"mm");

$y=$xml->createElement('cac:Party'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cac:PartyLegalEntity'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:RegistrationName'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);


$x=$xml->createElement('cac:Shipment'); 
$x =$Invoice ->appendChild($x);

$y=$xml->createElement('cbc:ID'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);


$y=$xml->createElement('cbc:HandlingCode'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);

$y=$xml->createElement('cbc:GrossWeightMeasure'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);
$y->setAttribute('unitCode',"mm");

$y=$xml->createElement('cbc:SplitConsignmentIndicator'); 
$y =$x->appendChild($y);
$value = $xml->createTextNode("m");
$value = $y->appendChild($value);

$y=$xml->createElement('cac:ShipmentStage'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cbc:TransportModeCode'); 
$z =$y->appendChild($z);
$value = $xml->createTextNode("m");
$value = $z->appendChild($value);

$z=$xml->createElement('cac:TransitPeriod'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:StartDate'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);

$z=$xml->createElement('cac:CarrierParty'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cac:PartyIdentification'); 
$v =$z->appendChild($v);

$w=$xml->createElement('cbc:ID'); 
$w =$v->appendChild($w);
$value = $xml->createTextNode("m");
$value = $w->appendChild($value);
$w->setAttribute('schemeID',"mm");

$v=$xml->createElement('cac:PartyName'); 
$v =$z->appendChild($v);

$w=$xml->createElement('cbc:ID'); 
$w =$v->appendChild($w);
$value = $xml->createTextNode("m");
$value = $w->appendChild($value);

$z=$xml->createElement('cac:TransportMeans'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cac:RoadTransport'); 
$v =$z->appendChild($v);

$w=$xml->createElement('cbc:LicensePlateID'); 
$w =$v->appendChild($w);
$value = $xml->createTextNode("m");
$value = $w->appendChild($value);

$z=$xml->createElement('cac:DriverPerson'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:ID'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);
$v->setAttribute('schemeID',"mm");

$y=$xml->createElement('cac:Delivery'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cac:DeliveryAddress'); 
$z =$y->appendChild($z);

$v=$xml->createElement('cbc:ID'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);

$v=$xml->createElement('cbc:StreetName'); 
$v =$z->appendChild($v);
$value = $xml->createTextNode("m");
$value = $v->appendChild($value);

$y=$xml->createElement('cac:OriginAddress'); 
$y =$x->appendChild($y);

$z=$xml->createElement('cbc:ID'); 
$z =$y->appendChild($z);
$value = $xml->createTextNode("m");
$value = $z->appendChild($value);

$z=$xml->createElement('cbc:StreetName'); 
$z =$y->appendChild($z);
$value = $xml->createTextNode("m");
$value = $z->appendChild($value);

for ($i=0; $i<count($ArrayItem); $i++){
   $x=$xml->createElement('cac:DespatchLine'); 
   $x =$Invoice ->appendChild($x);
   
   $y=$xml->createElement('cbc:ID'); 
   $y =$x->appendChild($y);
   $value = $xml->createTextNode("m");
   $value = $y->appendChild($value);
   
   
   $y=$xml->createElement('cbc:DeliveredQuantity'); 
   $y =$x->appendChild($y);
   $value = $xml->createTextNode("m");
   $value = $y->appendChild($value);
   $y->setAttribute('unitCode',"mm");

   $y=$xml->createElement('cac:OrderLineReference'); 
   $y =$x->appendChild($y);
   
   $z=$xml->createElement('cbc:LineID'); 
   $z =$y->appendChild($z);
   $value = $xml->createTextNode("m");
   $value = $z->appendChild($value);

   $y=$xml->createElement('cac:Item'); 
   $y =$x->appendChild($y);

   $z=$xml->createElement('cbc:Name'); 
   $z =$y->appendChild($z);
   $value = $xml->createTextNode("m");
   $value = $z->appendChild($value);

   $z=$xml->createElement('cac:SellersItemIdentification'); 
   $z =$y->appendChild($z);

   $v=$xml->createElement('cbc:ID'); 
   $v =$z->appendChild($v);
   $value = $xml->createTextNode("m");
   $value = $v->appendChild($value);





}














$xml->formatOutput = true; 
$strings_xml = $xml->saveXML(); 
$file = '../Xml/xml-no-firmados/'.$RucEmpresa.'-09-'.$NumComprobante.'.xml';
$xml->save($file)

?>