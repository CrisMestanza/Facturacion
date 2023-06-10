let detalle;
var rucEmisor;

window.onload = function () {

document.getElementById('gravada').innerHTML = "0.00";
document.getElementById('inafecta').innerHTML = "0.00";
document.getElementById('exonerada').innerHTML = "0.00";
document.getElementById('gratuita').innerHTML = "0.00";
document.getElementById('igv').innerHTML = "0.00";
document.getElementById('otros').innerHTML = "0.00";
document.getElementById('descuentos').innerHTML = "0.00";
document.getElementById('total').innerHTML = "0.00";
document.getElementById("a-tc").value = "0.00";
document.getElementById("a-tc").readOnly = true;
$("#btn-refrescar").hide();

};


function dat_consulta() {
  rucEmisor = document.getElementById("n-codigo-doc").innerHTML;
}



//Funciones de agregado
$('#btn-add').click(function () {

  $('#myModal-Detalle').on('shown.bs.modal', function () {
    $('#a-detalle-d').focus();
  });

  $("#myModal-Detalle").modal("show");

  $('#myModal-Detalle').on('hidden.bs.modal', function (e) {
    document.getElementById("btn-update").style.display = 'none';
    document.getElementById("add-detalle").style.display = 'block';
    limpiar();
  })
}
);


$('#add-detalle').click(function () {
  //	var valor=document.getElementById("a-codigo-d").value;
  //	var valor1=document.getElementById("a-movimiento-d").checked;
  var valor2 = document.getElementById("a-detalle-d").value;
  var valor3 = document.getElementById("a-tributo-d").value;
  var valor4 = document.getElementById("a-cantidad-d").value;
  var valor5 = document.getElementById("a-subtotal-d").value;
  var valor6 = document.getElementById("a-igv-d").value;
  var valor7 = document.getElementById("a-precio-d").value;


  if (valor2 == '') {
    showAlert("#exito-a", "   Atención!!, Edite el detalle!.", "success", 2000, "glyphicon-pencil")
    document.getElementById("a-detalle-d").focus();
    return false;
  }

  if (valor3 == '') {
    showAlert("#exito-a", "   Atención!!, Seleccione el tributo!.", "success", 2000, "glyphicon-pencil")
    document.getElementById("a-tributo-d").focus();
    return false;
  }

  if (valor4 == '') {
    showAlert("#exito-a", "   Atención!!, Edite la cantidad!.", "success", 2000, "glyphicon-pencil")
    document.getElementById("a-cantidad-d").focus();
    return false;
  }

  if (valor5 == '') {
    showAlert("#exito-a", "   Atención!!, Edite el Importe!.", "success", 2000, "glyphicon-pencil")
    document.getElementById("a-valor-d").focus();
    return false;
  }

  if (valor6 == '') {
    showAlert("#exito-a", "   Atención!!, Edite el Igv!.", "success", 2000, "glyphicon-pencil")
    document.getElementById("a-igv-d").focus();
    return false;
  }

  if (valor7 == '') {
    showAlert("#exito-a", "   Atención!!, Edite el Precio Total!.", "success", 2000, "glyphicon-pencil")
    document.getElementById("a-precio-d").focus();
    return false;
  }

  Agregar();

}
);



