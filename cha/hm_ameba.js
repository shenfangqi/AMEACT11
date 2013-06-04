/**
 * @param {Function} subCls 子?
 * @param {Function} superCls 父?
 */
function extend(subCls,superCls) {
    //?存子?原型
    var sbp = subCls.prototype;

    //重写之?原型－－原型?承
    subCls.prototype = new superCls();

    //重写后一定要将constructor指回subCls
    subCls.prototype.constructor = subCls;

    //?原子?原型
    for(var atr in sbp) {
        subCls.prototype[atr] = sbp[atr];
    }

    //?存父?
    subCls.supr = superCls;
}



/**
 *  父?Person
 */
function BasePart(bx,by,rx,ry,deg,imgfile,name,orient){
    this.baseX = bx;
    this.baseY = by;
    this.rotX = rx;
    this.rotY = ry;
    this.rotX1 = rx;
    this.rotY1 = ry;

    this.degree = deg;
    this.name = name;
    this.img = imgfile;
    this.orient = orient;
    this.offx = 0;
    this.offy = 0;
    this.disp = 1;
}

BasePart.prototype.UP = function() {this.baseY -=2;this.rotY -=2;this.rotY1 -=2;}
BasePart.prototype.DOWN = function() {this.baseY +=2;this.rotY +=2;this.rotY1 +=2;}
BasePart.prototype.LEFT = function() {this.baseX -=2;this.rotX -=2;this.rotX1 -=2;}
BasePart.prototype.RIGHT = function() {this.baseX +=2;this.rotX +=2;this.rotX1 +=2;}
BasePart.prototype.RotRIGHT = function() {this.degree -=10;}
BasePart.prototype.RotLEFT = function() {this.degree +=10;}

//BasePart.prototype.setDisp = function(disp) {
//    this.disp = disp;
//}


BasePart.prototype.setBasePos = function(offx,offy,deg) {
    this.baseX +=offx;
    this.baseY +=offy;
    this.rotX +=offx;
    this.rotY +=offy;
    this.rotX1 = this.rotX;
    this.rotY1 = this.rotY;
    this.degree =deg;
}


BasePart.prototype.setPos = function(px,py) {
    this.baseX = px+20;
    this.baseY = py+20;
}


BasePart.prototype.setPosOff = function(offx,offy) {
    this.offx = offx;
    this.offy = offy;
}

BasePart.prototype.setRotPos = function(rx,ry) {
    this.rotX = rx;
    this.rotY = ry;
}

BasePart.prototype.recoverRotPos = function() {
    this.rotX = this.rotX1;
    this.rotY = this.rotY1;
}

BasePart.prototype.getRotX = function() {
    return this.rotX;
}

BasePart.prototype.getRotY = function() {
    return this.rotY;
}


BasePart.prototype.setOrient = function(val) {
    this.orient = val;
}

BasePart.prototype.setImg = function(val) {
    this.img = val;
}

BasePart.prototype.getName = function() {return this.name;}

BasePart.prototype.getBaseX = function() {return this.baseX;}
BasePart.prototype.getBaseY = function() {return this.baseY;}
BasePart.prototype.getDeg = function() {return this.degree;}
BasePart.prototype.getInvert = function() {return this.orient;}
BasePart.prototype.setInvert = function() {
    if(this.orient=="ld")
        this.orient="rd";
    else if(this.orient=="rd")
        this.orient="ld";
    else if(this.orient=="lu")
        this.orient="ru";
    else if(this.orient=="ru")
        this.orient="lu";
}

BasePart.prototype.setInvertVal = function(ot) {
    this.orient=ot;
}

BasePart.prototype.draw = function() {
    var dx=this.baseX;
    var dy=this.baseY;
    var rx=this.rotX;
    var ry=this.rotY;
    var dg=this.degree;
    //this.img=hm.ss.getBodyImg(this.orient+"_"+this.name);

    var mx;
    if(isTest)  
       mx = 140;
    else
       mx = 100;
    
    if(this.orient =="rd" || this.orient =="ru") {  //image on right side is basic. if the left image then need to be inverted.
       dx = mx-this.baseX-this.img.width;   //100 here should be changed to definable
       rx = mx-this.rotX;
       dg = 0 - this.degree;
    }

    //alert(dx+":"+dy+":"+ rx+":"+ ry+":"+ dg);

//alert(this.img.src);

    this.drawSprite(this.img, dx, dy, rx, ry, dg);
}

