var tipo;
var estado;
//https://www.w3schools.com/icons/icons_reference.asp
window.onload = function () {
  LoadSession();
  LoadCat6()
  LoadDepartamentos()
  OcultarBoton()
};

function LoadCat6() {
  $.ajax({
    url: './model/anexos/anexos.php',
    type: 'POST',
    data: 'boton=cat6',
    success: function (data) {
      $("#a-tipo").html(data);

    }
  });
}

function LoadDepartamentos() {
  $.ajax({
    url: './model/anexos/anexos.php',
    type: 'POST',
    data: 'boton=dpt',
    success: function (data) {
      $("#a-dpt").html(data);
      $("#a-dpt-d").html(data);

    }
  });
}



function loadtablas(variable_1){
  $(".table").footable({
    empty: "Sin registros",
    toggleSelector: ".footable-toggle",
    paging: {
      enabled: true,
    },
    filtering: {
      placeholder: "Buscar",
      enabled: true,
      delay: -2,
    },
    sorting: {
      enabled: true,
    },
    paging: {
      enabled: true,
      size: 5,
      limit: 5,
      current: 1,
    },
    columns: [
      {
        name: "retorno_0",
        title: "Id",
        type: "number",
        visible: false,
        filterable: false,
        style: { width: 30, maxWidth: 80 },
      },
      { name: "retorno_1", title: "Documento" },
      {
        name: "retorno_2",
        title: "Nombre ó Razón Social",
        breakpoints: "xs sm md",
      },
      { name: "retorno_3", title: "Dirección", breakpoints: "xs sm md" },
      { name: "retorno_4", title: "Pais", breakpoints: "xs sm" },
      { name: "retorno_5", title: "Ubigeo", breakpoints: "xs sm md" },
      {
        name: "retorno_6",
        title: "Departamento.",
        breakpoints: "all",
        style: {
          maxWidth: 200,
          overflow: "hidden",
          textOverflow: "ellipsis",
          wordBreak: "keep-all",
          whiteSpace: "nowrap",
        },
      },
      { name: "retorno_7", title: "Provincia", breakpoints: "all" },
      { name: "retorno_8", title: "Distrito", breakpoints: "all" },
      { name: "retorno_9", title: "Email", breakpoints: "all" },
      { name: "retorno_10", title: "Urbanización", breakpoints: "all" },
      { name: "retorno_11", title: "Local", breakpoints: "all" },
    ],
    rows: $.get("json/" + variable_1 + "-C.json"),
    editing: {
      alwaysShow: true,
      allowView: false,
      pageToNew: true,
      position: "right",
      addText: "<span class='fa fa-plus-circle'></span> Nuevo Registro",
      showText:
        '<span class="fooicon fooicon-pencil" aria-hidden="true"></span> Editar Registros',
      hideText: "Cancelar",
      enabled: true,
      allowEdit: true,
      allowAdd: true,
      allowDelete: true,
      allowView: true,

      addRow: function () {
        tipo = true;
        loadmodal();
      },
      deleteRow: function (row) {
        var values = row.val();
        if (values.retorno_0 > 0) {
          swal(
            {
              title: "Información",
              text: "Desea Eliminar el registro !",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Sí",
              cancelButtonText: "Cerrar",
              closeOnConfirm: true,
            },
            function () {
          
              deldocumento_cli(values.retorno_0);
              if (estado == true) {
                row.delete();
              }
            }

          );
        }
      },
      editRow: function (row) {
        var values = row.val();
        if (values.retorno_0 > 0) {
          tipo = false;
          loadEdicion(values.retorno_0);
        }
      },
      viewRow: function (row) {
        var values = row.val();
        $("#a-cli-d").val(values.retorno_0);
        loadDir(values.retorno_0);
      },
    },
  });
}

function dat_consulta() {

  variable_1 = document.getElementById("n-codigo-doc").innerHTML;

  if (variable_1 != "") {
    $("#miTabla").html("");

    $.ajax({
      url: "./model/clientes/entidad.php",
      type: "POST",
      data:
        "variable_1=" +
        variable_1 +
        "&variable_2=C" +
        "&boton=consultar",
    }).done(function (resp) {
      loadtablas(variable_1);
    });
  }
}

