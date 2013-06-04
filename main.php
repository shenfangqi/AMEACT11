<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");
require_once("sceneTemplate.php");
session_start();
$uname = $_POST["uname"];
$upass = $_POST["upass"];

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

function unescape($source, $iconv_to = 'UTF-8') {
  $decodedStr = '';
  $pos = 0;
  $len = strlen ($source);
  while ($pos < $len) {
      $charAt = substr ($source, $pos, 1);
      if ($charAt == '%') {
          $pos++;
          $charAt = substr ($source, $pos, 1);
          if ($charAt == 'u') {
              // we got a unicode character
              $pos++;
              $unicodeHexVal = substr ($source, $pos, 4);
              $unicode = hexdec ($unicodeHexVal);
              $decodedStr .= code2utf($unicode);
              $pos += 4;
          }
          else {
              // we have an escaped ascii character
              $hexVal = substr ($source, $pos, 2);
              $decodedStr .= chr (hexdec ($hexVal));
              $pos += 2;
          }
      }
      else {
          $decodedStr .= $charAt;
          $pos++;
      }
  }

  if ($iconv_to != "UTF-8") {
      $decodedStr = iconv("UTF-8", $iconv_to, $decodedStr);
  }

  return $decodedStr;
}

function code2utf($num){
  if($num<128)return chr($num);
  if($num<2048)return chr(($num>>6)+192).chr(($num&63)+128);
  if($num<65536)return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
  if($num<2097152)return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128) .chr(($num&63)+128);
  return '';
}

function getUserInfo($uname,$upass) {
    $sql = "SELECT dispName,looks FROM pol_user WHERE pol_user.username = '$uname' and pol_user.password = '$upass'";

    $query=@mysql_query($sql);

    if(!$query)
        return false;

    $result=mysql_fetch_array($query);

    return array($result[0],$result[1]);
}

if(!isset($_SESSION["dispname"]))  {
    $uinfo = getUserInfo($uname,$upass);
    $inistr = $uinfo[1];
    $dispName = unescape($uinfo[0]);

    if(!$dispName)  {
       header("location:./?err=1");
    } else {
       $_SESSION["username"] =  $uname;
       $_SESSION["dispname"] =  $dispName;
       $_SESSION["inistr"] =  $inistr;
    }
} else {
    $dispName = $_SESSION["dispname"];
    $inistr = $_SESSION["inistr"];
    $uname = $_SESSION["username"];
}

$scrollheight_o0=388;
$scrollheight_o1=238;
if(mobile_user_agent_switch()=="ipad") {
    $scrollheight_o0=1024;
    $scrollheight_o1=700;
}


//echo "dp:" . unescape($dispName)  . "<br>";


//echo "<script language='javascript'>alert(escape('管理１'));</script>";
//echo "<script language='javascript'>alert(unescape('".$dispName."'));</script>";
//exit;



?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="MYO,engine,html5,avatar,chat,isometric,2.5D,iphone,ios,android,web,websocket,graphic,エンジン,アバター,チャット">
<meta name="description" content="MYO engine is a developing tool for anyone who want to create a Avatar chat system in no time.  MYO engine（MYO エンジン）は、誰でも簡単にアバターチャットシステムを作成できる開発エンジンです。" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title></title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>

<script src="./sfqdeploy/cha_min.js" type="text/javascript"></script>
<script src="./sfqdeploy/utility_min.js" type="text/javascript"></script>

<script type="text/javascript" src="./iscroll/iscroll.js"></script>

<script type="text/javascript">
var myScroll;
var hm;
function loaded() {
	myScroll = new iScroll('wrapper');
	ajustOrientation();
    hm = new human(orient,inistr);

    $("#s1").click(function() {
       //alert("s1");
      setPub();
    })

    $("#clothset").click(function() {
      setCloth();
      $("#scroller li").css("height","50px");
      $("#scroller li").css("line-height","50px");
    })

    $("#but1").click(function() {
      if($(this).text()=="保存")
         save();
      else
         window.open("./h6.php?room=<?php echo $uname?>&&usersele=1001&puser=<?php echo $uname?>","_top");
    })
}

