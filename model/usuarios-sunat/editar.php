<?php
require_once '../conexion.php';
$mysqli = conectar();
if ($mysqli->connect_errno) {
    echo "Fallo al conectar" . $mysqli->connect_errno;

} else {

    $codigo = $_POST['codigo'];
    $mysqli->set_charset("utf-8");
    $myquery = "SELECT * from usuarios_sunat where id='$codigo'";
    $resultado = $mysqli->query($myquery);
    while ($valores2 = $resultado->fetch_array()) {
        $datos = array(
            0 => $valores2[0],
            1 => $valores2[1],
            2 => $valores2[2],
            3 => base64_decode($valores2[3]),
            4 => base64_decode($valores2[4]),
        );

        echo json_encode($datos);
    }
}
