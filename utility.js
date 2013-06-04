function getPointInRhombus(px,py) {
            var x1,y1,x2,y2;
            var mx,my,mx1,my1,mx2,my2;
            //var tx,ty;
            var cx,cy;
            x1 = parseInt(px / half_tile_width);
            y1 = parseInt(py / tile_height_offset);
            mx1 = px%half_tile_width;
            my1 = py%tile_height_offset;

            if(mx1 + my1 < half_tile_width+tile_height_offset) {
            }

            mx=x1*half_tile_width;
            my=y1*tile_height_offset;

            if((x1+y1)%2 !=0) {
               cx=mx+half_tile_width;
               cy=my+tile_height_offset;
            } else {
               my=my+tile_height_offset;
               cx=mx+half_tile_width;
               cy=my-tile_height_offset;
            }

            var r1,r2;
            r1 = Math.abs(mx - px) + Math.abs(my - py);
            r2 = Math.abs(cx - px) + Math.abs(cy - py);

            if(r1<r2)  {
               px = mx;
               py = my;
            } else {
               px = cx;
               py = cy;
            }
        
            return parseInt(pos2loc(px,py));
}

function pos2loc(posX,posY) {
            var x,y;
            //posX = -y*16+512+x*16;
            //posY = 8+8*x+8*y;

            // poxX = 512+ 16*x - 16*y;
            // 2posY = 16+ 16*x + 16*y;


//            x = (2*posY + posX - half_bg_width - half_tile_width) / (half_tile_width * 2);
            x = (2*posY + posX - itemStartX - half_tile_width) / (half_tile_width * 2);
            y = (posY - tile_height_offset -tile_height_offset * x) / tile_height_offset;

            if(x<0 || y<0 || x>=map_arr_width || y>=map_arr_height) { 
               return -1;
            }
    
            return y*map_arr_width+x;
}
 
function pos2loc_test(posX,posY) {
            var x,y;
            //posX = -y*16+512+x*16;
            //posY = 8+8*x+8*y;

            // poxX = 512+ 16*x - 16*y;
            // 2posY = 16+ 16*x + 16*y;


            x = (2*posY + posX - half_bg_width - half_tile_width) / (half_tile_width * 2);
            y = (posY - tile_height_offset -tile_height_offset * x) / tile_height_offset;

alert(x+":"+y);

            //if(x<0 || y<0 || x>30 || y>30) {   //同上
            //   return -1;
            //}
    
}

 
function loc2pos(loc) {
            var x,y;
            var lx,ly;
             
            ly = parseInt(loc / map_arr_width);
            lx = loc % map_arr_width;
            
            //modified on 2011.03.01
            if(lx==map_arr_width-1) {lx=-1;ly=ly+1;}

            //alert(lx+":"+ly);
            
            //x = -ly*16+512+lx*16;
            //y = 8+8*lx+8*ly;

            x = itemStartX + half_tile_width * lx - half_tile_width * ly;
            y = tile_height_offset + tile_height_offset * lx + tile_height_offset * ly;        
             
            return Array(x,y);
}


//modified on 2011.03.03  this programe is used by TerrainMakr.js, in order to get the absolute postion of each loc. without edge logic while comparing to loc2pos
function loc2pos_absolute(loc) {
            var x,y;
            var lx,ly;
             
            ly = parseInt(loc / map_arr_width);
            lx = loc % map_arr_width;
            
            //modified on 2011.03.01
            //if(lx==map_arr_width-1) {lx=-1;ly=ly+1;}

            //alert(lx+":"+ly);
            
            //x = -ly*16+512+lx*16;
            //y = 8+8*lx+8*ly;

            x = half_bg_width + half_tile_width * lx - half_tile_width * ly;
            y = tile_height_offset + tile_height_offset * lx + tile_height_offset * ly;        
             
            return Array(x,y);
}

function is_terrain_passable(nid) {
           for(var i=0;i<map_mark.length;i++)  {
                if(nid == map_mark[i])
                  return true;
           }
           return false;
}


