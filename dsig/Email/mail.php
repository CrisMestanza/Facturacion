<?php
header('Content-type: text/html; charset=utf-8');
//$Cpe_v = '20601733022-01-FF01-00000012';
$Cpe_v = $_POST['codigo'];
$correo_Para = $_POST['correo'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Nos conectamos a la base de datos
require_once '../../model/conexion.php';
$mysqli = conectar();
$myquery = "SELECT * FROM conf_email ";


$resultado = $mysqli->query($myquery);

/*
$data = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
$jsonLista = json_encode($data);

$Json_email = json_decode($jsonLista, JSON_UNESCAPED_UNICODE);

foreach ($Json_email as $result) {
    $correo_Emisor = $result['correo_de'];
    $clave_Emisor = base64_decode($result['clave_de']);
    $host = $result['host'];
    $puerto = $result['puerto'];
    $ssl = $result['ssl_'];
   // $correo_Para = $result['correo_para'];
    $cc = $result['cc'];
    $cco = $result['cco'];
    $asunto = $result['asunto'];
    $body1 = $result['body1'];
    $body2 = $result['body2'];
    $html = $result['html'];
    $adjuntos = $result['adjuntos'];
    $seguridad = $result['email_p'];


}

*/



    if ($resultado->num_rows > 0) {
        while ($result = $resultado->fetch_array()) {
    $correo_Emisor = $result['correo_de'];
    $clave_Emisor = base64_decode($result['clave_de']);
    $host = $result['host'];
    $puerto = $result['puerto'];
    $ssl = $result['ssl_'];
   // $correo_Para = $result['correo_para'];
    $cc = $result['cc'];
    $cco = $result['cco'];
    $asunto = $result['asunto'];
    $body1 = $result['body1'];
    $body2 = $result['body2'];
    $html = $result['html'];
    $adjuntos = $result['adjuntos'];
    $seguridad = $result['email_p'];
        }
    }



if ($ssl == 1) {
    $ssl = true;
} else {
    $ssl = false;
}

if ($html == 1) {
    $html = true;
} else {
    $html = false;
}

if ($adjuntos == 1) {
    $asjuntos = true;
} else {
    $adjuntos = false;
}

/*Información de la Empresa*/
$Json_Emp = file_get_contents("../Json/" . substr($Cpe_v, 0, 11) . ".json");
$Json_Emp = json_decode($Json_Emp, JSON_UNESCAPED_UNICODE);
foreach ($Json_Emp as $cabezera) {
    $RucEmpresa = $cabezera['rucEmisor'];
    $NameEmpresa = $cabezera['razEmisor'];
}

//Leemos el Json de la facturacion
$Json_In = file_get_contents("../Json/" . $Cpe_v . ".json");
$Json_Fac = json_decode("[" . $Json_In . "]", JSON_UNESCAPED_UNICODE);

foreach ($Json_Fac as $cabezera) {
    $FechaComprobante = $cabezera['fecEmision'];
    $FechaVencimiento = $cabezera['fecVencimiento'];
    $TipoComprobante = $cabezera['tipComp'];
    $serieComp = $cabezera['serieComp'];
    $numeroComp = $cabezera['numeroComp'];
    $NumComprobante = $serieComp . "-" . $numeroComp;
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
    $SumatoriaIgv = $cabezera['mtoIgv'];
    $ImporteTotal = $cabezera['mtoTotal'];
}

if ($TipoComprobante == '01') {
    $textoCpe = 'FACTURA ELECTRÓNICA';
} elseif ($TipoComprobante == '03') {
    $textoCpe = 'BOLETA DE VENTA ELECTRÓNICA';
} elseif ($TipoComprobante == '07') {
    $textoCpe = 'NOTA DE CREDITO ELECTRÓNICA';
} elseif ($TipoComprobante == '08') {
    $textoCpe = 'NOTA DE DEBITO ELECTRÓNICA';
}

if ($TipoMoneda == 'PEN') {
    $tipomon = 'S/ ';
    $txtmon = 'SOLES';
} elseif ($TipoMoneda == 'USD') {
    $tipomon = '$. ';
    $txtmon = 'DOLARES';
}


function fechaconvertir($fecha){
    $date = trim($fecha);
    $year=substr($date,0,4);
    $month=substr($date,5,2);
    $day=substr($date,8,2);
    $conversionfecha=$day.'/'.$month.'/'.$year;
    return $conversionfecha;
}


if($FechaVencimiento == ""){
    $fechavence ="";
}else{
    $fechavence ="<tr>
                  <td>Fecha Vencimiento : </td>
                  <td>" . fechaconvertir($FechaVencimiento) . "</td>
                 </tr>";
}

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $correo_Emisor; // SMTP username
            $mail->Password = $clave_Emisor; // SMTP password

            if($seguridad==1){
                $mail->isSMTP(); // Send using SMTP
                $mail->Host         = $host;
                $mail->SMTPSecure = 'ssl'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            }else{
                $mail->Host         = "tls://".$host;
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            }
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];
            $mail->Port = $puerto; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
    //Recipients
    $mail->setFrom('fernando@excelservicios.com', $NameEmpresa);
    $mail->addAddress($correo_Para, $NameCliente); // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');

    if ($cc != "") {
       $mail->addCC($cc);
    }

    if ($cco != "") {
        $mail->addBCC($cco);
    }

    // Attachments

    if ($adjuntos == true) {
        $mail->addAttachment('../Repo/cpe/' . $Cpe_v . '.pdf');
        $mail->addAttachment('../Xml/xml-firmados/' . $Cpe_v . '.xml');
    }


    // Content
    $mail->isHTML($html); // Set email format to HTML
    $mail->Subject = $asunto;

    $contenido = "<table style='font-family: Tahoma; font-size: 14px;font-weight: bold;' >
    <tr>
       <td>N° RUC del emisor : </td>
       <td>" . $RucEmpresa . "</td>
    </tr>
    <tr>
       <td>Razón Social Emisor : </td>
       <td>" . $NameEmpresa . "</td>
    </tr>

    <tr>
       <td>Tipo de Documento : </td>
       <td>" . $textoCpe . "</td>
    </tr>
    <tr>
       <td>Serie y número : </td>
       <td>" . $NumComprobante . "</td>
    </tr>
    <tr>
       <td>Fecha de Emisión : </td>
       <td>" . fechaconvertir($FechaComprobante) . "</td>
    </tr>".$fechavence."
    <tr>
        <td>N° Ruc ó Dni Cliente : </td>
       <td>" . $RucCliente . "</td>
     </tr>
    <tr>
       <td>Nombre del Cliente: </td>
       <td>" . $NameCliente . "</td>
    </tr>
    <tr>
       <td>Moneda : </td>
       <td>" . $txtmon . "</td>
    </tr>
    <tr>
       <td>T.C : </td>
       <td>" . number_format($TipoCambio, 3) . "</td>
    </tr>
    <tr>
      <td>Base Imponible : </td>
      <td>" . $tipomon . number_format($OperacionesBase, 2) . "</td>
    </tr>
    <tr>
       <td>IGV : </td>
       <td>" . $tipomon . number_format($SumatoriaIgv, 2) . "</td>
    </tr>
      <tr>
         <td>Total : </td>
        <td>" . $tipomon . number_format($ImporteTotal, 2) . "</td>
    </tr>
 </table>";
    $mail->Body = utf8_decode($body1) . utf8_decode($contenido) . utf8_decode($body2);
    $mail->AltBody = "www.excelserviciios.com";

    $mail->send();
    echo 'Mensaje Enviado';

   //Guardar rn la base de datos
   $sqlUp = "UPDATE resumen SET estadoemail='1'  WHERE llave='$Cpe_v'";
   $resultado = $mysqli->query($sqlUp);

} catch (Exception $e) {
    echo   $correo_Emisor;
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