BasePart.prototype.getRotTarget = function(px,py,axis_px,axis_py,degree) {
    var deg=degree;
    var sin_val =Math.sin(deg * (Math.PI / 180));
    var cos_val =Math.cos(deg * (Math.PI / 180));

    //should be the origin point of the item to be displayed on the canvas.
    var origin_px=px;
    var origin_py=py;


    //should be the axis point which the whole item turn around by
    //hm.px,hm.py is used for mirrored image rot position
    var x1=axis_px;
    var y1=axis_py;


    //formula of get a target point(x',y') position while a point turn around by a ARC degree by a axis point(x,y)
    //x'=(x-a)cosc-(y-b)sinc+a
    //y'=(y-b)cosc+(x-a)sinc+b

    x2=(origin_px-x1)*cos_val - (origin_py-y1)*sin_val + x1 ;
    y2=(origin_py-y1)*cos_val + (origin_px-x1)*sin_val + y1 ;

    //var off_x=parseInt(x2)-x1;
    //var off_y=parseInt(y2)-y1;

    //var target_px = parseInt(origin_px + 64-sin_val*64);
    //var target_py = parseInt(origin_py - cos_val*64);
    
    return [parseInt(x2),parseInt(y2)];
}


BasePart.prototype.drawSprite = function(spriteImg,px,py,axis_px,axis_py,degree) {
    var deg=degree;
    var sin_val =Math.sin(deg * (Math.PI / 180));
    var cos_val =Math.cos(deg * (Math.PI / 180));

    //should be the origin point of the item to be displayed on the canvas.
    var origin_px=px;
    var origin_py=py;

//alert(px +":"+ py);

    //should be the axis point which the whole item turn around by
    //hm.px,hm.py is used for mirrored image rot position
    var x1=axis_px+this.offx;
    var y1=axis_py+this.offy;


    //formula of get a target point(x',y') position while a point turn around by a ARC degree by a axis point(x,y)
    //x'=(x-a)cosc-(y-b)sinc+a
    //y'=(y-b)cosc+(x-a)sinc+b

    x2=(x1-origin_px)*cos_val - (y1-origin_py)*sin_val + origin_px ;
    y2=(y1-origin_py)*cos_val + (x1-origin_px)*sin_val + origin_py ;

    var off_x=parseInt(x2)-x1;
    var off_y=parseInt(y2)-y1;

    var target_px = parseInt(origin_px + 64-sin_val*64);
    var target_py = parseInt(origin_py - cos_val*64);

    ctx.save();

//    if(this.disp==0)
//       ctx.globalAlpha = 0.1;
//    else 
//       ctx.globalAlpha = 0.9;

    ctx.translate(origin_px-off_x,origin_py-off_y);   //200: 180 + 64-(sin(45)*64)     135: 180 - (cos(45)*64)
    //ctx.scale(-1, 1);
    ctx.rotate(deg * (Math.PI / 180));

    ctx.drawImage(spriteImg, this.offx, this.offy);
    //ctx.drawImage(o.spritesheet.image, o.frame * o.spritesheet.offsetw, 0, o.w, o.h, -o.w/2, -o.h/2, o.w, o.h);

    ctx.restore();
}

/**
 *  子?BodyPart
 */
function BodyPart(bx,by,rx,ry,deg,imgfile,name,orient) {
    BodyPart.supr.call(this,bx,by,rx,ry,deg,imgfile,name,orient); //?用父??造器
    this.accessories = new Array;
    if((orient=="lu" || orient=="ru" )) {
       this.isUPed = true;
    } else {
       this.isUPed = false;
    }
}

BodyPart.prototype.drawImage = function() {
    this.draw();
    for(var i=0;i<this.accessories.length;i++) {
         this.accessories[i].drawImage();
    }
}

BodyPart.prototype.setAccessory = function(accessory) {
    this.accessories[this.accessories.length] = accessory;
}


BodyPart.prototype.setUpDnOffset = function(off_val) {
    this.up_dn_off = off_val;
}

BodyPart.prototype.setDir = function(val) {
    this.setOrient(val);

    if((this.orient=="lu" || this.orient=="ru" ) && !this.isUPed) {
        //因?lu的bodypart?像是从ld而来，但是排列上跟ld区?，?了?一算法，因此?算lu?形跟ld的offset，然后在?置1?的?候套用。
        this.baseX += this.up_dn_off[this.name][0];
        this.baseY += this.up_dn_off[this.name][1];
        this.isUPed = true;
    }
    if((this.orient=="ld" || this.orient=="rd" ) && this.isUPed) {
        this.baseX -= this.up_dn_off[this.name][0];
        this.baseY -= this.up_dn_off[this.name][1];
        this.isUPed = false;
    }

//alert(this.name +":"+ this.baseX +":"+ this.baseY);

    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].setOrient(val);

        if(this.orient=="ld" || this.orient=="rd")  {
            var ac_baseX = this.baseX +  this.accessories[i].off_ox1;
            var ac_baseY = this.baseY +  this.accessories[i].off_oy1;
        }
        else if(this.orient=="lu" || this.orient=="ru") {
            var ac_baseX = this.baseX + this.accessories[i].off_ox2;
            var ac_baseY = this.baseY + this.accessories[i].off_oy2;
        }

        this.accessories[i].baseX = ac_baseX;
        this.accessories[i].baseY = ac_baseY;
    }
}


