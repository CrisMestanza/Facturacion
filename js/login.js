var tipo=true;
window.onload = function () {
    LoadDepartamentos()
  };


$('#ing-login').on('click',function(){
    //recorrerTable()
    var user = $('#a-user').val();
    var clave = $('#a-clave').val();

    if (user=='') {
        showAlert("#exito","   Atención!!, Es necesario que ingrese su usuario !.", "danger", 2000, "glyphicon-info-sign")
    	$('#a-user').focus();
    	return false;
    }

     if (clave=='') {
        showAlert("#exito","   Atención!!, Es necesario que ingrese la clave !.", "danger", 2000, "glyphicon-info-sign")
    	$('#a-clave').focus();
    	return false;
    }

    $.ajax({
        url:'./model/usuarios/entidad.php',
        type:'POST',
        data:'variable_1='+user+'&variable_2='+clave+"&boton=ingresar"
    }).done(function(resp){
        alert(resp)
        if(resp=='exito'){
           location.href='index';
        }else{
            showAlert("#exito","   Atención!!, El usuario o clave son incorrectos!. ", "danger", 2000, "glyphicon-info-sign")
        }
        
    });


});