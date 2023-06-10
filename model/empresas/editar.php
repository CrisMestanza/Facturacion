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
	    $myquery = "SELECT t1.id, t1.documento,t1.nombres,t1.correo,t1.ruc,t1.razon,
		t1.celular,t1.telefono,t1.direccion, 
		concat(t1.idpais,t2.detalle) as pais,t1.idubigeo,
		t1.urb, t1.local_,t3.clave FROM tb_registros as t1 
		INNER JOIN catalogo_04 as t2 on t1.idpais=t2.id
        INNER JOIN tb_usuarios as t3 on t3.idregistro=t1.id
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
				9 => $valores2[9],
				10 => $valores2[10],
				11 => $valores2[11],
				12 => $valores2[12],
				13 => base64_decode($valores2[13]),

			);
	

		}

echo json_encode($datos);
}
?>