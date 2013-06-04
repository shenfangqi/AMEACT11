<?php
header("content-type:text/html; charset=utf-8");
$err = $_GET["err"];
if($err == 1)
   $err = "<font color='red'>このユーザーが存在しています。</font>";
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
	font-size: 12px;
	width:300px;
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

function setNick() {
   var p1 = document.getElementById("uname").value;
   var p2 = document.getElementById("unick").value;
   var p3 = document.getElementById("upass").value;
   var p4 = document.getElementById("reupass").value;
   var p5 = document.getElementById("gender").checked;

   var errinfo="";
   if(p1=="")
        errinfo = "<font color='red'>ユーザー名を入力してください。</font>";
   else if(p2=="")
        errinfo = "<font color='red'>表示名を入力してください。</font>";
   else if(p3=="")
        errinfo = "<font color='red'>パスワード名を入力してください。</font>";
   else if(p4=="")
        errinfo = "<font color='red'>パスワードを入力してください。</font>";
   else if(p3 != p4)  {
        errinfo = "<font color='red'>同じパスワードを入力してください。</font>";
   }

   if(errinfo !="")  {
        document.getElementById("errinfo").innerHTML=errinfo;
   } else {
        document.getElementById("unickescape").value = escape(p2);
        document.getElementById("thisform").submit();
   }
}
</script>

<body onorientationchange="ajustOrientation();">
<center>

<table border=0 width="100%" style="font-size:8px">
<tr>
   <td width="50%"><div id="errinfo"><?php echo $err?></div></td>
   <td valign="top" align="right">MYOエンジンを搭載</td>
</tr>
</table>


<form id="thisform" action="registerDB.php" method="post">

<table border=0 class="css3comm">
     <tr>
         <td width="8%"></td>
         <td width="30%" align="right"><input id="gender" name="gender" type="radio" value="2"><img src="./res/gender_girl.png"></td>
         <td width="30%"><img src="./res/gender_boy.png"><input id="gender" name="gender" type="radio" value="1" checked></td>
         <td align="right"><img src="./res/touroku_but.png" onclick="setNick()"></td>
     </tr>
     <tr>
         <td colspan=2 align="right">ユーザID</td>
         <td colspan=2><input class="inputtext" id="uname" name="uname" type=text maxlength=8></td>
     </tr>
     <tr>
         <td colspan=2 align="right">表示名</td>
         <td colspan=2><input class="inputtext" id="unick" name="unick" type=text maxlength=6><input id="unickescape" name="unickescape" type=hidden></td>
     </tr>
     <tr>
         <td colspan=2 align="right">パスワード</td>
         <td colspan=2><input class="inputtext" id="upass" name="upass" type=password></td>
     </tr>
     <tr>
         <td colspan=2 align="right">パスワード(確認用)</td>
         <td colspan=2><input class="inputtext" id="reupass" name="reupass" type=password></td>
     </tr>
</table>

</center>

</form>

</body>

</html>

