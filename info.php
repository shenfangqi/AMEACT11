<?php
require_once("config.php");

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

function setRoomMap($roomID,$mapStr) {
   $sql = "update pol_user set roomdata='$mapStr' WHERE username='$roomID'";
   //echo $sql . "<br>";;
   @mysql_query($sql);
}


$info =  $_GET["info"];
$roomID = $_GET["roomID"];
$adcode = $_GET["adcode"];

if(trim($adcode) != $ad_config) {
    echo "You are not authorized to make alteration to this room unless you input the correct admin code.";
    exit;
}

$arr=explode(",",$info);

$ret = "";


//echo "count:".count($arr) . "<br>";

for($i=0;$i<count($arr);$i++) {
  $r=$arr[$i];

  if($r==1 || $r==2)
      $ret.=$r . ",";
  else
      $ret.='"' . $r . '",';
}

//echo "strlen:" . strlen($ret);

$ret = substr($ret,0,-1);

setRoomMap($roomID,$ret);

echo "Congratulation!! Your design made to this room have been saved, It will take effect after your next login.";

/*
$ret_arr = explode(",",$ret);

while($ret_arr) {
  $r=array_shift($ret_arr);
  $cnt++;
  if($cnt>31) {
     echo $r . ",<br>";
     $cnt=0;
  } else
     echo $r .",";
}
*/


?>