BodyPart.prototype.moveUP = function() {
    this.UP();
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].UP();
    }
}

BodyPart.prototype.moveDOWN = function() {
    this.DOWN();
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].DOWN();
    }
}

BodyPart.prototype.moveLEFT = function() {
    this.LEFT();
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].LEFT();
    }
}

BodyPart.prototype.moveRIGHT = function() {
    this.RIGHT();
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].RIGHT();
    }
}

BodyPart.prototype.rotRIGHT = function() {
    this.RotRIGHT();
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].RotRIGHT();
    }
}

BodyPart.prototype.rotLEFT = function() {
    this.RotLEFT();
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].RotLEFT();
    }
}

BodyPart.prototype.setBodyPos = function(bx,by,deg,orient) {
    var offx = bx-this.baseX;
    var offy = by-this.baseY;
    this.setBasePos(offx,offy,deg);
    this.setInvertVal(orient);
    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].setBasePos(offx,offy,deg);
        this.accessories[i].setInvertVal(orient);
    }
}

BodyPart.prototype.invertBody = function() {
    this.setInvert();

    for(var i=0;i<this.accessories.length;i++) {
        this.accessories[i].setInvert();
    }
}


/**
 *  子?Accessories
 */
function Accessories(bx,by,rx,ry,deg,imgfile,name,orient) {
    Accessories.supr.call(this,bx,by,rx,ry,deg,imgfile,name,orient); //?用父?的?造器
}

Accessories.prototype.setOffsetVal = function(ox1,oy1,ox2,oy2) {
    this.off_ox1 = ox1;
    this.off_oy1 = oy1;
    this.off_ox2 = ox2;
    this.off_oy2 = oy2;
    //this.disp = true;
}

Accessories.prototype.setOrient = function(val) {
    this.orient = val;
}

Accessories.prototype.setDisp = function(val) {
    this.disp = val;
}

Accessories.prototype.drawImage = function() {
    var partCode = this.name.substring(0,1); 
    if(!(partCode == "M" && (this.orient =="lu" || this.orient =="ru")) && this.disp) {
         this.draw();
    }
}

extend(BodyPart,BasePart);
extend(Accessories,BasePart);


function createTwoDimensionArray(kv,m)  {
   var arr=new Array(kv.length);for(var i=0;i<kv.length;i++){arr[kv[i]]=new Array(m);}return arr;
}


