<?php 
	class Datos{

		private $conexion;
		public function __construct()
		{
			require_once('../conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

		function identificar($variable_1,$variable_2)
		{
			$variable_2=base64_encode($variable_2);
			$sql="SELECT t1.id,t2.correo,t1.clave,t2.ruc,t1.estado from tb_usuarios as t1
			inner join tb_registros as t2 on t2.id=t1.idregistro
			  WHERE t2.correo='$variable_1' and t1.clave='$variable_2' and t1.estado=1";

			$resulatdos = $this->conexion->conexion->query($sql);
			if ($resulatdos->num_rows > 0) {
				$r=$resulatdos->fetch_array();
				}
			else{
				$r[0]=0;
			}
			return $r;
			$this->conexion->cerrar();
		}

	
		function registrar($variable_1,$variable_2,$variable_3,$variable_4){
			$variable_1= base64_encode($variable_1);
			$sql="INSERT INTO tb_usuarios VALUES(0,'$variable_1','$variable_2','$variable_3','$variable_4')";
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
			$sql="DELETE FROM tb_usuarios WHERE id='$codigo'";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function modificar($variable_0,$variable_1,$variable_2,$variable_3,$variable_4)
		{
			$variable_1= base64_encode($variable_1);
			if (is_numeric($variable_0)) {
				$sql="UPDATE tb_usuarios SET  clave='$variable_1', idregistro='$variable_2',
				estado='$variable_3', correo='$variable_4' WHERE id='$variable_0'";
			}else{
				$sql="UPDATE tb_usuarios SET  clave='$variable_1'
				 WHERE correo='$variable_4'";
			}

			
		
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function consultar($variable_1,$variable_2){
		if (file_exists('../../json/webusuarios.json')) {
              unlink('../../json/webusuarios.json');
        } else {
      
        }
   
         $sql="SELECT * FROM tb_usuarios";

         $resultados = $this->conexion->conexion->query($sql);

          if ($resultados->num_rows > 0) { 
            $lista = array(); //creamos un array
          while($row = $resultados->fetch_array()) 
          { 
          $retorno_0=$row['id'];
          $retorno_1=$row['apnom'];
          $retorno_2=$row['correo'];
          $retorno_3=$row['clave'];
          $retorno_4=$row['tipo'];
          $retorno_5=$row['img'];
          $retorno_6=$row['estado'];

          $lista[] = array('retorno_0'=> $retorno_0, 
    	                   'retorno_1'=> $retorno_1,
                           'retorno_2'=> $retorno_2,
                           'retorno_3'=> $retorno_3,
                           'retorno_4'=> $retorno_4,
                           'retorno_5'=> $retorno_5,
                           'retorno_6'=> $retorno_6,
                          );

           }

         //Creamos el JSON
          $json_string = json_encode($lista);
          $r[0]=$json_string;
          $file = '../../json/webusuarios.json';
          file_put_contents($file, $json_string);
          }else{
           $r[0]='Error';
        }

          return $r;
          $this->conexion->cerrar();
         } 

	
	}

	
?>