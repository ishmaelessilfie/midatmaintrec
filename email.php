<?php
//     $email = trim($_POST['email']);
//     $password = trim($_POST['password']);
 
// if(isset($_POST['password']) && isset($_POST['password'])){

// $to = $email;
// $subject = "Login password";
// $message = $password;
// $from = "midatlanticghanaosu@gmail.com";
// $headers = "From: $from";
// mail($to,$subject,$message,$headers);
// }
// echo json_encode("Mail Sent")

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$output = '';

if($_POST){
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        if($email == ''){
            unset($email);
        }
    }
    if(isset($_POST['password'])){
        $password = $_POST['password'];
        if($password == ''){
            unset($password);
        }
    }
    
    if(!empty($email) && !empty($password)){
        $password = password_hash($password, PASSWORD_DEFAULT);
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);
        
        try {
        	$mail->isSMTP();
           $mail->Host = 'smtp.gmail.com';  //gmail SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = midatlanticghanaosu;   //username
    $mail->Password = Mid2021Atlantic;   //password
    
    // Sending mail through smtp secure(ssl/tls)
    $mail->SMTPSecure = 'ssl';  // Can also use 'tls' instead of 'ssl'
    $mail->Port = 465; 
            $mail->setFrom('midatlanticghanaosu@gmail.com', 'Login password');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Login Password';
            $mail->Body = 'Password:'. $password .'';

            $mail->send();
            $output = 'Message sent!';
        } catch (Exception $e) {
            $output = $mail->ErrorInfo;
        }

    }
}

?>