function bodyPos() {
   //watch the order
   var bodyArr = ["lLeg","lArm","lLimb","body","rLeg","rArm","rLimb","head"];
   this.pos_arr_up = createTwoDimensionArray(bodyArr,4);
   this.pos_arr_dn = createTwoDimensionArray(bodyArr,4);
   this.up_dn_offset = createTwoDimensionArray([0,1,2,3,4,5,6,7],2)
   this.up_dn_offset_name = createTwoDimensionArray(bodyArr,2);

   this.pos_arr_dn["lLeg"]["bx_off"]=15;   //baseX: value is the offset from canvas origin postion
   this.pos_arr_dn["lLeg"]["by_off"]=82;
   this.pos_arr_dn["lLeg"]["rx_off"]=9;    //rotateX: value is the offset from baseX,use for rotation
   this.pos_arr_dn["lLeg"]["ry_off"]=0;

   this.pos_arr_dn["lArm"]["bx_off"]=17;
   this.pos_arr_dn["lArm"]["by_off"]=59;
   this.pos_arr_dn["lArm"]["rx_off"]=10;
   this.pos_arr_dn["lArm"]["ry_off"]=0;

   this.pos_arr_dn["lLimb"]["bx_off"]=8;
   this.pos_arr_dn["lLimb"]["by_off"]=66;
   this.pos_arr_dn["lLimb"]["rx_off"]=10;
   this.pos_arr_dn["lLimb"]["ry_off"]=0;

   this.pos_arr_dn["body"]["bx_off"]=20;
   this.pos_arr_dn["body"]["by_off"]=57;
   this.pos_arr_dn["body"]["rx_off"]=12;
   this.pos_arr_dn["body"]["ry_off"]=0;

   this.pos_arr_dn["rLeg"]["bx_off"]=26;
   this.pos_arr_dn["rLeg"]["by_off"]=80;
   this.pos_arr_dn["rLeg"]["rx_off"]=9;
   this.pos_arr_dn["rLeg"]["ry_off"]=0;

   this.pos_arr_dn["rArm"]["bx_off"]=36;
   this.pos_arr_dn["rArm"]["by_off"]=60;
   this.pos_arr_dn["rArm"]["rx_off"]=2;
   this.pos_arr_dn["rArm"]["ry_off"]=2;

   this.pos_arr_dn["rLimb"]["bx_off"]=40;
   this.pos_arr_dn["rLimb"]["by_off"]=65;
   this.pos_arr_dn["rLimb"]["rx_off"]=2;
   this.pos_arr_dn["rLimb"]["ry_off"]=2;

   this.pos_arr_dn["head"]["bx_off"]=0;
   this.pos_arr_dn["head"]["by_off"]=6;
   this.pos_arr_dn["head"]["rx_off"]=32;
   this.pos_arr_dn["head"]["ry_off"]=57;


   this.pos_arr_up["lLeg"]["bx_off"]=15;   //baseX: value is the offset from canvas origin postion
   this.pos_arr_up["lLeg"]["by_off"]=78;
   this.pos_arr_up["lLeg"]["rx_off"]=9;    //rotateX: value is the offset from baseX,use for rotation
   this.pos_arr_up["lLeg"]["ry_off"]=0;

   this.pos_arr_up["lArm"]["bx_off"]=15;
   this.pos_arr_up["lArm"]["by_off"]=59;
   this.pos_arr_up["lArm"]["rx_off"]=20;
   this.pos_arr_up["lArm"]["ry_off"]=0;

   this.pos_arr_up["lLimb"]["bx_off"]=5;
   this.pos_arr_up["lLimb"]["by_off"]=65;
   this.pos_arr_up["lLimb"]["rx_off"]=20;
   this.pos_arr_up["lLimb"]["ry_off"]=0;

   this.pos_arr_up["body"]["bx_off"]=20;
   this.pos_arr_up["body"]["by_off"]=57;
   this.pos_arr_up["body"]["rx_off"]=12;
   this.pos_arr_up["body"]["ry_off"]=0;

   this.pos_arr_up["rLeg"]["bx_off"]=26;
   this.pos_arr_up["rLeg"]["by_off"]=85;
   this.pos_arr_up["rLeg"]["rx_off"]=9;
   this.pos_arr_up["rLeg"]["ry_off"]=0;

   this.pos_arr_up["rArm"]["bx_off"]=36;
   this.pos_arr_up["rArm"]["by_off"]=60;
   this.pos_arr_up["rArm"]["rx_off"]=2;
   this.pos_arr_up["rArm"]["ry_off"]=2;

   this.pos_arr_up["rLimb"]["bx_off"]=40;
   this.pos_arr_up["rLimb"]["by_off"]=66;
   this.pos_arr_up["rLimb"]["rx_off"]=2;
   this.pos_arr_up["rLimb"]["ry_off"]=2;

   this.pos_arr_up["head"]["bx_off"]=0;
   this.pos_arr_up["head"]["by_off"]=2;
   this.pos_arr_up["head"]["rx_off"]=32;
   this.pos_arr_up["head"]["ry_off"]=57;

   this.up_dn_offset[0][0]= this.pos_arr_up["lLeg"]["bx_off"] - this.pos_arr_dn["lLeg"]["bx_off"];
   this.up_dn_offset[0][1]= this.pos_arr_up["lLeg"]["by_off"] - this.pos_arr_dn["lLeg"]["by_off"];

   this.up_dn_offset[1][0]= this.pos_arr_up["lArm"]["bx_off"] - this.pos_arr_dn["lArm"]["bx_off"];
   this.up_dn_offset[1][1]= this.pos_arr_up["lArm"]["by_off"] - this.pos_arr_dn["lArm"]["by_off"];

   this.up_dn_offset[2][0]= this.pos_arr_up["lLimb"]["bx_off"] - this.pos_arr_dn["lLimb"]["bx_off"];
   this.up_dn_offset[2][1]= this.pos_arr_up["lLimb"]["by_off"] - this.pos_arr_dn["lLimb"]["by_off"];

   this.up_dn_offset[3][0]= this.pos_arr_up["body"]["bx_off"] - this.pos_arr_dn["body"]["bx_off"];
   this.up_dn_offset[3][1]= this.pos_arr_up["body"]["by_off"] - this.pos_arr_dn["body"]["by_off"];

   this.up_dn_offset[4][0]= this.pos_arr_up["rLeg"]["bx_off"] - this.pos_arr_dn["rLeg"]["bx_off"];
   this.up_dn_offset[4][1]= this.pos_arr_up["rLeg"]["by_off"] - this.pos_arr_dn["rLeg"]["by_off"];

   this.up_dn_offset[5][0]= this.pos_arr_up["rArm"]["bx_off"] - this.pos_arr_dn["rArm"]["bx_off"];
   this.up_dn_offset[5][1]= this.pos_arr_up["rArm"]["by_off"] - this.pos_arr_dn["rArm"]["by_off"];

   this.up_dn_offset[6][0]= this.pos_arr_up["rLimb"]["bx_off"] - this.pos_arr_dn["rLimb"]["bx_off"];
   this.up_dn_offset[6][1]= this.pos_arr_up["rLimb"]["by_off"] - this.pos_arr_dn["rLimb"]["by_off"];

   this.up_dn_offset[7][0]= this.pos_arr_up["head"]["bx_off"] - this.pos_arr_dn["head"]["bx_off"];
   this.up_dn_offset[7][1]= this.pos_arr_up["head"]["by_off"] - this.pos_arr_dn["head"]["by_off"];

   this.up_dn_offset_name["lLeg"]= this.up_dn_offset[0];
   this.up_dn_offset_name["lArm"]= this.up_dn_offset[1];
   this.up_dn_offset_name["lLimb"]= this.up_dn_offset[2];
   this.up_dn_offset_name["body"]= this.up_dn_offset[3];
   this.up_dn_offset_name["rLeg"]= this.up_dn_offset[4];
   this.up_dn_offset_name["rArm"]= this.up_dn_offset[5];
   this.up_dn_offset_name["rLimb"]= this.up_dn_offset[6];
   this.up_dn_offset_name["head"]= this.up_dn_offset[7];
}


