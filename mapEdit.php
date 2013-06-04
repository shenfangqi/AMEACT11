<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");

$puser = $_POST["puser"];

?>

<html>
<head>
<title>Canvas tutorial</title>
<link rel="stylesheet" href="default.css">

<script src="MapData.js" type="text/javascript"></script>
<script src="OtherSprites.js" type="text/javascript"></script>
<script src="lib/jquery_new.js" type="text/javascript"></script>
<script src="h6.js" type="text/javascript"></script>
<script src="Sprite.js" type="text/javascript"></script>
<script src="custom_ht5.js" type="text/javascript"></script>
<script src="aStar1.js" type="text/javascript"></script>
<script src="utility.js" type="text/javascript"></script>
<script src="ResLoad.js" type="text/javascript"></script>

<style type="text/css">
     canvas { border: 1px solid black; }
</style>

</head>
<body>
<input id="startBut" type=button value="Start"/>
TO:<input id="sayTo" type=text style="width:40px"/>Contents:<input id="sayText" type=text style="width:100px"/> <input id="sayBut" type=button value="Sayyy" /><input id="testinfo" type=text value=0 style="width:250px"/>
<div id="lay0" style="z-index:1">
    <canvas id="canvas" width="1024" height="512"  style="z-index:1;left:0;top:30;position: absolute;background:url(2_bg_grass.png)"></canvas>
</div>

</body>

<script language="javascript">
// 注释为 A001：调整游戏图面大小所需要调整的位置
// 注释为 A002：调整游戏数组大小所需要调整的位置

var user = "<?php echo $puser?>";

// common setting for FF and IE--->
//should be the same as div parameters.
var bg_width = 1024;
var half_bg_width = 512;
var bg_height = 512;




//A001 tile img size  需要根据图片大小调整，目前设置为倍数
var tile_width = 32*2;
var half_tile_width = 16*2;
var tile_height = 15*2;
var tile_height_offset = 8*2;    //for overlaping

var screen_height_offset_times = 0;
var screen_height_offset = 30 * screen_height_offset_times;



// A002 should be the same as map_all array size.  游戏地图数组大小
var map_arr_width = 32;
var map_arr_height = 32;


var ix = bg_width/2 - tile_width/2;
var iy = 0 - screen_height_offset;

// common setting for FF and IE--->


// set passable terrain. should be load from server for each SIM-->
//var passable_terrain = Array(2,51,55,58,59,60,61,62);
// set passable terrain -->


var roomRes =  new ResLoad();
roomRes.map_res_load(map_all,1);  //根据地图data load所有资源


var ctx = document.getElementById('canvas').getContext('2d');
var iID;


var ca = new Canvas();
ca.setMap(ix,iy);



$("#startBut").click(function() {
           ca.mapEditInit();

           document.getElementById('lay0').onclick = function(e){
               var dir;
               e=e || window.event;
               var mousex = e.clientX;
               var mousey = e.clientY-30-iy;  // canvas top property
               target_pos = getPointInRhombus(mousex,mousey);
               alert(target_pos);

           }

           document.getElementById('lay0').onmousemove=function(e){
               e=e || window.event;
               var mousex = e.clientX;
               var mousey = e.clientY-30-iy;  // canvas top property
               target_pos = getPointInRhombus(mousex,mousey);
               $("#testinfo").val(loc2pos(target_pos));
           }

})
</script>

</html>