function save() {
       $.ajax({type:"GET", url:"looksave.php?user=<?php echo $uname?>&lookstr="+inistr, dataType:"text",async:false,success:function (msg){
         		alert("保存しました。");
       }});
}

function ajustOrientation() {
   window.setTimeout(function() {window.top.scrollTo(0,1);} , 100);

   var orientation = window.orientation;
   if(orientation == 0)  {
        $("#wrapper").css("height","<?php echo $scrollheight_o0?>");
        //$("#footer").css("top","388px");
   }  else {
        $("#wrapper").css("height","<?php echo $scrollheight_o1?>");
        //$("#footer").css("top","238px");
   }

   if(orientation == null)  {
        $("#wrapper").css("height","488px");
        //$("#footer").css("top","488px");
   }

   //alert($("#scroller li").css("line-height"));
   //$("#scroller li").css("height","50px");
   //$("#scroller li").css("line-height","50px");
}


function vertAlign(pImg) {
   var lHeight = pImg.clientHeight;
   var lParentHeight = pImg.parentNode.clientHeight;
   pImg.style.marginTop = (lParentHeight - lHeight)/2 + "px";
}

function setHuman(val) {
   inistr = addItem(val);
   //alert(hm.orient);
   hm = new human(hm.orient,inistr);
}

function setPub() {
   myScroll.destroy();
   var contents = $("#pubData").html();
   $("#thelist").html(contents);
   myScroll = new iScroll('wrapper');
   $("#but1").text("お部屋へ");
}

function setCloth() {
   myScroll.destroy();
   var contents = $("#clothData").html();
   $("#thelist").html(contents);
   myScroll = new iScroll('wrapper');
   $("#but1").text("保存");
}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

/* * * * * * * *
 *
 * Use this for high compatibility (iDevice + Android)
 *
 */
document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
/*
 * * * * * * * */


/* * * * * * * *
 *
 * Use this for iDevice only
 *
 */
//document.addEventListener('DOMContentLoaded', loaded, false);
/*
 * * * * * * * */


/* * * * * * * *
 *
 * Use this if nothing else works
 *
 */
//window.addEventListener('load', setTimeout(function () { loaded(); }, 200), false);
/*
 * * * * * * * */

</script>

<style type="text/css" media="all">
body,ul,li {
	padding:0;
	margin:0;
	border:0;
}

body {
	font-size:12px;
	-webkit-user-select:none;
    -webkit-text-size-adjust:none;
	font-family:helvetica;
}

#header {
	position:absolute; z-index:2;
	top:0; left:0;
	width:100%;
	height:40px;
	line-height:20px;
	padding:0;
	color:#eee;
	font-size:12px;
	text-align:center;
    background-color:#d51876;
}

#header a {
	color:#f3f3f3;
	text-decoration:none;
	font-weight:bold;
	text-shadow:0 -1px 0 rgba(0,0,0,0.5);
}

#footer {
	position:absolute; z-index:2;
	bottom:0; left:0;
	width:100%;
    top:388px;
	height:30px;
	background-color:#fff;
	background-image:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0, #999), color-stop(0.02, #666), color-stop(1, #222));
	background-image:-moz-linear-gradient(top, #999, #666 2%, #222);
	background-image:-o-linear-gradient(top, #999, #666 2%, #222);
	padding:0;
	border-top:1px solid #444;
}

#footer li {
	display:block;
	float:left;
}

#footer li {
	width:25%;
	text-align:center;
}

#footer a {
	display:block;
	text-decoration:none;
	font-size:12px;
	color:#eee;
	line-height:24px;
	text-shadow:0 -1px 0 #000;
}

#footer span {
	display:block;
	font-size:30px;
	font-weight:bold;
}

#wrapper {
	position:relative; z-index:1;
	top:0px; bottom:30px; left:0;
	width:100%;
	height:388px;
	background:#aaa;
	overflow:auto;
}


