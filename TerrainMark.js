    var TerrainMark=function(mark_arr,ipx,ipy,ipw,iph){
         this.mark_arr=mark_arr;
         this.ipx=ipx;
         this.ipy=ipy;
         this.ipw=ipw;
         this.iph=iph;
         this.bottom=Array();
         this.offset=0;
    }
    
    /**
     *
     */
    TerrainMark.prototype={

        getBottom:function()  {
            return  this.bottom; 
        },
        
        getFaceArr:function()  {
            var arr=this.mark_arr;
            var lmk;
            var n=0;
            var ret=Array();
            
            for(var i=0;i<arr.length;i++) {
                 lmk=this.scanToBottom(arr[i],arr);
                 if(jQuery.inArray(lmk,ret)==-1) {
                    ret[n++]=lmk;
                 }
            }
            
            ret=setToOrder(ret);
            
            this.bottom=ret;
            
            ret=this.splitItem(ret,this.ipx,this.ipy,this.ipw,this.iph);
            
            return ret; 
        },
        
        getLeft:function() {
        },


        getRight:function() {
        },
        
        getOffset:function() {
            return this.offset;
        },
        
        
        //px,py:item picture absolute position  pw,ph: width and height of item picture
        splitItem:function(arr,px,py,pw,ph) {
            var ox,oy;
            var tx,ty;
            var iarr=Array();
            for(var i=0;i<arr.length;i++)  {
               
               //left
               if(i==0) {
                    ox=0;
                    oy=0;
                    
                    tx=loc2pos_absolute(arr[i])[0]+32-px;
                    //alert(tx-32);
                    this.offset=tx-64;
                    ty=loc2pos_absolute(arr[i])[1]+15-py;
               }
               
               //right
               else if(i==arr.length-1) {
                    ox=loc2pos_absolute(arr[i])[0]-32-px;
                    oy=0;
                    
                    tx=pw;
                    ty=loc2pos_absolute(arr[i])[1]+15-py;
               }
               
               else {
                    ox=loc2pos_absolute(arr[i])[0]-32-px;
                    oy=0;
                    
                    tx=loc2pos_absolute(arr[i])[0]+32-px;
                    ty=loc2pos_absolute(arr[i])[1]+15-py;               
               }
            
               //alert(ox+":"+oy+"||"+tx+":"+ty);

               iarr[iarr.length]=ox+":"+oy+"||"+tx+":"+ty;
            }
            return iarr;
        },
        
        
        scanToBottom:function(mark,arr)  {
            var n=mark;
            var ret=mark;
            while(n<arr[arr.length-1])  {
               n=n+map_arr_width+1;
               if(jQuery.inArray(n,arr)!=-1)
                  ret=n;
            }
            return ret;
        }
        
        
        
        
    }    