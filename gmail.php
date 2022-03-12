<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function sendgmail() {

    $subscribers = file_get_contents('subscribers.json');
    $subscribers = json_decode($subscribers, TRUE);
    if(is_array($subscribers['emails']) && count($subscribers['emails']) > 1) {
        foreach ($subscribers['emails'] as $key => $val) {
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
            $mail->AddAddress($val, YOUR_NAME . "'s testament subscriber");
            $mail->SetFrom($mail->Username, YOUR_NAME);
            $mail->Subject = YOUR_NAME . "'s testament";
            $content = getenv("TESTAMENT_CONTENT");
            $mail->MsgHTML($content); 
            $mail->Send();
        }   
    }
}