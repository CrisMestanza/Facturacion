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


$("#btn-guardar").on("click", function () {
  var variable_0 = $("#a-id").val();
  var variable_1 = document.getElementById("a-doc").value;
  var variable_2 = document.getElementById("a-nom").value;
  var variable_3 = $("#a-email").val();
  var variable_4 = document.getElementById("a-ruc").value;
  var variable_5 = document.getElementById("a-raz").value;
  var variable_6 = document.getElementById("a-cel").value;
  var variable_7 = $("#a-tel").val();
  var variable_8 = $("#a-dir").val();
  var variable_9 = $("#a-pais").val();
  var variable_10 = document.getElementById("a-dist").value;
  var variable_14 = document.getElementById("a-urb").value;
  var variable_15 = document.getElementById("a-local").value;
  var clave = document.getElementById("a-clave2").value;



  if (variable_1 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el N° documento del representante legal!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-doc").focus();
    return false;
  }

  if (variable_2 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el nombre del representante legal!",
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
      "  Espere!!, Ingrese el N° de ruc!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-ruc").focus();
    return false;
  }

  if (variable_5 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el nombre ó razón social!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-raz").focus();
    return false;
  }

  if (variable_8 == "") {
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

  if (variable_9 == null  || variable_9 == "" ) {

    if($("#id-pais").val() != ""){
       variable_9 = $("#id-pais").val();
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

  if (variable_15 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el N° de Local !",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-local").focus();
    return false;
  }

  if (variable_3 == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese el correo Electrónico !",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-email").focus();
    return false;
  }

  if (clave == "") {
    showAlert(
      "#msj-alert",
      "  Espere!!, Ingrese la contraseña!",
      "success",
      2000,
      " ti-pencil-alt"
    );
    $("#a-clave").focus();
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
      variable_10,
      variable_14,
      variable_15,
      clave
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
      variable_9,
      variable_10,
      variable_14,
      variable_15,
      clave
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
  variable_10,
  variable_11,
  variable_12,
  variable_13
) {
  $.ajax({
    url: "./model/empresas/entidad.php",
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
      "&variable_11=" +
      variable_11 +
      "&variable_12=" +
      variable_12 +
      "&variable_13=" +
      variable_13 +
      "&boton=registrar",
  }).done(function (resp) {

    if (resp == "exito") {
      Guardar_Direccion(
        variable_8,
        variable_9,
        variable_10,
        variable_7,
        variable_11,
        variable_12,
        "P",
        variable_4
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
  variable_9,
  variable_10,
  variable_11,
  variable_12,
  variable_13
) {
  $.ajax({
    url: "./model/empresas/entidad.php",
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
      "&variable_10=" +
      variable_10 +
      "&variable_11=" +
      variable_11 +
      "&variable_12=" +
      variable_12 +
      "&boton=modificar",
  }).done(function (resp) {
  
    if (resp == "exito") {
      Mod_Direccion(
        variable_8,
        variable_9,
        variable_10,
        variable_7,
        variable_11,
        variable_12,
        "P",
        variable_4
      );
      //actualizamos la clave
      mod_usuarios("X",variable_13,"","",variable_3);
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
    url: "./model/direccion-empresa/entidad.php",
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
    url: "./model/empresas/entidad.php",
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
    url: "./model/empresas/editar.php",
    success: function (valores) {
      var datos = eval(valores);

      document.getElementById("a-id").value = datos[0];
      document.getElementById("a-doc").value = datos[1];
      document.getElementById("a-nom").value = datos[2];
      document.getElementById("a-email").value = datos[3];
      document.getElementById("a-ruc").value = datos[4];
      document.getElementById("a-raz").value = datos[5];
      document.getElementById("a-cel").value = datos[6];
      document.getElementById("a-tel").value = datos[7];
      document.getElementById("a-dir").value = datos[8];
      var idpais = datos[9];
      document.getElementById("a-pais").value = idpais.substr(0, 2);
      document.getElementById("id-pais").value = idpais.substr(0, 2);
      document.getElementById("a-ubigeo").value = datos[10];
      document.getElementById("a-urb").value = datos[11];
      document.getElementById("a-local").value = datos[12];

      var datodpt = datos[10];
      document.getElementById("a-dpt").value = datodpt.substr(0, 2);
      loadprovincias(true, datodpt.substr(0, 4), datodpt.substr(0, 6));
      var datospais = datos[9];
      document.getElementById(
        "select2-a-pais-container"
      ).innerHTML = datospais.substr(2, 50);
      document.getElementById("a-clave2").value = datos[13];
    },
  });
  loadmodal();
}

$("#btn-cancelar").on("click", function () {
  Cancelar();
});

function Cancelar() {
  $("#a-id").val("");
  $("#a-doc").val("");
  $("#a-ruc").val("");
  $("#a-raz").val("");
  $("#a-nom").val("");
  $("#a-dir").val("");
  $("#a-pais").val("");
  $("#a-dpt").val("");
  $("#a-prov").val("");
  $("#a-dist").val("");
  $("#a-email").val("");
  $("#a-local").val("");
  $("#a-urb").val("");
  $("#a-cel").val("");
  $("#a-tel").val("");
  $("#a-clave2").val("");

  $("#a-doc").focus();
}

function loadmodal() {
  $("#myModal").on("shown.bs.modal", function () {
    if (tipo == true) {
      Cancelar();
      document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
    } else if (tipo == false) {
      document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-saved'></span> Modificar Registro";
    }

    $("#a-doc").focus();
  });

  $("#myModal").modal("show");
}

/*CARGAMOS LAS DEPENDENCIAS*/

$(".itemPais").select2({
  placeholder: "Selecciona el País",
  minimumInputLength: 1,
  ajax: {
    url: "./model/empresas/pais.php",
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
      "model/empresas/provincias.php",
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
      "model/empresas/distritos.php",
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

//----- INSERTAR LA DIRECCIÒN DE LA EMPRESA ------//
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
    url: "./model/direccion-empresa/entidad.php",
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
        Command: toastr["success"]("En Buena Hora!, El registro se guardo con Exito!")
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
    url: "./model/direccion-empresa/entidad.php",
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
      Command: toastr["success"]("En Buena Hora!, El registro se actualizo con Exito!")
      LimpiarDir();

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
  $("#a-tel-d").val("");
  $("#a-local-d").val("");
  $("#a-urb-d").val("");
  document.getElementById("btn-guardar-d").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
  $("#a-dir-d").focus()
}


