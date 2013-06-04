<?php
header("content-type:text/html; charset=utf-8");
?>
<img id="layLoading" src="loading1.gif" style="z-index:1;left:480px;top:150px;position: absolute;">

<?php
require_once("config.php");
require_once("map_info.php");

$puser = $_GET["puser"];

$roomid = $_GET["room"];
$roomTab = "pol_pos_room".$roomid;


$canvasBg = "ss2.jpg";
//$canvasBg = "bg_room".$roomid . ".png";

$usersele = $_GET["usersele"];

//echo $puser .":". $room .":". $usersele . "<br>";

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

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
<meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5,maximum-scale=0.5">
<meta name="apple-mobile-web-app-capable" content="yes" />

<head>
<title>Now Chat</title>
<link rel="stylesheet" href="default.css">

<link rel="stylesheet" href="jquery-ui-1.8.11/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/demos/demos.css">

<script src="lib/jquery-1.5.1.js" type="text/javascript"></script>

<script src="OtherSprites.js" type="text/javascript"></script>
<script src="h6.js" type="text/javascript"></script>
<script src="Sprite.js" type="text/javascript"></script>
<script src="custom_ht5.js" type="text/javascript"></script>
<script src="aStar1.js" type="text/javascript"></script>
<script src="utility.js" type="text/javascript"></script>
<script src="ResLoad.js" type="text/javascript"></script>
<script src="browserDetect.js" type="text/javascript"></script>
<script src="cha/body_preload.js" type="text/javascript"></script>
<script src="cha/hm.js" type="text/javascript"></script>

<script src="jquery-ui-1.8.11/external/jquery.bgiframe-2.1.2.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.core.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.widget.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.mouse.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.draggable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.position.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.resizable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.dialog.js"></script>


<?php
//$default_pos = getDefaultPos($puser,$roomTab);
$default_pos = 458;

$mp = new map_info($roomid);
$mp->outPutMap();
//$default_pos = $mp->getRandomPos();
?>

<style type="text/css">
	#canvas {
		display: block;
		margin: auto;
		border: 5px solid #000;
		background: #000;
	}
	#lay0{
		display: block;
		margin: auto;
		background: #222;
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
    }
	#sayimg{

	}
	#chatimg{

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
		width: 300px;
		height: 50px;
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

</style>





</head>
<body style="background-color:#4f4f4f;margin-top: 0px;margin-left: 0px;" onscroll="relocateSaydiv()" onorientationchange="ajustOrientation();">

<div id="titleDiv" stype="background-color:#272727">
      <img src="bg_title.png" style="left:0px;width:640;height:42px;z-index:3;position: absolute">
</div>

<div id="commDiv" style="z-index:9999;left:100px;top:100px;position:absolute">
      <iframe name="s1" src="socketcontainer.html"  style="position:absolute;top:40px;width:1px;height:1px"></iframe>
</div>

<?php checkExist($puser,$roomid);?>


<div id="designDiv" style="z-index:3;left:250px;top:12px;position: absolute;display:none">
     <a href="MapEdit-c6.php?room=<?php echo $roomid?>&puser=<?php echo $puser?>" target="_top"><b><div class="titleMenu">Room</div> </b>
</div>

<div id="clothDiv" style="z-index:3;left:450px;top:12px;position: absolute">
     <a href="#" onclick="javascript:$('#clothDialog').dialog('open');" target="_top"><b><div class="titleMenu">Cloth </div></b></a>
</div>



<!--
<div id="homeDiv" style="z-index:3;left:300px;top:18px;position: absolute">
     <img id="homeBut" borde=0 src="res/icons/home.png"><a href="./index.html" target="_top"><font color="white">Home</font></a>
</div>



<div id="logoutDiv" style="z-index:3;left:750px;top:17px;position: absolute">
     <img id="logoutBut" borde=0 src="res/icons/logout.png"><a href="./index.html" target="_top"><font color="white">Logout</font></a>
</div>
-->

