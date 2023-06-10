var tipo;
var estado;

window.onload = function () {
    LoadSession();
    OcultarBoton()
};





function loadtablas() {
    variable_1 = document.getElementById("n-codigo-doc").innerHTML;
    $('.table').footable({
        "empty": "Sin registros",
        "toggleSelector": ".footable-toggle",
        "paging": {
            "enabled": true
        },
        "filtering": {
            "placeholder": "Buscar",
            "enabled": true,
            "delay": -2,
        },
        "sorting": {
            "enabled": true
        },
        "paging": {
            "enabled": true,
            "size": 5,
            "limit": 5,
            "current": 1
        },
        "columns": [
            { "name": "retorno_0", "title": "Id", "type": "number", "visible": false, "filterable": false, "style": { "width": 30, "maxWidth": 80 } },
            { "name": "retorno_1", "title": "Nombre Comercial" },
            { "name": "retorno_2", "title": "Usuario Sol", "breakpoints": "xs sm md" },
            { "name": "retorno_3", "title": "Clave Sol", "breakpoints": "xs sm md" },
            { "name": "retorno_4", "title": "Nombre Certificado", "breakpoints": "xs sm" },
            { "name": "retorno_5", "title": "Clave Certificado", "breakpoints": "xs sm" }
        ],
        "rows": $.get("json/" + variable_1 + "-CR.json"),
        "editing": {
            "alwaysShow": true,
            "allowView": false,
            "pageToNew": true,
            "position": "right",
            "addText": "<span class='fa fa-plus-circle'></span> Nuevo Registro",
            "showText": '<span class="fooicon fooicon-pencil" aria-hidden="true"></span> Editar Registros',
            "hideText": "Cancelar",
            "enabled": true,
            "allowEdit": true,
            "allowAdd": true,
            "allowDelete": true,

            addRow: function () {
                tipo = true;
                loadmodal()
            },
            deleteRow: function (row) {
                var values = row.val();
               
                if (values.retorno_0 > 0) {
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

                            deldocumento(values.retorno_0);
                            if (estado == true) {
                                row.delete();
                            }

                        });
                }

            },
            editRow: function (row) {
                var values = row.val();
                tipo = false;

                if (values.retorno_0 > 0) {
                    loadEdicion(values.retorno_0)
                }

            },

        }
    });


}


function dat_consulta() {

    variable_1 = document.getElementById("n-codigo-doc").innerHTML;

    if (variable_1 != "") {
        $("#miTabla").html("");
        $.ajax({
            url: './model/usuarios-sunat/entidad.php',
            type: 'POST',
            data: 'variable_1=' + variable_1 + '&variable_2=CR' + "&boton=consultar"
        }).done(function (resp) {
                loadtablas()           

        });
    }

}

$('#btn-guardar').on('click', function () {
    var variable_0 = $('#a-id').val();
    var variable_1 = $('#a-com').val();
    var variable_2 = document.getElementById("a-usuariosunat").value;
    var variable_3 = $('#a-clavesunat').val();
    var variable_4 = document.getElementById("a-clavecert").value
    var variable_5 = document.getElementById("n-codigo-doc").innerHTML;

    if (variable_1 == '') {
        showAlert("#msj-alert", "  Espere!!, Ingreso Nombre comercial de la empresa!", "success", 2000, " ti-pencil-alt");
        $('#a-com').focus();
        return false;
    }

    if (variable_2 == '') {
        showAlert("#msj-alert", "  Espere!!, Ingrese el usuario secundario de clave sol  !", "success", 2000, " ti-pencil-alt");
        $('#a-usuariosunat').focus();
        return false;
    }

    if (variable_3 == "") {
        showAlert("#msj-alert", "  Espere!!, Ingrese la clave secundaria de clave sol!", "success", 2000, " ti-pencil-alt");
        $('#a-clavesunat').focus();
        return false;
    }

    if (variable_4 == "") {
        showAlert("#msj-alert", "  Espere!!,Ingrese la clave del  certificado digital !", "success", 2000, " ti-pencil-alt");
        $('#a-clavecert').focus();
        return false;
    }



    if (variable_0 == '') {
        guadocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5);

    } else {
        moddocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5);

    }
});

function guadocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5) {

    //GUARDAMOS EL ARCHIVO
    const ArchivoPfx = $('#archivo').prop('files')[0];

    var formData = new FormData();
    var files = $('#archivo')[0].files[0];
    formData.append('file',files);

    if(files==undefined){
        showAlert("#msj-alert", "  Espere!!, Seleccione el Certificado a Actualizar!", "success", 2000, " ti-pencil-alt");
        return false;
       }

    if (ArchivoPfx.type !== 'application/x-pkcs12') {
        Command: toastr["error"]("El archivo del certiicado no es valido, suba uno bueno !")
        return false;
      }

    $.ajax({
        url: './model/usuarios-sunat/upload.php',
        type: 'post',
        data: formData ,
        contentType: false,
        processData: false,
        success: function(response) {

            var rpta= response.substring(0,1);
            if(rpta=="1"){
                variable_6=response.substring(1,100);
                $.ajax({
                    url: './model/usuarios-sunat/entidad.php',
                    type: 'POST',
                    data: 'variable_0=' + variable_0 + '&variable_1=' + variable_1 + '&variable_2=' + variable_2 + '&variable_3=' + variable_3 + '&variable_4=' + variable_4 + '&variable_5=' + variable_5 + '&variable_6=' + variable_6 + "&boton=registrar"
                }).done(function (resp) {
                   
                    if (resp == 'exito') {
                        $("#myModal").modal("hide");
                        Cancelar();
                        Command: toastr["success"]("En Buena Hora!, El registro se guardo con Exito!")
                        dat_consulta();
                    } else {
                        Command: toastr["error"]("El registro no se guardo, vuelvalo a intentar !")
            
                    }
            
                });

            }else{

            }

        }
    });


}

function moddocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6) {
       //GUARDAMOS EL ARCHIVO
       const ArchivoPfx = $('#archivo').prop('files')[0];

       var formData = new FormData();
       var files = $('#archivo')[0].files[0];
       formData.append('file',files);
    
       if(files==undefined){
        showAlert("#msj-alert", "  Espere!!, Seleccione el Certificado a Actualizar!", "success", 2000, " ti-pencil-alt");
        return false;
       }
   
       if (ArchivoPfx.type !== 'application/x-pkcs12') {
           Command: toastr["error"]("El archivo del certiicado no es valido, suba uno bueno !")
           return false;
         }
   
    $.ajax({
        url: './model/usuarios-sunat/upload.php',
        type: 'post',
        data: formData ,
        contentType: false,
        processData: false,
        success: function(response) {
    
            var rpta= response.substring(0,1);
            if(rpta=="1"){
                variable_6=response.substring(1,100);
                $.ajax({
                    url: './model/usuarios-sunat/entidad.php',
                    type: 'POST',
                    data: 'variable_0=' + variable_0 + '&variable_1=' + variable_1 + '&variable_2=' + variable_2 + '&variable_3=' + variable_3 + '&variable_4=' + variable_4 + '&variable_5=' + variable_5 + '&variable_6=' + variable_6 + "&boton=modificar"
                }).done(function (resp) {
                   
                    if (resp == 'exito') {
                        $("#myModal").modal("hide");
                        Cancelar();
                        Command: toastr["success"]("En Buena Hora!, El registro se guardo con Exito!")
                        dat_consulta();
                    } else {
                        Command: toastr["error"]("El registro no se guardo, vuelvalo a intentar !")
            
                    }
            
                });

            }else{

            }

        }
    });
    


}

function deldocumento(codigo) {

    $.ajax({
        url: './model/usuarios-sunat/entidad.php',
        type: 'POST',
        data: 'codigo=' + codigo + "&boton=eliminar"
    }).done(function (resp) {
        if (resp == 'exito') {
             Command: toastr["success"]("En Buena Hora!, El registro se Elimino con Exito!")
            dat_consulta();
            estado = true;
        } else {
            Command: toastr["error"]("El registro no se elimino, vuelvalo a intentar !")
            estado = false;
        }

    });
}

function loadEdicion(codigo) {
    var variable_1 = codigo;
 
    $.ajax({
        type: 'POST',
        data: 'codigo=' + variable_1,
        url: './model/usuarios-sunat/editar.php',
        success: function (valores) {

            var datos = eval(valores);

            document.getElementById("a-id").value = datos[0];
            document.getElementById("a-com").value = datos[1];
            document.getElementById("a-usuariosunat").value = datos[2];
            document.getElementById("a-clavesunat").value = datos[3];
            document.getElementById("a-clavecert").value = datos[4];

        }

    });

    loadmodal()

}


$('#btn-cancelar').on('click', function () {
    Cancelar();
});


function Cancelar() {
    $('#a-id').val('');
    $('#a-com').val('');
    $('#a-usuariosunat').val('');
    $('#a-clavesunat').val('');
    $('#a-clavecert').val('');
    $('#archivo').innerHTML = "";
    $('#archivo').value = "";
    document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
    $('#a-com').focus();

}


function loadmodal() {
    $('#myModal').on('shown.bs.modal', function () {

        if (tipo == true) {
            Cancelar();   
            document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
          } else if (tipo == false) {

            document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-saved'></span> Modificar Registro";
          }

        $('#a-cod').focus();
    });

    $("#myModal").modal("show");
}

/*CARGAMOS LAS DEPENDENCIAS*/

