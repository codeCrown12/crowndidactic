<?php

// Mailer script
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'crowndidactic@gmail.com'; 
$mail->Password = 'CROWNdidactic@123';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;


if(isset($_POST['send'])){
    $schurl = $_POST['schurl'];
  if($_POST['email'] == "" || $_POST['name'] == "" || $_POST['subject'] == "" || $_POST['msg'] == ""){
    header("Location: onepage.php?selector=$schurl&error=Unable to send mail try again#contactus");
  }
  else{
    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress($schurl);
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body ="<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Message</title>
    </head>
    <body style='background-color: #f8f9fa;padding-bottom: 10px;'>
    <div style='border: solid #fff 1px;width: 75%;padding: 9px;margin-left: auto;margin-right: auto;border-radius: 5px;background-color: white;'>
        <div style='text-align: center;'>
            <h2 style='font-family: Raleway, sans-serif;'>$subject</h2>
            <p>$_POST[msg]</p>
        </div>
    </div>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>Powered by </span><a href='https://www.crowndidactic.com/' target='_blank'>Crowndidactic</a></small></p>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'></span><a href='https://www.crowndidactic.com/Terms/terms.php' target='_blank'>Privacy policy</a></small></p>
    </body>
    </html>";
    
    if($mail->send()){
      header("Location: onepage.php?selector=$schurl&success=Mail sent successfully#contactus");
    }  
  else{
    header("Location: onepage.php?selector=$schurl&error=Unable to send mail try again#contactus");
  }
  }
}
?>