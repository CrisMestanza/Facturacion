var tipo;
var estado;

window.onload = function () {
    LoadSession();
    loadTipo_Comprobante() ;
    OcultarBoton()


};

/*CARGAMOS LAS DIRECCIONES DEL CLIENTE SELECCIONADO*/
function LoadDireccion(codigo) {

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=dir-empresa' +'&codigo=' + codigo,
        success: function (data) {
            $("#a-dir").html(data);

        }
    });
}

function loadTipo_Comprobante() {

    $.ajax({
        url: './model/anexos/anexos.php',
        type: 'POST',
        data: 'boton=tipo-comp',
        success: function (data) {
            $('#a-comp').html(data);

        }
    });
}



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
            { "name": "retorno_1", "title": "Serie" },
            { "name": "retorno_2", "title": "Número", "breakpoints": "xs sm md" },
            { "name": "retorno_3", "title": "Comprobante", "breakpoints": "xs sm md" },
            { "name": "retorno_4", "title": "Dirección", "breakpoints": "xs sm" }
        ],
        "rows": $.get("json/" + variable_1 + "-N.json"),
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
            url: './model/numeracion/entidad.php',
            type: 'POST',
            data: 'variable_1=' + variable_1 + '&variable_2=N' + "&boton=consultar"
        }).done(function (resp) {
                LoadDireccion(variable_1)
                loadtablas()           

        });
    }

}

$('#btn-guardar').on('click', function () {
    var variable_0 = $('#a-id').val();
    var variable_1 = $('#a-serie').val();
    var variable_2 = document.getElementById("a-numero").value;
    var variable_3 = $('#a-dir').val();
    var variable_4 = document.getElementById("a-comp").value
    var variable_5 = document.getElementById("n-codigo-doc").innerHTML + '-' + $('#a-serie').val() + '-' + $('#a-numero').val();
    var variable_6 = document.getElementById("n-codigo-doc").innerHTML;

    if (variable_1 == '') {
        showAlert("#msj-alert", "  Espere!!, Ingreso la serie!", "success", 2000, " ti-pencil-alt");
        $('#a-serie').focus();
        return false;
    }

    if (variable_2 == '') {
        showAlert("#msj-alert", "  Espere!!, Ingrese el número !", "success", 2000, " ti-pencil-alt");
        $('#a-numero').focus();
        return false;
    }

    if (variable_3 == null) {
        showAlert("#msj-alert", "  Espere!!, Seleccione la dirección!", "success", 2000, " ti-pencil-alt");
        $('#a-dir').focus();
        return false;
    }

    if (variable_4 == null) {
        showAlert("#msj-alert", "  Espere!!, Seleccione el comprobante!", "success", 2000, " ti-pencil-alt");
        $('#a-comp').focus();
        return false;
    }



    if (variable_0 == '') {
        guadocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6);

    } else {
        moddocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6);

    }
});

function guadocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6) {

    $.ajax({
        url: './model/numeracion/entidad.php',
        type: 'POST',
        data: 'variable_1=' + variable_1 + '&variable_2=' + variable_2 + '&variable_3=' + variable_3 + '&variable_4=' + variable_4 + '&variable_5=' + variable_5 + '&variable_6=' + variable_6 + "&boton=registrar"
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
}

function moddocumento(variable_0, variable_1, variable_2, variable_3, variable_4, variable_5, variable_6) {
    $.ajax({
        url: './model/numeracion/entidad.php',
        type: 'POST',
        data: 'variable_0=' + variable_0 + '&variable_1=' + variable_1 + '&variable_2=' + variable_2 + '&variable_3=' + variable_3 + '&variable_4=' + variable_4 + '&variable_5=' + variable_5 + '&variable_6=' + variable_6 + "&boton=modificar"
    }).done(function (resp) {
      
        if (resp == 'exito') {
            $("#myModal").modal("hide");
            Cancelar();
            Command: toastr["success"]("En Buena Hora!, El registro se Actualizo con Exito!")
            dat_consulta();
        } else {
            Command: toastr["error"]("El registro no se actualizo, vuelvalo a intentar !")
        }

    });

}

function deldocumento(codigo) {

    $.ajax({
        url: './model/numeracion/entidad.php',
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
        url: './model/numeracion/editar.php',
        success: function (valores) {

            var datos = eval(valores);

            document.getElementById("a-id").value = datos[0];
            document.getElementById("a-serie").value = datos[1];
            document.getElementById("a-numero").value = datos[2];
            document.getElementById("a-dir").value = datos[3];
            document.getElementById("a-comp").value = datos[4];

        }

    });

    loadmodal()

}


$('#btn-cancelar').on('click', function () {
    Cancelar();
});


function Cancelar() {
    $('#a-id').val('');
    $('#a-serie').val('');
    $('#a-numero').val('');
    document.getElementById("btn-guardar").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span> Guardar Registro";
    $('#a-serie').focus();

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

