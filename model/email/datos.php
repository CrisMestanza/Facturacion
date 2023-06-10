<?php
class Datos
{

    private $conexion;
    public function __construct()
    {
        require_once '../conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }

    public function modificar($variable_0, $variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6, $variable_7, $variable_8, $variable_9, $variable_10, $variable_11, $variable_12, $variable_13, $variable_14)
    {

        $variable_1 = base64_encode(utf8_decode($variable_1));
        $cod = $variable_14 . '-E';


        $sqlUp = "UPDATE conf_email SET correo_de='$variable_0', clave_de='$variable_1', host='$variable_2', puerto='$variable_3',
			 html='$variable_4', adjuntos='$variable_5', ssl_='$variable_6', correo_para='$variable_7' ,
			  cc='$variable_8',cco='$variable_9',asunto='$variable_10',body1='$variable_11' ,
			  body2='$variable_12', email_p='$variable_13', rucempresa='$variable_14'  WHERE id='$cod'";

        $sqlReg = "INSERT INTO conf_email VALUES('$cod','$variable_0','$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$variable_7','$variable_8','$variable_9','$variable_10','$variable_11','$variable_12','$variable_13','$variable_14')";
        
		if ($this->conexion->conexion->query($sqlReg)) {
            return true;
        } else {
			
            if ($this->conexion->conexion->query($sqlUp)) {
                return true;
            } else {
                return false;
            }
        }

        $this->conexion->cerrar();
    }

}
