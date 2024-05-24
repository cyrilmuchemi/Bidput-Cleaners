<?php

require_once 'SignupHandler.php';
require_once 'LoginHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['data_type'])) {
    if( $_POST['data_type'] === 'signup')
    {
        $signupHandler = new SignupHandler();
        $signupHandler->handleSignup($_POST);
        $signupHandler->sendResponse();
    }else if($_POST['data_type'] === 'login')
    {
        $loginHandler = new LoginHandler();
        $loginHandler->get_user($_POST);
        $loginHandler->get_response($_POST);
    }
}