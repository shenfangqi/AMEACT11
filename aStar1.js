    var Path_Finding=function(){
        this.UPDW_SPACE = map_arr_width;  //h6中设置地图宽和高
        this.LFRT_SPACE = map_arr_height;
        this.map_all = new Array;

        //与上下左右菱形间距，如新菱形设置比例与旧相同则无需抽出，下同
         this.rhombus_distance = 18;
        //与下左上右菱形间距
         this.rhombus_lr_distance = 32;
        //与上左下右菱形间距
         this.rhombus_ud_distance = 16;
    }
    
    /**
     *
     */
    Path_Finding.prototype={
                 
        Path_Finding_init:function(map) {
           this.map_all = map;
        },
        
        getXY:function(sid) {
           var ret = new Array(2);
           ret[0] = parseInt(sid/this.LFRT_SPACE);
           ret[1] = sid%this.LFRT_SPACE;
          return ret;
        },        
        
        getDistance:function(d1, d2) {
	            var ret= -1;
                    var p1 = this.getXY(d1);
                    var p2 = this.getXY(d2);
                    ret = Math.abs(p1[0] - p2[0]) + Math.abs(p1[1] - p2[1]);
	            return ret;
	},

        isPassable:function (nid) {
/*
                    var pic_id =0;
                    if(nid >= this.UPDW_SPACE *  this.LFRT_SPACE)
                         return false;

                    if((nid+1)%this.UPDW_SPACE == 0)   // %32 -1 
                         return false;
                         
                    if(nid > this.UPDW_SPACE * (this.LFRT_SPACE -1) -1)  //32 * 31 - 1
                         return false;
                         
                    //pic_id = map_all[nid];
*/

                    if(is_terrain_passable(nid))
                         return false;
                    else
                         return true;
	},

        isInClose:function (close,close_count,nid) {
                   for(var i=0;i<close.length;i++)  {
                       if(i>=close_count)
                               break;
                       if(close[i][0]==nid)
                              return true;
		          }
		          return false;
	},


        retNoInArr:function(arr,count,nid)  {
                    for(var i=0;i<=count-1;i++) {
                          if(arr[i][0] == nid && arr[i][5] == 0)
                               return i;

		            }
		            return -1;
	},

        retKeyInOpen:function(open,count) {
                   var smallest = 99999;
                   var key = -1;
                   for(var i=0;i<=count-1;i++) {
		 	              if(open[i][4] < smallest && open[i][5] == 0) {
			                   smallest = open[i][4];
			                   key = i;
			               }
                    }
                    return key;
        },

        dispPath:function(close,count,point,res) {
                   for(var i=0;i<close.length;i++) {
                        if(i>count)
                              break;
                        if(close[i][0]==point)  {
                              //alert(point);
                              res.push(point);
                              this.dispPath(close,count,close[i][1],res);
                        }
                   }
        },      



        getNear:function(nid, c_gv, end,close, count_close) {
                   u = new Array;
                   d = new Array;
                   l = new Array;
                   r = new Array;

                   ul = new Array;
                   ur = new Array;
                   dl = new Array;
                   dr = new Array;

                   var u_id,d_id,l_id,r_id;
                   var ul_id,ur_id,dl_id,dr_id;

                   u_id = (nid - this.UPDW_SPACE >=0?nid - this.UPDW_SPACE:-1);
                   d_id = (nid + this.UPDW_SPACE <= this.UPDW_SPACE * this.UPDW_SPACE?nid + this.UPDW_SPACE:-1);
                   l_id = (nid-1>=0?nid-1:-1);
                   r_id = (nid+1<=this.UPDW_SPACE * this.UPDW_SPACE?nid+1:-1);

                   if(u_id !=-1 && this.isPassable(u_id) && !this.isInClose(close,count_close,u_id)) {
		        u = new Array(6);
                        u[0] = u_id;
                        u[1] = nid;
                        u[2] = c_gv + this.rhombus_distance;
                        u[3] = this.getDistance(u_id,end);
                        u[4] = u[2] + u[3];
		        u[5] = 0;
		   }
                   if(d_id !=-1 && this.isPassable(d_id) && !this.isInClose(close,count_close,d_id)) {
		        d = new Array(6);
                        d[0] = d_id;
                        d[1] = nid;
                        d[2] = c_gv + this.rhombus_distance;
                        d[3] = this.getDistance(d_id,end);
                        d[4] = d[2] + d[3];
		        d[5] = 0;
		   }
                   if(l_id !=-1 && this.isPassable(l_id) && !this.isInClose(close,count_close,l_id)) {
                        l = new Array(6);
                        l[0] = l_id;
                        l[1] = nid;
                        l[2] = c_gv + this.rhombus_distance;
                        l[3] = this.getDistance(l_id,end);
		        l[4] = l[2] + l[3];
		        l[5] = 0;
		   }
                   if(r_id !=-1 && this.isPassable(r_id) && !this.isInClose(close,count_close,r_id)) {
                        r = new Array(6);
                        r[0] = r_id;
                        r[1] = nid;
                        r[2] = c_gv + this.rhombus_distance;
                        r[3] = this.getDistance(r_id,end);
		        r[4] = r[2] + r[3];
		        r[5] = 0;
		   }


                   if(nid % this.UPDW_SPACE == 0)
                        l = "";
                   if((nid+1)%this.UPDW_SPACE == 0)
                        r = "";

                   ul_id = (nid-this.UPDW_SPACE-1>=0?nid-this.UPDW_SPACE-1:-1);
                   ur_id = (nid-this.UPDW_SPACE+1>=0?nid-this.UPDW_SPACE+1:-1);
                   dl_id = (nid+this.UPDW_SPACE-1<=this.UPDW_SPACE*this.UPDW_SPACE?nid+this.UPDW_SPACE-1:-1);
                   dr_id = (nid+this.UPDW_SPACE+1<=this.UPDW_SPACE*this.UPDW_SPACE?nid+this.UPDW_SPACE+1:-1);

		   if(u != "" && l != "" && this.isPassable(ul_id) && !this.isInClose(close,count_close,ul_id)) {
                        ul = new Array(6);
		        ul[0] = ul_id;
		        ul[1] = nid;
                        ul[2] = c_gv + this.rhombus_ud_distance;
                        ul[3] = this.getDistance(ul_id,end);
                        ul[4] = ul[2] + ul[3];
                        ul[5] = 0;
		   }
		   if(u != "" && r != "" && this.isPassable(ur_id) && !this.isInClose(close,count_close,ur_id)) {
                        ur = new Array(6);
		        ur[0] = ur_id;
		        ur[1] = nid;
		        ur[2] = c_gv + this.rhombus_lr_distance;
                        ur[3] = this.getDistance(ur_id,end);
		        ur[4] = ur[2] + ur[3];
                        ur[5] = 0;
		   }
		   if(d != "" && l != "" && this.isPassable(dl_id) && !this.isInClose(close,count_close,dl_id)) {
                        dl = new Array(6);
		        dl[0] = dl_id;
		        dl[1] = nid;
		        dl[2] = c_gv + this.rhombus_lr_distance;
                        dl[3] = this.getDistance(dl_id,end);
		        dl[4] = dl[2] + dl[3];
                        dl[5] = 0;
		   }
		   if(d != "" && r != "" && this.isPassable(dr_id) && !this.isInClose(close,count_close,dr_id)) {
                        dr = new Array(6);
		        dr[0] = dr_id;
		        dr[1] = nid;
		        dr[2] = c_gv + this.rhombus_ud_distance;
                        dr[3] = this.getDistance(dr_id,end);
		        dr[4] = dr[2] + dr[3];
                        dr[5] = 0;
		   }


                   var n = Array(u,d,l,r,ul,ur,dl,dr);

//                   var n = Array(u,d,l,r);

                   return n;
              },

              Astar:function (startPoint, endPoint){
                   var startN = new Array(6);
                   var count_open = 0;
                   var count_close = 0;
                   var isFound = false;
                   var idx_open = 0;
                   var res = [];

                   startN[0] = startPoint;
                   startN[1] = -1;
                   startN[2] = 0;
                   startN[3] = this.getDistance(startPoint,endPoint);
                   startN[4] = startN[2] + startN[3];
                   startN[5] = 0;

                   var open=createTwoDimensionArray(this.UPDW_SPACE * this.LFRT_SPACE,6);  //初始化开启列表

                   open[count_open++] = startN;

                   var close=createTwoDimensionArray(this.UPDW_SPACE * this.LFRT_SPACE,6);  //初始化关闭列表

                   while(!isFound) {
                       var start_rec = open[idx_open];
                       var near_recs = this.getNear(start_rec[0],start_rec[2],endPoint,close,count_close);

                       open[idx_open][5] = 1;

                       for(var i=0;i<near_recs.length;i++)  {
			         	    if(near_recs[i] == "")
			         	      continue;
			         	    var nid = near_recs[i][0];
                            var in_open_id = this.retNoInArr(open,count_open,nid);
                            var in_close_id = this.retNoInArr(close,count_close,nid);

                            if(in_open_id == -1 && in_close_id == -1) {
			         			open[count_open++] = near_recs[i];
			         		}
			         		if(in_open_id != -1) {
			         		    if(near_recs[i][4] < open[in_open_id][4]) {
                                     open[in_open_id] = near_recs[i];
			         			}
			         		}
			           }

                       close[count_close++] = open[idx_open];

                       if(open[idx_open][0] == endPoint)
                           isFound = true;
                       else
                           idx_open = this.retKeyInOpen(open,count_open);
                   }

                   this.dispPath(close,count_close,endPoint,res);
                   return res;
              }
        
     }    
        
