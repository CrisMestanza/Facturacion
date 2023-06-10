<?php 
require 'header.php';
?>

      <div class="panel-group">
         <div class="panel panel-default">
            <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card">
                           <table id="miTabla" class="table table-striped table-bordered"></table>
                        </div>
                     </div>
                  </div>
            </div>
         </div>
      </div>
      <!-- DETALLE DEL SERVICIO Ó PRODUCTO  -->
       <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div  class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4><span class="glyphicon glyphicon-info-sign"></span> Usuario Sunat </h4>
                  </div>
                   <div class="modal-body" style="padding:40px 50px;">
                        <form method="post" action="#" enctype="multipart/form-data">
                            <div id="msj-alert"></div>
                            <input type="text" id="a-id" style="display: none;">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre Comercial :</label>
                                <div class="col-sm-9">
                                    <input id="a-com" type="text" class="form-control form-control-round" placeholder="Nombre Comercial de la Compañia" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Usuario Sunat :</label>
                                <div class="col-sm-9">
                                    <input id="a-usuariosunat" type="text" class="form-control form-control-round" placeholder="Usuario Sol secundario" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Clave de Sunat:</label>
                                <div class="col-sm-9">
                                <input id="a-clavesunat" type="text" class="form-control form-control-round" placeholder="Clave Sol secundaria" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Clave del Certificado :</label>
                                <div class="col-sm-9">
                                <input id="a-clavecert" type="text" class="form-control form-control-round" placeholder="clave del certificado dígital" autocomplete="off">
         
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre del Cerficado :</label>
                                <div class="col-sm-9">
                                <input type="file" class="form-control-file" name="archivo" id="archivo">
                                </div>
                            </div>                            
                        </form>




                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="col-sm-12">
                                <button id="btn-guardar"  type="button" class="btn btn-primary btn-round upload "><span class="glyphicon glyphicon-floppy-disk"></span> Guardar Registro</button>
                                <button id="btn-cancelar" type="button" class="btn btn-danger btn-round " data-dismiss="modal"> <span class="fa fa-times"></span> Cerrar</button>
                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

<?php 
   require 'footer.php'

?>
<script type="text/javascript" src="js/usuarios-sunat.js"></script>
<script>
$(document).ready(function() {
    /*
    $(".upload").on('click', function() {
        var formData = new FormData();
        var files = $('#image')[0].files[0];
        formData.append('file',files);
        $.ajax({
            url: './model/usuarios-sunat/upload.php',
            type: 'post',
            data: formData ,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response)

            }
        });
        return false;
    });
    */
});
</script>
