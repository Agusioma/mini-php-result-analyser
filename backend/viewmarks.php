<?php
require_once "connection.php";
$rankArray = array();
$rankMarks = array();
function AssignGrade($arg){
    if($arg>=85){
        return "A";
      }else  if($arg>=80){
        return "A-";
      }else  if($arg>=75){
        return "B+";
      }else  if($arg>=70){
        return "B";
      }else  if($arg>=65){
        return "B-";
      }else  if($arg>=60){
        return "C+";
      }else  if($arg>=55){
        return "C";
      }else  if($arg>=50){
        return "C-";
      }else  if($arg>=45){
        return "D+";
      }else  if($arg>=40){
        return "D";
      }else  if($arg>=35){
        return "D-";
      }else  if($arg<=34){
        return "E";
      }
}
function AssignPoint($arg){
    if($arg>=85){
        return 12;
      }else  if($arg>=80){
        return 11;
      }else  if($arg>=75){
        return 10;
      }else  if($arg>=70){
        return 9;
      }else  if($arg>=65){
        return 8;
      }else  if($arg>=60){
        return 7;
      }else  if($arg>=55){
        return 6;
      }else  if($arg>=50){
        return 5;
      }else  if($arg>=45){
        return 4;
      }else  if($arg>=40){
        return 3;
      }else  if($arg>=35){
        return 2;
      }else  if($arg>=0){
        return 1;
      }
}
function AssignPointGrade($arg){
    if($arg==12){
        return "A";
      }else  if($arg>=11){
        return "A-";
      }else  if($arg>=10){
        return "B+";
      }else  if($arg>=9){
        return "B";
      }else  if($arg>=8){
        return "B-";
      }else  if($arg>=7){
        return "C+";
      }else  if($arg>=6){
        return "C";
      }else  if($arg>=5){
        return "C-";
      }else  if($arg>=4){
        return "D+";
      }else  if($arg>=3){
        return "D";
      }else  if($arg>=2){
        return "D-";
      }else  if($arg>=0){
        return "E";
      }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $cat = trim($_POST["cat"]);
    $term = trim($_POST["term"]);

    $rankStmt = "SELECT * FROM marks WHERE cat='$cat' AND term='$term' ORDER BY total DESC, totalmks DESC";
    if($rankQuery = $mysqli->query($rankStmt)){
        if($rankQuery->num_rows > 0){
          while($rankRow = $rankQuery->fetch_array()){
          $rankArray[]=$rankRow['total'];
          $rankTotal[] = ($rankRow['english']+$rankRow['mathematics']+$rankRow['kiswahili']+$rankRow['chemistry']+$rankRow['biology']+$rankRow['physics']+$rankRow['geo']+$rankRow['history']+$rankRow['cre']+$rankRow['agriculture']+$rankRow['business']);
        }
        }
    }
$sql = "SELECT * FROM marks WHERE cat='$cat' AND term='$term' ORDER BY total DESC, totalmks DESC";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        ?>
        <span  style="text-align: center"><h3 class="text-danger"><?php echo("CAT ". $cat ." TERM ".$term." RESULTS");?></h3><span>
        <table id="0101" class="table table-sm table-striped table-responsive">
            <tr>
                <th class="text-info">Student Name</th>
                <th class="text-info">Adm</th>
                <th class="text-info">ENG</th>
                <th class="text-dark">GR</th>
                <th class="text-info">MAT</th>
                <th class="text-dark">GR</th>
                <th class="text-info">KIS</th>
                <th class="text-dark">GR</th>
                <th class="text-info">CHE</th>
                <th class="text-dark">GR</th>
                <th class="text-info">BIO</th>
                <th class="text-dark">GR</th>
                <th class="text-info">PHY</th>
                <th class="text-dark">GR</th>
                <th class="text-info">GEO</th>
                <th class="text-dark">GR</th>
                <th class="text-info">HIS</th>
                <th class="text-dark">GR</th>
                <th class="text-info">CRE</th>
                <th class="text-dark">GR</th>
                <th class="text-info">AGR</th>
                <th class="text-dark">GR</th>
                <th class="text-info">BUS</th>
                <th class="text-dark">GR</th>
                <th class="text-info">TOT</th>
                <th class="text-info">M. MK</th>
                <th class="text-info">PTS</th>
                <th class="text-info">M. GR</th>
                <th class="text-info">POS</th>
            </tr>
        <?php
        $rank=1;
        $prev_rank=$rank;
        $saa=0;
        for ($i=0; $i < count($rankArray) ; $i++) {
        //while($row = $result->fetch_array()){
          $row = $result->fetch_array();
          if($i==0){
            $saa=$rank;
        //////echo"POS".($prev_rank);
        
        
        }
        elseif($rankArray[$i]!=$rankArray[$i-1]){
        $rank++;
        $prev_rank=$rank;
        $saa=$rank;
        //////echo"POS".($prev_rank);
        
        
        }
        else{
          if($rankTotal[$i]!=$rankTotal[$i-1]){
            $rank++;
            $prev_rank=$rank;
            $saa=$rank;
            //////echo"POS".($prev_rank);
            
            }
            else{
            $rank++;
            $saa=$prev_rank;
            //echo"POS".($prev_rank);
            }
        }
            $nametoken = $row['admission'];
            $totalMk = $row['english']+$row['mathematics']+$row['kiswahili']+$row['chemistry']+$row['biology']+$row['physics']+$row['geo']+$row['history']+$row['cre']+$row['agriculture']+$row['business'];
            $totalPts = AssignPoint($row['english'])+AssignPoint($row['mathematics'])+AssignPoint($row['kiswahili'])+AssignPoint($row['chemistry'])+AssignPoint($row['biology'])+AssignPoint($row['physics'])+AssignPoint($row['geo'])+AssignPoint($row['history'])+AssignPoint($row['cre'])+AssignPoint($row['agriculture'])+AssignPoint($row['business']);
            $meanPts = number_format($totalPts/11, 2);
            $meanMk = number_format($totalMk/11, 2);


            $insertTotal = "UPDATE marks SET total='$totalPts',totalmks='$totalMk' WHERE admission='$nametoken' AND cat='$cat' AND term='$term'";
            $mysqli->query($insertTotal);

            $nameStmt = "SELECT * FROM students WHERE admission='$nametoken'";
            if($nameResults = $mysqli->query($nameStmt)){
                $nameRow = $nameResults->fetch_array();
            }
            echo "<tr>";
                echo "<td>" . $nameRow['first_name']." ".$nameRow['last_name'] . "</td>";
                echo "<td>" . $row['admission'] . "</td>";
                echo "<td>" . $row['english'] . "</td>";
                echo "<td>" . AssignGrade($row['english']) . "</td>";
                echo "<td>" . $row['mathematics'] . "</td>";
                echo "<td>" . AssignGrade($row['mathematics']) . "</td>";
                echo "<td>" . $row['kiswahili'] . "</td>";
                echo "<td>" . AssignGrade($row['kiswahili']) . "</td>";
                echo "<td>" . $row['chemistry'] . "</td>";
                echo "<td>" . AssignGrade($row['chemistry']) . "</td>";
                echo "<td>" . $row['biology'] . "</td>";
                echo "<td>" . AssignGrade($row['biology']) . "</td>";
                echo "<td>" . $row['physics'] . "</td>";
                echo "<td>" . AssignGrade($row['physics']) . "</td>";
                echo "<td>" . $row['geo'] . "</td>";
                echo "<td>" . AssignGrade($row['geo']) . "</td>";
                echo "<td>" . $row['history'] . "</td>";
                echo "<td>" . AssignGrade($row['history']) . "</td>";
                echo "<td>" . $row['cre'] . "</td>";
                echo "<td>" . AssignGrade($row['cre']) . "</td>";
                echo "<td>" . $row['agriculture'] . "</td>";
                echo "<td>" . AssignGrade($row['agriculture']) . "</td>";
                echo "<td>" . $row['business'] . "</td>";
                echo "<td>" . AssignGrade($row['business']) . "</td>";
                echo "<td>" . $totalMk . "</td>";
                echo "<td>" . $meanMk . "</td>";
                echo "<td>" . $totalPts . "</td>";  
                echo "<td>" . AssignPointGrade($meanPts) . "</td>";
                echo "<td>" . $saa . "</td>";           
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        $result->free();
    } else{
        ?>
        <span style="text-align: center"><h3 class="text-danger">Sorry, no results found. Please try feeding marks to the system before proceeding.</h3></span>
        <?php
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
}
?>