<?php
require_once('../conexion.php');
$mysqli =  conectar();
if($mysqli ->connect_errno)
{
	echo "Fallo al conectar".$mysqli->connect_errno;

}
else
{

$sql = "SELECT id, detalle FROM catalogo_13_dpt
    WHERE detalle LIKE '%".$_GET['q']."%'
    LIMIT 10";

$result = $mysqli->query($sql);

$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id'], 'text'=>$row['detalle']];
}

echo json_encode($json);


}
?>