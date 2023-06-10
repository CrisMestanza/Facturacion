
(function (a) {
    a.createModal = function (b) {
        defaults = {
            title: "",
            message: "Your Message Goes Here!",
            closeButton: true,
            scrollable: false
        };

        var b = a.extend({}, defaults, b);
        var c = (b.scrollable === true) ? 'style="height:70px; overflow-y: auto;"' : "";
        html = '<div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal" tabindex="-2">';
        html += '<div class="modal-dialog">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header">';
        html += '<button id="frm-cerrar" type="button" data-dismiss="modal" class="close"  aria-hidden="true">×</button>';
        if (b.title.length > 0) { html += '<h4 class="modal-title">' + b.title + "</h4>" } html += "</div>";
        html += '<div class="modal-body" ' + c + ">";
        html += b.message; html += "</div>";
        html += '<div class="modal-footer">';
        if (b.closeButton === true) {
            html += '<button onclick="DescargarXML()"  type="button" class="btn btn-success"><span class="fa fa-file-text"></span> Descargar Xml</button>'
            html += '<button onclick="DescargarPDF()" type="button" class="btn btn-info"><span class="fa fa-file-pdf-o"></span> Descargar Pdf</button>'
            html += '<button onclick="DescargarCDR()" type="button" class="btn btn-primary"><span class="fa fa-file-code-o"></span> Descargar Cdr</button>'
            html += '<button onclick="AbrirCorreo()" type="button" class="btn btn-warning"><span class="fa fa-envelope"></span> Enviar Correo</button>'
        }

        html += "</div>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        a("body").prepend(html);
        a("#myModal").modal().on("hidden.bs.modal", function () {

             a(this).remove()

             var variable_1 = document.getElementById('n-codigo').innerHTML;
             if (variable_1.trim() != '' && variable_1.trim() != 0) {
                location.href='./facturacion';

               
             }else{
                
             }

            
             })
    }
})(jQuery);



function VisualizarPDF(documento) {

    var pdf_link = "./dsig/Repo/cpe/" + documento + ".pdf"; //Funciona en Local y Nube
    var iframe = '<div class="iframe-container"><embed src="' + pdf_link + '" type="application/pdf" width="400" height="600"></embed></div><div id="a-cpe">' + documento + '</div>'

    $.createModal({
        title: 'Comprobante Electrónico',
        message: iframe,
        closeButton: true,
        scrollable: false
    });
    return false;
}

function AbrirCorreo() {
    $("#myModal3").modal("show");
}

function AbrirCorreo_2(cod) {
    var str1 = cod.toString();
    var str2 = str1.replace("/", "");
    var doc = str2.replace("/", "");
    document.getElementById("a-cpe-correo").value=doc.substring(0, 28);

    document.getElementById("a-correo-e").value=doc.substring(28, 150);

    $("#myModal3").modal("show");
}

function LoadCorreo_e() {
    var correo= document.getElementById("a-correo-e").value;
    var cod= document.getElementById("a-cpe-correo").value;

    if(correo==""){
        Command: toastr["error"](
            "Ingrese el Correo Electrónico!"
          );
        return false;
    }
    document.getElementById("btn-correo-e").disabled = true;
    
    var img=document.createElement("img");
    img.src="imagenes/spinner.gif";
    img.setAttribute("id", "img-correo");
    var foo = document.getElementById("div-correo");
    foo.appendChild(img);

    $.ajax({
        url: './dsig/Email/mail.php',
        type: 'POST',
        data: 'codigo=' + cod + '&correo='+correo.trim(),
        success: function (data) {
            var ultimo = document.getElementById('img-correo');
            foo.removeChild(ultimo);
               if(data=="Mensaje Enviado"){
                Command: toastr["success"](
                    " Correo electrónico enviado con exito!"
                  );

                  $("#myModal3").modal("hide");
                  dat_consulta();
               }else{

                Command: toastr["error"](
                    "  Error!!, " + data,
                  );

                showAlert(
                    "#error-correo",
                    "  Error!!, " + data,
                    "danger",
                    2000,
                    " glyphicon-remove-sign"
                  );
               }

        }
      });
      document.getElementById("btn-correo-e").disabled = false;
}

function DescargarPDF() {
    var ruta = "./dsig/Repo/cpe/";
    var archivo = document.getElementById("a-cpe").innerHTML;
    window.open("./descarga_cpe.php?ruta=" + ruta + '&fichero=' + archivo + ".pdf", "_blank");
}

function DescargarXML() {
    var ruta = "./dsig/Xml/xml-firmados/";
    var archivo = document.getElementById("a-cpe").innerHTML;
    window.open( "./descarga_cpe.php?ruta=" + ruta + '&fichero=' + archivo + ".xml", "_blank");
}

function DescargarCDR() {
    var ruta = "./dsig/Cdr/";
    var archivo = document.getElementById("a-cpe").innerHTML;
    window.open("./descarga_cpe.php?ruta=" + ruta + '&fichero=R-' + archivo + ".xml", "_blank");
}


