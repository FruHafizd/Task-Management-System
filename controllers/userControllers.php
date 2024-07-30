<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once "phpMailer.php";
include '../config/connection.php';
session_start();

class UserControllers 
{
    private $conn;

    public function __construct() 
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function register()
    {   
        if (isset($_POST['register_btn'])) 
        {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $phone = $_POST['phone'];
            $name = $_POST['name'];
            $verify_token = md5(rand());

            // Prepare and execute statement to check if email already exists
            $check_email_query = "SELECT email FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($check_email_query);
            $stmt->execute(['email' => $email]);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['status'] = "Email Id Already Exists";
                header("Location: ../views/register.php");
            } else {
                // Prepare and execute statement to insert new user
                $query = "INSERT INTO users (email, password, phone, name, verify_token) VALUES (:email, :password, :phone, :name, :verify_token)";
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute([
                    'email' => $email,
                    'password' => $password_hashed,
                    'phone' => $phone,
                    'name' => $name,
                    'verify_token' => $verify_token
                ]);

                if ($result) {
                    $verifyUser = new PhpMailerUser();
                    $verifyUser->sendVerifyEmail($name, $email, $verify_token);
                    $_SESSION['status'] = "Registration Successfully, Please Verify Your Account";
                    header("Location: ../views/login.php");
                } else {
                    $_SESSION['status'] = "Registration Failed";
                    header("Location: ../views/register.php");
                }
            }
        }
    }

    public function login()
    {
        if (isset($_POST['login_now_btn'])) 
        {
            if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) 
            {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                // Cari pengguna berdasarkan email
                $login_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($login_query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) 
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hashed_password = $row['password'];

                    // Verifikasi password
                    if (password_verify($password, $hashed_password)) 
                    {
                        if ($row["verify_status"] == "1") 
                        {
                            $_SESSION['authenticated'] = TRUE;
                            $_SESSION['auth_user'] = [
                                'username' => $row['name'],
                                'phone' => $row['phone'],
                                'email' => $row['email'],
                            ];
                            $_SESSION['status'] = "You Are Logged In Successfully";
                            header("Location: ../views/index.php");
                            exit(0);
                        } 
                        else 
                        {
                            $_SESSION['status'] = "Please Verify Your Email Address To Log In";
                            header("Location: ../views/login.php");
                            exit(0);
                        }
                    } 
                    else 
                    {
                        $_SESSION['status'] = "Invalid Email Or Password";
                        header("Location: ../views/login.php");
                        exit(0);
                    }
                } 
                else 
                {
                    $_SESSION['status'] = "Invalid Email Or Password";
                    header("Location: ../views/login.php");
                    exit(0);
                }
            } 
            else 
            {
                $_SESSION['status'] = "All fields are Mandatory";
                header("Location: ../views/login.php");
                exit(0);
            }
        }
    }

    public function resendEmail()
    {   
        if (isset($_POST['resend_email_verify_btn'])) 
        {
            if (!empty(trim($_POST['email']))) {
                
                $email = trim($_POST['email']);

                $checkemail_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($checkemail_query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                
                if ($stmt->rowCount() > 0) 
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row['verify_status'] == "0") {

                        $name = $row['name'];
                        $email = $row['email'];
                        $verify_token = $row['verify_token'];
                        $verifyUser = new PhpMailerUser();
                        $verifyUser->resend_email_verify($name,$email,$verify_token);
                        $_SESSION['status'] = "Verification email has been sent to you email addres";
                        header("Location: ../views/login.php");
                        exit(0);
                    }else {
                        $_SESSION['status'] = "Email Already Verified. Please Log In";
                        header("Location: ../views/resend-email-verification.php");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Email Is not Registred. Please Registred Now";
                    header("Location: ../views/register.php");
                    exit(0);
                }
                

            }else {
                $_SESSION['status'] = "Please Enter the Email field";
                header("Location: ../views/resend-email-verification.php");
                exit(0);
            }
        } else {
            # code...
        }
    }


    public function passwordResetLink()
    {   
        if (isset($_POST['password_reset_link'])) {
            $email = trim($_POST['email']);
            $token = md5(rand());
        
            $check_email = "SELECT email FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($check_email);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $get_name = $row['name'];
                $get_email = $row['email'];
        
                $update_token = "UPDATE users SET verify_token = :token WHERE email = :email LIMIT 1";
                $update_stmt = $this->conn->prepare($update_token);
                $update_stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $update_stmt->bindParam(':email', $get_email, PDO::PARAM_STR);
                $update_result = $update_stmt->execute();
        
                if ($update_result) {
                    $verifyUser = new PhpMailerUser();
                    $verifyUser->send_password_reset($get_name,$get_email,$token);
                    $_SESSION['status'] = "We E-mail you a password reset link";
                    header("Location: ../views/password-reset.php");
                    exit(0);
        
                } else {
                    $_SESSION['status'] = "Something went Wrong. #1";
                    header("Location: ../views/password-reset.php");
                    exit(0);
                }
                
            }
            else {
                $_SESSION['status'] = "No Email Found";
                header("Location: ../views/password-reset.php");
                exit(0);
            }
            
        }
    }

    public function passwordUpdate()
    {
        if (isset($_POST['password_update'])) 
        {
            $email = trim($_POST['email']);
            $new_password = trim($_POST['new_password']);
            $confirm_password = trim($_POST['confirm_password']);
            $password_hashed = password_hash($confirm_password, PASSWORD_BCRYPT);
            $token = trim($_POST['password_token']);
    

            if (!empty($token)) {
                if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
                    // CHECK TOKEN VALID OR NOT
                    $check_token = "SELECT verify_token FROM users WHERE verify_token = :token LIMIT 1";
                    $stmt = $this->conn->prepare($check_token);
                    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) 
                    {
                        if ($new_password == $confirm_password) 
                        {
                            $update_password = "UPDATE users SET password = :password WHERE verify_token = :token LIMIT 1";
                            $update_stmt = $this->conn->prepare($update_password);
                            $update_stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);
                            $update_stmt->bindParam(':token', $token, PDO::PARAM_STR);
                            $update_result = $update_stmt->execute();

                            if ($update_result) {
                                $new_token = md5(rand());
                                $update_to_new_token = "UPDATE users SET verify_token = :new_token WHERE verify_token = :old_token";
                                $new_token_stmt = $this->conn->prepare($update_to_new_token);
                                $new_token_stmt->bindParam(':new_token', $new_token, PDO::PARAM_STR);
                                $new_token_stmt->bindParam(':old_token', $token, PDO::PARAM_STR);
                                $new_token_stmt->execute();

                                $_SESSION['status'] = "New Password Succesfully Updated!";
                                header("Location: ../views/login.php");
                                exit(0);
                            }else {
                                $_SESSION['status'] = "Did not update password something went wrong";
                                header("Location: ../views/password-change.php?token=$token&email=$email");
                                exit(0);
                            }

                        }else {
                            $_SESSION['status'] = "Password And confirm password does not match";
                            header("Location: ../views/password-change.php?token=$token&email=$email");
                            exit(0);
                        }
                    }else {
                        $_SESSION['status'] = "Invalid Token";
                        header("Location: ../views/password-change.php?token=$token&email=$email");
                        exit(0);
                    }

                }
                else {
                    $_SESSION['status'] = "All filed are mendetory";
                    header("Location: ../views/password-change.php?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "No Token Available";
                header("Location: ../views/password-reset.php");
                exit(0);
            }
            
        }
    }




}

$code = new UserControllers();
$code->register();
$code->login();
$code->resendEmail();
$code->passwordResetLink();
$code->passwordUpdate();