bodyPos.prototype.getRHand1Pos = function() {
   return [this.pos_arr_dn["rLimb"]["bx_off"]+this.pos_arr_dn["rLimb"]["rx_off"],this.pos_arr_dn["rLimb"]["by_off"]+this.pos_arr_dn["rLimb"]["ry_off"]];
}

bodyPos.prototype.getRHand1PosAXoff = function() {
   return [this.pos_arr_dn["rLimb"]["rx_off"],this.pos_arr_dn["rLimb"]["ry_off"]];
}

bodyPos.prototype.getLHand1Pos = function() {
   return [this.pos_arr_dn["lLimb"]["bx_off"]+this.pos_arr_dn["lLimb"]["rx_off"],this.pos_arr_dn["lLimb"]["by_off"]+this.pos_arr_dn["lLimb"]["ry_off"]];
}

bodyPos.prototype.getLHand1PosAXoff = function() {
   return [this.pos_arr_dn["lLimb"]["rx_off"],this.pos_arr_dn["lLimb"]["ry_off"]];
}

bodyPos.prototype.getInitalPos = function(orient,bid) {
   if(orient=="ru"||orient=="lu")
      return this.pos_arr_up[bid];
   else if(orient=="rd"||orient=="ld")
      return this.pos_arr_dn[bid];
}

bodyPos.prototype.getUpDnOffset = function() {
   return this.up_dn_offset;
}

bodyPos.prototype.getUpDnOffset_name = function() {
   return this.up_dn_offset_name;
}


/*
protocal:  llegimg
                  _ac1img:offx:offy
                  _ac2img:offx:offy
           ||lhandimg
                    _ac1img:offx:offy
                    _ac2img:offx:offy
           ||bodyimg
                    _ac1img:offx:offy
                    _ac2img:offx:offy
....

eg:    lLeg_shoes:-3:13||lArm||body||rLeg_shoes:-2:13||rArm||head
*/
var base_pos = new bodyPos();
function human(orient,inistr) {
    //watch the order
    this.inistr = inistr;

    this.dn_up_off = base_pos.getUpDnOffset(); //the offset synconize the up images to down images. to make sure that up and down can use the same images.

    this.overlap_order_dn = [0,1,2,4,5,6,3,7];
    this.overlap_order_up = [4,5,6,0,1,2,3,7];  //定?各个部位的?示?序，?度必?是部位的数量。??的部分参考inistr的｜｜?序

    this.humanObj = [];
    this.loadedImg = [];
    this.aniArr = [];    //走路用?作数?
    this.actArr = [];    //?作表情用的?作数?
    this.aniLen = 0;
    this.actLen = 0;
    this.aniPoint = 0;
    this.actPoint = 0;
    this.orient = orient;

    this.px = -20;
    this.py = -20;
    this.ss = null;

    this.offx = 0;
    this.offy = 0;

    this.loadRes();
    this.isLoaded = 0;
}


