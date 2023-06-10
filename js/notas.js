
$("#btn-ref").click(function () {
  Load_ModalNotas()
});

$("#btn-buscar-ref").click(function () {

  //$("#tb-nota").dataTable().fnDestroy();
  //$('#tb-nota').dataTable().fnClearTable()
  //$('#detalle-nota').html('');
  var table = $('#tb-nota').DataTable();
  table.destroy();


  var codigo = $("#a-txt-bref").val();


  $.ajax({
    url: 'model/anexos/anexos.php',
    type: 'POST',
    data: 'boton=lista-nota' + '&codigo=' + codigo + '&rucempresa=' + document.getElementById("n-codigo-doc").innerHTML,
    success: function (data) {
      if (data == "error") {

      } else {
        $('#detalle-nota').html(data);
        miDataTable();
      }




    }
  });


});


//https://www.youtube.com/watch?v=tnA2yc47gxg
function miDataTable() {

  $('#tb-nota').DataTable({
    "destroy": true,
    "scrollCollapse": true,
    "deferRender": true,
    "paging": true,
    "scroller": false,
    "columnDefs": [
      { "targets": [0], "width": "2%" },
      { "targets": [1], "width": "10%" },
      { "targets": [2], "width": "4%" },
      { "targets": [3], "width": "4%" },
      { "targets": [4], "width": "15%" },
      { "targets": [5], "width": "4%" }
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

    "lengthMenu": [[3, 5, 7, 10, 20, 25, 50, -1], [3, 5, 7, 10, 20, 25, 50, "Todos"]],
    "iDisplayLength": 7,

  });
}


//Abriri Modal
function Load_ModalNotas() {
  $('#myModal').on('shown.bs.modal', function () {

  });

  $("#myModal").modal("show");

}


function add_referencia(cod) {
  var variable_1 = document.getElementById('n-codigo').innerHTML;
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");
  $('#a-ref-cpe').val(doc);

  var tipo = doc.substring(12, 14);
  if (tipo == '01') {
    tipo = 'FAC / ';
  } else if (tipo == '03') {
    tipo = 'BOL / ';

  }

  var cpe = tipo + doc.substring(15, 28);
  $('#a-referencia').val(cpe);
  $("#myModal").modal("hide");

  if (variable_1.trim() == '' || variable_1.trim() == 0 ) {
    Buscar_CPE(doc);
  }
  
}



