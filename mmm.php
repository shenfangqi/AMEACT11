<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");
require_once("map_info.php");

$roomID=1;
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
   if($ret_w<=80 && $ret_h <=80) {
       $ret_w=$ret_w;
       $ret_h=$ret_h;
   }
   else if($ret_w>$ret_h) {
      $ret_h=intval((80*$ret_h) / $ret_w);
       $ret_w=80;
   } else {
       $ret_w=intval((80*$ret_w) / $ret_h);
       $ret_h=80;
   }
}

?>
<html>
<http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5,maximum-scale=0.5">
<head>
<title>mmmm</title>

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
<link rel="stylesheet" href="jquery-ui-1.8.11/slider.css">

<script src="utility.js"></script>
<script src="jquery-ui-1.8.11/jquery-1.6.2.min.js"></script>
<script src="jquery-ui-1.8.11/jquery.touchSlider.js"></script>

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

		<script type="text/javascript">
			$(document).ready(function(){
				$('#gallery1').touchSlider({
					mode: 'shift'
				});

				$('#gallery2').touchSlider({
					mode: 'shift',
					animation: 'js'
				});

				$('#gallery3').touchSlider({
					mode: 'shift',
					animation: false
				});
			});
		</script>

<?php
$mp = new map_info($roomID);
$mp->outPutMap();
?>


</head>

<body style="margin-top: 0px; margin-left: 0px;">

<div  id="map" style="z-index:0;border: 5px solid #000;width:940px;height: 512px; left:0; top:0;background:url(<?php echo $canvasBg?>) no-repeat;background-position:-512px -570px;-webkit-background-size:2048px 1332px">
     <div id="lay0" style="z-index:0">
         <input type=text id="sss" style="position:absolute;left:500px;top:0px">
         <div id="control" style="position:absolute;left:0px;top:0px"></div>

     </div>
</div>


<div title="gallery-holder" style="width:840px;z-index:1000">
	<div class="gallery" id="gallery1">
		<div class="holder">
			<div class="list">
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

         echo "<div class='item'><div class='box box1'><img id='".$itemID."' src='".$tar_img_file."' style='width:$width;height:$height'></div></div>";
     }
     ?>
           </div>
		</div>
	</div>
</div>

</body>
</html>