    var Sprite=function(){
         this.px=0;
         this.py=0;
    }
    
    /**
     *
     */
    Sprite.prototype={

        draw:function() {
           var posX;
           var posY;
           var mul=1;
           var pa = loc2pos(this.pos);
           posX = pa[0] + parseInt(this.repeatPathCnt*mul)*16;
           posY = pa[1] - this.height;           
           
           var imgDir = imgByDir_cha(this.spriteID,this.dir);
           var posX1,posY1;
           
           if(this.dir==6) {
               posX1 = pa[0] - parseInt(this.repeatPathCnt)*8;
               posY1 = pa[1] - this.height;
           } else if(this.dir==2) {
               posX1 = pa[0] + parseInt(this.repeatPathCnt)*8;
               posY1 = pa[1] - this.height;
           } else if(this.dir==5) {
               posX1 = pa[0] + parseInt(this.repeatPathCnt)*8;
               posY1 = pa[1] - this.height + parseInt(this.repeatPathCnt)*4;
           } else if(this.dir==3) {
               posX1 = pa[0] - parseInt(this.repeatPathCnt)*8;
               posY1 = pa[1] - this.height - parseInt(this.repeatPathCnt)*4;
           } else if(this.dir==1) {
               posX1 = pa[0] + parseInt(this.repeatPathCnt)*8;
               posY1 = pa[1] - this.height - parseInt(this.repeatPathCnt)*4;
           } else if(this.dir==7) {
               posX1 = pa[0] - parseInt(this.repeatPathCnt)*8;
               posY1 = pa[1] - this.height + parseInt(this.repeatPathCnt)*4;
           } else if(this.dir==0) {
               posX1 = pa[0];
               posY1 = pa[1] - this.height - parseInt(this.repeatPathCnt)*8;
           } else if(this.dir==8) {
               posX1 = pa[0];
               posY1 = pa[1] - this.height + parseInt(this.repeatPathCnt)*8;
           }  else {
               posX1 = pa[0];
               posY1 = pa[1]-this.height;                
           }
           
           //25 和 40 值为人物被换成cha类型以后，于原单图类型相比的位置偏移量，25 的值为调整人物和建筑之间遮盖关系的关键
           //如果调整不好，建筑将遮盖住人物的部分
           posX1 = posX1-(this.width-half_tile_width)-8 + 25 ;
           posY1 = posY1 - screen_height_offset + 80;

           this.px=posX1;
           this.py=posY1;
           
           this.drawSprite(imgDir,posX1,posY1);
        },   

      
        drawSprite:function(dir,x,y) {
           try{
                if(this.hm.isLoaded ===1) {
                   if(x<bg_width) {
                      this.hm.setHMPos(x,y);
                      this.hm.setDir(dir)
                      //this.hm.setAniFrame(this.anID);
                      this.hm.drawFrame();
                      showPlayerLable(this.user);
                   } else {
                      hidePlayerLable(this.user);
                   }
                }

           } catch (e) {alert(e);}
        },        


        setSpriteID:function(val)  {
           this.spriteID=val;
        },
        
        setImg:function(spriteID) {
           this.spriteID=spriteID;
           this.img=spriteID+"_10";   // 10 is the default direction
           this.anID=0;           //animator pic id
           this.dir=1;           //initial for no dir
           this.repeatPathCnt=0;
      
           this.content="";
           this.cid=-1;
           this.sayTime=-1;
           this.actCnt=0;
           this.actStr="";
        },

        setUser:function(val) {
           this.user=val;
        },

        setHuman:function(val)  {
           this.hm=val;
        },

        setContent:function(vl) {
           this.content=vl;
        },

        setWidth:function(vl) {
           this.width=vl;
        },

        getWidth:function() {
           return this.width;
        },

        setHeight:function(vl) {
           this.height=vl;
        },

        setCid:function(vl) {
           this.cid=vl;
        },
        
        getCid:function() {
           return this.cid; 
        },
        
        setSayTime:function(vl) {
           this.sayTime=vl;
        },
        
        getSayTime:function() {
           return this.sayTime; 
        },
        
        getPosX:function() {
           return this.px; 
        },

        getPosY:function() {
           return this.py;
        },
        
        setPathVal:function(vl) {
           this.path=vl;  
        },

        getPathVal:function() {
           return this.path;  
        },

        setPathCntVal:function(vl) {
           this.pathCnt=vl;  
        },        
        
        getPathCntVal:function() {
           return this.pathCnt;  
        },          
        
        setSID:function(sid) {
           this.sid=sid;  
        },

        getSID:function() {
           return this.sid;  
        },

        setPos:function(pos) {
           this.pos=pos;  
        },        

        getPos:function() {
           return this.pos;  
        },  
        
        setRepeatPathCnt:function(val) {
           this.repeatPathCnt=val;
        },

        setActCntVal:function(vl) {
           this.actCnt=vl;  
        },
        
        setActStr:function(vl) {
           this.hm.action(vl);  //action str should start with &&
           this.actStr=vl.substring(2);
        },
        
        getActVal:function() {
           return this.actStr;  
        },
        
        setPath:function() {
           if(this.repeatPathCnt==0) {
                  var path = path_cal.Astar(target_pos,this.pos);
                  target_pos = 0;
                  if(iID)
                     clearInterval(iID);

                  if(pathEnd == false)   {
                      clearInterval(iID);
                      var playerPathArr = new Array;
                      var msg = this.path.toString();
                      var playerCnt = parseInt(this.pathCnt);
                      playerPathArr = msg.split(",");

                      var playerPathArr1 = playerPathArr.slice(0,playerCnt);
 
                      //$.ajax({type:"GET", url:"pol_test1.php?room="+room_id+"&user="+user+"&pos="+playerPathArr1, dataType:"text",async:false,success:function (msg){
	         		//alert(msg);
  	              //}});
                  }

                  this.path=path;
                  this.pathCnt=0;
                  this.repeatPathCnt=0;
                  pathEnd = false;

                  //iID=setInterval(this.move_main_player,spriteSpeed);
           }
        },

        login:function() {
           //alert("pol_test1.php?room="+room_id+"&user="+user+"&pos="+default_pos+"&sID="+this.spriteID+"&sHI="+this.height+"&sWI="+this.width);
           $.ajax({type:"GET", url:"pol_test1.php?room="+room_id+"&user="+user+"&pos="+default_pos+"&sID="+this.spriteID+"&sHI="+this.height+"&sWI="+this.width, dataType:"text",async:false,success:function (msg){
       		//alert(msg);
           }});        
        },

        move_main_player:function()  {
           var isMove=0;
           var isCurrentActEnd;
           
           if(mainsprite.path !="") {
              isMove=1;
              if(target_pos!=0 && mainsprite.repeatPathCnt==0) {   // 如果当前点了目标点，而且用户站到了起点上，则设置路径，否则继续前行
                  //alert("ccc:"+mainsprite.anID);
                  mainsprite.setPath(); 
              } else {
                  var ts = spriteMoveProcess_ht5(mainsprite);
                  ts.hm.setAniFrame(ts.anID);
                  ca.setMainSprite(ts);

                  //ca.mapReload();

                  var pathstr = ts.path.toString();
                  var playerPathArr = pathstr.split(",");

                  if(ts.getPathCntVal()+1 >= playerPathArr.length) {
                        //clearInterval(iID);
                        mainsprite.path="";
                        //$.ajax({type:"GET", url:"pol_test1.php?room="+room_id+"&user="+user+"&pos="+playerPathArr, dataType:"text",async:false,success:function (msg){
	             	//	pathEnd = true;
	                //}});

	                var sendStr=this.user+":0:"+playerPathArr+":1001"; 
                        socket.emit("msg",sendStr);
                        //conn.send(sendStr);                        

	                repeat=0;
                        scrollScr(mainsprite.px,mainsprite.py);
                  }
              }
           }

           if(mainsprite.actStr != "" && isMove==0) {
	      mainsprite.hm.setActFrame(mainsprite.actCnt);
	      mainsprite.actCnt++;
	      
	      var actstr = mainsprite.actStr.toString();
	      var playerActArr = actstr.split("&&");
	      
	      isCurrentActEnd=(mainsprite.actCnt == (playerActArr.length));  //arr string start with "&&"
	      
	      if(isCurrentActEnd) { 
	          mainsprite.actCnt=0;
	          mainsprite.actStr="";
	      }
	   }
	   
	}

    }
