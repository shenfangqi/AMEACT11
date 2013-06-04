<?php
header("content-type:text/html; charset=utf-8");
session_start();

?>


<?php
$roomid = $_GET["room"];
$roomTab = "pol_pos_room".$roomid;
$puser = $_GET["puser"];
$ppass = $_GET["ppass"];
$usersele = $_GET["usersele"];

require_once("config.php");
require_once("map_info.php");

$mp = new map_info($roomid);

$this_scene =  $mp->getRoomSce();
require_once("sceneTemplate.php");


$uinfo = $mp->getUserInfo($puser);
$mp->setMapSize($canvasSize);


$this_nick = $uinfo[0];
$this_looks = $uinfo[1];


$viewport_scale="0.5";
$device = mobile_user_agent_switch();
if($device=="iphone") {
    $viewport_scale="0.5";
} else if($device=="ipad") {
    $viewport_scale="1.0";
}

//$canvasBg = "ss3.jpg";
//$canvasBg = "bg_room".$roomid . ".png";


//echo $puser .":". $room .":". $usersele . "<br>";

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);


if( !isValidUrl('http://180.37.144.138:3000')){
	echo "server error.Please click <a href='./index.html' target='_top'>here</a> to return";
    exit;
} else {
    //echo "<img id='layLoading' src='loading1.gif' style='z-index:1;left:480px;top:150px;position: absolute;'>";
}


function isValidUrl($url)
{
	$array = @get_headers($url,1);
	if(preg_match('/200/',$array[0])){
		return true;
	}else{
		return false;
	}
}

function getDefaultPos($user,$table) {
    $pos = "460";
    $sql = "select pos from $table where user='$user' and sid =(select max(sid) from $table where user= '$user')";

    $query=@mysql_query($sql);

    if(!$query)
        return $pos;

    $result=mysql_fetch_array($query);

    if($result)  {
            $arr = split(",",$result[0]);
            $pos = $arr[count($arr)-1];
    }
    return $pos;
}


/*
function getSpriteInfo($user,&$spriteID,&$roomID,&$spriteHeight) {
    $sql = "SELECT spriteID,height,defaultRoom FROM pol_user LEFT JOIN pol_sprite ON pol_user.spriteID = pol_sprite.id WHERE pol_user.username = '$user'";
    $query=@mysql_query($sql);

    if(!$query)
        exit;
    $result=mysql_fetch_array($query);

    if(!$result)  {
        exit;

    }
    $spriteID = $result[0];
    $spriteHeight = $result[1];
    $roomID = $result[2];
}
*/


function getSpriteInfo($spriteID,&$spriteWidth,&$spriteHeight) {
    $sql = "SELECT width,height FROM pol_sprite WHERE id = '$spriteID'";

    $query=@mysql_query($sql);

    if(!$query)
        exit;
    $result=mysql_fetch_array($query);

    if(!$result)  {
        exit;

    }
    $spriteWidth = $result["width"];
    $spriteHeight = $result["height"];
}

function checkExist($user,$roomid) {
    $savetime = time();
    $sql = "delete from pol_user_online where $savetime-savetime>30 and room='$roomid'";
    $query=@mysql_query($sql);

    $sql1 = "SELECT id FROM pol_user_online WHERE user = '$user' and room='$roomid'";
    $query1=@mysql_query($sql1);

    $result=mysql_fetch_array($query1);


    if($result) {
        echo "<script language='javascript'>$('#layLoading').css('display','none')</script>";
        echo "<div style='position:absolute;left:20;top:200'>This user has logined within 30 seconds, You should login with another username or wait 30 seconds until it get expire.</div>";
        exit;
    }
}

$spriteID=$usersele;
$spriteWidth=0;
$spriteHeight=0;
//$roomID=$roomid;
//getSpriteInfo($puser,$spriteID,$roomID,$spriteHeight);
getSpriteInfo($spriteID,$spriteWidth,$spriteHeight);

//echo $spriteHeight . "<br>";
//$mp = new map_info($roomID);
//$mp->outPutMap();

?>

<html>
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta name="viewport" content="width=device-width,initial-scale=<?php echo $viewport_scale?>,minimum-scale=<?php echo $viewport_scale?>,maximum-scale=<?php echo $viewport_scale?>">
<meta name="apple-mobile-web-app-capable" content="yes" />

<head>
<title></title>
<link rel="stylesheet" href="default.css">

<link rel="stylesheet" href="jquery-ui-1.8.11/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/demos/demos.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/slider.css">

<script language="javascript">
var act_type = "play";
var isgomain=false;
function gomain() {
   isgomain=true;
   document.location.href="./main.php";
}
</script>


<script type="text/javascript" src="./browserDetect.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script src="jquery-ui-1.8.11/jquery.touchSlider.js"></script>

<script src="./sfqdeploy/h6_min.js" type="text/javascript"></script>
<script src="./sfqdeploy/hm_cloth_ctrl_min.js" type="text/javascript"></script>
<script type="text/javascript" src="./iscroll/iscroll.js"></script>

