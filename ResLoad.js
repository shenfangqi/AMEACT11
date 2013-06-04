    var ResLoad=function(){
        this.mapResHash = new Hash();
        this.spriteResHash = new Hash();
        this.loadedRec = new Hash();
        this.loadedMapImgCnt=0;
        this.loadedSpriteImgCnt=0;
    }

    ResLoad.prototype={
        map_res_load:function(map_data,type){  //0:game   1:mapedit
           this.loadedMapImgCnt=0;
           //this.loadedSpriteImgCnt=0;
           
           for(var i =0; i< map_data.length; i++)      {
              if(!isBGImg(map_data[i]))   {
                    var key = map_data[i];
                    if(!this.mapResHash.hasItem(key)) {
                        //this.loadedMapImgCnt++;
                        var map_img=new Image();
                        var dir=key.split("_")[0];
                        map_img.src="res/mapRes/up/"+dir+"/"+key +".png";
                        //alert(map_img.style.zIndex);
                        map_img.onload = this.load_map_count_up;
                        this.mapResHash.setItem(key,map_img);

                        if(type==1 && key.split("_")[1] && key.split("_")[1]==0) {
                            map_img.src="res/mapRes/up/"+dir+"/"+key.split("_")[0] +".png";
                            map_img.onload = this.load_map_count_up;
                            this.mapResHash.setItem(key.split("_")[0],map_img);
                        }
                    }
              }
           }
        },    


        //dirCnt判断是4方向的还是8方向的sprite，目前只对应4方向，8是为以后做接口
        //frameCnt 判断sprite动作序列图片数，目前对应8个动作，以后可能为速度要求减少图片动作
        //以上2参数必须根据sprite实际情况输入，否则会出现找不到文件错误
        sprite_res_load:function(spriteID,dirCnt,frameCnt) {
           //$("#testinfo").val(0);
           this.loadedSpriteImgCnt=0;
           var recObj = new Object;
           recObj.total = dirCnt*frameCnt;
           recObj.loaded = 0;
           
           this.loadedRec.setItem(spriteID,recObj);
           
           for(var i=0;i<dirCnt;i++)   {
               for(var j=0;j<frameCnt;j++)   {
                  var key=spriteID+"_1"+i+"_"+j;
                  var sprite_img=new Image();
                  sprite_img.src="res/spriteRes/"+spriteID+"/"+key +".png";
                  
                  //var sprite_img=document.createElement("IMG");
                  //sprite_img.setAttribute("src","res/spriteRes/"+spriteID+"/"+key +".png");
                  sprite_img.onload = this.load_sprite_count_up(spriteID);
                  this.spriteResHash.setItem(key,sprite_img);                
               }           
           }
        },
     
        get_sprite_img:function(img_name) {
           var key=img_name;
           return this.spriteResHash.getItem(key);
        },
        
        load_map_count_up:function() {
//           var o=roomRes.mapResHash.getLength();
//alert(o);
//           setProgress((parseInt((o/itemNum)*100)));
//           isloaded();
        },

        load_sprite_count_up:function(spriteID) {
           var o = roomRes.loadedRec.getItem(spriteID);
           o.loaded = o.loaded+1;
//           setProgress((parseInt((o.loaded/spriteNum)*100)));
           roomRes.loadedRec.setItem(spriteID,o);
           isloaded();
        },

        isSpriteLoaded:function(spriteID) {
           var o = roomRes.loadedRec.getItem(spriteID);
           if(o && o.loaded == o.total)  
              return true;
           return false;   
        },

        get_map_img:function(img_name) {
           var key=img_name;
           return this.mapResHash.getItem(key);
        },
        
        set_sprite:function(sprite_head) {
        },
        
        get_sprite:function() {
        }
        
    }    