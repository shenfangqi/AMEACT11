<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");

$puser = $_GET["puser"];

?>

<html>
<head>
<title><?php echo $puser?></title>

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
// 注?? A001：?整游??面大小所需要?整的位置
// 注?? A002：?整游?数?大小所需要?整的位置

var user = "<?php echo $puser?>";

//should be the same as div parameters.
var bg_width = 1024;
var half_bg_width = 512;
var bg_height = 512;

//A001 tile img size  需要根据?片大小?整，目前?置?倍数
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

var screen_height_offset_times = 0;
var screen_height_offset = 30 * screen_height_offset_times;

var main_map_id = 2;

// A002 should be the same as map_all array size.  游?地?数?大小
var map_arr_width = 8;
var map_arr_height = 8;

var ix = bg_width/2 - tile_width/2;
var iy = 0 - screen_height_offset;

var imgMV=0;

function CR_baseTiles(imgCode,posX,posY,pos) {
//   if(imgCode==58)
//       posX = posX-210;
//   if(imgCode==59)
//       posX = posX-100;

   var a = document.createElement("IMG");
   a.imgCode = imgCode;
   a.setAttribute("id",pos);
   a.setAttribute("type","tile");

   //A001 ?置地??片
   a.setAttribute("src","res/mapRes/"+main_map_id+"_"+imgCode + ".png");
   if(imgCode==58)
       alert("res/mapRes/"+main_map_id+"_"+imgCode + ".png");


   a.style.position="absolute";
   a.style.left=posX;
   a.style.top=posY + tile_height - a.height;


   if(imgCode==56) {
      a.style.zIndex=9999;
      a.style.opacity=0.7;
      //a.style.filter = "alpha(opacity=70)";    //for IE
   }

   a.onmouseover = function()  {
       tx=parseInt(a.style.left);
       ty=parseInt(a.style.top);
       iw=parseInt(a.width);
       ih=parseInt(a.height);

       tx1=tx+iw;
       ty1=ty+ih;
       createRect(tx,ty,tx1,ty1,"point.jpg");
   }

   a.onclick = function()  {
       if(imgMV==0)  {
          imgMV=a.id;
       }
       else {
          imgMV=0;
          clearRect();
       }
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
              if((mvArr[i].imgCode)==59)
                  $("#lay0").append(mvArr[i]);
              else if((mvArr[i].imgCode)==56)
                  $("#lay1").append(mvArr[i]);
        }
   }
}

function mapclear() {
   $("#lay1").empty();
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



</body>
</html>


<script>
var target_pos=0;
var img_obj = CR_consor("target",1,1,-1,"target_sign");
$("#lay0").append(img_obj);

function cc() {
   startChat();
}

function startChat() {
   drawMap(ix,iy);
   mapReload();

   document.getElementById('map').onmousemove=function(e){
             if(imgMV !=0)  {
               e=e || window.event;
               var mousex = e.clientX;
               var mousey = screen_height_offset+e.clientY-0;  // canvas top property
               target_pos = getPointInRhombus(mousex,mousey);
               var pa = loc2pos(target_pos-1);
               setTargetSign(mousex,mousey,target_pos-1);
             }
   }

}

function setTargetSign(px,py,idx) {
     if(imgMV!=0) {
       document.getElementById(imgMV).style.left=(px-64)+"px";
       document.getElementById(imgMV).style.top=(py-32)+"px";
       document.getElementById(imgMV).style.zIndex=9999;
     }
}


function showMarked() {
   var marked_all = Array();
   var n=0;
   for(var i =0;i<map_all.length;i++)   {
         if(map_all[i]==56)  {
            marked_all[n]=i;
            n++;
         }
   }

   markObj=new TerrainMark(marked_all);
   alert(markObj.getFaceArr());

}

</script>