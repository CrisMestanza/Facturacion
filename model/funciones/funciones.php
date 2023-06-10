<?php

$evento=$_POST['evento'];

switch ($evento) {
	case 'salir':
	    session_start();
		session_destroy();
		echo "exito";
		break;

	
	default:
		# code...
		break;
}

?>