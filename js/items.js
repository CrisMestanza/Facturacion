var tipo;
var estado;

window.onload = function () {

  document.getElementById("a-igv").value = "18";
  $('#a-ope').val(10);
  $('#a-igv').val(18);
  $('#a-valor').val(0);
  $('#a-impuesto').val(1);
  $('#a-descuento').val(0);
  LoadSession();
  loadcat7();
  OcultarBoton()


};

//Calculos Automaticos
$(function () {
  $('#a-ope').on('change', function () {

    if($('#a-ope').val()=='10'){
      document.getElementById("a-igv").disabled=false;
      document.getElementById("a-impuesto").disabled=false;
      $('#a-igv').val(18)
      $('#a-impuesto').val(1)
    
    }else if($('#a-ope').val()=='20' || $('#a-ope').val()=='30'){
      $('#a-igv').val(0)
      $('#a-impuesto').val(0)
      document.getElementById("a-igv").disabled=true;
      document.getElementById("a-impuesto").disabled=true;
    }
  });


});


function loadcat7() {

  $.ajax({
    url: './model/anexos/anexos.php',
    type: 'POST',
    data: 'boton=cat7',
    success: function (data) {
      $('#a-ope').html(data);

    }
  });
}

function loadtablas() {
  variable_1 = document.getElementById("n-codigo-doc").innerHTML;
  $('.table').footable({
    "empty": "Sin registros",
    "toggleSelector": ".footable-toggle",
    "paging": {
      "enabled": true
    },
    "filtering": {
      "placeholder": "Buscar",
      "enabled": true,
      "delay": -2,
    },
    "sorting": {
      "enabled": true
    },
    "paging": {
      "enabled": true,
      "size": 5,
      "limit": 5,
      "current": 1
    },
    "columns": [
      { "name": "retorno_0", "title": "Id", "type": "number", "visible": false, "filterable": false, "style": { "width": 30, "maxWidth": 80 } },
      { "name": "retorno_1", "title": "Código" },
      { "name": "retorno_2", "title": "Código Sunat", "breakpoints": "xs sm md" },
      { "name": "retorno_3", "title": "Descripción del Bien", "breakpoints": "xs sm md" },
      { "name": "retorno_4", "title": "Unidad", "breakpoints": "xs sm" },
      { "name": "retorno_5", "title": "Operación", "breakpoints": "xs sm md" },
      { "name": "retorno_6", "title": "Precio U.", "breakpoints": "all", "style": { "maxWidth": 200, "overflow": "hidden", "textOverflow": "ellipsis", "wordBreak": "keep-all", "whiteSpace": "nowrap" } },
      { "name": "retorno_7", "title": "Valor U.", "breakpoints": "all" }
    ],
    "rows": $.get("json/" + variable_1 + "-I.json"),
    "editing": {
      "alwaysShow": true,
      "allowView": false,
      "pageToNew": true,
      "position": "right",
      "addText": "<span class='fa fa-plus-circle'></span> Nuevo Registro",
      "showText": '<span class="fooicon fooicon-pencil" aria-hidden="true"></span> Editar Registros',
      "hideText": "Cancelar",
      "enabled": true,
      "allowEdit": true,
      "allowAdd": true,
      "allowDelete": true,

      addRow: function () {
        tipo = true;
        loadmodal()
      },
      deleteRow: function (row) {
        var values = row.val();
        if (values.retorno_0 > 0) {

          swal({
            title: "Información",
            text: "Desea Eliminar el registro !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            closeOnConfirm: true
          },
            function () {
              deldocumento(values.retorno_0);
              if (estado == true) {
                row.delete();
              }
            });
        }

      },
      editRow: function (row) {
        var values = row.val();
        if (values.retorno_0 > 0) {
          tipo = false;
          loadEdicion(values.retorno_0)
        }
      },

    }
  });


}