<script src="jquery-ui-1.8.11/external/jquery.bgiframe-2.1.2.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.core.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.widget.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.mouse.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.draggable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.position.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.resizable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.dialog.js"></script>
<script src="http://www.audero.it/public/audero-smoke-effect/javascript/smoke-min.js"></script>

<script src="entry/scroller/sfq-touch-scroll.js"></script>


<?php
//$default_pos = getDefaultPos($puser,$roomTab);
//$default_pos = 30;

$mp->outPutMap();

//$default_pos = $mp->getRandomPos();

?>

<style type="text/css">
	#canvas {
		display: block;
		margin: auto;
		border: 0px solid #000;
		background: #000;
	}
	#lay0{
		display: block;
		margin: auto;
		background: #666666;
		border: 0px solid #fff;
		padding: 0px;
	}

    .portrait {
        -webkit-transform: rotate(90deg);
        -webkit-transform-origin: 200px 190px;
    }

    .portrait-onready {
        -webkit-transform: rotate(90deg);
        -webkit-transform-origin: 165px 150px;
    }

    .titleMenu {
        font-size: 150%;
        color: #FFF;
    }

	.buttonCtrl{
		width: 60px;
		height: 60px;
		z-index:9999;
	}

	#sayText{
		width: 300px;
		height: 50px;
		font-size:22px;
    }

    .smoke-puff {
   	    position: absolute;
	    width: 0px;
	    height: 0px;
	    z-index: 1000;
	    opacity: 0.4;
    }


@media only screen and (max-device-width: 480px) {
  /* For general iphone layouts */

    .titleMenu {
        font-size: 200%;
        color: #FFF;
    }

	.buttonCtrl{
		width: 96px;
		height: 96px;
		z-index:9999;
	}

	#sayText{
		width: 290px;
		height: 50px;
		font-size:22px;
    }

	#sayimg{
		width: 74px;
		height: 38px;
		z-index:9999;
	}
	#chatimg{
		width: 74px;
		height: 38px;
		z-index:9999;
	}
}

.menubox {
    	 width: 520px;
	     height: 60px;
	     text-align:center;
         padding: 5px 5px;
         z-index:9999;
}

.boxshow {
    	 width: 50px;
	     height: 50px;
	     text-align:left;
	     BACKGROUND-COLOR:#0bafe2;
         -moz-border-radius: 10px;   /* firefox */
         border-radius: 10px;        /* CSS3 */
         -moz-box-shadow: 5px 5px 10px #aaaaaa; /* Firefox */
         -webkit-box-shadow: 5px 5px 10px #aaaaaa; /* Safari,Chrome */
         box-shadow: 5;
         padding: 5px 5px;
}

.box1hide {
}

.menubox {
    	 width: 73px;
	     height: 73px;
	     border: "2px solid #000";
	     line-height: 83px;
	     text-align: center;
	     font-size:22px;
	     color:#fff;
	     margin: 1px;
	     display: block;
	     text-decoration: none;
	     overflow: hidden;
	     position: relative;
	     BACKGROUND-COLOR:#0bafe2;

         -moz-border-radius: 15px;   /* firefox */
         border-radius: 15px;        /* CSS3 */
}

</style>


</head>
<body style="overflow:hidden;background-color:#666666;margin-top: 0px;margin-left: 0px;" onload="startChat()" onscroll="relocateSaydiv()" onorientationchange="ajustOrientation();">

<div id="commDiv" style="z-index:9999;left:100px;top:100px;position:absolute;display:none">
      <iframe name="s1" src="socketcontainer.html"  style="position:absolute;top:40px;width:1px;height:1px"></iframe>
</div>

<?php if($hasSmoke == 1)  {?>
    <img id="smokeAnchor" src="./images/item_bar_bg.png"style="position:absolute;width:1px;height:1px;top:<?php echo $smokeY?>px;left:<?php echo $smokeX?>px;z-index:9999" />
<? } ?>

<?php //checkExist($puser,$roomid);?>

<div id="banner"  style="z-index:1;height:43px;background-color:#d51876">
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
                 <tr>
                          <td width=50% align="left"><img src="./res/myo.png"></td>
                          <td width=40% align="left">&nbsp;</td>
                          <td align="left"><a href="./main.php" target="_top"><img src="./images/logout.png"></a></td>
                 </tr>
         </table>
</div>

