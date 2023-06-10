
// Solo permite ingresar numeros.
function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57 || key <= 46)
}

//return isNumberKey(event)
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
//FORMATO DE FECHAS
function validarFormatoFecha(campo) {
    var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
    if ((campo.match(RegExPattern)) && (campo != '')) {
        return true;
    } else {
        return false;
    }
}

function ch(id) {
    if (id == true) {
        return 1;
    } else if (id == false) {
        return 0;
    }
}

function existeFecha(fecha) {
    var fechaf = fecha.split("/");
    var day = fechaf[0];
    var month = fechaf[1];
    var year = fechaf[2];
    var date = new Date(year, month, '0');
    if ((day - 0) > (date.getDate() - 0)) {
        return false;
    }
    return true;
}

function existeFecha2(fecha) {
    var fechaf = fecha.split("/");
    var d = fechaf[0];
    var m = fechaf[1];
    var y = fechaf[2];
    return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}

function conversionfecha(fecha) {
    var date = fecha;
    var newdate = date.split("/").reverse().join("-");
    return newdate;
}

function conversionfecha2(fecha) {
    var date = fecha;
    var newdate = date.split("-").reverse().join("/");
    return newdate;
}

function fechanueva(fecha) {
    var periodo = fecha.substring(0, 4);
    var mes = fecha.substring(5, 7);
    var dia = fecha.substring(8, 10);


    return periodo + '-' + mes + '-' + dia;
}

function updatemes(a){

 if (countDigits(a.toString())==1){
    a = "0" + a;
 }

 return a;
}

function updatedia(a){
    if (countDigits(a.toString())==1){
        a = "0" + a;
     }
    
     return a;
    }

    function countDigits( str ) {
        return Array.prototype.reduce.call( str, function( acu, val ) {
          return ( val.charCodeAt( 0 ) > 47 ) && ( val.charCodeAt( 0 ) < 58 ) ? acu + 1 : acu;
        }, 0 );
      }

function fechaconversion(fecha) {
    var str = fecha;
    var dia = str.substring(8, 10);
    var mes = str.substring(5, 7);
    var periodo = str.substring(0, 4);
    var fecha = dia + '/' + mes + '/' + periodo;
    return fecha;
}

function OcultarBoton(){
    $("#btn-nuevo").hide();
    $("#btn-enviar").hide();
}

function contarCaracteres(str) {
    //Pasamos la cadena a minusculas(por si lo necesitas)
    //str = str.toLowerCase()
    //quitamos los espacios en blanco
    str = str.replace(/\s/g, "");
    final = {} //Donde guardamos los resultados
    for(let char in str){ //Cogemos el indice de cada caracter
      if(str[char] in final) { //Si ya existe, simplemente aumentamos el contador
          final[str[char]] = final[str[char]] + 1
      } else { // Si no existe, lo inicializamos a 1
          final[str[char]] = 1
      }
  }
    //Mostar los resultados
    tmp = ``
    Object.keys(final).forEach(function(letra){
      tmp += `La cantidad de ${letra} es: ${final[letra]} \n`
    })
    return tmp
  }

/*ARCHIVOS SUNAT - TODOS LAS ESTRUCTURAS*/
/*=====================================================================*/
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

    var CSV = '';
    //Set Report title in first row or line

    //CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";

        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {

            //Now convert each value to string and comma-seprated
            row += index + '|';
        }

        row = row.slice(0, -1);

        //append Label row with line break
        CSV += row + '\r\n';
    }

    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";

        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '' + arrData[i][index] + '|';
        }

        row.slice(0, row.length - 1);

        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {
        alert("Invalid data");
        return;
    }

    //Generate a file name
    var fileName = ReportTitle;
    //Pasamos el Archivo para crear el Txt
    $.ajax({
        url: 'funciones.php',
        type: 'POST',
        data: 'archivo=' + fileName + '&datos=' + CSV
    }).done(function (respuesta) {

        if (respuesta == 'exito') {
            window.open('./upload.php?archivo=' + fileName + '.zip');
        }
        else {
            alert('error, no se descargo el archivo')
        }

    });

}


//Alerta dinamica
function showAlert(etiqueta, message, type, closeDelay, icon) {


    // default to alert-info; other options include success, warning, danger
    type = type || "info";

    // create the alert div
    var alert = $('<div class="alert alert-' + type + ' fade in"  > <span class="glyphicon ' + icon + '">')
        .append(
            $('<button type="button" class="close" data-dismiss="alert">')
                .append("&times;")
        )
        .append(message);

    // add the alert div to top of alerts-container, use append() to add to bottom
    $(etiqueta).prepend(alert);

    // if closeDelay was passed - set a timeout to close the alert
    if (closeDelay)
        window.setTimeout(function () { alert.alert("close") }, closeDelay);
}



function NumeroCeros(num) {
    var texto_num = '';
    var largo = num.length;
    switch (largo) {
        case 1:
            texto_num = '0000000' + num;
            break;

        case 2:
            texto_num = '000000' + num;
            break;

        case 3:
            texto_num = '00000' + num;
            break;

        case 4:
            texto_num = '0000' + num;
            break;

        case 5:
            texto_num = '000' + num;
            break;

        case 6:
            texto_num = '00' + num;
            break;

        case 7:
            texto_num = '0' + num;
            break;

        case 8:
            texto_num = num;
            break;


    }


    return texto_num;
}

//Autor :  Roberto Herrero & Daniel//Web: http://www.indomita.org
//Asunto : Dar formato a un número
function dar_formato(num) {

    var cadena = ""; var aux;

    var cont = 1, m, k;

    if (num < 0) aux = 1; else aux = 0;

    num = num.toString();

    for (m = num.length - 1; m >= 0; m--) {

        cadena = num.charAt(m) + cadena;

        if (cont % 3 == 0 && m > aux) cadena = "." + cadena; else cadena = cadena;

        if (cont == 3) cont = 1; else cont++;

    }

    cadena = cadena.replace(/.,/, ",");

    return cadena;

}

function forceUnicodeEncoding(string) {
    return unescape(encodeURIComponent(string));
}
