<html>
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta name="viewport" content="width=device-width,initial-scale=0.5,minimum-scale=0.5,maximum-scale=0.5">

<link rel="stylesheet" href="default.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="jquery-ui-1.8.11/demos/demos.css">
<?php
$puser = $_GET["puser"];
$room = $_GET["room"];
?>
<script src="jquery-ui-1.8.11/jquery-1.5.1.js" type="text/javascript"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.core.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.widget.js"></script>
<script src="jquery-ui-1.8.11/ui/jquery.ui.button.js"></script>

<script type="text/javascript">
function setval(vl) {
  $("#adcode").val(vl);
}


function showCtrl() {
   $("#startCtrl").css("display","");
}

	$(function() {
		$( "button, input:submit, a", ".demo" ).button();
		$( "a", ".demo" ).click(function() { return false; });
	});
	</script>
<style type="text/css">
	.fg-button { outline: 0; margin:0 4px 0 0; padding: .4em 1em; text-decoration:none !important; cursor:pointer; position: relative; text-align: center; zoom: 1; }
	.fg-button .ui-icon { position: absolute; top: 50%; margin-top: -8px; left: 50%; margin-left: -8px; }

	a.fg-button { float:left; }

	/* remove extra button width in IE */
	button.fg-button { width:auto; overflow:visible; }

	.fg-button-icon-left { padding-left: 2.1em; }
	.fg-button-icon-right { padding-right: 2.1em; }
	.fg-button-icon-left .ui-icon { right: auto; left: .2em; margin-left: 0; }
	.fg-button-icon-right .ui-icon { left: auto; right: .2em; margin-left: 0; }

	.fg-button-icon-solo { display:block; width:6px; text-indent: -9999px; }	 /* solo icon buttons must have block properties for the text-indent to work */

	.fg-buttonset { float:left; }
	.fg-buttonset .fg-button { float: left; }
	.fg-buttonset-single .fg-button,
	.fg-buttonset-multi .fg-button { margin-right: -1px;}

	.fg-toolbar { padding: 0em; margin: 0;  }
	.fg-toolbar .fg-buttonset { margin-right:0em; padding-left: 0px; }
	.fg-toolbar .fg-button { font-size: 1em;  }

	/*demo page css*/
	h2 { clear: both; padding-top:1.5em; margin-top:0; }
	.strike { text-decoration: line-through; }
</style>
<body style="margin-top: 0px;margin-left: 0px;" onorientationchange="setOrient();" ontouchmove="return false">
   <div id="titleDiv" style="left:0px;width:640;z-index:3;position: absolute">
         <img src="bg_title.png" style="width:640px;height:42px">
   </div>

<!--
<div id="homeDiv" style="z-index:3;left:480px;top:18px;position: absolute">
     <img id="homeBut" borde=0 src="res/icons/home.png"><a href="./index.html" target="_top"><font color="white">Home</font></a>
</div>

<div id="inventoryDiv" style="z-index:3;left:580px;top:18px;position: absolute">
     <img id="inventoryBut" borde=0 src="res/icons/inventory.png" onclick="c4.loadItems()"><a href="#" onclick="c4.loadItems()"><font color="white">Inventory</font></a>
</div>

<div id="logoutDiv" style="z-index:3;left:680px;top:17px;position: absolute">
     <img id="logoutBut" borde=0 src="res/icons/logout.png"><a href="./index.html" target="_top"><font color="white">Logout</font></a>
</div>

<div id="upDiv" style="z-index:3;left:780px;top:17px;position: absolute">
     <a href="#"  onclick="c4.move(0)"><font color="white">up</font></a>
</div>
<div id="downDiv" style="z-index:3;left:810px;top:17px;position: absolute">
     <a href="#"  onclick="c4.move(1)"><font color="white">down</font></a>
</div>
<div id="leftDiv" style="z-index:3;left:850px;top:17px;position: absolute">
     <a href="#"  onclick="c4.move(2)"><font color="white">left</font></a>
</div>
<div id="rightDiv" style="z-index:3;left:880px;top:17px;position: absolute">
     <a href="#"  onclick="c4.move(3)"><font color="white">right</font></a>
</div>

<div id="modeDiv" style="z-index:3;left:910px;top:17px;position: absolute">
     <input id = "modeBut" type="button" value="Items">
</div>
-->



<div id="startCtrl" class="fg-toolbar ui-widget-header ui-corner-all ui-helper-clearfix" style="left:270px;top:7px;position:absolute;z-index:4;display:none">
	 <table border=0>
	 <tr>
	     <td width="10px">
	 <div class="fg-buttonset ui-helper-clearfix">
		  <a href="javascript:c4.save($('#adcode').val())" class="fg-button ui-state-default fg-button-icon-solo  ui-corner-all" title="Save"><span class="ui-icon ui-icon-disk"></span> Save</a>
	 </div>
	     </td>
	     <td>
	 <div>
     <input id="adcode" type=text  value="Admin code here" style="width:100px">
     <input type=button value="UPUP" onclick="c4.move(0);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input type=button value="DOWN" onclick="c4.move(1);">
     </div>
        </td>
     </tr>
     </table>
</div>

<iframe id="c4" frameborder=0 name="c4" src="MapEdit-c6.php?room=<?php echo $room?>&puser=<?php echo $puser?>" frameborder="0" scrolling="no" style="position:absolute;top:40px;width:960px;height:512px"></iframe>

</body>

<script language="javascript">
var user = "<?php echo $puser?>";
$("#sayBut").click(function() {
     objOnclick=true;
     var fr = user;
     var to = $("#sayTo")[0].value;
     var content = $("#sayText")[0].value;
     var content = escape(content);
//alert("sendChatMsg.php?from="+fr+"&to="+to+"&content="+content);

     $.ajax({type:"GET", url:"sendChatMsg.php?from="+fr+"&to="+to+"&content="+content, dataType:"text",async:false,success:function (msg){
	 }});
}
)

$("#modeBut").click(function() {
   if($(this).val()=="Items") {
       $(this).val("Terrain")
   }
   else if($(this).val()=="Terrain") {
       $(this).val("Items")
   }
}
)

function setOrient() {
  window.scrollTo(0,1);
  var orientation = window.orientation;
//alert(orientation);
   var width,height;
   if(orientation == 0) {
        width="640px";
        height="980px";
   } else  {
        width="960px";
        height="512px";
   }

   document.getElementById('c4').style.width=width;
   document.getElementById('c4').style.height=height;

   c4.ajustOrientation(orientation);
}

</script>
</html>