<?php
require_once "connection.php";
$sql = "SELECT * FROM students";
$result = $mysqli->query($sql);
    echo($result->num_rows);      
$mysqli->close();
?>