<?php	

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.mailtrap.io';
$mail->Port = 2525;
$mail->SMTPAuth = true;
$mail->Username = 'c2a1915d27ac8a';
$mail->Password = 'afc18dbe337fef';
$mail->setFrom('excelservicios@hotmail.com', 'Your Name');
//$mail->addReplyTo('test@hostinger-tutorials.com', 'Your Name');
$mail->addAddress('excelservicios@hotmail.com', 'FERNANDO'); 
$mail->Subject = 'Testing PHPMailer';
//$mail->msgHTML(file_get_contents('message.html'), __DIR__);
$mail->Body = 'This is a plain text message body';
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}



    /*
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
*/
?>