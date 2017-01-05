<?php
  require("conn.php");
?>
<?php
  //calculate expected return, STD
  for($i = 0; $i < 112; $i++) {
    //$stk_id = 0;
    //$i = 0;
    $priceNew = 0;
    $Er = 1;
    $count = 0;
    $aveEr = 0;
    $STD = 0;
    $aveSTD = 0;
    $array = array();
    $beta = 0;
    
    $priceNewMkt = 0;
    $ErMkt = 1;
    $countMkt = 0;
    $aveErMkt = 0;
    $STDMkt = 0;
    $aveSTDMkt = 0;
    $arrayMkt = array();
    
    //$sql1 = "SELECT idx_id, Name, Symbol, adj_close FROM stk_raw_data_month WHERE stk_id = $i AND Date = '2016-09-01'";
    $sql1 = "SELECT idx_id, Name, Symbol, adj_close FROM stk_raw_data_month WHERE stk_id = $i ORDER BY Date DESC LIMIT 1";
    $result1 = $conn->query($sql1);
    if($result1->num_rows > 0){
	  while($row1 = $result1->fetch_assoc()){
	    $idx_id = $row1[idx_id];
	    $name = $row1[Name];
	    $symbol = $row1[Symbol];
	    $priceNew = $row1[adj_close];
	  }
    }
    if($idx_id == 3)  $idx_id = 0;
    
    $sql3 = "SELECT adj_close FROM idx_data_month WHERE idx_id = $idx_id ORDER BY Date DESC LIMIT 1";
    //$sql3 = "SELECT adj_close FROM idx_data_month WHERE idx_id = $idx_id AND Date = '2016-09-01'";
    $result3 = $conn->query($sql3);
    if($result3->num_rows > 0){
	  while($row3 = $result3->fetch_assoc()){
	    $priceNewMkt = $row3[adj_close];
	  }
    }
  
    $sql = "SELECT adj_close FROM stk_raw_data_month WHERE stk_id = $i ORDER BY Date DESC";  
    //$sql = "SELECT adj_close FROM stk_raw_data_month WHERE stk_id = $i AND Date <= '2016-09-01'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
	  while($row = $result->fetch_assoc()){
	    //$Er += ($priceNew - $row[adj_close])/$row[adj_close];
	    $Er *= (($priceNew - $row[adj_close])/$row[adj_close] + 1);
	    //$Er += log($priceNew/$row[adj_close]);
	    //$array[$count] = log($priceNew/$row[adj_close]);
	    $array[$count] = ($priceNew - $row[adj_close])/$row[adj_close];
	    $price += $row[adj_close];
	    $priceNew = $row[adj_close];
	    $count++;
	  }
    }
    
    $sql4 = "SELECT adj_close FROM idx_data_month WHERE idx_id = $idx_id ORDER BY Date DESC";
    //$sql4 = "SELECT adj_close FROM idx_data_month WHERE idx_id = $idx_id AND Date <= '2016-09-01'";
    $result4 = $conn->query($sql4);
    if($result4->num_rows > 0){
	  while($row4 = $result4->fetch_assoc()){
	    //$Er += ($priceNew - $row[adj_close])/$row[adj_close];
	    $ErMkt *= (($priceNewMkt - $row4[adj_close])/$row4[adj_close] + 1);
	    //$Er += log($priceNew/$row[adj_close]);
	    //$arrayMkt[$countMkt] = log($priceNewMkt/$row4[adj_close]);
	    $arrayMkt[$countMkt] = ($priceNewMkt - $row4[adj_close])/$row4[adj_close];
	    //$price += $row[adj_close];
	    $priceNewMkt = $row4[adj_close];
	    $countMkt++;
	  }
    }
    $count = $count - 1;
    $countMkt = $countMkt - 1;
    //$aveEr = $Er/$count;
    $aveEr = round(pow($Er, 1/$count) - 1, 6);
    $aveErMkt = round(pow($ErMkt, 1/$countMkt) - 1, 6);
    //$avePrice = $price/$count;
    if($count < $countMkt)  $temp = $count;
    else $temp = $countMkt;
    
    for($j = 1; $j < $temp + 1; $j++) {
      $STD += ($array[$j] - $aveEr)*($array[$j] - $aveEr);
      $STDMkt += ($arrayMkt[$j] - $aveErMkt)*($arrayMkt[$j] - $aveErMkt);
      $beta += ($array[$j] - $aveEr)*($arrayMkt[$j] - $aveErMkt);
    }
    $betaStk = round($beta/$STDMkt, 6);
    $aveSTD = round(pow($STD/$temp, 0.5), 6)*100;
    $aveEr = $aveEr*100;
    $sql2 = "INSERT INTO stk_cal (idx_id, stk_id, Name, Symbol, ER, STD, Beta) VALUES('$idx_id', '$i', '$name', '$symbol', '$aveEr', '$aveSTD', '$betaStk')";
    if ($conn->query($sql2) === TRUE) {
      //echo "New record created successfully";
      //echo $beta ."<br>";
      //echo $STDMkt ."<br>";
      //echo $betaStk ."<br>";
      //echo $test. "<br>";
      //for($w = 0; $w < $temp + 1; $temp++) {
      //echo $array[$w]. "<br>";
      //echo $arrayMkt[$w];}
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  
  /*
  echo $aveEr;
  //echo $Er;
  echo "nnnn";
  echo $aveSTD;
  session_start();
  $_SESSION['array'] = $array;
  header('Location: calCor.php');*/
  require "conn_close.php";
?>