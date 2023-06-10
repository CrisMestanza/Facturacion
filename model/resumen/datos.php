<?php 
	class Datos{

		private $conexion;
		public function __construct()
		{
			require_once('../conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

	
		function registrar($variable_1,$variable_2,$variable_3,$variable_4){
			$sql="INSERT INTO tb_cursos VALUES(0,'$variable_2','$variable_3','$variable_4')";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function eliminar($codigo){
			$sql="DELETE FROM tb_cursos WHERE id='$codigo'";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function modificar($variable_1,$variable_2,$variable_3,$variable_4)
		{

			$sql="UPDATE tb_cursos SET  codigo='$variable_2', detalle='$variable_3', idcategoria='$variable_4' WHERE id='$variable_1'";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function consultarclientes($variable_1){
          $sql = "SELECT id, detalle FROM codigos_productos
                  WHERE detalle LIKE '%".'$variable_1'."%'
                  LIMIT 10";
         $resultados = $this->conexion->conexion->query($sql);

          if ($resultados->num_rows > 0) { 
            $lista = array(); //creamos un array
          while($row = $resultados->fetch_array()) 
          { 
          $retorno_0=$row['id'];
          $retorno_2=$row['detalle'];

          $lista[] = array('retorno_0'=> $retorno_0, 
    	                   'retorno_2'=> $retorno_2,
                          );

           }

         //Creamos el JSON
          $json_string = json_encode($lista);
          $r[0]=$json_string;
          }else{
           $r[0]='Error';
        }

          return $r;
          $this->conexion->cerrar();
         } 

	
	}

	
?>