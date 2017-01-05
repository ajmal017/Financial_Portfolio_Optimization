<?php
  require("conn.php");
?>
<?php  //calculate correaltion
  //session_start();
  //$std = $_SESSION['std'];
  //function calCor($stk_id1, $stk_id2, $std1, $std2, $avePrice1, $avePrice2) {
  //$std1 = 0.010326;//0
  $std1 = 0.013184;//1
  $std2 = 0.015249; //2

  //$avePrice1 = 0.0006598;  //0
  $avePrice2 = 0.000852;  //2
  $avePrice1 = -0.000076;  //1
  
  $stk_id1 = 1;
  $stk_id2 = 2;
  
  $array1 = array();
  $array2 = array();
  $count1 = 0;
  $count2 = 0;
  
  $cor = 0;
  $priceNew1 = 0;
  $priceNew2 = 0;
  $sql3 = "SELECT adj_close FROM stk_raw_data WHERE stk_id = $stk_id1 ORDER BY stk_hist_data_id LIMIT 1";
  $result3 = $conn->query($sql3);
  if($result3->num_rows > 0){
	while($row3 = $result3->fetch_assoc()){
	  $priceNew1 = $row3[adj_close];
	}
  }
  
  $sql1 = "SELECT adj_close FROM stk_raw_data WHERE stk_id = $stk_id1";
  $result1 = $conn->query($sql1);
  if($result1->num_rows > 0){
	while($row1 = $result1->fetch_assoc()){
	  $array1[$count1] = ($priceNew1 - $row1[adj_close])/$row1[adj_close];
	  $count1++;
	}
  }
  
  $sql4 = "SELECT adj_close FROM stk_raw_data WHERE stk_id = $stk_id2 ORDER BY stk_hist_data_id LIMIT 1";
  $result4 = $conn->query($sql4);
  if($result4->num_rows > 0){
	while($row4 = $result4->fetch_assoc()){
	  $priceNew2 = $row4[adj_close];
	}
  }
  
  $sql2 = "SELECT adj_close FROM stk_raw_data WHERE stk_id = $stk_id2";
  $result2 = $conn->query($sql2);
  if($result2->num_rows > 0){
	while($row2 = $result2->fetch_assoc()){
	  $array2[$count2] = ($priceNew2 - $row2[adj_close])/$row2[adj_close];
	  $count2++;
	}
  }
  
  $b = $count1 - $count2;
  if($b >= 0) {  //use second stock
    for($i = 1; $i < $count2; $i++) {
      $cor += ($array1[$i]- $avePrice1)*($array2[$i]- $avePrice2);
    }
    $cor = $cor/($count2 - 1);
  } else{  //use first stock
    for($i = 1; $i < $count1; $i++) {
      $cor += ($array1[$i]- $avePrice1)*($array2[$i]- $avePrice2);
    }
    $cor = $cor/($count1 - 1);
  }
  
  echo $cor;

  
//}
?>