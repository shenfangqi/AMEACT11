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
getUserInfo($puser,$roomID);

if($_GET["room"])
   $roomID=$_GET["room"];


$canvasBg = "ss2.jpg";
//$canvasBg = "bg_room".$roomID . ".png";

?>
<html>
<http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5,maximum-scale=0.5">
<meta name="apple-mobile-web-app-capable" content="yes" />
<head>
<title><?php echo $puser?></title>

<style type="text/css">
body {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        margin-top: 0px;
        margin-left: 0px;
}
</style>

<link rel="stylesheet" href="jquery-ui-1.8.11/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/demos/demos.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/slider.css">

<script language="javascript">
// A002 should be the same as map_all array size.  ??????????
var map_arr_width = 32;
var map_arr_height = 32;
</script>

<script src="utility.js"></script>
<script src="jquery-ui-1.8.11/jquery-1.6.2.min.js"></script>
<script src="jquery-ui-1.8.11/jquery.touchSlider.js"></script>

<script src="custom.js" type="text/javascript"></script>
<script src="aStar1.js" type="text/javascript" ></script>
<script src="ResLoad.js" type="text/javascript"></script>
<script src="mapBuilder.js" type="text/javascript"></script>

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
	$(document).ready(function(){
		$('#gallery1').touchSlider({
			mode: 'shift'
		});
	});

    /*
      用以判断items slider上用户的动作是否选择某个item,还是滑动以浏览所有items
      1.当检测到slider上有touch行为，则将标志设为1，然后在200ms后执行选择物品的方法
      2.如果用户放开了touch，则将标志清空。
      3.如果在200ms以内，用户还没有放开touch则认为是用户选择了该item
    */
    var setCnt=0;
    var lastX=0,lastY=0;
    function setS(sid,imgstr,itemstr,locstr) {
	   setCnt=1;
       setTimeout(function(){ setSelectedItem_sa(sid,imgstr,itemstr,locstr); }, 200);
    }

    //如果用户放开touch, 将标志设为0，且物品已经被选择，则执行将物品定位操作。
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

    //如果在200ms后执行的该方法判断到标志仍为1，则说明用户按住该item超过了200ms,则认为用户选择了该item.
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

    function endSelectedItem()  {
       var ob=sd.ob;
       var obx,oby;
       obx = parseInt(ob.style.left);
       oby = parseInt(ob.style.top);
       obh = parseInt(ob.height);

       //如果图片位置在屏幕左上初始位置，或者图片在slider宽度范围内，则将生成的图片删除。
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
       if(commandCtl._getCmd()=="add")
          commandCtl._setCmd("move");
    }

    //为web版本用的，无touch功能，为了整合将代码放touch一起。
    function setSelectedItem_web(imgcode,off,sub_item,sub_loc)  {
       commandCtl._setCmd("add")
       sid=getuuid();
       var ob=CR_item(imgcode,0,0,0,sid,off,sub_item,sub_loc);
       $(ob).draggable();

       imgMV=sid;
       $("#lay0").append(ob);
    }

</script>

<?php
$mp = new map_info($roomID);
$mp->outPutMap();
?>

<script>
var isIE=false;
var isSafari=false;
var canvas_offx = 0;
var canvas_offy = 0;
var scr_scroll_speed = 180;


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

var ix = half_bg_width - tile_width/2;
var iy = 0 - screen_height_offset;


var imgMV=0;
var imgMVIndex=0;


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

   a.setAttribute("imgCode",r[0]);

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
         e.preventDefault();
         sd.set(a,r[0]);
         var ob=sd.ob;
         ob.style.opacity=0.6;
         temp_imgCode=imgCode;

         imgMV=ob.id;

         if(commandCtl._getCmd()=="move") {
             moveCtrl(isDrag,sd);
         }
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