<div id="lay0"  style="z-index:1;display:none">
    <canvas id="canvas"  tabindex="1" style="z-index:1;background:url(<?php echo $canvasBg?>) no-repeat;background-position:<?php echo $bgImgPosX?>px <?php echo $bgImgPosY?>px;-webkit-background-size:<?php echo $bg_width."px"?> <?php echo $bg_height."px"?>">
    </canvas>


    <div id="historyDiv" style='font-size:22px; filter:alpha(opacity=60); /* IE */ -moz-opacity:0.6; /* Moz + FF */ opacity:0.6;z-index:1;left:6px;top:50px;position: absolute;border:0px;PADDING:0px; width:100%; height:300px; LINE-HEIGHT: 20px; overflow-x:hidden;OVERFLOW-y:auto;display:none;background-color:#FFF'>
		<section>
			<nav>
              <lay><br>
			  </lay>
			</nav>
		</section>
    </div>

    <div id="gallery-holder" title="gallery-holder" style="background:url(./images/item_bar_bg.png);width:100%;z-index:9999;display:none">
         <div class="gallery" id="gallery1" style="width:100%">
                 <?php $galwidth="100%";if(!$isIPhone) { $galwidth="80%";?>
                 <div style="width:10%;float: left;"><a href='#' class='prev1'><img src="images/item_ctrl_left.png"></a></div>
                 <? } ?>
                      <div class="holder" style="width:<?php echo $galwidth?>;float:left;">
                          <div id="items" class="list">
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/107/disp/disp.png' onclick=setHumanClo("lLeg:B107:6:0:6:1||rLeg:B107:6:0:6:1")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/505/disp/disp.png' onclick=setHumanClo("lLeg:L505:0:16:0:17||rLeg:L505:0:16:0:17")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/106/disp/disp.png' onclick=setHumanClo("body:A106:0:0:0:0")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/103/disp/disp.png' onclick=setHumanClo("body:A103:-1:2:-1:2")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/105/disp/disp.png' onclick=setHumanClo("head:A105:-15:-16:-15:-16")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/108/disp/disp.png' onclick=setHumanClo("head:A108:2:40:-3:37")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/026/disp/disp.png' onclick=setHumanClo("head:H026:0:0:0:0")></div></div>

                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/201/disp/disp.png' onclick=setHumanClo("body:A201:-2:-1:0:0")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/202/disp/disp.png' onclick=setHumanClo("lLeg:L202:0:16:0:18||rLeg:L202:0:16:0:18")></div></div>
                              <div class='item'><div class='newbox box4'><img onload='vertAlign(this)' src='res/items/203/disp/disp.png' onclick=setHumanClo("head:A203:-11:-16:-15:-16")></div></div>


                              <div class='item'><div class='newbox box4'><!--<img id='82' src='res/items/026/LD/H026.png'  onclick=setSelectedItem_web(this.id,23,'82','63')>--></div></div>
                              <div class='item'><div class='newbox box4'><!--<img id='83' src='res/items/108/LD/A108.png'  onclick=setSelectedItem_web(this.id,4,'83','63')>--></div></div>
                              <div class='item'><div class='newbox box4'><!--<img id='85' src='res/items/105/LD/A105.png' style='width:75;height:96' onclick=setSelectedItem_web(this.id,43,'85_0||85_1||85_2','62,63,55')>--></div></div>
                          </div>
                     </div>
                <?if(!$isIPhone) {?>
                <div style="float: right;"><a href='#' class='next1'><img src="images/item_ctrl_right.png"></a></div>
                <?}?>
         </div>
    </div>

</div>

<div id="lay9" style="z-index:1;display:none">
    <canvas id="canvas1" width="<?php echo $canvas_width?>px" height="<?php echo $canvas_height?>px"  style="z-index:1;">
    </canvas>
</div>

<div id="dialog-history" title="History" style="z-index:1;display:none">
</div>

<!--
<div id="menubox">
     <table border=0>
     <tr>
        <td><div id="sayCtrl"><img src="./images/say_ctrl.png"></div></td>
        <td>&nbsp;&nbsp;</td>
        <td><input id="sayText" type=text/ style="height:40px"></td>
        <td><a id="sayBut" href="#"><img id="sayimg" width="74px" width="38px" src="./images/say_but.png"></a></td>
        <td><a id="chatmsg" href="#"><img id="chatimg" width="74px" width="38px" src="./images/history_but.png"></a></td>
     </tr>
     <tr>
     </tr>
     </table>
</div>
-->

<div id="menubox" style="background:url(./images/item_bar_bg.png);">
     <table border=0>
     <tr>
        <td rowspan="2"><div id="sayCtrl"><img src="./images/say_ctrl.png"></div></td>
        <td>&nbsp;&nbsp;</td>
        <td align="right"><a id="sayBut" href="#"><img id="sayimg" width="74px" width="38px" src="./images/say_but.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <a id="chatmsg" href="#"><img id="chatimg" width="74px" width="38px" src="./images/history_but.png"></a></td>
        <td colspan="2" rowspan="2">&nbsp;</td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>
            <?php if($isIPhone)  {?>
                <input id="sayText" type=text/ style="height:50px;width:530px">
            <? } else {?>
                <input id="sayText" type=text/ style="height:40px;width:530px">
            <? } ?>
       </td>
       </tr>
     </table>
</div>


<div id="returnCtrl"  style="position:absolute;left:6px;top:70px;z-index:9999;display:none"><img src="./images/item_close.png"></div>
<div id="applyCtrl"  style="position:absolute;left:306px;top:70px;z-index:9999;display:none"><img src="./images/item_apply.png"></div>


<div id="actbox"  style="display:none;background:url(./images/item_bar_bg.png);">
     <table border=0>
     <tr>
        <td><div id="actCtrl"><img src="./images/act_ctrl.png"></div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><div  id='A1'><img src="./images/act1.png" style="height:90px"></div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><div  id='A2'><img src="./images/act2.png" style="height:90px"></div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><div  id='A3'><img src="./images/act3.png" style="height:90px"></div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><div  id='A4'><img src="./images/act4.png" style="height:90px"></div></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><div  id='A5'><img src="./images/act5.png" style="height:90px"></div></td>
     </tr>
     </table>
