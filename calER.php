<?php
  require("conn.php");
?>
<?php
  //calculate expected return
  
  $stk_id = 0;
  $priceNew = 0;
  $Er = 1;
  $count = 0;
  $aveEr = 0;
  $STD = 0;
  $aveSTD = 0;
  //$price = 0;
  //$avePrice = 0;
  $array = array();
  $sql1 = "SELECT adj_close FROM stk_raw_data_month WHERE stk_id = $stk_id ORDER BY stk_hist_data_id LIMIT 1";
  $result1 = $conn->query($sql1);
  if($result1->num_rows > 0){
	while($row1 = $result1->fetch_assoc()){
	  $priceNew = $row1[adj_close];
	}
  }
  
  $sql = "SELECT adj_close FROM stk_raw_data_month WHERE stk_id = $stk_id";
  $result = $conn->query($sql);
  if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
	  //$Er += ($priceNew - $row[adj_close])/$row[adj_close];
	  $Er *= (($priceNew - $row[adj_close])/$row[adj_close] + 1);
	  //$Er += log($priceNew/$row[adj_close]);
	  $array[$count] = log($priceNew/$row[adj_close]);
	  //$price += $row[adj_close];
	  $priceNew = $row[adj_close];
	  $count++;
	}
  }
  $count = $count - 1;
  //$aveEr = $Er/$count;
  $aveEr = pow($Er, 1/$count) - 1;
  //$avePrice = $price/$count;
  
  for($i = 1; $i < $count + 1; $i++) {
    $STD += ($array[$i] - $aveEr)*($array[$i] - $aveEr);
  }
  $aveSTD = pow($STD, 0.5);
  
  echo $aveEr;
  //echo $Er;
  echo "nnnn";
  echo $aveSTD;
  session_start();
  $_SESSION['array'] = $array;
  header('Location: calCor.php');
  require "conn_close.php";
?>