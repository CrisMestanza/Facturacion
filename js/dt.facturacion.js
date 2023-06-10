var boton;
$(document).ready(function () {
    LoadSession();

    loadTipo_Comprobante();
    loadMoneda();
    load_TipoPago();
    loadEdicion();
    load_Impresion();


})
/*CARGAMOS LAS DEPENDENCIAS*/
function LoadClientes() {
    var codcliente = $("#a-cliente").val();
    var rucEmisor = document.getElementById("n-codigo-doc").innerHTML;
    //buscar el codigo del cliente por id y Empresa

   
    $.ajax({
        url: './model/clientes/entidad.php',
        type: 'POST',
        data: 'codigo=' + codcliente +'&rucempresa='+rucEmisor+'&boton=consulta-id',
        success: function (data) { 
            
            LoadDireccion(data, 0);
        }
    });
  

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

/*CARGAMOS LAS DIRECCIONES DEL CLIENTE SELECCIONADO*/
function LoadDireccion(codigo, dir) {

    $.ajax({
        url: './model/resumen/direccion.php',
        type: 'POST',
        data: 'codigo=' + codigo,
        success: function (data) {
            $("#a-direccion").html(data);
            document.getElementById("a-direccion").value = dir;

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
        url: './model/resumen/editarItems.php',
        success: function (valores) {

            var datos = eval(valores);
            document.getElementById("a-itemid").value = datos[0];//id items
            document.getElementById("a-cod-d").value = datos[1];//codigio items
            document.getElementById("a-sun-d").value = datos[2];//Codigo sunat
            document.getElementById("a-itemdet").value = datos[3];//detalle items
            document.getElementById("a-id-d").value = datos[4];//id de la unidad
            document.getElementById("a-tributo-d").value = datos[5];//tributo
            document.getElementById("a-imp-d").value = datos[6];//impuesto
            document.getElementById("a-valor-d").value = datos[7];//precio o valor
            document.getElementById("a-tipo-d").value = datos[8];//aplica impuesto
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
    var variable_1 = document.getElementById('n-codigo').innerHTML;

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=tipo-comp',
        success: function (data) {
            $('#a-tipocomp').html(data);
            var codigo = $("#a-tipocomp").val();
           
            if (variable_1.trim() == '' || variable_1.trim() == 0 ) {
              
                loadSeries(codigo);
                load_Notas(codigo,"");
            } else {

            }


        }
    });
}

function loadSeries(codigo) {
    var variable_1 = document.getElementById('n-codigo').innerHTML;

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=series' + '&codigo=' + codigo,
        success: function (data) {
           
            $('#a-serie').html(data);
          
            if (variable_1.trim() != '' && variable_1.trim() != 0 ) {

            } else {
                LoadNumeracion();
            }

        }
    });
}

function LoadNumeracion() {
    var codigo = $("#a-serie").val();

    if(codigo!="" && codigo != null){
    $.ajax({
        type: 'POST',
        data: 'codigo=' + codigo,
        url: './model/resumen/numeracion.php',
        success: function (valores) {
            var datos = eval(valores);
            $('#a-num').val('');
            document.getElementById("a-num").value = datos[2];
            document.getElementById("a-dirEmp").value = datos[3];
            $("#a-cliente").focus();
        }

    });
}else{
    Command: toastr["error"](
        "No se e a registrado ninguna serie para el Comprobante Electrónico !"
    )
}
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
    var pago = $("#a-pago").val();

    if (pago == '02') {
        document.getElementById("v-dia").style.display = 'block';
        $("#a-dias").focus();
    } else {
        document.getElementById("v-dia").style.display = 'none';
        $("#a-envio").focus();
    }
   
});

function load_Impresion() {

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=print',
        success: function (data) {
            
            $('#a-print').html(data);
            BuscarImpresion();
        }
    });
}

$("#a-print").change(function () {
    BuscarImpresion();
});

function BuscarImpresion(){
    var print = $("#a-print").val();
    $.ajax({
        type: 'POST',
        data: 'codigo=' + print,
        url: './model/cpe/buscar-print.php',
        success: function (valores) {
            var datos = eval(valores);
            document.getElementById("a-saltos").value = datos[2];
        }
    });
}




function load_Notas(codigo, ed) {

    if (codigo == '07') {
        boton = "n-credito"
        document.getElementById("v-nota").style.display = 'block';
        document.getElementById("v-fecha-v").style.display = 'none';
        document.getElementById("v-pago").style.display = 'none';

        document.getElementById("v-referencia").style.display = 'block';
        document.getElementById("a-referencia").readOnly = true;
    } else if (codigo == '08') {
        boton = "n-debito"
        document.getElementById("v-nota").style.display = 'block';
        document.getElementById("v-fecha-v").style.display = 'none';
        document.getElementById("v-pago").style.display = 'none';
        document.getElementById("v-referencia").style.display = 'block';
        document.getElementById("a-referencia").readOnly = true;
    } else if (codigo == '01') {
        document.getElementById("v-nota").style.display = 'none';
        document.getElementById("v-pago").style.display = 'block';
        document.getElementById("v-referencia").style.display = 'none';
        document.getElementById("v-fecha-v").style.display = 'block';

        $('#a-nota').html('');
        return false;
    } else if (codigo == '03') {
        document.getElementById("v-nota").style.display = 'none';
        document.getElementById("v-pago").style.display = 'none';
        document.getElementById("v-referencia").style.display = 'none';
        document.getElementById("v-fecha-v").style.display = 'none';

        $('#a-nota').html('');
        return false;
    }
    
    /*Rellenar el catalogo 09 o el 10 */
    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=' + boton + '&codigo=' + codigo,
        success: function (data) {
            $('#a-nota').html(data);
            if (ed==""){
            Load_ModalNotas()
            }

        }
    });
    


}
//Cargamos los datos para Edición o Nota de Credito
function Buscar_CPE(codigo) {
    $.ajax({
        type: 'POST',
        data: 'codigo=' + codigo,
        url: './model/resumen/editar.php',
        success: function (valores) {
            var datos = eval(valores);
            //document.getElementById("n-codigo").value = datos[0];
            // document.getElementById("a-fecha").value = conversionfecha2(datos[1]);
            document.getElementById("a-fecha").value = conversionfecha2(datos[2]);
            document.getElementById("a-fecha-v").value = conversionfecha2(datos[3]);
            LoadDireccion(datos[4], datos[6]);
            document.getElementById("a-idcliente").value = datos[4];
            document.getElementById("a-cliente").value = datos[5];
            document.getElementById("select2-a-cliente-container").innerHTML = datos[5];
            document.getElementById("a-moneda").value = datos[7];
            document.getElementById("a-tc").value = datos[8];
            document.getElementById("a-pago").value = datos[9];

            if (datos[9] == '01') {
                document.getElementById("v-dia").style.display = 'none';
            }


        }

    });

    loadLista_Edicion(codigo);

}

function loadLista_Edicion(codigo) {
    $.ajax({
        url: 'model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=lista-editar&codigo=' + codigo,
        success: function (data) {
            $('#detalle-factura').html(data);
            sumatoriasDetalle();
        }
    });
}


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