</div>



</body>

<script language="javascript">

window.requestAnimationFrame = (function(){
    //Check for each browser
    //@paul_irish function
    //Globalises this function to work on any browser as each browser has a different namespace for this
    return  window.requestAnimationFrame       ||  //Chromium
            window.webkitRequestAnimationFrame ||  //Webkit
            window.mozRequestAnimationFrame    || //Mozilla Geko
            window.oRequestAnimationFrame      || //Opera Presto
            window.msRequestAnimationFrame     || //IE Trident?
            function(callback, element){ //Fallback function
                window.setTimeout(callback, 1000/60);
            }
})();


// ??? A001?????????????????
// ??? A002?????????????????

//?置buffer canvas
var m_canvas = document.getElementById('canvas1');
var ctx = m_canvas.getContext('2d');

var version=2;

var isBrowser=false;
var isIPhone=false;


/*
if(BrowserDetect.browser=="Explorer")  {
   isBrowser=true;
} else if(BrowserDetect.browser=="iPhone")  {
   isIPhone=true;
}


if(BrowserDetect.OS=="iPhone/iPod")  {
   isIPhone=true;
} else {
   isBrowser=true;
}
*/

var deviceW0 = <?echo $deviceW0?>;
var deviceH0 = <?echo $deviceH0?>;
var deviceW1 = <?echo $deviceW1?>;
var deviceH1 = <?echo $deviceH1?>;


<?php
if($isIPhone) {
   echo "isIPhone=true;";
} else {
   echo "isBrowser=true;";
}
?>

if(isBrowser)
    window.onscroll = relocateSaydiv;

var device = "<?php echo $device?>";
var user = "<?php echo $puser?>";
var myname = unescape("<?php echo $this_nick?>");

user=unescape(user);
var default_pos = <?php echo $default_pos?>;
var main_img_id = <?php echo $spriteID?>;
var room_id = "<?php echo $roomid?>";
// common setting for FF and IE--->
//should be the same as div parameters.
var bg_width = 1024;
var half_bg_width = <?php echo $itemStartX?>;   // ajust this to scroll left and right
var bg_height = 512;

//A001 tile img size  ??????????????????
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

//var screen_height_offset_times = 8;   // ajust this to scroll up and down

var itemStartX = <?php echo $itemStartX?>;
var itemStartY = <?php echo $itemStartY?>;
var screen_height_offset = <?php echo $itemStartY?>;

//A001 player image size  ??????????????????
//var player_img_width = 16*2;
//var player_img_height = 31*2;

var player_img_width = <?php echo $spriteWidth?>;
var player_img_height = <?php echo $spriteHeight?>;

// A002 should be the same as map_all array size.  ????????
var map_arr_width = <?php echo $map_arr_width?>;
var map_arr_height = <?php echo $map_arr_height?>;

var ix = half_bg_width - tile_width/2;
var iy = 0 - screen_height_offset;

var canvas_offx = 0;
var canvas_offy = 43;    // should be the banner height;
var scr_scroll_speed = 40;

var maxUser = 8;
// common setting for FF and IE--->


// set passable terrain. should be load from server for each SIM-->
// var passable_terrain = Array(2,51,55,58,59,60,61,62,81,82,83,70,71,72,73,74,75,76);
// set passable terrain -->


var roomRes =  new ResLoad();
roomRes.map_res_load(map_all,0);  //????data load????

//??spriteid????sprite????????,utility.js,customer ht5.js??????
var mainPaceNum;
if(main_img_id<1000) {
     mainPaceNum=6;
} else if(main_img_id>=1000 && main_img_id<2000) {
     mainPaceNum=2;
} else {
     mainPaceNum=4;
}

var spriteNum=4*(mainPaceNum+1);

//roomRes.sprite_res_load(main_img_id,4,mainPaceNum+1);  //??spriteID?sprite?????action????load sprite?????????load 4*7=28?action??
isloaded();

var cb_canvas = document.getElementById('canvas');
var ctx1 = cb_canvas.getContext('2d');
var pathEnd = true;
var iID;
var cycleSpeed = 3000;
var spriteSpeed = 80;    //character moving speed , old value is 120

var ca = new Canvas();
ca.setMap(ix,iy);

var isTest = false;

//var inistr_main = "1||1||lLeg||lArm_B101:3:0:4:-1||lLimb||body_A101:0:3:-1:1||rLeg||rArm_C101:-1:0:-2:0||rLimb||head_M001:10:22:10:88_M003:14:28:0:0_M002:14:28:0:0:0_M005:22:26:0:0_M004:24:43:0:0_H006:0:-1:0:0";  //accesory should define the offset to the attached body part
//var inistr_main_myo = "1||1||lLeg_L503:-3:-2:0:-1||lArm||lLimb||body_A102:0:6:1:3||rLeg_L502:2:-1:0:0||rArm||rLimb||head_H009:-10:0:2:2";  //accesory should define the offset to the attached body part

