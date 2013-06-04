<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");

$uname = $_POST["uname"];
$upass = $_POST["upass"];
$gender = $_POST["gender"];
$unick = $_POST["unickescape"];

if($gender==1)
    $lookstr = "1||1||lLeg_L505:0:16:0:17||lArm||lLimb||body_A106:0:0:0:0||rLeg_L505:0:16:0:17||rArm||rLimb||head_M021:7:41:10:88_M025:15:48:0:0_M024:18:63:0:0_H026:0:0:0:0_A105:-15:-16:-15:-16_A108:2:40:-3:37";
else
    $lookstr = "1||2||lLeg_L202:0:16:0:18||lArm||lLimb||body_A201:-2:-1:0:0||rLeg_L202:0:16:0:18||rArm||rLimb||head_M205:7:41:10:88_M206:9:37:10:88_M207:17:48:0:0_M208:16:59:0:0_H204:-2:0:0:0";

//$roomstr = "1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,\"106\",1,1,1,1,1,1,1,1,1,1,1,1,1,\"106\",1,1,\"105_2\",1,1,1,1,1,1,\"105_0\",\"105_1\",1,1,1";
$roomstr = "1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,\"131\",1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,\"130\",\"129\",1,1,1,1,1,1,1,1,1,1,1,1,1,1";

$scestr = "sce2";

$itemstr = "106,105,81,82,83,84,85,86,87,85";

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

function checkUserExist($uname)  {
    $sql = "SELECT id FROM pol_user WHERE pol_user.username = '$uname'";
    $query=@mysql_query($sql);

    if(!$query) {
        echo "<font size='8'>DBエラー。<a href='./'>ここ</a>をクリックして戻ります。</font>";
        exit;
    }
    $result=mysql_fetch_array($query);

    if($result)
        return true;
    else
        return false;
}

function setUserInfo($uname,$upass,$unick,$lookstr,$roomstr,$scestr,$itemstr) {
    $datestr = date("Y-m-d");

    $sql = "
    INSERT INTO `pol`.`pol_user` (
    `username` ,
    `password` ,
    `dispName` ,
    `looks` ,
    `roomdata` ,
    `roomtype` ,
    `items` ,
    `createDate`
    )
    VALUES (
    '$uname', '$upass', '$unick', '$lookstr', '$roomstr' , '$scestr' , '$itemstr' , '$datestr'
    );
    ";

    $query=@mysql_query($sql);

    if(!$query) {
        echo "<font size='8'>DBエラー。<a href='./'>ここ</a>をクリックして戻ります。</font>";
        exit;
    }
    echo "<script language='javascript'>if(confirm('ご登録ありがとうございます。ログインしてください。')) {window.location.href='./'} </script>";
}


if(checkUserExist($uname)==true)  {
     echo "<font size='8'>このユーザーはもう存在しています。<a href='./'>ここ</a>をクリックして戻ります。</font>";
     exit;
}

setUserInfo($uname,$upass,$unick,$lookstr,$roomstr,$scestr,$itemstr);

?>