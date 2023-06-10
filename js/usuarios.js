

function mod_usuarios(variable_0, variable_1, variable_2, variable_3, variable_4) {
    $.ajax({
        url: "./model/usuarios/entidad.php",
        type: "POST",
        data:
            "variable_0=" +
            variable_0 +
            "&variable_1=" +
            variable_1 +
            "&variable_2=" +
            variable_2 +
            "&variable_3=" +
            variable_3 +
            "&variable_4=" +
            variable_4 +
            "&boton=modificar",
    }).done(function (resp) {

        if (variable_0 == "X") {
            return false;
        }

        if (resp == "exito") {

            Command: toastr["success"](
                "En Buena Hora!, El registro se Actualizo con Exito!"
            );

        } else {
            Command: toastr["error"](
                "El registro no se actualizo, vuelvalo a intentar !"
            );
        }
    });
}