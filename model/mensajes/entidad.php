<?php
require_once('datos.php');
		$boton=$_POST['boton'];
	function boolNumber($bValue) 
	{ 
	     if ($bValue=='false'){
		    return 0;
	      }
	     if ($bValue=='true'){
		    return 1;
	        }
    }

		switch ($boton) {
			case 'registrar':
				   $Json_In = $_POST['json'];

					$Json = json_decode("[" . $Json_In . "]", JSON_UNESCAPED_UNICODE);

					foreach ($Json as $cpe) {
						$variable_1 = $cpe['id'];
						$variable_2 = $cpe['nombres'];
						$variable_3 = $cpe['correo'];
						$variable_4 = $cpe['asunto'];
						$variable_5 = $cpe['mensaje'];
						$variable_6 = $cpe['codigo'];
						$variable_7 = $cpe['celular'];
						$variable_8 = $cpe['plan'];
					}


					$instancia = new Datos();
					if($instancia->registrar($variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8))
					{
					    echo "exito";
					}
					else{
						echo "No se registro";
					}

				break;

			
		}
		
?>