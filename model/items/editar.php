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
	    $myquery = "SELECT t1.id,t1.cod,t1.idsunat,t1.detalle,t1.idunidad,t1.cat7,t1.igv,t1.valor,t1.impuesto,t1.descuento, t2.detalle,t3.detalle FROM items as t1 inner join codigos_productos as t2 on  t2.id=t1.idsunat
		inner join catalogo_03 as t3 on  t3.id=t1.idunidad where t1.id='$codigo'";
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
				9 => $valores2[9],
				10 => $valores2[10],
				11 => $valores2[11]
			);
	

		}

echo json_encode($datos);
}
?>