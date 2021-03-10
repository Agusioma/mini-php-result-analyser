<?php
require_once "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $emailaddress = trim($_POST["emailaddress"]);
    $password = trim($_POST["password"]);

    $sql = "INSERT INTO teacher (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssss", $param1, $param2, $param3, $param4);
        
        // Set parameters
        $param1 = $firstname;
        $param2 = $lastname;
        $param3 = $emailaddress;
        $param4 = $password;
        
        // Attempt to execute the prepared statement
        $stmt->execute();
        echo('Saved successfully');
     
    // Close statement
    $stmt->close();
}
$mysqli->close();
?>