function move(dir)  {
   var ps = $('#map').css('backgroundPosition');
   var ps_x = parseInt(ps.split(" ")[0]);
   var ps_y = parseInt(ps.split(" ")[1]);
   var offx,offy;

//   $("#lay0").empty();

   //img_obj = CR_consor("target",1,1,-1,"target_sign");
   //$("#lay0").append(target_obj);

   if(dir==0)  {
      screen_height_offset -=120;
      ps_y += 120;
      offy = 120;
   } else if(dir==1) {
      screen_height_offset +=120;
      ps_y -= 120;
      offy = -120;
   } else if(dir==2) {
      half_bg_width += 128;
      ps_x += 128;
      offx = 128;
   } else if(dir==3) {
      half_bg_width -= 128;
      ps_x -= 128;
      offx = -128;
   }
   //screen_height_offset = 30 * screen_height_offset_times;

   ix = half_bg_width - tile_width/2;
   iy = 0 - screen_height_offset;

//   map_all = Array();
//   for(var i=0;i<map_all_update.length;i++) {
//         map_all[i] = map_all_update[i];
//   }

   target_pos=0;
//   drawMap(ix,iy);
//   mapReload();

   ps_x = ps_x + "px";
   ps_y = ps_y + "px";
   var ss= ps_x +" "+ ps_y;
   $('#map').css('backgroundPosition',ss);
   updateMap(offx,offy);
}




<!--    Screen Moving Control for both Safari Mobile and WEB  -->
var tx=0;
var ty=0;
var sx=0;
var sy=0;
var isScrMoving=0;
var md_cnt=0;
var isMouseDown=0;
var dura=0;

//for mobile safari only. android should be considered.


function endMoveEventFunction(e) {
    e.preventDefault();
    tx=0;
    ty=0;
    sx=0;
    sy=0;
    isScrMoving=0;
    dura=0;
    setTimeout(function() { isScrMoving=0; },300);
}

function mapEditScreenMove(mx,my)  {
    var td = new Date().getTime()-dura;
    if(td < scr_scroll_speed)
       return false;

    dura = new Date().getTime();

    var ox,oy,tmp;
    if(sx==0 && sy==0) {
	     sx = mx;
         sy = my;
    } else {
         ox=mx-sx;
         oy=my-sy;

         //get canvas background postion
         var ps = $('#map').css('backgroundPosition');;
         var ps_x = parseInt(ps.split(" ")[0]);
         var ps_y = parseInt(ps.split(" ")[1]);

         //compare horizon and vectical movement,if the horizon movement > vectical movement then only handle horizon.
         var or = Math.abs(ox)-Math.abs(oy);

         //notice: 64 is the width of the basic grid, 30 is the height of basic grid. shouldn't be changed.
         var hv;
         if(or>0)  {
            if(ox>0) {
                move(2);
            } else {
                move(3);
            }
         }

         if(or<0)  {
            if(oy<0) {
                move(1);
            } else {
                move(0);
            }
         }
      }
}

function moveEventFunction(e) {
    var p = getCoords(e.touches[0]);
    if(p.y < 100)
       return;

    isScrMoving=1;
    md_cnt++;

    if (e.touches && md_cnt>3) {
            md_cnt=0;
            mapEditScreenMove(p.x , p.y);

    }
    return false;
}

function moveMSEventFunction(e) {
    var ox,oy,tmp;

    md_cnt++;

    if (isMouseDown==1) {
            md_cnt=0;
            isScrMoving=1;
            var evt = window.event || e;

            md_cnt=0;
            mapEditScreenMove(evt.clientX , evt.clientY);
    }
    return false;
}


function m_down() {
    //alert("mdown");
    isMouseDown=1;
}

function endMSMoveEventFunction(e) {
    tx=0;
    ty=0;
    sx=0;
    sy=0;
    isMouseDown=0;
    setTimeout(function() { isScrMoving=0; },300);
}

<!--  End of Screen Moving Control for both Safari Mobile and WEB  -->





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

   a.setAttribute("imgCode",imgCode);

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
          e.preventDefault();
          sd.set(a,imgCode);
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


function updateMap(offx,offy)  {
   $('#lay0').children('img').each(
       function(){
           thisX = parseInt($(this).css("left"));
           thisY = parseInt($(this).css("top"));

           thisX = thisX + offx + "px";
           thisY = thisY + offy + "px";

           $(this).css("left",thisX);
           $(this).css("top",thisY);
       }
   );
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
   var t;
   for(var i =0;i<mvArr.length;i++)   {
        if(mvArr[i] && !isTerrainImg(mvArr[i].src))  {
          $("#lay0").append(mvArr[i]);
        }
   }
}


</script>
</head>

<body onorientationchange="ajustOrientation();">

