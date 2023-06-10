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
					$variable_1 = $_POST['variable_1'];
					$variable_2 = $_POST['variable_2'];
					$variable_3 = $_POST['variable_3'];
					$variable_4 = $_POST['variable_4'];
					$variable_5 = $_POST['variable_5'];
					$variable_6 = $_POST['variable_6'];
					$variable_7 = $_POST['variable_7'];
					$variable_8 = $_POST['variable_8'];
					$variable_9 = $_POST['variable_9'];
					$variable_10 = $_POST['variable_10'];
					$variable_11 = $_POST['variable_11'];
					$variable_12 = $_POST['variable_12'];
					$variable_13 = $_POST['variable_13'];

					$instancia = new Datos();
					if($instancia->registrar($variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8,$variable_9,$variable_10,$variable_11,$variable_12,$variable_13))
					{
					    echo "exito";


					}
					else{
						echo "No se registro";
					}

				break;

			case 'eliminar':
					
					$codigo = $_POST['codigo'];

					$instancia = new Datos();
					if($instancia->eliminar($codigo))
					{
						echo "exito";
					}
					else{
						echo "No se registro";
					}
				break;

			case 'modificar':
			        $variable_0 = $_POST['variable_0'];
					$variable_1 = $_POST['variable_1'];
					$variable_2 = $_POST['variable_2'];
					$variable_3 = $_POST['variable_3'];
					$variable_4 = $_POST['variable_4'];
					$variable_5 = $_POST['variable_5'];
					$variable_6 = $_POST['variable_6'];
					$variable_7 = $_POST['variable_7'];
					$variable_8 = $_POST['variable_8'];
					$variable_9 = $_POST['variable_9'];
					$variable_10 = $_POST['variable_10'];
					$variable_11 = $_POST['variable_11'];
					$variable_12 = $_POST['variable_12'];
					
					$instancia = new Datos();

					if($instancia->modificar($variable_0,$variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8,$variable_9,$variable_10,$variable_11,$variable_12))
					{
						echo "exito";
					}
					else{
						echo "No se registro";
					}
				break;


			case 'consultar':
					$variable_1 = $_POST['variable_1'];

					$instancia = new Datos();
					$array=$instancia->consultar($variable_1);

						echo $array[0];
				

				break;


			default:
				# code...
				break;
		}
		
?>