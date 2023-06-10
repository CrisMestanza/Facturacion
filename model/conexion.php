<?php
require_once('global.php');
class conexion
	{
		private $servidor;
		private $usuario;
		private $clave;
		private $basedatos;
		public  $conexion;

		public function __construct(){
			$this->servidor  = DB_HOST;
			$this->usuario   = DB_USERNAME;
			$this->clave= DB_PASSWORD;
			$this->basededatos  = DB_NAME;

		}

		function conectar(){
			$this->conexion= new mysqli($this->servidor,$this->usuario,$this->clave,$this->basededatos);
			mysqli_set_charset($this->conexion,"utf8");
		}

		function cerrar(){
			$this->conexion->close();
		}
	}

	function conectar(){

		$mysqli= new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
		if (mysqli_connect_errno())
		  {
		   echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		   mysqli_set_charset($mysqli,"utf8");
		   return $mysqli;
	 }
	 
?>