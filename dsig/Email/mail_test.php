<?php
header('Content-type: text/html; charset=utf-8');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$boton = $_POST['boton'];

switch ($boton) {

    case 'registrar':

        $correo_Emisor = $_POST['variable_0'];
        $clave_Emisor = ($_POST['variable_1']);
        $host = $_POST['variable_2'];
        $puerto = $_POST['variable_3'];
        $ssl = $_POST['variable_6'];
        $correo_Para = $_POST['variable_7'];
        $cc = $_POST['variable_8'];
        $cco = $_POST['variable_9'];
        $asunto = $_POST['variable_10'];
        $body1 = $_POST['variable_11'];
        $body2 = $_POST['variable_12'];
        $html = $_POST['variable_4'];
        $adjuntos = $_POST['variable_5'];
        $Seguridad = $_POST['variable_13'];


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
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $correo_Emisor; // SMTP username
            $mail->Password = $clave_Emisor; // SMTP password
            
            if($Seguridad==1){
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
          //  $mail->Port = $puerto; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('fernando@excelservicios.com', "CORREO DE PRUEBA");
            $mail->addAddress($correo_Para, 'FERNANDO MAMANI BLAS'); // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');

            if ($cc != "") {
                $mail->addCC($cc);
            }

            if ($cco != "") {
                $mail->addBCC($cco);
            }

            // Content
            $mail->isHTML($html); // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body = utf8_decode($body1) . utf8_decode($body2);
            $mail->AltBody = "www.excelservicios.com";

            $mail->send();
            echo 'exito';

        } catch (Exception $e) {
            echo $Seguridad;
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        break;

}