var inistr_main = "<?php echo $this_looks?>";
var inistr_main_old = inistr_main;


//var anistr_ameba = "&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld;2&&35;102;-40;ld_37;83;20;ld_28;84;30;ld_40;77;0;ld_46;100;20;ld_56;80;-20;ld_60;83;-20;ld_20;26;0;ld;1&&35;102;20;ld_37;79;0;ld_28;84;10;ld_40;77;0;ld_46;98;-20;ld_54;76;10;ld_58;85;10;ld_20;26;0;ld;2";
var anistr ="&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;-20;ld_39;97;20;ld_51;90;10;ld_56;87;0;ld_62;113;30;ld_82;95;-20;ld_72;90;-20;ld_40;25;0;ld&&53;108;-50;ld_39;97;40;ld_51;90;10;ld_56;87;0;ld_62;113;50;ld_82;95;-10;ld_72;90;-20;ld_40;25;0;ld&&53;108;-10;ld_39;99;0;ld_49;92;0;ld_56;87;0;ld_62;113;10;ld_82;97;10;ld_72;88;0;ld_40;25;0;ld&&53;108;10;ld_39;99;30;ld_49;92;10;ld_56;87;0;ld_62;113;-30;ld_82;95;-10;ld_72;88;-10;ld_40;25;0;ld";

//var anistr = "&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld&&35;102;-40;ld_37;83;20;ld_28;84;30;ld_40;77;0;ld_46;100;20;ld_56;80;-20;ld_60;83;-20;ld_20;26;0;ld&&35;102;20;ld_37;79;0;ld_28;84;10;ld_40;77;0;ld_46;98;-20;ld_54;76;10;ld_58;85;10;ld_20;26;0;ld";


var paceNum = anistr.split("&&").length-2;

//var anistr_myo = "&&47;94;0;ld_45;83;0;ld_35;87;0;ld_52;70;0;ld_57;102;0;ld_68;81;0;ld_77;89;0;ld_40;26;0;ld&&43;98;-40;ld_45;83;20;ld_35;83;20;ld_52;68;0;ld_57;100;40;ld_68;81;-20;ld_77;85;-20;ld_40;26;0;ld&&47;94;0;ld_45;83;0;ld_35;87;0;ld_52;70;0;ld_57;102;0;ld_68;81;0;ld_77;89;0;ld_40;26;0;ld&&51;94;30;ld_45;83;30;ld_31;83;20;ld_52;70;0;ld_55;104;-30;ld_68;81;-20;ld_79;87;-20;ld_40;26;0;ld&&47;94;0;ld_45;83;0;ld_35;87;0;ld_52;70;0;ld_57;102;0;ld_68;81;0;ld_77;89;0;ld_40;26;0;ld";

var or = "ld";
var hm = new human(or,inistr_main);
hm.animator(anistr);
//hm.setHMPos(150,120);  //?置human?示到跟canvas?点的相?位置。 50，120?基点，表示??色的点

//hm.drawFrame();


var mainsprite = new Sprite();
mainsprite.setUser(user);
mainsprite.setPos(<?php echo $default_pos?>);
mainsprite.setWidth(player_img_width);
mainsprite.setHeight(player_img_height);

var otherSprites = new OtherSprites();
mainsprite.setImg(main_img_id);
mainsprite.setDispName(myname);

mainsprite.setHuman(hm);
mainsprite.path="";

var path_cal =  new Path_Finding(map_arr_width,map_arr_height);
path_cal.Path_Finding_init(map_all);
var target_pos=0;

var isMouseDown=0;

$("#startBut").click(function(){
     startChat();
})

$("#designDiv").click(function() {
     window.open("c7_frm.php?room="+room_id,"_top");
})

$("#sayBut").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = $("#sayText").val();
     //var content = actstr;
     if(content.indexOf("<")>=0 || content.indexOf(">")>=0 || content.indexOf("eval")>=0 || content.indexOf("grep")>=0 || content.indexOf("script")>=0 || content.indexOf("shell")>=0) {
        $("#sayText").val("")
        return;
     }

     if(content !="") {
        content = escape(content);

/*
        $.ajax({type:"GET", url:"sendChatMsg.php?from="+fr+"&to="+to+"&content="+content, dataType:"text",async:false,success:function (msg){
              update_la_content(user,unescape(content));
              mainsprite.setSayTime(5);
   	    }});
*/

        var sendStr=content;
        s1.socket.emit("chat", sendStr);

//        ctx.fillText(unescape(content), mainsprite.px, mainsprite.py);

        update_la_content(user,unescape(content),myname);
        mainsprite.setSayTime(20);

   }
})

$("#A1").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&53;108;10;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;30;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;30;ld_37;99;60;ld_49;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;30;ld_37;99;60;ld_49;90;0;ld_56;87;0;ld_64;113;0;ld_86;99;-40;ld_76;90;0;ld_40;25;0;ld&&53;108;30;ld_37;99;60;ld_49;90;0;ld_56;87;0;ld_64;113;0;ld_86;99;-60;ld_76;90;0;ld_40;25;-10;ld&&53;108;0;ld_37;99;10;ld_49;90;0;ld_56;87;0;ld_64;113;0;ld_86;99;30;ld_76;90;0;ld_40;25;-10;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})

