<?php
header("content-type:text/html; charset=utf-8");

$roomid = $_GET["room"];
$roomTab = "pol_pos_room".$roomid;

if(isset($_GET["hideBg"]))
    $hideBg = $_GET["hideBg"];
else
    $hideBg = 1;

require_once("config.php");
require_once("map_info.php");

$mp = new map_info($roomid);
$this_scene =  $mp->getRoomSce();

require_once("sceneTemplate.php");

$viewport_scale="0.5";
$menuboxdispposoffset=80;
if(mobile_user_agent_switch()=="iphone") {
    $viewport_scale="0.5";
} else if(mobile_user_agent_switch()=="ipad") {
    $viewport_scale="1.0";
    $menuboxdispposoffset=200;
}

$link=mysql_connect ($host, $db_user, $db_password);
mysql_select_db($database,$link);

$puser = "MapEdit";

function getUserInfo($user,&$roomID) {
    $sql = "SELECT ownnerRoom FROM pol_user WHERE pol_user.username = '$user'";

    $query=@mysql_query($sql);

    if(!$query)
        exit;

    $result=mysql_fetch_array($query);

    $roomID = $result[0];
}

function getUserItemsInfo($itemID,&$sub_items_str,&$loc_str,&$imgoff_str)   {
    $sql = "SELECT sub_items,loc,imgoff FROM pol_items WHERE id = '$itemID'";

    $query=@mysql_query($sql);

    if(!$query)
        exit;

    $result=mysql_fetch_array($query);

    $imgoff_str=$result["imgoff"];
    $loc_str=$result["loc"];

    if(!$result["sub_items"])  {
       $sub_items_str=$itemID;
    } else {
       $val = preg_replace('/(.png)/', "", $result["sub_items"]);
       $sub_items_str=substr($val,0,-2);
    }
}

function getFitImgSize(&$ret_w,&$ret_h) {
   $size=96;
   if($ret_w<=$size && $ret_h <=$size) {
       $ret_w=$ret_w;
       $ret_h=$ret_h;
   }
   else if($ret_w>$ret_h) {
      $ret_h=intval(($size*$ret_h) / $ret_w);
       $ret_w=$size;
   } else {
       $ret_w=intval(($size*$ret_w) / $ret_h);
       $ret_h=$size;
   }
}


$roomID=-1;
//getUserInfo($puser,$roomID);

if($_GET["room"])
   $roomID=$_GET["room"];


//$canvasBg = "ss3.jpg";
//$canvasBg = "bg_room".$roomID . ".png";

?>
<html>
<http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=<?php echo $viewport_scale?>,minimum-scale=<?php echo $viewport_scale?>,maximum-scale=<?php echo $viewport_scale?>">
<meta name="apple-mobile-web-app-capable" content="yes" />
<head>
<title><?php echo $puser?>のMYO Space</title>

<style type="text/css">
body {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        margin-top: 0px;
        margin-left: 0px;
}

.menubox {
         position:absolute;
    	 width: 360px;
	     height: 65px;
	     left: 10px;
	     top: 112px;
	     text-align:center;
         -moz-border-radius: 20px;   /* firefox */
         border-radius: 20px;        /* CSS3 */
         padding: 5px 5px;
         background-color:#e0e0e0;
         z-index:9999;
}