function Agregar() {
  // declare variable
    var _0 = $("#a-detalle-d").val();
  //Consultamos algunos datos antes de generar el JSON
      var _1 = $('input[name="1"]').val();
      var detalle = document.getElementById("a-detalle-d");
      var _2 = detalle.options[detalle.selectedIndex].text;
      var _3 = $('input[name="3"]').val();
      var _4 = $('input[name="4"]').val();

      var vuni = $('input[name="13"]').val();
      var subtotal = $('input[name="5"]').val();
      var igv = $('input[name="6"]').val();
      var preciovta = $('input[name="7"]').val();
      var valorvta = $('input[name="8"]').val();

      var _5 = parseFloat(subtotal).toFixed(2);
      var _6 = parseFloat(igv).toFixed(2);
      var _7 = parseFloat(preciovta).toFixed(2);
      var _8 = parseFloat(valorvta).toFixed(2);

      var _9 = $('input[name="9"]').val();
      var _10 = $('input[name="10"]').val();
      var _11 = $('input[name="11"]').val();
      var _12 = $('input[name="12"]').val();

      //---- Precio Unitario----//
      var tipoIgv = $("#a-tipo-d").val();
      if (tipoIgv == 0) {
        var vuni = preciovta / _4;
      }
      var _13 = parseFloat(vuni).toFixed(6);

      var _tr =
        '<tr><td><button  type="button" class="btn-xs btn-info btn-edit"><span class="glyphicon glyphicon-pencil"></span></button></td> <td><button type="button" class="btn-xs btn-danger btn-delete"><span class="glyphicon glyphicon-remove"></button></td><td  style="display:none;">' +
        _0 +
        '</td>	<td class="text-left">' +
        _1 +
        '</td>	<td class="text-left">' +
        _2 +
        '</td>	<td class="text-center">' +
        _3 +
        '</td>	<td class="text-center">' +
        _4 +
        '</td><td class="text-right">' +
        _13 +
        '</td> <td class="text-right">' +
        _5 +
        '</td> <td class="text-right">' +
        _6 +
        '</td>	<td class="text-right">' +
        _7 +
        '</td><td  style="display:none;">' +
        _8 +
        '</td><td  style="display:none;">' +
        _9 +
        '</td><td  style="display:none;">' +
        _10 +
        '</td><td  style="display:none;">' +
        _11 +
        '</td><td  style="display:none;">' +
        _12 +
        "</td></tr>";

      $("#detalle-factura").append(_tr);
      showAlert(
        "#exito-a",
        "   Atención!!,  Registro Agregado con Exito.. !.",
        "success",
        2000,
        "glyphicon-ok"
      );
      sumatoriasDetalle();
      limpiar();

}

var _trEdit = null;
$(document).on('click', '.btn-edit', function () {
  _trEdit = $(this).closest('tr');

  var _0 = $(_trEdit).find('td:eq(2)').text();
  var _1 = $(_trEdit).find('td:eq(3)').text();
  var _2 = $(_trEdit).find('td:eq(4)').text();
  var _3 = $(_trEdit).find('td:eq(5)').text();
  var _4 = $(_trEdit).find('td:eq(6)').text();


  var pitems = $(_trEdit).find('td:eq(7)').text();
  var subtotal = $(_trEdit).find('td:eq(8)').text();
  var igv = $(_trEdit).find('td:eq(9)').text();
  var total = $(_trEdit).find('td:eq(10)').text();
  var valor = $(_trEdit).find('td:eq(11)').text();

  var _5 = parseFloat(pitems).toFixed(2);
  var _6 = parseFloat(subtotal).toFixed(5);
  var _7 = parseFloat(igv).toFixed(2);
  var _8 = parseFloat(total).toFixed(2);
  var _9 = parseFloat(valor).toFixed(2);

  var _10 = $(_trEdit).find('td:eq(12)').text();
  var _11 = $(_trEdit).find('td:eq(13)').text();
  var _12 = $(_trEdit).find('td:eq(14)').text();
  var _13 = $(_trEdit).find('td:eq(15)').text();



  $('#a-cod-items').val(_0);//id items
  $('#a-itemid').val(_0);
  $('#a-id-d').val(_1);//unidad
  $('#a-tributo-d').val(_3);
  $('#a-cantidad-d').val(_4);

  $('#a-subtotal-d').val(_6);
  $('#a-igv-d').val(_7);
  $('#a-precio-d').val(_8);
  $('#a-valortotal-d').val(_9);


  $('#a-cod-d').val(_10);//cod items
  $('#a-sun-d').val(_11);//cod sunat
  $('#a-imp-d').val(_12);//impuesto
  $('#a-tipo-d').val(_13);//aplica impuesto

  if (_13 == 1) {
    $('#a-valor-d').val(_5);
  } else {
    var valor_2 = _9 / _4;
    $('#a-valor-d').val(valor_2);
  }

  $('#a-itemdet').val(_2);
  document.getElementById("select2-a-detalle-d-container").innerHTML = _2;
  document.getElementById("add-detalle").style.display = 'none';
  document.getElementById("btn-update").style.display = 'block';
  $("#myModal-Detalle").modal("show");
});



