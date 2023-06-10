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

			
			$sql="INSERT INTO direccion_empresa VALUES(0,'$variable_1','$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$variable_7','$variable_8')";

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
			$sql="DELETE FROM direccion_empresa WHERE id='$codigo'";
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
                $cw=" WHERE rucempresa='$variable_8' and tipo='$variable_7'";
			}else{
				$cw=" WHERE id='$variable_0'";
			}


			$sql="UPDATE direccion_empresa SET dir='$variable_1', 
			idpais='$variable_2', idubigeo='$variable_3',
			 telefono='$variable_4', urb='$variable_5', local_='$variable_6' " . $cw;


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