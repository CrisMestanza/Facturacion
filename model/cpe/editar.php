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
	    $myquery = "SELECT
		t1.id,
		t1.fechaem,
		t1.fechaven,
		t1.idnum,
		t2.doc,
		concat( t2.nom ) AS cliente,
		t1.iddir,
		t1.idmon,
		t1.tc,
		t1.idpago,
		t1.dias,
		t1.docref,
		t1.cat09,
		t1.cat10,
		t2.id AS codcliente,
		t3.iddir AS dir 
	FROM
		resumen AS t1
		INNER JOIN clientes AS t2 ON t2.id = t1.idcliente
		INNER JOIN numeracion t3 ON t3.id = t1.idnum
		  where t1.llave='$codigo'";
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
				11 => $valores2[11],
				12 => $valores2[12],
				13 => $valores2[13],
				14 => $valores2[14],
				15 => $valores2[15],

			);
	

		}

echo json_encode($datos);
}
?>