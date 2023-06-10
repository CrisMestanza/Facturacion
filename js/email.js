function loadEmail() {

  var cod= document.getElementById("n-codigo-doc").innerHTML+'-E';
      $.ajax({
        type: 'POST',
        data: 'codigo=' +cod,
        url: './model/email/editar.php',
        success: function (valores) {
          var datos = eval(valores);
          document.getElementById("b-correo").value = datos[1]
          document.getElementById("b-clave").value = datos[2]
          document.getElementById("b-clave2").value = datos[2]
          document.getElementById("b-servidor").value = datos[3]
          document.getElementById("b-puerto").value = datos[4]

          var g=datos[5];
          if (g==0){
            $('#b-html').bootstrapSwitch('state', false)
          }else if(g==1){
            $('#b-html').bootstrapSwitch('state', true)
          }

          var g=datos[6];
          if (g==0){
            $('#b-adjuntos').bootstrapSwitch('state', false)
          }else if(g==1){
            $('#b-adjuntos').bootstrapSwitch('state', true)
          }


          var g=datos[7];
          if (g==0){
            $('#b-ssl').bootstrapSwitch('state', false)
          }else if(g==1){
            $('#b-ssl').bootstrapSwitch('state', true)
          }


          document.getElementById("b-correo-envio").value = datos[8]
          document.getElementById("b-correo-cc").value = datos[9]
          document.getElementById("b-correo-cco").value = datos[10]
          document.getElementById("b-asunto").value = datos[11]
          document.getElementById("b-body").value = datos[12]
          document.getElementById("b-footer").value = datos[13]

  
        }
  
      });

  }


  
$('#btn-email').on('click', function(){
    var variable_0 = document.getElementById("b-correo").value 
    var variable_1 = document.getElementById("b-clave").value
    var variable_1_a = document.getElementById("b-clave2").value 
    var variable_2 = document.getElementById("b-servidor").value;
    var variable_3 = document.getElementById("b-puerto").value 
    var variable_4 = ch(document.getElementById("b-html").checked);
    var variable_5 = ch(document.getElementById("b-adjuntos").checked);
    var variable_6 = ch(document.getElementById("b-ssl").checked);
    var variable_7 = document.getElementById("b-correo-envio").value
    var variable_8 = document.getElementById("b-correo-cc").value
    var variable_9 = document.getElementById("b-correo-cco").value
    var variable_10 = document.getElementById("b-asunto").value
    var variable_11= document.getElementById("b-body").value
    var variable_12= document.getElementById("b-footer").value
    var variable_13= ch(document.getElementById("b-email-p").checked);
    var variable_14=  document.getElementById("n-codigo-doc").innerHTML;



    if (variable_0=='') {
        showAlert("#exito-e","  Espere!!, Ingrese el correo!", "success", 2000, " ti-pencil-alt");
        $('#b-correo').focus();
        return false;
    }

    if (variable_1=='') {
        showAlert("#exito-e","  Espere!!, Ingrese la clave!", "success", 2000, " ti-pencil-alt");
        $('#b-clave').focus();
        return false;
    }

    if (variable_1_a=='') {
        showAlert("#exito-e","  Espere!!, Confirme la clave!", "success", 2000, " ti-pencil-alt");
        $('#b-clave2').focus();
        return false;
    }

    if (variable_1==variable_1_a) {

    }else{
        showAlert("#exito-e","  Espere!!, Las constraseñas no son iguales!", "success", 2000, " ti-pencil-alt");
        $('#b-clave').focus();
        return false;
        
    }

    if (variable_2=='') {
        showAlert("#exito-e","  Espere!!, Ingrese el Servidor del email", "success", 2000, " ti-pencil-alt");
        $('#b-servidor').focus();
        return false;
    }

    if (variable_3=='') {
        showAlert("#exito-e","  Espere!!, Ingrese el Puerto del email", "success", 2000, " ti-pencil-alt");
        $('#b-puerto').focus();
        return false;
    }

    if (variable_10=='') {
        showAlert("#exito-e","  Espere!!, Ingrese el Asunto del email", "success", 2000, " ti-pencil-alt");
        $('#b-asunto').focus();
        return false;
    }

    if (variable_11=='') {
        showAlert("#exito-e","  Espere!!, Ingrese el Body del email", "success", 2000, " ti-pencil-alt");
        $('#b-body').focus();
        return false;
    }


    if (variable_12=='') {
        showAlert("#exito-e","  Espere!!, Ingrese el Footer del email", "success", 2000, " ti-pencil-alt");
        $('#b-footer').focus();
        return false;
    }

    $.ajax({
        url:'./model/email/entidad.php',
        type:'POST',
        data:'variable_0='+variable_0+'&variable_1='+variable_1+'&variable_2='+variable_2+'&variable_3='+variable_3+'&variable_4='+variable_4+'&variable_5='+variable_5+'&variable_6='+variable_6+'&variable_7='+variable_7+'&variable_8='+variable_8+'&variable_9='+variable_9+'&variable_10='+variable_10+'&variable_11='+variable_11+'&variable_12='+variable_12+'&variable_13='+variable_13+'&variable_14='+variable_14+"&boton=registrar"
    }).done(function(resp){
      alert(resp)
        if(resp=='exito'){
         $("#myModal4").modal("hide"); 

           Command: toastr["success"]("En Buena Hora!, El registro se guardo con Exito!")

        }else{
          Command: toastr["error"]("El registro no se guardo, vuelvalo a intentar !")

        }
        
    });
   
});

