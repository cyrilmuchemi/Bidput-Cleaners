<?php

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $query = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
    $row = db_query_row($query);

    if($row)
    {
        $verify_token = $row['verify_token'];

        if($row['verify_status'] === 0)
        {
            $clicked_token = $verify_token;
            $update_query = "UPDATE users SET verify_status = 1 WHERE verify_token='$clicked_token' LIMIT 1";
            $update_status = db_query_row($update_query);

            $_SESSION['status'] = "Verification Successful. Please login";
            redirect('login');
            exit(0);
        }else{
            $_SESSION['status'] = "Email has already been verified!";
        }
    }else{
        $_SESSION['status'] = "Token does not exist!";
        redirect('login');
    }
}else
{
    $_SESSION['status'] = "Access Denied!";
    redirect('login');
}