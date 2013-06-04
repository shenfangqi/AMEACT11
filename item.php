<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
?>

<script src="MapData.js" type="text/javascript"></script>
<script src="utility.js"></script>
<script src="lib/jquery_new.js"></script>
<script src="custom.js" type="text/javascript"></script>
<script src="aStar1.js" type="text/javascript" ></script>
<script src="TerrainMark.js" type="text/javascript" ></script>
<script src="ResLoad.js" type="text/javascript"></script>

<script language="javascript">
var roomRes = new ResLoad();
roomRes.map_res_load(map_all,0);  //根据地?data load所有?源
</script>


<?php
echo session_id() . "<br>";

mysql_connect("localhost","root","") or die("Could not connect: " . mysql_error());
mysql_select_db("pol");

if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){

        $tp=$_POST["typesel"];
        mysql_query("INSERT INTO pol_items(type) values ($tp)");
        $iid=mysql_insert_id();

        $newdir="res/mapRes/up/$iid";

        if(!mkdir($newdir,"0755")) {
            echo "creating dir of $newdir failed.";
            exit;
        }

        //?了更高效，将信息存放在?量中
        $upfile=$_FILES["uploadfile"];//用一个数??型的字符串存放上?文件的信息
        //print_r($upfile);  //如果打印??出?似??的信息Array ( [name] => m.jpg [type] => image/jpeg [tmp_name] => C:\WINDOWS\Temp\php1A.tmp [error] => 0 [size] => 44905 )
        $name=$upfile["name"];  //便于以后?移文件?命名
        $type=$upfile["type"];  //上?文件的?型
        $size=$upfile["size"];  //上?文件的大小
        $tmp_name=$upfile["tmp_name"];   //用?上?文件的??名称
        $error=$upfile["error"];   //上??程中的??信息

        //?文件?型?行判断，判断是否要?移文件,如果符合要求??置$ok=1即可以?移

        switch($type){
            case "image/jpg": $ok=1;
            break;
            case "image/jpeg": $ok=1;
            break;
            case "image/gif" : $ok=1;
            break;
            case "image/png" : $ok=1;
            break;
            default:$ok=0;
            break;
        }

        $target_file_name=$newdir ."/". $iid.".png";
        //echo $tmp_name ."<--->". $target_file_name;

        //如果文件符合要求并且上??程中没有??
        if($ok==1&&$error==0){
            //?用move_uploaded_file（）函数，?行文件?移

            if(move_uploaded_file($tmp_name,$target_file_name)) {
               echo "sucesussful";
            } else {
               echo "failed";
            }

            list($width, $height, $type, $attr) = getimagesize($target_file_name);
            //echo "file name:" . $target_file_name . "<br>";
            //echo "img width:".$width . "<br>";
            //echo "img Height:".$height. "<br>";

            $img_name=$target_file_name;
            $img_width=$width;
            $img_height=$height;

            include_once("T0_PicEdit-c6.php");
            //echo "<img src=\"$target_file_name\" $attr>";
            //操作成功后，提示成功
            //echo "<script language=\"javascript\">alert('succeed')</script>";
        } else {
            //如果文件不符合?型或者上??程中有??，提示失?
            echo "<script language=\"javascript\">alert('upload error or not image file')</script>";
        }
}
?>



<!--?置提交文件的表?-->
<form enctype="multipart/form-data" method="post" name="uploadform">
<input type="file" name="uploadfile" value="Upload File">
<select name="typesel">
       <option value="1000">1000</option>
       <option value="1001">1001</option>
</select>
<input type="submit" name="submit" value="Upload">
</form>