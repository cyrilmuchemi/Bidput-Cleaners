<?php
var_dump($_POST);
require_once "../app/core/functions.php";

if (!empty($_POST['data_type'])) {
    if($_POST['data_type'] === 'signup')
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];

        if (empty($first_name) || empty($last_name) || empty($password) || empty($phone_number)) {
            echo "Please fill in all fields.";
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (email, first_name, last_name, phone_number, role, password) VALUES (:email, :first_name, :last_name, :phone_number, 'customer', :password)";
        $data = array(':email' => $email, ':first_name' => $first_name, ':password' => $hashed_password, ':last_name' => $last_name, ':phone_number' => $phone_number);

        if (db_query($query, $data)) {
            echo "Signup Successful";
        } else {
            echo "Could not Signup";
        }
    }
}
