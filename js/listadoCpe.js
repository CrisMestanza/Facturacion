
$(document).ready(function () {
  LoadSession();
  OcultarBoton();
});

function dat_consulta() {
  var table = $('#tb-hos').DataTable();
  table.destroy();
  loadLista_cabezera();
}

function loadLista_cabezera() {
  $.ajax({
    url: 'model/anexos/anexos.php',
    type: 'POST',
    data: 'boton=lista-cab&rucempresa=' + document.getElementById("n-codigo-doc").innerHTML,
    success: function (data) {
      $('#detalle-cab').html(data);
      miDataTable();
    }
  });
}

function ReloadTabla() {
  //var table = $('#tb-hos').DataTable();
  //table.destroy();
  loadLista_cabezera()
}



function miDataTable() {

  $('#tb-hos').DataTable({
    "columnDefs": [
      {
        "targets": [0],
        "visible": false,
      },
      { "targets": [1], "width": "5%" },
      { "targets": [2], "width": "5%" },
      { "targets": [3], "width": "5%" },
      { "targets": [4], "width": "5%" },
      { "targets": [5], "width": "20%" },
      { "targets": [6], "width": "7%" },
      { "targets": [7], "width": "8%" },
      { "targets": [8], "width": "8%" }

    ],
    "bDestroy": true,
    'paging'      : true,
    'lengthChange': false,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false,
    "scrollY"     : "500px",
    "scrollCollapse": false,
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


function envdocumento(cod, estadocdr) {

  //Procurar en adelante tener el Json Empresa y Factura en modo Consulta y no en el directorio
  //porque si se borran dara error.
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");
  if (estadocdr == 0 || estadocdr == 2) {


    swal({
      title: "Información",
      text: "Desea Enviar el comprobante Electrónico a SUNAT !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Sí",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
      function () {

        $.ajax({
          url: './dsig/Reload/reload.php',
          type: 'POST',
          data: 'codigo=' + doc + '&boton=enviar-cpe',
          success: function (data) {
            timeoutID = window.setTimeout(EnvioSUNAT, 2000, data, doc, true, "On");
            //fina de envio
            $('#myModal2').on('show.bs.modal', function () {
              document.getElementById('envios-cpe').innerHTML = 1;
              document.getElementById('tipo-envio').innerHTML = "Enviado Comprobante a Sunat";
              document.getElementById('cpe-id').innerHTML = doc;
              BuscarCDR1(doc);
            });


            $("#myModal2").modal("show");


          }
        });



      });
  } else {
    Command: toastr["error"](
      " Espere!!, El comprobante Electrónico no se puede Enviar Nuevamente, su estado es Enviado a SUNAT")
  }



}

function anuldocumento(cod, estadocdr, estadocpe, ticket) {
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");
  document.getElementById('btn-ticket-e').disabled = true;



  if (estadocdr == 1) {

    if (estadocpe == 0) {



      swal({
        title: "Información",
        text: "Desea Anular el comprobante Electrónico !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí",
        cancelButtonText: "No",
        closeOnConfirm: true
      },
        function () {
          document.getElementById('cod-baja').innerHTML = doc;
          if(ticket==undefined){
          }else{
            document.getElementById('btn-ticket-e').disabled = false;
            document.getElementById('ticket-baja').innerHTML = ticket;
          }
          $("#myModal-baja").modal("show");
        });

    } else {

      Command: toastr["info"](
        " Espere!!, El comprobante Electrónico se encuentra Anulado, su estado es Enviado a SUNAT")
    }
  } else {
    Command: toastr["error"](
      " Espere!!, El comprobante Electrónico no se puede Anular, su estado es No Enviado a SUNAT")
  }


}

function eddocumento(cod, estadocdr) {

  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");


  if (estadocdr == 0 || estadocdr == 2) {


    swal({
      title: "Información",
      text: "Desea Editar el comprobante Electrónico !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Sí",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
      function () {
        location.href = 'facturacion?codigo=' + doc;
      });
  } else {
    Command: toastr["error"](
      " Espere!!, El comprobante Electrónico no se puede editar, su estado es Enviado a SUNAT")
  }
}

function deldocumento(cod, estadocdr) {
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");
  if (estadocdr == 0 || estadocdr == 2) {


    swal({
      title: "Información",
      text: "Desea Eliminar el comprobante Electrónico, NO RECOMENDADO !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Sí",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
      function () {

        $.ajax({
          url: "./model/001/entidad.php",
          type: "POST",
          data:
            "codigo=" +
            doc +
            "&boton=eliminar",
        }).done(function (resp) {


          if (resp == "exito") {

            Command: toastr["success"](
              "En Buena Hora!, El registro se Elimino con Exito!"
            );
            ReloadTabla();

          } else {
            Command: toastr["error"](
              "El registro no se actualizo, vuelvalo a intentar !"
            );
          }
        });



      });
  } else {
    Command: toastr["error"](
      " Espere!!, El comprobante Electrónico no se puede Eliminar, su estado es Enviado a SUNAT")
  }
}

function errdocumento(cod) {
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");



  $.ajax({
    url: "./model/001/entidad.php",
    type: "POST",
    data:
      "codigo=" +
      doc +
      "&boton=consultar-error",
  }).done(function (resp) {
    $('#myModal_error').on('show.bs.modal', function () {
      $("#a-txt-error").val(resp);
      document.getElementById('error-cpe-a').innerHTML = "Comprobante Electrónico N° :" + doc;
    });
    $("#myModal_error").modal("show");


  });

}


function ver_Pdf(cod) {

  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");

  $.ajax({
    url: './dsig/Reload/reload.php',
    type: 'POST',
    data: 'codigo=' + doc + '&boton=pdf',
    success: function (data) {
      //Procurar en adelante tener el Json Empresa y Factura en modo Consulta y no en el directorio
      //porque si se borran dara error.
      var aMyUTF8Output = base64DecToArr(data);
      var sMyOutput = UTF8ArrToStr(aMyUTF8Output);
      var data = JSON.parse(sMyOutput);

      if (data[0].BaseDatos == 'Registrado') {
        var ruta = "./dsig/Repo/cpe/";
        window.open("./descarga_cpe.php?ruta=" + ruta + '&fichero=' + doc + ".pdf", "_blank");
      } else {

      }
    }
  });

}

function ver_Xml(cod) {

  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");

  var ruta = "./dsig/Xml/xml-firmados/";
  window.open("./descarga_cpe.php?ruta=" + ruta + '&fichero=' + doc + ".xml", "_blank");

}


function ver_Cdr(cod) {
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");

  var ruta = "./dsig/Cdr/";
  window.open("./descarga_cpe.php?ruta=" + ruta + '&fichero=R-' + doc + ".xml", "_blank");

}