$("#A2").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;-10;ld_39;99;30;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;20;ld_72;90;0;ld_40;25;10;ld&&53;108;-10;ld_39;99;70;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;40;ld_72;90;0;ld_40;25;20;ld&&53;108;-10;ld_39;99;70;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;40;ld_72;90;0;ld_40;25;20;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})

$("#A3").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;rd&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;rd&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;rd&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;rd&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})


$("#A4").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&51;108;-10;ld_35;95;70;ld_49;92;40;ld_56;87;0;ld_62;111;-10;ld_84;99;-10;ld_74;90;0;ld_40;25;10;ld&&51;108;-10;ld_35;91;80;ld_49;92;50;ld_56;87;0;ld_62;111;-10;ld_84;97;-20;ld_74;90;-10;ld_40;25;10;ld&&51;108;-10;ld_35;95;50;ld_49;92;30;ld_56;87;0;ld_62;111;-10;ld_82;97;0;ld_74;90;0;ld_40;25;0;ld&&51;108;-10;ld_35;95;50;ld_49;92;30;ld_56;87;0;ld_62;111;-10;ld_82;97;0;ld_74;90;0;ld_40;25;0;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})

$("#A5").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld&&49;112;-20;ld_39;105;-20;ld_51;96;0;ld_56;93;0;ld_58;113;-30;ld_82;105;30;ld_72;96;0;ld_40;31;-10;ld&&49;112;-20;ld_39;105;-20;ld_51;96;0;ld_56;93;0;ld_58;113;-30;ld_82;105;30;ld_72;96;0;ld_40;31;-10;ld&&49;98;60;ld_37;77;70;ld_45;82;70;ld_50;77;-10;ld_58;103;-60;ld_84;85;-40;ld_72;84;-40;ld_40;15;20;ld&&49;98;60;ld_37;77;70;ld_45;82;70;ld_50;77;-10;ld_58;103;-60;ld_84;85;-40;ld_72;84;-40;ld_40;15;20;ld&&53;108;0;ld_39;99;0;ld_51;90;0;ld_56;87;0;ld_64;113;0;ld_82;99;0;ld_72;90;0;ld_40;25;0;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})


<!-- Screen Moving Control for both Safari Mobile and WEB  -->

var tx=0;
var ty=0;
var sx=0;
var sy=0;
var isScrMoving=0;
var main_heart=0;

//for mobile safari only. android should be considered.
lay0.ontouchmove = moveEventFunction;
lay0.ontouchend = endMoveEventFunction;
document.getElementById("historyDiv").ontouchmove=cancelMoving;
//document.getElementById("menubox").ontouchmove=cancelMoving;
//document.getElementById("titleDiv").ontouchmove=cancelMoving;

function pageElementMove(ox,oy) {
<?php if($hasSmoke == 1)  {?>
   var sx = parseInt($("#smokeAnchor").css("left"));
   var sy = parseInt($("#smokeAnchor").css("top"));
   sx += ox;
   sy += oy;
   $("#smokeAnchor").css("left",sx+"px");
   $("#smokeAnchor").css("top",sy+"px");
<? } ?>
}

function cancelMoving(e) {
   e.preventDefault();
}

function setHumanClo(val) {
   $("#applyCtrl").css("display","");
   inistr_main = addItem(val);
   //alert(hm.orient);

   hm = new human(hm.orient,inistr_main);
   hm.animator(anistr);

   mainsprite.setHuman(hm);
   //ca.setMainSprite(mainsprite);
}

function setHumanCloBack() {
   hm = new human(hm.orient,inistr_main_old);
   hm.animator(anistr);
   mainsprite.setHuman(hm);
}


var myScroll;
function startChat() {
           <?php if($hasSmoke == 1)  {?>
                SmokeEffect.run("smokeAnchor", 50, 20);
           <? } ?>
           ca.setMainSprite(mainsprite);
           ajustOrientation();

           var cpx = parseInt(cb_canvas.style.left)+canvas_offx;
           var cpy = parseInt(cb_canvas.style.top)+canvas_offy;
           cb_canvas.style.left = cpx +"px";
           cb_canvas.style.top = cpx +"px";

           //cycleID  = setInterval('setCycle()',cycleSpeed);

           //i_oID = setInterval('move_otherPlayers()',spriteSpeed);
           document.getElementById('canvas').ontouchstart = function(e) {
               window.top.scrollTo(0,1);

               //$("#sayText").val("mmm:"+e.touches[0].clientX);
               isMouseDown=0;
               //if the screen is rolling, the user can't specify the moving target.
               if(isScrMoving==0) {
                   var dir;
                   e=e || window.event;
                   //var win_left = document.body.scrollLeft;
                   //var win_top = document.body.scrollTop;

                   if(isBrowser) {
                      win_left = document.documentElement.scrollLeft;
                      win_top = document.documentElement.scrollTop;
                   } else {
                      win_left = document.body.scrollLeft;
                      win_top = document.body.scrollTop;
                   }

                   var mousex = e.touches[0].clientX + win_left - canvas_offx - m_offx;
                   var mousey = e.touches[0].clientY-30 + itemStartY + win_top - canvas_offy +30 - m_offy;  // canvas top property

//pos2loc_test(mousex,mousey);

                   target_pos = getPointInRhombus(mousex,mousey);



                   //$("#sayText").val("win:"+ win_left+"-"+win_top);

                   if(target_pos<0) {
                      //alert("It is out of the boundary."+target_pos);
                      target_pos = 0;
                   } else if(jQuery.inArray(target_pos,map_mark)==-1 && target_pos != mainsprite.pos) {
                       //main_heart = new Date().getTime();
                       mainsprite.setPath();
                   } else {
                      //alert("It is occupied by some items");
                      target_pos = 0;
                   }
               }
           }
           $("#startDiv").css("display","none");
           $("#sayDiv").css("display","");
           $("#designDiv").css("display","");
           $("#lay0").css("display","");

           s1.conn();

           involk();
           //mainsprite.login();
           //i_oID = setInterval('move_otherPlayers()',spriteSpeed);
}

