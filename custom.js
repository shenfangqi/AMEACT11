var cycleID;
var count=0;
var i_oID;
var other_cnt ;

//$(document).ready(function() {
//      cycleID  = setInterval('setCycle()',3000);
//});


function setCycle() {
      var sid2str = "";
      var ajax_url = "";
      var sid2str = get_others_sid_str();

      //ajax_url = "pol_test2.php?room=1&user="+user+"&sidhash="+sid2str+"&cidhash="+get_cid_str();
      ajax_url = "pol_test2.php?room=1&user="+user+"&sidhash="+sid2str+"&cidhash="+get_cid_str()+"&sID="+main_img_id+"&sHI="+player_img_height;



//$("#sayText").val(sid2str);
$("#testinfo",window.parent.document).val(ajax_url);
////alert(ajax_url);

      $.ajax({type:"GET", url:ajax_url, dataType:"text",async:false,success:function (msg){
//$("#testinfo",window.parent.document).val(msg);

          removeNoExistPlayers(msg);
          var msg_arr = msg.split("__");

          //msg_arr[0] : the online users   msg_arr[1] : users and theirs info,location etc..
          if(msg_arr[1] !="") {
                 set_other_path(msg_arr[1]);
          }
          if(msg_arr[2] !="") {
                 set_chat_msg(msg_arr[2]);
          }              
          intervalChatMsg();
         
      }});

}

function get_others_sid_str() {
      var jobj = $("IMG[type='otherPlayer']");
      var sid_str="";
      for(var i=0;i<jobj.length;i++)   {
            var thisID = jobj[i].id;
            var thisSID = $("#" + thisID).attr("sid");
            sid_str += "||" + thisID  + ":"  + thisSID;
      }
      sid_str = sid_str.substring(2);
      return sid_str;
}

function get_cid_str() {
      var jobj = $("IMG[type='otherPlayer']");
      var cid_str="";
      for(var i=0;i<jobj.length;i++)   {
            var thisID = jobj[i].id;
            var thisCID = $("#" + thisID).attr("cid");
            cid_str += "||" + thisID  + ":"  + thisCID;
      }
      cid_str = cid_str.substring(2);

      var c = $("#mainplayer");
      var maincid = parseInt(c.attr("cid"));
      var thisID =user;
      cid_str =  thisID  + ":"  + maincid + "||" + cid_str;
      return cid_str;
}

function set_chat_msg(msg)  {
      //msg is like sfq:hi,pol<br>hi,all:1||pol:hello,sfq:2||ala:hi,all:3
      var t = msg.split("||");

      var otherName;
      for(var i=0;i<t.length;i++)   {
           var r = t[i].split(":");
           var content = unescape(r[1]);
           var cid = r[2];
           
           if(r[0]==user)
              otherName = "#mainplayer";
           else  
              otherName = "#" + r[0];

              
           if($(otherName)[0]) { 
               $(otherName).attr("content",content);
               $(otherName).attr("cid",cid);
               $(otherName).attr("sayTime",5);
               update_la_content(r[0],content);
           }
      }
}

function update_la_content(thisID,content) {
      var obj = getNameLable(thisID+"_la");
      if(content=="") {
         obj.innerHTML = getNameLableStyle(thisID+"_la");
      }
      else
         obj.innerHTML = getChatBubbleStyle(content)+obj.innerHTML;
      mapReload();
}

function intervalChatMsg()  {
      var jobj = $("IMG[type='otherPlayer']");

      var otherName;
      var sayCnt;
      var tstr="tstr::::";

      for(var i=0;i<jobj.length;i++)   {
            var thisID = jobj[i].id;
            otherName = "#" + thisID;

           if($(otherName)[0]) { 
               sayCnt = parseInt($(otherName).attr("sayTime"));                    
               if(sayCnt>-1)  {      
                   sayCnt--;
                   $(otherName).attr("sayTime",sayCnt);
               } else {
                   update_la_content(thisID,"")
               }
               tstr +=  $(otherName).attr("id")  +"__"+ $(otherName).attr("sayTime")  + "__";
           }
      }

      var c = $("#mainplayer");
      sayCnt = parseInt(c.attr("sayTime"));
      if(sayCnt>-1)  {
          sayCnt--;
          c.attr("sayTime",sayCnt);
      } else {
          update_la_content(user,"");     
      }
      tstr += user  +"__"+ c.attr("sayTime")  + "__";

//$("#sayText").val(tstr);               

}


