<?php
header("content-type:text/html; charset=utf-8");
session_start();
include_once( "Msg_Imp.php" );
$Msg_Imp_Info = new Msg_Imp();
$roomid = 1;
$sid = session_id();

$content = $_GET["content"];
$from = $_GET["from"];
$to = $_GET["to"];

//http://localhost/MG2.5/sendChatMsg.php?content=hellokitty&from=sfq&to=pol

$Msg_Imp_Info->input_chat_msg($roomid,$content,$sid,$from,$to);
?>
