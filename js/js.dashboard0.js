
$(function () {
    LoadSession();
    LoadWidget()
    loadDashboard()
    GraficoPastel()
    OcultarBoton()
    $("#btn-refrescar").hide();
})

function dat_consulta() {



    $.ajax({
        url: 'model/anexos/graficos.php',
        type: 'POST',
        data: 'boton=consulta',
        success: function (data) {

            $('#tb-lista').html(data);
             miDataTable();
        }
    });
}

function LoadTabla(){
    var table = $('#tb-lista').DataTable();
    table.destroy();
    dat_consulta()
}




function miDataTable() {

    $('#tb-lista').DataTable({
        "columnDefs": [
            { "targets": [0], "width": "50%" },
            { "targets": [1], "width": "10%" },
            { "targets": [2], "width": "10%" },
            { "targets": [3], "width": "10%" },
            { "targets": [4], "width": "10%" },
            { "targets": [5], "width": "10%" }


        ],
        "bDestroy": true,
        "paging": false,
        "searching": false,
        "orderable": false,
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
function LoadWidget() {

    $.ajax({
        url: './model/anexos/graficos.php',
        type: 'POST',
        data: 'boton=widget',
        success: function (data) {

            //inicio ajax
            var content = JSON.parse(data);
            if(content[0].f==null){
                document.getElementById("v-t1").innerHTML =0;
            }else{
                document.getElementById("v-t1").innerHTML = content[0].f;
            }

            if(content[0].b==null){
                document.getElementById("v-t2").innerHTML =0;
            }else{
                document.getElementById("v-t2").innerHTML = content[0].b;
            }

            if(content[0].nc==null){
                document.getElementById("v-t3").innerHTML =0;
            }else{
                document.getElementById("v-t3").innerHTML = content[0].nc;
            }

            if(content[0].nd==null){
                document.getElementById("v-t4").innerHTML =0;
            }else{
                document.getElementById("v-t4").innerHTML = content[0].nd;
            }



        }

    });



}


function GraficoPastel() {

    var oilCanvas = document.getElementById("oilChart");

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;

    $.ajax({
        url: './model/anexos/graficos.php',
        type: 'POST',
        data: 'boton=cuadro',
        success: function (data) {

            //inicio ajax
            var content = JSON.parse(data);

            var oilData = {
                labels: [
                    "Ventas Totales",
                    "Devoluciones",
                    "Anulados"
                ],
                datasets: [
                    {
                        data: [content[0].tv, content[0].dv, content[0].an],
                        backgroundColor: [
                            "#63FF84",
                            "#6384FF",
                            "#FF6384"
                        ]
                    }]
            };

            var pieChart = new Chart(oilCanvas, {
                type: 'pie',
                data: oilData
            });


        }

    });
}

function loadDashboard() {


    //Destruimos el canvas
    document.getElementById("chartContainer1").innerHTML = '&nbsp;';
    document.getElementById("chartContainer1").innerHTML = '<canvas id="chart1"></canvas>';

    document.getElementById("chartContainer2").innerHTML = '&nbsp;';
    document.getElementById("chartContainer2").innerHTML = '<canvas id="chart2"></canvas>';

    document.getElementById("chartContainer3").innerHTML = '&nbsp;';
    document.getElementById("chartContainer3").innerHTML = '<canvas id="chart3"></canvas>';


    $.ajax({
        url: './model/anexos/graficos.php',
        type: 'POST',
        data: 'boton=inicio',
        success: function (data) {

            //inicio ajax
            var content = JSON.parse(data);


            //......... GRAFICO ENVIADOS ........//
            document.getElementById("chart1").value = null;
            var ctx = document.getElementById("chart1");


            var data = {
                labels: ["Facturas", "Boletas", "Notas de Crédito", "Notas de Débito"],
                datasets: [{
                    label: 'Enviados',
                    data: [content[0].f, content[0].b, content[0].nc, content[0].nd],
                    backgroundColor: [
                        'rgba(60, 179, 113, 0.7)',
                        'rgba(0, 0, 255, 0.7)',
                        'rgba(255, 165, 0, 0.7)',
                        'rgba(106, 90, 205, 0.8)',
                    ],
                    borderColor: [
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                    ],
                    borderWidth: 2
                }]
            };
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            var chart1 = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });



            //......... GRAFICO NO ENVIADOS ........//

            document.getElementById("chart2").value = null;
            var ctx = document.getElementById("chart2");

            var data = {
                labels: ["Facturas", "Boletas", "Notas de Crédito", "Notas de Débito"],
                datasets: [{
                    label: 'No Enviados',
                    data: [content[0].fn, content[0].bn, content[0].ncn, content[0].ndn],
                    backgroundColor: [
                        'rgba(60, 179, 113, 0.7)',
                        'rgba(0, 0, 255, 0.7)',
                        'rgba(255, 165, 0, 0.7)',
                        'rgba(106, 90, 205, 0.8)',
                    ],
                    borderColor: [
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                    ],
                    borderWidth: 2
                }]
            };
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            var chart2 = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });



            //......... GRAFICO CON ERRORES ........//


            document.getElementById("chart3").value = null;
            var ctx3 = document.getElementById("chart3");
            var data = {
                labels: ["Facturas", "Boletas", "Notas de Crédito", "Notas de Débito"],
                datasets: [{
                    label: 'Con Errores',
                    data: [content[0].fe, content[0].be, content[0].nce, content[0].nde],
                    backgroundColor: [
                        'rgba(60, 179, 113, 0.7)',
                        'rgba(0, 0, 255, 0.7)',
                        'rgba(255, 165, 0, 0.7)',
                        'rgba(106, 90, 205, 0.8)',
                    ],
                    borderColor: [
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                        'rgba(200,200,200,1)',
                    ],
                    borderWidth: 2
                }]
            };
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            var chart3 = new Chart(ctx3, {
                type: 'bar',
                data: data,
                options: options
            });


            //fin del ajax
        }
    });
}
