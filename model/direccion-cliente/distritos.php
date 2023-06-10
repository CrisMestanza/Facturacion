<?php
        require_once('../conexion.php');
        
        $mysqli =  conectar();
        if($mysqli ->connect_errno)
        {
        echo "Fallo al conectar".$mysqli->connect_errno;
                   
        }
        else
        {
        $id_distrito = $_POST['id_distrito'];
        $mysqli->set_charset("utf-8");
        $myquery="SELECT * FROM catalogo_13_dist WHERE  idprov='$id_distrito'";
        $resultado = $mysqli->query($myquery);
        $html="";

        while($fila = $resultado ->fetch_assoc()){
        $html.='<option value="'.$fila['id'].'">'.$fila['detalle'].'</option>';
        }
        }
       echo $html;
?>