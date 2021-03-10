<?php
require_once "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $admission = trim($_POST["admission"]);
    $cat = trim($_POST["cat"]);
    $term = trim($_POST["term"]);
    $subject = trim($_POST["subject"]);
    $mark = trim($_POST["mark"]);

    $sql = "SELECT admission FROM marks WHERE admission='$admission' AND cat='$cat' AND term='$term'";
    $result = $mysqli->query($sql);
    if($result->num_rows==0){

            $sql = "INSERT INTO marks (admission, term, cat) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $param1, $param2, $param3);
                
                // Set parameters
                $param1 = $admission;
                $param2 = $term;
                $param3 = $cat;
                
                // Attempt to execute the prepared statement
                $stmt->execute();
                $sql = "UPDATE marks SET $subject='$mark' WHERE admission=$admission AND cat='$cat' AND term='$term'";
                $mysqli->query($sql);
                echo('Marks Saved');
    }else{
        $sql = "UPDATE marks SET $subject='$mark' WHERE admission=$admission AND cat='$cat' AND term='$term'";
        if($mysqli->query($sql)===true){
        echo('Marks Saved');
        }else{
        echo "ERROR: ".$mysqli->error;
        }
    }
 
}

?>