<div id="startDiv" style="z-index:3;left:500px;top:200px;position: absolute;display:none">
     <a id="startBut" href="#"><img src="./res/icons/start.png"></a>
</div>


<div id="control" style="z-index:3;left:10px;top:45px;position: absolute">
    <input type=button id='buttonCtrl' class="buttonCtrl" value='ACT'>
</div>

<div id="sayDiv" style="z-index:2;left:96px;top:52px;position: absolute;display:none">
     <table border=0>
     <tr>
        <td><input id="sayText" type=text/></td>
        <td><a id="sayBut" href="#"><img id="sayimg" src="res/icons/say.png"></a></td>
        <td><a id="chatmsg" href="#"><img id="chatimg" src="res/icons/his_open.png"></a></td>
     <tr>
     </table>
</div>

<div id="actDiv" style="z-index:2;left:106px;top:45px;position: absolute;display:none">
     <table border=0>
     <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><input type=button id='A1' class="buttonCtrl" value='A1'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><input type=button id='A2' class="buttonCtrl" value='A2'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><input type=button id='A3' class="buttonCtrl" value='A3'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><input type=button id='A4' class="buttonCtrl" value='A4'></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><input type=button id='A5' class="buttonCtrl" value='A5'></td>
     </tr>
     </table>
</div>

<div id="clothDialog" title="My inventory" style="z-index:1">
    <iframe name="clothfrm" src="human_cloth.html" frameborder="0" scrolling="no" style="position:absolute;top:0;width:500px;height:320px"></iframe>
</div>

<div id="lay0"  style="z-index:1;display:none">
    <canvas id="canvas" width="1024px" height="1024px"  style="z-index:1;left:0px;top:40px;position:absolute;background:url(<?php echo $canvasBg?>) no-repeat;background-position:-512px -570px;-webkit-background-size:2048px 1332px">
    </canvas>
</div>

<div id="lay9" style="z-index:1;display:none">
    <canvas id="canvas1" width="1024px" height="1024px"  style="z-index:1;left:0px;top:40px;position:absolute>
    </canvas>
</div>

<div id="dialog-history" title="History" style="z-index:1;display:none">
</div>

<div id="historyDiv" style='filter:alpha(opacity=60); /* IE */ -moz-opacity:0.6; /* Moz + FF */ opacity:0.6;z-index:1;left:6px;top:150px;position: absolute;border:0px;PADDING:0px; width:298px; height:200px; LINE-HEIGHT: 20px; overflow-x:hidden;OVERFLOW-y:auto;display:none;background-color:#FFF'>
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

var isIE=false;
var isIPhone=false;

if(BrowserDetect.browser=="Explorer")  {
   isIE=true;
} else if(BrowserDetect.browser=="iPhone")  {
   isIPhone=true;
}

if(isIE)
    window.onscroll = relocateSaydiv;

var user = "<?php echo $puser?>";
user=unescape(user);
var default_pos = <?php echo $default_pos?>;
var main_img_id = <?php echo $spriteID?>;
var room_id = <?php echo $roomid?>;
// common setting for FF and IE--->
//should be the same as div parameters.
var bg_width = 1024;
var half_bg_width = 512;   // ajust this to scroll left and right
var bg_height = 512;

//A001 tile img size  ??????????????????
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

//var screen_height_offset_times = 8;   // ajust this to scroll up and down
var screen_height_offset = 30 * 8;

//A001 player image size  ??????????????????
//var player_img_width = 16*2;
//var player_img_height = 31*2;

var player_img_width = <?php echo $spriteWidth?>;
var player_img_height = <?php echo $spriteHeight?>;

// A002 should be the same as map_all array size.  ????????
var map_arr_width = 32;
var map_arr_height = 32;

var ix = half_bg_width - tile_width/2;
var iy = 0 - screen_height_offset;

var canvas_offx = 0;
var canvas_offy = 0;
var scr_scroll_speed = 180;

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
var spriteSpeed = 120;    //character moving speed , old value is 120

var ca = new Canvas();
ca.setMap(ix,iy);