$("#btn-guardar").on("click", function () {
  var variable_0 = $("#a-id").val();
  var variable_1 = document.getElementById("a-tipo").value;
  var variable_2 = document.getElementById("a-doc").value;
  var variable_3 = $("#a-nom").val();
  var variable_4 = document.getElementById("a-dir").value;
  var variable_5 = document.getElementById("a-pais").value;
  var variable_6 = document.getElementById("a-dist").value;
  var variable_7 = $("#a-email").val();
  var variable_8 = $("#a-urb").val();
  var variable_9 = $("#a-local").val();
  var variable_10 = document.getElementById("n-codigo-doc").innerHTML;

  if (variable_1 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, seleccione el tipo de documento!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-tipo").focus();
    return false;
  }

  if (variable_2 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, edite el N° de documento!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-doc").focus();
    return false;
  }

  if (variable_3 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el nombre ó razón social!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-nom").focus();
    return false;
  }

  if (variable_4 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese la direción principal!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-dir").focus();
    return false;
  }

  if (variable_5 == null  || variable_5 == "" ) {

    if($("#id-pais").val() != ""){
       variable_5 = $("#id-pais").val();
    }else{
      showAlert(
        "#msj-alert",
        "  Espere!!, Seleccione el País!",
        "success",
        2000,
        " ti-pencil-alt"
      );
      $("#a-pais").focus();
      return false;
    }

  }

  if ($("#a-dpt").val() == null) {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el departamento!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-dpt").focus();
    return false;
  }

  if ($("#a-prov").val() == null) {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese la provincia!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-prov").focus();
    return false;
  }

  if ($("#a-dist").val() == null) {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el distrito!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-dist").focus();
    return false;
  }




  if (variable_0 == "") {
    guadocumento(
      variable_0,
      variable_1,
      variable_2,
      variable_3,
      variable_4,
      variable_5,
      variable_6,
      variable_7,
      variable_8,
      variable_9,
      variable_10
    );
  } else {
    moddocumento(
      variable_0,
      variable_1,
      variable_2,
      variable_3,
      variable_4,
      variable_5,
      variable_6,
      variable_7,
      variable_8,
      variable_9
    );
  }
});

function guadocumento(
  variable_0,
  variable_1,
  variable_2,
  variable_3,
  variable_4,
  variable_5,
  variable_6,
  variable_7,
  variable_8,
  variable_9,
  variable_10
) {
  $.ajax({
    url: "./model/clientes/entidad.php",
    type: "POST",
    data:
      "variable_1=" +
      variable_1 +
      "&variable_2=" +
      variable_2 +
      "&variable_3=" +
      variable_3 +
      "&variable_4=" +
      variable_4 +
      "&variable_5=" +
      variable_5 +
      "&variable_6=" +
      variable_6 +
      "&variable_7=" +
      variable_7 +
      "&variable_8=" +
      variable_8 +
      "&variable_9=" +
      variable_9 +
      "&variable_10=" +
      variable_10 +
      "&boton=registrar",
  }).done(function (resp) {
    if (resp == "exito") {
      Guardar_Direccion(
        variable_4,
        variable_5,
        variable_6,
        variable_7,
        variable_8,
        variable_9,
        "P",
        variable_2
      );
      $("#myModal").modal("hide");
      Cancelar();
      Command: toastr["success"](
        "En Buena Hora!, El registro se guardo con Exito!"
      );
      dat_consulta();
    } else {
      Command: toastr["error"](
        "El registro no se guardo, vuelvalo a intentar !"
      );
    }
  });
}

function moddocumento(
  variable_0,
  variable_1,
  variable_2,
  variable_3,
  variable_4,
  variable_5,
  variable_6,
  variable_7,
  variable_8,
  variable_9
) {
  $.ajax({
    url: "./model/clientes/entidad.php",
    type: "POST",
    data:
      "variable_0=" +
      variable_0 +
      "&variable_1=" +
      variable_1 +
      "&variable_2=" +
      variable_2 +
      "&variable_3=" +
      variable_3 +
      "&variable_4=" +
      variable_4 +
      "&variable_5=" +
      variable_5 +
      "&variable_6=" +
      variable_6 +
      "&variable_7=" +
      variable_7 +
      "&variable_8=" +
      variable_8 +
      "&variable_9=" +
      variable_9 +
      "&boton=modificar",
  }).done(function (resp) {
    if (resp == "exito") {
      Mod_Direccion(
        variable_4,
        variable_5,
        variable_6,
        variable_7,
        variable_8,
        variable_9,
        "P",
        variable_0
      );
      $("#myModal").modal("hide");
      Cancelar();
      Command: toastr["success"](
        "En Buena Hora!, El registro se Actualizo con Exito!"
      );
      dat_consulta();
    } else {
      Command: toastr["error"](
        "El registro no se actualizo, vuelvalo a intentar !"
      );
    }
  });
}

