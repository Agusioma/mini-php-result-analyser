<?php
require_once "connection.php";
 

$sql = "SELECT * FROM students";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        ?>
        <select id="idMark01" class="form-control">            
        <?php
        while($row = $result->fetch_array()){
            ?>
            <option value=<?php echo $row['admission']; ?>><?php echo $row['admission']; ?></option>
                <?php
        }
        echo "</select>";
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