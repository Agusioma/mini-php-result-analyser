<?php
require_once "connection.php";
 

$sql = "SELECT * FROM students";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        ?>
        <span style="text-align: center"><h3 class="text-danger">LIST OF STUDENTS</h3><span>
        <table class="table table-striped table-responsive">
            <tr>
                <th class="text-info">Student Name</th>
                <th class="text-info">Admission Number</th>
                <th class="text-info">Gender</th>
            </tr>
        <?php
        while($row = $result->fetch_array()){
            echo "<tr>";
                echo "<td>" . $row['first_name']." ".$row['last_name'] . "</td>";
                echo "<td>" . $row['admission'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        $result->free();
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
?>