var tipo;
var estado;

window.onload = function () {
  LoadSession();
  LoadDepartamentos();
  OcultarBoton();
};



function loadtablas(variable_1) {
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
    rows: $.get("json/"+variable_1+".json"),
    editing: {
      alwaysShow: true,
      allowView: false,
      pageToNew: true,
      position: "right",
      addText: "Nuevo Registro",
      showText:
        '<span class="fooicon fooicon-pencil" aria-hidden="true"></span> Editar Registros',
      hideText: "Cancelar",
      enabled: true,
      allowEdit: true,
      allowAdd: false,
      allowDelete: false,
      allowView: true,


      
      editRow: function (row) {
        var values = row.val();
        if (values.retorno_0 > 0) {
          tipo = false;
          loadEdicion(values.retorno_0);
        }
      },
      viewRow: function (row) {
        var values = row.val();
        $("#a-cli-d").val(values.retorno_1);
        loadDir(values.retorno_1);
      },
    },
  });
}

function dat_consulta() {

  variable_1 = document.getElementById("n-codigo-doc").innerHTML;

  if (variable_1 != "") {
    $("#miTabla").html("");

    $.ajax({
      url: "./model/empresas/entidad.php",
      type: "POST",
      data:
        "variable_1=" +
        variable_1 +
        "&boton=consultar",
    }).done(function (resp) {

      loadtablas(variable_1);
    });
  }
}
