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

    $sql = "SELECT * FROM marks WHERE term='$term' ORDER BY total DESC";
    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_array()){
    
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
                            $resultFinalStmt->execute();
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

    $sqlIndividual = "SELECT * FROM marks WHERE cat='$cat' AND term='$term' ORDER BY total DESC, totalmks DESC";
    if($result = $mysqli->query($sqlIndividual)){
        if($result->num_rows > 0){
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

    $totalMkA = $EngTot+$KisTot+$MatTot+$CheTot+$PhyTot+$BioTot+$GeoTot+$HisTot+$CRETot+$AgrTot+$BusTot;
    $totalPtsA = AssignPoint($EngTot)+AssignPoint($KisTot)+AssignPoint($MatTot)+AssignPoint($CheTot)+AssignPoint($PhyTot)+AssignPoint($BioTot)+AssignPoint($GeoTot)+AssignPoint($HisTot)+AssignPoint($CRETot)+AssignPoint($AgrTot)+AssignPoint($BusTot);
    
                $nametoken = $row['admission'];
                $totalMk = $row['english']+$row['mathematics']+$row['kiswahili']+$row['chemistry']+$row['biology']+$row['physics']+$row['geo']+$row['history']+$row['cre']+$row['agriculture']+$row['business'];
                $totalPts = AssignPoint($row['english'])+AssignPoint($row['mathematics'])+AssignPoint($row['kiswahili'])+AssignPoint($row['chemistry'])+AssignPoint($row['biology'])+AssignPoint($row['physics'])+AssignPoint($row['geo'])+AssignPoint($row['history'])+AssignPoint($row['cre'])+AssignPoint($row['agriculture'])+AssignPoint($row['business']);
                $meanPts = number_format($totalPts/11, 2);
                $meanMk = number_format($totalMk/11, 2);    
                $nameStmt = "SELECT * FROM students WHERE admission='$nametoken'";
                if($nameResults = $mysqli->query($nameStmt)){
                    $nameRow = $nameResults->fetch_array();
                } 
                /*echo "<tr>";
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
            echo "</table>";*/
            ?>
    <div style="width: 75%">
    <div class="text-danger" style="text-align: center;"><h3>CHEMCHEMI SECONDARY SCHOOL</h3></span></div>
      <div  style="text-align: center; font-weight: bold" class="text-primary" ><h4>P.O. BOX 89 - 90126</h4></div>
 <div style="text-align: center;">REPORT FORM</div>
          </div>
<table class="table  table-bordered border-dark table-striped tb-sm" style="width: 80%">
      <thead>
         <tr>
        <th colspan="9">
          <strong  style="margin-left: 6.5%; color:black">NAME:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black"><?php echo $nameRow['first_name']." ".$nameRow['last_name'];?></strong>
        <strong style=" color:black">ADM NO:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black"><?php echo $row['admission']; ?></strong>
        <strong style=" color:black">FORM:</strong>
        <strong style=" margin-right: 3%; font-weight: normal; color:black">1</strong>
         <strong style=" color:black">TERM:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black"><?php echo $term; ?></strong>
      </tr>
         <tr>
        <th colspan="9"><strong style="margin-left: 14.5%; color:black">FORM POS:</strong>
        	     <strong style="margin-right: 3%; font-weight: normal; color:red">
                 <?php echo $saa; ?>
       </strong>
        <strong style=" color:black">OUT OF:</strong>
        <strong style=" margin-right: 3%; font-weight: normal; color:black"><?php echo count($rankArray); ?></strong>
        <strong style="text-decoration: underline; margin-right: 3%; font-weight: normal; color:black"></strong>
        <strong style=" color:black">MEAN GRADE:</strong>
        <strong style=" margin-right: 3%; font-weight: normal; color:red"><?php echo AssignPointGrade($meanPts); ?></strong></th>
      </tr>
        <tr>
        <th colspan="9"><strong style="margin-left: 20.5%; color:black">T.MARKS:</strong>
        <strong style="text-decoration: underline; margin-right: 3%; font-weight: normal; color:black"><?php echo $totalMk; ?></strong>
        <strong style=" color:black">M.MARK:</strong>
        <strong style="text-decoration: underline; margin-right: 3%; font-weight: normal; color:black"><?php echo $meanMk; ?></strong>
        <strong style=" color:black">T.POINTS</strong>
        <strong style="text-decoration: underline; margin-right: 3%; font-weight: normal; color:black"><?php echo $totalPts; ?></strong>
        <strong style=" color:black">M.POINTS:</strong>
        <strong style="text-decoration: underline; margin-right: 3%; font-weight: normal; color:black"><?php echo $meanPts; ?></strong></th>
      </tr>
        <tr>
        <th class="text-info">SUBJECT</strong></th>
        <th><strong style=" color:black">CAT 1</strong></th>
        <th><strong style=" color:black">CAT 2</strong></th>
        <th><strong style=" color:black">END TERM</strong></th>
           <th><strong style=" color:black">AVERAGE</strong></th>
        <th><strong style=" color:black">GRADE</strong></th>
        <th><strong style=" color:black">POINTS</strong></th>
        <th><strong style=" color:black">REMARKS</strong></th>
      </tr>
      </thead>
      <tfoot>
        <tr>
        <th rowspan="2" colspan="3"><strong style=" color:black"></strong></th>
       <th rowspan="2"><strong style=" color:black">TOTAL</strong></th>
        <th><strong style=" color:red;text-align: center; font-size: .85em"><?php echo $totalMk; ?></strong></th>
        <th><strong class="text-primary" style="text-align: center; font-size: .85em"><?php echo AssignPointGrade($meanPts); ?></strong></th>
        <th><strong class="text-info" style="text-align: center; font-size: .85em"><?php echo $totalPts; ?></strong></th>
        </tr>
        <tr>
         <th><strong style=" color:black;text-align: center; font-size: .85em">1100</strong></th>
        <th><strong style=" color:black;text-align: center; font-size: .85em">A</strong></th>
        <th><strong style=" color:black; text-align: center; font-size: .85em">132</strong></th>
        </tr>
      </tfoot>
      <tbody>
 <tr>
          <td>English</td>
          <td><?php echo $cat1Eng; ?></td>
           <td><?php echo $cat2Eng;  ?></td>
          <td><?php echo $cat3Eng; ?></td> 
          <td><?php echo $row['english']; ?></td>
          <td><?php echo AssignGrade($row['english']); ?></td>
           <td><?php echo AssignPoint($row['english']); ?></td>
           <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['english'])); ?></td>
</tr>
<tr>
      <td>Kiswahili</td>
      <td><?php echo $cat1Kis; ?></td>
        <td><?php echo $cat2Kis;  ?></td>
      <td><?php echo $cat3Kis; ?></td> 
      <td><?php echo $row['kiswahili']; ?></td>
      <td><?php echo AssignGrade($row['kiswahili']); ?></td>
        <td><?php echo AssignPoint($row['kiswahili']); ?></td>
        <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo kisRemarks(AssignGrade($row['kiswahili'])); ?></td>
</tr>
<tr>
          <td>Mathematics</td>
          <td><?php echo $cat1Mat; ?></td>
            <td><?php echo $cat2Mat;  ?></td>
          <td><?php echo $cat3Mat; ?></td> 
          <td><?php echo $row['mathematics']; ?></td>
          <td><?php echo AssignGrade($row['mathematics']); ?></td>
            <td><?php echo AssignPoint($row['mathematics']); ?></td>
            <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['mathematics'])); ?></td>
