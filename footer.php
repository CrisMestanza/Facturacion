
<?php
require 'modal-confEmail.php';

?>

<footer class="main-footer">

  </footer>

      <script type="text/javascript" src="js/jquery.3.4.1.min.js"></script>
      <script src="js/jquery-ui.min.js"></script>
      <script type="text/javascript" src="js/bootstrap.3.4.1.min.js"> </script>
      <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
      <script src="js/bootstrap-switch.js" type="text/javascript"></script>
      <script type="text/javascript" src="js/jquery.tabletojson.js"></script>
      <script type="text/javascript" src="libs/select2/4.0.3/js/select2.min.js"></script>
      <script src="js/toastr.min.js"></script>
      <script src="js/Chart.min.js"></script>
      <script type="text/javascript" src="js/funciones.js"></script>
      <script type="text/javascript" src="js/ventanas.js"></script>
      <script type="text/javascript" src="js/email.js"></script>
      <script type="text/javascript" src="js/base64.js"></script>
      <script type="text/javascript" src="js/sweetalert.min.js"></script>
      <script src="libs/sweetalert/js/jquery.sweet-alert.custom.js"></script>
      <script src="libs/FooTable-3/compiled/footable.js"></script>

<script>
  $(document).ready(function () {
     $("[name='my-checkbox']").bootstrapSwitch();
     $("#btn-refrescar").on("click", function () {
         dat_consulta()
     });

  });


</script>



   </body>
</html>