<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function sendgmail() {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 1;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = getenv("TESTAMENT_EMAIL_USERNAME");
    $mail->Password   = getenv("TESTAMENT_EMAIL_PASSWORD");
    $mail->IsHTML(true);
    $mail->AddAddress("amirsh.nll@gmail.com", YOUR_NAME . "'s testament subscriber");
    $mail->SetFrom($mail->Username, YOUR_NAME);
    $mail->Subject = YOUR_NAME . "'s testament";
    $content = getenv("TESTAMENT_CONTENT");

    $mail->MsgHTML($content); 
    if(!$mail->Send()) {
        echo "Error while sending testament's mail.";
        var_dump($mail);
    } else {
        echo "Testament's mail sent successfully";
    }
}