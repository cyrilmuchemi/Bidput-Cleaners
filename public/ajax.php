<?php

require_once 'SignupHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data_type']) && $_POST['data_type'] === 'signup') {
    $signupHandler = new SignupHandler();
    $signupHandler->handleSignup($_POST);
}