.boxshow {
    	 width: 50px;
	     height: 50px;
	     text-align:center;
	     margin:0 auto;
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
</style>

<link rel="stylesheet" href="jquery-ui-1.8.11/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/demos/demos.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/slider.css">


<script language="javascript">
// A002 should be the same as map_all array size.  ??????????
var map_arr_width = <?php echo $map_arr_width?>;
var map_arr_height = <?php echo $map_arr_height?>;
var act_type = "edit1";
</script>

<script src="jquery-ui-1.8.11/jquery-1.6.2.min.js"></script>
<script src="jquery-ui-1.8.11/jquery.touchSlider_design.js"></script>

<script src="./sfqdeploy/map_min.js"></script>

<script src="jquery-ui-1.8.11/external/jquery.bgiframe-2.1.2.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.core.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.widget.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.mouse.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.draggable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.position.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.resizable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.dialog.js"></script>
<script src="browserDetect.js" type="text/javascript"></script>

<script type="text/javascript">
    var hideBg = <?php echo $hideBg?>;

    var itemStartX = <?php echo $itemStartX?>;
    var itemStartY = <?php echo $itemStartY?>;

	$(document).ready(function(){
		$('#gallery1').touchSlider({
			mode: 'shift',
			prevLink: 'a.prev',
            <?if(!$isIPhone)  {
              echo "touch:false,";
            }?>
            nextLink: 'a.next'
		});
	});

    /*
      用以判断items slider上用?的?作是否??某个item,?是滑?以??所有items
      1.当??到slider上有touch行?，?将?志??1，然后在200ms后?行??物品的方法
      2.如果用?放?了touch，?将?志清空。
      3.如果在200ms以内，用??没有放?touch???是用???了?item
    */
    var setCnt=0;
    var lastX=0,lastY=0;
    function setS(sid,imgstr,itemstr,locstr) {
	   setCnt=1;
       setTimeout(function(){ setSelectedItem_sa(sid,imgstr,itemstr,locstr); }, 200);
    }

    //如果用?放?touch, 将?志??0，且物品已?被??，??行将物品定位操作。
    function setE(e) {
/*
       e=e || window.event;
       var gl_w=parseInt($("#gl").css("width"));
       var gl_h=parseInt($("#gl").css("height"));
       var gl_l=parseInt($("#gl").css("left"));
       var gl_t=parseInt($("#gl").css("top"));

       var is_in_gl=0;
       if(p.x<(gl_w+gl_l) && p.y<(gl_t+gl_h) && p.y>gl_t)
            is_in_gl=1;

       console.log(gl_w +":"+ gl_h +":"+ gl_l +":"+ gl_t);
       console.log("is in gl:"+is_in_gl);
*/

	   setCnt=0;
	   if(sd.ob !=null)
          endSelectedItem();
    }

    //如果在200ms后?行的?方法判断到?志仍?1，??明用?按住?item超?了200ms,???用???了?item.
    function setSelectedItem_sa(imgcode,off,sub_item,sub_loc)  {
       if(setCnt==1)  {
          commandCtl._setCmd("add")
          sid=getuuid();
          var ob=CR_item(imgcode,0,0,0,sid,off,sub_item,sub_loc);
          $(ob).draggable();
          sd.clear();
          sd.set(ob,imgcode);
          imgMV=sid;
          temp_imgCode=imgcode;

          $("#lay0").append(ob);
          moveCtrl(0,sd);
       }
    }

    //?web版本用的，无touch功能，?了整合将代?放touch一起。draggalbe中的js代?被修改了需要注意。
    function setSelectedItem_web(imgcode,off,sub_item,sub_loc)  {
       commandCtl._setCmd("add")
       sid=getuuid();
       var ob=CR_item(imgcode,0,0,0,sid,off,sub_item,sub_loc);
       $(ob).draggable();

       imgMV=sid;
       $("#lay0").append(ob);
    }


    function endSelectedItem()  {
       var ob=sd.ob;
       var obx,oby;
       obx = parseInt(ob.style.left);
       oby = parseInt(ob.style.top);
       obh = parseInt(ob.height);

       //如果?片位置在屏幕左上初始位置，或者?片在slider?度范?内，?将生成的?片?除。
       if((obx<=0 && oby<=0) || (oby+obh)<100)  {
          ob.style.display="none";
          sd.clear();
          imgMV =0;
          return;
       }

       if(isDrag==1) {
          ob.style.opacity=1.0;
          setMapAct();
          isDrag =0;
       }
       if(commandCtl._getCmd()=="add") {
          commandCtl._setCmd("move");
          focusMoveIcon();
       }
    }


</script>

<?php
$mp = new map_info($roomID);
$mp->outPutMap();
?>

<script>
var isBrowser=false;
var isSafari=false;
var canvas_offx = 0;
var canvas_offy = 0;
var scr_scroll_speed = 40;

var deviceW0 = <?echo $deviceW0?>;
var deviceH0 = <?echo $deviceH0?>;
var deviceW1 = <?echo $deviceW1?>;
var deviceH1 = <?echo $deviceH1?>;

//alert(BrowserDetect.browser);

if(BrowserDetect.browser=="Explorer")  {
   isBrowser=true;
} else if(BrowserDetect.browser=="IPhone" || BrowserDetect.browser=="Safari")  {
   isSafari=true;
}

<?
if($isIPhone)  {
   echo "isSafari=true;";
} else {
   echo "isBrowser=true;";
}
?>


var sData=function(){
  this.ob=null;
  this.imgHead=0;
}

sData.prototype={
  clear:function() {
     this.ob=null;
     this.imgHead=0;
  },

  set:function(ob,hid) {
     this.ob=ob;
     this.imgHead=hid;
  }
}

var sd=new sData();

// ??? A001?????????????????????
// ??? A002?????????????????????
var map_all_update = Array();
for(var i=0;i<map_all.length;i++) {
      map_all_update[i] = map_all[i];
}

var roomRes = new ResLoad();
roomRes.map_res_load(map_all,1);  //??Y??data load?????

var user = "<?php echo $puser?>";

//should be the same as div parameters.
var bg_width = 1024;
var half_bg_width = <?php echo $itemStartX?>;
var bg_height = 512;

//A001 tile img size  ????Y????????????????
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

var screen_height_offset_times = 8;
//var screen_height_offset = -21 * screen_height_offset_times;
var screen_height_offset = <?php echo $itemStartY?>;

var main_map_id = 2;

// A002 should be the same as map_all array size.  ??????????

var ix = half_bg_width - tile_width/2;
var iy = 0 - screen_height_offset;


var imgMV=0;
var imgMVIndex=0;


var isDrag =0;
var temp_map_all_update;
var temp_imgMVIndex,temp_zIndex,temp_posX,temp_posY,temp_imgCode;
var count=0;



</script>
</head>

<body  onload="startChat()" style="overflow:hidden;background-color:#666666" onorientationchange="ajustOrientation();">

<div  id="map" style="display:none;overflow:hidden;border: 0px solid #000;width:<?php echo $canvas_width?>px; height:<?php echo $canvas_height?>px; left:0; top:0; position:absolute; background:url(<?php echo $canvasBg?>) no-repeat;background-position:<?php echo $bgImgPosX?>px <?php echo $bgImgPosY?>px;-webkit-background-size:<?php echo $bg_width."px"?> <?php echo $bg_height."px"?>">
     <div id="lay0" style="z-index:0">
         <!--<input type=text id="sss" style="position:absolute;left:500px;top:200px">-->
     </div>

     <div id="gallery-holder" title="gallery-holder" style="position:absolute;top:0px;left:5px;width:100%;z-index:9999">
         	<div class="gallery" id="gallery1">
         		<div class="holder">
         			<div id="items" class="list" style="display:none">
              <?php
              $sub_items_str="";
              $loc_str="";
              $imgoff_str="";

              $useritems = explode(",",$mp->getFinalItemArr($roomID));
              for($i=0;$i<count($useritems);$i++)  {
                  $itemID=$useritems[$i];
                  getUserItemsInfo($itemID,$sub_items_str,$loc_str,$imgoff_str);

                  $tar_img_file="res/mapRes/up/".$itemID."/".$itemID.".png";

                  list($width, $height, $type, $attr) = getimagesize($tar_img_file);

                  getFitImgSize($width,$height);

                  if($isIPhone)
                      echo "<div class='item'><div class='box box1'><img id='".$itemID."' src='".$tar_img_file."' style='width:$width;height:$height' ontouchend=setE(event) ontouchstart=setS(this.id,".$imgoff_str.",'".$sub_items_str."','".$loc_str."')></div></div>";
                  else
                      echo "<div class='item'><div class='box box1'><img id='".$itemID."' src='".$tar_img_file."' style='width:$width;height:$height' onclick=setSelectedItem_web(this.id,".$imgoff_str.",'".$sub_items_str."','".$loc_str."')></div></div>";
              }
              ?>

                    </div>
		        </div>

		        <?if(!$isIPhone)  {
                   echo "<a id='pre_but' href='#' class='prev'>Prev</a><a id='next_but' href='#' class='next'>Next</a>";
                }?>
	         </div>
     </div>

</div>

<!--<div id="control" style="position:absolute;left:10px;top:45px;z-index:9999"></div>-->

<!--
<div id="save" style="position:absolute;left:10px;top:145px;z-index:9999">
   <input type=button id='saveCtrl' value='save' style='width:96px;height:96px;z-index:9999'>
</div>

<div id="add" style="position:absolute;left:10px;top:245px;z-index:9999">
   <input type=button id='addCtrl' value='add' style='width:96px;height:96px;z-index:9999'>
</div>

<div id="del" style="position:absolute;left:10px;top:345px;z-index:9999">
   <input type=button id='delCtrl' value='del' style='width:96px;height:96px;z-index:9999'>
</div>

<div id="item" style="position:absolute;left:10px;top:445px;z-index:9999">
   <input type=button id='itemCtrl' value='item' style='width:96px;height:96px;z-index:9999'>
</div>
-->

<div id="returnCtrl"  style="position:absolute;left:6px;top:35px;z-index:9000"><img src="./res/icons/return.png"></div>


<div class="menubox">
     <table border=0>
     <tr>
        <td><div id="moveCtrl"  class="boxshow"><img src="./res/icons/move.png"></div></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><div id="addCtrl"  class="boxhide"><img src="./res/icons/clone1.png"></div></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><div id="delCtrl"  class="boxhide"><img src="./res/icons/remove.png"></div></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><div id="itemCtrl"  class="boxhide"><img src="./res/icons/tools.png"></div></td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;</td>
        <td><div id="saveCtrl"  class="boxhide"><img src="./res/icons/save.png"></div></td>
     <tr>
     </table>
</div>



<div id="dialog-saved" title="Confirm" style="z-index:1">
	<p><div id="saveText"></div></p>
</div>

<div id="dialog-dele" title="Confirm" style="z-index:1;display:none">
	<p><div id="delConfirmText">Are you sure to delete this item?</div></p>
</div>

<div id="startDiv" style="z-index:9999;left:500px;top:200px;position: absolute">
    <a id="startBut" href="#" onclick="startChat()"><img src="./res/icons/start.png"></a>
</div>

<!--<input id="info" type=text style="position:absolute;z-index:9999">-->

</body>
</html>


<script language="javascript">

var target_pos=0;
var commandCtl = {
	_cmd : 'move',

	_setCmd : function(_c){
		commandCtl._cmd = _c;
	},

	_getCmd : function(){
        return commandCtl._cmd;
	}
}


function startChat() {
   hidePreNext();
   ajustOrientation();

   var cpx = parseInt($('#map').css("left")) + canvas_offx + "px";
   var cpy = parseInt($('#map').css("top")) + canvas_offy + "px";

   $('#map').css("left",cpx);
   $('#map').css("top",cpy);

   drawMap(ix,iy);
   mapReload();


   if(!isSafari) {
       // for web
      (function(){

         document.getElementById('map').onmousemove=function(e){
            if(imgMV==0)  {
//            if(imgMV==0 && map_arr_width > 12)  {
               moveMSEventFunction(e);
               return false;
            }
            e=e || window.event;
            var mousex = e.clientX - canvas_offx - m_offx;
            var mousey = e.clientY-0 - canvas_offy  + itemStartY - m_offy;
            target_pos = getPointInRhombus(mousex,mousey);

            var pa = loc2pos(target_pos-1);
            setTargetSign(pa[0]+m_offx,pa[1]+m_offy,target_pos,e);
         }


         //  本来?方法是放在?片上的，但是由于在移??程中，有可能焦点从?片?失，因此将?方法放在map上。
         //  意??，用?在?片上点?，触?onmousedown，然后将相?参数保存，在map上判断如果用?松?了鼠?，??行
         //  以下方法，将数据写入?形更新数?。
         document.getElementById('map').onmouseup = function(e) {
            isMouseDown=0;

            if(imgMV==0)  {
//            if(imgMV==0 && map_arr_width > 12)  {
               endMSMoveEventFunction(e);
               return;
            }
            setMapAct();
            if(commandCtl._getCmd()=="add")  {
               commandCtl._setCmd("move");
               focusMoveIcon();
            }
         }


      })();

   } else {

      //for safari iphone
      (function(){
         document.getElementById('map').ontouchmove = function(e){
             e.preventDefault();
             if(imgMV==0)  {
//             if(imgMV==0 && map_arr_width > 12)  {
                moveEventFunction(e);
                return false;
             }
             isDrag =1;
             if(e.touches) {
                 var p = getCoords(e.touches[0]);
                 p.x = p.x - canvas_offx -  m_offx;
                 p.y = p.y - canvas_offy + itemStartY - m_offy;
                 //lastX = p.x;
                 //lastY = p.y;
                 target_pos = getPointInRhombus(p.x,p.y-0);
                 var pa = loc2pos(target_pos-1);
                 setTargetSign(pa[0]+m_offx,pa[1]+m_offy,target_pos,e);
                 //console.log(pa[0]+m_offx +":"+ pa[1]+m_offy);
             }
             return false;
         }
      })();
   }

   $("#startDiv").css("display","none");
   //parent.showCtrl();
   setCtrlButton();
   //parent.setOrient();

   $("#addCtrl").click(function() {
         isMouseDown=0;
         $("#items").css("display","none");
         commandCtl._setCmd("col");
         hidePreNext();
   });

   $("#itemCtrl").click(function() {
         isMouseDown=0;
         $("gallery1").css("display","");
         $("#items").css("display","");
         commandCtl._setCmd("move");
         showPreNext();
   });

   $("#delCtrl").click(function() {
         isMouseDown=0;
         $("#items").css("display","none");
         commandCtl._setCmd("del");
          hidePreNext();
   });

   $("#moveCtrl").click(function() {
         isMouseDown=0;
         $("#items").css("display","none");
         commandCtl._setCmd("move");
         focusMoveIcon();
         hidePreNext();
   });

   $("#map").css("display","");

}

function showPreNext()  {
   $("#pre_but").css("display","");
   $("#next_but").css("display","");
}

function hidePreNext()  {
   $("#pre_but").css("display","none");
   $("#next_but").css("display","none");
}

function setCtrlButton()  {
/*
   var msg = "<input type=button id='buttonCtrl' value='move' style='width:96px;height:96px;z-index:9999'>";
   $("#control").html(msg);
   commandCtl._setCmd("move");
   document.getElementById("buttonCtrl").onclick=function(e){
     if(this.value=="move")  {
         $("#items").css("display","none");
         this.value="col";
         commandCtl._setCmd("col");
     }
     else if(this.value=="col")  {
         $("#items").css("display","none");
         this.value="del";
         commandCtl._setCmd("del");
     }
     else if(this.value=="del")  {
         $("#items").css("display","none");
         this.value="item";
         commandCtl._setCmd("item");
     }
     else if(this.value=="item")  {
         $("#items").css("display","");
         this.value="move";
         commandCtl._setCmd("move");
     }
   }
*/
   document.getElementById("saveCtrl").onclick=function(e){
     save("aaa");
   }

}



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
        return {x:e.pageX,y:e.pageY};
    }
}


