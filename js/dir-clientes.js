


function loadLista_cabezera() {
    var codigo = $("#a-cli-d").val();

    $.ajax({
        url: 'model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=lista-dir-cli'+'&codigo='+codigo,
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
          url: "./model/direccion-cliente/editar.php",
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

            document.getElementById("a-email-d").value = datos[4];
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
                    url: './model/direccion-cliente/entidad.php',
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