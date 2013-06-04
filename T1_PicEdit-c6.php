<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");

$left = $_GET["left"];
$top = $_GET["top"];
$img_name = $_GET["target"];
$img_off = $_GET["imgoff"];
$iid = $_GET["iid"];


$main_map_id=2;
//$img_name="res/mapRes/1000.png";

list($img_width, $img_height, $type, $attr) = getimagesize($img_name);

//$img_width=156;
//$img_height=107;

?>

<html>
<head>
<title></title>

<style type="text/css">
#map{margin-left: 0px;border: 1px solid #979797;background-color: #e5e3df;}
#block{border: 1px solid #979797;background-color: #e5e3df;}
#chatcontent{
 width: 180px;
 background: #E7DFD3;
}
</style>
<link rel="stylesheet" href="default.css">


<script src="MapData.js" type="text/javascript"></script>
<script src="utility.js"></script>
<script src="lib/jquery_new.js"></script>
<script src="custom.js" type="text/javascript"></script>
<script src="aStar1.js" type="text/javascript" ></script>
<script src="TerrainMark.js" type="text/javascript" ></script>


<script>
var step=1;

// 注?? A001：?整游??面大小所需要?整的位置
// 注?? A002：?整游?数?大小所需要?整的位置

//should be the same as div parameters.
var bg_width = 512;
var half_bg_width = 256;
var bg_height = 256;

var itemStartX = half_bg_width;

//A001 tile img size  需要根据?片大小?整，目前?置?倍数
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

var screen_height_offset_times = 0;
var screen_height_offset = 30 * screen_height_offset_times;

var main_map_id = <?php echo $main_map_id?>;

// A002 should be the same as map_all array size.  游?地?数?大小
var map_arr_width = 8;
var map_arr_height = 8;

var ix = bg_width/2 - tile_width/2;
var iy = 0 - screen_height_offset;

var imgMV=0;

var ipx=<?php echo $left?>;
var ipy=<?php echo $top?>;
var ipw=<?php echo $img_width?>;
var iph=<?php echo $img_height?>;

function CR_baseTiles(imgCode,posX,posY,pos) {
   var a = document.createElement("IMG");
   a.imgCode = imgCode;
   a.setAttribute("id",pos);
   a.setAttribute("type","tile");

   //A001 ?置地??片
   a.setAttribute("src","res/mapRes/up/3/3.png");

//   if(imgCode==58)
//       alert("res/mapRes/"+main_map_id+"_"+imgCode + ".png");


   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY + tile_height - a.height;


   if(imgCode==3) {
      a.style.zIndex=1000;
      a.style.opacity=0.8;
      //a.style.filter = "alpha(opacity=70)";    //for IE
   }

   return a;
}


function CR_consor(imgCode,posX,posY,pos,sid) {
   var a = document.createElement("IMG");
   a.id=sid;
   a.pos = pos;
   a.setAttribute("type","tile");

   //A001 ?置地??片
   a.setAttribute("src","res/mapRes/"+main_map_id+"_"+imgCode + ".png");

   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY + tile_height - a.height;
   a.style.zIndex=9999;
   //a.style.opacity=0.8;


   return a;
}


var mvArr = Array();
var mvArr_cnt = 0;
function drawMap(ix,iy)  {
   mvArr = Array();
   mvArr_cnt = 0;
   var px,py;
   var line_start_x,line_start_y;

   for(var i =0; i< map_arr_width; i++)      {
        line_start_x = ix- i*(tile_width/2);
        line_start_y = iy+i*tile_height_offset;
        for(var j =0; j< map_arr_height; j++)      {
                   px = line_start_x + j*(tile_width/2);
                   py = line_start_y + j*tile_height_offset;

                   if(!isBGImg(map_all[i*map_arr_width+j]))  {
//alert((i*map_arr_width+j)+":"+map_all[i*map_arr_width+j]);
                           var img_obj = CR_baseTiles(map_all[i*map_arr_width+j],px,py,i*map_arr_width+j);

                           mvArr[mvArr_cnt] = img_obj;
                           mvArr_cnt++;
                   }
        }
   }
//alert(mvArr_cnt);
}

