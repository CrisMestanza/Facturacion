<?php

$ruta = "../../dsig/Certificado/";
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $ruta .$_FILES['file']['name'])) {
        echo '1'.$_FILES['file']['name'];
    } else {
        echo 0;
    }
