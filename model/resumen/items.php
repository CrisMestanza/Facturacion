<?php
require_once '../conexion.php';
require_once '../usuarios/sesiones.php';
$mysqli = conectar();
if ($mysqli->connect_errno) {
    echo "Fallo al conectar" . $mysqli->connect_errno;

} else {
    $rucemisor = LoadSession();
    $sql = "SELECT id, detalle FROM items
    WHERE nruc='$rucemisor' and  detalle LIKE '%" . $_GET['q'] . "%'
    LIMIT 10";

    $result = $mysqli->query($sql);

    $json = [];
    while ($row = $result->fetch_assoc()) {
        $json[] = ['id' => $row['id'], 'text' => $row['detalle']];
    }
    mysqli_close($mysqli);
    echo json_encode($json);

}