function moveCtrl(flag,sd) {
    var ob=sd.ob;

    //如果mousedown被点?，且不是在移??程中，?将当前的位置信息??下来，以便在物体移?到非法位置以后，恢??示以及地?数?数据
    if(flag==0) {
      isDrag=1;   //????????touch?????release???isdrag=1???????touchend??????????????????????touchend慮????????????
      imgMV=ob.id;
      temp_imgMVIndex = imgMVIndex;

      temp_posX=ob.style.left;
      temp_posY=ob.style.top;
      temp_zIndex=ob.style.zIndex;

      temp_map_all_update = [];
      for(var i=0;i<map_all_update.length;i++) {
         temp_map_all_update[i] = map_all_update[i];
      }
    }

    //物体在被move的?候才清除当前的地?数据，如果在colone的?候清除了，那?就会把被colone的物体清除。
    if(commandCtl._getCmd()=="move") {
        //点到?物体?候,将?物体代表的数?从地?数?清除掉,如果清除失?，?可能是用?点鼠?超?了?界，
        //然后返回的?候点了鼠?，??的点?由于不是??点?，因此必?把地?数据提交。
        if(!clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead])) {
           setMapAct();
        }
    }
}


function delCtrl(flag,sd) {
    var ob=sd.ob;

/*
    $( "#dialog-dele" ).dialog({
	    width: 420,
		height: 120,
		modal: true,
		buttons: {
				"Ok": function() {
                       clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead]);
                       ob.style.display="none";  //should be better if removed from lay0
                       $(this).dialog("close");
                 },
				 "Cancel": function() {
                       $(this).dialog("close");
                       ob.style.opacity=1.0;
                 }
	    }
	});
*/

//    if(confirm("削除しますか。")) {
        isMouseDown=0;
        clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead]);
        ob.style.display="none";  //should be better if removed from lay0
