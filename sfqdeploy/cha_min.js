function ImagePreloader(a,b,c,d,e){this.pObj=e;this.nLoaded=0;this.nProcessed=0;this.aImages=[];this.nImages=a.length+b.length+c.length+d.length;for(var f=0;f<a.length;f++)this.preload(a[f],"ld");for(var f=0;f<b.length;f++)this.preload(b[f],"rd");for(var f=0;f<c.length;f++)this.preload(c[f],"lu");for(var f=0;f<d.length;f++)this.preload(d[f],"ru")}function extend(a,b){var c=a.prototype;a.prototype=new b;a.prototype.constructor=a;for(var d in c){a.prototype[d]=c[d]}a.supr=b}function BasePart(a,b,c,d,e,f,g,h){this.baseX=a;this.baseY=b;this.rotX=c;this.rotY=d;this.rotX1=c;this.rotY1=d;this.degree=e;this.name=g;this.img=f;this.orient=h;this.offx=0;this.offy=0;this.disp=1}function BodyPart(a,b,c,d,e,f,g,h){BodyPart.supr.call(this,a,b,c,d,e,f,g,h);this.accessories=new Array;if(h=="lu"||h=="ru"){this.isUPed=true}else{this.isUPed=false}}function Accessories(a,b,c,d,e,f,g,h){Accessories.supr.call(this,a,b,c,d,e,f,g,h)}function createTwoDimensionArray(a,b){var c=new Array(a.length);for(var d=0;d<a.length;d++){c[a[d]]=new Array(b)}return c}function bodyPos(){var a=["lLeg","lArm","lLimb","body","rLeg","rArm","rLimb","head"];this.pos_arr_up=createTwoDimensionArray(a,4);this.pos_arr_dn=createTwoDimensionArray(a,4);this.up_dn_offset=createTwoDimensionArray([0,1,2,3,4,5,6,7],2);this.up_dn_offset_name=createTwoDimensionArray(a,2);this.pos_arr_dn["lLeg"]["bx_off"]=13;this.pos_arr_dn["lLeg"]["by_off"]=83;this.pos_arr_dn["lLeg"]["rx_off"]=8;this.pos_arr_dn["lLeg"]["ry_off"]=4;this.pos_arr_dn["lArm"]["bx_off"]=-1;this.pos_arr_dn["lArm"]["by_off"]=74;this.pos_arr_dn["lArm"]["rx_off"]=14;this.pos_arr_dn["lArm"]["ry_off"]=0;this.pos_arr_dn["lLimb"]["bx_off"]=11;this.pos_arr_dn["lLimb"]["by_off"]=65;this.pos_arr_dn["lLimb"]["rx_off"]=14;this.pos_arr_dn["lLimb"]["ry_off"]=0;this.pos_arr_dn["body"]["bx_off"]=16;this.pos_arr_dn["body"]["by_off"]=62;this.pos_arr_dn["body"]["rx_off"]=12;this.pos_arr_dn["body"]["ry_off"]=0;this.pos_arr_dn["rLeg"]["bx_off"]=24;this.pos_arr_dn["rLeg"]["by_off"]=88;this.pos_arr_dn["rLeg"]["rx_off"]=8;this.pos_arr_dn["rLeg"]["ry_off"]=0;this.pos_arr_dn["rArm"]["bx_off"]=42;this.pos_arr_dn["rArm"]["by_off"]=74;this.pos_arr_dn["rArm"]["rx_off"]=0;this.pos_arr_dn["rArm"]["ry_off"]=0;this.pos_arr_dn["rLimb"]["bx_off"]=32;this.pos_arr_dn["rLimb"]["by_off"]=65;this.pos_arr_dn["rLimb"]["rx_off"]=0;this.pos_arr_dn["rLimb"]["ry_off"]=0;this.pos_arr_dn["head"]["bx_off"]=0;this.pos_arr_dn["head"]["by_off"]=0;this.pos_arr_dn["head"]["rx_off"]=32;this.pos_arr_dn["head"]["ry_off"]=57;this.pos_arr_up["lLeg"]["bx_off"]=14;this.pos_arr_up["lLeg"]["by_off"]=87;this.pos_arr_up["lLeg"]["rx_off"]=8;this.pos_arr_up["lLeg"]["ry_off"]=4;this.pos_arr_up["lArm"]["bx_off"]=1;this.pos_arr_up["lArm"]["by_off"]=72;this.pos_arr_up["lArm"]["rx_off"]=14;this.pos_arr_up["lArm"]["ry_off"]=0;this.pos_arr_up["lLimb"]["bx_off"]=12;this.pos_arr_up["lLimb"]["by_off"]=63;this.pos_arr_up["lLimb"]["rx_off"]=14;this.pos_arr_up["lLimb"]["ry_off"]=0;this.pos_arr_up["body"]["bx_off"]=16;this.pos_arr_up["body"]["by_off"]=62;this.pos_arr_up["body"]["rx_off"]=12;this.pos_arr_up["body"]["ry_off"]=0;this.pos_arr_up["rLeg"]["bx_off"]=24;this.pos_arr_up["rLeg"]["by_off"]=82;this.pos_arr_up["rLeg"]["rx_off"]=8;this.pos_arr_up["rLeg"]["ry_off"]=4;this.pos_arr_up["rArm"]["bx_off"]=39;this.pos_arr_up["rArm"]["by_off"]=71;this.pos_arr_up["rArm"]["rx_off"]=0;this.pos_arr_up["rArm"]["ry_off"]=0;this.pos_arr_up["rLimb"]["bx_off"]=30;this.pos_arr_up["rLimb"]["by_off"]=62;this.pos_arr_up["rLimb"]["rx_off"]=0;this.pos_arr_up["rLimb"]["ry_off"]=0;this.pos_arr_up["head"]["bx_off"]=0;this.pos_arr_up["head"]["by_off"]=0;this.pos_arr_up["head"]["rx_off"]=32;this.pos_arr_up["head"]["ry_off"]=57;this.up_dn_offset[0][0]=this.pos_arr_up["lLeg"]["bx_off"]-this.pos_arr_dn["lLeg"]["bx_off"];this.up_dn_offset[0][1]=this.pos_arr_up["lLeg"]["by_off"]-this.pos_arr_dn["lLeg"]["by_off"];this.up_dn_offset[1][0]=this.pos_arr_up["lArm"]["bx_off"]-this.pos_arr_dn["lArm"]["bx_off"];this.up_dn_offset[1][1]=this.pos_arr_up["lArm"]["by_off"]-this.pos_arr_dn["lArm"]["by_off"];this.up_dn_offset[2][0]=this.pos_arr_up["lLimb"]["bx_off"]-this.pos_arr_dn["lLimb"]["bx_off"];this.up_dn_offset[2][1]=this.pos_arr_up["lLimb"]["by_off"]-this.pos_arr_dn["lLimb"]["by_off"];this.up_dn_offset[3][0]=this.pos_arr_up["body"]["bx_off"]-this.pos_arr_dn["body"]["bx_off"];this.up_dn_offset[3][1]=this.pos_arr_up["body"]["by_off"]-this.pos_arr_dn["body"]["by_off"];this.up_dn_offset[4][0]=this.pos_arr_up["rLeg"]["bx_off"]-this.pos_arr_dn["rLeg"]["bx_off"];this.up_dn_offset[4][1]=this.pos_arr_up["rLeg"]["by_off"]-this.pos_arr_dn["rLeg"]["by_off"];this.up_dn_offset[5][0]=this.pos_arr_up["rArm"]["bx_off"]-this.pos_arr_dn["rArm"]["bx_off"];this.up_dn_offset[5][1]=this.pos_arr_up["rArm"]["by_off"]-this.pos_arr_dn["rArm"]["by_off"];this.up_dn_offset[6][0]=this.pos_arr_up["rLimb"]["bx_off"]-this.pos_arr_dn["rLimb"]["bx_off"];this.up_dn_offset[6][1]=this.pos_arr_up["rLimb"]["by_off"]-this.pos_arr_dn["rLimb"]["by_off"];this.up_dn_offset[7][0]=this.pos_arr_up["head"]["bx_off"]-this.pos_arr_dn["head"]["bx_off"];this.up_dn_offset[7][1]=this.pos_arr_up["head"]["by_off"]-this.pos_arr_dn["head"]["by_off"];this.up_dn_offset_name["lLeg"]=this.up_dn_offset[0];this.up_dn_offset_name["lArm"]=this.up_dn_offset[1];this.up_dn_offset_name["lLimb"]=this.up_dn_offset[2];this.up_dn_offset_name["body"]=this.up_dn_offset[3];this.up_dn_offset_name["rLeg"]=this.up_dn_offset[4];this.up_dn_offset_name["rArm"]=this.up_dn_offset[5];this.up_dn_offset_name["rLimb"]=this.up_dn_offset[6];this.up_dn_offset_name["head"]=this.up_dn_offset[7]}function human(a,b){this.inistr=b;this.dn_up_off=base_pos.getUpDnOffset();this.overlap_order_dn=[0,1,2,4,3,5,6,7];this.overlap_order_up=[4,5,6,0,1,2,3,7];this.humanObj=[];this.loadedImg=[];this.aniArr=[];this.actArr=[];this.aniLen=0;this.actLen=0;this.aniPoint=0;this.actPoint=0;this.orient=a;this.px=-20;this.py=-20;this.ss=null;this.offx=0;this.offy=0;this.loadRes();this.isLoaded=0}function formPath(a){return a.substring(1)}function getIniStr(){return inistr}function addItem(a){var b=a.split("||");var c,d;var e,f,g;if(isItemInIni(a,inistr)){inistr=removeItem(a);return inistr}for(var h=0;h<b.length;h++){d=b[h].split(":");e=d[0];f=d[1];g=d[2]+":"+d[3]+":"+d[4]+":"+d[5];inistr=setItem(e,f,g)}return inistr}function removeItem(a){var b=a.split("||");var c,d;var e,f,g;for(var h=0;h<b.length;h++){d=b[h].split(":");e=d[0];f=d[1];inistr=unsetItem(e,f)}return inistr}function setItem(a,b,c){var d=inistr.split("||");var e="";for(var f=0;f<d.length;f++){if(d[f].startWith(a)){d[f]+="_"+b+":"+c}e+="||"+d[f]}return e.substring(2)}function unsetItem(a,b){var c=inistr.split("||");var d;var e="";var f;var g="";for(var h=0;h<c.length;h++){if(c[h].startWith(a)){d=c[h].split("_");f=d[0];for(var i=1;i<d.length;i++){if(d[i].startWith(b)){}else{g+=d[i]+"_"}}g=g.substring(0,g.length-1);if(g){c[h]=f+"_"+g}else c[h]=f}e+="||"+c[h]}return e.substring(2)}function getAttachmentList(a){var b=a.split("||");var c,d;var e=[];for(var f=0;f<b.length;f++){c=b[f].split("_");for(var g=1;g<c.length;g++){d=c[g].split(":");d=d[0].substring(1);if(e.IndexOf(d)==-1)e[e.length]=d}}return e}function getItemAttachement(a){var b=a.split("||");var c=b[0].split(":");return c[1].substring(1)}function isItemInIni(a,b){var c=getItemAttachement(a);var d=getAttachmentList(b);if(d.IndexOf(c)==-1)return false;else return true}ImagePreloader.prototype.preload=function(a,b){var c=new Image;var d=a.split("/");d=d[d.length-1];d=d.split(".")[0];this.aImages[b+"_"+d]=c;c.onload=ImagePreloader.prototype.onload;c.onerror=ImagePreloader.prototype.onerror;c.onabort=ImagePreloader.prototype.onabort;c.oImagePreloader=this;c.bLoaded=false;c.src=a};ImagePreloader.prototype.onComplete=function(){this.nProcessed++;if(this.nProcessed==this.nImages){this.pObj.startUP()}};ImagePreloader.prototype.onload=function(){this.bLoaded=true;this.oImagePreloader.nLoaded++;this.oImagePreloader.onComplete()};ImagePreloader.prototype.onerror=function(){this.bError=true;this.oImagePreloader.onComplete()};ImagePreloader.prototype.onabort=function(){this.bAbort=true;this.oImagePreloader.onComplete()};ImagePreloader.prototype.getBodyImg=function(a){return this.aImages[a]};BasePart.prototype.UP=function(){this.baseY-=2;this.rotY-=2;this.rotY1-=2};BasePart.prototype.DOWN=function(){this.baseY+=2;this.rotY+=2;this.rotY1+=2};BasePart.prototype.LEFT=function(){this.baseX-=2;this.rotX-=2;this.rotX1-=2};BasePart.prototype.RIGHT=function(){this.baseX+=2;this.rotX+=2;this.rotX1+=2};BasePart.prototype.RotRIGHT=function(){this.degree-=10};BasePart.prototype.RotLEFT=function(){this.degree+=10};BasePart.prototype.setBasePos=function(a,b,c){this.baseX+=a;this.baseY+=b;this.rotX+=a;this.rotY+=b;this.rotX1=this.rotX;this.rotY1=this.rotY;this.degree=c};BasePart.prototype.setPos=function(a,b){this.baseX=a+20;this.baseY=b+20};BasePart.prototype.setPosOff=function(a,b){this.offx=a;this.offy=b};BasePart.prototype.setRotPos=function(a,b){this.rotX=a;this.rotY=b};BasePart.prototype.recoverRotPos=function(){this.rotX=this.rotX1;this.rotY=this.rotY1};BasePart.prototype.getRotX=function(){return this.rotX};BasePart.prototype.getRotY=function(){return this.rotY};BasePart.prototype.setOrient=function(a){this.orient=a};BasePart.prototype.setImg=function(a){this.img=a};BasePart.prototype.getName=function(){return this.name};BasePart.prototype.getBaseX=function(){return this.baseX};BasePart.prototype.getBaseY=function(){return this.baseY};BasePart.prototype.getDeg=function(){return this.degree};BasePart.prototype.getInvert=function(){return this.orient};BasePart.prototype.setInvert=function(){if(this.orient=="ld")this.orient="rd";else if(this.orient=="rd")this.orient="ld";else if(this.orient=="lu")this.orient="ru";else if(this.orient=="ru")this.orient="lu"};BasePart.prototype.setInvertVal=function(a){this.orient=a};BasePart.prototype.draw=function(){var a=this.baseX;var b=this.baseY;var c=this.rotX;var d=this.rotY;var e=this.degree;var f;if(isTest)f=140;else f=100;if(this.orient=="rd"||this.orient=="ru"){a=f-this.baseX-this.img.width;c=f-this.rotX;e=0-this.degree}this.drawSprite(this.img,a,b,c,d,e)};BasePart.prototype.getRotTarget=function(a,b,c,d,e){var f=e;var g=Math.sin(f*(Math.PI/180));var h=Math.cos(f*(Math.PI/180));var i=a;var j=b;var k=c;var l=d;x2=(i-k)*h-(j-l)*g+k;y2=(j-l)*h+(i-k)*g+l;return[parseInt(x2),parseInt(y2)]};BasePart.prototype.drawSprite=function(a,b,c,d,e,f){var g=f;var h=Math.sin(g*(Math.PI/180));var i=Math.cos(g*(Math.PI/180));var j=b;var k=c;var l=d+this.offx;var m=e+this.offy;x2=(l-j)*i-(m-k)*h+j;y2=(m-k)*i+(l-j)*h+k;var n=parseInt(x2)-l;var o=parseInt(y2)-m;var p=parseInt(j+64-h*64);var q=parseInt(k-i*64);ctx.save();ctx.translate(j-n,k-o);ctx.rotate(g*(Math.PI/180));ctx.drawImage(a,this.offx,this.offy);ctx.restore()};BodyPart.prototype.drawImage=function(){this.draw();for(var a=0;a<this.accessories.length;a++){this.accessories[a].drawImage()}};BodyPart.prototype.setAccessory=function(a){this.accessories[this.accessories.length]=a};BodyPart.prototype.setUpDnOffset=function(a){this.up_dn_off=a};BodyPart.prototype.setDir=function(a){this.setOrient(a);if((this.orient=="lu"||this.orient=="ru")&&!this.isUPed){this.baseX+=this.up_dn_off[this.name][0];this.baseY+=this.up_dn_off[this.name][1];this.isUPed=true}if((this.orient=="ld"||this.orient=="rd")&&this.isUPed){this.baseX-=this.up_dn_off[this.name][0];this.baseY-=this.up_dn_off[this.name][1];this.isUPed=false}for(var b=0;b<this.accessories.length;b++){this.accessories[b].setOrient(a);if(this.orient=="ld"||this.orient=="rd"){var c=this.baseX+this.accessories[b].off_ox1;var d=this.baseY+this.accessories[b].off_oy1}else if(this.orient=="lu"||this.orient=="ru"){var c=this.baseX+this.accessories[b].off_ox2;var d=this.baseY+this.accessories[b].off_oy2}this.accessories[b].baseX=c;this.accessories[b].baseY=d}};BodyPart.prototype.moveUP=function(){this.UP();for(var a=0;a<this.accessories.length;a++){this.accessories[a].UP()}};BodyPart.prototype.moveDOWN=function(){this.DOWN();for(var a=0;a<this.accessories.length;a++){this.accessories[a].DOWN()}};BodyPart.prototype.moveLEFT=function(){this.LEFT();for(var a=0;a<this.accessories.length;a++){this.accessories[a].LEFT()}};BodyPart.prototype.moveRIGHT=function(){this.RIGHT();for(var a=0;a<this.accessories.length;a++){this.accessories[a].RIGHT()}};BodyPart.prototype.rotRIGHT=function(){this.RotRIGHT();for(var a=0;a<this.accessories.length;a++){this.accessories[a].RotRIGHT()}};BodyPart.prototype.rotLEFT=function(){this.RotLEFT();for(var a=0;a<this.accessories.length;a++){this.accessories[a].RotLEFT()}};BodyPart.prototype.setBodyPos=function(a,b,c,d){var e=a-this.baseX;var f=b-this.baseY;this.setBasePos(e,f,c);this.setInvertVal(d);for(var g=0;g<this.accessories.length;g++){this.accessories[g].setBasePos(e,f,c);this.accessories[g].setInvertVal(d)}};BodyPart.prototype.invertBody=function(){this.setInvert();for(var a=0;a<this.accessories.length;a++){this.accessories[a].setInvert()}};Accessories.prototype.setOffsetVal=function(a,b,c,d){this.off_ox1=a;this.off_oy1=b;this.off_ox2=c;this.off_oy2=d};Accessories.prototype.setOrient=function(a){this.orient=a};Accessories.prototype.setDisp=function(a){this.disp=a};Accessories.prototype.drawImage=function(){var a=this.name.substring(0,1);if(!(a=="M"&&(this.orient=="lu"||this.orient=="ru"))&&this.disp){this.draw()}};extend(BodyPart,BasePart);extend(Accessories,BasePart);bodyPos.prototype.getRHand1Pos=function(){return[this.pos_arr_dn["rLimb"]["bx_off"]+this.pos_arr_dn["rLimb"]["rx_off"],this.pos_arr_dn["rLimb"]["by_off"]+this.pos_arr_dn["rLimb"]["ry_off"]]};bodyPos.prototype.getRHand1PosAXoff=function(){return[this.pos_arr_dn["rLimb"]["rx_off"],this.pos_arr_dn["rLimb"]["ry_off"]]};bodyPos.prototype.getLHand1Pos=function(){return[this.pos_arr_dn["lLimb"]["bx_off"]+this.pos_arr_dn["lLimb"]["rx_off"],this.pos_arr_dn["lLimb"]["by_off"]+this.pos_arr_dn["lLimb"]["ry_off"]]};bodyPos.prototype.getLHand1PosAXoff=function(){return[this.pos_arr_dn["lLimb"]["rx_off"],this.pos_arr_dn["lLimb"]["ry_off"]]};bodyPos.prototype.getInitalPos=function(a,b){if(a=="ru"||a=="lu")return this.pos_arr_up[b];else if(a=="rd"||a=="ld")return this.pos_arr_dn[b]};bodyPos.prototype.getUpDnOffset=function(){return this.up_dn_offset};bodyPos.prototype.getUpDnOffset_name=function(){return this.up_dn_offset_name};var base_pos=new bodyPos;human.prototype.loadRes=function(){var a=this.inistr;var b=[];var c=[];var d=[];var e=[];var f=a.split("||");var g=f[0];var h=f[1];for(var i=2;i<f.length;i++){var j=f[i].split("_");var k=j[0];var l="human"+h;if(i==9){b.push("res/"+l+"/LD/h"+g+"/"+k+".png");c.push("res/"+l+"/RD/h"+g+"/"+k+".png");d.push("res/"+l+"/LU/h"+g+"/"+k+".png");e.push("res/"+l+"/RU/h"+g+"/"+k+".png")}else if(i==5){b.push("res/"+l+"/LD/b1/"+k+".png");c.push("res/"+l+"/RD/b1/"+k+".png");d.push("res/"+l+"/LU/b1/"+k+".png");e.push("res/"+l+"/RU/b1/"+k+".png")}else{b.push("res/"+l+"/LD/"+k+".png");c.push("res/"+l+"/RD/"+k+".png");d.push("res/"+l+"/LU/"+k+".png");e.push("res/"+l+"/RU/"+k+".png")}for(var m=1;m<j.length;m++){var n=j[m].split(":");var o=n[0];var p=o.substring(1);b.push("res/items/"+p+"/LD/"+o+".png");c.push("res/items/"+p+"/RD/"+o+".png");d.push("res/items/"+p+"/LU/"+o+".png");e.push("res/items/"+p+"/RU/"+o+".png")}}this.ss=new ImagePreloader(b,c,d,e,this)};human.prototype.startUP=function(){var a=20;var b=20;if(isTest){a=40;b=25}var c;var d;var e;var f;var g;var h;var i;var j=base_pos.getUpDnOffset_name();var k=this.inistr.split("||");var l=this.orient;var m;for(var n=2;n<k.length;n++){var o=k[n].split("_");var p=o[0];var q=base_pos.getInitalPos(l,p);c=a+q["bx_off"];d=b+q["by_off"];e=c+q["rx_off"];f=d+q["ry_off"];g=0;m=this.ss.getBodyImg(l+"_"+p);var r=new BodyPart(c,d,e,f,g,m,p,l);r.setUpDnOffset(j);r.setPosOff(this.px,this.py);for(var s=1;s<o.length;s++){var t=o[s].split(":");var u=t[0];m=this.ss.getBodyImg(l+"_"+u);if(l=="ld"||l=="rd"){var v=c+parseInt(t[1]);var w=d+parseInt(t[2])}else if(l=="lu"||l=="ru"){var v=c+parseInt(t[3]);var w=d+parseInt(t[4])}var x=new Accessories(v,w,e,f,g,m,u,l);if(typeof t[5]!="undefined"){h=parseInt(t[4]);h==0?x.disp=false:x.disp=true}else{x.disp=true}x.setOffsetVal(parseInt(t[1]),parseInt(t[2]),parseInt(t[3]),parseInt(t[4]));x.setPosOff(this.px,this.py);r.setAccessory(x)}this.humanObj[this.humanObj.length]=r}if(isTest)this.drawFrame();this.isLoaded=1};human.prototype.setDir=function(a){var b;this.orient=a;for(var c=0;c<this.humanObj.length;c++){var d=this.humanObj[c];d.setDir(a);b=this.ss.getBodyImg(a+"_"+d.getName());d.setImg(b);for(var e=0;e<d.accessories.length;e++){b=this.ss.getBodyImg(d.accessories[e].getInvert()+"_"+d.accessories[e].getName());d.accessories[e].setImg(b)}}if(isTest)this.drawFrame()};human.prototype.resetDirImg=function(a){var b=this.ss.getBodyImg(a.getInvert()+"_"+a.getName());a.setImg(b);for(var c=0;c<a.accessories.length;c++){b=this.ss.getBodyImg(a.accessories[c].getInvert()+"_"+a.accessories[c].getName());a.accessories[c].setImg(b)}};human.prototype.setPOS=function(a){var b=a.split("_");var c,d,e,f,g,h;for(var i=0;i<b.length;i++){c=b[i].split(";");d=parseInt(c[0]);e=parseInt(c[1]);f=parseInt(c[2]);g=c[3];if(typeof c[4]!="undefined"){h=c[4];this.setInvisible(i,h)}if(this.orient=="lu"||this.orient=="ru"){if(this.orient=="ru"){if(g=="ld")g="ru";else if(g=="rd")g="lu"}else if(this.orient=="lu"){if(g=="ld")g="lu";else if(g=="rd")g="ru"}d+=this.dn_up_off[i][0];e+=this.dn_up_off[i][1]}if(this.orient=="rd"){if(g=="ld")g="rd";else if(g=="rd")g="ld"}this.humanObj[i].setBodyPos(d,e,f,g);this.resetDirImg(this.humanObj[i])}};human.prototype.setInvisible=function(a,b){var c;var d=0;this.setAccVisible(a);while(b.length>0){d++;c=parseInt(b.substring(0,1));this.humanObj[a].accessories[c].disp=false;b=b.substring(d,b.length)}};human.prototype.setAccVisible=function(a){for(var b=0;b<this.humanObj[a].accessories.length;b++){this.humanObj[a].accessories[b].disp=true}};human.prototype.getPOS=function(a){var b="";for(var c=0;c<this.humanObj.length;c++){var d=this.humanObj[c];b+=d.getBaseX()+";"+d.getBaseY()+";"+d.getDeg()+";"+d.getInvert()+"_"}return b.substring(0,b.length-1)};human.prototype.animator=function(a){this.aniArr=a.split("&&");this.aniLen=this.aniArr.length;if(isTest)hm_iID=setInterval(this.moveAni,100)};human.prototype.action=function(a){this.actArr=a.split("&&");this.actLen=this.actArr.length};human.prototype.getAniLen=function(){return this.aniLen-1};human.prototype.getActLen=function(){return this.actLen-1};human.prototype.setAniFrame=function(a){a++;var b=this.aniArr[a];this.setPOS(b)};human.prototype.setActFrame=function(a){a++;var b=this.actArr[a];this.setPOS(b)};human.prototype.moveAni=function(){var a=hm.aniArr[hm.aniPoint];hm.setPOS(a);hm.drawFrame();hm.aniPoint++;if(hm.aniPoint==hm.aniArr.length)hm.aniPoint=0};human.prototype.setHMPos=function(a,b){this.px=a-50;this.py=b-120;for(var c=0;c<this.humanObj.length;c++){var d=this.humanObj[c];d.setPosOff(this.px,this.py);for(var e=0;e<d.accessories.length;e++){d.accessories[e].setPosOff(this.px,this.py)}}};human.prototype.drawFrame=function(a){a=typeof a=="undefined"?1:a;var b=[];if(this.orient=="ld"||this.orient=="rd")b=this.overlap_order_dn;else if(this.orient=="lu"||this.orient=="ru")b=this.overlap_order_up;if(isTest)ctx.clearRect(0,0,100,150);for(var c=0;c<this.humanObj.length;c++){this.humanObj[b[c]].drawImage()}};human.prototype.selectBody=function(a){this.selected_body=this.humanObj[a]};human.prototype.recoverSelectedRotPos=function(a){this.humanObj[a].recoverRotPos()};human.prototype.getSelectedRotY=function(a){return this.humanObj[a].getRotY()};human.prototype.moveUP=function(a){this.selected_body.moveUP()};human.prototype.moveDOWN=function(a){this.selected_body.moveDOWN()};human.prototype.moveLEFT=function(a){this.selected_body.moveLEFT()};human.prototype.moveRIGHT=function(a){this.selected_body.moveRIGHT()};human.prototype.rotRIGHT=function(a){this.selected_body.rotRIGHT()};human.prototype.rotLEFT=function(a){this.selected_body.rotLEFT()};human.prototype.invert=function(){this.selected_body.invertBody();this.resetDirImg(this.selected_body)};human.prototype.drawCircle=function(a,b,c){ctx.fillStyle=c;ctx.beginPath();ctx.arc(a,b,1,0,Math.PI*2,true);ctx.fill()};Array.prototype.IndexOf=function(a){for(var b=0;b<this.length;b++){if(this[b]==a)return b}return-1}