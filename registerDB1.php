<?php
header("content-type:text/html; charset=utf-8");

$err = $_GET["err"];
if($err == 1)
   $err = "<font color='red'>正しい情報を入力してください。</font>";
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="MYO,engine,html5,avatar,chat,isometric,2.5D,iphone,ios,android,web,websocket,graphic,エンジン,アバター,チャット">
<meta name="description" content="MYO engine is a developing tool for anyone who want to create a Avatar chat system in no time.  MYO engine（MYO エンジン）は、誰でも簡単にアバターチャットシステムを作成できる開発エンジンです。" />
<meta name="viewport" content="width=device-width, initial-scale=0.4, user-scalable=0.4, minimum-scale=0.4, maximum-scale=0.4">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>Myo</title>

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

function setNick() {
   var p1 = document.getElementById("uname").value;
   var p2 = document.getElementById("unick").value;
   var p3 = document.getElementById("upass").value;
   var p4 = document.getElementById("reupass").value;
   var p5 = document.getElementById("gender").checked;

   var errinfo="";
   if(p1=="")
        errinfo = "<font face='Arial' size=5 color='red'>Please input user id.</font>";
   else if(p2=="")
        errinfo = "<font face='Arial' size=5 color='red'>Please input user name.</font>";
   else if(p3=="")
        errinfo = "<font face='Arial' size=5 color='red'>Please input password.</font>";
   else if(p4=="")
        errinfo = "<font face='Arial' size=5 color='red'>Please input password for confirm.</font>";
   else if(p3 != p4)  {
        errinfo = "<font face='Arial' size=5 color='red'>Please input the same password.</font>";
   }

   if(errinfo !="")  {
        document.getElementById("errinfo").innerHTML=errinfo;
   } else {
        document.getElementById("unickescape").value = escape(p2);
        document.getElementById("thisform").submit();
   }
}
</script>

<body style="margin:0px;" onorientationchange="ajustOrientation();" onload="ajustOrientation();">
<table width="408" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col"><a href="./" target="_top"><img src="./images/title1.png" width="819" height="154"></a></th>
  </tr>
  <tr>
    <td align="center" height="143" style="background:url(./images/title2.png) no-repeat">
    <br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10%"><div style="position:relative;left:60px;top:8px";><img src="images/sign_left.png"></div></td>
        <td width="80%">

<form id="thisform" action="registerDB.php" method="post">

<table border=0 width="100%" style="font-size:8px">
<tr>
   <td width="50%"><div id="errinfo"><?php echo $err?></div></td>
</tr>
</table>

 <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="65%"  height="20" colspan="2" align="center" bgcolor="#D51875"><h1><font face="Arial" size="100px" color="#FFFFFF">Welcome!</font></h1></td>
        </tr>
      <tr>
        <td height="2" colspan="2" align="left" style="height:8px;background:url(./images/dot.png) repeat"></td>
        </tr>
      <tr>
        <td height="40" align="right" bgcolor="#D51875"><font face="Arial" size=5 color="#FFFFFF">Boy:<input type=radio id="gender" name="gender" value="1" checked style="width:40px;height:40px"></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td align="left" bgcolor="#D51875"><font face="Arial" size=5 color="#FFFFFF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Girl:<input type=radio id="gender" name="gender" value="2"  style="width:20px;height:20px"></font></td>
      </tr>
      <tr>
        <td height="40" align="right" bgcolor="#D51875"><font face="Arial" size=5 color="#FFFFFF">User ID:&nbsp;</font></td>
        <td align="left" bgcolor="#D51875"><input id="uname" name="uname" maxlength=8 type="text" style="width:170px;height:30px;font-size: 20px;"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#D51875"  height="40"><font face="Arial" size=5 color="#FFFFFF">Display Name:&nbsp;</font></td>
        <td align="left" bgcolor="#D51875"><input id="unick" name="unick" type=text maxlength=6  style="width:170px;height:30px;font-size: 20px;"><input id="unickescape" name="unickescape" type=hidden></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#D51875"  height="40"><font face="Arial" size=5 color="#FFFFFF">Password:&nbsp;</font></td>
        <td align="left" bgcolor="#D51875"><input id="upass" name="upass" type=password style="width:170px;height:30px;font-size: 20px;"></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#D51875"  height="40"><font face="Arial" size=5 color="#FFFFFF">Password (Confirm):&nbsp;</font></td>
        <td align="left" bgcolor="#D51875"><input  id="reupass" name="reupass" type=password style="width:170px;height:30px;font-size: 20px;"></td>
      </tr>
    </table>
</form>

        </td>
        <td width="10%"><div style="position:relative;left:-60px;top:-8px";><img src="images/sign_right.png"></div></td>
      </tr>
    </table>
    <br>
    <br>
    </td>
  </tr>

  <tr>
    <td align="center"><img src="images/rr.png" onclick="setNick()"></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
