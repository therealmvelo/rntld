<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'process/phpmailer/src/Exception.php';
require 'process/phpmailer/src/PHPMailer.php';
require 'process/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'me.voidcache@gmail.com';
$mail->Password = 'matwnzklbngexhcw';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

?>