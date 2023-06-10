<?php
class cpeanulados{ 
function Anulados($Json_Fac,$Json_Emp)
{

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
  $LocalEmpresa=$cabezera['localEmisor'];
}


$conteo=1;
$ItemLine = array();
$TipoComprobante = array();
$SerieComp= array();
$NumeroComp = array();
$FechaReferencia = array();
$FechaIsue = array();
$MotivoAnulacion = array();



foreach ($Json_Fac as $cabezera) {
  $ItemLine[]=$conteo;
  $TipoComprobante[]=$cabezera['tipDocBaja'];
  $SerieComp[]=$cabezera['serDocBaja'];
  $NumeroComp[]=$cabezera['numDocBaja'];;
  $FechaReferencia[]=$cabezera['fecGeneracion'];
  $FechaIsue[]=$cabezera['fecComunicacion'];
  $MotivoAnulacion[]=$cabezera['desMotivoBaja'];
  $lote=$cabezera['numLote'];
  $conteo++;
}

//$fecharesultado=str_replace("-","",$FechaReferencia[0]);
$NumComprobante="RA-".substr($FechaReferencia[0], 0,4).substr($FechaReferencia[0], 5,2).substr($FechaReferencia[0], 8,2).'-'.$lote;

$InfSistema="ELABORADO POR DESARROLLO DE SISTEMAS INTEGRADOS DE GESTION PERU S.A.C";


$xml = new DomDocument('1.0', 'ISO-8859-1');
$xml->standalone = false;
$Invoice = $xml->createElement('VoidedDocuments');
$Invoice = $xml->appendChild($Invoice);
// Set the attributes.
$Invoice->setAttribute('xmlns',	'urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1');
$Invoice->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$Invoice->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$Invoice->setAttribute('xmlns:ds',"http://www.w3.org/2000/09/xmldsig#"); 
$Invoice->setAttribute('xmlns:ext',"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"); 
$Invoice->setAttribute('xmlns:sac',"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"); 
$Invoice->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance"); 

   
$UBLExtension=$xml->createElement('ext:UBLExtensions'); 
$UBLExtension =$Invoice ->appendChild($UBLExtension); 

$ext=$xml->createElement('ext:UBLExtension'); 
$ext =$UBLExtension ->appendChild($ext); 

$contents=$xml->createElement('ext:ExtensionContent'); 
$contents =$ext->appendChild($contents); 


//Ubl-Firma
$extFirma=$xml->createElement('ext:UBLExtension'); 
$extFirma =$UBLExtension ->appendChild($extFirma);
$contentsFirma=$xml->createElement('ext:ExtensionContent'); 
$contentsFirma =$extFirma->appendChild($contentsFirma); 

//------------------------ -----------------------//
//Informacion del comprobante y Version
$UBLVersion=$xml->createElement('cbc:UBLVersionID'); 
$UBLVersion =$Invoice ->appendChild($UBLVersion);
$value = $xml->createTextNode('2.0');
$value = $UBLVersion->appendChild($value);

$CBCCustomization=$xml->createElement('cbc:CustomizationID'); 
$CBCCustomization =$Invoice ->appendChild($CBCCustomization); 
$value = $xml->createTextNode('1.0');
$value = $CBCCustomization->appendChild($value);

$CBCid=$xml->createElement('cbc:ID'); 
$CBCid =$Invoice ->appendChild($CBCid); 
$value = $xml->createTextNode($NumComprobante);
$value = $CBCid->appendChild($value);

$CBCReferenceDate=$xml->createElement('cbc:ReferenceDate'); 
$CBCReferenceDate =$Invoice ->appendChild($CBCReferenceDate);
$value = $xml->createTextNode($FechaReferencia[0]);
$value = $CBCReferenceDate->appendChild($value);

$CBCIssueDate=$xml->createElement('cbc:IssueDate'); 
$CBCIssueDate =$Invoice ->appendChild($CBCIssueDate);
$value = $xml->createTextNode($FechaIsue[0]);
$value = $CBCIssueDate->appendChild($value); 


//---------------------------------------------------//
//Información de la Empresa Emisora -- (Signature)
$CACSignature=$xml->createElement('cac:Signature'); 
$CACSignature =$Invoice ->appendChild($CACSignature);

$IdEmpresa=$xml->createElement('cbc:ID'); 
$IdEmpresa =$CACSignature->appendChild($IdEmpresa);
$value = $xml->createTextNode($RucEmpresa);
$value = $IdEmpresa->appendChild($value); 

$cbcNote=$xml->createElement('cbc:Note'); 
$cbcNote =$CACSignature->appendChild($cbcNote);
$value = $xml->createTextNode($InfSistema);
$value = $cbcNote->appendChild($value); 

$CACSignatoryParty=$xml->createElement('cac:SignatoryParty'); 
$CACSignatoryParty =$CACSignature->appendChild($CACSignatoryParty);

//---------------- Nombre Comercial ----------------//
$CACPartyIdentification=$xml->createElement('cac:PartyIdentification'); 
$CACPartyIdentification =$CACSignatoryParty->appendChild($CACPartyIdentification);
$PartyEmpresa=$xml->createElement('cbc:ID'); 
$PartyEmpresa =$CACPartyIdentification->appendChild($PartyEmpresa);
$value = $xml->createTextNode($RucEmpresa);
$value = $PartyEmpresa->appendChild($value); 

$CACPartyName=$xml->createElement('cac:PartyName'); 
$CACPartyName =$CACSignatoryParty->appendChild($CACPartyName);
$PartyName=$xml->createElement('cbc:Name'); 
$PartyName =$CACPartyName->appendChild($PartyName);
$value = $xml->createTextNode($ComercialEmpresa);
$value = $PartyName->appendChild($value);

//-------------- Razon Social de la Empresa---------------//
$CACAgentParty=$xml->createElement('cac:AgentParty'); 
$CACAgentParty =$CACSignatoryParty->appendChild($CACAgentParty);

$CACPartyIdentification=$xml->createElement('cac:PartyIdentification'); 
$CACPartyIdentification =$CACAgentParty->appendChild($CACPartyIdentification);
$PartyEmpresa=$xml->createElement('cbc:ID'); 
$PartyEmpresa =$CACPartyIdentification->appendChild($PartyEmpresa);
$value = $xml->createTextNode($RucEmpresa);
$value = $PartyEmpresa->appendChild($value); 

$CACPartyName=$xml->createElement('cac:PartyName'); 
$CACPartyName =$CACAgentParty->appendChild($CACPartyName);
$PartyName=$xml->createElement('cbc:Name'); 
$PartyName =$CACPartyName->appendChild($PartyName);
$value = $xml->createTextNode($NameEmpresa);
$value = $PartyName->appendChild($value);

$CACPartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
$CACPartyLegalEntity =$CACAgentParty->appendChild($CACPartyLegalEntity);
$CBCPartyLegalEntity=$xml->createElement('cbc:RegistrationName'); 
$CBCPartyLegalEntity =$CACPartyLegalEntity->appendChild($CBCPartyLegalEntity);
$value = $xml->createTextNode($NameEmpresa);
$value = $CBCPartyLegalEntity->appendChild($value);


$CACDigitalSignatureAttachment=$xml->createElement('cac:DigitalSignatureAttachment'); 
$CACDigitalSignatureAttachment =$CACSignature->appendChild($CACDigitalSignatureAttachment);

$CACExternalReference=$xml->createElement('cac:ExternalReference'); 
$CACExternalReference =$CACDigitalSignatureAttachment->appendChild($CACExternalReference);

$CBCUri=$xml->createElement('cbc:URI'); 
$CBCUri =$CACExternalReference->appendChild($CBCUri);
$value = $xml->createTextNode('SIGN');
$value = $CBCUri->appendChild($value);
// --------------- FIN (Signature)-----------------------//



//------------------------------------------------------//
// ---- Datos del domicilio fiscal del emisor de la factura electrónica. (cac:AccountingSupplierParty)//
$CACAccountingSupplierParty=$xml->createElement('cac:AccountingSupplierParty'); 
$CACAccountingSupplierParty =$Invoice ->appendChild($CACAccountingSupplierParty);

$CBCCustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID'); 
$CBCCustomerAssignedAccountID =$CACAccountingSupplierParty ->appendChild($CBCCustomerAssignedAccountID);
$value = $xml->createTextNode($RucEmpresa);
$value = $CBCCustomerAssignedAccountID->appendChild($value);

$CBCAdditionalAccountID=$xml->createElement('cbc:AdditionalAccountID'); 
$CBCAdditionalAccountID =$CACAccountingSupplierParty ->appendChild($CBCAdditionalAccountID);
$value = $xml->createTextNode($TipoEmpresa);
$value = $CBCAdditionalAccountID->appendChild($value);

$CABParty=$xml->createElement('cac:Party'); 
$CABParty =$CACAccountingSupplierParty ->appendChild($CABParty);


//------------- Razon social de la Empresa ----------------////
$CACPartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
$CACPartyLegalEntity =$CABParty->appendChild($CACPartyLegalEntity);
$CBCPartyLegalEntity=$xml->createElement('cbc:RegistrationName'); 
$CBCPartyLegalEntity =$CACPartyLegalEntity->appendChild($CBCPartyLegalEntity);
$value = $xml->createTextNode($NameEmpresa);
$value = $CBCPartyLegalEntity->appendChild($value);
//---------- fin - (cac:AccountingSupplierParty)---------//


/*------------------------ Datos de la Comunicación de baja ----------------------------------*/
for ($i=0; $i<count($ItemLine); $i++){
$SACVoidedDocumentsLine=$xml->createElement('sac:VoidedDocumentsLine'); 
$SACVoidedDocumentsLine =$Invoice ->appendChild($SACVoidedDocumentsLine);

$CBCLineID=$xml->createElement('cbc:LineID'); 
$CBCLineID = $SACVoidedDocumentsLine->appendChild($CBCLineID);
$value = $xml->createTextNode($ItemLine[$i]);
$value = $CBCLineID->appendChild($value);

$CBCDocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode'); 
$CBCDocumentTypeCode = $SACVoidedDocumentsLine->appendChild($CBCDocumentTypeCode);
$value = $xml->createTextNode($TipoComprobante[$i]);
$value = $CBCDocumentTypeCode->appendChild($value);

$CBCDocumentSerialID=$xml->createElement('sac:DocumentSerialID'); 
$CBCDocumentSerialID = $SACVoidedDocumentsLine->appendChild($CBCDocumentSerialID);
$value = $xml->createTextNode($SerieComp[$i]);
$value = $CBCDocumentSerialID->appendChild($value);

$CBCDocumentNumberID=$xml->createElement('sac:DocumentNumberID'); 
$CBCDocumentNumberID = $SACVoidedDocumentsLine->appendChild($CBCDocumentNumberID);
$value = $xml->createTextNode($NumeroComp[$i]);
$value = $CBCDocumentNumberID->appendChild($value);

$CBCVoidReasonDescription=$xml->createElement('sac:VoidReasonDescription'); 
$CBCVoidReasonDescription = $SACVoidedDocumentsLine->appendChild($CBCVoidReasonDescription);
$value = $xml->createTextNode($MotivoAnulacion[$i]);
$value = $CBCVoidReasonDescription->appendChild($value);
}


$xml->formatOutput = true; 
$strings_xml = $xml->saveXML(); 
$file = '../Xml/xml-no-firmados/'.$RucEmpresa.'-'.$NumComprobante.'.xml';
$xml->save($file); 


  if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }

return $r;

}
}
?>