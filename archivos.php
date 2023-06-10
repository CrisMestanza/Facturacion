<?php 

	$cpe=$_POST['cpe'];

        $archivozip='./dsig/Cdr/R-'.$cpe.'.xml';
        if (file_exists($archivozip)) {
           echo "On";
        }else{
            echo "Off";
        }
     
?>     