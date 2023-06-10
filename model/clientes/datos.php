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

    public function registrar($variable_1, $variable_2, $variable_3, $variable_4, $variable_5, $variable_6, $variable_7, $variable_8, $variable_9, $variable_10)
    {

        $sqlNum="SELECT MAX(id) FROM clientes ";
        $result = $this->conexion->conexion->query($sqlNum);
        $row = mysqli_fetch_array($result);
        $num=$row[0]+1;


        $sql = "INSERT INTO clientes VALUES($num,'$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$variable_7','$variable_8','$variable_9','P','$variable_10')";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function eliminar($codigo)
    {
        $sql = "DELETE FROM clientes WHERE id='$codigo'";
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
        $sql = "UPDATE clientes SET iddoc='$variable_1', doc='$variable_2', 
        nom='$variable_3', dir='$variable_4', idpais='$variable_5',
         idubigeo='$variable_6', email='$variable_7', urb='$variable_8' , local_='$variable_9' WHERE id='$variable_0'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function consultar_ID($variable_1, $variable_2)
    {

        $sqlNum="SELECT * FROM clientes WHERE doc='$variable_1' and nruc='$variable_2' ";
        $result = $this->conexion->conexion->query($sqlNum);
        $row = mysqli_fetch_array($result);
        $r[0]=$row[0];
        return $r;



    }

    public function consultar($variable_1, $variable_2)
    {
        if (file_exists('../../json/' . $variable_1 . '-' . $variable_2 . 'json')) {
            unlink('../../json/' . $variable_1 . '-' . $variable_2 . '.json');
        }

        $sql = "SELECT t1.id, t1.doc, t1.nom, t1.dir, t1.idpais, t1.idubigeo,
         t4.detalle as dpt, t3.detalle as prov, t2.detalle as dist, t1.email, 
         t1.urb, t1.local_ FROM clientes as t1
               INNER JOIN catalogo_13_dist as t2 on t2.id=t1.idubigeo
               INNER JOIN catalogo_13_prov as t3 on t3.id=t2.idprov
               INNER JOIN catalogo_13_dpt as t4 on t4.id=t3.iddpt
			   WHERE t1.nruc='$variable_1'";

        $resultados = $this->conexion->conexion->query($sql);

        if ($resultados->num_rows > 0) {
            $lista = array(); //creamos un array
            while ($row = $resultados->fetch_array()) {
                $retorno_0 = $row['id'];
                $retorno_1 = $row['doc'];
                $retorno_2 = $row['nom'];
                $retorno_3 = $row['dir'];
                $retorno_4 = $row['idpais'];
                $retorno_5 = $row['idubigeo'];
                $retorno_6 = $row['dpt'];
                $retorno_7 = $row['prov'];
                $retorno_8 = $row['dist'];
                $retorno_9 = $row['email'];
                $retorno_10 = $row['urb'];
                $retorno_11 = $row['local_'];

                $lista[] = array('retorno_0' => $retorno_0,
                    'retorno_1' => $retorno_1,
                    'retorno_2' => $retorno_2,
                    'retorno_3' => $retorno_3,
                    'retorno_4' => $retorno_4,
                    'retorno_5' => $retorno_5,
                    'retorno_6' => $retorno_6,
                    'retorno_7' => $retorno_7,
                    'retorno_8' => $retorno_8,
                    'retorno_9' => $retorno_9,
                    'retorno_10' => $retorno_10,
                    'retorno_11' => $retorno_11,
                );

            }
            $this->conexion->cerrar();
        } else {
            $lista[] = array('retorno_0' => "0",
                'retorno_1' => "RRRRRRRRRR",
                'retorno_2' => "NNNNNNNNNN",
                'retorno_3' => "DDDDDDDDDDDD",
                'retorno_4' => "PP",
                'retorno_5' => "UUUUUU",
                'retorno_6' => "DPT",
                'retorno_7' => "PROV",
                'retorno_8' => "DIST",
                'retorno_9' => "EEEEEEEE",
                'retorno_10' => "URB",
                'retorno_11' => "LLLL",
            );
        }
        //Creamos el JSON
        $json_string = json_encode($lista);
        $r[0] = $json_string;
        $file = '../../json/' . $variable_1 . '-' . $variable_2 . '.json';
        file_put_contents($file, $json_string);

        return $r;

    }

}
