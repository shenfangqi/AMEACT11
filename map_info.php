<?php
include_once( "config.php" );

class map_info
{
  var $conid;

/*
  var $map_data = array(
"3",1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1
  );
*/

var $map_offset_arr = array();
var $map_mark_arr = array();
var $roomID;
var $map_data;
var $link;
var $sce;
var $items;
var $nick;
var $looks;
var $size;

function map_info($roomID) {
     $this->link=mysql_connect (DBHOST, DBUSER, DBPASSWORD);
     mysql_select_db(DBNAME,$this->link);
     $this->roomID=$roomID;
     $this->user=$user;
     $this->pass=$pass;
     $map_str = $this->getMapData();
     $this->map_data = explode(",",$map_str);
}

function setMapSize($size) {
     $this->size = $size;
}

function outPutMap() {
     $off = $this->getOffsetArr();
     $mark = $this->getMarkArr();
     $enditems = $this->getEndItemArr();

     $imgoff = $this->getImgOffsetArr();
     $subitems = $this->getSubitemsArr();
     $sublocs = $this->getSubLocatesArr();
     $itemNum =  "var itemNum=".count($this->getItemID()).";";

     echo "<script language='javascript'>";
     $s="var  map_all = Array(";
     for($i=0;$i<count($this->map_data);$i++)  {
          $s .= $this->map_data[$i] . ",";
     }
     $s = substr($s,0,-1);
     $s=$s. ");";

     $s .= $off;
     $s .= $mark;
     $s .= $enditems;
     $s .= $imgoff;
     $s .= $subitems;
     $s .= $sublocs;
     $s .= $itemNum;

     echo $s;
     echo "</script>";
     //return $this->map_data;
}

function getRoomSce() {
     return $this->sce;
}

function getNick() {
     return $this->nick;
}

function getLooks() {
     return $this->looks;
}

function getUserInfo($user) {
     $sql="select dispName,looks from `pol_user` where username = '$user'";

     $result=$this->exectuteSql($sql);

     if($result)  {
          $row=@mysql_fetch_array($result);
          return array($row[0],$row[1]);
     }
}

function getMapData() {
  $sql="select roomdata,roomtype,items,dispName,looks from `pol_user` where username = '$this->roomID'";

  $result=$this->exectuteSql($sql);

  if($result)  {
       $row=@mysql_fetch_array($result);
       $this->sce = $row[1];
       $this->items = $row[2];
       $this->nick = $row[3];
       $this->looks = $row[4];
       return $row[0];
  }
}


function getOffsetArr_1()  {
  $ret="var  map_offset = Array();";
  $item_arr = $this->getItemID();

  for($i=0;$i<count($item_arr);$i++)   {
       $iid=$item_arr[$i];
       $sql="select offset from pol_items where id=$iid";

       $result=$this->exectuteSql($sql);
       if($result)  {
           $row=@mysql_fetch_array($result);
           if($iid !=1 && $iid !=2)
               $ret .= "map_offset[".$iid."]=". $row["offset"] .";" ;
       }
  }
  return $ret;
}

function getOffsetArr()  {
  $ret="var  map_offset = Array();";
  $item_arr = $this->getItemID();

  for($i=0;$i<count($item_arr);$i++)   {
       $iid_str=$item_arr[$i];

       $iid_str =ltrim($iid_str,"\"");
       $iid_str =rtrim($iid_str,"\"");

       $iid_arr = explode("|",$iid_str);

       while($iid_arr) {
          $iid = array_shift($iid_arr);
          $sql="select offset from pol_items where id=\"$iid\"";

//echo $sql . "<br>";

          $result=$this->exectuteSql($sql);
          if($result)  {
              $row=@mysql_fetch_array($result);
              if($iid !=1 && $iid !=2)
                  $ret .= "map_offset[\"".$iid."\"]=". $row["offset"] .";" ;
          }
       }
  }
  return $ret;
}


function getImgOffsetArr()  {
  $ret="var img_offset = Array();";

//  $item_arr = $this->getFinalMultiItemArr();
    $item_arr = explode(",",$this->getFinalItemArr());

//  while (list($key, $value) = each($item_arr)) {
    for($i=0;$i<count($item_arr);$i++) {
       $sql="select imgoff from pol_items where id='".$item_arr[$i]."'";
       $result=$this->exectuteSql($sql);
       if($result)  {
            $row=@mysql_fetch_array($result);
            $ret .= "img_offset['".$item_arr[$i]."']=". $row["imgoff"] .";";
       }
  }

  return $ret;
}


function getSubitemsArr()  {
  $ret="var sub_items = Array(); var wholeImgOff = Array();";

  $cdi=$this->getFinalItemArr();

  $sql="select id,sub_items,imgoff from pol_items where id in ($cdi)";

  $result=$this->exectuteSql($sql);

  while($row=@mysql_fetch_array($result))  {
       $key = $row["id"];
       if($row["sub_items"]=="")
            $val=$key;
       else
            $val=substr($row["sub_items"],0,-2);

       $val1=$row["imgoff"];


       $val = preg_replace('/(.png)/', "", $val);
       $ret .= "sub_items['".$key."']='". $val ."';";
       $ret .= "wholeImgOff['".$key."']='". $val1 ."';";
  }

  return $ret;
}


function getSubLocatesArr() {
  $ret="var sub_locs = Array();";

  $cdi=$this->getFinalItemArr();

  $sql="select id,loc from pol_items where id in ($cdi)";

//$ret .= $sql;

  $result=$this->exectuteSql($sql);

  while($row=@mysql_fetch_array($result))  {
       $key = $row["id"];
       $ret .= "sub_locs['".$key."']='". $row["loc"] ."';";
  }

  return $ret;
}



function getMarkArr()  {
  $ret="var  map_mark = Array();";
  $item_arr = $this->getMapUnpassArr();

  for($i=0;$i<count($item_arr);$i++)   {
        $ret .= "map_mark[$i]=". $item_arr[$i] .";" ;
  }
  return $ret;
}






function getEndItemArr()  {
  $ret="var  map_enditem = Array();";
  $item_arr = $this->getFinalMultiItemArr_repeat();

  while (list($key, $value) = each($item_arr)) {
        $ret .= "map_enditem[$key]='$value';" ;
  }

  return $ret;
}


/*
function getMarkArr()  {
  $ret=array();
  $item_arr = $this->getItemID();
  for($i=0;$i<count($item_arr);$i++)   {
       $iid=$item_arr[$i];
       $sql="select mark from pol_items where id='$iid'";
       $result=$this->exectuteSql($sql);

       if($result)  {
          $row=@mysql_fetch_array($result);
          $mr=explode(",",$row["mark"]);

          for($j=0;$j<count($mr);$j++)  {
              if( !in_array($mr[$j],$ret) )
                   array_push($ret,$mr[$j]);
          }
       }
  }
  return $ret;
}
*/


function getImgIDMarkArr($iid)  {
  $sql="select mark from pol_items where id='$iid'";

  //echo $sql;

  $result=$this->exectuteSql($sql);

  if($result)  {
     $row=@mysql_fetch_array($result);
     $mr=explode(",",$row["mark"]);
     return $mr;
  }
}

function getImgIDEndItemArr($iid)  {
  $sql="select sub_items from pol_items where id='$iid'";

  $result=$this->exectuteSql($sql);

  if($result)  {
     $row=@mysql_fetch_array($result);
     $mr=explode("||",$row["sub_items"]);
     return $mr[count($mr)-2];
  }
}

function getFirstLoc($iid) {
  $sql="select loc from pol_items where id='$iid'";

  $result=$this->exectuteSql($sql);

  if($result)  {
      $row=@mysql_fetch_array($result);
      $str_arr = explode(",",$row[0]);
      return $str_arr[0];
  }
  echo "first loc error.";
  return false;
}

function getImgBottomSeqID($iid) {
  $sql="select loc from pol_items where id='$iid'";

  $result=$this->exectuteSql($sql);

  $cmpVal=-1;
  $seqID=-1;

  if($result)  {
     $row=@mysql_fetch_array($result);
     $mr=explode(",",$row["loc"]);

     for($i=0;$i<count($mr);$i++)  {
          if($mr[$i] > $cmpVal)  {
                $cmpVal = $mr[$i];
                $seqID=$i;
          }
     }

     return $seqID;;
  }
  return false;
}

function getItemID()  {
     $ret=array();
     for($i=0;$i<count($this->map_data);$i++)   {
         if(!$this->isBGImg($this->map_data[$i])  && !in_array($this->map_data[$i],$ret))
             array_push($ret,$this->map_data[$i]);
     }
     return $ret;
}

function exectuteSql($sqlstr) {
    mysql_query("Set Names 'gb2312'");
	$result = @mysql_query($sqlstr,$this->link);
    if($result)
       $totalMsg = mysql_num_rows($result);
    else
       return false;
    if($totalMsg<=0)
         return false;
    else
         return $result;
}


function setItemMark($cpos,$itemid,$item_mark,$item_first_loc)  {

//echo "<pre>";
//print_r($item_mark);
//echo "</pre>";

//echo "first:$item_first_loc<br>";

    $target_arr_width = $this->size;

    $ret = array();

    //$item=array();
    //$item[$itemid]["mark"] = array(52,61,44,53,62,36,45,54,63,37,46,55,38,47);

    //$item_mark = $item[$itemid]["mark"];

    $fox = intval($cpos / $target_arr_width);
    $foy = $cpos % $target_arr_width;

    $eox = intval($item_first_loc / 8);
    $eoy = $item_first_loc % 8;

    $offx = $fox - $eox;
    $offy = $foy - $eoy;

    $ret=array($cpos);

    for($i=1;$i<count($item_mark);$i++)  {
          $origin_id = $item_mark[$i];
          $ox = intval($origin_id / 8);
          $oy = $origin_id % 8;

          $ttx = $ox + $offx;
          $tty = $oy + $offy;

          $tpos = $ttx * $target_arr_width + $tty;

          if($ttx >=$target_arr_width || $ttx < 0 || $tty >=$target_arr_width || $tty < 0 )
                    $tpos = -1;

          array_push($ret,$tpos);

          //echo $origin_id .":". $tpos ."||" . $ttx .":". $tty . "<br>";
    }

    //echo "<pre>";
    //print_r($ret);
    //echo "</pre>";

//exit;

    return $ret;
}


function getUnpassable($fp,$fd,$mark)   {
   $first_item_pos = $fp;
   $first_item_id = $fd;
   $item_mark_arr_ordered = $mark;

    $orgin_arr_width=8;
    $target_arr_width=32;

    $ret=array($first_item_pos);

    $target_item_pos_row_off = (int)($first_item_pos / $target_arr_width);
    $target_item_pos_col_off = (int)($first_item_pos % $target_arr_width);

    $first_item_pos_row_off = (int)($item_mark_arr_ordered[0] / $orgin_arr_width);
    $first_item_pos_col_off = (int)($item_mark_arr_ordered[0] % $orgin_arr_width);

    for($i=1;$i<count($item_mark_arr_ordered);$i++)  {
          $row_off = (int)($item_mark_arr_ordered[$i] / $orgin_arr_width);
          $col_off = (int)($item_mark_arr_ordered[$i] % $orgin_arr_width);

          $t_row_off = $target_item_pos_row_off + ($row_off - $first_item_pos_row_off);
          $t_col_off = $target_item_pos_col_off + ($col_off - $first_item_pos_col_off);

          //echo $t_row_off .":". $t_col_off . "<br>";

          if($t_col_off >=$target_arr_width || $t_col_off < 0 || $t_row_off >=$target_arr_width || $t_row_off < 0 )  {
              array_push($ret,-1);
          } else {
              array_push($ret,$t_row_off * $target_arr_width + $t_col_off);
          }
     }

     return $ret;
}

function getFinalMultiItemArr()  {
     $ret=array();
     for($i=0;$i<count($this->map_data);$i++)  {
          if(!$this->isBGImg($this->map_data[$i]))   {
              $imgid=$this->map_data[$i];
              $imgid = preg_replace('/(\")/', "", $imgid);
              $imgid_arr=explode("_",$imgid);
              if(count($imgid_arr)>1)
              {
                    $first_item_pos = $i;
                    $first_item_id = $imgid_arr[0];
                    $end_item=$i;

                    $ret[$first_item_id]=$end_item;
              }
          }
     }
     return $ret;
}


// return array like  arr[imgid]=(pos1,pos2,pos3....)  for 1 item was located in various places.
function getFinalMultiItemArr_repeat()  {
     $ret=array();
     for($i=0;$i<count($this->map_data);$i++)  {
          if(!$this->isBGImg($this->map_data[$i]))   {
              $imgid=$this->map_data[$i];
              $imgid = preg_replace('/(\")/', "", $imgid);

              $iid_arr = explode("|",$imgid);

              while($iid_arr) {
                        $imgid = array_shift($iid_arr);
                        $imgid_arr=explode("_",$imgid);
                        if(count($imgid_arr)>1)
                        {
                              $first_item_pos = $i;
                              $first_item_id = $imgid_arr[0];
                              $second_item_id = $imgid_arr[1];
                              $end_item=$i;

                              if(array_key_exists( $first_item_id , $ret)) {
                              //if($ret[$first_item_id]!="")  {
                                   if(($second_item_id)==$this->getImgBottomSeqID($first_item_id))
                                          $ret[$first_item_id]=$ret[$first_item_id].",".$end_item;
                              }
                              else {
                                   if(($second_item_id)==$this->getImgBottomSeqID($first_item_id))
                                          $ret[$first_item_id]=$end_item;
                              }
                        }
              }


          }
     }
     return $ret;
}



function getFinalItemArr() {
     return $this->items;

     //if($this->roomID==1) {
     //    return "66,71,72,73,75,76,77,78,88,89,90,91,92,93,94,95,96,96,10";
     //}
     //else if($this->roomID==2) {
     //    return "81,82,83,84,85,86,87,10";
     //}
}


function getMapUnpassArr1()  {
     $ret=array();
     for($i=0;$i<count($this->map_data);$i++)  {
          if(!$this->isBGImg($this->map_data[$i]))   {
              $imgid=$this->map_data[$i];
              $imgid_arr=explode("_",$imgid);
              if(count($imgid_arr)==1)
              {
                    array_push($ret,$i);
              }
              else
              {
                    $first_item_pos = $i;
                    $imgid_arr[0] = substr($imgid_arr[0],1);
                    $first_item_id = $imgid_arr[0];
                    $item_mark_arr_ordered=$this->getImgIDMarkArr($imgid_arr[0]);
                    $marr=$this->setItemMark($first_item_pos,$first_item_id,$item_mark_arr_ordered);
                    while($marr)  {
                        array_push($ret,array_shift($marr));
                    }
              }
          }
     }

echo "<pre>";
print_r($ret);
echo "</pre>";
exit;

     return $ret;
}

function getMapUnpassArr()  {
     $ret = array();

     for($i=0;$i<count($this->map_data);$i++)  {
         $itemid = $this->map_data[$i];

         if($itemid != 1 && $itemid != 10)   {
              $tmp = explode("_",$itemid);

              if(count($tmp)==1)
              {
                    array_push($ret,$i);
              }
              else if(count($tmp)>1 && $tmp[1]==0)   {
                    //echo $i .":". $tmp[0] . "<br>";
                    $tmp[0] = substr($tmp[0],1);
                    $item_mark_arr_ordered=$this->getImgIDMarkArr($tmp[0]);
                    $item_first_loc = $this->getFirstLoc($tmp[0]);
                    $marr = $this->setItemMark($i,$tmp[0],$item_mark_arr_ordered,$item_first_loc);

                    while($marr)  {
     			          array_push($ret,array_shift($marr));
                    }
              }
         }
     }

//echo "<pre>";
//print_r($ret);
//echo "</pre>";
//exit;
    return $ret;
}




function isBGImg($imgid)   {
     if($imgid == 1 || $imgid == 2)  {
          return true;
     }
     return false;
}

function getRandomPos()  {
    srand(time());

    $go=true;
    while($go)  {
        $rpx = rand(12, 20);
        $rpy = rand(12, 20);
        $p=$rpx*32+$rpy;
        if($this->map_data[$p]==1)  {
            $go=false;
        }
    }
    return $p;
}

}