<?php
header("content-type:text/html; charset=utf-8");
require_once("sceneTemplate.php");

$err = $_GET["err"];
if($err == 1)
   $err = "<font color='red'>正しい情報を入力してください。</font>";

$viewport_scale="0.4";
if(mobile_user_agent_switch()=="iphone") {
    $viewport_scale="0.4";
} else if(mobile_user_agent_switch()=="ipad") {
    $viewport_scale="1.0";
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="MYO,engine,html5,avatar,chat,isometric,2.5D,iphone,ios,android,web,websocket,graphic,エンジン,アバター,チャット">
<meta name="description" content="MYO engine is a developing tool for anyone who want to create a Avatar chat system in no time.  MYO engine（MYO エンジン）は、誰でも簡単にアバターチャットシステムを作成できる開発エンジンです。" />
<meta name="viewport" content="width=device-width,initial-scale=<?php echo $viewport_scale?>,minimum-scale=<?php echo $viewport_scale?>,maximum-scale=<?php echo $viewport_scale?>">
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
//document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
</script>

<body style="margin:0px;" onorientationchange="ajustOrientation();" onload="ajustOrientation();">
<table width="408" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th width="819" scope="col"><img src="./images/title1.png" width="800"></th>
  </tr>
  <tr>
    <td height="143" align="center" style="background:url(./images/title2.png) no-repeat">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td align="center" valign="middle"><a href="./"><img src="images/about_but2.png" width="120"></a></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="525" rowspan="6" valign="top">
        <table width="100%" border="0">
          <tr>
            <td>
                  <font face="Arial" size=4>
                  <p>MYO is a JavaScript-based framework specifically for isometric avatar chat system development,  using Node.js as server-side making it entirely a Javascript solution with both client and server side. It allow developers to produce their own stunning HTML5 avatar chat system for both desktop and mobile browsers. No programming skills is needed.  All need to do is to provide proper graphic materials and do the setting according to the specification.</p>
                  <p>What’s more, MYO is integrated with many useful development kit to make the job easier. Such as a world editor,a avatar action editor, a avator asset management system and a 2.5d image converter.  Which would help developers or end-clients to make their own scene and avatar in a flash.</p>
                  <p>MYO is an undergoing project. Every design work demonstrated in the Demo is copyrighted to their owners. If you are interesting in this project, you may reach us by <a href="mailto:nevin.ug206@gmail.com">nevin.ug206@gmail.com</a></p></td>
                  </font>
          </tr>
          <tr>
            <td><img src="images/about1.png" width="576" height="180"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><img src="images/about2.png" width="576" height="421"></td>
          </tr>
        </table></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" width="179">&nbsp;</td>
        <td align="right" width="115">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
         <form name="loginfrm" action="main.php" method="post">
        <td>&nbsp;</td>
        </form>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
