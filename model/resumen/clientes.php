<?php
require_once '../conexion.php';
require_once '../usuarios/sesiones.php';
$mysqli = conectar();
if ($mysqli->connect_errno) {
    echo "Fallo al conectar" . $mysqli->connect_errno;

} else {
    $rucemisor = LoadSession();

    if (is_numeric($_GET['q'])) {
        $sql = "SELECT doc,nom FROM clientes
                WHERE  nruc='$rucemisor' and  doc LIKE '%" . $_GET['q'] . "%'
                LIMIT 10";
    } else {
        $sql = "SELECT  doc,nom FROM clientes
               WHERE  nruc='$rucemisor' and  nom LIKE '%" . $_GET['q'] . "%'
               LIMIT 10";
    }

    $result = $mysqli->query($sql);

    $json = [];
    while ($row = $result->fetch_assoc()) {
        $json[] = ['id' => $row['doc'], 'text' => $row['nom']];
    }
    mysqli_close($mysqli);
    echo json_encode($json);

}