function Mod_Direccion(
  variable_1,
  variable_2,
  variable_3,
  variable_4,
  variable_5,
  variable_6,
  variable_7,
  variable_8
) {

  $.ajax({
    url: "./model/direccion-cliente/entidad.php",
    type: "POST",
    data:
    "variable_0=''" +
    "&variable_1=" +
    variable_1 +
    "&variable_2=" +
    variable_2 +
    "&variable_3=" +
    variable_3 +
    "&variable_4=" +
    variable_4 +
    "&variable_5=" +
    variable_5 +
    "&variable_6=" +
    variable_6 +
    "&variable_7=" +
    variable_7 +
    "&variable_8=" +
    variable_8 +
      "&boton=modificar",
  }).done(function (resp) {

 
  });
}


function deldocumento_cli(codigo) {

  $.ajax({
    url: "./model/clientes/entidad.php",
    type: "POST",
    data: "codigo=" + codigo + "&boton=eliminar",
  }).done(function (resp) {
  
    if (resp == "exito") {
       Command: toastr["success"]("En Buena Hora!, El registro se Elimino con Exito!")
      dat_consulta();
      estado = true;
    } else {
      Command: toastr["error"](
        "El registro no se elimino, vuelvalo a intentar !"
      );
      estado = false;
    }
  });
}

function loadEdicion(codigo) {
  var variable_1 = codigo;

  $.ajax({
    type: "POST",
    data: "codigo=" + variable_1,
    url: "./model/clientes/editar.php",
    success: function (valores) {

      var datos = eval(valores);

      document.getElementById("a-id").value = datos[0];
      document.getElementById("a-tipo").value = datos[1];

      document.getElementById("a-doc").value = datos[2];
      document.getElementById("n-doc").value = datos[2];
      document.getElementById("a-nom").value = datos[3];
      document.getElementById("a-dir").value = datos[4];
      var idpais = datos[5];
      document.getElementById("a-pais").value = idpais.substr(0, 2);
      document.getElementById("id-pais").value = idpais.substr(0, 2);
      document.getElementById("a-ubigeo").value = datos[6];
      document.getElementById("a-email").value = datos[7];
      document.getElementById("a-urb").value = datos[8];
      document.getElementById("a-local").value = datos[9];
      var datodpt = datos[6];
      document.getElementById("a-dpt").value = datodpt.substr(0, 2);
      loadprovincias(true, datodpt.substr(0, 4), datodpt.substr(0, 6));
      var datospais = datos[5];
      document.getElementById(
        "select2-a-pais-container"
      ).innerHTML = datospais.substr(2, 50);
    },
  });
  loadmodal();
}

//----- INSERTAR LA DIRECCIÒN DEL CLIENTE ------//
function Guardar_Direccion(
  variable_1,
  variable_2,
  variable_3,
  variable_4,
  variable_5,
  variable_6,
  variable_7,
  variable_8
) {

  $.ajax({
    url: "./model/direccion-cliente/entidad.php",
    type: "POST",
    data:
      "variable_0=''" +
      "&variable_1=" +
      variable_1 +
      "&variable_2=" +
      variable_2 +
      "&variable_3=" +
      variable_3 +
      "&variable_4=" +
      variable_4 +
      "&variable_5=" +
      variable_5 +
      "&variable_6=" +
      variable_6 +
      "&variable_7=" +
      variable_7 +
      "&variable_8=" +
      variable_8 +
      "&boton=registrar",
  }).done(function (resp) {
 
    if (resp == "exito") {
      if (variable_7 == "S") {
        showAlert(
          "#msj-alert-d",
          "  Espere!!, Registro se guardo con exito !",
          "success",
          2000,
          " ti-pencil-alt"
        );
        LimpiarDir();
      }
    }

  });
}

function Modificar_Direccion(
  variable_0,
  variable_1,
  variable_2,
  variable_3,
  variable_4,
  variable_5,
  variable_6,
  variable_7,
  variable_8
) {

  $.ajax({
    url: "./model/direccion-cliente/entidad.php",
    type: "POST",
    data:
      "variable_0=" +
      variable_0+
      "&variable_1=" +
      variable_1 +
      "&variable_2=" +
      variable_2 +
      "&variable_3=" +
      variable_3 +
      "&variable_4=" +
      variable_4 +
      "&variable_5=" +
      variable_5 +
      "&variable_6=" +
      variable_6 +
      "&variable_7=" +
      variable_7 +
      "&variable_8=" +
      variable_8 +
      "&boton=modificar",
  }).done(function (resp) {

    if (resp == "exito") {
      showAlert(
        "#msj-alert-d",
        "  Espere!!, Registro actualizado con exito !",
        "success",
        2000,
        " ti-pencil-alt"
      );
      LimpiarDir();
      document.getElementById("btn-guardar-d").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
    }

  });

}

