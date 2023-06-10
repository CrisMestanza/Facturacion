<?php
require_once('datos.php');
		$boton=$_POST['boton'];


		switch ($boton) {

			case 'mod-error':
					
				$codigo = $_POST['codigo'];
				$error = $_POST['error'];
				$cdr = $_POST['cdr'];

				$instancia = new Datos();
				if($instancia->modificar_Error($codigo,$error,$cdr))
				{
					echo "exito";
				}
				else{
					echo "No se registro";
				}
			break;

			case 'mod-error-ticket':
					
				$codigo = $_POST['codigo'];
				$error = $_POST['error'];

				$instancia = new Datos();
				if($instancia->modificar_Error_Ticket($codigo,$error))
				{
					echo "exito";
				}
				else{
					echo "No se registro";
				}
			break;

			case 'ticket':
					
				$codigo = $_POST['codigo'];
				$ticket = $_POST['ticket'];
				$status = $_POST['status'];

				$instancia = new Datos();
				if($instancia->agregar_Ticket($codigo,$ticket,$status))
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

			case 'consultar-error':
					
					$codigo = $_POST['codigo'];
	
					$instancia = new Datos();
					$array=$instancia->consultar_Error($codigo);

					echo $array[0];
				break;


			default:
				# code...
				break;
		}
		
?>