</tr>
<tr>
        <td>Chemistry</td>
        <td><?php echo $cat1Che; ?></td>
          <td><?php echo $cat2Che;  ?></td>
        <td><?php echo $cat3Che; ?></td> 
        <td><?php echo $row['chemistry']; ?></td>
        <td><?php echo AssignGrade($row['chemistry']); ?></td>
          <td><?php echo AssignPoint($row['chemistry']); ?></td>
          <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['chemistry'])); ?></td>
</tr>
<tr>
          <td>Biology</td>
          <td><?php echo $cat1Bio; ?></td>
            <td><?php echo $cat2Bio;  ?></td>
          <td><?php echo $cat3Bio; ?></td> 
          <td><?php echo $row['biology']; ?></td>
          <td><?php echo AssignGrade($row['biology']); ?></td>
            <td><?php echo AssignPoint($row['biology']); ?></td>
            <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['biology'])); ?></td>
</tr>
<tr>
          <td>Physics</td>
          <td><?php echo $cat1Phy; ?></td>
            <td><?php echo $cat2Phy;  ?></td>
          <td><?php echo $cat3Phy; ?></td> 
          <td><?php echo $row['physics']; ?></td>
          <td><?php echo AssignGrade($row['physics']); ?></td>
            <td><?php echo AssignPoint($row['physics']); ?></td>
            <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['physics'])); ?></td>
</tr>
<tr>
              <td>Geography</td>
              <td><?php echo $cat1Geo; ?></td>
                <td><?php echo $cat2Geo;  ?></td>
              <td><?php echo $cat3Geo; ?></td> 
              <td><?php echo $row['geo']; ?></td>
              <td><?php echo AssignGrade($row['geo']); ?></td>
                <td><?php echo AssignPoint($row['geo']); ?></td>
                <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['geo'])); ?></td>
