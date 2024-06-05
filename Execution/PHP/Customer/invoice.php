<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $name)
{

    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'luciferdynamic598@gmail.com';                     //SMTP username
        $mail->Password = 'wgvf rsrm egmc ejqx';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('luciferdynamic598@gmail.com', 'Community Harvest');
        $mail->addAddress($email);     //Add a recipient


        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Invoice From Community Harvest';
        $mail->Body = "";



        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}



?>