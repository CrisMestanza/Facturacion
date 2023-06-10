<?php
require_once '../conexion.php';
$mysqli = conectar();
if ($mysqli->connect_errno) {
    echo "Fallo al conectar" . $mysqli->connect_errno;

} else {

    if (isset($_POST["codigo"])) {
        $codigo = $_POST["codigo"];

        $sql = "SELECT id, dir FROM direccion_cliente
    WHERE idcliente ='$codigo'";

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id'] . '">' . $row['dir'] . '</option>';
        }

    }

}
