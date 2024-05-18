<?php

require_once 'Connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class SignupHandler
{
    private $response;
    private $db;

    public function __construct()
    {
        $this->response = ['success' => false, 'message' => '', 'errors' => []];
        $this->db = Connection::getInstance();
        session_start();
    }

    public function handleSignup($postData)
    {
        $errors = $this->validateData($postData);

        if (!empty($errors)) {
            $this->response['message'] = "Validation failed";
            $this->response['errors'] = $errors;
        } else {
            $email = $postData['email'];
            $existing_mail_query = "SELECT id FROM users WHERE email = :email LIMIT 1";
            $result = $this->db->dbRead($existing_mail_query, ['email' => $email]);
            if ($result) {
                $this->response['message'] = "That email already exists";
            } else {
                $this->registerUser($postData);
            }
        }
        $this->sendResponse();
    }

    private function validateData($data)
    {
        $errors = [];
        $requiredFields = ['first_name', 'last_name', 'email', 'password'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "Please fill in $field";
            }
        }
        return $errors;
    }

    private function registerUser($post = [])
    {
        $data['user_id'] = $this->createUserId();
        $data['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        $data['verify_token'] = md5(rand());
        $data['role'] = "customer";
        $data['first_name'] = $post['first_name'];
        $data['last_name'] = $post['last_name'];
        $data['email'] = $post['email'];

        $query = "INSERT INTO users (email, first_name, last_name, verify_token, role, password, user_id) VALUES (:email, :first_name, :last_name, :verify_token, :role, :password, :user_id)";
        $signed = $this->db->dbInsert($query, $data);

        if ($signed) {
            $this->sendEmailVerify($data['first_name'], $data['email'], $data['verify_token']);
            $this->response['message'] = 'Registration Successful. Verify your Email to Continue';
            $this->response['success'] = true;
        } else {
            $this->response['message'] = 'Registration failed. Please check your details and try again.';
        }
    }

    private function sendResponse()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
        exit;
    }

    private function createUserId()
    {
        $length = rand(4, 20);
        $number = "";
    
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
    
        return $number;
    }

    private function sendEmailVerify($firstName, $email, $verifyToken)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
           // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  
            $mail->isSMTP();                                          
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                 
            $mail->Username   = 'bidputcleaners@gmail.com';                    
            $mail->Password   = 'urzg axst ihba gfqd';                              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
            $mail->Port       = 465;                                  

            // Recipients
            $mail->setFrom('bidputcleaners@gmail.com', 'Bidput Cleaners');
            $mail->addAddress($email);     

            // Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'Email verification from Bidput Cleaners';
            $mail->Body    = "
                <h2>You have registered with Bidput Cleaners</h2>
                <h5>Verify your Email address by clicking the link below!</h5>
                <a href='http://localhost/bidput-cleaners/public/verify-email?token=$verifyToken'>Click Here</a>
            ";
            $mail->AltBody = "
                You have registered with Bidput Cleaners. 
                Verify your Email address by clicking the link below! 
                http://localhost/bidput-cleaners/public/verify-email?token=$verifyToken
            ";
        
            $mail->send();
            error_log('Message has been sent');
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