function involk() {
    if(s1.connected)  {
           mainsprite.login();
           i_oID = setInterval('move_otherPlayers()',spriteSpeed);
    } else {
           setTimeout(involk,500);
    }
}


function setText(str) {
    $("#sayText").val(str);
}



lay0.onmousedown = m_down;
lay0.onmousemove = moveMSEventFunction;
lay0.onmouseup = endMSMoveEventFunction;
lay0.onmouseout = endMSMoveEventFunction1;
//lay0.onmouseover = endMSMoveEventFunction;

function sss() {
   alert("ssss");
}


$("#lay0").disableSelection();
$("#canvas").disableSelection();


// Get the coordinates for a mouse or touch event
function getCoords(e) {
    if (e.offsetX) {
        // Works in Chrome / Safari (except on iPad/iPhone)
        return { x: e.offsetX, y: e.offsetY };
    }
    else if (e.layerX) {
        // Works in Firefox
        return { x: e.layerX, y: e.layerY };
    }
    else {
        // Works in Safari on iPad/iPhone
        //alert((e.pageX-cb_canvas.offsetLeft) +":"+ (e.pageY-cb_canvas.offsetTop));
        return {x:e.pageX-cb_canvas.offsetLeft,y:e.pageY-cb_canvas.offsetTop};
    }
}

$("#chatmsg").click(function() {

     if($("#historyDiv").css("display")=="none") {
         $("#historyDiv").css("display","");
         $("#chatimg").attr("src","./images/history_close.png");
     }
     else {
         $("#historyDiv").css("display","none");
         $("#chatimg").attr("src","./images/history_but.png");
     }
})

$("#buttonCtrl").click(function() {
     if($("#buttonCtrl").val()=="ACT") {
        $("#sayDiv").css("display","none");
        $("#actDiv").css("display","");
        $("#buttonCtrl").val("SAY");
     } else {
        $("#sayDiv").css("display","");
        $("#actDiv").css("display","none");
        $("#buttonCtrl").val("ACT");
     }
})




function relocateSaydiv()  {
     if(!isIPhone)
        return;

     var win_left=0;
     var win_top=0;

     if(isBrowser) {
        win_left = document.documentElement.scrollLeft;
        win_top = document.documentElement.scrollTop;
     } else {
        win_left = document.body.scrollLeft;
        win_top = document.body.scrollTop;
     }
     var s_left=parseInt(htmlPosStrToNumber($("#sayDiv").css("left")));
     var s_top=parseInt(htmlPosStrToNumber($("#sayDiv").css("top")));

     if(win_top==0) {
         s_top = 52;
     } else  {
         s_top = win_top;
     }

     if(win_left==0) {
         s_left = 106;
     } else  {
         s_left = win_left;
     }

     $("#sayDiv").css("left",s_left);
     $("#sayDiv").css("top",s_top);

}

function mousemove(e) {
     if(isMouseDown==1) {
        var evt = window.event || e;
        var left = evt.clientX + "px";
        var top = evt.clientY + "px";
        //$("#sayText").val(left +":"+ top)
     }
}

function m_down() {
    //alert("mdown");
    isMouseDown=1;
}


function m_up() {
    //alert("mup");
    isMouseDown=0;
}

