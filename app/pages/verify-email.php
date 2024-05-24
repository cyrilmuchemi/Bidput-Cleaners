<?php

define('CLASSES', dirname(__DIR__, 2));

require_once CLASSES . "/public/Connection.php";

Class VerifyEmail{

    private $token;
    private $response;
    private $db;

    public function __construct()
    {
        $this->token = $_GET['token'];
        $this->db = Connection::getInstance();
        $this->response = ['success' => false, 'message' => '', 'errors' => []];
    }
    public function get_token()
    {
        $my_token = $this->token;
        $query = "SELECT verify_token, verify_status FROM users WHERE verify_token = :verify_token LIMIT 1";
        $data = ['verify_token' => $my_token];
        $rows = $this->db->dbRead($query, $data);
    
        if (!empty($rows)) {
            $row = $rows[0];
    
            if (isset($row['verify_token']) && isset($row['verify_status'])) {
                $verify_token = $row['verify_token'];
                $verify_status = $row['verify_status'];
    
                if ($verify_status === 0) {
                    $update_query = "UPDATE users SET verify_status = :verify_status WHERE verify_token = :verify_token LIMIT 1";
                    $update_data = [
                        'verify_status' => 1,
                        'verify_token' => $verify_token
                    ];
    
                    $update_status = $this->db->dbUpdate($update_query, $update_data);
                    if ($update_status) {
                        $this->response = [
                            'success' => true,
                            'message' => 'Email Registration Successful!',
                            'errors' => []
                        ];
                        redirect('login'); 
                        exit(0);
                    } else {
                        $this->response = [
                            'success' => false,
                            'message' => 'Failed to update verification status!',
                            'errors' => []
                        ];
                    }
                } elseif ($verify_status === 1) {
                    $this->response = [
                        'success' => false,
                        'message' => 'Email has already been Verified!',
                        'errors' => []
                    ];
                }
            } else {
                $this->response = [
                    'success' => false,
                    'message' => '',
                    'errors' => ['message' => 'Verify status or token does not exist!']
                ];
            }
        } else {
            $this->response = [
                'success' => false,
                'message' => '',
                'errors' => ['message' => 'Token does not exist!']
            ];
        }
    }
    

    public function get_response()
    {
        return $this->response;
    }

}

$verify_email = new VerifyEmail();
$verify_email->get_token();

echo json_encode($verify_email->get_response());