function Hash()
{
	this.length = 0;
	this.items = new Array();
	for (var i = 0; i < arguments.length; i += 2) {
		if (typeof(arguments[i + 1]) != 'undefined') {
			this.items[arguments[i]] = arguments[i + 1];
			this.length++;
		}
	}
   
	this.removeItem = function(in_key)
	{
		var tmp_previous;
		if (typeof(this.items[in_key]) != 'undefined') {
			this.length--;
			var tmp_previous = this.items[in_key];
			delete this.items[in_key];
		}
	   
		return tmp_previous;
	}

	this.getItem = function(in_key) {
		return this.items[in_key];
	}

	this.setItem = function(in_key, in_value)
	{
		var tmp_previous;
		if (typeof(in_value) != 'undefined') {
			if (typeof(this.items[in_key]) == 'undefined') {
				this.length++;
			}
			else {
				tmp_previous = this.items[in_key];
			}

			this.items[in_key] = in_value;
		}
	   
		return tmp_previous;
	}

	this.hasItem = function(in_key)
	{
		return typeof(this.items[in_key]) != 'undefined';
	}

	this.clear = function()
	{
		for (var i in this.items) {
			delete this.items[i];
		}

		this.length = 0;
	}
	
	this.getLength = function() 
	{
	        return this.length;
	}
}

function createTwoDimensionArray(n,m)  { 
        var arr=new Array(n);for(var i=0;i<n;i++){arr[i]=new Array(m);}return arr;
}

function in_obj_array(v,a){
        for(key in a){
            if(a[key].pos==v) return true
        }
        return false;
}


/*
function pathArr2cordArr(path) {
//alert("path:"+path);
        var tp;
        var np;
        var path_pos_arr = new Array();
        
        for(var i=0;i<path.length-1;i++)  {
           tp = path[i];
           np = path[i+1];
           path_pos_arr = path2cord(tp,np,path_pos_arr)
        }
//alert("path_pos_arr:"+path_pos_arr);
        return path_pos_arr;
}


function path2cord(thispos,nextpos,path_pos_arr) {
        var thisloc = loc2pos(thispos);
        var nextloc = loc2pos(nextpos);
        
//alert("para:"+thisloc+"||"+nextloc);
        
        var ret  = new Array();
        if(nextpos == thispos+map_arr_width-1 || nextpos == thispos-map_arr_width+1) {  //left 2 right  and right 2 left
           //ret[0] = thisloc[0] +"|"+ thisloc[1];
           ret[0] = (thisloc[0]+nextloc[0])/2 +"|"+ thisloc[1];
           ret[1] = nextloc[0] +"|"+ nextloc[1];
        //} 
        //else if(nextpos == thispos-map_arr_width+1) {  //left 2 right
        //
        } else {
           //ret[0] = thisloc[0] +"|"+ thisloc[1];
           ret[0] = nextloc[0] +"|"+ nextloc[1];
        }
        return path_pos_arr.concat(ret);
}
*/


