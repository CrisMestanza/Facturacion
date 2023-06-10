
function LoadTicket_e() {

  var ticket = document.getElementById('ticket-baja').innerHTML;


  document.getElementById('cod-baja').style.display = "none";
  document.getElementById('a-com_baj').style.display = "none";
  document.getElementById('btn-baja-e').disabled = true;
  document.getElementById('btn-ticket-e').disabled = true;
  document.getElementById('rpta-baja').style.display = "block";




  var cpe = document.getElementById('cod-baja').innerHTML;

  Consultar_Ticket(cpe,ticket);
  
}


function LoadBaja_e() {
  var f = new Date();

  var fecha = updatedia(f.getDate()) + "/" + updatemes(f.getMonth() + 1) + "/" + f.getFullYear();

  var cpe = document.getElementById('cod-baja').innerHTML;

  V_Ruc = cpe.substring(0, 11);
  V_Tipo = cpe.substring(12, 14)
  V_Serie = cpe.substring(15, 19)
  V_Numero = cpe.substring(20, 28)

  //-------------Cabezera Individual----------------//
  var miObjeto = new Object();
  miObjeto.tipDocBaja = V_Tipo;
  miObjeto.serDocBaja = V_Serie;
  miObjeto.numDocBaja = V_Numero;
  miObjeto.fecGeneracion = conversionfecha(fecha)
  miObjeto.fecComunicacion = conversionfecha(fecha)
  miObjeto.desMotivoBaja = document.getElementById('a-com_baj').value;
  miObjeto.numLote = 1;


  //parametros paar enviara  sunat
  var myString = JSON.stringify(miObjeto);
  var myString = forceUnicodeEncoding(myString);
  document.getElementById('cod-baja').style.display = "none";
  document.getElementById('a-com_baj').style.display = "none";
  document.getElementById('btn-baja-e').disabled = true;

  var img = document.createElement("img");
  img.src = "imagenes/spinner.gif";
  img.setAttribute("id", "img-baja");
  var foo = document.getElementById("div-baja");
  foo.appendChild(img);

  $.ajax({
    url: "./dsig/Token/Authorization.php",
    type: "POST",
    data:
      "Login=" + cpe.substring(0, 11) +
      "&EnviarLista=Off" +
      "&Puerto=A" +
      "&Json=" +
      myString,
  }).done(function (respuesta) {
    var ultimo = document.getElementById('img-baja');
    foo.removeChild(ultimo);
    try {

      var aMyUTF8Output = base64DecToArr(respuesta);
      var sMyOutput = UTF8ArrToStr(aMyUTF8Output);
      //alert( sMyOutput)
      var data = JSON.parse(sMyOutput);

      document.getElementById('rpta-baja').style.display = "block";
      let obj = data[0].Ticket
      document.getElementById('rpta-baja').innerHTML = "Consultando N° Ticket : " + obj["0"].trim();
      Consultar_Ticket(cpe,obj["0"].trim())//Consultamos el ticker recibido
    } catch (error) {
      //aqio es donde genera un error en el firmado o el envio a sunat
      Registro_errores_ticket(cpe, respuesta);

      document.getElementById('rpta-baja').style.display = "block";
      document.getElementById('rpta-baja').innerHTML = "No se envio a sunat la Anulación , Revise los Errores " ;
 
      
    }
  });

}

function Consultar_Ticket(cpe,ticket){

  var img2 = document.createElement("img");
  img2.src = "imagenes/spinner.gif";
  img2.setAttribute("id", "img-baja2");
  var foo2 = document.getElementById("div-baja");
  foo2.appendChild(img2);
  
  $.ajax({
    url: "./dsig/Token/Authorization.php",
    type: "POST",
    data:
      "Login=" + cpe.substring(0, 11) +
      "&EnviarLista=" + ticket +
      "&Puerto=T" +
      "&Json=",
  }).done(function (respuesta) {
    var ultimo = document.getElementById('img-baja2');
    foo2.removeChild(ultimo);
    try {
      var aMyUTF8Output = base64DecToArr(respuesta);
      var sMyOutput = UTF8ArrToStr(aMyUTF8Output);

      if(parseInt(sMyOutput)==0){   
        document.getElementById('rpta-baja').innerHTML = "N° Ticket : " + ticket +", Anulación Procesada con Exito";
        Registro_ticket(cpe,ticket,1)
      }else if(parseInt(sMyOutput)==98){
        document.getElementById('rpta-baja').innerHTML = "N° Ticket : " + ticket +", En proceso la Anulación ";
        Registro_ticket(cpe,ticket,2)
      }else if(parseInt(sMyOutput)==99){
        document.getElementById('rpta-baja').innerHTML = "N° Ticket : " + ticket +", Anulación Rechazada ";
        Registro_ticket(cpe,ticket,0)
      }else{
        document.getElementById('rpta-baja').innerHTML = "Código de respuesta Sunat: "+sMyOutput ;
        Command: toastr["info"](
          " Espere!!, Código de respuesta Sunat: "  )

      }

      Registro_errores_ticket(cpe," ");
      ReloadTabla()
    } catch (error) {
   
      //aqio es donde genera un error en el firmado o el envio a sunat
      Registro_errores_ticket(cpe,ticket);

      
    }
  });
  
}

function Registro_errores_ticket(cpe, respuesta) {
  $.ajax({
    url: "./model/001/entidad.php",
    type: "POST",
    data:
      "codigo=" +
      cpe +
      "&error=" +
      respuesta +
      "&boton=mod-error-ticket",
  }).done(function (resp) {
    
  });
}

function Registro_ticket(cpe, ticket,status) {

  $.ajax({
    url: "./model/001/entidad.php",
    type: "POST",
    data:
      "codigo=" +
      cpe +
      "&ticket=" +
      ticket +
      "&status=" +
      status +
      "&boton=ticket",
  }).done(function (resp) {

  });
}

  function cerrar_baja() {

    document.getElementById('cod-baja').style.display = "block";
    document.getElementById('a-com_baj').style.display = "block";
    document.getElementById('btn-baja-e').disabled = false;
    document.getElementById('rpta-baja').style.display = "none";
    $("#myModal-baja").modal("hide");
  }