<div  id="map" style="overflow:hidden;border: 5px solid #000;width:950px;height: 512px; left:0; top:0; position: absolute; background:url(<?php echo $canvasBg?>) no-repeat;background-position:-512px -570px;-webkit-background-size:2048px 1332px">
     <div id="lay0" style="z-index:0">
         <!--<input type=text id="sss" style="position:absolute;left:500px;top:200px">-->
     </div>

     <div title="gallery-holder" style="position:absolute;top:35px;left:136px;width:800px;z-index:9999">
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
	         </div>
     </div>

</div>

<div id="control" style="position:absolute;left:10px;top:45px;z-index:9999"></div>

<div id="save" style="position:absolute;left:10px;top:185px;z-index:9999">
   <input type=button id='saveCtrl' value='save' style='width:96px;height:96px;z-index:9999'>
</div>


<div id="dialog-saved" title="Confirm" style="z-index:1">
	<p><div id="saveText"></div></p>
</div>

<div id="startDiv" style="z-index:9999;left:500px;top:200px;position: absolute">
    <a id="startBut" href="#" onclick="startChat()"><img src="./res/icons/start.png"></a>
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


function startChat() {
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
               moveMSEventFunction(e);
               return false;
            }
            e=e || window.event;
            var mousex = e.clientX - canvas_offx;
            var mousey = screen_height_offset+e.clientY-0 - canvas_offy;  // canvas top property
            target_pos = getPointInRhombus(mousex,mousey);
            var pa = loc2pos(target_pos-1);
            setTargetSign(pa[0],pa[1],target_pos,e);
         }


         //  本来该方法是放在图片上的，但是由于在移动过程中，有可能焦点从图片丢失，因此将该方法放在map上。
         //  意义为，用户在图片上点击，触发onmousedown，然后将相关参数保存，在map上判断如果用户松开了鼠标，则执行
         //  以下方法，将数据写入图形更新数组。
         document.getElementById('map').onmouseup = function(e) {
            if(imgMV==0)  {
               endMSMoveEventFunction(e);
               return;
            }
            setMapAct();
            if(commandCtl._getCmd()=="add")
               commandCtl._setCmd("move");
         }


      })();

   } else {

      //for safari iphone
      (function(){
         document.getElementById('map').ontouchmove = function(e){
             e.preventDefault();
             if(imgMV==0)  {
                moveEventFunction(e);
                return false;
             }
             isDrag =1;
             if(e.touches) {
                 var p = getCoords(e.touches[0]);
                 p.x = p.x - canvas_offx;
                 p.y = p.y - canvas_offy;
                 lastX = p.x;
                 lastY = p.y;
                 target_pos = getPointInRhombus(p.x,screen_height_offset+p.y-0);
                 var pa = loc2pos(target_pos-1);
                 setTargetSign(pa[0],pa[1],target_pos,e);
             }
             return false;
         }
      })();

   }

   $("#startDiv").css("display","none");
   //parent.showCtrl();
   setCtrlButton();
   //parent.setOrient();
}

function setCtrlButton()  {
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

    //如果mousedown被点击，且不是在移动过程中，则将当前的位置信息记录下来，以便在物体移动到非法位置以后，恢复显示以及地图数组数据
    if(flag==0) {
      isDrag=1;   //用于测定当图片被touch以后，马上release之后，isdrag=1则将进入图片的touchend判断，否则该情况下，图片数组被清空，不能进入touchend方法的话，数据则不能保存。
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
    imgMV=0;
    commandCtl._setCmd("move");
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
           if(orientation == 0) {
              $('#map').css("width","630px");
              $('#map').css("height","980px");
           } else  {
              $('#map').css("width","980px");
              $('#map').css("height","630px");
           }
           drawMap(ix,iy);
           window.setTimeout(function() { window.top.scrollTo(0,1);relocateSaydiv();} , 100);
}


document.getElementById('map').onmousedown = m_down;
//document.getElementById('map').onmousemove = moveMSEventFunction;
//document.getElementById('map').onmouseup = endMSMoveEventFunction;
document.getElementById('map').onmouseout = endMSMoveEventFunction;

//document.getElementById('map').ontouchmove = moveEventFunction;
document.getElementById('map').ontouchend = endMoveEventFunction;

</script>