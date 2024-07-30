<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

class PhpMailerUser 
{
    public function sendVerifyEmail($name,$email,$verify_token)
    {
        $mail = new PHPMailer(true);
        
        try {
            // Pengaturan server
            $mail->isSMTP();
            $mail->Host       = 'localhost'; // Mailpit berjalan di localhost
            $mail->SMTPAuth   = false; // Mailpit tidak membutuhkan autentikasi
            $mail->Port       = 1025; // Port default Mailpit untuk SMTP
        
            // Penerima
            $mail->setFrom('your_email@example.com', $name);
            $mail->addAddress($email);
        
            // Konten
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification from LOGINOOP';

            $email_template = "
                <h2>You Have Registerd with email verification</h2>
                <h5>Verify your email addres to login with the below given link</h5>
                <br>
                <a href='http://localhost:8321/controllers/verify.php?token=$verify_token'>Click Here</a>
            ";


            $mail->Body    = $email_template;
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }

    public function resend_email_verify($name,$email,$verify_token)
    {
        $mail = new PHPMailer(true);
        
        try {
            // Pengaturan server
            $mail->isSMTP();
            $mail->Host       = 'localhost'; // Mailpit berjalan di localhost
            $mail->SMTPAuth   = false; // Mailpit tidak membutuhkan autentikasi
            $mail->Port       = 1025; // Port default Mailpit untuk SMTP
        
            // Penerima
            $mail->setFrom('your_email@example.com', $name);
            $mail->addAddress($email);
        
            // Konten
            $mail->isHTML(true);
            $mail->Subject = 'Resend - Email Verification from LOGINOOP';

            $email_template = "
                <h2>You Have Registerd with email verification</h2>
                <h5>Verify your email addres to login with the below given link</h5>
                <br>
                <a href='http://localhost:8321/controllers/verify.php?token=$verify_token'>Click Here</a>
            ";


            $mail->Body    = $email_template;
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function send_password_reset($get_name,$get_email,$token)
    {
        $mail = new PHPMailer(true);
        
        try {
            // Pengaturan server
            $mail->isSMTP();
            $mail->Host       = 'localhost'; // Mailpit berjalan di localhost
            $mail->SMTPAuth   = false; // Mailpit tidak membutuhkan autentikasi
            $mail->Port       = 1025; // Port default Mailpit untuk SMTP
        
            // Penerima
            $mail->setFrom('your_email@example.com', $get_name);
            $mail->addAddress($get_email);
        
            // Konten
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Notification';

            $email_template = "
                <h2>Hello</h2>
                <h5>You are receiving this email because we received a password reset request for your account.</h5>
                <br>
                <a href='http://localhost:8321/views/password-change.php?token=$token&email=$get_email'>Click Here</a>
            ";


            $mail->Body    = $email_template;
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
