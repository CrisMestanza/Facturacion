<?php
// ============ OUTPUT ============= //

if (isset($_POST['Login'])) {
    $ruc = $_POST['Login'];
    $key = sha1($ruc . 'Desarrollador: Fernando Carmelo Mamani Blas - DNI: 43614667');
} else {
    $ruc = "";
}

/*
if (isset($_POST['Token'])) {
$key=$_POST['Token'];
} else {
$key = "";
}*/

if (isset($_POST['Puerto'])) {
    $out = $_POST['Puerto'];
} else {
    $out = "";
}

if (isset($_POST['Json'])) {
    $Json_In = $_POST['Json'];
} else {
    $Json_In = "";
}

if (isset($_POST['EnviarLista'])) {
    $send_sunat = $_POST['EnviarLista'];
} else {
    $send_sunat = "Off";
}

// =============== Dependencias ======== //
require_once '../Auth/class_login.php';
require_once "Err_Auth.php";
require_once "../Api/Rest-Cliente.php";
// ================  SQL ============ //
$instancia = new tabla();
$array = $instancia->identificar($ruc, $key);

if ($array[0] == 7) {
    echo base64_encode("hola");
    //echo base64_encode($email.$key.$out.$Json_In);
} else {
    if ($array[4] == 0) {
        echo base64_encode(Error_Estado());
        return false;
    }

    if ($ruc == $array[0]) {
        if ($key == $array[1]) {
            switch ($out) {
                case "F":
                    echo base64_encode(Rest_Cliente($out, $ruc, $Json_In, $send_sunat));
                    break;
                case "A":
                    echo base64_encode(Rest_Cliente($out, $ruc, $Json_In, $send_sunat));
                    break;
                case "T":
                        echo base64_encode(Rest_Cliente($out, $ruc, $Json_In, $send_sunat));
                        break;
                default:
                    //
                    break;
            }
        } else {
            echo base64_encode(Error_Token());
            return false;
        }
    } else {
        echo base64_encode(Error_Email());
        return false;
    }

}
