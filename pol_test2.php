<?php
header("content-type:text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

require_once("config.php");

$user = $_GET["user"];
$user_sid_hash = $_GET["sidhash"];
$user_cid_hash = $_GET["cidhash"];

$roomid = $_GET["room"];
$roomTab = "pol_pos_room".$roomid;

$spriteID=$_GET["sID"];
$spriteWidth=$_GET["sWI"];
$spriteHeight=$_GET["sHI"];

$con_arr = array();
$chat_arr = array();

if($user_sid_hash<>"")
   $con_arr = explode("||",$user_sid_hash);

if($user_cid_hash<>"")
   $chat_arr = explode("||",$user_cid_hash);

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);


if(!checkValidReq($roomTab,$roomid,$user,$link)) {
    echo "NG";
    exit;
}

function checkValidReq($roomTab,$roomid,$user,$link) {
    if($user=="PlsVoteOnMe" || $user=="sfq" || $user=="nevin") {
       return true;
    }
    $sql1 = "select max(SaveTime) as st1 from pol_chatmsg where Fr='$user' and RoomID='$roomid'";
    $query1=@mysql_query($sql1,$link);
    $result1=@mysql_fetch_array($query1);
    if(!$result1 || !$result1["st1"])
         $talk_time=0;
    else
         $talk_time=$result1["st1"];

    $sql2 = "select max(SaveTime) as st2 from $roomTab where user='$user'";
    $query2=@mysql_query($sql2,$link);
    $result2=@mysql_fetch_array($query2);

    if(!$result2 || !$result2["st2"])
        return false;

    $walk_time=$result2["st2"];

    $savetime = time();

//echo "$savetime-$walk_time=".($savetime-$walk_time)."<br>";
//echo "$savetime-$talk_time=".($savetime-$talk_time)."<br>";

    if($savetime-$walk_time<300)
        return true;
    else if($savetime-$talk_time<300)
        return true;

    return false;
}


