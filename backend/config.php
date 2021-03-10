<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$mysqli = new mysqli("localhost", "root", "");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
// Attempt create database query execution
$sql = "CREATE DATABASE ra";
if($mysqli->query($sql) === true){
    echo "Database created successfully";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}

$mysqli->close();

$mysqli = new mysqli("localhost", "root", "", "ra");

// Attempt create table query execution
$sql = "CREATE TABLE students(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    admission VARCHAR(5) NOT NULL UNIQUE,
    gender VARCHAR(6) NOT NULL
)";
if($mysqli->query($sql) === true){
    echo "Table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}

// Attempt create table query execution
$sql = "CREATE TABLE marks(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    admission VARCHAR(5) NOT NULL,
    term VARCHAR(5) NOT NULL,
    cat VARCHAR(5) NOT NULL,
    english VARCHAR(3) NOT NULL DEFAULT 0,
    kiswahili VARCHAR(3) NOT NULL DEFAULT 0,
    mathematics VARCHAR(3) NOT NULL DEFAULT 0,
    chemistry VARCHAR(3) NOT NULL DEFAULT 0,
    biology VARCHAR(3) NOT NULL DEFAULT 0,
    physics VARCHAR(3) NOT NULL DEFAULT 0,
    history VARCHAR(3) NOT NULL DEFAULT 0,
    geo VARCHAR(3) NOT NULL DEFAULT 0,
    cre VARCHAR(3) NOT NULL DEFAULT 0,
    agriculture VARCHAR(3) NOT NULL DEFAULT 0,
    business VARCHAR(3) NOT NULL DEFAULT 0,
    total VARCHAR(4) NOT NULL DEFAULT 0,
    totalmks VARCHAR(4) NOT NULL DEFAULT 0
)";
if($mysqli->query($sql) === true){
    echo "Table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}

// Attempt create table query execution
$sql = "CREATE TABLE teacher(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE,
    password VARCHAR(20) NOT NULL
)";
if($mysqli->query($sql) === true){
    echo "Table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}

$mysqli->close();
?>