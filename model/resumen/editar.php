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
	    $myquery = "SELECT t1.id, t1.llave, t1.fechaem, t1.fechaven, t1.idcliente, t2.nom , t1.iddir, t1.idmon,
		 t1.tc, t1.idpago, t1.cdr, t1.anu, t1.docref, t1.cat09, t1.cat10
		  from resumen as t1  
		inner join clientes as t2 on t2.id = t1.idcliente 
        where t1.llave='$codigo' order by id desc";
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