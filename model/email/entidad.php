<?php
require_once('datos.php');
		$boton=$_POST['boton'];


		switch ($boton) {

			case 'registrar':
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
					$variable_13 = $_POST['variable_13'];
					$variable_14 = $_POST['variable_14'];

					
					$instancia = new Datos();

					if($instancia->modificar($variable_0,$variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8,$variable_9,$variable_10,$variable_11,$variable_12,$variable_13,$variable_14))
					{
						echo "exito";
					}
					else{
						echo "No se registro";
					}
				break;


		}
		
?>