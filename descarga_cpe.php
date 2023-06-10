<?php

$ruta = $_GET['ruta'];
$fichero = $_GET['fichero'];
$resultado = $ruta . $fichero;

if (file_exists($resultado)) {
    // header("Content-type: application/octet-stream");
    header("Content-Type: application/force-download");
    //header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename=' . $fichero);
    readfile($resultado);
} else {
   // header('Location: ./');
    
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