#myFrame {
	position:absolute;
	top:0; left:0;
}

.css3comm {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
    font-weight: bold;
	color: #fff;
	width:90px;
	padding: 6px 6px;
	background: -moz-linear-gradient(
		top,
		#d51875 0%,
		#d51875);
	background: -webkit-gradient(
		linear, left top, left bottom,
		from(#d51875),
		to(#d51875));
	border-radius: 12px;
	-moz-border-radius: 12px;
	-webkit-border-radius: 12px;
	border: 1px solid #d51875;
}

.box {
    	 width: 46px;
	     height: 46px;
	     border: "2px solid #000";
	     line-height: 46px;
	     text-align: center;
	     margin: 1px;
	     display: block;
	     text-decoration: none;
	     overflow: hidden;
	     position: relative;
         BACKGROUND-COLOR:#FFF;

         -moz-border-radius: 15px;   /* firefox */
         border-radius: 15px;        /* CSS3 */
}

.left_menu {
    	 background:url(./images/item_bar_bg.png);
}

hr.style-six {
    border: 0;
    height: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}

</style>
</head>

<body onload="ajustOrientation();"  onorientationchange="ajustOrientation();">

<div id="header">
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
                 <tr>
                          <td align="left"><img src="./res/myo.png"></td>
                          <td align="right">&nbsp;</td>
                 </tr>
         </table>
</div>

<div id = "clothData1" style="display:none">
    <li id='101' type='cloth' pic='res/icons/coat.png' code='body:A101:0:3:-1:1||lArm:B101:3:0:4:-1||rArm:C101:-1:0:-2:0'>Item1</li>
    <li id='501' type='cloth' pic='res/icons/shoes.png' code='lLeg:L501:1:15:1:23||rLeg:L501:2:23:0:15'>Item2</li>
    <li id='006' type='face' pic='res/items/006/LD/H006.png' code='head:H006:0:-1:0:0'>Item3</li>
    <li id='007' type='face' pic=res/items/007/LD/H007.png' code='head:H007:-2:-1:0:0'>Item4</li>
    <li id='008' type='face' pic='res/items/008/LD/H008.png' code='head:H008:2:-16:0:0'>Item5</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>Item3</li><li pic='' code=''>Item3</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>Item3</li><li pic='' code=''>Item3</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>Item3</li><li pic='' code=''>Item3</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>Item3</li><li pic='' code=''>Item3</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>Item3</li><li pic='' code=''>Item3</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>Item3</li><li pic='' code=''>Item3</li>
    <li pic='' code=''>Item3</li><li pic='' code=''>ItemN</li>
</div>

<!--
1||2||lLeg_L504:-2:17:-1:23||lArm||lLimb||body_A103:-1:2:-1:2_A104:-10:16:-8:14||rLeg_L504:0:24:-1:14||rArm||rLimb||
head_M001:10:28:10:88_M011:12:34:0:0_M002:14:34:0:0:0_M005:22:32:0:0_M004:24:49:0:0_H010:0:-5:0:0

1||1||lLeg||lArm_B101:3:0:4:-1||lLimb||body_A101:0:3:-1:1||rLeg||rArm_C101:-1:0:-2:0||rLimb||
head_M001:10:22:10:88_M003:14:28:0:0_M002:14:28:0:0:0_M005:22:26:0:0_M004:24:43:0:0_H006:0:-1:0:0


1||1||lLeg_B107:6:0:6:1_L505:0:16:0:17||lArm||lLimb||body_A106:0:0:0:0||rLeg_B107:6:0:6:1_L505:0:16:0:17||rArm||rLimb||head_M021:7:41:10:88_M025:15:48:0:0_M024:18:63:0:0__A108:2:40:-3:37_H026:0:0:0:0_A105:-15:-16:-15:-16
-->

<div id = "clothData" style="display:none">
    <table style="background-color:#f0f0f0;font-size:14px" border=0 width="100%">
         <tr>
              <td><center><div class="box" onclick=setHuman("body:A101:0:3:-1:1||lArm:B101:3:0:4:-1||rArm:C101:-1:0:-2:0")><img src='res/icons/coat.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("lLeg:L501:1:15:1:23||rLeg:L501:2:23:0:15")><img src='res/icons/shoes.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("head:H006:0:-1:0:0")><img src='res/items/006/LD/H006.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
         </tr>
         <tr>
              <td><center><div class="box" onclick=setHuman("head:H007:-2:-1:0:0")><img src='res/items/007/LD/H007.png'' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("head:H008:2:-16:0:0")><img src='res/items/008/LD/H008.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("body:A103:-1:2:-1:2")><img src='res/items/103/LD/A103.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
         </tr>
         <tr>
              <td><center><div class="box" onclick=setHuman("body:A104:-10:16:-8:14")><img src='res/items/104/LD/A104.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("lLeg:L504:-2:17:-1:23||rLeg:L504:0:24:-1:14")><img src='res/items/504/LD/L504.png' width='16px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("head:H010:0:-5:0:0")><img src='res/items/010/LD/H010.png'' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
         </tr>
         <tr>
              <td><center><div class="box" onclick=setHuman("head:A108:2:40:-3:37")><img src='res/items/108/LD/A108.png'' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("head:H026:0:0:0:0")><img src='res/items/026/LD/H026.png'' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("head:A105:-15:-16:-15:-16")><img src='res/items/105/LD/A105.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
         </tr>
         <tr>
              <td><center><div class="box" onclick=setHuman("lLeg:B107:6:0:6:1||rLeg:B107:6:0:6:1")><img src='res/items/107/LD/B107.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("lLeg:L505:0:16:0:17||rLeg:L505:0:16:0:17")><img src='res/items/505/LD/L505.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
              <td><center><div class="box" onclick=setHuman("body:A106:0:0:0:0")><img src='res/items/106/LD/A106.png' width='32px' onload='vertAlign(this)'></div></center><hr class="style-six"/></td>
         </tr>
         <tr>
              <td><center><div class="box">&nbsp;&nbsp;</div></center><hr class="style-six"/></td>
              <td><center><div class="box">&nbsp;&nbsp;</div></center><hr class="style-six"/></td>
              <td><center><div class="box">&nbsp;&nbsp;</div></center><hr class="style-six"/></td>
         </tr>
         <tr>
              <td><center><div class="box">&nbsp;&nbsp;</div></center><hr class="style-six"/></td>
              <td><center><div class="box">&nbsp;&nbsp;</div></center><hr class="style-six"/></td>
              <td><center><div class="box">&nbsp;&nbsp;</div></center><hr class="style-six"/></td>
         </tr>
    </table>
</div>


<div id = "pubData" style="display:none">
    <table style="background-color:#f0f0f0;	font-size:14px" border=0 width="100%">
   	      <tr>
	          <td height="100px"><center><img src="./res/pub1.png"><br><a href="./h6.php?room=pub1&&usersele=1001&puser=<?php echo $uname?>">釣り堀</a></center><hr class="style-six"/></td>
	      </tr>
	      <tr>
	          <td height="110px"><center><img src="./res/pub2.png"><br>中華料理</center><hr class="style-six"/></td>
	      </tr>
	      <tr>
	          <td height="110px"><center><img src="./res/pub3.png"><br>商店街</center><hr class="style-six"/></td>
	      </tr>
	      <tr>
	          <td height="110px"><center><img src="./res/pub4.png"><br>渋谷公園</center><hr class="style-six"/></td>
	      </tr>
	</table>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="position:absolute;left:0px;top:40px">
<tr>
   <td width="100px" valign="top" style=" background:url(./images/item_bar_bg.png);">
      <table border="0" width="100%  cellspacing="0">
          <tr>
          <td>
              <div id="avatar">
                  <p  style="zoom:0.8;z-index:1">
                      <canvas id="canvas" width="100px" height="136px"></canvas>
                  </p>
              </div>
          </td>
          </tr>
          <tr>
              <td align="center">
                 <button type="button" id="but1" class="css3comm">お部屋へ</button>
              </td>
          </tr>
          <tr>
              <td align="center">
                   <img src="./images/setting.png"><a href="#" onclick=window.open("./MapEdit-c6.php?room=<?php echo $uname?>&puser=<?php echo $uname?>","_top")><font style="color:#fff">もようかえ</font></a>
              </td>
          </tr>
          <tr>
              <td align="center">
                   <img src="./images/logout.png" width="19px" height="18px"><a href="./"><font style="color:#fff">ログアウト</font></a>
              </td>
          </tr>

      </table>
   </td>

   <td>
   <div id="wrapper">
   	   <div id="scroller">
	 	   <ul id="thelist">
			   <table style="background-color:#f0f0f0;	font-size:14px" border=0 width="100%" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                       <td  valign="top" align="center">
                             &nbsp;
                       </td>
                  </tr>

                  <? if(!$isIPhone) { ?>
          	         <tr><td height="100px"><center><img src="./res/pub1b.png"><br><a href="./h6.php?room=pub2&&usersele=1001&puser=<?php echo $uname?>">Viking World</a></center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub3b.png"><br><a href="./h6.php?room=pub3&&usersele=1001&puser=<?php echo $uname?>">Desert Land</a></center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2b.png"><br>Apple Tree</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2b.png"><br>Deeply Sea</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2b.png"><br>Deeply Sea</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2b.png"><br>Deeply Sea</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2b.png"><br>Deeply Sea</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2b.png"><br>Deeply Sea</center><hr class="style-six"/></td></tr>
                  <? } else {?>
          	         <tr><td height="100px"><center><img src="./res/pub1s.png"><br><a href="./h6.php?room=pub2&&usersele=1001&puser=<?php echo $uname?>">Viking World</a></center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub3s.png"><br><a href="./h6.php?room=pub3&&usersele=1001&puser=<?php echo $uname?>">Desert Land</a></center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2s.png"><br>Apple Tree</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2s.png"><br>Deeply Sea</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2s.png"><br>Apple Tree</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2s.png"><br>Apple Tree</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2s.png"><br>Apple Tree</center><hr class="style-six"/></td></tr>
			         <tr><td height="110px"><center><img src="./res/pub2s.png"><br>Apple Tree</center><hr class="style-six"/></td></tr>
                  <? } ?>


			   </table>
		   </ul>
	   </div>
   </div>
   </td>

</tr>
</table>

<!--
<div id="footer">
    <ul>
       <li><a  id="s1"><span><img src="./res/icons/home.png"></span></li>
       <li><a  id="s2"><span><img src="./res/icons/contacts.png"></span></li>
       <li><a  id="s3"><span><img src="./res/icons/portfolio.png"></span></li>
       <li><a  id="s4"><span><img src="./res/icons/cart.png"></span></span></li>
    </ul>
</div>
-->

</body>

<script language="javascript">

var ctx = document.getElementById('canvas').getContext('2d');
var isTest = 2;
//var inistr = "1||1||lLeg||lArm_B101:3:0:4:-1||lLimb||body_A101:0:3:-1:1||rLeg||rArm_C101:-1:0:-2:0||rLimb||head_H006:0:-1:0:0_M001:10:22:10:88_M003:14:28:0:0_M002:14:28:0:0:0_M005:22:26:0:0_M004:24:43:0:0";  //accesory should define the offset to the attached body part
var inistr = "<?php echo $inistr?>";

var anistr = "&&35;102;-40;ld_37;83;20;ld_28;84;30;ld_40;77;0;ld_46;100;20;ld_56;80;-20;ld_60;83;-20;ld_20;20;0;ld&&35;102;20;ld_37;79;0;ld_28;84;10;ld_40;77;0;ld_46;98;-20;ld_54;76;10;ld_58;85;10;ld_20;20;0;ld&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;20;0;ld";
var orient = "ld";

</script>

</html>