human.prototype.loadRes = function() {
    var inistr = this.inistr;

    var img_arr_ld =[];
    var img_arr_rd =[];
    var img_arr_lu =[];
    var img_arr_ru =[];

    var inistr_split = inistr.split("||");
    var headNo = inistr_split[0];
    var bodyNo = inistr_split[1];

    //var bodyArr = ["lLeg","lArm","lLimb","body","rLeg","rArm","rLimb","head"];

    for(var i=2;i<inistr_split.length;i++) {
        var body_item_split = inistr_split[i].split("_");
        var body_part_img_name = body_item_split[0];

        var humanDir = "human"+bodyNo;   //human1 for boys, human2 for girls

        if(i==9) {   //根据headNo 判断当前用?的?型
           img_arr_ld.push("res/"+humanDir+"/LD/h"+headNo+"/"+body_part_img_name+".png");
           img_arr_rd.push("res/"+humanDir+"/RD/h"+headNo+"/"+body_part_img_name+".png");
           img_arr_lu.push("res/"+humanDir+"/LU/h"+headNo+"/"+body_part_img_name+".png");
           img_arr_ru.push("res/"+humanDir+"/RU/h"+headNo+"/"+body_part_img_name+".png");
        }
        else if(i==5) {  //根据bodyNo判断当前男女体型
           img_arr_ld.push("res/"+humanDir+"/LD/b1/"+body_part_img_name+".png");
           img_arr_rd.push("res/"+humanDir+"/RD/b1/"+body_part_img_name+".png");
           img_arr_lu.push("res/"+humanDir+"/LU/b1/"+body_part_img_name+".png");
           img_arr_ru.push("res/"+humanDir+"/RU/b1/"+body_part_img_name+".png");
        } else {
           img_arr_ld.push("res/"+humanDir+"/LD/"+body_part_img_name+".png");
           img_arr_rd.push("res/"+humanDir+"/RD/"+body_part_img_name+".png");
           img_arr_lu.push("res/"+humanDir+"/LU/"+body_part_img_name+".png");
           img_arr_ru.push("res/"+humanDir+"/RU/"+body_part_img_name+".png");
        }

/*
        for(var j=1;j<body_item_split.length;j++)  {
             var ac_item = body_item_split[j].split(":");
             var ac_img_name = ac_item[0];
             img_arr_ld.push("res/human/LD/"+ac_img_name+".png");
             img_arr_rd.push("res/human/RD/"+ac_img_name+".png");
             img_arr_lu.push("res/human/LU/"+ac_img_name+".png");
             img_arr_ru.push("res/human/RU/"+ac_img_name+".png");
        }
*/

        for(var j=1;j<body_item_split.length;j++)  {
             var ac_item = body_item_split[j].split(":");
             var ac_img_name = ac_item[0];
             var ac_folder = ac_img_name.substring(1);
             img_arr_ld.push("res/items/"+ac_folder+"/LD/"+ac_img_name+".png");
             img_arr_rd.push("res/items/"+ac_folder+"/RD/"+ac_img_name+".png");
             img_arr_lu.push("res/items/"+ac_folder+"/LU/"+ac_img_name+".png");
             img_arr_ru.push("res/items/"+ac_folder+"/RU/"+ac_img_name+".png");
        }

    }

    this.ss = new ImagePreloader(img_arr_ld,img_arr_rd,img_arr_lu,img_arr_ru,this);
}


