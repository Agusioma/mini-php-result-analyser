<?php
require_once "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $firstname = trim($_POST["first_name"]);
    $lastname = trim($_POST["last_name"]);
    $adm = trim($_POST["admission"]);
    $gen = trim($_POST["gender"]);

    $sql = "INSERT INTO students (first_name, last_name, admission, gender) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssss", $param1, $param2, $param3, $param4);
        
        // Set parameters
        $param1 = $firstname;
        $param2 = $lastname;
        $param3 = $adm;
        $param4 = $gen;
        
        // Attempt to execute the prepared statement
        $stmt->execute();
        echo('Saved successfully');
     
    // Close statement
    $stmt->close();
}
$mysqli->close();
?>