//    } else {
//        isMouseDown=0;
//        ob.style.opacity=1.0;
//    }

    imgMV=0;
    commandCtl._setCmd("move");
    focusMoveIcon();
}


function colCtrl(flag,sd) {
    var ob=sd.ob;
    var ic=sd.imgHead;
    var sid=getuuid();
    var ppx=parseInt(ob.style.left);
    var ppy=parseInt(ob.style.top);

//    var item=CR_item(sd.imgHead,ppx,ppy,ob.pos,sid,wholeImgOff[sd.imgHead],sub_items[sd.imgHead],sub_locs[sd.imgHead]);
    var item=CR_item(sd.imgHead,ppx,ppy,0,sid,wholeImgOff[sd.imgHead],sub_items[sd.imgHead],sub_locs[sd.imgHead]);


    $(item).draggable();

//alert(sd.imgHead +":"+ ppx +":"+ ppy +":"+ 0 +":"+ sid,wholeImgOff[sd.imgHead] +":"+ sub_items[sd.imgHead] +":"+ sub_locs[sd.imgHead]);

//    imgMV=item.id;
    $("#lay0").append(item);
    sd.clear();
    sd.set(item,ic);

    moveCtrl(0,sd);
    focusMoveIcon();
}


function setMapAct()  {
   var ob=sd.ob;
   if(ob==null)
      return;

   ob.style.zIndex=imgMVIndex;

//alert(imgMVIndex);

   if(setTargetMap(ob.style.zIndex,sub_locs[sd.imgHead],sub_items[sd.imgHead]))   {
      var ic = temp_imgCode.split("_")[0];
      map_enditem[ic] = map_enditem[ic] +","+imgMVIndex;
   } else if(commandCtl._getCmd()=="col" || commandCtl._getCmd()=="add") {
      ob.style.display="none";
   } else {
      ob.style.left=temp_posX;
      ob.style.top=temp_posY;
      ob.style.zIndex=temp_zIndex;
      ob.style.opacity=1.0;
      imgMVIndex = temp_imgMVIndex;
      map_all_update = [];
      for(var i=0;i<temp_map_all_update.length;i++) {
          map_all_update[i] = temp_map_all_update[i];
      }
   }
   imgMV=0;
   sd.clear();
   commandCtl._setCmd("move");
}