$('#btn-update').click(function () {

  if (_trEdit) {
    var _0 = $('#a-itemid').val();
    var _1 = $('input[name="1"]').val();
    var _2 = $('#a-itemdet').val();
    var _3 = $('input[name="3"]').val();
    var _4 = $('input[name="4"]').val();
    var _5 = $('input[name="5"]').val();
    var _6 = $('input[name="6"]').val();
    var _7 = $('input[name="7"]').val();
    var _8 = $('input[name="8"]').val();
    var _9 = $('input[name="9"]').val();
    var _10 = $('input[name="10"]').val();
    var _11 = $('input[name="11"]').val();
    var _12 = $('input[name="12"]').val();
    var _13 = $('input[name="13"]').val();

    $(_trEdit).find('td:eq(2)').text(_0);
    $(_trEdit).find('td:eq(3)').text(_1);
    $(_trEdit).find('td:eq(4)').text(_2);
    $(_trEdit).find('td:eq(5)').text(_3);
    $(_trEdit).find('td:eq(6)').text(_4);//cantidad


    //---- Precio Unitario----//
    if (_12 == 0) {
      var vuni = _7 / _4;
      _13 = parseFloat(vuni).toFixed(6);
  
    }



    $(_trEdit).find('td:eq(7)').text(_13);//precio unitario

    $(_trEdit).find('td:eq(8)').text(_5);//sub total
    $(_trEdit).find('td:eq(9)').text(_6);//igv
    $(_trEdit).find('td:eq(10)').text(_7);//precio total  
    $(_trEdit).find('td:eq(11)').text(_8);//valor total

    $(_trEdit).find('td:eq(12)').text(_9);
    $(_trEdit).find('td:eq(13)').text(_10);
    $(_trEdit).find('td:eq(14)').text(_11);
    $(_trEdit).find('td:eq(15)').text(_12);


    showAlert("#exito-a", "   Atención!!, Se Actualizo el Registro con Exito.. !.", "success", 2000, "glyphicon-ok")
    _trEdit = null;
    document.getElementById("btn-update").style.display = 'none';
    document.getElementById("add-detalle").style.display = 'block';
    sumatoriasDetalle();
    limpiar();

  }
});

$(document).on('click', '.btn-delete', function () {
  if (confirm("Desea Eliminar el Registro de la lista?")) {
    $(this).closest('tr').remove();
    sumatoriasDetalle();
  }
});


function limpiar() {

  $('input[name="1"]').val(''); /*unidad*/
  $('#a-valor-d').val('');
  $('#a-detalle-d').val('').trigger('change')

  $('input[name="3"]').val('');
  $('input[name="4"]').val('');
  $('input[name="5"]').val('');
  $('input[name="6"]').val('');
  $('input[name="7"]').val('');
  $('input[name="8"]').val('');
  $('input[name="9"]').val('');
  $('input[name="10"]').val('');
  $('input[name="11"]').val('');
  $('input[name="12"]').val('');
  $('input[name="13"]').val('');
  $('input[name="14"]').val('');
  $('input[name="15"]').val('');
  document.getElementById("a-cliente").focus();
}

//Abriri Modal
$(function () {
  $('#abrir_datos').on('click', function () {

    $('#myModal').on('shown.bs.modal', function () {
      $('#a-comp-m').focus();
    });

    $("#myModal").modal("show");
  });




  $('#myModal').on('hidden.bs.modal', function () {
    var a = $('#a-comp-m').val();
    var b = $('#a-ser-m').val();
    var c = $('#a-num-m').val();

    $('#n-16').val(a);
    $('#n-17').val(b);
    $('#n-18').val(c);


  });

});

function loadGuia() {
  $("#myGuia").modal("show");
}


//Calculos Automaticos
$(function () {
  $('#a-tributo-d').on('change', function () {
    sumatorias();
  });

  $('#a-cantidad-d').on('change', function () {
    sumatorias();
  });

  $('#a-valor-d').on('change', function () {
    sumatorias();
  });


});