$('#btn-email-test').on('click', function(){
  var variable_0 = document.getElementById("b-correo").value 
  var variable_1 = document.getElementById("b-clave").value
  var variable_1_a = document.getElementById("b-clave2").value 
  var variable_2 = document.getElementById("b-servidor").value;
  var variable_3 = document.getElementById("b-puerto").value 
  var variable_4 = ch(document.getElementById("b-html").checked);
  var variable_5 = ch(document.getElementById("b-adjuntos").checked);
  var variable_6 = ch(document.getElementById("b-ssl").checked);
  var variable_7 = document.getElementById("b-correo-envio").value
  var variable_8 = document.getElementById("b-correo-cc").value
  var variable_9 = document.getElementById("b-correo-cco").value
  var variable_10 = document.getElementById("b-asunto").value
  var variable_11= document.getElementById("b-body").value
  var variable_12= document.getElementById("b-footer").value
  var variable_13= ch(document.getElementById("b-email-p").checked);
  var variable_14=  document.getElementById("n-codigo-doc").innerHTML;



  if (variable_0=='') {
      showAlert("#exito-e","  Espere!!, Ingrese el correo!", "success", 2000, " ti-pencil-alt");
      $('#b-correo').focus();
      return false;
  }

  if (variable_1=='') {
      showAlert("#exito-e","  Espere!!, Ingrese la clave!", "success", 2000, " ti-pencil-alt");
      $('#b-clave').focus();
      return false;
  }

  if (variable_1_a=='') {
      showAlert("#exito-e","  Espere!!, Confirme la clave!", "success", 2000, " ti-pencil-alt");
      $('#b-clave2').focus();
      return false;
  }

  if (variable_1==variable_1_a) {

  }else{
      showAlert("#exito-e","  Espere!!, Las constraseñas no son iguales!", "success", 2000, " ti-pencil-alt");
      $('#b-clave').focus();
      return false;
      
  }

  if (variable_2=='') {
      showAlert("#exito-e","  Espere!!, Ingrese el Servidor del email", "success", 2000, " ti-pencil-alt");
      $('#b-servidor').focus();
      return false;
  }

  if (variable_3=='') {
      showAlert("#exito-e","  Espere!!, Ingrese el Puerto del email", "success", 2000, " ti-pencil-alt");
      $('#b-puerto').focus();
      return false;
  }

  if (variable_10=='') {
      showAlert("#exito-e","  Espere!!, Ingrese el Asunto del email", "success", 2000, " ti-pencil-alt");
      $('#b-asunto').focus();
      return false;
  }

  if (variable_11=='') {
      showAlert("#exito-e","  Espere!!, Ingrese el Body del email", "success", 2000, " ti-pencil-alt");
      $('#b-body').focus();
      return false;
  }


  if (variable_12=='') {
      showAlert("#exito-e","  Espere!!, Ingrese el Footer del email", "success", 2000, " ti-pencil-alt");
      $('#b-footer').focus();
      return false;
  }

  $.ajax({
      url:'./dsig/Email/mail_test.php',
      type:'POST',
      data:'variable_0='+variable_0+'&variable_1='+variable_1+'&variable_2='+variable_2+'&variable_3='+variable_3+'&variable_4='+variable_4+'&variable_5='+variable_5+'&variable_6='+variable_6+'&variable_7='+variable_7+'&variable_8='+variable_8+'&variable_9='+variable_9+'&variable_10='+variable_10+'&variable_11='+variable_11+'&variable_12='+variable_12+'&variable_13='+variable_13+'&variable_14='+variable_14+"&boton=registrar"
  }).done(function(resp){
    
      if(resp=='exito'){

         Command: toastr["success"]("En Buena Hora!, El Correo de prueba se envio con Exito!")

      }else{
        Command: toastr["error"]("Error , " + resp)

      }
      
  });
 
});