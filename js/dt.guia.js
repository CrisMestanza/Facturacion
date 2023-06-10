
$(document).ready(function () {

    $("[name='my-checkbox']").bootstrapSwitch();
    loadTipo_Comprobante();
    loadMoneda();
    load_TipoPago();


})
/*CARGAMOS LAS DEPENDENCIAS*/
function LoadClientes() {
    var codcliente = $("#a-cliente").val();
    LoadDireccion(codcliente,0);
}

$('.itemName').select2({
    placeholder: 'Selecciona el Cliente',
    minimumInputLength: 1,
    ajax: {
        url: './model/resumen/clientes.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: false
    }
});

//$("#select2-a-cliente-results").val('sccc');
/*CARGAMOS LAS DIRECCIONES DEL CLIENTE SELECCIONADO*/
function LoadDireccion(codigo, dir) {

    $.ajax({
        url: './model/resumen/direccion.php',
        type: 'POST',
        data: 'codigo=' + codigo,
        success: function (data) {
            $("#a-direccion").html(data);
            document.getElementById("a-direccion").value =dir;

        }
    });
}

/*CARGAMOS LOS ITEMS*/
$('.itemBien').select2({
    placeholder: 'Selecciona el items',
    minimumInputLength: 1,
    ajax: {
        url: './model/resumen/items.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: false
    }
});

/*CARGAMOS LOS DATOS DEL ITEMS SELECCIONADO*/
function LoadItems() {
    var codigo = $("#a-detalle-d").val();
    if (codigo == null) {
        return false;
    }

    $.ajax({
        type: 'POST',
        data: 'codigo=' + codigo,
        url: './model/resumen/editaritems.php',
        success: function (valores) {

            var datos = eval(valores);
            document.getElementById("a-cod-d").value = datos[1];
            document.getElementById("a-sun-d").value = datos[2];
            document.getElementById("a-id-d").value = datos[4];//id de la unidad
            document.getElementById("a-tributo-d").value = datos[5];
            document.getElementById("a-imp-d").value = datos[6];
            document.getElementById("a-valor-d").value = datos[7];
            document.getElementById("a-tipo-d").value = datos[8];
            $("#a-cantidad-d").val(1);
            sumatorias();
            $("#a-cantidad-d").focus();
        }

    });

}


/*VALIDAMOS TABLAS ANEXAS*/
function loadMoneda() {

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=moneda',
        success: function (data) {
   
            $('#a-moneda').html(data);
        }
    });
}

function loadTipo_Comprobante() {
    
    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=tipo-comp',
        success: function (data) {
            $('#a-tipocomp').html(data);
            var codigo = $("#a-tipocomp").val();
            loadSeries(codigo);
            load_Notas(codigo);
        }
    });
}

function loadSeries(codigo) {

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=series'+'&codigo='+codigo,
        success: function (data) {
            $('#a-serie').html(data);
            LoadNumeracion();
        }
    });
}

function LoadNumeracion() {
    var codigo = $("#a-serie").val();
    $.ajax({
        type: 'POST',
        data: 'codigo=' + codigo,
        url: './model/resumen/numeracion.php',
        success: function (valores) {
            var datos = eval(valores);
            $('#a-num').val('');
            document.getElementById("a-num").value = datos[2];
            $("#a-cliente").focus();
        }

    });
}

$("#a-serie").change(function () {
    LoadNumeracion();
});


$("#a-tipocomp").change(function () {
    var codigo = $("#a-tipocomp").val();
    loadSeries(codigo);
    load_Notas(codigo)
});


function load_TipoPago() {
    
    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=tipo-pago',
        success: function (data) {
            $('#a-pago').html(data);
        }
    });
}



$("#a-pago").change(function () {
    var pago=$("#a-pago").val();

    if(pago=='02'){
        document.getElementById("v-dia").style.display = 'block';
        $("#a-dias").focus();
    }else{
        document.getElementById("v-dia").style.display = 'none';
        $("#a-envio").focus();
    }
    
});


//
/*VALIDAMOS LA MONEDA SEGUN LA SELECCIÓN*/
function ValidaMoneda() {

    var mon = document.getElementById("a-moneda").value;
    if (mon == 'PEN') {
        document.getElementById("a-tc").value = "0.00";
        document.getElementById("a-tc").readOnly = true;
    } else if (mon == 'USD') {
        document.getElementById("a-tc").value = "";
        document.getElementById("a-tc").readOnly = false;
    }

}

/*CARGAMOS LAS DEPENDENCIAS*/

$('.itemUnidad').select2({
    placeholder: 'Selecciona la Unidad',
    minimumInputLength: 1,
    ajax: {
      url: './model/items/unidad.php',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data

        };
      },
      cache: false

    }
  });

   /*CARGAMOS LAS DEPENDENCIAS*/

$(".itemPais").select2({
    placeholder: "Selecciona el País",
    minimumInputLength: 1,
    ajax: {
      url: "./model/clientes/pais.php",
      dataType: "json",
      delay: 250,
      processResults: function (data) {
        return {
          results: data,
        };
      },
      cache: false,
    },
  });
  
  $("#a-dpt").change(function () {
    loadprovincias();
  });
  
  $("#a-prov").change(function () {
    loaddistritos();
  });
  
  $("#a-dist").change(function () {});
  
  function loadprovincias(estado, prov, dist) {
    $("#a-dpt option:selected").each(function () {
      id_provincia = $(this).val();
      $.post(
        "model/clientes/provincias.php",
        { id_provincia: id_provincia },
        function (data) {
          $("#a-prov").html(data);
          if (estado == true) {
            document.getElementById("a-prov").value = prov;
            loaddistritos(true, dist);
            return false;
          }
  
          loaddistritos();
        }
      );
    });
  }
  
  function loaddistritos(estado, dist) {
    $("#a-prov option:selected").each(function () {
      id_distrito = $(this).val();
      $.post(
        "model/clientes/distritos.php",
        { id_distrito: id_distrito },
        function (data) {
          $("#a-dist").html(data);
          if (estado == true) {
            document.getElementById("a-dist").value = dist;
            $("#a-dist").val(dist);
          }
        }
      );
    });
  }


  $("#a-dpt-2").change(function () {
    loadprovincias_2();
  });
  
  $("#a-prov-2").change(function () {
    loaddistritos_2();
  });
  
  $("#a-dist-2").change(function () {});
  
  function loadprovincias_2(estado, prov, dist) {

    $("#a-dpt-2 option:selected").each(function () {
      id_provincia = $(this).val();
      $.post(
        "model/clientes/provincias.php",
        { id_provincia: id_provincia },
        function (data) {
          $("#a-prov-2").html(data);
          if (estado == true) {
            document.getElementById("a-prov-2").value = prov;
            loaddistritos(true, dist);
            return false;
          }
  
          loaddistritos_2();
        }
      );
    });
  }
  
  function loaddistritos_2(estado, dist) {
    $("#a-prov-2 option:selected").each(function () {
      id_distrito = $(this).val();
      $.post(
        "model/clientes/distritos.php",
        { id_distrito: id_distrito },
        function (data) {
          $("#a-dist-2").html(data);
          if (estado == true) {
            document.getElementById("a-dist-2").value = dist;
            $("#a-dist-2").val(dist);
          }
        }
      );
    });
  }

$('#a-id-und').change(function() {
  document.getElementById("a-und").value="";
})