function LimpiarDir() {
  ReloadTabla()
  $("#a-id-d").val("");
  $("#a-dir-d").val("");
  $("#a-pais-d").val("");
  $("#a-dpt-d").val("");
  $("#a-prov-d").val("");
  $("#a-dist-d").val("");
  $("#a-email-d").val("");
  $("#a-local-d").val("");
  $("#a-urb-d").val("");
  $("#a-dir-d").focus()
}

$("#btn-cancelar").on("click", function () {
  Cancelar();
});

function Cancelar() {
  $("#a-id").val("");
  $("#a-tipo").val("");
  $("#a-nom").val("");
  $("#a-dir").val("");
  $("#a-pais").val("");
  $("#a-dpt").val("");
  $("#a-prov").val("");
  $("#a-dist").val("");
  $("#a-email").val("");
  $("#a-local").val("");
  $("#a-urb").val("");

  $("#a-tipo").focus();
}

function loadmodal() {
  $("#myModal").on("shown.bs.modal", function () {
    if (tipo == true) {
      Cancelar();
   
      document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
    } else if (tipo == false) {
      document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-saved'></span> Modificar Registro";
    }

    $("#a-tipo").focus();
  });

  $("#myModal").modal("show");
}

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

$("#a-dist").change(function () { });

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

//=========================== AGREGAR DIRECCIONES ADICIONALES ===============================//
function loadDir(codigo) {
  $("#a-cli-d").val(codigo);
  ReloadTabla()
  $("#myModal2").on("show.bs.modal", function () {
  
   
    document.getElementById("btn-guardar-d").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";


    $("#a-dir-d").focus();
  });

  $("#myModal2").modal("show");
}


/*CARGAMOS LAS DEPENDENCIAS 2*/
$("#a-dpt-d").change(function () {
  loadprovincias2();
});

$("#a-prov-d").change(function () {
  loaddistritos2();
});

$("#a-dist-d").change(function () { });

function loadprovincias2(estado, prov, dist) {
  $("#a-dpt-d option:selected").each(function () {
    id_provincia = $(this).val();
    $.post(
      "model/clientes/provincias.php",
      { id_provincia: id_provincia },
      function (data) {
        $("#a-prov-d").html(data);
        if (estado == true) {
          document.getElementById("a-prov-d").value = prov;
          loaddistritos2(true, dist);
          return false;
        }

        loaddistritos2();
      }
    );
  });
}

function loaddistritos2(estado, dist) {
  $("#a-prov-d option:selected").each(function () {
    id_distrito = $(this).val();
    $.post(
      "model/clientes/distritos.php",
      { id_distrito: id_distrito },
      function (data) {
        $("#a-dist-d").html(data);
        if (estado == true) {
          document.getElementById("a-dist-d").value = dist;
          $("#a-dist-d").val(dist);
        }
      }
    );
  });
}

$("#btn-guardar-d").on("click", function () {

  var variable_0 = $("#a-id-d").val();
  var variable_1 = document.getElementById("a-dir-d").value;
  var variable_2 = document.getElementById("a-pais-d").value;
  var variable_3 = document.getElementById("a-dist-d").value;
  var variable_4 = $("#a-email-d").val();
  var variable_5 = $("#a-urb-d").val();
  var variable_6 = $("#a-local-d").val();
  var variable_7 = "S";
  var variable_8 = $("#a-cli-d").val();

  if (variable_1 == "") {
    showAlert(
      "#msj-alert-d",
      "  Espere!!, Ingrese la direción Adicional !",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-dir-d").focus();
    return false;
  }

  if (variable_2 == null  || variable_2 == "" ) {

    if($("#id-pais-d").val() != ""){
       variable_2 = $("#id-pais-d").val();
    }else{
      showAlert(
        "#msj-alert",
        "  Espere!!, Seleccione el País!",
        "success",
        2000,
        " ti-pencil-alt"
      );
      $("#a-pais").focus();
      return false;
    }

  }

  if ($("#a-dpt-d").val() == null) {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el departamento!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-dpt-d").focus();
    return false;
  }

  if ($("#a-prov-d").val() == null) {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese la provincia!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-prov-d").focus();
    return false;
  }
 
  if ($("#a-dist-d").val() == null) {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el distrito!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-dist-d").focus();
    return false;
  }



  if (variable_0 == "") {
    Guardar_Direccion(
      variable_1,
      variable_2,
      variable_3,
      variable_4,
      variable_5,
      variable_6,
      variable_7,
      variable_8
    );
  } else {
   
    Modificar_Direccion(
      variable_0,
      variable_1,
      variable_2,
      variable_3,
      variable_4,
      variable_5,
      variable_6,
      variable_7,
      variable_8
    );
  }
});

