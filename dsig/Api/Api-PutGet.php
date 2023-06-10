<?php 
class Rest{
		private $conexion;
		public function __construct()
		{
			require_once('../Connection/conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

  function Consulta_Compras(){
    $sql="SELECT t1.id, t1.fecha, t1.idcomprobante, t1.serie, t1.numero, t2.doc, t2.nombres, t1.subtotal, t1.impuesto, t1.total FROM bd_compras AS t1
    INNER JOIN bd_personas as t2 on t2.doc=t1.idpersona";
    $resultados = $this->conexion->conexion->query($sql);

    if ($resultados->num_rows > 0) { 
      $lista = array(); //creamos un array
        while($row = $resultados->fetch_array()) 
        { 
          $id=$row['id'];
          $fecha=$row['fecha'];
          $idcomprobante=$row['idcomprobante'];
          $serie=$row['serie'];
          $numero=$row['numero'];
          $doc=$row['doc'];
          $nombres=$row['nombres'];
          $subtotal=$row['subtotal'];
          $impuesto=$row['impuesto'];
          $total=$row['total'];


          $lista[] = array('Id'=> $id, 
    	                     'Fecha'=> $fecha,
                           'Comprobante'=> $idcomprobante,
                           'Serie'=> $serie,
                           'Numero'=> $numero,
                           'Documento'=> $doc,
                           'Empresa'=> $nombres,
                           'SubTotal'=> $subtotal,
                           'Igv'=> $impuesto,
                           'Total'=> $total,
                          );

        }

        //Creamos el JSON
        $json_string = json_encode($lista);
        $r[0]=$json_string;
    }else{
      $r[0]='Error';
    }

    return $r;
    $this->conexion->cerrar();
  } 

  function Registrar_Compras($Json_In){
    $datosclientes = json_decode(base64_decode($Json_In), true);
      foreach ($datosclientes as $cliente) {
         $In_1 =$cliente['Fecha'];
         $In_2 =$cliente['Comprobante'];
         $In_3 =$cliente['Serie'];
         $In_4 =$cliente['Numero'];
         $In_5 =$cliente['Documento'];
         //$In_6 =$cliente['Empresa'];
         $In_7 =QuitarComa($cliente['SubTotal']); 
         $In_8 =QuitarComa($cliente['Igv']);
         $In_9 =QuitarComa($cliente['Total']);

         $sql="INSERT INTO bd_compras VALUES(0,'$In_1','$In_2','$In_3','$In_4','$In_5','$In_7',0,'$In_9')";
            if($this->conexion->conexion->query($sql)){
              $r[0]='Registrado';
            }
            else
            {
              $r[0]='Error';
            }
      } 
      return $r;
      $this->conexion->cerrar();
  }

  function Registrar_FacturaGravada($Json_In){
      $datosclientes = json_decode(base64_decode($Json_In), true);
      foreach ($datosclientes as $cliente) {
         $In_0 =$cliente['llave'];
         $In_1 =$cliente['tipOperacion'];
         $In_2 =$cliente['fecEmision'];
         $In_3 =$cliente['fecVence'];
         $In_4 =$cliente['codLocalEmisor'];
         $In_5 =$cliente['tipComp'];
         $In_6 =$cliente['serieComp'];
         $In_7 =$cliente['numeroComp'];
         $In_8 =$cliente['tipDocUsuario'];
         $In_9 =$cliente['numDocUsuario'];
         $In_10 =$cliente['rznSocialUsuario'];
         $In_11 =$cliente['dirUsuario'];
         $In_12 =$cliente['paisUsuario'];
         $In_13 =$cliente['ubiUsuario'];
         $In_14 =$cliente['dptUsuario'];
         $In_15 =$cliente['provUsuario'];
         $In_16 =$cliente['distUsuario'];
         $In_17 =$cliente['tipMoneda'];
         $In_18 =$cliente['mtoOperGravadas'];
         $In_19 =$cliente['mtoIGV'];
         $In_20 =$cliente['mtoImpVenta'];
         $In_21 =$cliente['codNota'];
         $In_22 =$cliente['motivoNota'];
         $In_23 =$cliente['tipComNota'];
         $In_24 =$cliente['numRefNota'];
         $In_25 =$cliente['docRelNota'];
         $In_26 =$cliente['numRelNota'];

         $In_27 =$cliente['fechaGenAnu'];
         $In_28 =$cliente['fechaBajAnu'];
         $In_29 =$cliente['detAnu'];
         $In_30 =$cliente['loteAnu'];

         $In_31 =$cliente['numLetras'];
         $In_32 =$cliente['estadoCpe'];

         $In_33 =$cliente['ctdUnidadItem'];
         $In_34 =$cliente['codProducto'];
         $In_35 =$cliente['desItem'];
         $In_36 =$cliente['codUnidadMedida'];
         $In_37 =$cliente['mtoValorUnitario'];
         $In_38 =$cliente['mtoIgvItem'];
         $In_39 =$cliente['mtoPrecioVentaItem'];
         $In_40 =$cliente['mtoValorVentaItem'];
         $In_41 =$cliente['emailUsuario'];
         $In_42 =$cliente['rucEmisor'];


         $fecha=strftime( "%Y-%m-%d-%H-%M-%S", time() );
         $sql="INSERT INTO tb_facturagravada VALUES(0,'$In_0','$In_1','$In_2','$In_3','$In_4','$In_5','$In_6','$In_7','$In_8','$In_9','$In_10','$In_11','$In_12','$In_13','$In_14','$In_15','$In_16','$In_17','$In_18','$In_19','$In_20','$In_21','$In_22','$In_23','$In_24','$In_25','$In_26','$In_27','$In_28','$In_29','$In_30','$In_31','$In_32','$In_33','$In_34','$In_35','$In_36','$In_37','$In_38','$In_39','$In_40','$In_41','$In_42','$fecha')";
            if($this->conexion->conexion->query($sql)){
              $r[0]='Registrado';
            }
            else
            {
              $r[0]='Error';
            }
      } 
      return $r;
      $this->conexion->cerrar();
  }


 function Registrar_Cpe($Json_In){
    $datosclientes = json_decode(base64_decode($Json_In), true);
    //Creamos el JSON
   $json_string = base64_decode($Json_In);
   $file = '../Json/lientes.json';
   file_put_contents($file, $json_string);
      foreach ($datosclientes as $cliente) {
         $In_1 =$cliente['ruccliente'];
         $In_2 =$cliente['tipocomp'];
         $In_3 =$cliente['seriecomp'];
         $In_4 =$cliente['numerocomp'];
         $In_5 =$cliente['fechacomp'];
         $In_6 =QuitarComa($cliente['totalcomp']); 
         $In_7 =$cliente['rucemisor'];
         $In_8 =boolNumber($cliente['anuladocomp']);
         $In_9=$cliente['key'];

         $sql="INSERT INTO tbl_comprobantes VALUES(0,'$In_1','$In_2','$In_3','$In_4','$In_5','$In_6','$In_7','$In_8','$In_9')";
            if($this->conexion->conexion->query($sql)){
              $r[0]='Registrado';
            }
            else
            {
              $r[0]='Error';
            }
      } 
      return $r;
      $this->conexion->cerrar();
  }

 function Registrar_Emp($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/400.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
 }

 function Registrar_Cab($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/500.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
 }

  function Registrar_Det($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/501.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }

  function Registrar_Aca($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/502.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }

  function Registrar_Ley($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/503.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }

  function Registrar_Cabnotas($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/504.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }

  function Registrar_Anulados($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/600.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }

  function Registrar_Resumen_Boletas($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/601.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }

  function Registrar_Guia_Factura($Json_In){
   $json_string = base64_decode($Json_In);
   $file = '../Json/507.json';
   file_put_contents($file, $json_string);

   if (file_exists($file)) {
      $r[0]='Registrado';
   } else {
      $r[0]='Error';
   }
     return $r;
  }





//fin
}

function QuitarComa($valor){
   $numero = $valor; 
   $caracteres = Array(",",""); 
   return  str_replace($caracteres,"",$numero);
}
function boolNumber($bValue) { 
	            if ($bValue=='false'){
		          return 0;
	              }
	             if ($bValue=='true'){
		              return 1;
	            }
}
?>