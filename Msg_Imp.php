<?php
include_once( "db_op.php" );

class Msg_Imp	{
   var $db;

   function Msg_Imp()
   {
       $this->db = new db_info();
       $this->db->getdbconnection();
   }

   function input_chat_msg($roomid,$content,$sid,$from,$to) {
       $system_date = time();

       $ins_arr = array();
       $ins_arr[0][0] = "RoomID";
       $ins_arr[0][1] = $roomid;

       $ins_arr[1][0] = "Content";
       $ins_arr[1][1] = $content;

       $ins_arr[2][0] = "SessionID";
       $ins_arr[2][1] = $sid;

       $ins_arr[3][0] = "SaveTime";
       $ins_arr[3][1] = $system_date;

       $ins_arr[4][0] = "Fr";
       $ins_arr[4][1] = $from;

       $ins_arr[5][0] = "To";
       $ins_arr[5][1] = $to;

       return $this->db->insertSql("pol_chatmsg",$ins_arr);
   }

   function close()
   {
       $this->db->closedbconnection();
   }

}
?>