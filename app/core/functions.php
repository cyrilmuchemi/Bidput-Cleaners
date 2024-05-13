<?php

create_tables();

function create_tables()
{

    $string = "mysql:hostname=localhost;dbname=" .DBNAME;
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
        phone_number VARCHAR(50) NOT NULL,
        role VARCHAR(50) NOT NULL,
        password VARCHAR(200) NOT NULL,
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
}

