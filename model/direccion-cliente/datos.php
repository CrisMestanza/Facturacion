<?php 
	class Datos{

		private $conexion;
		public function __construct()
		{
			require_once('../conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

	
		function registrar($variable_0,$variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8){
           
			
             if($variable_7=='P'){
				//agregamos la direccion primaria -- variable 8 añadimos un nuevo dato
				$sqlNum="SELECT MAX(id) FROM clientes ";
				$result = $this->conexion->conexion->query($sqlNum);
				$row = mysqli_fetch_array($result);
				$variable_8 = $row[0];
			 }

			
			$sql="INSERT INTO direccion_cliente VALUES(0,'$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$variable_7','$variable_8')";

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
			$sql="DELETE FROM direccion_cliente WHERE id='$codigo'";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function modificar($variable_0,$variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8)
		{

			if($variable_7=='P'){
                $cw=" WHERE idcliente='$variable_8' and tipo='$variable_7'";//direccion primaria
			}else{
				$cw=" WHERE id='$variable_0'";
			}


			$sql="UPDATE direccion_cliente SET dir='$variable_1', 
			idpais='$variable_2', idubigeo='$variable_3',
			 email='$variable_4', urb='$variable_5', local_='$variable_6' " . $cw;


			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		
	
	}

	
?>