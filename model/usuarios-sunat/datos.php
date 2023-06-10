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

    public function registrar($variable_1, $variable_2, $variable_3, $variable_4, $variable_5,$variable_6)
    {

        $variable_3=base64_encode($variable_3);
        $variable_4=base64_encode($variable_4);
        $token=sha1($variable_5.'Desarrollador: Fernando Carmelo Mamani Blas - DNI: 43614667');

        $sql = "INSERT INTO usuarios_sunat VALUES(0,'$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$token')";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function eliminar($codigo)
    {
        $sql = "DELETE FROM usuarios_sunat WHERE id='$codigo'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function modificar($variable_0, $variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6)
    {
        $variable_3=base64_encode($variable_3);
        $variable_4=base64_encode($variable_4);
        $variable_5=sha1($variable_5.'Desarrollador: Fernando Carmelo Mamani Blas - DNI: 43614667');

        
        $sql = "UPDATE usuarios_sunat SET nomcomercial='$variable_1', nomus='$variable_2', 
        clavus='$variable_3', clavcer='$variable_4',nomcer='$variable_6',token='$variable_5'
			 WHERE id='$variable_0'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function consultar($variable_1,$variable_2)
    {
        if (file_exists('../../json/' . $variable_1 .'-'.$variable_2. 'json')) {
            unlink('../../json/' . $variable_1 .'-'.$variable_2. '.json');
        }

        $sql = "SELECT * from usuarios_sunat
		WHERE rucempresa = '$variable_1'";
        $resultados = $this->conexion->conexion->query($sql);

        if ($resultados->num_rows > 0) {
            $lista = array(); //creamos un array
            while ($row = $resultados->fetch_array()) {
                $retorno_0 = $row['id'];
                $retorno_1 = $row['nomcomercial'];
                $retorno_2 = $row['nomus'];
                $retorno_3 = $row['clavus'];
                $retorno_4 = $row['nomcer'];
                $retorno_5 = $row['clavcer'];

                $lista[] = array('retorno_0' => $retorno_0,
                    'retorno_1' => $retorno_1,
                    'retorno_2' => $retorno_2,
                    'retorno_3' => $retorno_3,
                    'retorno_4' => $retorno_4,
                    'retorno_5' => $retorno_5,
                );

            }
			$this->conexion->cerrar();
        } else {
            $lista[] = array('retorno_0' => "0",
                'retorno_1' => "NNNNNNNN",
                'retorno_2' => "UUUUUUUU",
                'retorno_3' => "CCCCCCCC",
                'retorno_4' => "NC",
                'retorno_5' => "CC",
            );
        }

        //Creamos el JSON
        $json_string = json_encode($lista);
        $r[0] = $json_string;
        $file = '../../json/' . $variable_1 .'-'.$variable_2. '.json';
        file_put_contents($file, $json_string);

        return $r;
       
    }

}
