<?php
class cpeFacturacionUBL2_0{ 
function Registrar_FacturacionUBL2_0($Json_Fac,$Json_Emp)
{


//https://www.taniarascia.com/how-to-use-json-data-with-php-or-javascript/  //echo $value["Items"][1]["ctdUnidadItem"];

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
$ArrayTipoPrecioVenta = array();
$ArrayIndicadorDscto = array();
$ArrayDescuento = array();
$ArrayAfectacionIgv = array();
$ArrayIgv = array();
$ArrayCat05 = array();
$ArrayName05 = array();
$ArrayTaxTypeCode05 = array();
$ArrayCategoryCode05 = array();
$ArrayPrecioUnitario = array();

$ArrayCodAdditional = array();
$ArrayValorAdditional = array();

$item=1;
$igv=0;


foreach($Json_Fac as $cabezera){
         $TipoOperacion =$cabezera['tipOperacion'];
         $FechaComprobante =$cabezera['fecEmision'];
         $fechaVencimiento=$cabezera['fecVencimiento'];
         $TipoComprobante =$cabezera['tipComp'];
         $serieComp =$cabezera['serieComp'];
         $numeroComp =$cabezera['numeroComp'];
         $NumComprobante=$serieComp."-".$numeroComp;
         $DomicilioFiscalEmisor =$cabezera['codLocalEmisor'];
         $TipoCliente =$cabezera['tipDocUsuario'];
         $RucCliente =$cabezera['numDocUsuario'];
         $NameCliente =$cabezera['rznSocialUsuario'];         
         $TipoMoneda =$cabezera['tipMoneda'];
         $TipoCambio =$cabezera['tipCambio'];
         $Descuentosglobales =$cabezera['DsctoGlobal'];         
         $SumatoriaOtrosCargos =$cabezera['otrosCargos'];         
         //$Totaldescuentos =$cabezera['mtoDescuentos'];
         $OperacionesGravadas =$cabezera['Gravada'];
         $OperacionesInafectas =$cabezera['Inafecta'];
         $OperacionesExoneradas =$cabezera['Exonerada'];
         $OperacionesGratuitas=$cabezera['Gratuita'];
         $OperacionesAnticipo=$cabezera['Anticipo'];
         $SumatoriaIgv=$cabezera['mtoIgv'];
         //$SumatoriaISc =$cabezera['mtoISC'];
         //$SumatoriaOtrosTributos =$cabezera['mtoOtrosTributos'];
         $ImporteTotal =$cabezera['mtoTotal'];
        // $guiaitin =$cabezera['guiaItin'];
        // $tipoitin =$cabezera['tipoItin'];

        $codefechavence="-";
        $UbigeoCliente=$cabezera['codUbigeoCliente'];
        $DepartamentoCliente=$cabezera['deptCliente'];
        $ProvinciaCliente= $cabezera['provCliente'];
        $DistritoCliente= $cabezera['distCliente'];
        $PaisCliente=$cabezera['codPaisCliente'];
        $DireccionCliente=$cabezera['desDireccionCliente'];
        $UrbanizacionCliente='-';

         foreach($cabezera['items'] as $detalle) {
              // echo $detalle["ctdUnidadItem"];
               $ArrayItem[] =$item;
               $ArrayTipoUnidad[] =$detalle['codUnidadMedida'];
               $ArrayDetalleBienServicio[] =utf8_decode($detalle['desItem']);
               $ArrayCodigoBienServicio[] =$detalle['codProducto'];
               $ArrayCantidad[] =$detalle['ctdUnidadItem'];               
               $ArrayValorVenta[] =$detalle['mtoValorUnitario'];
               $ArrayPrecioVenta[] =$detalle['mtoPrecioVentaItem'];

               $ArrayTipoPrecioVenta[] =$detalle['tipPrecio'];/*Catalogo N°16*/
               $ArrayIndicadorDscto[] ='false';
               $ArrayDescuento[] =$detalle['mtoDsctoItem'];/*DEscuento por Item*/
               $ArrayAfectacionIgv[] =$detalle['tipAfeIGV'];/*Catalogo N° 07*/
               $ArrayIgv[] =$detalle['mtoIgvItem'];/*Igv por Item*/

               if ($detalle['tipAfeIGV']=='10'){
                  $tributocat5='1000';
               }else if ($detalle['tipAfeIGV']=='10' ||  $detalle['tipAfeIGV']=='11'||  $detalle['tipAfeIGV']=='12'||  $detalle['tipAfeIGV']=='13'||  $detalle['tipAfeIGV']=='14'||  $detalle['tipAfeIGV']=='15'||  $detalle['tipAfeIGV']=='16'||  $detalle['tipAfeIGV']=='17') {
                 $tributocat5='9996';
               }else if ($detalle['tipAfeIGV']=='20'){
                  $tributocat5='9997';
               }else if ($detalle['tipAfeIGV']=='21'){
                  $tributocat5='9996';
               }else if ($detalle['tipAfeIGV']=='30'){
                  $tributocat5='9998';
               }else if ($detalle['tipAfeIGV']=='32' || $detalle['tipAfeIGV']=='33' || $detalle['tipAfeIGV']=='34' || $detalle['tipAfeIGV']=='35' || $detalle['tipAfeIGV']=='36'){
                  $tributocat5='9996';
               }else if ($detalle['tipAfeIGV']=='40'){
                  $tributocat5='9995';
               }

              if ($tributocat5=='1000') {
                  $ArrayCat05[]='1000';
                  $ArrayName05[] ='IGV'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='VAT'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='S';

               }else if ($tributocat5=='9995') {
                  $ArrayCat05[]='9995';
                  $ArrayName05[] ='EXP'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='FRE';
                  $ArrayCategoryCode05[]='G';
               } else if ($tributocat5=='9996') {
                  $ArrayCat05[]='9996';
                  $ArrayName05[] ='GRAT'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='FRE'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='Z';
               } else if ($tributocat5=='9997') {
                  $ArrayCat05[]='9997';
                  $ArrayName05[] ='EXO'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='VAT'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='E';
               } else if ($tributocat5=='9998') {
                  $ArrayCat05[]='9998';
                  $ArrayName05[] ='INA'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='FRE'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='O';
               }
            

               $ArrayPrecioUnitario [] =$detalle['mtoValorVentaItem']; 

               $item=$item+1;
               $igv=$igv+$detalle['mtoIgvItem'];
         }

}



$Arraymonetary        = ["1001","1002","1003","1004"];
$ArrayTotalesmonetary  = [$OperacionesGravadas,$OperacionesInafectas,$OperacionesExoneradas,$OperacionesGratuitas];


//------ Importes Detalle ---------//
$TotalesIGV=number_format($igv,2);
$Cat05="1000";/*Catalogo N° 05*/
$Name05="IGV";/*Catalogo N° 05*/
$TaxTypeCode05="VAT";/*Catalogo N° 05*/

$AllowanceTotal="0.00";/*50.- Descuentos Globales */
$ChargeTotal="0.00";/*25.Sumatoria otros Cargos*/
$PayableTotal=$ImporteTotal;/*27.Importe total de la venta, de la cesión en uso o del servicio prestado */

$InfSistema="ELABORADO POR DESARROLLO DE SISTEMAS INTEGRADOS DE GESTION PERU S.A.C";

       $ArrayCodAdditional[] ="1000";
         $ArrayValorAdditional[] ="SON";

//logisticaqmodayestilos3g.pe
//  jacson principe

/**************************************** XML UBL 2.0 *******************************************************/

$xml = new DomDocument('1.0', 'utf-8');
$xml->standalone = false;
$Invoice = $xml->createElement('Invoice');
$Invoice = $xml->appendChild($Invoice);
// Set the attributes.
$Invoice->setAttribute('xmlns', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
$Invoice->setAttribute('xmlns:cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
$Invoice->setAttribute('xmlns:cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
$Invoice->setAttribute('xmlns:ccts',"urn:un:unece:uncefact:documentation:2"); 
$Invoice->setAttribute('xmlns:ds',"http://www.w3.org/2000/09/xmldsig#"); 
$Invoice->setAttribute('xmlns:ext',"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"); 
$Invoice->setAttribute('xmlns:qdt',"urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2"); 
$Invoice->setAttribute('xmlns:sac',"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"); 
$Invoice->setAttribute('xmlns:udt',"urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2");
$Invoice->setAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance");

$UBLExtension=$xml->createElement('ext:UBLExtensions'); 
$UBLExtension =$Invoice ->appendChild($UBLExtension); 

$ext=$xml->createElement('ext:UBLExtension'); 
$ext =$UBLExtension ->appendChild($ext); 

$contents=$xml->createElement('ext:ExtensionContent'); 
$contents =$ext->appendChild($contents); 

$information=$xml->createElement('sac:AdditionalInformation'); 
$information =$contents->appendChild($information); 

for ($i=0; $i<count($Arraymonetary); $i++){
  $AdditionalMonetaryTotal=$xml->createElement('sac:AdditionalMonetaryTotal'); 
    $AdditionalMonetaryTotal =$information->appendChild($AdditionalMonetaryTotal);

    $Monetary1=$xml->createElement('cbc:ID'); 
    $Monetary1 =$AdditionalMonetaryTotal->appendChild($Monetary1);
    $value1 = $xml->createTextNode($Arraymonetary[$i]);
  $value1 = $Monetary1->appendChild($value1);

  $Monetary2=$xml->createElement('cbc:PayableAmount'); 
    $Monetary2 =$AdditionalMonetaryTotal->appendChild($Monetary2);
    $value2 = $xml->createTextNode($ArrayTotalesmonetary[$i]);
  $value2 = $Monetary2->appendChild($value2);
    $Monetary2->setAttribute('currencyID',$TipoMoneda);

}

for ($i=0; $i<count($ArrayCodAdditional); $i++){
  $AdditionalProperty =$xml->createElement('sac:AdditionalProperty'); 
    $AdditionalProperty =$information->appendChild($AdditionalProperty);

    $Additional1=$xml->createElement('cbc:ID'); 
    $Additional1 =$AdditionalProperty->appendChild($Additional1);
    $value1 = $xml->createTextNode($ArrayCodAdditional[$i]);
  $value1 = $Additional1->appendChild($value1);

  $Additional2=$xml->createElement('cbc:Value'); 
    $Additional2 =$AdditionalProperty->appendChild($Additional2);
    $value2 = $xml->createTextNode($ArrayValorAdditional[$i]);
    $value2 = $Additional2->appendChild($value2);
}

  $SACSUNATTransaction =$xml->createElement('sac:SUNATTransaction'); 
    $SACSUNATTransaction =$information->appendChild($SACSUNATTransaction);

    $CBCTipoOperacion=$xml->createElement('cbc:ID'); 
    $CBCTipoOperacion =$SACSUNATTransaction->appendChild($CBCTipoOperacion);
    $value = $xml->createTextNode($TipoOperacion);
   $value = $CBCTipoOperacion->appendChild($value);


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

$CBCIssueDate=$xml->createElement('cbc:IssueDate'); 
$CBCIssueDate =$Invoice ->appendChild($CBCIssueDate);
$value = $xml->createTextNode($FechaComprobante);
$value = $CBCIssueDate->appendChild($value); 

$CBCInvoiceTypeCode=$xml->createElement('cbc:InvoiceTypeCode'); 
$CBCInvoiceTypeCode =$Invoice ->appendChild($CBCInvoiceTypeCode);
$value = $xml->createTextNode($TipoComprobante);
$value = $CBCInvoiceTypeCode->appendChild($value); 

$CBCDocumentCurrencyCode=$xml->createElement('cbc:DocumentCurrencyCode'); 
$CBCDocumentCurrencyCode =$Invoice ->appendChild($CBCDocumentCurrencyCode); 
$value = $xml->createTextNode($TipoMoneda);
$value = $CBCDocumentCurrencyCode->appendChild($value);

/*Boleta Itinerante*/
//$DespatchDocumentReference = $xml->createElement('cac:DespatchDocumentReference'); 
//$DespatchDocumentReference = $Invoice ->appendChild($DespatchDocumentReference); 

//$Id_Despatch = $xml->createElement('cbc:ID'); 
//$Id_Despatch = $DespatchDocumentReference ->appendChild($Id_Despatch); 
//$value = $xml->createTextNode($guiaitin);
//$value = $Id_Despatch->appendChild($value);

//$DocumentTypeCode = $xml->createElement('cbc:DocumentTypeCode'); 
//$DocumentTypeCode = $DespatchDocumentReference ->appendChild($DocumentTypeCode); 
//$value = $xml->createTextNode($tipoitin);
//$value = $DocumentTypeCode->appendChild($value);

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

$CABPartyName=$xml->createElement('cac:PartyName'); 
$CABPartyName =$CABParty ->appendChild($CABPartyName);

$CBCPartyName=$xml->createElement('cbc:Name'); 
$CBCPartyName =$CABPartyName ->appendChild($CBCPartyName);
$value = $xml->createTextNode($ComercialEmpresa);
$value = $CBCPartyName->appendChild($value);

$CABPostalAddress=$xml->createElement('cac:PostalAddress'); 
$CABPostalAddress =$CABParty ->appendChild($CABPostalAddress);
//------------- Ubigeo ----------//
$CBCUbigeo=$xml->createElement('cbc:ID'); 
$CBCUbigeo =$CABPostalAddress ->appendChild($CBCUbigeo);
$value = $xml->createTextNode($UbigeoEmpresa);
$value = $CBCUbigeo->appendChild($value);
//------------- DIreccion ----------//
$CBCStreetName=$xml->createElement('cbc:StreetName'); 
$CBCStreetName =$CABPostalAddress ->appendChild($CBCStreetName);
$value = $xml->createTextNode($DireccionEmpresa);
$value = $CBCStreetName->appendChild($value);
//------------- Urbanizacion ----------//
$CBCCitySubdivisionName=$xml->createElement('cbc:CitySubdivisionName'); 
$CBCCitySubdivisionName =$CABPostalAddress ->appendChild($CBCCitySubdivisionName);
$value = $xml->createTextNode($UrbanizacionEmpresa);
$value = $CBCCitySubdivisionName->appendChild($value);
//------------- Departamento ----------//
$CBCCityName=$xml->createElement('cbc:CityName'); 
$CBCCityName =$CABPostalAddress ->appendChild($CBCCityName);
$value = $xml->createTextNode($DepartamentoEmpresa);
$value = $CBCCityName->appendChild($value);
//------------- Provincia ----------//
$CBCCountrySubentity=$xml->createElement('cbc:CountrySubentity'); 
$CBCCountrySubentity =$CABPostalAddress ->appendChild($CBCCountrySubentity);
$value = $xml->createTextNode($ProvinciaEmpresa);
$value = $CBCCountrySubentity->appendChild($value);
//------------- Distrito ----------//
$CBCDistrict=$xml->createElement('cbc:District'); 
$CBCDistrict =$CABPostalAddress ->appendChild($CBCDistrict);
$value = $xml->createTextNode($DistritoEmpresa);
$value = $CBCDistrict->appendChild($value);
//------------- Id del Pais ----------//
$CACCountry=$xml->createElement('cac:Country'); 
$CACCountry =$CABPostalAddress ->appendChild($CACCountry);

$CBCIdentificationCode=$xml->createElement('cbc:IdentificationCode'); 
$CBCIdentificationCode =$CACCountry ->appendChild($CBCIdentificationCode);
$value = $xml->createTextNode($PaisEmpresa);
$value = $CBCIdentificationCode->appendChild($value);


//------------- Razon social de la Empresa ----------------////
$CACPartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
$CACPartyLegalEntity =$CABParty->appendChild($CACPartyLegalEntity);
$CBCPartyLegalEntity=$xml->createElement('cbc:RegistrationName'); 
$CBCPartyLegalEntity =$CACPartyLegalEntity->appendChild($CBCPartyLegalEntity);
$value = $xml->createTextNode($NameEmpresa);
$value = $CBCPartyLegalEntity->appendChild($value);
//---------- fin - (                                                                        )---------//

//-------------------------- (cac:AccountingCustomerParty) -----------------------------//
//-- Apellidos y nombres o denominación o razón social del adquirente o usuario --//
$CACAccountingCustomerParty=$xml->createElement('cac:AccountingCustomerParty'); 
$CACAccountingCustomerParty =$Invoice ->appendChild($CACAccountingCustomerParty);

$CBCCustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID'); 
$CBCCustomerAssignedAccountID =$CACAccountingCustomerParty ->appendChild($CBCCustomerAssignedAccountID);
$value = $xml->createTextNode($RucCliente);
$value = $CBCCustomerAssignedAccountID->appendChild($value);

$CBCAdditionalAccountID=$xml->createElement('cbc:AdditionalAccountID'); 
$CBCAdditionalAccountID =$CACAccountingCustomerParty ->appendChild($CBCAdditionalAccountID);
$value = $xml->createTextNode($TipoCliente);
$value = $CBCAdditionalAccountID->appendChild($value);

$CACPartyCliente=$xml->createElement('cac:Party'); 
$CACPartyCliente =$CACAccountingCustomerParty ->appendChild($CACPartyCliente);

/*Datos del Cliente*/
$CABPostalAddress=$xml->createElement('cac:PostalAddress'); 
$CABPostalAddress =$CACPartyCliente ->appendChild($CABPostalAddress);
//------------- Ubigeo ----------//
$CBCUbigeo=$xml->createElement('cbc:ID'); 
$CBCUbigeo =$CABPostalAddress ->appendChild($CBCUbigeo);
$value = $xml->createTextNode($UbigeoCliente);
$value = $CBCUbigeo->appendChild($value);
//------------- DIreccion ----------//
$CBCStreetName=$xml->createElement('cbc:StreetName'); 
$CBCStreetName =$CABPostalAddress ->appendChild($CBCStreetName);
$value = $xml->createTextNode($DireccionCliente);
$value = $CBCStreetName->appendChild($value);
//------------- Urbanizacion ----------//
$CBCCitySubdivisionName=$xml->createElement('cbc:CitySubdivisionName'); 
$CBCCitySubdivisionName =$CABPostalAddress ->appendChild($CBCCitySubdivisionName);
$value = $xml->createTextNode($UrbanizacionCliente);
$value = $CBCCitySubdivisionName->appendChild($value);
//------------- Departamento ----------//
$CBCCityName=$xml->createElement('cbc:CityName'); 
$CBCCityName =$CABPostalAddress ->appendChild($CBCCityName);
$value = $xml->createTextNode($DepartamentoCliente);
$value = $CBCCityName->appendChild($value);
//------------- Provincia ----------//
$CBCCountrySubentity=$xml->createElement('cbc:CountrySubentity'); 
$CBCCountrySubentity =$CABPostalAddress ->appendChild($CBCCountrySubentity);
$value = $xml->createTextNode($ProvinciaCliente);
$value = $CBCCountrySubentity->appendChild($value);
//------------- Distrito ----------//
$CBCDistrict=$xml->createElement('cbc:District'); 
$CBCDistrict =$CABPostalAddress ->appendChild($CBCDistrict);
$value = $xml->createTextNode($DistritoCliente);
$value = $CBCDistrict->appendChild($value);
//------------- Id del Pais ----------//
$CACCountry=$xml->createElement('cac:Country'); 
$CACCountry =$CABPostalAddress ->appendChild($CACCountry);

$CBCIdentificationCode=$xml->createElement('cbc:IdentificationCode'); 
$CBCIdentificationCode =$CACCountry ->appendChild($CBCIdentificationCode);
$value = $xml->createTextNode($PaisCliente);
$value = $CBCIdentificationCode->appendChild($value);

//----------- Direccion del Cliente ---------------------//
$CACPhysicalLocation=$xml->createElement('cac:PhysicalLocation'); 
$CACPhysicalLocation =$CACPartyCliente->appendChild($CACPhysicalLocation);
$CBCLocation=$xml->createElement('cbc:Description'); 
$CBCLocation =$CACPhysicalLocation->appendChild($CBCLocation);
$value = $xml->createTextNode($DireccionCliente);
$value = $CBCLocation->appendChild($value);

/*Razon social del cliente*/
$CACPartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
$CACPartyLegalEntity =$CACPartyCliente->appendChild($CACPartyLegalEntity);
$CBCPartyLegalEntity=$xml->createElement('cbc:RegistrationName'); 
$CBCPartyLegalEntity =$CACPartyLegalEntity->appendChild($CBCPartyLegalEntity);
$value = $xml->createTextNode($NameCliente);
$value = $CBCPartyLegalEntity->appendChild($value);
//-------------------------- FIN (cac:AccountingCustomerParty) -----------------------------/

/*------------Codigo del Domicilio Fiscal------------*/
$CACSellerSupplierParty=$xml->createElement('cac:SellerSupplierParty'); 
$CACSellerSupplierParty =$Invoice ->appendChild($CACSellerSupplierParty);

$CACParty=$xml->createElement('cac:Party'); 
$CACParty =$CACSellerSupplierParty ->appendChild($CACParty);

$CACPostalAddress=$xml->createElement('cac:PostalAddress'); 
$CACPostalAddress =$CACParty ->appendChild($CACPostalAddress);

$CBCAddressTypeCode=$xml->createElement('cbc:AddressTypeCode'); 
$CBCAddressTypeCode =$CACPostalAddress ->appendChild($CBCAddressTypeCode);
$value = $xml->createTextNode($DomicilioFiscalEmisor);
$value = $CBCAddressTypeCode->appendChild($value);

/*----------------Fecha de Vencimiento-------------*/
$CACPaymentMeans=$xml->createElement('cac:PaymentMeans'); 
$CACPaymentMeans =$Invoice ->appendChild($CACPaymentMeans);

$CBCPaymentMeansCode=$xml->createElement('cbc:PaymentMeansCode'); 
$CBCPaymentMeansCode=$CACPaymentMeans ->appendChild($CBCPaymentMeansCode);
$value = $xml->createTextNode($codefechavence);
$value = $CBCPaymentMeansCode->appendChild($value);

$CBCPaymentDueDate=$xml->createElement('cbc:PaymentDueDate'); 
$CBCPaymentDueDate=$CACPaymentMeans ->appendChild($CBCPaymentDueDate);
$value = $xml->createTextNode($fechaVencimiento);
$value = $CBCPaymentDueDate->appendChild($value);

//-------------- B.2.3. Tag TaxTotal -------------//
/*------------Igv Total de Bien o Servicio ----------*/
$CACTaxTotal=$xml->createElement('cac:TaxTotal'); 
$CACTaxTotal =$Invoice ->appendChild($CACTaxTotal);

$CACTaxAmount=$xml->createElement('cbc:TaxAmount'); 
$CACTaxAmount =$CACTaxTotal ->appendChild($CACTaxAmount);
$value = $xml->createTextNode($TotalesIGV);
$value = $CACTaxAmount->appendChild($value);
$CACTaxAmount->setAttribute('currencyID',$TipoMoneda);

$CACTaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
$CACTaxSubtotal =$CACTaxTotal ->appendChild($CACTaxSubtotal);

$CBCTaxAmount=$xml->createElement('cbc:TaxAmount'); 
$CBCTaxAmount =$CACTaxSubtotal ->appendChild($CBCTaxAmount);
$value = $xml->createTextNode($TotalesIGV);
$value = $CBCTaxAmount->appendChild($value);
$CBCTaxAmount->setAttribute('currencyID',$TipoMoneda);

$CACTaxCategory=$xml->createElement('cac:TaxCategory'); 
$CACTaxCategory =$CACTaxSubtotal ->appendChild($CACTaxCategory);

$CACTaxScheme=$xml->createElement('cac:TaxScheme'); 
$CACTaxScheme =$CACTaxCategory ->appendChild($CACTaxScheme);

$CBCId=$xml->createElement('cbc:ID'); 
$CBCId =$CACTaxScheme ->appendChild($CBCId);
$value = $xml->createTextNode($Cat05);
$value = $CBCId->appendChild($value);

$CBCName=$xml->createElement('cbc:Name'); 
$CBCName =$CACTaxScheme ->appendChild($CBCName);
$value = $xml->createTextNode($Name05);
$value = $CBCName->appendChild($value);

$CBCTaxTypeCode=$xml->createElement('cbc:TaxTypeCode'); 
$CBCTaxTypeCode =$CACTaxScheme ->appendChild($CBCTaxTypeCode);
$value = $xml->createTextNode($TaxTypeCode05);
$value = $CBCTaxTypeCode->appendChild($value);

//--------- 25. Sumatoria otros Cargos ---------//
$CACLegalMonetaryTotal=$xml->createElement('cac:LegalMonetaryTotal'); 
$CACLegalMonetaryTotal =$Invoice ->appendChild($CACLegalMonetaryTotal);

$CBCAllowanceTotalAmount=$xml->createElement('cbc:AllowanceTotalAmount'); 
$CBCAllowanceTotalAmount =$CACLegalMonetaryTotal ->appendChild($CBCAllowanceTotalAmount);
$value = $xml->createTextNode($AllowanceTotal);
$value = $CBCAllowanceTotalAmount->appendChild($value);
$CBCAllowanceTotalAmount->setAttribute('currencyID',$TipoMoneda);

$CBCChargeTotalAmount=$xml->createElement('cbc:ChargeTotalAmount'); 
$CBCChargeTotalAmount =$CACLegalMonetaryTotal ->appendChild($CBCChargeTotalAmount);
$value = $xml->createTextNode($ChargeTotal);
$value = $CBCChargeTotalAmount->appendChild($value);
$CBCChargeTotalAmount->setAttribute('currencyID',$TipoMoneda);

$CBCPayableAmount=$xml->createElement('cbc:PayableAmount'); 
$CBCPayableAmount =$CACLegalMonetaryTotal ->appendChild($CBCPayableAmount);
$value = $xml->createTextNode($PayableTotal);
$value = $CBCPayableAmount->appendChild($value);
$CBCPayableAmount->setAttribute('currencyID',$TipoMoneda);

//--------- B.2.4. Tag InvoiceLines ---------//
for ($i=0; $i<count($ArrayItem); $i++){
$CACInvoiceLine=$xml->createElement('cac:InvoiceLine'); 
$CACInvoiceLine =$Invoice ->appendChild($CACInvoiceLine);

$CBCID=$xml->createElement('cbc:ID'); 
$CBCID =$CACInvoiceLine ->appendChild($CBCID);
$value = $xml->createTextNode($ArrayItem[$i]);
$value = $CBCID->appendChild($value);

$CBCInvoicedQuantity=$xml->createElement('cbc:InvoicedQuantity'); 
$CBCInvoicedQuantity =$CACInvoiceLine ->appendChild($CBCInvoicedQuantity);
$value = $xml->createTextNode($ArrayCantidad[$i]);
$value = $CBCInvoicedQuantity->appendChild($value);
$CBCInvoicedQuantity->setAttribute('unitCode',$ArrayTipoUnidad[$i]);

$CBCineExtensionAmount=$xml->createElement('cbc:LineExtensionAmount'); 
$CBCineExtensionAmount =$CACInvoiceLine ->appendChild($CBCineExtensionAmount);
$value = $xml->createTextNode($ArrayValorVenta[$i]);
$value = $CBCineExtensionAmount->appendChild($value);
$CBCineExtensionAmount->setAttribute('currencyID',$TipoMoneda);

$CACPricingReference=$xml->createElement('cac:PricingReference'); 
$CACPricingReference =$CACInvoiceLine ->appendChild($CACPricingReference);

$CACAlternativeConditionPrice=$xml->createElement('cac:AlternativeConditionPrice'); 
$CACAlternativeConditionPrice =$CACPricingReference ->appendChild($CACAlternativeConditionPrice);

$CBCPriceAmount=$xml->createElement('cbc:PriceAmount'); 
$CBCPriceAmount =$CACAlternativeConditionPrice ->appendChild($CBCPriceAmount);
$value = $xml->createTextNode($ArrayPrecioVenta[$i]);
$value = $CBCPriceAmount->appendChild($value);
$CBCPriceAmount->setAttribute('currencyID',$TipoMoneda);

$CBCPriceTypeCode=$xml->createElement('cbc:PriceTypeCode'); 
$CBCPriceTypeCode =$CACAlternativeConditionPrice ->appendChild($CBCPriceTypeCode);
$value = $xml->createTextNode($ArrayTipoPrecioVenta[$i]);
$value = $CBCPriceTypeCode->appendChild($value);

$CACAllowanceCharge=$xml->createElement('cac:AllowanceCharge'); 
$CACAllowanceCharge =$CACInvoiceLine ->appendChild($CACAllowanceCharge);

$CBCChargeIndicator=$xml->createElement('cbc:ChargeIndicator'); 
$CBCChargeIndicator =$CACAllowanceCharge ->appendChild($CBCChargeIndicator);
$value = $xml->createTextNode($ArrayIndicadorDscto[$i]);
$value = $CBCChargeIndicator->appendChild($value);

$CBCAmount=$xml->createElement('cbc:Amount'); 
$CBCAmount =$CACAllowanceCharge ->appendChild($CBCAmount);
$value = $xml->createTextNode($ArrayDescuento[$i]);
$value = $CBCAmount->appendChild($value);
$CBCAmount->setAttribute('currencyID',$TipoMoneda);

/*Igv por Item de Bien o Servicio*/
$CACTaxTotal=$xml->createElement('cac:TaxTotal'); 
$CACTaxTotal =$CACInvoiceLine ->appendChild($CACTaxTotal);

$CACTaxAmount=$xml->createElement('cbc:TaxAmount'); 
$CACTaxAmount =$CACTaxTotal ->appendChild($CACTaxAmount);
$value = $xml->createTextNode($ArrayIgv[$i]);
$value = $CACTaxAmount->appendChild($value);
$CACTaxAmount->setAttribute('currencyID',$TipoMoneda);

$CACTaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
$CACTaxSubtotal =$CACTaxTotal ->appendChild($CACTaxSubtotal);

$CBCTaxAmount=$xml->createElement('cbc:TaxAmount'); 
$CBCTaxAmount =$CACTaxSubtotal ->appendChild($CBCTaxAmount);
$value = $xml->createTextNode($ArrayIgv[$i]);
$value = $CBCTaxAmount->appendChild($value);
$CBCTaxAmount->setAttribute('currencyID',$TipoMoneda);

$CACTaxCategory=$xml->createElement('cac:TaxCategory'); 
$CACTaxCategory =$CACTaxSubtotal ->appendChild($CACTaxCategory);

$CACTaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode'); 
$CACTaxExemptionReasonCode =$CACTaxCategory ->appendChild($CACTaxExemptionReasonCode);
$value = $xml->createTextNode($ArrayAfectacionIgv[$i]);
$value = $CACTaxExemptionReasonCode->appendChild($value);

$CACTaxScheme=$xml->createElement('cac:TaxScheme'); 
$CACTaxScheme =$CACTaxCategory ->appendChild($CACTaxScheme);

$CBCId=$xml->createElement('cbc:ID'); 
$CBCId =$CACTaxScheme ->appendChild($CBCId);
$value = $xml->createTextNode($ArrayCat05[$i]);
$value = $CBCId->appendChild($value);

$CBCName=$xml->createElement('cbc:Name'); 
$CBCName =$CACTaxScheme ->appendChild($CBCName);
$value = $xml->createTextNode($ArrayName05[$i]);
$value = $CBCName->appendChild($value);

$CBCTaxTypeCode=$xml->createElement('cbc:TaxTypeCode'); 
$CBCTaxTypeCode =$CACTaxScheme ->appendChild($CBCTaxTypeCode);
$value = $xml->createTextNode($ArrayTaxTypeCode05[$i]);
$value = $CBCTaxTypeCode->appendChild($value);

$CACItem=$xml->createElement('cac:Item'); 
$CACItem =$CACInvoiceLine ->appendChild($CACItem);

$CBCDescription=$xml->createElement('cbc:Description'); 
$CBCNDescription =$CACItem ->appendChild($CBCDescription);
$value = $xml->createTextNode($ArrayDetalleBienServicio[$i]);
$value = $CBCDescription->appendChild($value);

$CABSellersItemIdentification=$xml->createElement('cac:SellersItemIdentification'); 
$CABSellersItemIdentification =$CACItem ->appendChild($CABSellersItemIdentification);

$CBCID=$xml->createElement('cbc:ID'); 
$CBCID =$CABSellersItemIdentification ->appendChild($CBCID);
$value = $xml->createTextNode($ArrayCodigoBienServicio[$i]);
$value = $CBCID->appendChild($value);

$CACPrice=$xml->createElement('cac:Price'); 
$CACPrice =$CACInvoiceLine ->appendChild($CACPrice);

$CBCPriceAmount=$xml->createElement('cbc:PriceAmount'); 
$CBCPriceAmount =$CACPrice ->appendChild($CBCPriceAmount);
$value = $xml->createTextNode($ArrayPrecioUnitario[$i]);
$value = $CBCPriceAmount->appendChild($value);
$CBCPriceAmount->setAttribute('currencyID',$TipoMoneda);
}


$xml->formatOutput = true; 
$strings_xml = $xml->saveXML(); 
$file = '../Xml/xml-no-firmados/'.$RucEmpresa.'-'.$TipoComprobante.'-'.$NumComprobante.'.xml';
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