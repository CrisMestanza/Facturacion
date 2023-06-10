<?php 
	class Datos{

		private $conexion;
		public function __construct()
		{
			require_once('../conexion.php');
			$this->conexion= new conexion();
			$this->conexion->conectar();
		}

	
		function registrar($variable_1){

/*Información de la Empresa*/
foreach ($Json_Emp as $cabezera) {
  $RucEmpresa = $cabezera['rucEmisor'];
  $NameEmpresa = $cabezera['razEmisor'];
  $DireccionEmpresa =$cabezera['direccionEmisor'];
  $PaisEmpresa =$cabezera['paisEmisor'];
  $UbigeoEmpresa =$cabezera['ubigeoEmisor'];
  $DepartamentoEmpresa =$cabezera['depEmisor'];
  $ProvinciaEmpresa =$cabezera['provEmisor'];
  $DistritoEmpresa =$cabezera['distEmisor'];
  $ComercialEmpresa =$cabezera['comercialEmisor'];
  $TipoEmpresa="6";
  $UrbanizacionEmpresa=$cabezera['urbEmisor'];
  $LocalEmpresa='0001';
}

/*LECTURA DEL ARCHIVO JSON*/
/*-------------------------*/
$ArrayItem = array();
$ArrayTipoUnidad = array();
$ArrayDetalleBienServicio = array();
$ArrayCodigoBienServicio = array();
$ArrayCantidad = array();
$ArrayValorVenta = array();
$ArrayPrecioVenta = array();
$ArrayTipoPrecioVenta = array();
$ArrayIndicadorDscto = array();
$ArrayDescuento = array();
$ArrayAfectacionIgv = array();
$ArrayIgv = array();
$ArrayCat05 = array();
$ArrayName05 = array();
$ArrayTaxTypeCode05 = array();
$ArrayCategoryCode05 = array();
$ArrayValorTotal = array();
$ArrayPorcentaje = array();

//--------Sumatorias------//
$TotalValorVta=0;
$TotalPrecioVta=0;
$TotalDescuentos=0;
$TotalOtrosCargos=0;
$TotalAnticipos=0;
$ImporteTotalVta=0;

$item=1;
$igv=0;

foreach($Json_Fac as $cabezera){
         $TipoOperacion =$cabezera['tipOperacion'];
         $FechaComprobante =$cabezera['fecEmision'];
         $FechaVencimiento=$cabezera['fecVencimiento'];
         $TipoComprobante =$cabezera['tipComp'];
         $serieComp =$cabezera['serieComp'];
         $numeroComp =$cabezera['numeroComp'];
         $NumComprobante=$serieComp."-".$numeroComp;
         $DomicilioFiscalEmisor =$cabezera['codLocalEmisor'];
         $TipoCliente =$cabezera['tipDocUsuario'];
         $RucCliente =$cabezera['numDocUsuario'];
         $NameCliente =$cabezera['rznSocialUsuario'];         
         $TipoMoneda =$cabezera['tipMoneda'];
         $TipoCambio =$cabezera['tipCambio'];
         $Descuentosglobales =$cabezera['DsctoGlobal'];         
         $SumatoriaOtrosCargos =$cabezera['otrosCargos'];         
         $OperacionesGravadas =$cabezera['Gravada'];
         $OperacionesInafectas =$cabezera['Inafecta'];
         $OperacionesExoneradas =$cabezera['Exonerada'];
         $OperacionesBase=$OperacionesGravadas+$OperacionesInafectas+$OperacionesExoneradas;
         $OperacionesGratuitas=$cabezera['Gratuita'];
         $OperacionesAnticipo=$cabezera['Anticipo'];
         $SumatoriaIgv=$cabezera['mtoIgv'];
         $ImporteTotal =$cabezera['mtoTotal'];

         $codefechavence="-";
         $UbigeoCliente=$cabezera['codUbigeoCliente'];
         $DepartamentoCliente=$cabezera['deptCliente'];
         $ProvinciaCliente=$cabezera['provCliente'];
         $DistritoCliente=$cabezera['distCliente'];
         $PaisCliente=$cabezera['codPaisCliente'];
         $DireccionCliente=$cabezera['desDireccionCliente'];
         $UrbanizacionCliente='-';

         foreach($cabezera['items'] as $detalle) {
              // echo $detalle["ctdUnidadItem"];
               $ArrayItem[] =$item;
               $ArrayTipoUnidad[] =$detalle['codUnidadMedida'];
               $ArrayDetalleBienServicio[] =utf8_decode($detalle['desItem']);
               $ArrayCodigoBienServicio[] =$detalle['codProducto'];
               $ArrayCantidad[] =$detalle['ctdUnidadItem'];               
               $ArrayValorVenta[] =$detalle['mtoValorUnitario'];
               $ArrayPrecioVenta[] =$detalle['mtoPrecioVentaItem'];

               $ArrayTipoPrecioVenta[] =$detalle['tipPrecio'];/*Catalogo N°16*/
               $ArrayIndicadorDscto[] ='false';
               $ArrayDescuento[] =$detalle['mtoDsctoItem'];/*DEscuento por Item*/               
               $ArrayIgv[] =$detalle['mtoIgvItem'];/*Igv por Item*/

               $ArrayAfectacionIgv[] =$detalle['tipAfeIGV'];/*Catalogo N° 07*/

               if ($detalle['tipAfeIGV']=='10'){
                  $tributocat5='1000';
               }else if ($detalle['tipAfeIGV']=='10' ||  $detalle['tipAfeIGV']=='11'||  $detalle['tipAfeIGV']=='12'||  $detalle['tipAfeIGV']=='13'||  $detalle['tipAfeIGV']=='14'||  $detalle['tipAfeIGV']=='15'||  $detalle['tipAfeIGV']=='16'||  $detalle['tipAfeIGV']=='17') {
                 $tributocat5='9996';
               }else if ($detalle['tipAfeIGV']=='20'){
                  $tributocat5='9997';
               }else if ($detalle['tipAfeIGV']=='21'){
                  $tributocat5='9996';
               }else if ($detalle['tipAfeIGV']=='30'){
                  $tributocat5='9998';
               }else if ($detalle['tipAfeIGV']=='32' || $detalle['tipAfeIGV']=='33' || $detalle['tipAfeIGV']=='34' || $detalle['tipAfeIGV']=='35' || $detalle['tipAfeIGV']=='36'){
                  $tributocat5='9996';
               }else if ($detalle['tipAfeIGV']=='40'){
                  $tributocat5='9995';
               }

               if ($tributocat5=='1000') {
                  $ArrayCat05[]='1000';
                  $ArrayName05[] ='IGV'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='VAT'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='S';

               }else if ($tributocat5=='9995') {
                  $ArrayCat05[]='9995';
                  $ArrayName05[] ='EXP'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='FRE';
                  $ArrayCategoryCode05[]='G';
               } else if ($tributocat5=='9996') {
                  $ArrayCat05[]='9996';
                  $ArrayName05[] ='GRAT'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='FRE'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='Z';
               } else if ($tributocat5=='9997') {
                  $ArrayCat05[]='9997';
                  $ArrayName05[] ='EXO'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='VAT'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='E';
               } else if ($tributocat5=='9998') {
                  $ArrayCat05[]='9998';
                  $ArrayName05[] ='INA'; /*Catalogo N° 05*/
                  $ArrayTaxTypeCode05[] ='FRE'; /*Catalogo N° 05*/
                  $ArrayCategoryCode05[]='O';
               }
            
          
               $ArrayValorTotal[] =$detalle['mtoValorVentaItem']; 
               $ArrayPorcentaje[]=$detalle['porcentajeIgv'];               

               $TotalValorVta=$TotalValorVta+$detalle['mtoValorVentaItem'];
               $igv=$igv+$detalle['mtoIgvItem'];
               $TotalPrecioVta=$TotalPrecioVta+$detalle['mtoPrecioVentaItem'];

               $ImporteTotalVta=$ImporteTotalVta+$detalle['mtoPrecioVentaItem'];
               $item=$item+1;
         }

}




			
			$sql="INSERT INTO tb_personas VALUES(0,'$variable_2','$variable_3','$variable_4','$variable_5','$variable_6','$variable_7','$variable_8','$variable_9')";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function eliminar($codigo){
			$sql="DELETE FROM tb_personas WHERE id='$codigo'";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function modificar($variable_1,$variable_2,$variable_3,$variable_4,$variable_5,$variable_6,$variable_7,$variable_8,$variable_9)
		{
			$pass= sha1($variable_3);
			$sql="UPDATE tb_personas SET  dni='$variable_2', appat='$variable_3', apmat='$variable_4', nom='$variable_5', emp='$variable_6', email='$variable_7', cel='$variable_8' , telf='$variable_9' WHERE id='$variable_1'";
			if($this->conexion->conexion->query($sql)){
				return true;
			}
			else
			{
				return false;
			}
			$this->conexion->cerrar();
		}

		function consultar($variable_1,$variable_2){
		if (file_exists('../../json/webclientes.json')) {
              unlink('../../json/webclientes.json');
        } else {
      
        }
   
         $sql="SELECT * FROM tb_personas  ";

         $resultados = $this->conexion->conexion->query($sql);

          if ($resultados->num_rows > 0) { 
            $lista = array(); //creamos un array
          while($row = $resultados->fetch_array()) 
          { 
          $retorno_0=$row['id'];
          $retorno_1=$row['dni'];
          $retorno_2=$row['appat'];
          $retorno_3=$row['apmat'];
          $retorno_4=$row['nom'];
          $retorno_5=$row['emp'];
          $retorno_6=$row['email'];
          $retorno_7=$row['cel'];
          $retorno_8=$row['telf'];

          $lista[] = array('retorno_0'=> $retorno_0, 
    	                   'retorno_1'=> $retorno_1,
                           'retorno_2'=> $retorno_2,
                           'retorno_3'=> $retorno_3,
                           'retorno_4'=> $retorno_4,
                           'retorno_5'=> $retorno_5,
                           'retorno_6'=> $retorno_6,
                           'retorno_7'=> $retorno_7,
                           'retorno_8'=> $retorno_8,
                          );

           }

         //Creamos el JSON
          $json_string = json_encode($lista);
          $r[0]=$json_string;
          $file = '../../json/webclientes.json';
          file_put_contents($file, $json_string);
          }else{
           $r[0]='Error';
        }

          return $r;
          $this->conexion->cerrar();
         } 

	
	}

	
?>