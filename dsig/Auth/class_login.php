<?php 
	class tabla{
		private $conexion;
		public function __construct()
		{
			require_once('../../model/conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}


		function identificar($ruc,$key){
			//$pass=sha1($key);
			$sql="SELECT t1.rucempresa,t1.token,t3.correo,t3.clave, t3.estado from  usuarios_sunat as t1
			INNER JOIN tb_registros as t2 on t2.ruc = t1.rucempresa
			INNER JOIN tb_usuarios as t3 on t3.idregistro = t2.id
                   WHERE t1.rucempresa ='$ruc' AND t1.token='$key'";

			$resultados = $this->conexion->conexion->query($sql);
			if ($resultados->num_rows > 0) {
				$r=$resultados->fetch_array();
				}
			else{
				$r[0]=7;
			}
			return $r;
			$this->conexion->cerrar();
		}

	}
?>