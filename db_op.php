<?php
include_once( "config.php" );

class db_info
{
  var $conid;
  function db_info() {}

  function getdbconnection($connID="") {
    if($connID != "") {
        $this->conid = $connID;
        return true;
    }

	$this->conid = mysql_connect(DBHOST, DBUSER, DBPASSWORD);

	if ($this->conid) {
		mysql_select_db(DBNAME, $this->conid);
	} else {
		//fn_print_debug_msg("Can't get connection to MYSQL database in model 'user.php'.");
		return false;
	}
  }

  function exectuteSql($sqlstr) {
    mysql_query("Set Names 'gb2312'");
	$result = mysql_query($sqlstr, $this->conid);
    if($result)
       $totalMsg = mysql_num_rows($result);
    else
       return false;
    if($totalMsg<=0)
         return false;
    else
         return $result;
  }

  function exectuteSql_config($sqlstr) {
//echo $sqlstr . "<br>";
	return mysql_query($sqlstr, $this->conid);
  }

  function deleteSql($sqlstr) {
    mysql_query("Set Names 'gb2312'");

//echo $sqlstr . "<br>";
	$result = mysql_query($sqlstr, $this->conid);
    return $result;
  }

  /*
  $tbl  table name
  $nl field list arr
  $vl value list arr
  */
  function insertSql($tbl,$arr) {

    $nl = array();
    $vl = array();
    for($i=0;$i<count($arr);$i++) {
        $nl[$i] = "`" . $arr[$i][0] . "`";
        $vl[$i] = $arr[$i][1];
    }

    $fstr = $this->arr2str($nl,0);
    $vstr = $this->arr2str($vl,1);
    $sql = "insert into " .$tbl . " (".$fstr.")" . "values (" . $vstr . ")";

//echo $sql;

    mysql_query("Set Names 'gb2312'");
    $ret = mysql_query($sql, $this->conid);

    if($ms_err = mysql_error($this->conid))  {
          echo "error occured:$sql <br>";
    }

    return $ret;
  }



//-----------------------------------------------------------
  function updateSql($tbl,$arr,$conditionStr) {
//    $tbl = mb_strtolower($tbl,"sjis");

    $tmp_arr = $arr;
    $u_str="";
    while($arr) {
       $tmp = array_shift($arr);
       $u_str .= $tmp[0] ."='". $tmp[1] . "',";
    //  echo '<br>'.$u_str;
    }
    $u_str = substr($u_str,0,strlen($u_str)-1);
    $sql = "update " . $tbl . " set " .$u_str. " where " . $conditionStr;

//if($tbl == "PTA411" || $tbl == "pta411")
//   echo $sql . "<br>";

    mysql_query("Set Names 'gb2312'");
    $ret = mysql_query($sql, $this->conid);

//echo $tbl . "----" . IS_WRITE_TO_RETRIEVE . "<br>";

    $tbl = strtolower($tbl);
    if($ms_err = mysql_error($this->conid)) {
          echo "$ms_err";
    }

    return $ret;
  }
//--------------------------------------------------------
  function arr2str($arr,$type) {
    $str="";
    if($type) {
       while($arr) {
          $str = $str ."'". array_shift($arr) ."'". ",";
       }
    } else {
       while($arr) {
          $str = $str . array_shift($arr) . ",";
       }
    }
    return substr($str,0,strlen($str)-1);
  }

  function get_max_recordID($table,$field) {
     $sql = "select max($field) from $table";
     $result=$this->exectuteSql($sql);
     if(!$result) return 0;
     $row=mysql_fetch_array($result);
     if($row[0]==NULL)
         return 0;
     return $row[0];
  }

  function get_count($table) {
     $sql = "select count(*) from $table";
     $result=$this->exectuteSql($sql);
     if(!$result) return false;
     $row=mysql_fetch_array($result);
     return $row[0];
  }

  function show_table($tbl) {
//     $tbl = mb_strtolower($tbl,"sjis");
     $sql="select * from $tbl";
     $result=$this->exectuteSql($sql);
     if(!$result) return false;

     while($row=mysql_fetch_array($result)) {
        echo "<pre>";
        print_r($row);
        echo "</pre>";
     }
  }

  function getIDFromSql($sql) {
  }

  function addFTIdx($id)  {
     $ft = new ft_index_dao();
     $ft->setID($id);
     $ft->execute();
  }

  function closedbconnection() {
//  echo "cID:$this->conid\n";
    mysql_close($this->conid);
  }
}
?>
