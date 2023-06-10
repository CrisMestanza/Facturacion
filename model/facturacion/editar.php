<?php
require_once('../conexion.php');
$mysqli =  conectar();
if($mysqli ->connect_errno)
{
	echo "Fallo al conectar".$mysqli->connect_errno;

}
else
{

	   $codigo  = $_POST['codigo'];
	   $mysqli->set_charset("utf-8");
	    $myquery = "SELECT t1.id,t1.dir,t1.idpais,t1.idubigeo,t4.detalle as dapartamento,t3.detalle as provincia,t2.detalle as distrito,t1.email,t1.urb,t1.local FROM  direccion_cliente  as t1
INNER JOIN catalogo_13_dist as t2 on t2.id = t1.idubigeo
INNER JOIN catalogo_13_prov as t3 on t3.id = t2.idprov
INNER JOIN catalogo_13_dpt as t4 on t4.id = t3.iddpt
 where t1.id='$codigo'";
		$resultado = $mysqli->query($myquery);
		while($valores2 = $resultado ->fetch_array())

		{
			$datos = array(
				0 => $valores2[0], 
				1 => $valores2[1], 
				2 => $valores2[2], 
				3 => $valores2[3],
				4 => $valores2[4],
				5 => $valores2[5],
				6 => $valores2[6],
				7 => $valores2[7],
				8 => $valores2[8],

			);
	

		}

echo json_encode($datos);
}
?>