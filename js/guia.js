let detalle;
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


};


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
  var miObjeto = new Object();
  $.ajax({
    type: "POST",
    data: "codigo=" + _0,
    url: "./model/resumen/editarItems.php",
    success: function (valores) {
      var datos = eval(valores);

      var _1 = $('input[name="1"]').val();
     // var detalle = document.getElementById("a-detalle-d");
      var _2 =  datos[3];//detalle.options[detalle.selectedIndex].text;
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
    },
  });


}

//Editar Registro   
var _trEdit = null;
$(document).on('click', '.btn-edit', function () {
  _trEdit = $(this).closest('tr');
  var _0 = $(_trEdit).find('td:eq(2)').text();//cod item interno
  var _1 = $(_trEdit).find('td:eq(3)').text();//unidad
  var _2 = $(_trEdit).find('td:eq(4)').text();//detalle
  var _3 = $(_trEdit).find('td:eq(5)').text();//tributo
  var _4 = $(_trEdit).find('td:eq(6)').text();//cantidad

  //Dara formato
  var vuni = $(_trEdit).find('td:eq(7)').text();//valor unitario
  var subtotal = $(_trEdit).find('td:eq(8)').text();//sub total
  var igv = $(_trEdit).find('td:eq(9)').text();//igv
  var preciovta = $(_trEdit).find('td:eq(10)').text();//total
  var valorvta = $(_trEdit).find('td:eq(11)').text();// valor venta total


  var _6 = parseFloat(subtotal).toFixed(2);
  var _7 = parseFloat(igv).toFixed(2);
  var _8 = parseFloat(preciovta).toFixed(2);
  var _9 = parseFloat(valorvta).toFixed(2);

  var _10 = $(_trEdit).find('td:eq(12)').text();// cod item
  var _11 = $(_trEdit).find('td:eq(13)').text();// cos sunat
  var _12 = $(_trEdit).find('td:eq(14)').text();//igv
  var _13 = $(_trEdit).find('td:eq(15)').text();//aplica impueso

  //---- Precio Unitario----//
  var tipoIgv = $('#a-tipo-d').val();
  if (tipoIgv == 0) {
    var vuni = subtotal / _4;
  }
  var _5 = parseFloat(vuni).toFixed(6);


  $('input[name="0"]').val(_0);//
  $('input[name="1"]').val(_1);//cod unidad
  $('input[name="2"]').val(_2);//
  $('input[name="3"]').val(_3);//tributo
  $('input[name="4"]').val(_4);//cantidad
  $('input[name="13"]').val(_5);//precio o valor unitario base
  $('input[name="5"]').val(_6);//Sub total
  $('input[name="6"]').val(_7);//igv
  $('input[name="7"]').val(_8);//precio venta
  $('input[name="8"]').val(_9);//valor venta
  $('input[name="9"]').val(_10);//cod item
  $('input[name="10"]').val(_11);//cod sunat
  $('input[name="11"]').val(_12);//impuesto %
  $('input[name="12"]').val(_13);//aplica impuestp

  //$("#a-id-det").val(_2)

  document.getElementById("select2-a-detalle-d-container").innerHTML = _2;
  document.getElementById("add-detalle").style.display = 'none';
  document.getElementById("btn-update").style.display = 'block';

  $("#myModal-Detalle").modal("show");
});