function sumatorias() {
  var a = $('#a-cantidad-d').val(); //Importe Base
  var b = $('#a-valor-d').val();    //Cantidad Base
  var c = $('#a-tributo-d').val();//tipo de operacion

  var tipoIgv = $('#a-tipo-d').val();
  var igv = $('#a-imp-d').val();

  var igv_b = igv / 100;
  var igv_i = (igv / 100) + 1;


  if (a > 0 && b > 0) {
    if (c == '10') {
      if (tipoIgv == 0) {
        //Sacamos el Igv
        var y = (parseFloat(a) * parseFloat(b));
        var z = y.toFixed(6);
        $('#a-subtotal-d').val(z);

        var a = parseFloat(a);
        var d = (parseFloat(a) * parseFloat(b)) * igv_b;
        var e = d.toFixed(2);
        $('#a-igv-d').val(e);

        var f = (parseFloat(a) * parseFloat(b));

        $('#a-valortotal-d').val(parseFloat(f.toFixed(2)));
        var g = parseFloat(f.toFixed(2)) + parseFloat(d.toFixed(2));
        $('#a-precio-d').val(g);

      } else {

        //Incluye el Igv         
        var y = (parseFloat(a) * parseFloat(b)) / igv_i;
        var b = y.toFixed(6);
        $('#a-subtotal-d').val(b);//Subtotal

        var d = (parseFloat(b)) * igv_b;
        var e = d.toFixed(2);
        $('#a-igv-d').val(e);//igv

        var f = (parseFloat(b) / parseFloat(a)) * parseFloat(a);
        $('#a-valortotal-d').val(parseFloat(f.toFixed(2)));

        var g = parseFloat(b) + parseFloat(e);
        var h = g.toFixed(2);
        $('#a-precio-d').val(h);//Precio Total

      }

    } else if (c == '20' || c == '30' || c == '40') {


      $('#a-subtotal-d').val(b);//Subtotal

      var a = parseFloat(a);
      $('#a-igv-d').val(0);
      var f = (parseFloat(a) * parseFloat(b));
      $('#a-valortotal-d').val(parseFloat(f.toFixed(2)));
      var g = parseFloat(f.toFixed(2));
      $('#a-precio-d').val(parseFloat(g.toFixed(2)));

    }

  }

}

function sumatoriasDetalle() {
  var detalle = document.getElementById("a-moneda");
  var mon = detalle.options[detalle.selectedIndex].text;

  var campo4;
  var campo7 = 0;
  var campo8 = 0;
  var campo9 = 0;

  $("#example tbody tr").each(function (index) {

    $(this).children("td").each(function (index2) {
      switch (index2) {

        case 5: campo4 = $(this).text();//tributo
          break;
        case 9: campo7 = parseFloat($(this).text()) + parseFloat(campo7);//igv
          break;
        case 10: campo8 = parseFloat($(this).text()) + parseFloat(campo8);//precio
          break;
        case 11: campo9 = parseFloat($(this).text()) + parseFloat(campo9);//valor total
          break;
      }

    })
  });

  if (campo4 == "10") {
    document.getElementById('gravada').innerHTML = mon + ' ' + parseFloat(campo9).toFixed(2);
    document.getElementById('exonerada').innerHTML = mon + ' ' + "0.00";
    document.getElementById('inafecta').innerHTML = mon + ' ' + "0.00";
    document.getElementById('gratuita').innerHTML = mon + ' ' + "0.00";

  } else if (campo4 == "20") {
    document.getElementById('exonerada').innerHTML = mon + ' ' + parseFloat(campo9).toFixed(2);
    document.getElementById('gravada').innerHTML = mon + ' ' + "0.00";
    document.getElementById('inafecta').innerHTML = mon + ' ' + "0.00";
    document.getElementById('gratuita').innerHTML = mon + ' ' + "0.00";
  } else if (campo4 == "30") {
    document.getElementById('inafecta').innerHTML = mon + ' ' + parseFloat(campo9).toFixed(2);
    document.getElementById('exonerada').innerHTML = mon + ' ' + "0.00";
    document.getElementById('gravada').innerHTML = mon + ' ' + "0.00";
    document.getElementById('gratuita').innerHTML = mon + ' ' + "0.00";
  } else {
    // $('#gratuita').val(parseFloat(campo9.toFixed(2)));
  }
  document.getElementById('otros').innerHTML = mon + ' ' + "0.00";
  document.getElementById('descuentos').innerHTML = mon + ' ' + "0.00";
  document.getElementById('igv').innerHTML = mon + ' ' + parseFloat(campo7).toFixed(2);
  document.getElementById('total').innerHTML = mon + ' ' + parseFloat(campo8).toFixed(2);


}


$("#btn-nuevo").on("click", function () {
  swal({
    title: "Información",
    text: "Desea recargar la página? !",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm: TextTrackCue
  },
    function () {
      location.href = './facturacion';
    });


});



