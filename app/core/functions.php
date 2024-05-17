<?php
function sendemail_verify($name, $email, $verify_token)
{
   

}

function redirect($page)
{
    header('Location: '.ROOT. '/' . $page);

    die();
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



