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

    public function registrar($variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6, $variable_7, $variable_8, $variable_9, $variable_12)
    {
        $sql = "INSERT INTO items VALUES(0,'$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$variable_7','$variable_8','$variable_9','$variable_12')";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function eliminar($codigo)
    {
        $sql = "DELETE FROM items WHERE id='$codigo'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function modificar($variable_0, $variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6, $variable_7, $variable_8, $variable_9)
    {
        $pass = sha1($variable_3);
        $sql = "UPDATE items SET cod='$variable_1', idsunat='$variable_2', 
        detalle='$variable_3', idunidad='$variable_4', 
        cat7='$variable_5', igv='$variable_6', valor='$variable_7',
         impuesto='$variable_8' , descuento='$variable_9' WHERE id='$variable_0'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function consultar($variable_1, $variable_2)
    {
        if (file_exists('../../json/' . $variable_1 .'-'.$variable_2 . 'json')) {
            unlink('../../json/' .$variable_1 .'-'.$variable_2. '.json');
        }

        $sql = "SELECT t1.id,t1.cod, t1.idsunat,t1.detalle,t1.idunidad,t1.cat7,t1.igv
        ,t1.valor,t1.impuesto,t1.descuento,t1.nruc,t2.detalle as detunidad, 
        ucase(t3.detalle) as detope, t4.detalle as detsunat from items as t1
        INNER JOIN catalogo_03 AS t2 on t2.id = t1.idunidad
        INNER JOIN catalogo_07 AS t3 on t3.id = t1.cat7
        INNER JOIN codigos_productos AS t4 on t4.id = t1.idsunat
         WHERE nruc='$variable_1' ";

        $resultados = $this->conexion->conexion->query($sql);

        if ($resultados->num_rows > 0) {
            $lista = array(); //creamos un array
            while ($row = $resultados->fetch_array()) {
                $retorno_0 = $row['id'];
                $retorno_1 = $row['cod'];
                $retorno_2 = $row['detsunat'];
                $retorno_3 = $row['detalle'];
                $retorno_4 = $row['idunidad']. ' - '.$row['detunidad'];
                $retorno_5 =  $row['cat7']. ' - '.$row['detope'];
                $retorno_6 = $row['precio'];
                $retorno_7 = $row['valor'];

                $lista[] = array('retorno_0' => $retorno_0,
                    'retorno_1' => $retorno_1,
                    'retorno_2' => $retorno_2,
                    'retorno_3' => $retorno_3,
                    'retorno_4' => $retorno_4,
                    'retorno_5' => $retorno_5,
                    'retorno_6' => $retorno_6,
                    'retorno_7' => $retorno_7,
                );

            }
			$this->conexion->cerrar();
        } else {
			$lista[] = array('retorno_0' => "0",
			'retorno_1' => "CCCCC",
			'retorno_2' => "SSSSSSSS",
			'retorno_3' => "DDDDDDDDDD",
			'retorno_4' => "UU",
			'retorno_5' => "OP",
			'retorno_6' => "0.00",
			'retorno_7' => "0.00",
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