function setTargetSign(px,py,idx,e) {
   var event = e||window.event;

   if(idx==-1)
      return;

   if(imgMV==0) {
       //document.getElementById('target_sign').style.left=px+"px";
       //document.getElementById('target_sign').style.top=(py-screen_height_offset)+"px";
       //document.getElementById('target_sign').pos = idx;
       //document.getElementById('target_sign').style.zIndex=9999;
   } else {
       //document.getElementById('target_sign').style.left=px+"px";
       //document.getElementById('target_sign').style.top=(py-screen_height_offset)+"px";


       var iv=document.getElementById(imgMV);
       var imgCode;

//console.log(imgMV+":"+$("#"+imgMV).attr("imgCode"));

/*
       if(iv.id.split("-").length>0)  {
           imgCode=iv.id;
           px = px - parseInt(iv.off);
       } else if(iv.pos !== void(0) && iv.id!==0) {   //map current items
           imgCode=map_all[iv.pos];
       } else  {    // the set items
           imgCode=iv.id;
           px = px - parseInt(iv.off);
       }
*/

/*
       if(iv.id.split("-").length>1)  {
           imgCode=iv.id;
           px = px - parseInt(iv.off);
       } else  {   //map current items
           imgCode=map_all[iv.pos];
       }
*/

imgCode = $("#"+imgMV).attr("imgCode");

//$("#info").val(iv.id.split("-").length +":"+ px+":"+py);

       var r=imgCode.split("_");


/*
       if(r.length==1) {  // if not the splited image, use offset.
           px = px - getItemOffset(r[0]);
       } else {
           px = px - img_offset[imgCode];
       }
*/

           px = px - img_offset[imgCode];

console.log(px +":"+ py);


       px = px;
       py = py+tile_height-iv.height-screen_height_offset;


       iv.style.left=px+"px";
       iv.style.top=py+"px";
       iv.style.zIndex=9999;
       iv.style.display="";

       imgMVIndex=idx;

       //alert(idx);

       //tx=px;
	   //ty=py;
	   //iw=parseInt(iv.width);
	   //ih=parseInt(iv.height);

	   //tx1=tx+iw;
	   //ty1=ty+ih;
       //createRect(tx,ty,tx1,ty1,"point.jpg");
   }
}