</tr>
<tr>
          <td>History</td>
          <td><?php echo $cat1His; ?></td>
            <td><?php echo $cat2His;  ?></td>
          <td><?php echo $cat3His; ?></td> 
          <td><?php echo $row['history']; ?></td>
          <td><?php echo AssignGrade($row['history']); ?></td>
            <td><?php echo AssignPoint($row['history']); ?></td>
            <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['history'])); ?></td>
</tr>
<tr>
            <td>CRE</td>
            <td><?php echo $cat1CRE; ?></td>
              <td><?php echo $cat2CRE;  ?></td>
            <td><?php echo $cat3CRE; ?></td> 
            <td><?php echo $row['cre']; ?></td>
            <td><?php echo AssignGrade($row['cre']); ?></td>
              <td><?php echo AssignPoint($row['cre']); ?></td>
              <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['cre'])); ?></td>
</tr>
<tr>
        <td>Agriculture</td>
        <td><?php echo $cat1Agr; ?></td>
          <td><?php echo $cat2Agr;  ?></td>
        <td><?php echo $cat3Agr; ?></td> 
        <td><?php echo $row['agriculture']; ?></td>
        <td><?php echo AssignGrade($row['agriculture']); ?></td>
          <td><?php echo AssignPoint($row['agriculture']); ?></td>
          <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['agriculture'])); ?></td>
</tr>
<tr>
            <td>Business</td>
            <td><?php echo $cat1Bus; ?></td>
              <td><?php echo $cat2Bus;  ?></td>
            <td><?php echo $cat3Bus; ?></td> 
            <td><?php echo $row['business']; ?></td>
            <td><?php echo AssignGrade($row['business']); ?></td>
              <td><?php echo AssignPoint($row['business']); ?></td>
              <td style="font-family: serif; font-size: 105%; font-style: italic"><?php echo subRemarks(AssignGrade($row['business'])); ?></td>
</tr>
     </tbody>
  </table>

  <table class="table  table-bordered border-dark table-striped tb-sm" style="width: 80%">
      <thead>
         <tr>
        <th colspan="9">
        <strong style=" color:black">Principal's Signature:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black">___________</strong>
          <strong  style="margin-left: 6.5%; color:black">Classteacher's Signature:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black">____________</strong>
        <strong style=" color:black">Parent's Signature:</strong>
        <strong style=" margin-right: 3%; font-weight: normal; color:black">____________</strong>
      </tr>
      </thead>  
          </table>
          <table class="table  table-bordered border-dark table-striped tb-sm" style="width: 80%">
      <thead>
         <tr>
        <th colspan="9">
        <strong style=" color:black">Opening Date:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black">___________</strong>
          <strong  style="margin-left: 6.5%; color:black">Closing Date:</strong>
        <strong style="margin-right: 3%; font-weight: normal; color:black">____________</strong>
      </tr>
      </thead>  
          </table>
            <?php 
        }

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

function subRemarks($arg) { 
if($arg=="A"){
  return "Excellent";
}else  if($arg=="A-"){
  return "Very very good";
}else  if($arg=="B+"){
  return "Very good";
}else  if($arg=="B"){
  return "Good";
}else  if($arg=="B-"){
  return "Good trial";
}else  if($arg=="C+"){
  return "Good trial";
}else  if($arg=="C"){
  return "Work harder";
}else  if($arg=="C-"){
  return "Work harder";
}else  if($arg=="D+"){
  return "Work more harder";
}else  if($arg=="D"){
  return "Work more harder";
}else  if($arg=="D-"){
  return "Work more harder";
}else  if($arg=="E"){
  return "Work more harder";
}else  if($arg=="_"){
  return "_";
}
}

function kisRemarks($arg) { 
  if($arg=="A"){
  return "Heko";
}else  if($arg=="A-"){
  return "Vyema kabisa";
}else  if($arg=="B+"){
  return "Vyema";
}else  if($arg=="B"){
  return "Jaribio njema";
}else  if($arg=="B-"){
  return "Jaribio njema";
}else  if($arg=="C+"){
  return "Tia bidii";
}else  if($arg=="C"){
  return "Tia bidii";
}else  if($arg=="C-"){
  return "Tia bidii kabisa";
}else  if($arg=="D+"){
  return "Tia bidii kabisa";
}else  if($arg=="D"){
  return "Tia bidii kabisa";
}else  if($arg=="D-"){
  return "Tia bidii kabisa";
}else  if($arg=="E"){
  return "Tia bidii kabisa";
}else  if($arg=="_"){
  return "_";
}
 }

?>