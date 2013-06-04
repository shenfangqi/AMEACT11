<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");

require_once("config.php");

$user = $_GET["user"];
$pos = $_GET["pos"];
$roomid = $_GET["room"];
$roomTab = "pol_pos_room".$roomid;

$spriteID="";
$spriteWidth="";
$spriteHeight="";

if(isset($_GET["sID"]) && isset($_GET["sWI"]) && isset($_GET["sHI"])) {
   $spriteID=$_GET["sID"];
   $spriteWidth=$_GET["sWI"];
   $spriteHeight=$_GET["sHI"];
}

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

function setUserRealTime($user,$roomid,$spriteID,$spriteWidth,$spriteHeight,$link) {
    $sql = "select id from pol_user_online where user='$user' and room='$roomid'";
    $query=@mysql_query($sql,$link);

    $result=@mysql_fetch_array($query);

    $savetime = time();
    if($result) {
        $sql = "update pol_user_online set savetime='$savetime' where user='$user' and room='$roomid'";
    } else {
        $sql = "insert into pol_user_online(room,user,spriteID,spriteWidth,spriteHeight,savetime) values ('$roomid','$user', '$spriteID', '$spriteWidth','$spriteHeight', '$savetime')";
    }

//echo $sql;

    @mysql_query($sql,$link) or die($sql);
}

function clearTimeoutUser($roomTab,$roomid) {
    $savetime = time();
    $sql = "delete from pol_user_online where $savetime-savetime>30";
    @mysql_query($sql);

    $sql1 = "delete from $roomTab where user not in (select user from pol_user_online where room='$roomid')";
    @mysql_query($sql1);
}

clearTimeoutUser($roomTab,$roomid);
setUserRealTime($user,$roomid,$spriteID,$spriteWidth,$spriteHeight,$link);


//echo "$database--------$link<br>";

$maxline = "select pos from $roomTab where user='$user' order by sid desc";

//echo "$maxline<br>";
$query=@mysql_query($maxline);

if($query) {
   $lastPos="";
   if($linresult=mysql_fetch_array($query)){
       $line_path = $linresult["pos"];
       $line_path_arr = explode(",",$line_path);
       $lastPos = $line_path_arr[count($line_path_arr)-1];
   }
}


$this_path_arr = explode(",",$pos);
$thisPos = $this_path_arr[0];


//为了保持路径的连续性，将上一次路径数组的最后一个值加入到本次路径数组的开头。如不这样，那么在显示其他用户的第一个位置的时候会出现跳跃
if($lastPos !="" && $lastPos != $thisPos)
    $pos = $lastPos .",". $pos;


$max_sql = "select max(sid)+1 as maxid from $roomTab where user='$user'";
$query=@mysql_query($max_sql);

if(!$query || !$result=mysql_fetch_array($query)){
   exit;
}

$maxid = $result["maxid"];
$savetime = time();
//echo "maxid:" . $maxid . "<br>";

$qstring = "insert into $roomTab set "
                   ."user='$user', "
                   ."sid='$maxid', "
                   ."pos='$pos',"
                   ."savetime='$savetime'";

//echo $qstring;

$query=@mysql_query($qstring);

?>