$("#btn-enviar").on("click", function () {

  if (document.getElementById("total").innerHTML=="S/ 0.00" || document.getElementById("total").innerHTML=="0.00"){
    Command: toastr["error"](
      " Espere!!, No agrego ningun detalle al comprobante Electrónico")
    return false;
  }
  
  swal({
    title: "Información",
    text: "Desea generar el comprobante Electrónico !",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    closeOnConfirm:true
  },
    function () {
      rucEmisor = document.getElementById("n-codigo-doc").innerHTML;
      var envio = document.getElementById("a-envio").checked;



      if (validarFormatoFecha(document.getElementById("a-fecha").value)) {
        if (existeFecha(document.getElementById("a-fecha").value)) {
        } else {
          Command: toastr["info"](
            " Espere!!, La Fecha Introducida no existe dd/mm/aaaa !"
          );
          $("#a-fecha").focus();
          return false;
        }
      } else {
        Command: toastr["info"](
          " Espere!!, La Fecha Introducida no existe dd/mm/aaaa!"
        );
        $("#a-fecha").focus();
        return false;
      }

      if ($("#a-serie").val() == "") {
        Command: toastr["info"](
          "Es necesario que seleccione la serie del Comprobante Eectrónico!"
        );
        $("#a-serie").focus();
        return false;
      }

      var cliente = document.getElementById("a-cliente").value;
      var cliente2 = document.getElementById("a-idcliente").value;
      if (cliente == "") {

        if (cliente2 == "") {
          Command: toastr["info"](
            "Es necesario que seleccione el Cliente a quie se Factura!"
          );

          $("#a-cliente").focus();

          return false;
        } else {
          cliente = cliente2;
        }
      }

      var direccion = document.getElementById("a-direccion").value;
      if (direccion == "") {
        Command: toastr["info"](
          "Es necesario que seleccione la dirección del Cliente!"
        );
        $("#a-direccion").focus();
        return false;
      }

      var moneda = document.getElementById("a-moneda").value;
      if (moneda == "") {
        Command: toastr["info"]("Es necesario que seleccione el tipo de moneda!");
        $("#a-moneda").focus();
        return false;
      }

      var tc = document.getElementById("a-tc").value;
      if (tc == "") {
        Command: toastr["info"]("Es necesario que edite el tipo de cambio!");
        $("#a-tc").focus();
        return false;
      }

      if (envio == "true") {
        envio = true;
      } else if (envio == "false") {
        envio = false;
      }

      if (document.getElementById("a-pago").value == "01") {
        $("#a-dias").val(0);
      } else {
        if (
          document.getElementById("a-dias").value == "" ||
          document.getElementById("a-dias").value == 0
        ) {
          Command: toastr["info"](
            "Si es al crédito la venta no puede ser igual a cero ó vacio!"
          );
          $("#a-dias").focus();
          return true;
        }
      }

      //Eliminar el Presupuesto si se actualiza
      var accion;
      var variable_1 = document.getElementById('n-codigo').innerHTML;
      if (variable_1.trim() != '' && variable_1.trim() != 0) {
        accion = true;
      } else {
        accion = false;
      }


      //Consultamos algunos datos antes de generar el JSON
      var miObjeto = new Object();
      var tipocpe;
      var seriecpe;
      var numcpe;

      $.ajax({
        type: "POST",
        data: "codigo=" + direccion,
        url: "./model/resumen/editarCPE.php",
        success: function (valores) {

          var datos = eval(valores);

          //-------------Cabezera Individual----------------//

          miObjeto.tipOperacion = "0101";
          miObjeto.fecEmision = conversionfecha(
            document.getElementById("a-fecha").value
          );
          miObjeto.fecVencimiento = conversionfecha(
            document.getElementById("a-fecha-v").value
          );

          tipocpe = document.getElementById("a-tipocomp").value;
          miObjeto.tipComp = tipocpe;

          document.getElementById("a-serie").disabled = false;
          document.getElementById("a-num").disabled = false;

          var serie = document.getElementById("a-serie");
          seriecpe = serie.options[serie.selectedIndex].text;
          miObjeto.serieComp = seriecpe;
          numcpe = NumeroCeros(document.getElementById("a-num").value);
          miObjeto.numeroComp = numcpe;




          miObjeto.tipDocUsuario = datos[10];
          miObjeto.codCliente= datos[13];
          miObjeto.numDocUsuario = datos[11];
          miObjeto.rznSocialUsuario = datos[12];
          miObjeto.codPaisCliente = datos[2];
          miObjeto.codLocalEmisor = datos[9];
          miObjeto.desDireccionCliente = datos[1];
          miObjeto.deptCliente = datos[4];
          miObjeto.provCliente = datos[5];
          miObjeto.distCliente = datos[6];
          miObjeto.urbCliente = datos[8];
          miObjeto.codUbigeoCliente = datos[3];

          miObjeto.tipMoneda = document.getElementById("a-moneda").value;
          miObjeto.tipCambio = document.getElementById("a-tc").value;
          miObjeto.Gravada = formatearnum(
            document.getElementById("gravada").innerHTML
          );
          miObjeto.Exonerada = formatearnum(
            document.getElementById("exonerada").innerHTML
          );
          miObjeto.Inafecta = formatearnum(
            document.getElementById("inafecta").innerHTML
          );
          miObjeto.Gratuita = formatearnum(
            document.getElementById("gratuita").innerHTML
          );
          miObjeto.Anticipo = "0.00";
          miObjeto.DsctoGlobal = "0.00";
          miObjeto.otrosCargos = "0.00";
          miObjeto.mtoIgv = formatearnum(document.getElementById("igv").innerHTML);
          miObjeto.mtoTotal = formatearnum(
            document.getElementById("total").innerHTML
          );
          miObjeto.servidorSunat = 3;
          miObjeto.envioSunat = envio;
          miObjeto.UBL = "2.1";

          miObjeto.idserie = document.getElementById("a-serie").value
          miObjeto.numdias = document.getElementById("a-dias").value

          //Nota de Credito o Debito
          var catDet = document.getElementById("a-nota");
          
          if (document.getElementById("a-tipocomp").value == "07") {
            miObjeto.Cat09 = document.getElementById("a-nota").value;
            miObjeto.Cat10 = "00";
            miObjeto.detCat = catDet.options[catDet.selectedIndex].text;
          } else if (document.getElementById("a-tipocomp").value == "08") {
            miObjeto.Cat10 = document.getElementById("a-nota").value;
            miObjeto.Cat09 = "00";
            miObjeto.detCat = catDet.options[catDet.selectedIndex].text;
          } else {
            miObjeto.Cat10 = "00";
            miObjeto.Cat09 = "00";
          }

          miObjeto.docRef = document.getElementById("a-ref-cpe").value;

          //Datos Adicionale de BD
          miObjeto.CodDir = document.getElementById("a-direccion").value;
          miObjeto.tipPago = document.getElementById("a-pago").value;
          miObjeto.accion = accion
          miObjeto.obs = document.getElementById("a-obs").value;
          miObjeto.saltosLinea = document.getElementById("a-saltos").value;
          var print = document.getElementById("a-print");
          miObjeto.impresion = print.options[print.selectedIndex].text;
          miObjeto.rucEmp = rucEmisor;
          miObjeto.dirEmp = document.getElementById("a-dirEmp").value;
          miObjeto.emailCli = datos[7];
          document.getElementById("a-correo-e").value=datos[7];
          miObjeto.items = new Array();
          var i = 0;

          $("#example tbody tr").each(function (index) {
            var campo1,
              campo2,
              campo3,
              campo4,
              campo5,
              campo6,
              campo7,
              campo8,
              campo9;
            $(this)
              .children("td")
              .each(function (index2) {
                switch (index2) {
                  case 2:
                    campo1 = $(this).text(); //codigo
                    break;
                  case 3:
                    campo2 = $(this).text(); //unidad
                    break;
                  case 4:
                    campo3 = $(this).text(); //detalle
                    break;
                  case 5:
                    campo4 = $(this).text(); //tributo
                    break;
                  case 6:
                    campo5 = $(this).text(); //cantidad
                    break;
                  //tenemos q revisar con el valor unitario real
                  case 8:
                    campo6 = $(this).text(); //sub total
                    break;
                  case 9:
                    campo7 = $(this).text(); //igv
                    break;
                  case 10:
                    campo8 = $(this).text(); //precio
                    break;
                  case 11:
                    campo9 = $(this).text(); //valor total
                    break;
                  case 14:
                    campo14 = $(this).text(); //impuesto
                    break;
                }
              });

            // '141 - 410'
            miObjeto.items[i] = new Object();
            miObjeto.items[i].CodItem = campo1;
            miObjeto.items[i].codUnidadMedida = campo2;
            miObjeto.items[i].ctdUnidadItem = campo5;
            miObjeto.items[i].codProducto = campo1;
            miObjeto.items[i].desItem = campo3;
            miObjeto.items[i].mtoValorUnitario = campo6;
            miObjeto.items[i].mtoDsctoItem = "0.00";
            miObjeto.items[i].mtoIgvItem = formatearnum(campo7);
            miObjeto.items[i].tipAfeIGV = campo4;
            miObjeto.items[i].tipPrecio = "01";
            miObjeto.items[i].mtoPrecioVentaItem = formatearnum(campo8);
            miObjeto.items[i].mtoValorVentaItem = formatearnum(campo9);
            miObjeto.items[i].porcentajeIgv = campo14;

            i = i + 1;
          });

          //parametros paar enviara  sunat
          var myString = JSON.stringify(miObjeto);
          var myString = forceUnicodeEncoding(myString);
          cpe = rucEmisor + '-' + tipocpe + '-' + seriecpe + '-' + numcpe
          //envio es para enviar a sunat : true o false;
          //off es para reenviar el json  a sunat cuando no se envio;
          timeoutID = window.setTimeout(EnvioSUNAT, 2000, myString, cpe, envio, "Off");
          //fina de envio



          contador = 0;
          document.getElementById('tipo-envio').innerHTML = "";

          if (envio == true) {
            $('#myModal2').on('show.bs.modal', function () {
              document.getElementById('envios-cpe').innerHTML =0;
              document.getElementById('tipo-envio').innerHTML = "Enviado Comprobante a Sunat";
              document.getElementById('cpe-id').innerHTML = cpe;
              BuscarCDR1(cpe);

            });
          } else {
            $('#myModal2').on('show.bs.modal', function () {
              document.getElementById('envios-cpe').innerHTML =0;
              document.getElementById('cpe-id').innerHTML = cpe;
              document.getElementById('tipo-envio').innerHTML = "Firmado Comprobante Electrónico";
            });
          }
          $("#myModal2").modal("show");



        },

      });


    });


});



