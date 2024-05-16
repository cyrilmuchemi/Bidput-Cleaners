<?php
require_once "../app/core/functions.php";

class SignupHandler{
    private $response;

    public function __construct()
    {
        $this->response = ['success' => false, 'message' => '', 'error' => []];
    }

    public function handleSignup($postData)
    {
        $errors = $this->validateData($postData);

        if(!empty($errors))
        {
            $this->response['message'] = "Validation failed";
            $this->response['errors'] = $errors;
        }else{
            $email =  $postData['email'];
            $existing_mail = db_insert("SELECT id FROM users WHERE email = :email LIMIT 1", ['email' => $email]);
            if($existing_mail)
            {
                $this->response['message'] = "That email already exists";
            }else {
                $this->registerUser($postData);
            }
        }
        $this->sendResponse();
    } 

    public function validateData($data)
    {
        $errors = [];
        $required_fields = ['first_name', 'last_name', 'email', 'password'];

        foreach($required_fields as $field)
        {
            if(empty($data[$field]))
            {
                $errors[$field] = "Please fill in $field";
            }
        }
        return $errors;
    }

    public function registerUser($data)
    {
        $data['user_id'] = create_user_id();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['verify_token'] = md5(rand());
        $data['role'] = "customer";

        $query = "INSERT INTO users (email, first_name, last_name, verify_token, role, password, user_id) VALUES (:email, :first_name, :last_name, :verify_token, :role, :password, :user_id)";
        $signed = db_query($query, $data);

        if ($signed) {
            $this->response['success'] = true;
            $this->response['message'] = 'Registration Successful. Verify your Email to Continue';
            sendemail_verify($data['first_name'], $data['email'], $data['verify_token']);
            $_SESSION['status'] = "Registration Successful! Verify your Email to Continue";
        } else {
            $this->response['message'] = 'Registration failed. Please check your details and try again.';
        }
    }

    private function sendResponse()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data_type']) && $_POST['data_type'] === 'signup') {
    $signupHandler = new SignupHandler();
    $signupHandler->handleSignup($_POST);
}
