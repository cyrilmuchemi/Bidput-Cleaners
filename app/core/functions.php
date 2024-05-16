<?php

define('DBUSER', "root");
define('DBPASS', "");
define('DBNAME', "bidput_db");
define('DBHOST', "localhost");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../public/vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                     
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'bidputcleaners@gmail.com';                     //SMTP username
    $mail->Password   = 'urzg axst ihba gfqd';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('bidputcleaners@gmail.com', $name);
    $mail->addAddress($email);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email verification from Accounts Zone';
    $mail->Body    = "
    <h2>You have registered with Bidput Cleaners</h2>
    <h5>Verify your Email address by clicking the link below!</h5>
    <a href='http://localhost/bidput-cleaners/public/verify-email?token=$verify_token'>Click Here</a>
    ";
    $mail->AltBody = "
    <h2>You have registered with Bidput Cleaners</h2>
    <h5>Verify your Email address by clicking the link below!</h5>
    <a href='http://localhost/bidput-cleaners/public/verify-email?token=$verify_token'>Click Here</a>
    ";
    
    try {
        $mail->send($email);
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
   

}

function db_query(string $query, array $data = [], bool $isUpdate = false)
{
    try {
        $string = "mysql:host=".DBHOST.";dbname=".DBNAME;
        $con = new PDO($string, DBUSER, DBPASS);
        $stm = $con->prepare($query);
        $success = $stm->execute($data); 

        foreach($data as $key => &$value) 
        {
            $param_name = is_int($key) ? $key + 1 : ":$key";

            if(is_array($value))
            {
                //Handle array parameters
                foreach($value as $index => $item)
                {
                    $array_param_name = "{$key}_{$index}";
                    $stm->bindValue("$array_param_name", $item);
                }
                //Remove the original array parameter fro $data
                unset($data[$key]);
            }else{
                $stm->bindValue($param_name, $value);
            }
        }

        if($isUpdate)
        {
            $success = $stm->execute();
            return $success && $stm->rowCount() > 0;
        }else{
            $success = $stm->execute();

            if(!$success)
            {
                //Handle query execution failure
                return false;
            }

            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

function db_query_row(string $query, array $data = [])
{
    $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $con = new PDO($dsn, DBUSER, DBPASS, $options);
        $stm = $con->prepare($query);

        return $stm->fetch();

    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}

function db_insert(string $query, array $data = []) {
    try {
        $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME;
        $con = new PDO($dsn, DBUSER, DBPASS);
        $stm = $con->prepare($query);

        // Bind parameters
        foreach ($data as $key => $value) {
            $param_name = is_int($key) ? $key + 1 : ":$key";
            $stm->bindValue($param_name, $value);
        }

        // Execute query
        return $stm->execute();
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}


function redirect($page)
{
    header('Location: '.ROOT. '/' . $page);

    die();
}


function create_user_id()
{
    $length = rand(4, 20);
    $number = "";

    for($i = 0; $i < $length; $i++)
    {
        $new_rand = rand(0, 9);
        $number = $number . $new_rand;
    }

    return $number;
}

//create_tables();

function create_tables()
{

    $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
    $con = new PDO($string, DBUSER, DBPASS);

    $query = "create database if not exists ". DBNAME;
    $stm = $con->prepare($query);
    $stm->execute();

    $con->exec("USE " . DBNAME);

    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(100) NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        role VARCHAR(50) NOT NULL,
        password VARCHAR(200) NOT NULL,
        verify_token VARCHAR(255) NOT NULL,
        verify_status TINYINT(2) DEFAULT 0 NOT NULL,
        user_id BIGINT NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY email (email)
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    
    $query = "CREATE TABLE IF NOT EXISTS appointment (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(100) NOT NULL,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        phone_number VARCHAR(50) NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY phone_number (phone_number)
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "CREATE TABLE IF NOT EXISTS blogs (
        id INT PRIMARY KEY AUTO_INCREMENT,
        image VARCHAR(1024) NULL,
        title VARCHAR(100) NOT NULL,
        content TEXT NULL,
        slug VARCHAR(100) NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY title (title)
    )";
    $stm = $con->prepare($query);
    $stm->execute();

}



