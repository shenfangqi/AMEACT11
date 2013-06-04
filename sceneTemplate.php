<?php
/*
     "sce1" => array (
       "canvasBg"=>"ss2.jpg",
       "default_pos"=>460,
       "canvasWidth"=>1024,
       "canvasHeight"=>1024,
       "bgImgPosX"=>-512,
       "bgImgPosY"=>-570,
       "itemStartX"=>512,
       "itemStartY"=>30*8,
       "mapArrWidth"=>32,
       "mapArrHeight"=>32
     ),
*/

include_once("scene_config.php");

//$this_scene = "sce2";

//echo "<pre>";
//print_r($sce_arr[$this_scene]);
//echo "</pre>";

$canvasBg = $sce_arr[$this_scene]["canvasBg"];
$canvasSize = $sce_arr[$this_scene]["mapArrWidth"];

$hasSmoke = $sce_arr[$this_scene]["smokeEffect"];
$smokeX = $sce_arr[$this_scene]["smokeEffect_posX"];
$smokeY = $sce_arr[$this_scene]["smokeEffect_posY"];

list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($canvasBg);   // set the background image size.

$default_pos = $sce_arr[$this_scene]["default_pos"];

$canvas_width = $sce_arr[$this_scene]["canvasWidth"];
$canvas_height = $sce_arr[$this_scene]["canvasHeight"];

$bgImgPosX = $sce_arr[$this_scene]["bgImgPosX"];
$bgImgPosY = $sce_arr[$this_scene]["bgImgPosY"];

$itemStartX = $sce_arr[$this_scene]["itemStartX"];
$itemStartY = $sce_arr[$this_scene]["itemStartY"];

$map_arr_width = $sce_arr[$this_scene]["mapArrWidth"];
$map_arr_height = $sce_arr[$this_scene]["mapArrHeight"];


//if not iphone then set to android screen.
$deviceKey = key($device_arr);
$deviceW0 = $device_arr["S6160"]["deviceWidth_0"];
$deviceH0 = $device_arr["S6160"]["deviceHeight_0"];
$deviceW1 = $device_arr["S6160"]["deviceWidth_1"];
$deviceH1 = $device_arr["S6160"]["deviceHeight_1"];

$isIPhone=false;   //actually , it is used to detect if from Mobile client
while($rec = current($device_arr))   {
   if(strpos($_SERVER["HTTP_USER_AGENT"],key($device_arr)))  {
       $deviceKey = key($device_arr);
       $deviceW0 = $device_arr[$deviceKey]["deviceWidth_0"];
       $deviceH0 = $device_arr[$deviceKey]["deviceHeight_0"];
       $deviceW1 = $device_arr[$deviceKey]["deviceWidth_1"];
       $deviceH1 = $device_arr[$deviceKey]["deviceHeight_1"];
       $isIPhone = true;
   }
   next($device_arr);
}

?>