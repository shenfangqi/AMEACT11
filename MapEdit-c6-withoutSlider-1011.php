<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");
require_once("map_info.php");

$isIPhone=true;
if(!strpos($_SERVER["HTTP_USER_AGENT"],"iPhone"))
   $isIPhone=false;


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
   $size=63;
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
getUserInfo($puser,$roomID);

if($_GET["room"])
   $roomID=$_GET["room"];


$canvasBg = "ss2.jpg";
//$canvasBg = "bg_room".$roomID . ".png";

?>
<html>
< http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5,maximum-scale=0.5">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<head>
<title><?php echo $puser?></title>

<style type="text/css">
	img { border:0 }
	a { color:#c00 }
	#news { text-align:left; margin:auto; padding-top:150px; width:728px; }
	.clear { clear:both }
	.share-button {margin:auto; background:#fff; padding:0px 0px;width:1px;

	}
	.share-button:hover{ background:#fff }
	.orbit { background-color:rgba(0,0,0,0.4); border:2px solid #888;
	border-radius:200px; -moz-border-radius:200px;  -webkit-border-radius:200px;  }
	.orbit a:hover { background:rgba(255,255,255,0.6); }
	.orbit a { padding:8px;
		border-radius:32px; -moz-border-radius:32px; -webkit-border-radius:32px;
    }

    .btn   {
      BORDER-RIGHT:   #7b9ebd   1px   solid;   PADDING-RIGHT:   2px;   BORDER-TOP:   #7b9ebd   1px   solid;   PADDING-LEFT:   2px;   FONT-SIZE:   12px;   FILTER:   progid:DXImageTransform.Microsoft.Gradient(GradientType=0,   StartColorStr=#ffffff,   EndColorStr=#cecfde);   BORDER-LEFT:   #7b9ebd   1px   solid;   CURSOR:   hand;   COLOR:   black;   PADDING-TOP:   2px;   BORDER-BOTTOM:   #7b9ebd   1px   solid
    }

</style>

<link rel="stylesheet" href="jquery-ui-1.8.11/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/demos/demos.css">

<script src="utility.js"></script>
<script src="jquery-ui-1.8.11/jquery-1.5.1.js"></script>
<script src="custom.js" type="text/javascript"></script>
<script src="aStar1.js" type="text/javascript" ></script>
<script src="ResLoad.js" type="text/javascript"></script>
<script src="mapBuilder.js" type="text/javascript"></script>
<script src="lib/jquery.jorbital.js" type="text/javascript" ></script>

<script src="jquery-ui-1.8.11/external/jquery.bgiframe-2.1.2.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.core.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.widget.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.mouse.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.draggable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.position.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.resizable.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.dialog.js"></script>
<script src="browserDetect.js" type="text/javascript"></script>

<?php
$mp = new map_info($roomID);
$mp->outPutMap();
?>

<script>
var isIE=false;
var isSafari=false;

if(BrowserDetect.browser=="Explorer")  {
   isIE=true;
}
else if(BrowserDetect.browser=="Safari")  {
   isSafari=true;
}


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
//alert(c1.imgid);
//c1.set("59","33");
//alert(c1.imgid);
//c1.clear();
//alert(c1.imgid);



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
var half_bg_width = 512;
var bg_height = 512;

//A001 tile img size  ????Y????????????????
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

var screen_height_offset_times = 8;
var screen_height_offset = 30 * screen_height_offset_times;

var main_map_id = 2;

// A002 should be the same as map_all array size.  ??????????
var map_arr_width = 32;
var map_arr_height = 32;

var ix = half_bg_width - tile_width/2;
var iy = 0 - screen_height_offset;


var imgMV=0;
var imgMVIndex=0;

function move(dir)  {
   var ps = $('#map').css('backgroundPosition');
   var ps_x = parseInt(ps.split(" ")[0]);
   var ps_y = parseInt(ps.split(" ")[1]);

   $("#lay0").empty();

   //img_obj = CR_consor("target",1,1,-1,"target_sign");
   //$("#lay0").append(target_obj);

   if(dir==0)  {
      screen_height_offset -=120;
      ps_y += 120;
   } else if(dir==1) {
      screen_height_offset +=120;
      ps_y -= 120;
   } else if(dir==2) {
      half_bg_width += 128;
      ps_x += 128;
   } else if(dir==3) {
      half_bg_width -= 128;
      ps_x -= 128;
   }
   //screen_height_offset = 30 * screen_height_offset_times;

   ix = half_bg_width - tile_width/2;
   iy = 0 - screen_height_offset;

   map_all = Array();
   for(var i=0;i<map_all_update.length;i++) {
         map_all[i] = map_all_update[i];
   }

   target_pos=0;
   drawMap(ix,iy);
   mapReload();

   ps_x = ps_x + "px";
   ps_y = ps_y + "px";
   var ss= ps_x +" "+ ps_y;
   $('#map').css('backgroundPosition',ss);
}


var isDrag =0;
var temp_map_all_update;
var temp_imgMVIndex,temp_zIndex,temp_posX,temp_posY,temp_imgCode;
var count=0;
function CR_baseTiles(imgCode,posX,posY,pos) {
   var a = document.createElement("IMG");
   a.pos = pos;
   a.setAttribute("id",pos);
   a.setAttribute("type","tile");

   //A001 ??????
   var r=imgCode.split("_");
   if(r.length==1)
     a.setAttribute("src","res/mapRes/up/"+imgCode+"/"+imgCode + ".png");
   else
     a.setAttribute("src","res/mapRes/up/"+r[0]+"/"+r[0]+".png");

   a.style.position="absolute";

   if(r.length==1) {
       posX = posX - getItemOffset(map_all[pos]);
   } else {
       //alert("b:"+img_offset[r[0]]);
       posX=posX-img_offset[r[0]];
   }

   a.style.left=posX;
   a.style.top=posY + tile_height - a.height;
   a.style.zIndex=pos;


   if(!isSafari) {


      // for web
      a.onmouseover = function()  {
         a.style.opacity=0.6;
      }

      a.onmouseout = function()  {
         a.style.opacity=1.0;
      }

      //该事件是为了禁止在页面拖动图片元素到iframe以外的话，会导致iframe内的内容往相反方向移动
      a.ondrag = function() {
         return false;
      }

      a.onmousedown = function() {
         sd.set(a,r[0]);
         var ob=sd.ob;
         ob.style.opacity=0.6;
         temp_imgCode=imgCode;

         if(commandCtl._getCmd()=="move")
             moveCtrl(imgMV,sd);
         else if(commandCtl._getCmd()=="del")
             delCtrl(imgMV,sd);
         else if(commandCtl._getCmd()=="col")
             colCtrl(imgMV,sd);
      }

   } else {


      //for safari iphone
      //这里需要注意的是，ontouchstart以后，开始ontouchmove以后，在放开touch,激活ontouchend的时候，
      //系统似乎又去调用了一次ontouchstart.
      a.ontouchstart = function(e)  {
         sd.set(a,r[0]);
         var ob=sd.ob;
         ob.style.opacity=0.6;
         temp_imgCode=imgCode;

         imgMV=ob.id;

         if(commandCtl._getCmd()=="move")
             moveCtrl(isDrag,sd);
         else if(commandCtl._getCmd()=="del") {
             isDrag=0;
             delCtrl(imgMV,sd);
         }
         else if(commandCtl._getCmd()=="col")
             colCtrl(imgMV,sd);
      }

      a.ontouchend = function(e)  {
         if(isDrag==1) {
            a.style.opacity=1.0;
            setMapAct();
            isDrag =0;
         }
      }

   }

   return a;
}


/*
function setMove() {
   $(".share-button").mouseleave();
   var ob=sd.ob;

   imgMV=ob.id;
   clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead]);
}

function setCopy() {
   $(".share-button").mouseleave();
   var ob=sd.ob;

   var sid=getuuid();
   var ppx=ob.posX;
   var ppy=ob.posY;

   var item=CR_item(sd.imgHead,ppx,ppy,ob.pos,sid,wholeImgOff[sd.imgHead],sub_items[sd.imgHead],sub_locs[sd.imgHead]);
   imgMV=item.id;
   $("#lay0").append(item);
}


function setDele() {
   $(".share-button").mouseleave();
   var ob=sd.ob;
   ob.style.display="none";  //should be better if removed from lay0

   clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead]);
}
*/


function CR_consor(imgCode,posX,posY,pos,sid) {
   var a = document.createElement("IMG");
   a.id=sid;
   a.pos = pos;
   a.setAttribute("type","tile");

   //A001 ??????
   a.setAttribute("src","res/mapRes/"+main_map_id+"_"+imgCode + ".png");

   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY + tile_height - a.height;
   a.style.zIndex=9999;
   //a.style.opacity=0.8;

   a.onclick = function()  {
       alert(this.pos);
   }

   return a;
}



function CR_item(imgCode,posX,posY,pos,sid,off,sub_item,sub_loc) {
   var a = document.createElement("IMG");
   a.setAttribute("id",sid);
   a.pos = pos;
   a.off = off;
   a.setAttribute("type","tile");

   //A001 ??????
   a.setAttribute("src","res/mapRes/up/"+imgCode+"/"+imgCode + ".png");

   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY + tile_height - a.height;
   a.style.zIndex=pos;


   if(!isSafari) {

      a.onmouseover = function()  {
         a.style.opacity=0.6;
      }

      a.onmouseout = function()  {
         a.style.opacity=1.0;
      }

      // 该事件是为了禁止在页面拖动图片元素到iframe以外的话，会导致iframe内的内容往相反方向移动
      a.ondrag = function() {
         return false;
      }

      a.onmousedown = function() {
         sd.set(a,imgCode);
         var ob=sd.ob;
         ob.style.opacity=0.6;
         temp_imgCode=imgCode;

         if(commandCtl._getCmd()=="move")
             moveCtrl(imgMV,sd);
         else if(commandCtl._getCmd()=="del")
             delCtrl(imgMV,sd);
         else if(commandCtl._getCmd()=="col")
             colCtrl(imgMV,sd);
      }

  } else {

      //for safari iphone
      //这里需要注意的是，ontouchstart以后，开始ontouchmove以后，在放开touch,激活ontouchend的时候，
      //系统似乎又去调用了一次ontouchstart.
      a.ontouchstart = function(e)  {
          sd.set(a,imgCode);
          var ob=sd.ob;
          a.style.opacity=0.6;
          temp_imgCode=imgCode;

          imgMV=ob.id;

          moveCtrl(isDrag,sd);
      }

      a.ontouchend = function(e)  {
$("#sss").val("endtouchstart:"+isDrag);
          //e.preventDefault();
          if(isDrag==1) {
             a.style.opacity=1.0;
             setMapAct();
             isDrag =0;
          }
      }

   }

   return a;
}


var mvArr = Array();
function drawMap(ix,iy)  {
   var px,py;
   var line_start_x,line_start_y;
   var mvArr_cnt = 0;
   mvArr = Array();

   for(var i =0; i< map_arr_width; i++)      {
        line_start_x = ix-i*(tile_width/2);
        line_start_y = iy+i*tile_height_offset;
        for(var j =0; j< map_arr_height; j++)      {
                   px = line_start_x + j*(tile_width/2);
                   py = line_start_y + j*tile_height_offset;

                   if(!isBGImg(map_all[i*map_arr_width+j])  && isEndItem(map_all[i*map_arr_width+j],i*map_arr_width+j))  {
                      //if not bg img then it is mv img.
                      var img_obj = CR_baseTiles(map_all[i*map_arr_width+j],px,py,i*map_arr_width+j);
                      $(img_obj).draggable();
                      mvArr[mvArr_cnt] = img_obj;
                      mvArr_cnt++;
                   }
        }
   }
}


function isEndItem(imgCode,pos)  {
   var r=imgCode.split("_");
   var ret=false;
   if(r.length==1)
       ret=true;
   else {
       var c=imgCode.split("_");  //eg 41_1.png
       var c1=map_enditem[c[0]]+",";
       //if(c1==pos)  {
       //    ret=true;
       //    //alert(pos+":"+imgCode);
       //}

       pos=pos+",";
       if(c1.indexOf(pos)!=-1)
            ret=true;
   }
   return ret;
}

function mapReload() {
   for(var i =0;i<mvArr.length;i++)   {
        if(mvArr[i])
          $("#lay0").append(mvArr[i]);
   }
}


$(function() {
    var lr=1;
    if(isSafari)
        lr=1;
	$(".share-button").jOrbital({ inDuration:300, radius:lr});
});

</script>
</head>

<body style="margin-top: 0px; margin-left: 0px;">

<div  id="map" style="z-index:0;border: 5px solid #000;width:1024px;height: 512px; left:0; top:0; position: absolute; background:url(<?php echo $canvasBg?>) no-repeat;background-position:-512px -570px;-webkit-background-size:2048px 1332px">
     <div id="lay0" style="z-index:0">
         <!--<input type=text id="sss" style="position:absolute;left:500px;top:0px">-->
         <div id="control" style="position:absolute;left:0px;top:0px"></div>
         <div title="My inventory" style="position:absolute;left:160px;top:0px;width:840px;overflow-x:scroll;dispaly:inline;white-space:nowrap;z-index:1">
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
                 echo "<img id='".$itemID."' src='".$tar_img_file."' style='width:$width;height:$height' ontouchend=endSelectedItem() ontouchstart=setSelectedItem_sa(this.id,".$imgoff_str.",'".$sub_items_str."','".$loc_str."')>";
             else
                 echo "<img id='".$itemID."' src='".$tar_img_file."' style='width:$width;height:$height' onclick=setSelectedItem_web(this.id,".$imgoff_str.",'".$sub_items_str."','".$loc_str."')>";
         }
         ?>
         </div>
     </div>
</div>

<div id="dialog-saved" title="Confirm" style="z-index:1">
	<p><div id="saveText"></div></p>
</div>

<div id="startDiv" style="z-index:9999;left:500px;top:200px;position: absolute">
    <a id="startBut" href="#" onclick="startChat()"><img src="./res/icons/start.png"></a>
</div>

<div id="news">
	<div id="ggg" class="share-button">
		<div class="orbit">
			<a href="javascript:setCopy()"><img src="./res/icons/copy.png" /></a>
			<a href="javascript:setMove()"><img src="./res/icons/move.png" /></a>
			<a href="javascript:setDele()"><img src="./res/icons/delete.png"/></a>
		</div>
	</div>
	<div class="clear"></div>
</div>

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

function loadItems() {
	$( "#dialog-inventory" ).dialog({
	    width: 540,
		height: 240,
		modal: true,
	    buttons: {
				"Ok": function() {
			        $(this).dialog("close");
				 }
		}
	});
}

function startChat() {
   drawMap(ix,iy);
   mapReload();

   if(!isSafari) {
       // for web
      (function(){
         document.getElementById('map').onmousemove=function(e){
            e=e || window.event;
            var mousex = e.clientX;
            var mousey = screen_height_offset+e.clientY-0;  // canvas top property
            target_pos = getPointInRhombus(mousex,mousey);
            var pa = loc2pos(target_pos-1);
            setTargetSign(pa[0],pa[1],target_pos,e);
         }

         //  本来该方法是放在图片上的，但是由于在移动过程中，有可能焦点从图片丢失，因此将该方法放在map上。
         //  意义为，用户在图片上点击，触发onmousedown，然后将相关参数保存，在map上判断如果用户松开了鼠标，则执行
         //  以下方法，将数据写入图形更新数组。
         document.getElementById('map').onmouseup = function() {
            setMapAct();
            if(commandCtl._getCmd()=="add")
               commandCtl._setCmd("move");
         }
      })();


   } else {

      //for safari iphone
      (function(){
         document.getElementById('map').ontouchmove = function(e){
             if(imgMV==0)
                e.preventDefault();
                //return false;

             isDrag =1;

             if(e.touches) {
                 var p = getCoords(e.touches[0]);
                 target_pos = getPointInRhombus(p.x,screen_height_offset+p.y-0);
                 var pa = loc2pos(target_pos-1);
                 setTargetSign(pa[0],pa[1],target_pos,e);
             }
             return false;
         }
      })();

   }

   $("#startDiv").css("display","none");
   parent.showCtrl();
   setCtrlButton();
}


function setCtrlButton()  {
   var msg = "<button id='colCtrl' style='width:80px;height:80px;'>Col</button><button id='delCtrl' style='width:80px;height:80px;'>Del</button>";
   $("#control").html(msg);
   document.getElementById("colCtrl").onclick=function(e){
     commandCtl._setCmd("col");
     //alert(commandCtl._getCmd());
   }
   document.getElementById("delCtrl").onclick=function(e){
     commandCtl._setCmd("del");
     //alert(commandCtl._getCmd());
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

    //如果mousedown被点击，且不是在移动过程中，则将当前的位置信息记录下来，以便在物体移动到非法位置以后，恢复显示以及地图数组数据
    if(flag==0) {
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

    //物体在被move的时候才清除当前的地图数据，如果在colone的时候清除了，那么就会把被colone的物体清除。
    if(commandCtl._getCmd()=="move") {
        //点到该物体时候,将该物体代表的数组从地图数组清除掉,如果清除失败，则可能是用户点鼠标超过了边界，
        //然后返回的时候点了鼠标，这样的点击由于不是拖动点击，因此必须把地图数据提交。
        if(!clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead])) {
           setMapAct();
        }
    }
}


function delCtrl(flag,sd) {
    var ob=sd.ob;

    if(confirm("Are you sure to delete this item?")) {
        clearOriginMap(ob.style.zIndex,sub_locs[sd.imgHead]);
        ob.style.display="none";  //should be better if removed from lay0
    } else {
        sd.clear();
    }
}


function colCtrl(flag,sd) {
    var ob=sd.ob;
    var ic=sd.imgHead;
    var sid=getuuid();
    var ppx=ob.posX;
    var ppy=ob.posY;

    var item=CR_item(sd.imgHead,ppx,ppy,ob.pos,sid,wholeImgOff[sd.imgHead],sub_items[sd.imgHead],sub_locs[sd.imgHead]);
    $(item).draggable();

//    imgMV=item.id;
    $("#lay0").append(item);
    sd.clear();
    sd.set(item,ic);

    moveCtrl(0,sd);
}


function setMapAct()  {
   var ob=sd.ob;
   if(ob==null)
      return;

   ob.style.zIndex=imgMVIndex;

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
}


function setSelectedItem_sa(imgcode,off,sub_item,sub_loc)  {
   $('#dialog-inventory').dialog('close');
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

function setSelectedItem_web(imgcode,off,sub_item,sub_loc)  {
   commandCtl._setCmd("add")
   sid=getuuid();
   var ob=CR_item(imgcode,0,0,0,sid,off,sub_item,sub_loc);
   $(ob).draggable();

   imgMV=sid;
   $("#lay0").append(ob);
   $('#dialog-inventory').dialog('close');
}

function endSelectedItem()  {
   var ob=sd.ob;
   //e.preventDefault();
   if(isDrag==1) {
      ob.style.opacity=1.0;
      setMapAct();
      isDrag =0;
   }
   if(commandCtl._getCmd()=="add")
      commandCtl._setCmd("move");

}

function setTargetSign(px,py,idx,e) {
   var event = e||window.event;

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

       if(iv.pos !== void(0) && iv.pos!==0) {   //map current items
           imgCode=map_all[iv.pos];
       } else  {    // the set items

           imgCode=iv.id;
           px = px - parseInt(iv.off);
       }

       var r=imgCode.split("_");

       if(r.length==1) {  // if not the splited image, use offset.
           px = px - getItemOffset(r[0]);
       } else {
           px = px - img_offset[r[0]];
       }

       px = px;
       py = py+tile_height-iv.height-screen_height_offset;

       iv.style.left=px+"px";
       iv.style.top=py+"px";
       iv.style.zIndex=9999;

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
                var fireOnThis = document.getElementById('map')
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



</script>