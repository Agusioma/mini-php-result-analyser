<?php
require_once "connection.php";
$rankArray = array();
$rankMarks = array();
$finTotal = 0;
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

if($cat!="General"){

$sql = "SELECT * FROM marks WHERE cat='$cat' AND term='$term' ORDER BY total DESC, totalmks DESC";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        ?>
        <span style="text-align: center"><h3 class="text-danger"><?php echo("CAT ". $cat ." TERM ".$term." RESULTS");?></h3><span>
        <table class="table table-sm table-striped table-responsive">
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
}else{

    $sqlA = "SELECT * FROM marks WHERE term='$term' ORDER BY total DESC";
    if($resultA = $mysqli->query($sql)){
        if($resultA->num_rows > 0){
            while($row = $resultA->fetch_array()){
    
                $nameToken = $row['admission'];

                    $totalsQuery4 = "SELECT * FROM marks WHERE admission='$nameToken' AND cat='One' AND term='$term' ORDER BY total DESC";
                    if($totalsQueryResults4 = $mysqli->query($totalsQuery4)){
                        $totalsQueryRow4 = $totalsQueryResults4->fetch_array();
                        $cat1Eng = $totalsQueryRow4['english'];
                        $cat1Kis = $totalsQueryRow4['kiswahili'];
                        $cat1Mat = $totalsQueryRow4['mathematics'];
                        $cat1Che = $totalsQueryRow4['chemistry'];
                        $cat1Phy = $totalsQueryRow4['physics'];
                        $cat1Bio = $totalsQueryRow4['biology'];
                        $cat1Geo = $totalsQueryRow4['geo'];
                        $cat1His = $totalsQueryRow4['history'];
                        $cat1CRE = $totalsQueryRow4['cre'];
                        $cat1Agr = $totalsQueryRow4['agriculture'];
                        $cat1Bus= $totalsQueryRow4['business'];
                       
                    }
                    $totalsQuery5 = "SELECT * FROM marks WHERE admission='$nameToken' AND cat='Two' AND term='$term' ORDER BY total DESC";
                    if($totalsQueryResults5 = $mysqli->query($totalsQuery5)){
                        $totalsQueryRow5 = $totalsQueryResults5->fetch_array();
                        $cat2Eng = $totalsQueryRow5['english'];
                        $cat2Kis = $totalsQueryRow5['kiswahili'];
                        $cat2Mat = $totalsQueryRow5['mathematics'];
                        $cat2Che = $totalsQueryRow5['chemistry'];
                        $cat2Phy = $totalsQueryRow5['physics'];
                        $cat2Bio = $totalsQueryRow5['biology'];
                        $cat2Geo = $totalsQueryRow5['geo'];
                        $cat2His = $totalsQueryRow5['history'];
                        $cat2CRE = $totalsQueryRow5['cre'];
                        $cat2Agr = $totalsQueryRow5['agriculture'];
                        $cat2Bus= $totalsQueryRow5['business'];
                    }
                    $totalsQuery6 = "SELECT * FROM marks WHERE admission='$nameToken' AND cat='Three' AND term='$term' ORDER BY total DESC";
                    if($totalsQueryResults6 = $mysqli->query($totalsQuery6)){
                        $totalsQueryRow6 = $totalsQueryResults6->fetch_array();
                        $cat3Eng = $totalsQueryRow6['english'];
                        $cat3Kis = $totalsQueryRow6['kiswahili'];
                        $cat3Mat = $totalsQueryRow6['mathematics'];
                        $cat3Che = $totalsQueryRow6['chemistry'];
                        $cat3Phy = $totalsQueryRow6['physics'];
                        $cat3Bio = $totalsQueryRow6['biology'];
                        $cat3Geo = $totalsQueryRow6['geo'];
                        $cat3His = $totalsQueryRow6['history'];
                        $cat3CRE = $totalsQueryRow6['cre'];
                        $cat3Agr = $totalsQueryRow6['agriculture'];
                        $cat3Bus= $totalsQueryRow6['business'];
                    }
                $EngTot = number_format((($cat1Eng + $cat2Eng + $cat3Eng)/3),0);
                $KisTot = number_format((($cat1Kis + $cat2Kis + $cat3Kis)/3),0);
                $MatTot = number_format((($cat1Mat + $cat2Mat + $cat3Mat)/3),0);
                $CheTot = number_format((($cat1Che + $cat2Che + $cat3Che)/3),0);
                $PhyTot = number_format((($cat1Phy + $cat2Phy + $cat3Phy)/3),0);
                $BioTot = number_format((($cat1Bio + $cat2Bio + $cat3Bio)/3),0);
                $GeoTot = number_format((($cat1Geo + $cat2Geo + $cat3Geo)/3),0);
                $HisTot = number_format((($cat1His + $cat2His + $cat3His)/3),0);
                $CRETot = number_format((($cat1CRE + $cat2CRE + $cat3CRE)/3),0);
                $AgrTot = number_format((($cat1Agr + $cat2Agr + $cat3Agr)/3),0);
                $BusTot = number_format((($cat1Bus + $cat2Bus + $cat3Bus)/3),0);

                $totalMk = $EngTot+$KisTot+$MatTot+$CheTot+$PhyTot+$BioTot+$GeoTot+$HisTot+$CRETot+$AgrTot+$BusTot;
                $totalPts = AssignPoint($EngTot)+AssignPoint($KisTot)+AssignPoint($MatTot)+AssignPoint($CheTot)+AssignPoint($PhyTot)+AssignPoint($BioTot)+AssignPoint($GeoTot)+AssignPoint($HisTot)+AssignPoint($CRETot)+AssignPoint($AgrTot)+AssignPoint($BusTot);
                $meanPts = number_format($totalPts/11, 2);
                $meanMk = number_format($totalMk/11, 2);
    
                $resultFinalQuery = "SELECT * FROM marks WHERE admission='$nameToken' AND cat='$cat' AND term='$term' ORDER BY total DESC, totalmks DESC";
                $resultFinal = $mysqli->query($resultFinalQuery);
                if($resultFinal->num_rows==0){
            
                        $resultFinalQuery1 = "INSERT INTO marks (admission, term, cat) VALUES (?, ?, ?)";
                        $resultFinalStmt = $mysqli->prepare($resultFinalQuery1);
                            // Bind variables to the prepared statement as parameters
                            $resultFinalStmt->bind_param("sss", $param1, $param2, $param3);
                            
                            // Set parameters
                            $param1 = $nameToken;
                            $param2 = $term;
                            $param3 = $cat;
                            // Attempt to execute the prepared statement
                            $uQuery = "UPDATE marks SET english='$EngTot',kiswahili='$KisTot',mathematics='$MatTot',chemistry='$CheTot',biology='$BioTot',physics='$PhyTot',history='$HisTot',geo='$GeoTot',cre='$CRETot', agriculture='$AgrTot',business='$BusTot', total='$totalPts',totalmks='$totalMk' WHERE admission='$nameToken' AND cat='$cat' AND term='$term'";
                            $mysqli->query($uQuery);           
                }else{
                    $uQuery1 = "UPDATE marks SET english='$EngTot',kiswahili='$KisTot',mathematics='$MatTot',chemistry='$CheTot',biology='$BioTot',physics='$PhyTot',history='$HisTot',geo='$GeoTot',cre='$CRETot',agriculture='$AgrTot',business='$BusTot', total='$totalPts',totalmks='$totalMk' WHERE admission='$nameToken' AND cat='$cat' AND term='$term'";
                    $mysqli->query($uQuery1);
                }
                
            }
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

    $sql = "SELECT * FROM marks WHERE cat='$cat' AND term='$term' ORDER BY total DESC, totalmks DESC";
    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){
            ?>
            <span style="text-align: center"><h3 class="text-danger"><?php echo("CAT ". $cat ." TERM ".$term." RESULTS");?></h3><span>
            <table class="table table-sm table-striped table-responsive">
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


}
// Close connection
$mysqli->close();
}

function display($cat, $term){

}

?>