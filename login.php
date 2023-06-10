
<!DOCTYPE HTML>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

	<title>SIFO-LOGIN</title>
	<!-- Meta-Tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="keywords" content="Elite login Form a Responsive Web Template, Bootstrap Web Templates, Flat Web Templates, Android Compatible Web Template, Smartphone Compatible Web Template, Free Webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design">

	<!-- Stylesheets -->
	
    <link rel="stylesheet" href="css/bootstrap.3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="libs/select2/4.0.3/css/select2.min.css">
    <link href="css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="libs/font-awesome-4.7.0/css/font-awesome.min.css">
	 
	 <link href="css/style.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" href="css/miestilo.css">

	
	<!--// Stylesheets -->
	<!--fonts-->
	<div class="caja">
  		<h1 class="textoAnimado">
    		<span>B</span>
    		<span>i</span>
			<span>e</span>
			<span>n</span>
			<span>v</span>
			<span>e</span>
			<span>n</span>
			<span>i</span>
			<span>d</span>
			<span>o</span>
		</h1>
	</div>
	<!---728x90--->
	<div class="w3ls-login">
		<div class="img-vg">
			<img src="imagenes/Login/bg.svg">
		</div>
	<img class="wave" src="imagenes/Login/wave.png">
		<!-- form starts here -->
		<form action="#" method="post" class="form-login">
		<div id="img-perfil">
			<img src="imagenes/Login/perfil.png">
		</div>
      <div id="exito"></div>
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-user" aria-hidden="true"></i> Usuario:</label>
				<input type="text" id="a-user" placeholder=" "  />
			</div>
			<div class="agile-field-txt">
				<label>
					<i class="fa fa-lock" aria-hidden="true"></i> Contraseña:</label>
				<input type="password"  placeholder=" "  id="a-clave" />
				<div class="agile_label">
					<input id="check3" name="check3" type="checkbox" value="show password" onclick="myFunction()">
					<label class="check" for="check3">Mostrar Contraseña</label>
				</div>
			</div>
			<script>
				function myFunction() {
					var x = document.getElementById("a-clave");
					if (x.type === "password") {
						x.type = "text";
					} else {
						x.type = "password";
					}
				}
			</script>
			<!-- //script for show password -->
			<!---728x90--->
			<div class="w3ls-login  w3l-sub">
				<input id="ing-login" type="button" value="Iniciar Sessión">
			</div>
		</form>
	</div>
	<!-- //form ends here -->
	<!--copyright-->
	<!---728x90--->
	<div class="copy-wthree">
		<p>© 2023 Todos los derechos reservados  | Company "Los chamaquitos XD"
			<a href="javascript: loadmodal();" >Registrar Empresa</a>
		</p>
	</div>
	<!--//copyright-->

  <?php
   require 'modal-empresa.php';

   ?>

      <script type="text/javascript" src="js/jquery.3.4.1.min.js"></script>
	  
      <script type="text/javascript" src="js/bootstrap.3.4.1.min.js"> </script>
	  <script type="text/javascript" src="libs/select2/4.0.3/js/select2.min.js"></script>
      <script src="js/toastr.min.js"></script>
	  <script type="text/javascript" src="js/empresas.js"></script>
      <script type="text/javascript" src="js/login.js"></script>
      <script type="text/javascript" src="js/funciones.js"></script>
	  
</body>



</html>