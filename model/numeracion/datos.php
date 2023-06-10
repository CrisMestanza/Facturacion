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

    public function registrar($variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6)
    {
        $sql = "INSERT INTO numeracion VALUES(0,'$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6')";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function eliminar($codigo)
    {
        $sql = "DELETE FROM numeracion WHERE id='$codigo'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function modificar($variable_0, $variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6)
    {

        $sql = "UPDATE numeracion SET serie='$variable_1', numero='$variable_2', iddir='$variable_3',
			cat1='$variable_4',ruc_numser='$variable_5'
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
        if (file_exists('../../json/' .$variable_1 .'-'.$variable_2.  'json')) {
            unlink('../../json/' . $variable_1 .'-'.$variable_2.  '.json');
        }

        $sql = "SELECT t1.id,t1.serie,t1.numero,t2.detalle,
        concat(t3.dir,' ', t6.detalle,' - ',t5.detalle,' - ',t4.detalle) as dir 
        FROM numeracion AS t1
                INNER JOIN catalogo_01 as t2 on t2.id=t1.cat1
                INNER JOIN direccion_empresa as t3 on t3.id =t1.iddir
                INNER JOIN catalogo_13_dist as t4 on t4.id =t3.idubigeo
                INNER JOIN catalogo_13_prov as t5 on t5.id =t4.idprov
                INNER JOIN catalogo_13_dpt as t6 on t6.id =t5.iddpt        
		WHERE t1.nruc='$variable_1'";
        $resultados = $this->conexion->conexion->query($sql);

        if ($resultados->num_rows > 0) {
            $lista = array(); //creamos un array
            while ($row = $resultados->fetch_array()) {
                $retorno_0 = $row['id'];
                $retorno_1 = $row['serie'];
                $retorno_2 = $row['numero'];
                $retorno_3 = $row['detalle'];
                $retorno_4 = $row['dir'];

                $lista[] = array('retorno_0' => $retorno_0,
                    'retorno_1' => $retorno_1,
                    'retorno_2' => $retorno_2,
                    'retorno_3' => $retorno_3,
                    'retorno_4' => $retorno_4,
                );

            }
			$this->conexion->cerrar();
        } else {
            $lista[] = array('retorno_0' => "0",
                'retorno_1' => "SSSS",
                'retorno_2' => "NNNNNNNN",
                'retorno_3' => "CC",
                'retorno_4' => "DDDDDDDDDDDD",
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
