var timeout_Ini;
/*Menu Interactivo*/
function loadSalir (){

    swal({
     title: "Información",
     text: "Desea Usted Cerrar Sesión !",
     type: "warning",
     showCancelButton: true,
     confirmButtonColor: "#00a0d1",
     confirmButtonText: "Sí",
     cancelButtonText: "No",
     closeOnConfirm: false
    },
    function(){
   
                 $.ajax({
                   url:'./model/funciones/funciones.php',
                   type:'POST',
                   data:'evento=salir'
                   }).done(function(resp){
                   if(resp=='exito'){
                      location.href='login';
                   }else{
                      swal("Error !", "No se puede cerrar sessión !", "error")
                   }
                   
               });
    });
   }
   

function LoadDashboard(){
    location.href='./';
}
function LoadEmitirCpe(){
    location.href='./facturacion';
}

function LoadItem(){
    location.href='Items';
}

function LoadPersonas(){
    location.href='personas';
}

function LoadListado(){
    location.href='listadoCpe';
}

function LoadDireccion(){
    location.href='direcciones';
}

function LoadNumeracion_a(){
    location.href='numeracion';
}

function LoadEmpresa_m(){
    location.href='empresas';
}

function LoadUsuarios_Sunat_m(){
    location.href='usuarios-sunat';
}

function LoadconfEmail(){
      $('#myModal4').on('shown.bs.modal', function () {
        loadEmail();
      });
    
      $("#myModal4").modal("show");   

}

function LoadSession(){
  
    $.ajax({
        url:'./model/usuarios/sesiones.php',
        type:'POST',
        data:'session=true',
    }).done(function(resp){
       // $("#myModal-ini").modal("show");
       if(resp=='OFF'){
        document.getElementById("img-w").style.display ='block';
        timeout_Ini = window.setTimeout(loadWeb, 1000, resp);
      }else{
         document.getElementById("n-codigo-doc").innerHTML =resp;
         document.getElementById("img-w").style.display ='none';
         document.getElementById("container-body").style.display ='block';
         dat_consulta();
     }
        
        

    });
}

function loadWeb(resp){


    if(resp=='OFF'){
        location.href='login';
     }else{
         document.getElementById("n-codigo-doc").innerHTML =resp;
         document.getElementById("img-w").style.display ='none';
         document.getElementById("container-body").style.display ='block';
         dat_consulta();
     }

     window.clearTimeout(timeout_Ini);

   //  alert(document.getElementById("n-codigo-doc").innerHTML)
}

