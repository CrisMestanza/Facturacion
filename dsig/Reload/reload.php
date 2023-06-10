<?php
require_once("../Upload/UploadArchivos.php");//Pdf
		$boton=$_POST['boton'];

		switch ($boton) {
			case 'pdf':
					$cpe = $_POST['codigo'];

					$ruc=substr($cpe,0,11);
					$data = file_get_contents("../Json/".$ruc.".json");
					$Json_Emp = json_decode($data, JSON_UNESCAPED_UNICODE);

				    $data2 = file_get_contents("../Json/".$cpe.".json");
					$Json_Fac = json_decode("[".$data2."]",JSON_UNESCAPED_UNICODE);

					echo base64_encode(RespuestaServidor($Json_Emp,$Json_Fac,"Enviado","Registrado"));//Genera el Pdf

				break;

			case 'enviar-cpe':
					$cpe = $_POST['codigo'];
				    $data2 = file_get_contents("../Json/".$cpe.".json");				
					echo $data2;

			break;


			default:
				# code...
				break;
		}
		
?>