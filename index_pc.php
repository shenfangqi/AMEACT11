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
</script>

<body style="margin:0px;" onorientationchange="ajustOrientation();">
<table width="408" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="col"><img src="./images/title1.png" width="819" height="154"></th>
  </tr>
  <tr>
    <td align="center" height="143" style="background:url(./images/title2.png) no-repeat">
    <table width="486" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" width="146">&nbsp;</td>
        <td width="284">&nbsp;</td>
        <td align="right" width="70">&nbsp;</td>
      </tr>
      <tr>
        <td><a href="./registerDB1.php" target="_top"><img src="./images/register.png" width="146" height="50"></a></td>
         <form name="loginfrm" action="main.php" method="post">
        <td>

        <table width="100%" border="0" cellpadding="0" cellspacing="2">
          <tr>
            <td width="30%" height="30" align="right"><img src="./images/id.png" width="19" height="12"></td>
            <td style="background:url(./images/kk.png) no-repeat" width="70%" align="left" ><input type="text" name="uname" style="z-index:1;position:relative;left:3px;width:180px;border:0"></td>
          </tr>
          <tr>
            <td height="30" align="right"><img src="./images/password.png" width="73" height="13"></td>
            <td style="background:url(./images/kk.png) no-repeat"><input type="password" name="upass" style="z-index:1;position:relative;left:3px;width:180px;;border:0"></td>
          </tr>
        </table></td>
        <td><img src="./images/login.png" width="70" height="50" onclick=loginfrm.submit()></td>
        </form>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><img src="./images/welcome.png" width="500" ></td>
        </tr>
      <tr>
        <td colspan="3" align="right"><a href="./about.php" target="_top" ><img src="./images/about.png"></a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
