<?php
  require("conn.php");
?>
<?php
  //calculate expected return, STD
  for($i = 0; $i < 3; $i++) {
    //$stk_id = 0;
    $priceNew = 0;
    $Er = 1;
    $count = 0;
    $aveEr = 0;
    $STD = 0;
    $aveSTD = 0;
    //$price = 0;
    //$avePrice = 0;
    $array = array();
    $sql1 = "SELECT idx_id, Name, Symbol, adj_close FROM idx_data_month WHERE idx_id = $i ORDER BY idx_hist_data_id LIMIT 1";
    $result1 = $conn->query($sql1);
    if($result1->num_rows > 0){
	  while($row1 = $result1->fetch_assoc()){
	    $idx_id = $row1[idx_id];
	    $name = $row1[Name];
	    $symbol = $row1[Symbol];
	    $priceNew = $row1[adj_close];
	  }
    }
  
    $sql = "SELECT adj_close FROM idx_data_month WHERE idx_id = $i";
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
    $aveEr = round(pow($Er, 1/$count) - 1, 4);
    //$avePrice = $price/$count;
  
    for($j = 1; $j < $count + 1; $j++) {
      $STD += ($array[$j] - $aveEr)*($array[$j] - $aveEr);
    }
    $aveSTD = round(pow($STD, 0.5), 4);
    $sql2 = "INSERT INTO idx_cal (idx_id, Name, Symbol, ER, STD) VALUES('$idx_id', '$name', '$symbol', '$aveEr', '$aveSTD')";
    if ($conn->query($sql2) === TRUE) {
      //echo "New record created successfully";
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