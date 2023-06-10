


function loadLista_cabezera() {
    var codigo = $("#a-cli-d").val();
 
    $.ajax({
        url: 'model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=lista-dir-emp'+'&codigo='+codigo,
        success: function (data) {
          
            $('#detalle-dir').html(data);
            miDataTable();
        }
    });
}

function ReloadTabla() {
    var table = $('#tb-dir').DataTable();
    table.destroy();

    loadLista_cabezera()
}



function miDataTable() {

    $('#tb-dir').DataTable({
        "columnDefs": [
            {
                "targets": [0],
                "visible": false,
            },
            { "targets": [1], "width": "5%" },
            { "targets": [2], "width": "50%" },
            { "targets": [3], "width": "15%" },
            { "targets": [4], "width": "15%" },
            { "targets": [5], "width": "15%" }

        ],
        "bDestroy": true,
        "language": {
            "emptyTable": "<i>No hay datos disponibles en la tabla.</i>",
            "info": "Del _START_ al _END_ de _TOTAL_ ",
            "infoEmpty": "Mostrando 0 registros de un total de 0.",
            "infoFiltered": "(filtrados de un total de _MAX_ registros)",
            "infoPostFix": "(actualizados)",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "<span style='font-size:15px;'>Buscar:</span>",
            "searchPlaceholder": "Dato para buscar",
            "zeroRecords": "No se han encontrado coincidencias.",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": "Ordenación ascendente",
                "sortDescending": "Ordenación descendente"
            }
        },

        "lengthMenu": [[3, 5, 7, 10, 15, 20, 25, 50, -1], [3, 5, 7, 10, 15, 20, 25, 50, "Todos"]],
        "iDisplayLength": 15,

    });
}



function eddocumento(cod) {

    var str1 = cod.toString();
    var str2 = str1.replace("/", "");
    var doc = str2.replace("/", "");
      
        $.ajax({
          type: "POST",
          data: "codigo=" + doc,
          url: "./model/direccion-empresa/editar.php",
          success: function (valores) {
         
            var datos = eval(valores);
      
            document.getElementById("a-id-d").value = datos[0];
            document.getElementById("a-dir-d").value = datos[1];
            var idpais = datos[2];
            document.getElementById("a-pais-d").value = idpais.substr(0, 2);
            document.getElementById("id-pais-d").value = idpais.substr(0, 2);
            var datodpt = datos[3];
            document.getElementById("a-dpt-d").value = datodpt.substr(0, 2);

            loadprovincias2(true, datodpt.substr(0, 4), datodpt.substr(0, 6));
            var datospais = datos[2];
            document.getElementById(
              "select2-a-pais-d-container"
            ).innerHTML = datospais.substr(2, 50);

            document.getElementById("a-tel-d").value = datos[4];
            document.getElementById("a-urb-d").value = datos[5];
            document.getElementById("a-local-d").value = datos[6];
            document.getElementById("btn-guardar-d").innerHTML = "<span class='glyphicon glyphicon-floppy-saved'></span> Modificar Registro";
          },
        });


}

function deldocumento(cod) {
    var str1 = cod.toString();
    var str2 = str1.replace("/", "");
    var doc = str2.replace("/", "");
      
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

                $.ajax({
                    url: './model/direccion-empresa/entidad.php',
                    type: 'POST',
                    data: 'codigo=' + doc + "&boton=eliminar"
                }).done(function (resp) {
                    if (resp == 'exito') {
                        ReloadTabla()
                         Command: toastr["success"]("En Buena Hora!, El registro se Elimino con Exito!")
 
                    } else {
                        Command: toastr["error"]("El registro no se elimino, vuelvalo a intentar !")
    
                    }
            
                });

            });
  

}



//=========================== AGREGAR DIRECCIONES ADICIONALES ===============================//
function loadDir(codigo) {
  $("#a-cli-d").val(codigo);
  ReloadTabla()

    $("#myModal2").on("shown.bs.modal", function () {    
    
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
        "model/empresas/provincias.php",
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
        "model/empresas/distritos.php",
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
    var variable_4 = $("#a-tel-d").val();
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

  

