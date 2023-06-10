<?php
//Aqui Usamos los Recursos de la API 
require_once("Rest-Full.php");
require_once("../Envio/sunat_status.php");

function Rest_Cliente($id,$ruc,$Json_In,$send_sunat){
	switch ($id) {
		case "F":
			 return FacturacionUBL($ruc,$Json_In,$send_sunat);//Metodo Put
			break;
		case "A":
				return AnulacionUBL($ruc,$Json_In,$send_sunat);//Metodo Put
			   break;
		case "T":			
            $instancia = new statuscpeticket();
			return $instancia-> StatusTicket($ruc, $send_sunat);
			   break;
		default:
			return "";
			break;
	}

}
  
?>