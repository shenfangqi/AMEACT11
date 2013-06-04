    var mvArr = Array();
    var mvArr_cnt = 0;
    var isMapLoading=0;

    var Canvas=function(){
        this.mainSprite=null;
    }
    /**
     *
     */
    Canvas.prototype={
        /**
         * ????
         */
        begin:function(){

        },

        /**
         * ????
         */
        stop:function(){
            clearInterval(this.interval)
        },
        
        
        setMap:function(ix,iy)  {
           var id,key,px,py,pos;
           var line_start_x,line_start_y;
           mvArr_cnt=0;
           for(var i =0; i< map_arr_width; i++)      {
                line_start_x = ix- i*(tile_width/2);
                line_start_y = iy+i*tile_height_offset;
                for(var j =0; j< map_arr_height; j++)      {
                            px = line_start_x + j*(tile_width/2);
                            py = line_start_y + j*tile_height_offset;
                            
                            //if not bg img then it is mv img.
                            if(!isBGImg(map_all[i*map_arr_width+j]))  {
                               id = "bg"+ map_all[i*map_arr_width+j];
                               key =map_all[i*map_arr_width+j];

                               px = px - getItemOffset(map_all[i*map_arr_width+j]);

                                  
                               px = px;
                               py = py + tile_height;
                               pos = i*map_arr_width+j;
                               
                               var imgData=new Object();
                               imgData.px=px;
                               imgData.py=py;
                               imgData.pos=pos;
                               imgData.id=id;
                               imgData.key=key;
                               
                               //ctx.drawImage(img, img.px, img.py);
                               
                               mvArr[mvArr_cnt] = imgData;
                               mvArr_cnt++;
                            }
                }
           }
        },

        editMapReload:function() {
           ctx.clearRect(0,0,bg_width,bg_height);

           for(var i =0;i<mvArr.length;i++)   {
                if(mvArr[i])  {
                   try{
                        var dispImg=roomRes.get_map_img(mvArr[i].key);
                        ctx.drawImage(dispImg, mvArr[i].px, mvArr[i].py - dispImg.height);
                   } catch (e) {
                        continue;
                   }
                }
           }
        },
        
        
        mapReload:function() {
           if(isMapLoading==1)
              return;
           
           isMapLoading=1;
        
           //??buffer canvas
           ctx.clearRect(0,0,bg_width,bg_height);

           otherSprites.clear_ordered_arr();
           if(this.mainSprite && ( mvArr.length==0 || this.mainSprite.pos<=mvArr[0].pos)) {
                otherSprites.load_to_arr(this.mainSprite);
           }
           
           otherSprites.draw_others_before(mvArr);
           
           for(var i =0;i<mvArr.length;i++)   {
                if(mvArr[i])  {
                   try{
                        var dispImg=roomRes.get_map_img(mvArr[i].key);
                        if(mvArr[i].key !=10)  //10 is the unpassable terrain mark defined in mapedit module, no need to display.
                           ctx.drawImage(dispImg, mvArr[i].px, mvArr[i].py - dispImg.height);
                   } catch (e) {
                        continue;
                   }
                }           
                otherSprites.clear_ordered_arr();

                if(mvArr[i] && mvArr[i+1])  {
                   if(this.mainSprite && this.mainSprite.pos>=mvArr[i].pos  &&  this.mainSprite.pos<mvArr[i+1].pos )   {
                        otherSprites.load_to_arr(this.mainSprite);
                   }
                   otherSprites.draw_others_middle(mvArr,i);
                }
           }

           otherSprites.clear_ordered_arr();
           if(this.mainSprite && (mvArr.length==0 || this.mainSprite.pos>=mvArr[i-1].pos)) {
                  otherSprites.load_to_arr(this.mainSprite);
           }
                
           otherSprites.draw_others_last(mvArr);

           this.appendMainLable(user,myname);
           otherSprites.appendOtherLables();
           this.render();
           isMapLoading=0;
        },


        //?buffer canvas?????canvas
        render:function() {
           ctx1.clearRect(0,0,bg_width,bg_height);
           ctx1.drawImage(m_canvas, 0, 0);
        },

        setMainSprite:function(val) {
            this.mainSprite = val;
        },


        appendMainLable:function(name,dispname) {
            var px,py;
            px=mainsprite.getPosX();
            py=mainsprite.getPosY();

            if(px < bg_width)  {                  
                var obj = getNameLable(name,dispname);
                var alignCenterOffset = parseInt(htmlPosStrToNumber(obj.style.width)/2) + 20;
                var imgHalfWidth = parseInt(mainsprite.getWidth()/2);
            
                obj.style.left = px - alignCenterOffset + imgHalfWidth + canvas_offx+"px";
                obj.style.top = py - $("#"+user).height() - 60 + (canvas_offy-30) +"px";   //30 是title的高度，以后?提取出来
                obj.onclick="alert('cccc')";
                $("#lay0").append(obj);
            }
        },


        init:function(){
           if (ctx){
              //this.setMap(ix,iy);
              this.mapReload();
           }
        },

        mapEditInit:function(){
           if (ctx){
              //this.setMap(ix,iy);
              this.editMapReload();
           }
        }

    }
