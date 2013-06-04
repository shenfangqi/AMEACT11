<?php

$sce_arr = array(
     // for common big terrain
     "sce1" => array (
       "canvasBg"=>"ss2.jpg",
       "default_pos"=>455,
       "canvasWidth"=>1024,
       "canvasHeight"=>1024,
       "bgImgPosX"=>-512,
       "bgImgPosY"=>-580,
       "itemStartX"=>512,
       "itemStartY"=>30*8,
       "mapArrWidth"=>32,
       "mapArrHeight"=>32
     ),

     // for user small room
     "sce2" => array (
       "canvasBg"=>"ss7.gif",
       "default_pos"=>30,
       "canvasWidth"=>512,
       "canvasHeight"=>512,
       "bgImgPosX"=>0,
       "bgImgPosY"=>135,
       "itemStartX"=>256,
       "itemStartY"=>-36*8,
       "mapArrWidth"=>8,
       "mapArrHeight"=>8,
       "smokeEffect"=>1,
       "smokeEffect_posX"=>210,
       "smokeEffect_posY"=>180
     ),

     // for myo room
     "sce3" => array (
       "canvasBg"=>"ss4.jpg",
       "default_pos"=>455,
       "canvasWidth"=>1024,
       "canvasHeight"=>1024,
       "bgImgPosX"=>-518,
       "bgImgPosY"=>-558,
       "itemStartX"=>512,
       "itemStartY"=>30*8,
       "mapArrWidth"=>32,
       "mapArrHeight"=>32
     ),

     "sce4" => array (
       "canvasBg"=>"ss6.jpg",
       "default_pos"=>455,
       "canvasWidth"=>1024,
       "canvasHeight"=>1024,
       "bgImgPosX"=>-518,
       "bgImgPosY"=>-930,
       "itemStartX"=>512,
       "itemStartY"=>30*8,
       "mapArrWidth"=>32,
       "mapArrHeight"=>32,
       "smokeEffect"=>1,
       "smokeEffect_posX"=>480,
       "smokeEffect_posY"=>-240
     ),

     "sce5" => array (
       "canvasBg"=>"ss8.png",
       "default_pos"=>455,
       "canvasWidth"=>1024,
       "canvasHeight"=>1024,
       "bgImgPosX"=>-518,
       "bgImgPosY"=>-930,
       "itemStartX"=>512,
       "itemStartY"=>30*8,
       "mapArrWidth"=>32,
       "mapArrHeight"=>32,
       "smokeEffect"=>0,
       "smokeEffect_posX"=>480,
       "smokeEffect_posY"=>-240
     ),
);

//if new device come,this arr should be maintained.
$device_arr = array(
     // for iida android screen, 0 or 1 is  orientation identitiy
     "S6160" => array (
       "deviceWidth_0"=>590,
       "deviceHeight_0"=>926,
       "deviceWidth_1"=>659,
       "deviceHeight_1"=>1269
     ),

     // for iphone
     "iPhone" => array (
       "deviceWidth_0"=>630,
       "deviceHeight_0"=>830,
       "deviceWidth_1"=>530,
       "deviceHeight_1"=>980
     ),
     
     // for iphone
     "iPad" => array (
       "deviceWidth_0"=>590,
       "deviceHeight_0"=>926,
       "deviceWidth_1"=>659,
       "deviceHeight_1"=>1269
     )     
);

/*
*	Mobile device detection
*/
if( !function_exists('mobile_user_agent_switch') ){
	function mobile_user_agent_switch(){
		$device = '';

		if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$device = "ipad";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$device = "iphone";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$device = "blackberry";
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$device = "android";
		}

		if( $device ) {
			return $device;
		} return false; {
			return false;
		}
	}
}

?>