function loadEdicion() {
  var variable_1 = document.getElementById('n-codigo').innerHTML;
  var codigo = variable_1.trim()

  if (variable_1.trim() != '' && variable_1.trim() != 0) {

    $.ajax({
      type: 'POST',
      data: 'codigo=' + variable_1.trim(),
      url: './model/cpe/editar.php',
      success: function (valores) {

        var datos = eval(valores);
        document.getElementById("a-tipocomp").value = codigo.substring(12, 14)
        document.getElementById("a-fecha").value = conversionfecha2(datos[1]);

        if (datos[2] == "0000-00-00") {
          document.getElementById("a-fecha-v").value = "";
        } else {
          document.getElementById("a-fecha-v").value = conversionfecha2(datos[2]);
        }

        document.getElementById("a-comp").value = codigo.substring(15, 19)
        loadSeries(document.getElementById("a-tipocomp").value);

        document.getElementById("a-serie").value = datos[3];
        document.getElementById("a-serie").disabled = true;
        document.getElementById("a-num").disabled = true;
        document.getElementById("a-num").value = codigo.substring(20, 28)
        document.getElementById("a-idcliente").value = datos[4];
        document.getElementById("select2-a-cliente-container").innerHTML = datos[5];

        LoadDireccion(datos[14], datos[6])
        document.getElementById("a-moneda").value = datos[7];
        document.getElementById("a-tc").value = datos[8];
        document.getElementById("a-pago").value = datos[9];
        document.getElementById("a-dirEmp").value = datos[15];

        load_Notas(document.getElementById("a-tipocomp").value)


        loadLista_Edicion(codigo,"x")
        add_referencia(datos[11]);
        if (document.getElementById("a-tipocomp").value=="07") {
          document.getElementById("a-nota").value = datos[12];
        }else if (document.getElementById("a-tipocomp").value=="08") {
          document.getElementById("a-nota").value = datos[13];
        }

        



      }

    });
    
    // 
  } else {

  }


}