var isTest = false;

//var inistr_main = "1||1||lLeg||lArm_B101:3:0:4:-1||lLimb||body_A101:0:3:-1:1||rLeg||rArm_C101:-1:0:-2:0||rLimb||head";  //accesory should define the offset to the attached body part
var inistr_main = "1||1||lLeg||lArm_B101:3:0:4:-1||lLimb||body_A101:0:3:-1:1||rLeg||rArm_C101:-1:0:-2:0||rLimb||head_M001:10:22:10:88_M003:14:28:0:0_M002:14:28:0:0:0_M005:22:26:0:0_M004:24:43:0:0_H006:0:-1:0:0";  //accesory should define the offset to the attached body part
var anistr = "&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld&&35;102;-40;ld_37;83;20;ld_28;84;30;ld_40;77;0;ld_46;100;20;ld_56;80;-20;ld_60;83;-20;ld_20;26;0;ld;1&&35;102;20;ld_37;79;0;ld_28;84;10;ld_40;77;0;ld_46;98;-20;ld_54;76;10;ld_58;85;10;ld_20;26;0;ld;2";
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

mainsprite.setHuman(hm);
mainsprite.path="";

var path_cal =  new Path_Finding(map_arr_width,map_arr_height);
path_cal.Path_Finding_init(map_all);
var target_pos=0;

var isMouseDown=0;

$("#startBut").click(function() {
           mainsprite.login();
           ca.setMainSprite(mainsprite);
           ajustOrientation();

           var cpx = parseInt(cb_canvas.style.left)+canvas_offx;
           var cpy = parseInt(cb_canvas.style.top)+canvas_offy;
           cb_canvas.style.left = cpx +"px";
           cb_canvas.style.top = cpx +"px";

           //cycleID  = setInterval('setCycle()',cycleSpeed);

           i_oID = setInterval('move_otherPlayers()',spriteSpeed);
           document.getElementById('lay0').onclick = function(e) {

//$("#sayText").val("mm:"+isScrMoving);


               isMouseDown=0;
               //if the screen is rolling, the user can't specify the moving target.
               if(isScrMoving==0) {
                   var dir;
                   e=e || window.event;
                   //var win_left = document.body.scrollLeft;
                   //var win_top = document.body.scrollTop;

                   if(isIE) {
                      win_left = document.documentElement.scrollLeft;
                      win_top = document.documentElement.scrollTop;
                   } else {
                      win_left = document.body.scrollLeft;
                      win_top = document.body.scrollTop;
                   }
                   var mousex = e.clientX + win_left - canvas_offx;
                   var mousey = e.clientY-30-iy + win_top - canvas_offy +30;  // canvas top property

                   target_pos = getPointInRhombus(mousex,mousey);

                   //$("#sayText").val("win:"+ win_left+"-"+win_top);

                   if(target_pos<0) {
                      //alert("It is out of the boundary."+target_pos);
                      target_pos = 0;
                   } else if(jQuery.inArray(target_pos,map_mark)==-1 && target_pos != mainsprite.pos) {
                       mainsprite.setPath();
                   } else {
                      //alert("It is occupied by some items");
                      target_pos = 0;
                   }
               }
           }
           $(this).css("display","none");
           $("#sayDiv").css("display","");
           $("#designDiv").css("display","");
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

        update_la_content(user,unescape(content));
        mainsprite.setSayTime(20);

   }
})

$("#A1").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&35;102;0;ld_37;79;20;ld_32;82;40;ld_36;77;-10;ld_46;100;0;ld_52;76;40;ld_52;85;90;ld_18;24;-10;ld&&35;102;0;ld_37;79;20;ld_32;82;30;ld_36;77;-10;ld_46;100;0;ld_54;76;50;ld_50;85;120;ld_18;24;-10;ld&&35;102;0;ld_37;79;20;ld_32;82;40;ld_36;77;-10;ld_46;100;0;ld_54;76;50;ld_50;85;100;ld_18;24;-10;ld&&35;102;0;ld_37;79;20;ld_32;82;30;ld_36;77;-10;ld_46;100;0;ld_54;76;50;ld_50;85;120;ld_18;24;-10;ld&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})