function save(adcode) {
//     alert(map_all_update);
       $.ajax({type:"GET", url:"info.php?adcode="+"nevin.ug206"+"&roomID=<?php echo $roomID?>&info="+map_all_update.toString(), dataType:"text",async:false,success:function (msg){
         		//alert(msg);
                alert("マップを保存しました。");

/*
         		$("#saveText").html(msg);
         		$( "#dialog-saved" ).dialog({
				    width: 420,
					height: 120,
					modal: true,
					buttons: {
							"Ok": function() {
					 			        $(this).dialog("close");
							          }
			        }
		        });
*/
       }});

   //window.open("info.php?roomID=<?php echo $roomID?>&info="+map_all_update.toString());
   //$("#info").val(map_all);
}

/*
function doesTouch() {
    try
    {
        // if we can make touch events return true
        document.createEvent("TouchEvent");
        return true;
    }  catch(e) {
        return false;
    }
}
*/

function doesTouch(){
                //if(e.keyCode != 13){
                //    return;
                //}
                var fireOnThis = document.getElementById('map');
                if (document.createEvent)
                {
                    var evObj = document.createEvent('TouchEvent');
                    evObj.initEvent( 'touch', true, false );
                    fireOnThis.dispatchEvent(evObj);
                }
                else if (document.createEventObject)
                {
                       fireOnThis.fireEvent('ontouch');
                }
}

