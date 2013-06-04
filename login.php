<?php
header("content-type:text/html; charset=utf-8");

$err = $_GET["err"];
if($err == 1)
   $err = "<font color='red'>正しい情報を入力してください。</font>";
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>MYO Space</title>

<style>
.inputtext{
	width: 110px;
	height: 25px;
	font-size:16px;
}

.css3comm {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	width:100px;
	padding: 6px 6px;
	background-color:#d0d0d0

	border-radius: 12px;
	-moz-border-radius: 12px;
	-webkit-border-radius: 12px;
	border: 1px solid #7e8082;
}
</style>

<script language="javascript">
function ajustOrientation() {
   window.setTimeout(function() {window.top.scrollTo(0,1);} , 100);
}
</script>

<body onorientationchange="ajustOrientation();">
<center>

<table border=0 width="100%" style="font-size:8px">
<tr>
   <td width="33%">&nbsp;</td>
   <td width="33%" align="center"><img src="./res/pair_logo.png"></td>
   <td valign="top" align="right">MYOエンジンを搭載</td>
</tr>
</table>

<form name="loginfrm" action="main.php" method="post">

<table border=0 width="200px" class="css3comm">
<tr>
    <td COLSPAN=2>
        <a href="#" onclick="window.open('./register.php','_top')"><img src="./res/register_but.png"  width="195px" height="64px"></a>
    </td>
</tr>

<tr>
    <td COLSPAN=2>ID&nbsp;&nbsp;<?php echo $err?></td>
</tr>

<tr >
    <td width="30%">
       <table border=0 width="100%" style="font-size:10px">
          <tr><td><input class="inputtext" name="uname" type=text></td></tr>
          <tr><td>パスワード</td></tr>
          <tr><td><input class="inputtext" name="upass" type=password></td></tr>
       </table>

    </td>

    <td>
       <img src="./res/login_but.png" onclick=loginfrm.submit()>
    </td>
</tr>

</table>

</form>

</center>
</body>
</html>