function setUserRealTime($user,$roomid,$spriteID,$spriteWidth,$spriteHeight,$link) {
    $sql = "select id from pol_user_online where user='$user' and room='$roomid'";
    $query=@mysql_query($sql,$link);

    $result=@mysql_fetch_array($query);

    $savetime = time();
    if($result) {
        $sql = "update pol_user_online set room='$roomid',spriteID='$spriteID',spriteWidth='$spriteWidth',spriteHeight='$spriteHeight',savetime='$savetime' where user='$user' and room='$roomid'";
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

function getOnlineUsers($roomid) {
    $sql = "select user from pol_user_online where room='$roomid'";
    $query=@mysql_query($sql);

    $ret_str = "";
    while ($result=@mysql_fetch_array($query))  {
        $ret_str = $ret_str . $result["user"] . "||";
    }

    $ret_str = substr($ret_str,0,-2);
    //echo $ret_str;
    return $ret_str;
}


function exectuteSql($sqlstr) {
    mysql_query("Set Names 'gb2312'");
	$result = @mysql_query($sqlstr);
    if($result)
       $totalMsg = mysql_num_rows($result);
    else
       return false;
    if($totalMsg<=0)
         return false;
    else
         return $result;
}


function getNearestChat($username) {
    $savetime = time();

    $sql = "select MsgID,Content from pol_chatmsg where Fr='$username' and ($savetime-SaveTime) < 30 order by MsgID";
//echo $sql . "<br>";
    $result=exectuteSql($sql);
    if(!$result)
       return "";
    $this_str = "$username:";
    $content_str = "";
    while ($row=@mysql_fetch_array($result))  {
       $mid = $row["MsgID"];
       $content_str = $content_str . $row["Content"] . "\n";
    }
    return $this_str . $content_str . ":" . $mid;
}

function getChatFromID($username,$cid) {
    $sql = "select MsgID,Content from pol_chatmsg where Fr='$username' and MsgID>$cid order by MsgID";
//echo $sql . "<br>";
    $result=exectuteSql($sql);
    if(!$result)
       return "";
    $this_str = "$username:";
    $content_str = "";
    while ($row=@mysql_fetch_array($result))  {
       $mid = $row["MsgID"];
       $content_str = $content_str . $row["Content"] . "\n";
    }
    return $this_str . $content_str . ":" . $mid;
}


function getChatStr($username,$cid) {
    $chat_ret="";
    if($cid == -1)
        $chat_ret = getNearestChat($username);
    else
        $chat_ret = getChatFromID($username,$cid);

//echo "chat:$chat_ret";
    return $chat_ret;
}

function getSpriteIDByUser($username){
    $sql = "select spriteID from pol_user_online where user='$username'";
    $result=exectuteSql($sql);
    if(!$result)
       return -1;

    $row=@mysql_fetch_array($result);
    return $row["spriteID"];
}

function getSpriteSizeByUser($username){
    $sql = "select spriteHeight,spriteWidth from pol_user_online where user='$username'";
    $result=exectuteSql($sql);
    if(!$result)
       return -1;

    $row=@mysql_fetch_array($result);
    return $row["spriteHeight"] . ":" . $row["spriteWidth"];
}


setUserRealTime($user,$roomid,$spriteID,$spriteWidth,$spriteHeight,$link);
$online_user = getOnlineUsers($roomid);
//clearTimeoutUser($roomTab,$roomid);

//echo "online:" . $online_user ."<br>";

$chat_str = "";

while($chat_arr)   {
     $rec = array_shift($chat_arr);
     if($rec) {
        $rec_arr = explode(":",$rec);
        $username=$rec_arr[0];
        $cid=$rec_arr[1];
        $userChatStr = getChatStr($username,$cid);
        if($userChatStr)
           $chat_str = $chat_str . $userChatStr . "||";
     }
}

$chat_str = substr($chat_str,0,-2);

//echo "ccc:" . $chat_str;
//exit;

$ret_str = "";

     $userstr ="";
     $constr = "";

     while($con_arr)   {
         $rec = array_shift($con_arr);
         $rec_arr = explode(":",$rec);



         $constr .= "user='" . $rec_arr[0] . "' and sid =" . ($rec_arr[1]+1) . " or  ";
         $userstr =  $userstr . "'" . $rec_arr[0] . "',";
     }
     $userstr = $userstr . "'$user'";

     $constr = substr($constr,0,-4);


     //将客户端传来的用户的当前位置id加1，然后取得路经，这样可以保证用户走的路经的连续性
     $sql1 = "select  *  from $roomTab where " . $constr;

//echo $sql1 . "<br>";

     $query1=@mysql_query($sql1);

     while ($result=@mysql_fetch_array($query1))  {
         $ret_str .= $result["user"] .":". $result["sid"] .":". $result["pos"] . ":" . getSpriteIDByUser($result["user"]) . ":" . getSpriteSizeByUser($result["user"]) ."||";
     }


//echo "ret:" . $userstr . "<br>";

     //如果不是从客户端传来的用户，说明是新用户，则取该用户的最大的位置id的路经值的最后一个pos
     $c_time = time();
     $ret_str1 = "";
     $sql2 = "select  *  from  $roomTab a inner join (select user,max(sid) as sid from $roomTab group by user) b on a.user=b.user  and  a.sid=b.sid and a.user not in ($userstr)";

//echo $sql2 . "<br>";

     $query2=@mysql_query($sql2);

     while ($result=@mysql_fetch_array($query2))  {
         $lpos=explode(",",$result["pos"]);
         $l = $lpos[count($lpos)-1];
         //由于写db太快，可能其它用户的数据没取全，则忽略
         if(getSpriteIDByUser($result["user"])==-1)
            continue;
         $ret_str1 .= $result["user"] .":". $result["sid"] .":". $l . ":" . getSpriteIDByUser($result["user"]) . ":" . getSpriteSizeByUser($result["user"]) . "||";
     }

     $ret_str = $ret_str . $ret_str1;
//}

$ret_str = substr($ret_str,0,-2);

//$chat_str="pol:hello,sfq:33||sfq:hi,polllll:2";
//$chat_str="pol:hello,sfq:33";
//$chat_str="sfq:hi,polllll:5";
//$chat_str="";

echo $online_user ."__". $ret_str . "__" . $chat_str;

?>