function set_other_path(msg)  {
      clearInterval(i_oID);

      //msg is like sfq:34:1||pol:55:2||ala:77:3
      var t = msg.split("||");

      var otherName;
      for(var i=0;i<t.length;i++)   {
           var r = t[i].split(":");

               var spriteID = r[3];
               var spriteHeight =r[4];
               
//alert(msg+":"+spriteID);
               
               var paceNum;   //根据spriteID的值判断动画图片的张数
               if(spriteID<1000) {
                  paceNum=6;
               } else if(spriteID>=1000 && spriteID<2000) {
                  paceNum=2;
               } else {
                  paceNum=4;
               }

           //myHash.setItem(r[0],r[1]);
          
           otherName = "#" + r[0];
           if(!$(otherName)[0]) { 
               var cid=-1;
               CR_OtherPlayerTiles(spriteID,r[0],r[2],r[1],r[2],0,cid,spriteHeight);
           } else { 
               //php程序需要发送及获取方向的dir参数，以便确定角色的方向，最后1个应该为dir的值 
               Set_OtherPlayerTiles(otherName,r[1],r[2],0,8);
           }
      }
      
      other_cnt = 0;
      i_oID = setInterval('move_otherPlayers()',spriteSpeed);

}

function removeNoExistPlayers(msg) {
      var jobj = $("IMG[type='otherPlayer']");
      var msg_arr = msg.split("__");
      var online_users = msg_arr[0].split("||");
      
      for(var i=0;i<jobj.length;i++)   {
            var thisID = jobj[i].id;
            if(jQuery.inArray(thisID, online_users) == -1) {
                    removePlayerImg(thisID); 
                    removePlayerLable(thisID+"_la");
            }
      }
}

function removePlayerImg(thisID) {
      var other_obj  = $("#" + thisID);
      other_obj.remove();
      //myHash.removeItem(thisID);
}





function getMsgIDArr(msg) {
      var t = msg.split("||");
      var ta = new Array();
      for(var i=0;i<t.length;i++)   {
           var r = t[i].split(":");
           ta[i] = r[0];
      }
      return ta;
}

function test() {
      var jobj = $("IMG[type='otherPlayer']");

      for(var i=0;i<jobj.length;i++)   {
            var thisID = jobj[i].id;
            if($("#" + thisID).attr("removed") == 1)
                 alert(thisID +":"+ $("#" + thisID).attr("removed"));
      }
}


function move_otherPlayers() {
     var isEnd=true; 
     var maxpathlen = -1;
     var pathstr;
     var patharr;
     var pathCnt;
     var jobj = $("IMG[type='otherPlayer']");
     var other_obj;

     for(var i=0;i<jobj.length;i++)   {
            other_obj  = $("#" + jobj[i].id);
            pathstr = other_obj.attr("path").toString();
            patharr = pathstr.split(",");
            
            if(patharr.length>maxpathlen) 
                 maxpathlen = patharr.length;
     }

     var pos;
     for(var j=0; j<jobj.length; j++)   {
            other_obj  = $("#" + jobj[j].id);
            jobj[j] = spriteMoveProcess(other_obj);

            var pathstr = jobj[j].attr("path").toString();
            playerPathArr = pathstr.split(",");
            pathCnt = parseInt(jobj[j].attr("pathCnt"));
            
            isEnd = (pathCnt+1 == playerPathArr.length) & isEnd;
//alert(isEnd);
     }
   
     if(isEnd) 
            clearInterval(i_oID);
          
     other_cnt = other_cnt +1;     
     
     mapReload();
}


function CR_OtherPlayerTiles(spriteID,name,pos,sid,path,pathCnt,cid,spriteHeight) {
   var a = document.createElement("IMG");
   a.pos = pos;
   a.setAttribute("type","otherPlayer");
   a.setAttribute("id",name);
   
   //A001 设置人物图片
   //a.setAttribute("src",main_img_id+"_10"+ "_0.png");

   a.setAttribute("spriteID",spriteID);
   a.setAttribute("sid",sid);
   a.setAttribute("path",path);
   a.setAttribute("pathCnt",pathCnt);
   a.setAttribute("repeatPathCnt",0);
   a.setAttribute("removed",0);
   a.setAttribute("spriteHeight",spriteHeight);


   a.setAttribute("content","");
   a.setAttribute("cid",cid);
   a.setAttribute("sayTime",-1);

   a.style.position="absolute";
   
   var pp = loc2pos(pos);

   $("#lay0").append(a);
}



function Set_OtherPlayerTiles(otherName,sid,path,pathCnt,dir)  {
   $(otherName).attr("sid",sid);
   $(otherName).attr("path",path);
   $(otherName).attr("pathCnt",pathCnt);
   $(otherName).attr("direction",dir);
}




