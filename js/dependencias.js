
      $('.itemName').select2({
        placeholder: 'Selecciona una categoría',
        minimumInputLength: 1,
        ajax: {
          url: 'ajaxpro.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {

              results: data
            };
          },
          cache: false
        }
      });


function consultaClientes(){
$("#miTabla").html("");

variable_1='';
variable_2='';
            $.ajax({
                url:'./model/cursos/entidad.php',
                type:'POST',
                data:'variable_1='+variable_1+'&variable_2='+variable_2+"&boton=consultar"
            }).done(function(resp){
               if (resp=='Error') {

              }else{

                loadtablas()
              }
                
            });
}