function mapReload() {
   for(var i =0;i<mvArr_cnt;i++)   {
        if(mvArr[i]) {
              //if((mvArr[i].imgCode)==59)
              //    $("#lay0").append(mvArr[i]);
              if((mvArr[i].imgCode)==3)
                  $("#lay1").append(mvArr[i]);
        }
   }
   appendItemPic();
}

function mapclear() {
   $("#lay1").empty();
}

function appendItemPic() {
   $("#lay0").append(CR_ItemPic(59,ipx,ipy));
}

function CR_ItemPic(imgCode,posX,posY) {
   var a = document.createElement("IMG");
   a.imgCode = imgCode;
   a.setAttribute("type","item");

   a.setAttribute("src","<?php echo $img_name?>");

   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY;
   a.style.zIndex=2000;
   return a;
}


</script>
</head>

<body>
<div id="page" style="z-index:0"  align="center">
     <div id="main_map" style="z-index:0">
          <div  id="map" style="z-index:0;width:1024px;height: 512px; left:0; top:0; position: absolute; background:url(2_bg_grass.png)">
               <div id="lay0" style="z-index:0"></div>
               <div id="lay1" style="z-index:0"></div>
         </div>
     </div>
</div>
<div id="ctrl" style="z-index:10;position: absolute"><input type="button" value="Split" onclick="showMarked()"></div>

</body>
</html>


<script>
var target_pos=0;
var img_obj = CR_consor("target",1,1,-1,"target_sign");
$("#lay1").append(img_obj);
startChat();

function startChat() {
   drawMap(ix,iy);
   mapReload();

   document.getElementById('map').onmousemove=function(e){
             e=e || window.event;
             var mousex = e.clientX;
             var mousey = screen_height_offset+e.clientY-0;  // canvas top property

             target_pos = getPointInRhombus(mousex-16,mousey-8);
             var pa = loc2pos(target_pos);
             setTargetSign(pa[0],pa[1],target_pos);
   }

   document.getElementById('map').onclick=function(e){
             e=e || window.event;
             var mousex = e.clientX;
             var mousey = screen_height_offset+e.clientY-0;  // canvas top property
             target_pos = getPointInRhombus(mousex,mousey);
             alert(mousex+":"+mousey+":"+target_pos);
             setTargetTile(target_pos);
   }

}

function setTargetTile(posID) {
   //alert($("#"+posID).css("z-index"));
   var currentIdx = $("#"+posID).css("z-index");
   var setIdx=1000;
   if(currentIdx==9000) {
      setIdx=1000;
   }
   if(currentIdx==1000) {
      setIdx=9000;
   }
   $("#"+posID).css("z-index",setIdx);
   $("#"+posID).attr("sele",setIdx);

}

function setTargetSign(px,py,idx) {
   img_obj.style.left=px+"px";
   img_obj.style.top=py+"px";
   img_obj.style.zIndex=9999;
}


function showMarked() {
   var marr = Array();
   $("#lay1 [sele='9000']").each(function() {
      marr[marr.length]=parseInt(this.id);
   });
   if(marr.length>0)
        showMarked2(marr);
   else
        alert("at least select one terrain");
}

function showMarked2(mark) {
   markObj=new TerrainMark(mark,ipx,ipy,ipw,iph);
   var locstr = markObj.getFaceArr();
   var bostr = markObj.getBottom();
   var offset = markObj.getOffset();
   mark=setToOrder(mark);   //left  to  right
   //alert(markObj.getFaceArr());
   splitItem(locstr,mark,bostr,offset);
}

function splitItem(locstr,mark,bostr,offset) {
      var ajax_url = "splitItem.php?offset="+offset+"&bo="+bostr+"&mark="+mark+"&locstr="+locstr+"&img_name=<?php echo $img_name?>&iid=<?php echo $iid?>&imgoff=<?php echo $img_off?>";
      //alert(ajax_url);
      $.ajax({type:"GET", url:ajax_url, dataType:"text",async:false,success:function (msg){
          alert("ccc:"+msg);
      }});
}


</script>