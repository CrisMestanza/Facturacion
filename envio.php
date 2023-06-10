<?php 

if (isset($_POST['json'])) {
    $json=$_POST['json'];
} else {
    $json = "";
}


          $file = '400.json';
          file_put_contents($file, $json);
 ?>