//Actualizar Registro   
$('#btn-update').click(function () {

  if (_trEdit) {
    var _0 = $('#a-detalle-d').val();//validamos en null
    var _1 = $('input[name="1"]').val();

    if (_0 == null) {
      var _0 = $('input[name="0"]').val();//validamos por el undefindef
    } else {

      var detalle = document.getElementById("a-detalle-d");
      var _2 = detalle.options[detalle.selectedIndex].text;
    }

    var _3 = $('input[name="3"]').val();
    var _4 = $('input[name="4"]').val();
    var _8 = $('input[name="5"]').val();
    var _6 = $('input[name="6"]').val();
    var _7 = $('input[name="7"]').val();
    var _5 = $('input[name="8"]').val();
    var _9 = $('input[name="9"]').val();
    var _10 = $('input[name="10"]').val();
    var _11 = $('input[name="11"]').val();
    var _12 = $('input[name="12"]').val();
    var _13 = $('input[name="13"]').val();

    //Dara formato
    var vuni = parseFloat(_13).toFixed(2);;//precio unitario
    var subtotal = parseFloat(_5).toFixed(2);;//sub total
    var igv = parseFloat(_6).toFixed(2);//igv
    var preciovta = parseFloat(_7).toFixed(2);;//total
    var valorvta = parseFloat(_8).toFixed(2);;// valor venta total

    //---- Precio Unitario----//
    var tipoIgv = $('#a-tipo-d').val();

    if (tipoIgv == 0) {
      var vuni = preciovta / _4;
    }
    var vuni = parseFloat(vuni).toFixed(6);//valor unitario

    $(_trEdit).find('td:eq(2)').text(_0);
    $(_trEdit).find('td:eq(3)').text(_1);
    $(_trEdit).find('td:eq(4)').text(_2);
    $(_trEdit).find('td:eq(5)').text(_3);
    $(_trEdit).find('td:eq(6)').text(_4);
    $(_trEdit).find('td:eq(7)').text(vuni);
    $(_trEdit).find('td:eq(8)').text(subtotal);
    $(_trEdit).find('td:eq(9)').text(igv);
    $(_trEdit).find('td:eq(10)').text(preciovta);
    $(_trEdit).find('td:eq(11)').text(valorvta);
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
  if (confirm("Are you sure to delete?")) {
    $(this).closest('tr').remove();
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

function loadGuia(){
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
  var c = $('#a-tributo-d').val();

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

        var f = (parseFloat(b) / parseFloat(a));
        $('#a-valortotal-d').val(parseFloat(f.toFixed(2)));

        var g = parseFloat(b) + parseFloat(e);
        var h = g.toFixed(2);
        $('#a-precio-d').val(h);//Precio Total

      }

    } else if (c == '20' || c == '30' || c == '40') {
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

  } else if (campo4 == "30") {
    document.getElementById('exonerada').innerHTML = mon + ' ' + parseFloat(campo9).toFixed(2);
    document.getElementById('gravada').innerHTML = mon + ' ' + "0.00";
    document.getElementById('inafecta').innerHTML = mon + ' ' + "0.00";
    document.getElementById('gratuita').innerHTML = mon + ' ' + "0.00";
  } else if (campo4 == "20") {
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


$("#btn-enviar").on("click", function () {
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
  if (cliente == "") {
    Command: toastr["info"](
      "Es necesario que seleccione el Cliente a quie se Factura!"
    );
    $("#a-cliente").focus();
    return false;
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

  //Consultamos algunos datos antes de generar el JSON
  var miObjeto = new Object();
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
      miObjeto.tipComp = document.getElementById("a-tipocomp").value;
      var serie = document.getElementById("a-serie");
      miObjeto.serieComp = serie.options[serie.selectedIndex].text;
      miObjeto.numeroComp = NumeroCeros(document.getElementById("a-num").value);

      miObjeto.tipDocUsuario = datos[10];
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
      miObjeto.servidorSunat =3;
      miObjeto.envioSunat = envio;
      miObjeto.UBL = "2.1";

      //Nota de Credito o Debito
      if (document.getElementById("a-tipocomp").value == "07") {
        miObjeto.Cat09 = document.getElementById("a-nota").value;
        miObjeto.Cat10 = "00";
      } else if (document.getElementById("a-tipocomp").value == "08") {
        miObjeto.Cat10 = document.getElementById("a-nota").value;
        miObjeto.Cat09 = "00";
      } else {
        miObjeto.Cat10 = "00";
        miObjeto.Cat09 = "00";
      }

      miObjeto.docRef = document.getElementById("a-ref-cpe").value;

      //Datos Adicionale de BD
      miObjeto.CodDir = document.getElementById("a-direccion").value;
      miObjeto.tipPago = document.getElementById("a-pago").value;

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
        miObjeto.items[i].porcentajeIgv = 18;

        i = i + 1;
      });

      var myString = JSON.stringify(miObjeto);

      var myString = forceUnicodeEncoding(myString);

      $.ajax({
        url: "../../../Api-Rest-Json/Token/Authorization.php",
        type: "POST",
        data:
          "Login=20601733022" +
          "&Token=39e9289a5b8328ecc4286da11076748716c41ec7fb94839a689f7dac5cdf5ba8bdc9a9acdc95b95245f80a00d58c9575c203ceb541507cce40dd5a96e9399f4a" +
          "&Puerto=F" +
          "&Json=" +
          myString,
      }).done(function (respuesta) {
        alert(respuesta)
        var aMyUTF8Output = base64DecToArr(respuesta);
        var sMyOutput = UTF8ArrToStr(aMyUTF8Output);

        LoadNumeracion();

        var data = JSON.parse(sMyOutput);

        if (data[0].BaseDatos == "Registrado") {
          $("#myModal").modal("hide");
          // Cancelar();
          swal("En Buena Hora!", "El registro se guardo con Exito!", "success");
          LoadPdf();
        } else {
          swal(
            "Error !",
            "El registro no se guardo, vuelvalo a intentar !",
            "error"
          );
        }
      });
    },
  });
});

function LoadPdf() {
  V_Ruc = "20601733022";
  V_Tipo = "01";//document.getElementById("a-comp").value;
  var serie = document.getElementById("a-serie");
  V_Serie = serie.options[serie.selectedIndex].text;
  V_Numero = NumeroCeros(document.getElementById("a-num").value);

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



