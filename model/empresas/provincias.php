<?php
        require_once('../conexion.php');
        $mysqli =  conectar();
        if($mysqli ->connect_errno)
        {
        echo "Fallo al conectar".$mysqli->connect_errno;
                   
        }
        else
        {
        $id_provincia = $_POST['id_provincia'];
        $mysqli->set_charset("utf-8");
        $myquery="SELECT * FROM catalogo_13_prov WHERE  iddpt='$id_provincia'";
        $resultado = $mysqli->query($myquery);
        $html="";

        while($fila = $resultado ->fetch_assoc()){
        $html.='<option value="'.$fila['id'].'">'.$fila['detalle'].'</option>';
        }
        }
       echo $html;
?>