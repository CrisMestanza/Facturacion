<?php
class PutFacturacion
{

    private $conexion;
    public function __construct()
    {
        require_once '../../model/conexion.php';
        $this->conexion = new conexion();
        $this->conexion->conectar();
    }

    public function modificar($cpe)
    {

        $sql = "UPDATE resumen SET  cdr=1 WHERE llave='$cpe'";
        if ($this->conexion->conexion->query($sql)) {
            return true;
        } else {
            return false;
        }
        $this->conexion->cerrar();
    }

    public function Guardar($Json_Fac, $send_sunat)
    {
        date_default_timezone_set('America/Lima');

        /*LECTURA DEL ARCHIVO JSON*/
        /*-------------------------*/
        $ArrayId = array();
        $ArrayItem = array();
        $ArrayTipoUnidad = array();
        $ArrayDetalleBienServicio = array();
        $ArrayCodigoBienServicio = array();
        $ArrayCantidad = array();
        $ArrayValorVenta = array();
        $ArrayPrecioUnitario = array();
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
        $TotalValorVta = 0;
        $TotalPrecioVta = 0;
        $TotalDescuentos = 0;
        $TotalOtrosCargos = 0;
        $TotalAnticipos = 0;
        $ImporteTotalVta = 0;

        $item = 1;
        $igv = 0;

        foreach ($Json_Fac as $cabezera) {

            $TipoOperacion = $cabezera['tipOperacion'];
            $FechaComprobante = $cabezera['fecEmision'];
            $FechaVencimiento = $cabezera['fecVencimiento'];
            $TipoComprobante = $cabezera['tipComp'];
            $serieComp = $cabezera['serieComp'];
            $numeroComp = $cabezera['numeroComp'];
            $NumComprobante = $serieComp . "-" . $numeroComp;
            $DomicilioFiscalEmisor = $cabezera['codLocalEmisor'];
            $TipoCliente = $cabezera['tipDocUsuario'];
            $codCliente = $cabezera['codCliente'];
            $RucCliente = $cabezera['numDocUsuario'];
            $NameCliente = $cabezera['rznSocialUsuario'];
            $TipoMoneda = $cabezera['tipMoneda'];
            $TipoCambio = $cabezera['tipCambio'];
            $Descuentosglobales = $cabezera['DsctoGlobal'];
            $SumatoriaOtrosCargos = $cabezera['otrosCargos'];
            $OperacionesGravadas = $cabezera['Gravada'];
            $OperacionesInafectas = $cabezera['Inafecta'];
            $OperacionesExoneradas = $cabezera['Exonerada'];
            $OperacionesBase = $OperacionesGravadas + $OperacionesInafectas + $OperacionesExoneradas;
            $OperacionesGratuitas = $cabezera['Gratuita'];
            $OperacionesAnticipo = $cabezera['Anticipo'];
            $SumatoriaIgv = $cabezera['mtoIgv'];
            $ImporteTotal = $cabezera['mtoTotal'];

            $codefechavence = "-";
            $UbigeoCliente = $cabezera['codUbigeoCliente'];
            $DepartamentoCliente = $cabezera['deptCliente'];
            $ProvinciaCliente = $cabezera['provCliente'];
            $DistritoCliente = $cabezera['distCliente'];
            $PaisCliente = $cabezera['codPaisCliente'];
            $DireccionCliente = $cabezera['desDireccionCliente'];
            $cdr = $cabezera['envioSunat'];
            $UrbanizacionCliente = '-';

            //Nota de Credito o debito
            $Cat09 = $cabezera['Cat09'];
            $Cat10 = $cabezera['Cat10'];
            $docRef = $cabezera['docRef'];

            //DatosAdicionales//
            $CodDir = $cabezera['CodDir'];
            $tipoPago = $cabezera['tipPago'];
            $idserie = $cabezera['idserie'];
            $numdias = $cabezera['numdias'];
            $accion = $cabezera['accion'];
            $dirEmp = $cabezera['dirEmp'];
            $RucEmpresa = $cabezera['rucEmp'];

            foreach ($cabezera['items'] as $detalle) {
                $ArrayId[] = $detalle['CodItem'];
                $ArrayItem[] = $item;
                $ArrayTipoUnidad[] = $detalle['codUnidadMedida'];
                $ArrayDetalleBienServicio[] = utf8_decode($detalle['desItem']);
                $ArrayCodigoBienServicio[] = $detalle['codProducto'];
                $ArrayCantidad[] = $detalle['ctdUnidadItem'];
                $ArrayValorVenta[] = $detalle['mtoValorUnitario'];
                $ArrayPrecioVenta[] = $detalle['mtoPrecioVentaItem'];

                $ArrayTipoPrecioVenta[] = $detalle['tipPrecio']; /*Catalogo N°16*/
                $ArrayIndicadorDscto[] = 'false';
                $ArrayDescuento[] = $detalle['mtoDsctoItem']; /*DEscuento por Item*/
                $ArrayIgv[] = $detalle['mtoIgvItem']; /*Igv por Item*/

                $ArrayAfectacionIgv[] = $detalle['tipAfeIGV']; /*Catalogo N° 07*/

                if ($detalle['tipAfeIGV'] == '10') {
                    $tributocat5 = '1000';
                } else if ($detalle['tipAfeIGV'] == '11' || $detalle['tipAfeIGV'] == '12' || $detalle['tipAfeIGV'] == '13' || $detalle['tipAfeIGV'] == '14' || $detalle['tipAfeIGV'] == '15' || $detalle['tipAfeIGV'] == '16' || $detalle['tipAfeIGV'] == '17') {
                    $tributocat5 = '9996';
                } else if ($detalle['tipAfeIGV'] == '20') {
                    $tributocat5 = '9997';
                } else if ($detalle['tipAfeIGV'] == '21') {
                    $tributocat5 = '9996';
                } else if ($detalle['tipAfeIGV'] == '30') {
                    $tributocat5 = '9998';
                } else if ($detalle['tipAfeIGV'] == '31' || $detalle['tipAfeIGV'] == '32' || $detalle['tipAfeIGV'] == '33' || $detalle['tipAfeIGV'] == '34' || $detalle['tipAfeIGV'] == '35' || $detalle['tipAfeIGV'] == '36') {
                    $tributocat5 = '9996';
                } else if ($detalle['tipAfeIGV'] == '40') {
                    $tributocat5 = '9995';
                }

                if ($tributocat5 == '1000') {
                    $ArrayCat05[] = '1000';
                    $ArrayName05[] = 'IGV'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'VAT'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'S';

                } else if ($tributocat5 == '9995') {
                    $ArrayCat05[] = '9995';
                    $ArrayName05[] = 'EXP'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'FRE';
                    $ArrayCategoryCode05[] = 'G';
                } else if ($tributocat5 == '9996') {
                    $ArrayCat05[] = '9996';
                    $ArrayName05[] = 'GRAT'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'FRE'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'Z';
                } else if ($tributocat5 == '9997') {
                    $ArrayCat05[] = '9997';
                    $ArrayName05[] = 'EXO'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'VAT'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'E';
                } else if ($tributocat5 == '9998') {
                    $ArrayCat05[] = '9998';
                    $ArrayName05[] = 'INA'; /*Catalogo N° 05*/
                    $ArrayTaxTypeCode05[] = 'FRE'; /*Catalogo N° 05*/
                    $ArrayCategoryCode05[] = 'O';
                }

                $ArrayValorTotal[] = $detalle['mtoValorVentaItem'];
                $ArrayPrecioUnitario[] = $detalle['mtoPrecioVentaItem'] / $detalle['ctdUnidadItem']; //precio unitario
                $ArrayPorcentaje[] = $detalle['porcentajeIgv'];

                $TotalValorVta = $TotalValorVta + $detalle['mtoValorVentaItem'];
                $igv = $igv + $detalle['mtoIgvItem'];
                $TotalPrecioVta = $TotalPrecioVta + $detalle['mtoPrecioVentaItem'];

                $ImporteTotalVta = $ImporteTotalVta + $detalle['mtoPrecioVentaItem'];
                $item = $item + 1;

            }

        }

        if ($FechaVencimiento == '') {
            $FechaVencimiento = "0000-00-00";
        }

        //---------- Consultar la Empresa----------///
        $sqlEmp = "SELECT
                t5.ruc,
                t5.razon,
                t6.nomcomercial,
                t1.dir,
                t1.idpais,
                t1.idubigeo,
                t4.detalle AS departamento,
                t3.detalle AS provincia,
                t2.detalle AS distrito,
                t1.urb,
                t1.local_,
                t6.nomus,
                t6.clavus,
                t6.nomcer,
                t6.clavcer,
                t7.estado
                FROM
                direccion_empresa AS t1
                INNER JOIN catalogo_13_dist AS t2 ON t2.id = t1.idubigeo
                INNER JOIN catalogo_13_prov AS t3 ON t3.id = t2.idprov
                INNER JOIN catalogo_13_dpt AS t4 ON t4.id = t3.iddpt
                INNER JOIN tb_registros AS t5 ON t5.ruc = t1.rucempresa
                INNER JOIN usuarios_sunat AS t6 ON t6.rucempresa = t5.ruc
                INNER JOIN servidor AS t7 ON t7.rucempresa = t5.ruc
                WHERE t1.id='$dirEmp'";

        $result_emp = $this->conexion->conexion->query($sqlEmp);
        $lista = array(); //creamos un array
        if ($result_emp->num_rows > 0) {

            while ($row = $result_emp->fetch_array()) {
                $retorno_1 = $row['ruc'];
                $retorno_2 = $row['razon'];
                $retorno_3 = $row['dir'];
                $retorno_4 = $row['idpais'];
                $retorno_5 = $row['idubigeo'];
                $retorno_6 = $row['departamento'];
                $retorno_7 = $row['provincia'];
                $retorno_8 = $row['distrito'];
                $retorno_9 = $row['nomcomercial'];
                $retorno_10 = $row['urb'];
                $retorno_11 = $row['nomus'];
                $retorno_12 = $row['clavus'];
                $retorno_13 = $row['nomcer'];
                $retorno_14 = $row['clavcer'];
                $retorno_15 = $row['local_'];
                $retorno_16 = $row['estado'];

                $lista[] = array('rucEmisor' => $retorno_1,
                    'razEmisor' => $retorno_2,
                    'direccionEmisor' => $retorno_3,
                    'paisEmisor' => $retorno_4,
                    'ubigeoEmisor' => $retorno_5,
                    'depEmisor' => $retorno_6,
                    'provEmisor' => $retorno_7,
                    'distEmisor' => $retorno_8,
                    'comercialEmisor' => $retorno_9,
                    'urbEmisor' => $retorno_10,
                    'userSol' => base64_encode($retorno_11),
                    'claveSol' => $retorno_12,
                    'nomCertificado' => base64_encode($retorno_13),
                    'clavCertificado' => $retorno_14,
                    'localEmisor' => $retorno_15,
                    'servidorSunat' => $retorno_16,
                );

            }

        }

        $json_string = json_encode($lista);
        $file = '../Json/' . $RucEmpresa . '.json';
        file_put_contents($file, $json_string);

        if ($send_sunat == 'Off') {

            $llave = $RucEmpresa . '-' . $TipoComprobante . '-' . $serieComp . '-' . $numeroComp;

            if ($accion == true) {
                $sqlD = "DELETE FROM resumen WHERE llave='$llave'";
                $this->conexion->conexion->query($sqlD);
            }

            $hora = strftime("%Y-%m-%d-%H-%M-%S", time());
            //Registramos la Cabezera
            $sql = "INSERT INTO resumen VALUES(0,'$llave','$FechaComprobante','$FechaVencimiento','$hora','$codCliente','$CodDir',
            '$TipoMoneda','$TipoCambio','$tipoPago','$OperacionesExoneradas','$OperacionesInafectas','$OperacionesGravadas',
            '$OperacionesAnticipo','$SumatoriaIgv','$OperacionesGratuitas','$SumatoriaOtrosCargos','0',
            '$Descuentosglobales','$ImporteTotal','$cdr',0,'$docRef','$Cat09','$Cat10','$idserie','$numdias','$RucEmpresa',0,0,'','')";

            if ($this->conexion->conexion->query($sql)) {
                //Registramos el detalle
                for ($i = 0; $i < count($ArrayId); $i++) {
                    $sqlDetalle = "INSERT INTO detalle VALUES(0,'$ArrayId[$i]','$ArrayCantidad[$i]','$ArrayValorVenta[$i]','$ArrayDescuento[$i]','$ArrayIgv[$i]','0','$ArrayAfectacionIgv[$i]',
                     '$ArrayTipoPrecioVenta[$i]','$ArrayPrecioUnitario[$i]','$ArrayPrecioVenta[$i]','$ArrayValorTotal[$i]','$ArrayPorcentaje[$i]','$llave')";

                    if ($this->conexion->conexion->query($sqlDetalle)) {

                        //Esperamos el resultado
                        if ($accion == false) {
                            //------------ Actualizar --------------//
                            $NuevoNum = $numeroComp + 1;
                            $sqlNum = "UPDATE numeracion SET numero='$NuevoNum'  WHERE id='$idserie'";
                            $this->conexion->conexion->query($sqlNum);

                        }
                        return true;
                    } else {
                        return false;
                    }
                }

                $this->conexion->cerrar();
            } else {
                return false;
            }

            $this->conexion->cerrar();

        } else {
            return true;
        }

    }
}
