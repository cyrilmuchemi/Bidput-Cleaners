<?php
require_once 'Connection.php';

class LoginHandler{
    private $db;
    private $response;

    public function __construct()
    {
        $this->response = ['success' => false, 'message' => '', 'errors' => []];
        $this->db = Connection::getInstance();
        session_start();
    }

    
    private function validate_data($data):bool
    {
        $requiredFields = ['email', 'password'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $this->response['message'] = 'Please fill in the required fields!';
                $this->response['success'] = false;
                return false;
            }
        }
        return true;
    }

    public function verify_password($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function get_user($post = [])
    {
        if(!$this->validate_data($post))
        {
            return $this->response;
        }

        $email = $post['email'];
        $password = $post['password'];

        $user_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $data = ['email' => $email];
        $rows = $this->db->dbRead($user_query, $data);

        if($rows && isset($rows[0]))
        {
            $user = $rows[0];

            if($this->verify_password($password, $user['password']))
            {
                if($user['verify_status'] == 1)
                {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $this->response['message'] = 'Login Successful.';
                    $this->response['success'] = true;
                    header("Location: home");
                }else{
                    $this->response['message'] = 'Please verify your Email Address';
                    $this->response['success'] = false;
                }
            }else{
                $this->response['message'] = 'Invalid Email or Password!';
                $this->response['success'] = true;
            }
        }else{
            $this->response['message'] = 'User not found! Register to continue';
            $this->response['success'] = true;
        }

    }

    public function get_response()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
        exit;
    }
}