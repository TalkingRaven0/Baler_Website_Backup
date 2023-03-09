<?php
include "phpmailer/PHPMailerAutoload.php";

$gmailUsername = "baler.prod@gmail.com";//Gmail username to be used as sender (make sure gmail setting (Allow less secure apps) is turned ON or enabled)
$gmailPassword = "baler123";//Gmail Password


//////////////////////////////////////
$mail = new PHPMailer(); 
$mail->IsSMTP(); 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'ssl'; // 
$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->IsHTML(true);
$mail->Username = $gmailUsername;
$mail->Password = $gmailPassword;
/////////////////////////////////////


$mail->SetFrom($gmailUsername,"archIVE");//Name of Sender is user defined


$mail->Subject = "Signup | Verification"; //Email Subject:
$mail->Body = '
                 
   Thanks for signing up!
   Your account has been created, you can login with the following credentials but you cannot post until your account has been verified.<br><br>
     
   ------------------------<br>
   Username: '.$x.'<br>
   Password: '.$z.'<br>
   ------------------------<br><br>
     
   Please go into your account settings and enter the following code to verify your account<br>
   ------------------------<br>
   Code:'.$code.'<br>
   ------------------------<br>
     
   ';//Content of Message

$mail->AddAddress($y);//Recepient of email: to send whatever email you want to


 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 }

 
?>