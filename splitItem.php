<?php
// Create a 55x30 image
$locstr = $_GET["locstr"];
$img_name = $_GET["img_name"];
$iid = $_GET["iid"];
$mark = $_GET["mark"];   //user selected image all marked
$bostr = $_GET["bo"];   //image最底map arr
$offset = $_GET["offset"];
$img_off = $_GET["imgoff"];

$loc_arr=explode(",",$locstr);

if(count($loc_arr)==1)
    $img_off = $offset;

echo "<pre>";
print_r($loc_arr);
echo "</pre>";

//$img_name="res/mapRes/1000.png";

$src = imagecreatefrompng($img_name);

list($width, $height, $type, $attr) = getimagesize($img_name);

$cnt=0;
$items="";

if(count($loc_arr)>1)  {
   while($loc_arr) {
       $one_loc=array_shift($loc_arr);
       $sp_arr=explode("||",$one_loc);
       $start_arr=explode(":",$sp_arr[0]);
       $end_arr=explode(":",$sp_arr[1]);

       $sx=$start_arr[0];
       $sy=$start_arr[1];

//echo "$end_arr[0]-sx<br>";

       $tx=$end_arr[0]-$sx;
       $ty=$end_arr[1]-$sy;

//echo "$sx:$sy---$tx:$ty<br>";



       $im = @imagecreatetruecolor($tx, $ty) or die("Cannot Initialize new GD image stream");
       imagesavealpha($im,true);
       $trans_colour = imagecolorallocatealpha($im,0,0,0,127);
       imagefill($im,0,0,$trans_colour);

       if($ty>$height)  {
           $ty=$height;
       }
       imagecopy($im, $src, 0, 0, $sx, $sy, $tx, $ty);

       // Save the image
       $fn=$iid ."_". $cnt . ".png";
       $items .=$fn . "||";
       imagepng($im, "./res/mapRes/up/$iid/$fn");
       imagedestroy($im);
       $cnt++;
   }
}

mysql_connect("localhost","root","") or die("Could not connect: " . mysql_error());
mysql_select_db("pol");

$sysdate=date("Ymd H:i:s");
$sqlstr="update pol_items set sub_items='$items',loc='$bostr',mark='$mark',date='$sysdate',offset='$offset',imgoff='$img_off' where id='$iid'";
//echo $sql;
@mysql_query($sqlstr);

?>
