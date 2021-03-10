<?php
require_once "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
        $emailaddress = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $sql = "SELECT email FROM teacher WHERE email = '$emailaddress' AND password = '$password'";
        $stmt = $mysqli->query($sql);
            if($stmt->num_rows>0){
                echo("Access granted");
            }else{
                echo("Access Denied");
            }
    // Close connection
    $mysqli->close();
}
?>