function ajustOrientation() {
           var orientation = window.orientation;
           var lw0,lh0,lw1,lh1;

           lw = getWidth()-10;                        //10 is the double border width
           lh = getHeight() + 120;                    //100 is the navigate bar of IOS. if android should be some other value.

           if(orientation == null)
                lh -= 100;

           var sw;
           if(orientation == 0) {
              if(lw > lh) {
                  sw=lw;
                  lw=lh;
                  lh=sw-40;
              }

              $('#map').css("width", lw + "px");
              $('#map').css("height", lh + "px");
              $('#gallery-holder').css("left","-2px");
              $(".menubox").css("left","6px");
              $(".menubox").css("top",(lh-<?php echo $menuboxdispposoffset?>)+"px");

           } else  {
              if(lw < lh) {
                  sw=lw;
                  lw=lh;
                  lh=sw-40;
              }

              $('#map').css("width",lw + "px");
              $('#map').css("height",lh+ "px");
              $('#gallery-holder').css("left","-2px");
              $(".menubox").css("left","6px");
              $(".menubox").css("top",(lh-<?php echo $menuboxdispposoffset?>)+"px");
           }

           //drawMap(ix,iy);
           //mapReload();
           window.setTimeout(function() { window.top.scrollTo(0,1);} , 100);
}


function ajustOrientation_old() {
           var orientation = window.orientation;
           var lw0,lh0,lw1,lh1;

           lw0 = deviceW0;
           lh0 = deviceH0;
           lw1 = deviceW1;
           lh1 = deviceH1;

           var mi;
           if(lw0<lh0)  {
              mi = lw0;
              lw0 = lh0;
              lh0 = mi;
           }

           if(lw1<lh1)  {
              mi = lw1;
              lw1 = lh1;
              lh1 = mi;
           }

           if(orientation == 0) {
              $('#map').css("width", lh0 + "px");
              $('#map').css("height", lw0 + "px");
              $('#gallery-holder').css("left","-2px");
              $('#gallery-holder').css("width","660px");
           } else  {
              $('#map').css("width",lw1 + "px");
              $('#map').css("height",lh1+ "px");
              $('#gallery-holder').css("left","-2px");
              $('#gallery-holder').css("width","960px");
           }

           drawMap(ix,iy); mapReload();
           window.setTimeout(function() { window.top.scrollTo(0,1);} , 100);
}

function focusMoveIcon()  {
   $(".boxhide").removeClass("boxshow");
   $(".boxshow").removeClass("boxshow");
   $("#moveCtrl").addClass("boxshow");
}


document.getElementById('map').onmousedown = m_down;
document.getElementById('map').onmouseout = endMSMoveEventFunction;
document.getElementById('map').ontouchend = endMoveEventFunction;


$('body').disableSelection();

$(".boxhide").click(function() {
   $(".boxhide").removeClass("boxshow");
   $(".boxshow").removeClass("boxshow");
   $(this).addClass("boxshow");
})

$(".boxshow").click(function() {
   $(".boxhide").removeClass("boxshow");
   $(".boxshow").removeClass("boxshow");
   $(this).addClass("boxshow");
})

$("#returnCtrl").click(function() {
     history.go(-1);
})
</script>