<?php
header('Content-Type: application/json');
require_once "../app/core/functions.php";

if (!empty($_POST['data_type'])) {

    $errors = [];
    $response = [];

    if($_POST['data_type'] === 'signup')
    {
        $required_fields = ['first_name', 'last_name', 'email', 'password'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = "Please fill in $field";
            }
        }

        if(empty($errors))
        {
            $_POST['user_id'] = create_user_id();

            $existing_email = db_query("SELECT id FROM users WHERE email = :email LIMIT 1", ['email' => $_POST['email']]);
            if ($existing_email) {
                $errors['email'] = "That email already exists";
                echo json_encode($response);
                exit();
            }

            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'verify_token' => md5(rand()),
                'role' => "customer",
                'user_id' => $_POST['user_id']
            ];

            $query = "INSERT INTO users (email, first_name, last_name, verify_token, role, password, user_id) VALUES (:email, :first_name, :last_name, :verify_token, :role, :password, :user_id)";
            $signed = db_query($query, $data);

            if($signed)
            {
                $response = ['success' => true, 'message' => 'Registration Successful. Verify your Email to Continue'];
                sendemail_verify($data['first_name'], $data['email'], $data['verify_token']);
                $_SESSION['status'] = "Registration Successful! Verify your Email to Continue";
            }else{
                $response = ['success' => false, 'message' => 'Registration failed. Please check your details and try again.'];
            }
        }
        else {
            $response = ['success' => false, 'message' => 'Validation failed', 'errors' => $errors];
        }
    }
    echo json_encode($response);
}
?>