function spriteMoveProcess_ht5(thisSprite)  {
           var playerPathArr = new Array;
           var rc = parseInt(thisSprite.repeatPathCnt);
           var anID = parseInt(thisSprite.anID);
           var pathstr = thisSprite.path.toString();
           var dir;
           playerPathArr = pathstr.split(",");
           var playerCnt = thisSprite.getPathCntVal();

           var pos = playerPathArr[playerCnt];
           
           var rl=6;    //横向走完1格的?数
           var norl=2;  //非横向走完1格的?数

/*           
           var paceNum=6;  //?画?片数
           if(thisSprite.spriteID<1000) {
              paceNum=6;
           } else if(thisSprite.spriteID>=1000 && thisSprite.spriteID<2000) {
              paceNum=2;
           } else {
              paceNum=4;
           }
           $("#sayText").val(paceNum);
*/
          
           if(pos)  {
                 thisPos = parseInt(playerPathArr[playerCnt]);
                 nextPos = parseInt(playerPathArr[playerCnt+1]);
           
                 if((nextPos == thisPos + map_arr_width -1))  {  //Next pos is to the left of current pos
                      if(rc<rl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=rl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 6;
                 } 
                 else if((nextPos == thisPos - map_arr_width +1))  { //Next pos is to the right of current pos
                      if(rc<rl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=rl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 2;
                 }
                 else if(nextPos == thisPos + 1)  {
                      if(rc<norl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=norl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 5;
                 }
                 else if(nextPos == thisPos - 1)  {
                      if(rc<norl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=norl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 3;
                 }
                 else if(nextPos == thisPos + map_arr_width)  {
                      if(rc<norl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=norl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 7;
                 }
                 else if(nextPos == thisPos - map_arr_width)  {
                      if(rc<norl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=norl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 1;
                 }
                 else if(nextPos == thisPos + map_arr_width + 1)  {
                      if(rc<norl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=norl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 8;
                 }
                 else if(nextPos == thisPos - map_arr_width - 1)  {
                      if(rc<norl) {
                        rc++;
                        thisSprite.pos = thisPos;
                      } else if(rc>=norl){
                        rc=0;
                        thisSprite.pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.repeatPathCnt = rc;
                      thisSprite.dir = 0;
                 } 
                 //else {
                 //     alert(thisPos+":"+nextPos);
                 //     //thisSprite.dir = 8;
                 //}

                 thisSprite.pathCnt=playerCnt;

                 anID++;
                 //paceNum 用?走路?画frame数，再主程序中由anistr?得
                 if(anID>paceNum) {
                      anID =0;
                 }                 
                 
                 if(playerCnt+1 >=playerPathArr.length) {  //reset thisSprite pic when end
                      anID =0;
                 }
                 thisSprite.anID =anID;
           } else {
                 //alert("no pos error");
           }
           
           return thisSprite;
}




function spriteMoveProcess(thisSprite)  {
           var playerPathArr = new Array;
           var spriteID = parseInt(thisSprite.attr("spriteID"));
           var spriteHeight = parseInt(thisSprite.attr("spriteHeight"));

           var rc = parseInt(thisSprite.attr("repeatPathCnt"));
           var pathstr = thisSprite.attr("path").toString();
           var anID =  parseInt(thisSprite.attr("anID"));

           playerPathArr = pathstr.split(",");
           var playerCnt = parseInt(thisSprite.attr("pathCnt"));
           
           var pos = playerPathArr[playerCnt];
           
           var paceNum=6;  //?画?片数
           
           if(spriteID<1000) {
              paceNum=6;
           } else if(spriteID>=1000 && spriteID<2000) {
              paceNum=2;
           } else {
              paceNum=4;
           }


           if(pos)  {
                 thisPos = parseInt(playerPathArr[playerCnt]);
                 nextPos = parseInt(playerPathArr[playerCnt+1]);
                 
//alert(pos+":"+playerPathArr+":"+playerCnt);
//alert(thisPos+":"+nextPos);

                 //if(isNaN(thisPos) || isNaN(nextPos))  {
                 //     playerCnt++;
                 //}
                 //else 
                 
                 if((nextPos == thisPos + map_arr_width -1))  {  //Next pos is to the left of current pos
                      if(rc<6) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=6){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",6);
                 } 
                 else if((nextPos == thisPos - map_arr_width +1))  { //Next pos is to the right of current pos
                      if(rc<6) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=6){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",2);
                 }
                 else if(nextPos == thisPos + 1)  {
                      if(rc<2) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=2){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",5);
                 }
                 else if(nextPos == thisPos - 1)  {
                      if(rc<2) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=2){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",3);
                 }
                 else if(nextPos == thisPos + map_arr_width)  {
                      if(rc<2) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=2){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",7);
                 }
                 else if(nextPos == thisPos - map_arr_width)  {
                      if(rc<2) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=2){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",1);
                 }
                 else if(nextPos == thisPos + map_arr_width + 1)  {
                      if(rc<2) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=2){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",8);
                 }
                 else if(nextPos == thisPos - map_arr_width - 1)  {
                      if(rc<2) {
                        rc++;
                        thisSprite[0].pos = thisPos;
                      } else if(rc>=2){
                        rc=0;
                        thisSprite[0].pos = nextPos;
                        playerCnt++;
                      }
                      thisSprite.attr("repeatPathCnt",rc);
                      thisSprite.attr("direction",0);
                 } 
                 //else {
                 //     thisSprite.attr("direction",1);
                 //}
                 
                 var pa =  loc2pos(parseInt(thisSprite[0].pos));

                 var dir = parseInt(thisSprite.attr("direction"));

                 if(dir==6) {
                     posX = pa[0] - rc*8;
                     posY = pa[1]-spriteHeight;
                 } else if(dir==2) {
                     posX = pa[0] + rc*8;
                     posY = pa[1]-spriteHeight;
                 } else if(dir==5) {
                     posX = pa[0] + rc*8;
                     posY = pa[1] - spriteHeight + rc*4;
                 } else if(dir==3) {
                     posX = pa[0] - rc*8;
                     posY = pa[1] - spriteHeight - rc*4;
                 } else if(dir==1) {
                     posX = pa[0] + rc*8;
                     posY = pa[1] - spriteHeight - rc*4;
                 } else if(dir==7) {
                     posX = pa[0] - rc*8;
                     posY = pa[1] - spriteHeight + rc*4;
                 } else if(dir==0) {
                     posX = pa[0];
                     posY = pa[1] - spriteHeight - rc*8;
                 } else if(dir==8) {
                     posX = pa[0];
                     posY = pa[1] - spriteHeight + rc*8;
                 } else {
                     posX = pa[0];
                     posY = pa[1]-spriteHeight;
                     dir = 1;
                 }

                 thisSprite.css("left",posX);
                 
//alert(posY +":::"+ screen_height_offset);
                 posY = posY - screen_height_offset;
                 
                 thisSprite.css("top",posY);

                 thisSprite.attr("pathCnt",playerCnt);

                 var thisImg = imgByDir(spriteID,dir);
//alert(thisImg+":"+dir);

                 anID++;
                 if(anID>paceNum) {
                    anID =0;
                 }

                 if(playerCnt+1 >=playerPathArr.length) {  //reset thisSprite pic when end
		     anID =0;
                 }

                 thisSprite.attr("src","res/spriteRes/"+spriteID+"/"+thisImg +"_" + anID + ".png"); 

                 thisSprite.attr("anID",anID);
                 
           }
           
           return thisSprite;
}




/*
0 1 2
2 4 5
6 7 8

assume 4 is the current pos.
*/
function spriteDir(thisPos,nextPos)  {
//alert(thisPos+":"+nextPos);

           thisPos =parseInt(thisPos);
           nextPos =parseInt(nextPos);

           var dir=-1;
           if(nextPos == thisPos+1)  {
               dir=5;   
           }
           else if(nextPos == thisPos-1)  {
               dir=3;   
           }
           else if(nextPos == thisPos+map_arr_width)  {
               dir=7;   
           }
           else if(nextPos == thisPos-map_arr_width)  {
               dir=1;   
           }
           else if(nextPos == thisPos+map_arr_width+1)  {
               dir=8;   
           }
           else if(nextPos == thisPos+map_arr_width-1)  {
               dir=6;   
           }
           else if(nextPos == thisPos-map_arr_width+1)  {
               dir=2;   
           }
           else if(nextPos == thisPos-map_arr_width-1)  {
               dir=0;   
           }
           return dir;
}


//A001 "2_" ?原始?片放大1倍
function imgByDir(spriteID,dir) {
           var imgHead=spriteID+"_10";
           if(dir==0) {
              imgHead=spriteID+"_11";
           }
           else if(dir==1) {
              imgHead=spriteID+"_10";
           }
           else if(dir==2) {
              imgHead=spriteID+"_10";
           }
           else if(dir==3) {
              imgHead=spriteID+"_11";
           }
           else if(dir==5) {
              imgHead=spriteID+"_12";
           }
           else if(dir==6) {
              imgHead=spriteID+"_13";
           }
           else if(dir==7) {
              imgHead=spriteID+"_13";
           }
           else if(dir==8) {
              imgHead=spriteID+"_12";
           } else {
              imgHead=spriteID+"_10";
           }
           return imgHead;
}

function imgByDir_cha(spriteID,dir) {
           if(dir==0) {
              imgHead="lu";
           }
           else if(dir==1) {
              imgHead="ru";
           }
           else if(dir==2) {
              imgHead="ru";
           }
           else if(dir==3) {
              imgHead="lu";
           }
           else if(dir==5) {
              imgHead="rd";
           }
           else if(dir==6) {
              imgHead="ld";
           }
           else if(dir==7) {
              imgHead="ld";
           }
           else if(dir==8) {
              imgHead="rd";
           } else {
              imgHead="ru";
           }
           return imgHead;
}

function htmlPosStrToNumber(val) {
    return parseInt(val.substring(0,val.length-2));     //remove "px" from pos string
}

function getNameLable(name,dispname) {
    var obj;
    if($("#"+name)[0])
       obj = $("#"+name)[0];
    else {
      var obj = document.createElement("DIV");
      obj.setAttribute("id",name);
      obj.setAttribute("align","center");
      obj.style.position="absolute";
      obj.style.width="135px";
      obj.style.zIndex=99;
      obj.style.fontSize="20px";

      //obj.style.background="#000";
      
      if(name == user) 
           obj.innerHTML=getNameLableStyle_main(dispname);
      else 
           obj.innerHTML=getNameLableStyle(dispname);
    }
    return obj;
}

function getNameLableStyle(name)  {
    return "<br><div align='center' style='background: white;width:70px;z-index:10;font-size:18px'><b>"+name+"</b></div>";
    //return "<br><div align='center' style='width:70px;z-index:10;background:url(bg_talk.png)'><b>"+name+"</b></div>";
}

function getNameLableStyle_main(name)  {
    return "<br><div align='center' style='width:20px;z-index:10;font-size:18px'><img src='./res/icons/pos.png'></div>";
    //return "<br><div align='center' style='width:70px;z-index:10;background:url(bg_talk.png)'><b>"+name+"</b></div>";
}

function getChatBubbleStyle(content) {
    return "<p class='triangle-isosceles'>"+content+"</p>";
}

function update_la_content(thisID,content,thisDispName) {
      var obj = getNameLable(thisID,thisDispName);
      if(content=="") {
            if(thisID == user)
                   obj.innerHTML = getNameLableStyle_main(thisDispName);
            else 
                   obj.innerHTML = getNameLableStyle(thisDispName);
            //$(".triangle-isosceles").remove();
      }  else {
         obj.innerHTML = getChatBubbleStyle(content)+obj.innerHTML;
         //alert(obj.innerHTML);
         chatmsg="&nbsp<font color='blue'>"+thisDispName+":</font>"+content+"<br>"+chatmsg;
         $("lay").html(chatmsg);   
         
      }
      //ca.mapReload();
}


function removePlayerLable(thisID) {
      var lable_obj  = $("#" + thisID);
      lable_obj.remove();
}

function showPlayerLable(thisID) {
      var lable_obj  = $("#" + thisID);
      //console.log("ccc:"+lable_obj);
      lable_obj.css("display","");
}


function hidePlayerLable(thisID) {
      var lable_obj  = $("#" + thisID);
      //console.log("ccc:"+lable_obj);
      lable_obj.css("display","none");
}

function isBGImg(imgid)  {
      if(imgid == 1 || imgid == 2)  {
          return true;
      }
      return false;
}

function isTerrainImg(src)  {
      if(src.indexOf("/10.png") != -1 && hideBg==1)
          return true;
      return false;
}

function getItemOffset(iid)  {
     var iid_arr = iid.toString().split("_");
     if(map_offset[iid])  {
        if(iid_arr.length>1) {
           var iid_1=iid_arr[0];
           var iid_2=iid_arr[1];

           if(parseInt(iid_2) == 0)
             return map_offset[iid];
           else
             return 0;
        }  else  {
             return map_offset[iid];
        }
     } else {
        return 0;
     }
}


function point(x,y,w,h,i,src,id){
      var _img = document.createElement("img");
      _img.setAttribute("type","pointImg");
      _img.src = src;
      _img.id = id;
      _img.style.position = "absolute";
      _img.style.left = x +"px";
      _img.style.top = y +"px";
      _img.style.width = w +"px";
      _img.style.height = h +"px";
      _img.style.zIndex = i;
 
      $("#lay0").append(_img);
}
  
function createRect(x,y,x1,y1,src) {
      clearRect();
      point(x,y,x1-x,1,9999,"point.jpg","l1");
      point(x1,y,1,y1-y,9999,"point.jpg","l2");
      point(x,y,1,y1-y,9999,"point.jpg","l3");
      point(x,y1,x1-x,1,9999,"point.jpg","l4");
}

function clearRect() {
      var jobj = $("IMG[type='pointImg']");
      for(var i=0;i<jobj.length;i++)  {
         var other_obj  = $("#" + jobj[i].id);
         other_obj.remove();
      }
}

//sort from left to right
function setToOrder(arr) {
      arr.sort(function(x1,x2) {
           var x1_x = loc2pos_absolute(x1)[0];
           var x2_x = loc2pos_absolute(x2)[0];
           return x1_x-x2_x;
      });
      return arr;
}

//sort sprite pos order
function setHashOrder(arr) {
      arr.sort(function(x1,x2) {
           var x1_x = x1.getPos();
           var x2_x = x2.getPos();
           return x1_x-x2_x;
      });
      return arr;
}

function debugMsg(msg) {
   $("#debuginfo").val(msg);

}

function uuidlet() {
	return(((1+Math.random())*0x10000)|0).toString(16).substring(1);
}

/*
Generates random uuid
*/
function getuuid(p) {
	        uuid_default_prefix=p;
		p = p || uuid_default_prefix || '';
		return(p+uuidlet()+uuidlet()+"-"+uuidlet()+"-"+uuidlet()+"-"+uuidlet()+"-"+uuidlet()+uuidlet()+uuidlet());
}

function in_array(v,a)  {
    for(var i=0;i<a.length;i++)  {
          if(a[i]==v)
              return false;
    }
    return true;
}

function setProgress(val) {
    eval("$( \"#progressbar\" ).progressbar({value:"+val+"})");
}

function isloaded() {
   if(version==2) {
       $("#layLoading").remove();  
       //$("#lay0").css("display","");
       //$("#startDiv").css("display","");   
   } else {
       var spriteloaded=roomRes.loadedRec.getItem(main_img_id).loaded;
       var loadedMapImgCnt=roomRes.mapResHash.getLength();

       if(loadedMapImgCnt==itemNum&&spriteloaded==spriteNum) {
           $("#layLoading").remove();  
           $("#lay0").css("display","");
           $("#startDiv").css("display","");
       }
   }
}

function getTransformProperty(element) {
    var properties = [
        'transform',
        'WebkitTransform',
        'MozTransform',
        'msTransform',
        'OTransform'
    ];
    var p;
    while (p = properties.shift()) {
        if (typeof element.style[p] != 'undefined') {
            return p;
        }
    }
    return false;
}

function isActContent(content) {
   if(content.startWith("&&"))
      return true;
   else if(unescape(content).startWith("&&"))
      return true;
   return false;   
}

function isClothContent(content) {
   if(content.startWith(">>"))
      return true;
   else if(unescape(content).startWith(">>"))
      return true;
   return false;   
}

    function getWidth()
    {
        xWidth = null;
        if(window.screen != null)
           xWidth = window.screen.width;

        if(window.innerWidth != null)
           xWidth = window.innerWidth;

        if(document.body != null)
           xWidth = document.body.clientWidth;

        return xWidth;
    }

    function getHeight() {
        xHeight = null;
        if(window.screen != null)
            xHeight = window.screen.height;

        if(window.innerHeight != null)
            xHeight =   window.innerHeight;

        if(document.body != null)
            xHeight = document.body.clientHeight;

        return xHeight;
    }


String.prototype.startWith=function(str){     
    var reg=new RegExp("^"+str);     
    return reg.test(this);        
}  

String.prototype.startWith=function(str){
    var reg=new RegExp("^"+str);
    return reg.test(this);
}

String.prototype.replaceAll = function(s1,s2){   
    var r = new RegExp(s1.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),"ig");
    return this.replace(r,s2);
}
