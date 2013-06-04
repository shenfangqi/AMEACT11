<?php
require_once("config.php");

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

function setLook($user,$lookstr) {
   $sql = "update pol_user set looks='$lookstr' WHERE username='$user'";
   @mysql_query($sql);
}

$user =  $_GET["user"];
$lookstr = $_GET["lookstr"];

setLook($user,$lookstr);
?>