function dat_consulta() {

  variable_1 = document.getElementById("n-codigo-doc").innerHTML;

  if (variable_1 != "") {
    $("#miTabla").html("");

    $.ajax({
      url: './model/items/entidad.php',
      type: 'POST',
      data: 'variable_1=' + variable_1 + '&variable_2=I' + "&boton=consultar"
    }).done(function (resp) {

      loadtablas();
    });
  }
}

$('#btn-guardar').on('click', function () {
  var variable_0 = $('#a-id').val();
  var variable_1 = $('#a-cod').val();
  var variable_2 = document.getElementById("a-codsunat").value;
  var variable_3 = $('#a-det').val();
  var variable_4 = document.getElementById("a-und").value
  var variable_5 = document.getElementById("a-ope").value
  var variable_6 = $('#a-igv').val();
  var variable_7 = $('#a-valor').val();
  var variable_8 = $('#a-impuesto').val();
  var variable_9 = $('#a-descuento').val();
  var variable_10 = $('#a-idsunat').val();
  var variable_11 = $('#a-id-und').val();
  var variable_12 = document.getElementById("n-codigo-doc").innerHTML;


  if (variable_2 == '' || variable_2 == null) {
    if (variable_10 != '') {
      variable_2 = $('#a-idsunat').val();
    }else{
      showAlert("#msj-alert", "  Espere!!, seleccione el Código de Sunat!", "success", 2000, " ti-pencil-alt");
      $('#a-codsunat').focus();
      return false;
    }    
  }

  if (variable_3 == '') {
    showAlert("#msj-alert", "  Espere!!, Ingrese el detalle del bien ó servicio!", "success", 2000, " ti-pencil-alt");
    $('#a-det').focus();
    return false;
  }

  if (variable_4 == '' || variable_4 == null) {
    if (variable_11 != '') {
      variable_4 = $('#a-id-und').val();
    }else{
      showAlert("#msj-alert", "  Espere!!, Seleccione la Unidad de Medida!", "success", 2000, " ti-pencil-alt");
      $('#a-und').focus();
      return false;
    }    
  }

  if (variable_5 == '') {
    showAlert("#msj-alert", "  Espere!!, Seleccione el Tipo de operación!", "success", 2000, " ti-pencil-alt");
    $('#a-ope').focus();
    return false;
  }

  if (variable_6 == '') {
    showAlert("#msj-alert", "  Espere!!, Ingrese el Impuesto !", "success", 2000, " ti-pencil-alt");
    $('#a-igv').focus();
    return false;
  }

  if (variable_7 == '') {
    showAlert("#msj-alert", "  Espere!!, Ingrese el valor unitario!", "success", 2000, " ti-pencil-alt");
    $('#a-valor').focus();
    return false;
  }

  if (variable_8 == '') {
    showAlert("#msj-alert", "  Espere!!, Seleccione si incluye Impuesto!", "success", 2000, " ti-pencil-alt");
    $('#a-impuesto').focus();
    return false;
  }

  if (variable_9 == '') {
    showAlert("#msj-alert", "  Espere!!, Ingrese el descuento!", "success", 2000, " ti-pencil-alt");
    $('#a-descuento').focus();
    return false;
  }


  if (variable_0 == '') {
    guadocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6, variable_7, variable_8, variable_9, variable_12);

  } else {
    moddocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6, variable_7, variable_8, variable_9, variable_12);

  }
});

function guadocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6, variable_7, variable_8, variable_9, variable_12) {

  $.ajax({
    url: './model/items/entidad.php',
    type: 'POST',
    data: 'variable_1=' + variable_1 + '&variable_2=' + variable_2 + '&variable_3=' + variable_3 + '&variable_4=' + variable_4 + '&variable_5=' + variable_5 + '&variable_6=' + variable_6 + '&variable_7=' + variable_7 + '&variable_8=' + variable_8 + '&variable_9=' + variable_9 + '&variable_12=' + variable_12 + "&boton=registrar"
  }).done(function (resp) {
    if (resp == 'exito') {
      $("#myModal").modal("hide");
      Cancelar();
      Command: toastr["success"]("En Buena Hora!, El registro se guardo con Exito!")
      dat_consulta();
    } else {
      Command: toastr["error"]("El registro no se guardo, vuelvalo a intentar !")

    }

  });
}

function moddocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6, variable_7, variable_8, variable_9, variable_12) {
  $.ajax({
    url: './model/items/entidad.php',
    type: 'POST',
    data: 'variable_0=' + variable_0 + '&variable_1=' + variable_1 + '&variable_2=' + variable_2 + '&variable_3=' + variable_3 + '&variable_4=' + variable_4 + '&variable_5=' + variable_5 + '&variable_6=' + variable_6 + '&variable_7=' + variable_7 + '&variable_8=' + variable_8 + '&variable_9=' + variable_9 + '&variable_12=' + variable_12 + "&boton=modificar"
  }).done(function (resp) {
    if (resp == 'exito') {
      $("#myModal").modal("hide");
      Cancelar();
      Command: toastr["success"]("En Buena Hora!, El registro se Actualizo con Exito!")
      dat_consulta();
    } else {
      Command: toastr["error"]("El registro no se actualizo, vuelvalo a intentar !")
    }

  });

}



function deldocumento(codigo) {

  $.ajax({
    url: './model/items/entidad.php',
    type: 'POST',
    data: 'codigo=' + codigo + "&boton=eliminar"
  }).done(function (resp) {
    if (resp == 'exito') {
      Command: toastr["success"]("En Buena Hora!, El registro se Elimino con Exito!")
      dat_consulta();
      estado = true;
    } else {
      Command: toastr["error"]("El registro no se elimino, vuelvalo a intentar !")
      estado = false;
    }

  });
}


function loadEdicion(codigo) {
  var variable_1 = codigo;
  $.ajax({
    type: 'POST',
    data: 'codigo=' + variable_1,
    url: './model/items/editar.php',
    success: function (valores) {

      var datos = eval(valores);

      document.getElementById("a-id").value = datos[0];
      document.getElementById("a-cod").value = datos[1];
      document.getElementById("a-idsunat").value = datos[2];
      document.getElementById("a-det").value = datos[3];
      document.getElementById("a-id-und").value = datos[4];
      document.getElementById("a-ope").value = datos[5];
      document.getElementById("a-igv").value = datos[6];
      document.getElementById("a-valor").value = datos[7];
      document.getElementById("a-impuesto").value = datos[8];
      document.getElementById("a-descuento").value = datos[9];
      document.getElementById("select2-a-codsunat-container").innerHTML = datos[10];
      document.getElementById("select2-a-und-container").innerHTML = datos[11];

    }

  });

  loadmodal()

}


$('#btn-cancelar').on('click', function () {
  Cancelar();
});


function Cancelar() {
  $('#a-id').val('');
  $('#a-cod').val('');
  $('#a-det').val('');
  $('#a-id-und').val('');
  $('#a-idsunat').val('');
  document.getElementById("select2-a-codsunat-container").innerHTML = '';
  document.getElementById("select2-a-und-container").innerHTML = '';
  $('#a-ope').val(10);
  $('#a-igv').val(18);
  $('#a-valor').val(0);
  $('#a-impuesto').val(1);
  $('#a-descuento').val(0);
  document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
  $('#a-cod').focus();

}


function loadmodal() {
  $('#myModal').on('shown.bs.modal', function () {
    if (tipo == true) {
      Cancelar();   
      document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
    } else if (tipo == false) {
      document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-saved'></span> Modificar Registro";
    }

    $('#a-cod').focus();
  });

  $("#myModal").modal("show");
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

$('.itemCodSunat').select2({
  placeholder: 'Selecciona el Código Sunat',
  minimumInputLength: 1,
  ajax: {
    url: './model/items/codsunat.php',
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

$('#a-codsunat').change(function () {
  document.getElementById("a-idsunat").value = "";
})

$('#a-id-und').change(function () {
  document.getElementById("a-und").value = "";
})