$("#A2").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&33;96;-10;ld_31;73;70;ld_22;70;90;ld_34;69;0;ld_40;90;-20;ld_52;76;-70;ld_56;73;-50;ld_18;16;10;ld&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld&&33;96;-10;ld_31;73;70;ld_22;70;90;ld_34;69;0;ld_40;90;-20;ld_52;76;-70;ld_56;73;-50;ld_18;22;10;ld&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld";

     mainsprite.setActStr(content);
     mainsprite.setActCntVal(0);

     var sendStr=content;
     s1.socket.emit("act", sendStr);
})

$("#A3").click(function() {
     objOnclick=true;
     var fr = user;
     var to="";
     var content = "&&45;102;0;rd_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld&&35;102;0;ld_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld&&47;102;0;rd_37;79;0;ld_28;86;0;ld_40;77;0;ld_46;100;0;ld_56;80;0;ld_60;85;0;ld_20;26;0;ld";

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

//for mobile safari only. android should be considered.
canvas.ontouchmove = moveEventFunction;
canvas.ontouchend = endMoveEventFunction;

function endMoveEventFunction(e) {
    e.preventDefault();
    tx=0;
    ty=0;
    sx=0;
    sy=0;
    setTimeout(function() { isScrMoving=0; },300);
}

function moveEventFunction(e) {
    e.preventDefault();
    isScrMoving=1;

    if (e.touches) {
        var p = getCoords(e.touches[0]);
        mapScreenMove(p.x,p.y);
    }
    return false;
}


canvas.onmousedown = m_down;
canvas.onmousemove = moveMSEventFunction;
canvas.onmouseup = endMSMoveEventFunction;
canvas.onmouseout = endMSMoveEventFunction;


function endMSMoveEventFunction(e) {
    tx=0;
    ty=0;
    sx=0;
    sy=0;
    isMouseDown=0;
    setTimeout(function() { isScrMoving=0; },300);
}

function moveMSEventFunction(e) {
    var ox,oy,tmp;

    if (isMouseDown==1) {
            isScrMoving=1;
            var evt = window.event || e;

            mapScreenMove(evt.clientX,evt.clientY);
    }
    return false;
}

var dura=0;
function mapScreenMove(mx,my)  {
    var td = new Date().getTime()-dura;
    if(td < scr_scroll_speed)
       return false;

    dura = new Date().getTime();

    var ox,oy,tmp;
    if(sx==0 && sy==0) {
        sx=mx;
        sy=my;
    } else {
        ox=mx-sx;
        oy=my-sy;

        //get canvas background postion
        var ps = $('#canvas').css('backgroundPosition');
        var ps_x = parseInt(ps.split(" ")[0]);
        var ps_y = parseInt(ps.split(" ")[1]);

        //compare horizon and vectical movement,if the horizon movement > vectical movement then only handle horizon.
        var or = Math.abs(ox)-Math.abs(oy);

        //notice: 64 is the width of the basic grid, 30 is the height of basic grid. shouldn't be changed.
        var hv;
        if(or>0)  {
           if(ox>0) {
              hv = half_bg_width + 64;
              //if(hv<bg_width) {
                 half_bg_width += 64;
                 ps_x += 64;
              //}
           } else {
              hv = half_bg_width - 64;
              //if(hv>0) {
                  half_bg_width -= 64;
                  ps_x -= 64;
              //}
          }
        }

        if(or<0)  {
          if(oy<0) {
              hv = screen_height_offset + 30;
              //if(hv<bg_height) {
                 screen_height_offset +=30;
                 ps_y -= 30;
              //}
          } else {
              hv = screen_height_offset - 30;
              //if(hv>-bg_height) {
                 screen_height_offset -=30;
                 ps_y += 30;
              //}
          }
       }

       //move the background according to the offset.
       ps_x = ps_x + "px";
       ps_y = ps_y + "px";
       var ss= ps_x +" "+ ps_y;
       $('#canvas').css('backgroundPosition',ss);

       //move items
       ix = half_bg_width - tile_width/2;
       iy = 0 - screen_height_offset;
       ca.setMap(ix,iy);
       ca.mapReload();
    }
}

<!--  End of Screen Moving Control for both Safari Mobile and WEB  -->
















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
         $("#chatimg").attr("src","res/icons/his_close.png");
     }
     else {
         $("#historyDiv").css("display","none");
         $("#chatimg").attr("src","res/icons/his_open.png");
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


var repeat=0;
function scrollScr(spx,spy)  {
     if(isScrMoving==1)
        return;
     repeat++;

     var ps = $('#canvas').css('backgroundPosition');
     var ps_x = parseInt(ps.split(" ")[0]);
     var ps_y = parseInt(ps.split(" ")[1]);

     if(spy<64)  {
        screen_height_offset -=60;
         ps_y += 60;
     } else if(spy>450)  {
        screen_height_offset +=60;
         ps_y -= 60;
     }

     if(spx<92) {
        half_bg_width += 64;
        ps_x += 64;
     } else if(spx>920)  {
        half_bg_width -= 64;
        ps_x -= 64;
     }

     ix = half_bg_width - tile_width/2;
     iy = 0 - screen_height_offset;

//$("#sayText").val("nn:ix:"+ ix);


     ca.setMap(ix,iy);
     ca.mapReload();

     ps_x = ps_x + "px";
     ps_y = ps_y + "px";
     var ss= ps_x +" "+ ps_y;
     $('#canvas').css('backgroundPosition',ss);

     if(repeat <2)
          setTimeout(function() { scrollScr(spx,spy); },300);

}

function relocateSaydiv()  {
     if(!isIPhone)
        return;

     var win_left=0;
     var win_top=0;

     if(isIE) {
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

     var s_left=parseInt(htmlPosStrToNumber($("#historyDiv").css("left")));
     var s_top=parseInt(htmlPosStrToNumber($("#historyDiv").css("top")));

     if(win_top==0) {
         s_top = 150;
     } else  {
         s_top = win_top;
     }

     if(win_left==0) {
         s_left = 6;
     } else  {
         s_left = win_left+3;
     }

     $("#historyDiv").css("left",s_left);
     $("#historyDiv").css("top",s_top);

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
    var hmIniStr = ">>"+clothfrm.getIniStr().replace(/\|/g, "-");
    hmIniStr = hmIniStr.replace(/:/g, "~");

    var fr = user;
    var to="";

/*
    $.ajax({type:"GET", url:"sendChatMsg.php?from="+fr+"&to="+to+"&content="+hmIniStr, dataType:"text",async:false,success:function (msg){

   	}});
*/

     var sendStr=hmIniStr;
     s1.socket.emit("cloth", sendStr);

     hm = new human(hm.orient,clothfrm.getIniStr());
     hm.animator(anistr);
     mainsprite.setHuman(hm);
}

//根据???整canvas方向
//由于??不全，?在做法?将html和脚本中中canvas的?高都固定。
//最后解决方案???，?不同方向制定不同的?高?定，否?将物体?制在屏幕?示不出来的canvas位置上造成浪?
//具体方法可能?，1，利用css?配将canvas，2，利用下面脚本?定相?参数
function ajustOrientation() {
           var orientation = window.orientation;

           if(orientation == 0) {
              cb_canvas.width=630;
              cb_canvas.height=980;
              m_canvas.width=630;
              m_canvas.height=980;
              bg_width=630;
              bg_height=980;
           } else  {
              cb_canvas.width=980;
              cb_canvas.height=630;
              m_canvas.width=980;
              m_canvas.height=630;
              bg_width=980;
              bg_height=630;
           }

           //bg_height=1024;
           ca.mapReload();
           window.setTimeout(function() { window.top.scrollTo(0,1);relocateSaydiv();} , 100);
}

</script>


</html>
