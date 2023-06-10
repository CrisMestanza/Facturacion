<?php
require_once('datos.php');
require_once('./sesiones.php');
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
			case 'ingresar':
				$variable_1 = $_POST['variable_1'];
				$variable_2 = $_POST['variable_2'];


				$ins = new Datos();
				$array=$ins->identificar($variable_1,$variable_2);


				if ($array[0]==0) 
				{
					echo '0';
				}
				else
				{   
					IniciarSession($array[3]);
					echo 'exito';


				}

			break;
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
				    $variable_0 = $_POST['variable_0'];
					$variable_1 = $_POST['variable_1'];
					$variable_2 = $_POST['variable_2'];
					$variable_3 = $_POST['variable_3'];
					$variable_4 = $_POST['variable_4'];

					$instancia = new Datos();

					if($instancia->modificar($variable_0,$variable_1,$variable_2,$variable_3,$variable_4))
					{
						echo "exito";
					}
					else{
						echo "No se registro";
					}
				break;




			default:
				# code...
				break;
		}
		
?>