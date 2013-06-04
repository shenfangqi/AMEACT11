<?php
//header("content-type:text/html; charset=utf-8");
//require_once("config.php");

//$puser = $_GET["puser"];

$main_map_id=2;
$default_img_left=50;
$default_img_top=50;
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


<script>
var step=0;

// 注?? A001：?整游??面大小所需要?整的位置
// 注?? A002：?整游?数?大小所需要?整的位置
//should be the same as div parameters.
var bg_width = 512;
var half_bg_width = 256;
var bg_height = 256;

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

var ipx=<?php echo $default_img_left?>;
var ipy=<?php echo $default_img_top?>;
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
                           var bg_img = CR_baseTiles(map_all[i*map_arr_width+j],px,py,i*map_arr_width+j);
                           mvArr[mvArr_cnt] = bg_img;
                           mvArr_cnt++;
                   }
        }
   }
}

function mapReload() {
   for(var i =0;i<mvArr_cnt;i++)   {
        if(mvArr[i]) {
              if((mvArr[i].imgCode)==3)
                  $("#lay1").append(mvArr[i]);
        }
   }
//   appendItemPic();
}

function mapclear() {
   $("#lay1").empty();
}

function appendItemPic() {
   $("#lay0").append(CR_ItemPic(59,ipx,ipy));
}

function CR_ItemPic(imgCode,posX,posY,itemName) {
   var a = document.createElement("IMG");
   a.id = itemName;
   a.imgCode = imgCode;
   a.setAttribute("type","item");

   a.setAttribute("src",img_name);

   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY;
   a.style.zIndex=2000;

   a.onclick = function()  {
       if(imgMV==0)  {
          imgMV=1;
       }  else {
          imgMV=0;
       }
   }
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
<div id="ctrl" style="z-index:10;position: absolute"><input type="button" value="Split" onclick="next()"></div>


</body>
</html>


<script>
var img_name=<?php echo "'$img_name';"?>;

var item_obj = CR_ItemPic(59,ipx,ipy,"target_item");
$("#lay0").append(item_obj);
start();

function start() {
   drawMap(ix,iy);
   mapReload();

   document.getElementById('map').onmousemove=function(e){
             e=e || window.event;
             var mousex = e.clientX;
             var mousey = screen_height_offset+e.clientY-0;  // canvas top property

             //target_pos = getPointInRhombus(mousex-16,mousey-8);
             //var pa = loc2pos(target_pos);
             setTargetSign(mousex,mousey);
   }
}

function setTargetSign(px,py) {
     if(imgMV==1) {
       item_obj.style.left=(px-(ipw/2))+"px";
       item_obj.style.top=(py-(iph))+"px";
       item_obj.style.zIndex=9999;
     }
}

function showMarked() {
   alert(item_obj.style.left+":"+item_obj.style.top);
}

function next()  {
//   alert("T1_PicEdit-c6.php?target="+img_name+"&left="+parseInt(item_obj.style.left)+"&top="+parseInt(item_obj.style.top));
   var imgoff=ix-parseInt(item_obj.style.left);
   this.location="T1_PicEdit-c6.php?iid=<?php echo $iid?>&target="+img_name+"&left="+parseInt(item_obj.style.left)+"&top="+parseInt(item_obj.style.top)+"&imgoff="+imgoff;
}

</script>