human.prototype.startUP = function() {
    var baseX=20;
    var baseY=20;
    if(isTest) {
        baseX = 40;  
        baseY = 25;
    }
    var thisX;
    var thisY;
    var thisRotX;
    var thisRotY;
    var thisDeg;
    var thisDisp;

    var selected_body;
    //var base_pos = new bodyPos();
    var dn_up_off_name = base_pos.getUpDnOffset_name();

    var inistr_split = this.inistr.split("||");
    var orient = this.orient;
    var thisimg;

    for(var i=2;i<inistr_split.length;i++) {
        var body_item_split = inistr_split[i].split("_");
        var body_part_img_name = body_item_split[0];

        var body_item_pos = base_pos.getInitalPos(orient,body_part_img_name);

        thisX = baseX + body_item_pos["bx_off"];
        thisY = baseY + body_item_pos["by_off"];
        thisRotX = thisX + body_item_pos["rx_off"];
        thisRotY = thisY + body_item_pos["ry_off"];
        
        thisDeg = 0;

        thisimg = this.ss.getBodyImg(orient + "_" + body_part_img_name);

        // for body part, upper part is calculated from down part, so the up postion can be set to 0
        var tp = new BodyPart(thisX,thisY,thisRotX,thisRotY,thisDeg,thisimg,body_part_img_name,orient);
        tp.setUpDnOffset(dn_up_off_name);
        tp.setPosOff(this.px,this.py);

        for(var j=1;j<body_item_split.length;j++)  {
             var ac_item = body_item_split[j].split(":");
             var ac_img_name = ac_item[0];
             thisimg = this.ss.getBodyImg(orient + "_" + ac_img_name);

             if(orient=="ld" || orient=="rd")  {
                var ac_baseX = thisX + parseInt(ac_item[1]);
                var ac_baseY = thisY + parseInt(ac_item[2]);
             }
             else if(orient=="lu" || orient=="ru") {
                var ac_baseX = thisX + parseInt(ac_item[3]);
                var ac_baseY = thisY + parseInt(ac_item[4]);
             }
             
             var ac = new Accessories(ac_baseX,ac_baseY,thisRotX,thisRotY,thisDeg,thisimg,ac_img_name,orient);
             
             if(typeof(ac_item[5]) != 'undefined') {
                 thisDisp = parseInt(ac_item[4]);
                 (thisDisp==0) ? ac.disp=false : ac.disp=true;
             } else {
                 ac.disp=true; 
             }

             ac.setOffsetVal(parseInt(ac_item[1]),parseInt(ac_item[2]),parseInt(ac_item[3]),parseInt(ac_item[4]));
             ac.setPosOff(this.px,this.py);

             tp.setAccessory(ac);
        }

        this.humanObj[this.humanObj.length] = tp;
    }
    if(isTest)
       this.drawFrame();

    this.isLoaded = 1;
}


human.prototype.setDir = function(val) {
    var thisimg;
    this.orient = val;

    for(var i=0;i<this.humanObj.length;i++)  {
       var hObj = this.humanObj[i];
       hObj.setDir(val);
       thisimg = this.ss.getBodyImg(val + "_" + hObj.getName());
       hObj.setImg(thisimg);

       for(var j=0;j<hObj.accessories.length;j++) {
           thisimg = this.ss.getBodyImg(hObj.accessories[j].getInvert() + "_" + hObj.accessories[j].getName());
           hObj.accessories[j].setImg(thisimg);
       }
    }
    if(isTest)
       this.drawFrame();
}


human.prototype.resetDirImg = function(hObj) {
    var thisimg = this.ss.getBodyImg(hObj.getInvert() + "_" + hObj.getName());
    hObj.setImg(thisimg);
    for(var i=0;i<hObj.accessories.length;i++) {
        thisimg = this.ss.getBodyImg(hObj.accessories[i].getInvert() + "_" + hObj.accessories[i].getName());
        hObj.accessories[i].setImg(thisimg);
    }
}


//18:78:0_7:57:0_20:57:0_27:82:0_34:58:0_0:0:0
human.prototype.setPOS = function(actStr) {
    //var actStr="38:98:0:ld_27:77:0:ld_40:77:0:ld_47:102:0:ld_54:78:0:ld_20:20:0:ld";
    var actStr_arr = actStr.split("_");
    var pos_arr,bx,by,deg,ot,dispCtrl;

    for(var i=0;i<actStr_arr.length;i++)  {
        pos_arr = actStr_arr[i].split(";");
        bx = parseInt(pos_arr[0]);
        by = parseInt(pos_arr[1]);
        deg = parseInt(pos_arr[2]);
        ot = pos_arr[3];

        if(typeof(pos_arr[4]) != 'undefined') {
             dispCtrl = pos_arr[4];
             this.setInvisible(i,dispCtrl);
        }


        if(this.orient=="lu" || this.orient=="ru") {
//           ot=this.orient;

           if(this.orient=="ru") {
              if(ot=="ld")
                  ot="ru";
              else if(ot=="rd")
                  ot="lu";
           } else if(this.orient=="lu") {
              if(ot=="ld")
                  ot="lu";
              else if(ot=="rd")
                  ot="ru";
           }

           //因?lu的bodypart?形是从ld而来，但是排列上跟ld有区?，?了?一算法，因此?算出lu?形跟ld的offset，然后在?置1?的?候套用
           bx += this.dn_up_off[i][0];
           by += this.dn_up_off[i][1];
        }

        if(this.orient=="rd") {
           if(ot=="ld")
               ot="rd";
           else if(ot=="rd")
               ot="ld";
        }

        this.humanObj[i].setBodyPos(bx,by,deg,ot);
        this.resetDirImg(this.humanObj[i]);
    }
}

