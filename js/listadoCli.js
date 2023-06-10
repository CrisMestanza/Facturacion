

$(document).ready(function() {
    loadLista_cabezera();
  } );

function loadLista_cabezera(){

    $.ajax({
        url:'model/anexos/anexos.php',
        type:'POST',
        data:'boton=lista-cab',
        success: function(data){
           $('#detalle-cab').html(data);
           miDataTable();
        }
    });
  }

  function  miDataTable(){

    $('#tb-hos').DataTable({
      "columnDefs": [ 
        {
            "targets": [ 0 ],
            "visible": false,
        },
        { "targets": [ 1 ],"width": "5%"},
        { "targets": [ 2 ],"width": "5%"},
        { "targets": [ 3 ],"width": "5%"},
        { "targets": [ 4 ],"width": "5%"},
        { "targets": [ 5 ],"width": "20%"},
        { "targets": [ 6 ],"width": "7%"},
        { "targets": [ 7],"width": "8%"},
        { "targets": [ 8],"width": "8%"}
        
    ],

      "language": {
      "emptyTable":			"<i>No hay datos disponibles en la tabla.</i>",
      "info":		   		"Del _START_ al _END_ de _TOTAL_ ",
      "infoEmpty":			"Mostrando 0 registros de un total de 0.",
      "infoFiltered":			"(filtrados de un total de _MAX_ registros)",
      "infoPostFix":			"(actualizados)",
      "lengthMenu":			"Mostrar _MENU_ registros",
      "loadingRecords":		"Cargando...",
      "processing":			"Procesando...",
      "search":			"<span style='font-size:15px;'>Buscar:</span>",
      "searchPlaceholder":		"Dato para buscar",
      "zeroRecords":			"No se han encontrado coincidencias.",
      "paginate": {
        "first":			"Primera",
        "last":				"Última",
        "next":				"Siguiente",
        "previous":			"Anterior"
      },
      "aria": {
        "sortAscending":	"Ordenación ascendente",
        "sortDescending":	"Ordenación descendente"
      }
    },

    "lengthMenu":		[[3,5,7, 10, 20, 25, 50, -1], [3,5,7, 10, 20, 25, 50, "Todos"]],
    "iDisplayLength":	7,

    });
}


function ver_Pdf(cod){

var str1 = cod.toString();
var str2 = str1.replace("/", "");
var doc = str2.replace("/", "");

$.ajax({
  url:'../../Api-Rest-Json/Reload/reload.php',
  type:'POST',
  data:'codigo='+ doc + '&boton=pdf-a4',
  success: function(data){

    var aMyUTF8Output = base64DecToArr(data);
    var sMyOutput = UTF8ArrToStr(aMyUTF8Output);
    var data = JSON.parse(sMyOutput);

    if(data[0].BaseDatos=='Registrado'){
      var ruta="../../../Api-Rest-Json/Repo/cpe/";
      window.open("./php/descarga_cpe.php?ruta="+ruta+ '&fichero='+ doc+".pdf", "_blank");
      }else{
  
     }
  }
});

}

function ver_Xml(cod){

  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");
  
  var ruta="../../../Api-Rest-Json/Xml/xml-firmados/";
  window.open("./php/descarga_cpe.php?ruta="+ruta+ '&fichero='+ doc+".xml", "_blank");
 
 
 }

 
function ver_Cdr(cod){
  var str1 = cod.toString();
  var str2 = str1.replace("/", "");
  var doc = str2.replace("/", "");
  
  var ruta="../../../Api-Rest-Json/Cdr/";
  window.open("./php/descarga_cpe.php?ruta="+ruta+ '&fichero=R-'+ doc+".xml", "_blank");
 
 
 }