<?php
$data = array(1,1,1,1,1,1,1,1,1,1,"107_4",1,1,1,1,1,1,1,"107_3",1,1,1,1,1,"107_0","107_1","107_2",1,1,1,1,1,1,1,1,1,1,1,1,"107_4",1,1,1,1,1,1,1,"107_3",1,1,1,1,1,"107_0","107_1","107_2",1,1,1,1,1,1,1,1);



$ret = array();

for($i=0;$i<count($data);$i++)  {
    $itemid = $data[$i];

    if($itemid != 1 && $itemid != 10)   {
         $tmp = explode("_",$itemid);

         if(count($tmp)>1 && $tmp[1]==0)   {
               echo $i .":". $tmp[0] . "<br>";
               $marr = setItemMark($tmp[0],$i);

               while($marr)  {
			          array_push($ret,array_shift($marr));
               }
         }
    }
}

echo "<pre>";
print_r($ret);
echo "</pre>";


function setItemMark ($itemid,$cpos)  {
    echo $itemid .":". $cpos . "<br>-------<br>";

    $target_arr_width=16;

    $ret = array();

    $item=array();
    $item[$itemid]["mark"] = array(52,61,44,53,62,36,45,54,63,37,46,55,38,47);

    $item_mark = $item[$itemid]["mark"];

    $first_loc = $item_mark[0];
    $fox = intval($first_loc / 8);
    $foy = $first_loc % 8;

    $ret=array($cpos);

    for($i=1;$i<count($item_mark);$i++)  {
          $origin_id = $item_mark[$i];
          $ox = intval($origin_id / 8);
          $oy = $origin_id % 8;

          $offx = $ox - $fox;
          $offy = $oy - $foy;

          $tx = intval($cpos / $target_arr_width);
          $ty = $cpos % $target_arr_width;

          $ttx = $tx + $offx;
          $tty = $ty + $offy;

          $tpos = $ttx * $target_arr_width + $tty;

          if($ttx >=$target_arr_width || $ttx < 0 || $tty >=$target_arr_width || $tty < 0 )
                    $tpos = -1;

          array_push($ret,$tpos);

          //echo $origin_id .":". $tpos ."||" . $ttx .":". $tty . "<br>";
    }

    //echo "<pre>";
    //print_r($ret);
    //echo "</pre>";
    return $ret;
}


?>