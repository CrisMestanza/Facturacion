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


					$instancia = new Datos();
					if($instancia->registrar($variable_1,$variable_2,$variable_3,$variable_4))
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
					$variable_1 = $_POST['variable_1'];
					$variable_2 = $_POST['variable_2'];
					$variable_3 = $_POST['variable_3'];
					$variable_4 = $_POST['variable_4'];


					
					$instancia = new Datos();

					if($instancia->modificar($variable_1,$variable_2,$variable_3,$variable_4))
					{
						echo "exito";
					}
					else{
						echo "No se registro";
					}
				break;

			case 'consultar-clientes':
			        $variable_1 = $_POST['variable_1'];
					$instancia = new Datos();
					$array=$instancia->consultarclientes($variable_1);

					echo $array[0];
				

				break;


			default:
				# code...
				break;
		}
		
?>