human.prototype.setInvisible = function(bodyNum,dispCtrl) {
    var accNo;
    var cnt=0;
    this.setAccVisible(bodyNum);
    while(dispCtrl.length>0) {
        cnt ++;
        accNo = parseInt(dispCtrl.substring(0,1));
        this.humanObj[bodyNum].accessories[accNo].disp = false;
        dispCtrl = dispCtrl.substring(cnt,dispCtrl.length);
    }
}

human.prototype.setAccVisible = function(bodyNum) {
    for(var i=0;i<this.humanObj[bodyNum].accessories.length;i++) {
        this.humanObj[bodyNum].accessories[i].disp = true;
    }
}


human.prototype.getPOS = function(actStr) {
    var posstr="";
    for(var i=0;i<this.humanObj.length;i++)  {
        var ho = this.humanObj[i];
        posstr += ho.getBaseX() +";"+ ho.getBaseY() +";"+ ho.getDeg() +";"+ ho.getInvert() + "_";
        //posstr += ho.getBaseX() +":"+ ho.getBaseY() +":"+ ho.getDeg() + "_";
    }
    return posstr.substring(0,posstr.length-1);
}

human.prototype.animator = function(aniStr) {
    this.aniArr = aniStr.split("&&");
    this.aniLen = this.aniArr.length;
    if(isTest)
      hm_iID = setInterval(this.moveAni,100);
}

human.prototype.action = function(aniStr) {
    this.actArr = aniStr.split("&&");
    this.actLen = this.actArr.length;
}

human.prototype.getAniLen = function() {
    return this.aniLen-1;
}

human.prototype.getActLen = function() {
    return this.actLen-1;
}

human.prototype.setAniFrame = function(fid) {
    fid++;
    var aniPos = this.aniArr[fid];
//alert(this.aniArr[1]);
    this.setPOS(aniPos);
}

human.prototype.setActFrame = function(fid) {
    fid++;
    var actPos = this.actArr[fid];
    this.setPOS(actPos);
}

human.prototype.moveAni = function() {
    var aniPos = hm.aniArr[hm.aniPoint];
    hm.setPOS(aniPos);
    hm.drawFrame();
    hm.aniPoint++;
    if(hm.aniPoint == hm.aniArr.length)
       hm.aniPoint = 0;
    //clearInterval(hm_iID);
}

human.prototype.setHMPos = function(px,py) {
    this.px = px-50;
    this.py = py-120;

    for(var i=0;i<this.humanObj.length;i++)  {
       var hObj = this.humanObj[i];
       hObj.setPosOff(this.px,this.py);

       for(var j=0;j<hObj.accessories.length;j++) {
           hObj.accessories[j].setPosOff(this.px,this.py);
       }
    }
}

human.prototype.drawFrame = function(disp) {
    disp = typeof(disp) == "undefined" ? 1 : disp;
    var ol = [];
    if(this.orient == "ld" || this.orient == "rd")
       ol = this.overlap_order_dn;
    else if(this.orient == "lu" || this.orient == "ru")
       ol = this.overlap_order_up;

    if(isTest)
       ctx.clearRect(0,0,100,150);   //canvas size

    for(var i=0;i<this.humanObj.length;i++) {
       //this.humanObj[ol[i]].setDisp(disp);
       this.humanObj[ol[i]].drawImage();
    }
    //this.drawCircle(50,120,"#00f");  //draw the base point
}

human.prototype.selectBody = function(id) {
    this.selected_body = this.humanObj[id];
}


human.prototype.recoverSelectedRotPos = function(id) {
    this.humanObj[id].recoverRotPos();
}

human.prototype.getSelectedRotY = function(id) {
    return this.humanObj[id].getRotY();
}

human.prototype.moveUP = function(id) {
    this.selected_body.moveUP();
}
human.prototype.moveDOWN = function(id) {
    this.selected_body.moveDOWN();
}
human.prototype.moveLEFT = function(id) {
    this.selected_body.moveLEFT();
}
human.prototype.moveRIGHT = function(id) {
    this.selected_body.moveRIGHT();
}
human.prototype.rotRIGHT = function(id) {
    this.selected_body.rotRIGHT();
}
human.prototype.rotLEFT = function(id) {
    this.selected_body.rotLEFT();
}
human.prototype.invert = function() {
    this.selected_body.invertBody();
    this.resetDirImg(this.selected_body);
}

human.prototype.drawCircle = function(x,y,color){
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(x,y,1,0,Math.PI*2,true);
    ctx.fill();
}
