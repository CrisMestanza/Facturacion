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
	    $myquery = "SELECT t1.id ,t1.dir, concat(t1.idpais,t2.detalle) as pais,
		t1.idubigeo, t1.telefono,t1.urb, t1.local_, t1.tipo FROM direccion_empresa as t1
		INNER JOIN catalogo_04 as t2 on t1.idpais=t2.id 
		where t1.id='$codigo' ";
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