$(function(){
	$('#clothDialog').dialog({
		autoOpen: false,
		width: 600,
		height:400,
		buttons: {
			"Ok": function() {
			    setCloth();
				$(this).dialog("close");
			},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});

});

//    var hmIniStr = ">>"+"12~3--2_3~4_3--adf~s";
function setCloth() {
    inistr_main_old  = inistr_main;
    var hmIniStr = ">>"+inistr_main.replace(/\|/g, "-");
    hmIniStr = hmIniStr.replace(/:/g, "~");

    var fr = user;
    var to="";

/*
    $.ajax({type:"GET", url:"sendChatMsg.php?from="+fr+"&to="+to+"&content="+hmIniStr, dataType:"text",async:false,success:function (msg){

   	}});
*/

     var sendStr=hmIniStr;
     s1.socket.emit("cloth", sendStr);

     //hm = new human(hm.orient,clothfrm.getIniStr());
     //hm.animator(anistr);
     //mainsprite.setHuman(hm);
}


//根据???整canvas方向
//由于??不全，?在做法?将html和脚本中中canvas的?高都固定。
//最后解决方案???，?不同方向制定不同的?高?定，否?将物体?制在屏幕?示不出来的canvas位置上造成浪?
//具体方法可能?，1，利用css?配将canvas，2，利用下面脚本?定相?参数
function ajustOrientation() {
           var orientation = window.orientation;
           var lw0,lh0,lw1,lh1;

           lw = getWidth()-8 + 10;                        //10 is the original double border width
           lh = getHeight() + 100;                    //100 is the navigate bar of IOS. if android should be some other value.
           var heightOff=0;
           if(device == "ipad")
              heightOff = 236;
           else if(device == "iphone")
              heightOff = 120;

           if(orientation == null)
                lh -=150;

           var sw;
           if(orientation == 0) {
              if(lw > lh) {
                  sw=lw;
                  lw=lh;
                  lh=sw-40;
              }

              cb_canvas.width=lw;
              cb_canvas.height=lh-heightOff;
              m_canvas.width=lw;
              m_canvas.height=lh-heightOff;
              bg_width=lw;
              bg_height=lh-heightOff;
              //$(".menubox").css("left","6px");
              //$(".menubox").css("top",(lh-80)+"px");

           } else  {
              if(lw < lh) {
                  sw=lw;
                  lw=lh;
                  lh=sw-40;
              }
              cb_canvas.width=lw;
              cb_canvas.height=lh-heightOff;
              m_canvas.width=lw;
              m_canvas.height=lh-heightOff;
              bg_width=lw;
              bg_height=lh-heightOff;
              //$(".menubox").css("left","6px");
              //$(".menubox").css("top",(lh-80)+"px");
           }

           $.fn.sfqTouchSlider.bar_h6(lw);
           $("#returnCtrl").css("top", (bg_height-40)+"px");
           $("#applyCtrl").css("top", (bg_height-40)+"px");

           //bg_height=1024;
           ca.mapReload();

           window.setTimeout(function() {window.top.scrollTo(0,1); relocateSaydiv();} , 100);
}


function test1() {
        alert("test1");
        //window.top.scrollTo(0,1);
}

function save() {
       $.ajax({type:"GET", url:"looksave.php?user="+user+"&lookstr="+inistr_main, dataType:"text",async:false,success:function (msg){
         		setCloth();
         		//alert("保存しました。");
       }});
}

$(document).ready(function() {
    $(function(){
	        $('nav').sfqTouchSlider({
       			item: 'div.item',
    			hideClass: 'mt-hidden',
    			activeClass: 'active',
    			t_width:'500',
    			t_height:300,
    			t_left:10,
    			t_top:10
	        });
    });

    $('#gallery1').touchSlider({
			mode: 'shift',
            <?if(!$isIPhone)  {
              echo "prevLink: 'a.prev1',";
              echo "touch:false,";
              echo "nextLink: 'a.next1'";
            }?>
   });


<?php if($hasSmoke == 1)  {?>
   SmokeEffect.smokeEffect(
         "smokeAnchor",
         {
           ImagePath: "./images/yan.png",
           Width: 100,
           Height: 100
         }
   );
<? } ?>


});

$("#sayCtrl").click(function() {
    $("#menubox").css("display","none");
    $("#actbox").css("display","");
})

$("#actCtrl").click(function() {
    //$("#menubox").css("display","");
    $("#returnCtrl").css("top", (bg_height-40)+"px");
    $("#returnCtrl").css("display","");
    $("#applyCtrl").css("top", (bg_height-40)+"px");
    //$("#applyCtrl").css("display","");
    $("#gallery-holder").css("display","");
    $("#actbox").css("display","none");
})

$("#returnCtrl").click(function() {
    setHumanCloBack();
    $("#gallery-holder").css("display","none");
    $("#menubox").css("display","");
    $("#returnCtrl").css("display","none");
    $("#applyCtrl").css("display","none");
})

$("#applyCtrl").click(function() {
    $("#gallery-holder").css("display","none");
    $("#menubox").css("display","");
    $("#returnCtrl").css("display","none");
    $("#applyCtrl").css("display","none");
    //setCloth();
    save();
})




/*
$(".triangle-isosceles").click(function() {
    alert("tttttt");
})
*/


/*
$(window).resize(function() {
    var orientation = window.orientation;
    if(orientation != null)
           return;
    if(this.resizeTO) clearTimeout(this.resizeTO);
    this.resizeTO = setTimeout(function() {
        $(this).trigger('resizeEnd');
    }, 500);
});

$(window).bind('resizeEnd', function() {
  //resize just happened, pixels changed
   //setText(getWidth() +":"+ getHeight());
   var lw = getWidth()-12;
   var lh = getHeight()-107;

   cb_canvas.width=lw;
   cb_canvas.height=lh;
   m_canvas.width=lw;
   m_canvas.height=lh;
   bg_width=lw;
   bg_height=lh;
});
*/


</script>


</html>
