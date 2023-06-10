var timeoutID;
var timeoutID2;
var timeoutId1;
var timeoutId2;

var contador;
function EnvioSUNAT(myString, cpe, envio, EnviarLista) {

  $.ajax({
    url: "./dsig/Token/Authorization.php",
    type: "POST",
    data:
      "Login=" + cpe.substring(0, 11) +
      "&EnviarLista=" + EnviarLista +
      "&Puerto=F" +
      "&Json=" +
      myString,
  }).done(function (respuesta) {
    alert(respuesta)
            var aMyUTF8Output = base64DecToArr(respuesta);
      var sMyOutput = UTF8ArrToStr(aMyUTF8Output);

    if (respuesta.trim() == "No se registro") {
      swal(
        "Errores !",
        "El número de comprobante electrónico esta duplicado ó esta envianado información a la base de datos !",
        "error"
      );

      CerrarVentana(EnviarLista);
      return false;

    }


    if (EnviarLista == "Off") {

      var variable_1 = document.getElementById('n-codigo').innerHTML;
      if (variable_1.trim() != '' && variable_1.trim() != 0) {

      } else {
        LoadNumeracion();
      }

    }

    try {
      //Respúesta del api en formato JSON
      var aMyUTF8Output = base64DecToArr(respuesta);
      var sMyOutput = UTF8ArrToStr(aMyUTF8Output);
    
      var data = JSON.parse(sMyOutput);
     
      if (data[0].BaseDatos == "Registrado") {
        //aqui se cierre el modal porque solo s firmo el xml y no esta generado el CDR : ENVIO =FALSE
        if (envio == false) {
          $("#myModal2").modal("hide");
          swal("En Buena Hora!", "El registro se guardo y Firmo el XML del Comprobante Electrónico con Exito!", "info");
        } else {
          Registro_errores(cpe, "", 1, false)
          swal("En Buena Hora!", "El registro se guardo y Envío el Comprobante Electrónico a SUNAT con Exito!", "success");
        }

        document.getElementById("a-cpe-correo").value = cpe;//correo electronico
        LimpiarTabla(EnviarLista)
        LoadPdf(cpe);
      } else {
        swal(
          "Error !",
          "El registro no puede leer la respuesta del servidor, cierre la aplicación !",
          "error"
        );
      }
    } catch (error) {
      //aqio es donde genera un error en el firmado o el envio a sunat
      Registro_errores(cpe, respuesta, 2, EnviarLista, true);
      return false;
    }



  });

  window.clearTimeout(timeoutID);



}

function Registro_errores(cpe, respuesta, estadoCDR, EnviarLista, msj) {
  $.ajax({
    url: "./model/001/entidad.php",
    type: "POST",
    data:
      "codigo=" +
      cpe +
      "&error=" +
      respuesta +
      "&cdr=" +
      estadoCDR +
      "&boton=mod-error",
  }).done(function (resp) {
    if (msj == true) {
      if (resp == "exito") {

        Command: toastr["info"](
          "En Buena Hora!, El registro  se guardo , pero no se envio el Comprobante Electrónico a SUNAT!"
        );

      } else {
        Command: toastr["error"](
          "El registro del Error de envío no se registro, vuelvalo a intentar !"
        );
      }
      CerrarVentana(EnviarLista);
    }
    
  });


 
}

function BuscarCDR1(cpe) {

  if (contador > 20) {

    //cerrar el Temporizador de 1 minuto
    // timeoutID2 = window.setTimeout(CerrarTemp, 60000);
    document.getElementById('btn-cerrar').style.display = 'block';

  }

  timeoutId1 = setTimeout(function () {
    //alert("Hola Mundo1");
    $.ajax({
      url: "./archivos.php",
      type: "POST",
      data:
        "cpe=" + cpe,
    }).done(function (respuesta) {
      //  alert(respuesta.trim())
      if (respuesta.trim() == "On") {
        clearTimeout(timeoutId1);

        $('#myModal2').on('hidden.bs.modal', function () {
          if (document.getElementById('envios-cpe').innerHTML == 1) {
            ReloadTabla();
          }
        });


        $("#myModal2").modal("hide");

      } else {
        BuscarCDR2(cpe);
      }
    });

    contador = contador + 1;
  }, 2000);
}

function BuscarCDR2(cpe) {
  timeoutId2 = setTimeout(function () {
    //alert("Hola Mundo2");
    $.ajax({
      url: "./archivos.php",
      type: "POST",
      data:
        "cpe=" + cpe,
    }).done(function (respuesta) {
      //  alert(respuesta.trim())
      if (respuesta.trim() == "On") {
        clearTimeout(timeoutId2);
        $('#myModal2').on('hidden.bs.modal', function () {
          if (document.getElementById('envios-cpe').innerHTML == 1) {
            ReloadTabla();
          }
        });
        $("#myModal2").modal("hide");

      } else {
        BuscarCDR1(cpe);
      }
    });
    contador = contador + 1;
  }, 2000);

}

function CerrarTemp() {
  window.clearTimeout(timeoutID2);
  swal(
    "Error !",
    "El comprobante electrónico no se pudo enviar, revise los errores o vuelva a enviar !",
    "error"
  );
  CerrarVentana();

}

function CerrarVentana(EnviarLista) {


  timeoutId3 = setTimeout(function () {
    $("#myModal2").modal("hide");
    if (EnviarLista == "Off") {
      location.href = './facturacion';
    } else if (EnviarLista == "On") {
      location.href = './listadoCpe';
    }

  }, 4000);
}




function LoadPdf(cpe) {

  V_Ruc = cpe.substring(0, 11);
  V_Tipo = cpe.substring(12, 14)
  V_Serie = cpe.substring(15, 19)
  V_Numero = cpe.substring(20, 28)

  VisualizarPDF(V_Ruc + '-' + V_Tipo + '-' + V_Serie + '-' + V_Numero);

}

function formatearnum(a) {

  var m = document.getElementById("a-moneda");
  mon = m.options[m.selectedIndex].text;

  if (mon == "S/") {
    var n = a.replace("S/", ""); a.substr(0, 2);
  } else {
    var n = a.replace("$USD", "");
  }


  var x = parseFloat(n);
  return x.toFixed(2);
}

function LimpiarTabla(EnviarLista){

  if (EnviarLista == "Off") {
  $('#a-fecha-v').val('')
  $('#a-dias').val('')
  $('#a-tc').val('0.00')
  $('#a-moneda').val('PEN')
  $('#a-obs').val('')
  $('#a-pago').val('01')
  $('#detalle-factura').html('');
  sumatoriasDetalle();
  $('#a-tipocomp').focus()
  }
}


