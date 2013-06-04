<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");

require_once("config.php");

$user = $_GET["user"];
$pos = $_GET["pos"];
$room = $_GET["room"];

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db("pol",$link);

//echo "$database--------$link<br>";

$max_sql = "delete from pol_pos where user='$user'";
$query=mysql_query($max_sql);

$qstring = "insert into pol_pos set "
                   ."room='$room', "
                   ."user='$user', "
                   ."sid=0, "
                   ."pos='$pos'";

//echo $qstring;

$query=mysql_query($qstring);
?>