<?php
require_once "../Token/Err_Auth.php";
require_once "../Upload/UploadArchivos.php"; //Pdf
require_once "../../model/001/Put.php"; //MVC

//
//require_once('Api-PutGet.php');

/*Adicionales facturacion*/
require_once "../Xml/notacredito_2_1.php";
require_once "../Xml/notadebito_2_1.php";
require_once "../Xml/facturacion_2_1.php";
require_once "../Xml/anulados.php";
require_once "../Firma/firmar-xml.php";
require_once "../Firma/firmar-ticket.php";
require_once "../Envio/sunat_conexion.php";
require_once "../Envio/sunat_ticket.php";

function FacturacionUBL($ruc, $Json_In, $send_sunat)
{

    $Json_Fac = json_decode("[" . $Json_In . "]", JSON_UNESCAPED_UNICODE);

    foreach ($Json_Fac as $cpe) {
        $TipoComprobante = $cpe['tipComp'];
        $serieComp = $cpe['serieComp'];
        $numeroComp = $cpe['numeroComp'];
        $EnvioSunat = $cpe['envioSunat'];
        $VersionUbl = $cpe['UBL'];
    }

    //Validamos el envio del json con ele envio de la lista
    if ($send_sunat == 'On') {
        $EnvioSunat = true;
    }

    //Guardamos el Json en el directorio Local
    $json_string = $Json_In;
    $cpe_ = $ruc . '-' . $TipoComprobante . '-' . $serieComp . '-' . $numeroComp;
    $file = '../Json/' . $cpe_ . '.json';
    file_put_contents($file, $json_string);

    //Guardamos la Inf. del Json
    $Put = new PutFacturacion();
    if ($arrayPut = $Put->Guardar($Json_Fac, $send_sunat)) {
        /*Información de la Empresa*/
        $data = file_get_contents("../Json/" . $ruc . ".json");
        $Json_Emp = json_decode($data, JSON_UNESCAPED_UNICODE);

        //Generamos el XML, FIRMA, ENVIO Y PDF
        if ($TipoComprobante == "01" || $TipoComprobante == "03") {
            $instancia = new cpeFacturacionUBL2_1();
            $array = $instancia->Registrar_FacturacionUBL2_1($Json_Fac, $Json_Emp); //genera el Xml
            if ($array[0] == 'Registrado') {
                $firmado = new firmadocpe();
                $arrayFirma = $firmado->FirmarCpe($Json_Fac, $Json_Emp); //Firam el Xml
                if ($arrayFirma[0] == 'Registrado') {
                    if ($EnvioSunat == true) {
                        $enviado = new enviocpe();
                        $arrayEnviar = $enviado->EnviarCpe($Json_Fac, $Json_Emp); //envia e xml a sunat

                        if ($arrayEnviar[0] == 'Error') {
                            return Error_Out();
                        } else {
                            //solo actualizamos cuando es envio
                            if ($send_sunat == 'On') {

                                $Put->modificar($cpe_);
                            }
                            return RespuestaServidor($Json_Emp, $Json_Fac, "Enviado", "Registrado"); //Genera el Pdf
                        }
                    } else {
                        return RespuestaServidor($Json_Emp, $Json_Fac, "Firmado", "Registrado"); //Genera el Pdf
                    }

                } else {
                    return Error_In();
                }

            } else {
                return Error_In();
            }

        } elseif ($TipoComprobante == "07" ) {
            $instancia = new cpenotacredito();
            $array = $instancia->NotaCredito($Json_Fac, $Json_Emp); //genera el Xml
            
            if ($array[0] == 'Registrado') {
                $firmado = new firmadocpe();
                $arrayFirma = $firmado->FirmarCpe($Json_Fac, $Json_Emp); //Firam el Xml
                if ($arrayFirma[0] == 'Registrado') {
                    if ($EnvioSunat == true) {
                        $enviado = new enviocpe();
                        $arrayEnviar = $enviado->EnviarCpe($Json_Fac, $Json_Emp); //envia e xml a sunat

                        if ($arrayEnviar[0] == 'Error') {
                            return Error_Out();
                        } else {
                            //solo actualizamos cuando es envio
                            if ($send_sunat == 'On') {

                                $Put->modificar($cpe_);
                            }
                            return RespuestaServidor($Json_Emp, $Json_Fac, "Enviado", "Registrado"); //Genera el Pdf
                        }
                    } else {
                        return RespuestaServidor($Json_Emp, $Json_Fac, "Firmado", "Registrado"); //Genera el Pdf
                    }

                } else {
                    return Error_In();
                }

            } else {
                return Error_In();
            }


        } elseif ($TipoComprobante == "08" ) {
            $instancia = new cpenotadebito();
            $array = $instancia->NotaDebito($Json_Fac, $Json_Emp); //genera el Xml
            
            if ($array[0] == 'Registrado') {
                $firmado = new firmadocpe();
                $arrayFirma = $firmado->FirmarCpe($Json_Fac, $Json_Emp); //Firam el Xml
                if ($arrayFirma[0] == 'Registrado') {
                    if ($EnvioSunat == true) {
                        $enviado = new enviocpe();
                        $arrayEnviar = $enviado->EnviarCpe($Json_Fac, $Json_Emp); //envia e xml a sunat

                        if ($arrayEnviar[0] == 'Error') {
                            return Error_Out();
                        } else {
                            //solo actualizamos cuando es envio
                            if ($send_sunat == 'On') {

                                $Put->modificar($cpe_);
                            }
                            return RespuestaServidor($Json_Emp, $Json_Fac, "Enviado", "Registrado"); //Genera el Pdf
                        }
                    } else {
                        return RespuestaServidor($Json_Emp, $Json_Fac, "Firmado", "Registrado"); //Genera el Pdf
                    }

                } else {
                    return Error_In();
                }

            } else {
                return Error_In();
            }


        }

    } else {
        echo "No se registro";
    }

}

function AnulacionUBL($ruc, $Json_In, $send_sunat)
{

    $Json_Fac = json_decode("[" . $Json_In . "]", JSON_UNESCAPED_UNICODE);
        /*Información de la Empresa*/
        $data = file_get_contents("../Json/" . $ruc . ".json");
        $Json_Emp = json_decode($data, JSON_UNESCAPED_UNICODE);

            $instancia = new cpeanulados();
            $array = $instancia-> Anulados($Json_Fac, $Json_Emp); //genera el Xml
        
                $firmado = new firmadoticket();
                $arrayFirma = $firmado->FirmarTicket($Json_Fac, $Json_Emp); //Firam el Xml
                if ($arrayFirma[0] == 'Registrado') {
                        $enviado = new enviocpeticket();
                        $arrayEnviar = $enviado->EnviarTicket($Json_Fac, $Json_Emp); //envia e xml a sunat

                        if ($arrayEnviar[0] == 'Error') {
                            return Error_Out();
                        } else {
                            return RespuestaServidor($Json_Emp, $Json_Fac, "Anulados",$arrayEnviar[0] ); //Ticket
                        }
                        
                } else {
                    return Error_In();
                }




}
