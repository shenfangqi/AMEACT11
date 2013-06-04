function getPointInRhombus(a,b){var c,d,e,f;var g,h,i,j,k,l;var m,n;c=parseInt(a/half_tile_width);d=parseInt(b/tile_height_offset);i=a%half_tile_width;j=b%tile_height_offset;if(i+j<half_tile_width+tile_height_offset){}g=c*half_tile_width;h=d*tile_height_offset;if((c+d)%2!=0){m=g+half_tile_width;n=h+tile_height_offset}else{h=h+tile_height_offset;m=g+half_tile_width;n=h-tile_height_offset}var o,p;o=Math.abs(g-a)+Math.abs(h-b);p=Math.abs(m-a)+Math.abs(n-b);if(o<p){a=g;b=h}else{a=m;b=n}return parseInt(pos2loc(a,b))}function pos2loc(a,b){var c,d;c=(2*b+a-itemStartX-half_tile_width)/(half_tile_width*2);d=(b-tile_height_offset-tile_height_offset*c)/tile_height_offset;if(c<0||d<0||c>=map_arr_width||d>=map_arr_height){return-1}return d*map_arr_width+c}function pos2loc_test(a,b){var c,d;c=(2*b+a-half_bg_width-half_tile_width)/(half_tile_width*2);d=(b-tile_height_offset-tile_height_offset*c)/tile_height_offset}function loc2pos(a){var b,c;var d,e;e=parseInt(a/map_arr_width);d=a%map_arr_width;if(d==map_arr_width-1){d=-1;e=e+1}b=itemStartX+half_tile_width*d-half_tile_width*e;c=tile_height_offset+tile_height_offset*d+tile_height_offset*e;return Array(b,c)}function loc2pos_absolute(a){var b,c;var d,e;e=parseInt(a/map_arr_width);d=a%map_arr_width;b=half_bg_width+half_tile_width*d-half_tile_width*e;c=tile_height_offset+tile_height_offset*d+tile_height_offset*e;return Array(b,c)}function is_terrain_passable(a){for(var b=0;b<map_mark.length;b++){if(a==map_mark[b])return true}return false}function Hash(){this.length=0;this.items=new Array;for(var a=0;a<arguments.length;a+=2){if(typeof arguments[a+1]!="undefined"){this.items[arguments[a]]=arguments[a+1];this.length++}}this.removeItem=function(a){var b;if(typeof this.items[a]!="undefined"){this.length--;var b=this.items[a];delete this.items[a]}return b};this.getItem=function(a){return this.items[a]};this.setItem=function(a,b){var c;if(typeof b!="undefined"){if(typeof this.items[a]=="undefined"){this.length++}else{c=this.items[a]}this.items[a]=b}return c};this.hasItem=function(a){return typeof this.items[a]!="undefined"};this.clear=function(){for(var a in this.items){delete this.items[a]}this.length=0};this.getLength=function(){return this.length}}function createTwoDimensionArray(a,b){var c=new Array(a);for(var d=0;d<a;d++){c[d]=new Array(b)}return c}function in_obj_array(a,b){for(key in b){if(b[key].pos==a)return true}return false}function spriteMoveProcess_ht5(a){var b=new Array;var c=parseInt(a.repeatPathCnt);var d=parseInt(a.anID);var e=a.path.toString();var f;b=e.split(",");var g=a.getPathCntVal();var h=b[g];var i=6;var j=2;if(h){thisPos=parseInt(b[g]);nextPos=parseInt(b[g+1]);if(nextPos==thisPos+map_arr_width-1){if(c<i){c++;a.pos=thisPos}else if(c>=i){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=6}else if(nextPos==thisPos-map_arr_width+1){if(c<i){c++;a.pos=thisPos}else if(c>=i){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=2}else if(nextPos==thisPos+1){if(c<j){c++;a.pos=thisPos}else if(c>=j){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=5}else if(nextPos==thisPos-1){if(c<j){c++;a.pos=thisPos}else if(c>=j){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=3}else if(nextPos==thisPos+map_arr_width){if(c<j){c++;a.pos=thisPos}else if(c>=j){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=7}else if(nextPos==thisPos-map_arr_width){if(c<j){c++;a.pos=thisPos}else if(c>=j){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=1}else if(nextPos==thisPos+map_arr_width+1){if(c<j){c++;a.pos=thisPos}else if(c>=j){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=8}else if(nextPos==thisPos-map_arr_width-1){if(c<j){c++;a.pos=thisPos}else if(c>=j){c=0;a.pos=nextPos;g++}a.repeatPathCnt=c;a.dir=0}a.pathCnt=g;d++;if(d>paceNum){d=0}if(g+1>=b.length){d=0}a.anID=d}else{}return a}function spriteMoveProcess(a){var b=new Array;var c=parseInt(a.attr("spriteID"));var d=parseInt(a.attr("spriteHeight"));var e=parseInt(a.attr("repeatPathCnt"));var f=a.attr("path").toString();var g=parseInt(a.attr("anID"));b=f.split(",");var h=parseInt(a.attr("pathCnt"));var i=b[h];var j=6;if(c<1e3){j=6}else if(c>=1e3&&c<2e3){j=2}else{j=4}if(i){thisPos=parseInt(b[h]);nextPos=parseInt(b[h+1]);if(nextPos==thisPos+map_arr_width-1){if(e<6){e++;a[0].pos=thisPos}else if(e>=6){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",6)}else if(nextPos==thisPos-map_arr_width+1){if(e<6){e++;a[0].pos=thisPos}else if(e>=6){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",2)}else if(nextPos==thisPos+1){if(e<2){e++;a[0].pos=thisPos}else if(e>=2){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",5)}else if(nextPos==thisPos-1){if(e<2){e++;a[0].pos=thisPos}else if(e>=2){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",3)}else if(nextPos==thisPos+map_arr_width){if(e<2){e++;a[0].pos=thisPos}else if(e>=2){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",7)}else if(nextPos==thisPos-map_arr_width){if(e<2){e++;a[0].pos=thisPos}else if(e>=2){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",1)}else if(nextPos==thisPos+map_arr_width+1){if(e<2){e++;a[0].pos=thisPos}else if(e>=2){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",8)}else if(nextPos==thisPos-map_arr_width-1){if(e<2){e++;a[0].pos=thisPos}else if(e>=2){e=0;a[0].pos=nextPos;h++}a.attr("repeatPathCnt",e);a.attr("direction",0)}var k=loc2pos(parseInt(a[0].pos));var l=parseInt(a.attr("direction"));if(l==6){posX=k[0]-e*8;posY=k[1]-d}else if(l==2){posX=k[0]+e*8;posY=k[1]-d}else if(l==5){posX=k[0]+e*8;posY=k[1]-d+e*4}else if(l==3){posX=k[0]-e*8;posY=k[1]-d-e*4}else if(l==1){posX=k[0]+e*8;posY=k[1]-d-e*4}else if(l==7){posX=k[0]-e*8;posY=k[1]-d+e*4}else if(l==0){posX=k[0];posY=k[1]-d-e*8}else if(l==8){posX=k[0];posY=k[1]-d+e*8}else{posX=k[0];posY=k[1]-d;l=1}a.css("left",posX);posY=posY-screen_height_offset;a.css("top",posY);a.attr("pathCnt",h);var m=imgByDir(c,l);g++;if(g>j){g=0}if(h+1>=b.length){g=0}a.attr("src","res/spriteRes/"+c+"/"+m+"_"+g+".png");a.attr("anID",g)}return a}function spriteDir(a,b){a=parseInt(a);b=parseInt(b);var c=-1;if(b==a+1){c=5}else if(b==a-1){c=3}else if(b==a+map_arr_width){c=7}else if(b==a-map_arr_width){c=1}else if(b==a+map_arr_width+1){c=8}else if(b==a+map_arr_width-1){c=6}else if(b==a-map_arr_width+1){c=2}else if(b==a-map_arr_width-1){c=0}return c}function imgByDir(a,b){var c=a+"_10";if(b==0){c=a+"_11"}else if(b==1){c=a+"_10"}else if(b==2){c=a+"_10"}else if(b==3){c=a+"_11"}else if(b==5){c=a+"_12"}else if(b==6){c=a+"_13"}else if(b==7){c=a+"_13"}else if(b==8){c=a+"_12"}else{c=a+"_10"}return c}function imgByDir_cha(a,b){if(b==0){imgHead="lu"}else if(b==1){imgHead="ru"}else if(b==2){imgHead="ru"}else if(b==3){imgHead="lu"}else if(b==5){imgHead="rd"}else if(b==6){imgHead="ld"}else if(b==7){imgHead="ld"}else if(b==8){imgHead="rd"}else{imgHead="ru"}return imgHead}function htmlPosStrToNumber(a){return parseInt(a.substring(0,a.length-2))}function getNameLable(a,b){var c;if($("#"+a)[0])c=$("#"+a)[0];else{var c=document.createElement("DIV");c.setAttribute("id",a);c.setAttribute("align","center");c.style.position="absolute";c.style.width="135px";c.style.zIndex=99;c.style.fontSize="20px";c.innerHTML=getNameLableStyle(b)}return c}function getNameLableStyle(a){return"<br><div align='center' style='background: white;width:70px;z-index:10;font-size:18px'><b>"+a+"</b></div>"}function getChatBubbleStyle(a){return"<p class='triangle-isosceles'>"+a+"</p>"}function update_la_content(a,b,c){var d=getNameLable(a,c);if(b==""){d.innerHTML=getNameLableStyle(c)}else{d.innerHTML=getChatBubbleStyle(b)+d.innerHTML;chatmsg="&nbsp<font color='blue'>"+a+":</font>"+b+"<br>"+chatmsg;$("lay").html(chatmsg)}}function removePlayerLable(a){var b=$("#"+a);b.remove()}function showPlayerLable(a){var b=$("#"+a);b.css("display","")}function hidePlayerLable(a){var b=$("#"+a);b.css("display","none")}function isBGImg(a){if(a==1||a==2){return true}return false}function isTerrainImg(a){if(a.indexOf("/10.png")!=-1&&hideBg==1)return true;return false}function getItemOffset(a){var b=a.toString().split("_");if(map_offset[a]){if(b.length>1){var c=b[0];var d=b[1];if(parseInt(d)==0)return map_offset[a];else return 0}else{return map_offset[a]}}else{return 0}}function point(a,b,c,d,e,f,g){var h=document.createElement("img");h.setAttribute("type","pointImg");h.src=f;h.id=g;h.style.position="absolute";h.style.left=a+"px";h.style.top=b+"px";h.style.width=c+"px";h.style.height=d+"px";h.style.zIndex=e;$("#lay0").append(h)}function createRect(a,b,c,d,e){clearRect();point(a,b,c-a,1,9999,"point.jpg","l1");point(c,b,1,d-b,9999,"point.jpg","l2");point(a,b,1,d-b,9999,"point.jpg","l3");point(a,d,c-a,1,9999,"point.jpg","l4")}function clearRect(){var a=$("IMG[type='pointImg']");for(var b=0;b<a.length;b++){var c=$("#"+a[b].id);c.remove()}}function setToOrder(a){a.sort(function(a,b){var c=loc2pos_absolute(a)[0];var d=loc2pos_absolute(b)[0];return c-d});return a}function setHashOrder(a){a.sort(function(a,b){var c=a.getPos();var d=b.getPos();return c-d});return a}function debugMsg(a){$("#debuginfo").val(a)}function uuidlet(){return((1+Math.random())*65536|0).toString(16).substring(1)}function getuuid(a){uuid_default_prefix=a;a=a||uuid_default_prefix||"";return a+uuidlet()+uuidlet()+"-"+uuidlet()+"-"+uuidlet()+"-"+uuidlet()+"-"+uuidlet()+uuidlet()+uuidlet()}function in_array(a,b){for(var c=0;c<b.length;c++){if(b[c]==a)return false}return true}function setProgress(val){eval('$( "#progressbar" ).progressbar({value:'+val+"})")}function isloaded(){if(version==2){$("#layLoading").remove()}else{var a=roomRes.loadedRec.getItem(main_img_id).loaded;var b=roomRes.mapResHash.getLength();if(b==itemNum&&a==spriteNum){$("#layLoading").remove();$("#lay0").css("display","");$("#startDiv").css("display","")}}}function getTransformProperty(a){var b=["transform","WebkitTransform","MozTransform","msTransform","OTransform"];var c;while(c=b.shift()){if(typeof a.style[c]!="undefined"){return c}}return false}function isActContent(a){if(a.startWith("&&"))return true;else if(unescape(a).startWith("&&"))return true;return false}function isClothContent(a){if(a.startWith(">>"))return true;else if(unescape(a).startWith(">>"))return true;return false}function getWidth(){xWidth=null;if(window.screen!=null)xWidth=window.screen.width;if(window.innerWidth!=null)xWidth=window.innerWidth;if(document.body!=null)xWidth=document.body.clientWidth;return xWidth}function getHeight(){xHeight=null;if(window.screen!=null)xHeight=window.screen.height;if(window.innerHeight!=null)xHeight=window.innerHeight;if(document.body!=null)xHeight=document.body.clientHeight;return xHeight}function getImageArr(a,b){var c=[];c[0]=a;var d=parseInt(a/target_arr_width);var e=parseInt(a%target_arr_width);var f=parseInt(b[0]/orgin_arr_width);var g=parseInt(b[0]%orgin_arr_width);for(var h=1;h<b.length;h++){var i=parseInt(b[h]/orgin_arr_width);var j=parseInt(b[h]%orgin_arr_width);var k=d+(i-f);var l=e+(j-g);if(l>=target_arr_width||l<0||k>=target_arr_width||k<0){c[c.length]=-1}else{c[c.length]=k*target_arr_width+l}}return c}function getLeftNode(a,b,c){var d=parseInt(a/target_arr_width);var e=parseInt(a%target_arr_width);var f=parseInt(b/orgin_arr_width);var g=parseInt(b%orgin_arr_width);var h=parseInt(c/orgin_arr_width);var i=parseInt(c%orgin_arr_width);var j=f-h;var k=g-i;var l=d-j;var m=e-k;var n;if(m>=target_arr_width||m<0||l>=target_arr_width||l<0){n=-1}else{n=l*target_arr_width+m}return n}function getItemBottomNode(a){var b=0;for(var c=0;c<a.length;c++){if(a[c]>b)b=a[c]}return b}function getItemLeftNode(a){return a[0]}function clearOriginMap(a,b){var c=b.split(",");var d=getLeftNode(a,getItemBottomNode(c),getItemLeftNode(c));if(d==-1){return false}var e=getImageArr(d,c);if(!checkImageArr(e)){return false}for(var f=0;f<e.length;f++){map_all_update[e[f]]=1}return true}function setTargetMap(a,b,c){var d=b.split(",");var e=c.split("||");var f=getLeftNode(a,getItemBottomNode(d),getItemLeftNode(d));if(f==-1){return false}var g=getImageArr(f,d);if(!checkImageArr(g)){return false}if(isAvailable(g)){for(var h=0;h<g.length;h++){map_all_update[g[h]]=e[h]}}else{return false}return true}function isAvailable(a){var b=true;for(var c=0;c<a.length;c++){if(!isBGImg(map_all_update[a[c]]))b=b&false}return b}function checkImageArr(a){for(var b=0;b<a.length;b++){if(a[b]==-1){return false}}return true}function CR_baseTiles(a,b,c,d){var e=getuuid();var f=document.createElement("IMG");f.pos=d;f.setAttribute("id",e);f.setAttribute("type","tile");var g=a.split("_");if(g.length==1)f.setAttribute("src","res/mapRes/up/"+a+"/"+a+".png");else f.setAttribute("src","res/mapRes/up/"+g[0]+"/"+g[0]+".png");f.setAttribute("imgCode",g[0]);f.style.position="absolute";if(g.length==1){b=b-getItemOffset(g)}else{b=b-img_offset[g[0]]}f.style.left=b;f.style.top=c+tile_height-f.height;f.style.zIndex=d;if(!isSafari){f.onmouseover=function(){f.style.opacity=.6};f.onmouseout=function(){f.style.opacity=1};f.ondrag=function(){return false};f.onmousedown=function(){sd.set(f,g[0]);var b=sd.ob;b.style.opacity=.6;temp_imgCode=a;if(commandCtl._getCmd()=="move")moveCtrl(imgMV,sd);else if(commandCtl._getCmd()=="del")delCtrl(imgMV,sd);else if(commandCtl._getCmd()=="col")colCtrl(imgMV,sd)}}else{f.ontouchstart=function(b){b.preventDefault();sd.set(f,g[0]);var c=sd.ob;c.style.opacity=.6;temp_imgCode=a;imgMV=c.id;if(commandCtl._getCmd()=="move"){moveCtrl(isDrag,sd)}else if(commandCtl._getCmd()=="del"){isDrag=0;delCtrl(imgMV,sd)}else if(commandCtl._getCmd()=="col")colCtrl(imgMV,sd)};f.ontouchend=function(a){if(isDrag==1){f.style.opacity=1;setMapAct();isDrag=0}}}return f}function move(a){var b=$("#map").css("backgroundPosition");var c=parseInt(b.split(" ")[0]);var d=parseInt(b.split(" ")[1]);var e,f;var g=120/2;var h=128/2;if(a==0){screen_height_offset-=g;d+=g;f=g}else if(a==1){screen_height_offset+=g;d-=g;f=-g}else if(a==2){half_bg_width+=h;c+=h;e=h}else if(a==3){half_bg_width-=h;c-=h;e=-h}ix=half_bg_width-tile_width/2;iy=0-screen_height_offset;target_pos=0;c=c+"px";d=d+"px";var i=c+" "+d;$("#map").css("backgroundPosition",i);updateMap(e,f)}function moves(a,b){var c=$("#map").css("backgroundPosition");var d=parseInt(c.split(" ")[0]);var e=parseInt(c.split(" ")[1]);target_pos=0;d+=a;m_offx+=a;e+=b;m_offy+=b;d=d+"px";e=e+"px";var f=d+" "+e;$("#map").css("backgroundPosition",f);updateMap(a,b)}function endMoveEventFunction(a){a.preventDefault();tx=0;ty=0;sx=0;sy=0;isScrMoving=0;dura=0;setTimeout(function(){isScrMoving=0},300)}function mapEditScreenMove(a,b){var c=(new Date).getTime()-dura;if(c<scr_scroll_speed)return false;dura=(new Date).getTime();var d,e,f;if(sx==0&&sy==0){sx=a;sy=b}else{d=parseInt((a-sx)/12);e=parseInt((b-sy)/12);var g=$("#map").css("backgroundPosition");var h=parseInt(g.split(" ")[0]);var i=parseInt(g.split(" ")[1]);moves(d,e)}}function moveEventFunction(a){var b=getCoords(a.touches[0]);if(b.y<100)return;a.preventDefault();if(a.touches){mapEditScreenMove(b.x,b.y)}return false}function moveMSEventFunction(a){var b,c,d;if(isMouseDown==1){isScrMoving=1;var e=window.event||a;mapEditScreenMove(e.clientX,e.clientY)}return false}function m_down(){isMouseDown=1}function endMSMoveEventFunction(a){tx=0;ty=0;sx=0;sy=0;isMouseDown=0;setTimeout(function(){isScrMoving=0},300)}function CR_consor(b,c,d,e,f){var g=document.createElement("IMG");g.id=f;g.pos=e;g.setAttribute("type","tile");g.setAttribute("src","res/mapRes/"+main_map_id+"_"+b+".png");g.style.position="absolute";g.style.left=c;g.style.top=d+tile_height-a.height;g.style.zIndex=9999;g.onclick=function(){alert(this.pos)};return g}function CR_item(a,b,c,d,e,f,g,h){var i=document.createElement("IMG");i.setAttribute("id",e);i.pos=d;i.off=f;i.setAttribute("type","tile");i.setAttribute("imgCode",a);i.setAttribute("src","res/mapRes/up/"+a+"/"+a+".png");i.style.position="absolute";i.style.left=b;i.style.top=c+tile_height-i.height;i.style.zIndex=d;i.style.display="none";if(!isSafari){i.onmouseover=function(){i.style.opacity=.6};i.onmouseout=function(){i.style.opacity=1};i.ondrag=function(){return false};i.onmousedown=function(){sd.set(i,a);var b=sd.ob;b.style.opacity=.6;temp_imgCode=a;if(commandCtl._getCmd()=="move")moveCtrl(imgMV,sd);else if(commandCtl._getCmd()=="del")delCtrl(imgMV,sd);else if(commandCtl._getCmd()=="col")colCtrl(imgMV,sd)}}else{i.ontouchstart=function(b){b.preventDefault();sd.set(i,a);var c=sd.ob;c.style.opacity=.6;temp_imgCode=a;imgMV=c.id;if(commandCtl._getCmd()=="move")moveCtrl(isDrag,sd);else if(commandCtl._getCmd()=="del"){isDrag=0;delCtrl(imgMV,sd)}else if(commandCtl._getCmd()=="col")colCtrl(imgMV,sd)};i.ontouchend=function(a){if(isDrag==1){i.style.opacity=1;setMapAct();isDrag=0}}}return i}function drawMap(a,b){var c,d;var e,f;var g=0;var h,i,j;mvArr=Array();for(var k=0;k<map_arr_width;k++){e=a-k*(tile_width/2);f=b+k*tile_height_offset;for(var l=0;l<map_arr_height;l++){h=map_all[k*map_arr_width+l].toString();i=h.split("|");for(var m=0;m<i.length;m++){c=e+l*(tile_width/2);d=f+l*tile_height_offset;j=i[m];if(!isBGImg(j)){if(isEndItem(j,k*map_arr_width+l)){var n=CR_baseTiles(j,c,d,k*map_arr_width+l);$(n).draggable();mvArr[g]=n;g++}}}}}}function drawMap_1(a,b){var c,d;var e,f;var g=0;mvArr=Array();for(var h=0;h<map_arr_width;h++){e=a-h*(tile_width/2);f=b+h*tile_height_offset;for(var i=0;i<map_arr_height;i++){c=e+i*(tile_width/2);d=f+i*tile_height_offset;if(!isBGImg(map_all[h*map_arr_width+i])&&isEndItem(map_all[h*map_arr_width+i],h*map_arr_width+i)){var j=CR_baseTiles(map_all[h*map_arr_width+i],c,d,h*map_arr_width+i);$(j).draggable();mvArr[g]=j;g++}}}}function updateMap(a,b){$("#lay0").children("img").each(function(){thisX=parseInt($(this).css("left"));thisY=parseInt($(this).css("top"));thisX=thisX+a+"px";thisY=thisY+b+"px";$(this).css("left",thisX);$(this).css("top",thisY)})}function isEndItem(a,b){var c=a.split("_");var d=false;if(c.length==1)d=true;else{var e=a.split("_");var f=map_enditem[e[0]].split(",");b=b.toString();if(jQuery.inArray(b,f)>-1)d=true}return d}function mapReload(){var a;for(var b=0;b<mvArr.length;b++){if(mvArr[b]&&!isTerrainImg(mvArr[b].src)){$("#lay0").append(mvArr[b])}}}var isMouseDown=0;var dura=0;var tx=0;var ty=0;var sx=0;var sy=0;var isScrMoving=0;var md_cnt=0;String.prototype.startWith=function(a){var b=new RegExp("^"+a);return b.test(this)};String.prototype.startWith=function(a){var b=new RegExp("^"+a);return b.test(this)};String.prototype.replaceAll=function(a,b){var c=new RegExp(a.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),"ig");return this.replace(c,b)};var ResLoad=function(){this.mapResHash=new Hash;this.spriteResHash=new Hash;this.loadedRec=new Hash;this.loadedMapImgCnt=0;this.loadedSpriteImgCnt=0};ResLoad.prototype={map_res_load:function(a,b){this.loadedMapImgCnt=0;var c,d,e;for(var f=0;f<a.length;f++){c=a[f].toString();d=c.split("|");for(var g=0;g<d.length;g++){e=d[g];if(!isBGImg(e)){var h=e;if(!this.mapResHash.hasItem(h)){var i=new Image;var j=h.split("_")[0];i.src="res/mapRes/up/"+j+"/"+h+".png";i.onload=this.load_map_count_up;this.mapResHash.setItem(h,i);if(b==1&&h.split("_")[1]&&h.split("_")[1]==0){i.src="res/mapRes/up/"+j+"/"+h.split("_")[0]+".png";i.onload=this.load_map_count_up;this.mapResHash.setItem(h.split("_")[0],i)}}}}}},sprite_res_load:function(a,b,c){this.loadedSpriteImgCnt=0;var d=new Object;d.total=b*c;d.loaded=0;this.loadedRec.setItem(a,d);for(var e=0;e<b;e++){for(var f=0;f<c;f++){var g=a+"_1"+e+"_"+f;var h=new Image;h.src="res/spriteRes/"+a+"/"+g+".png";h.onload=this.load_sprite_count_up(a);this.spriteResHash.setItem(g,h)}}},get_sprite_img:function(a){var b=a;return this.spriteResHash.getItem(b)},load_map_count_up:function(){},load_sprite_count_up:function(a){var b=roomRes.loadedRec.getItem(a);b.loaded=b.loaded+1;roomRes.loadedRec.setItem(a,b);isloaded()},isSpriteLoaded:function(a){var b=roomRes.loadedRec.getItem(a);if(b&&b.loaded==b.total)return true;return false},get_map_img:function(a){var b=a;return this.mapResHash.getItem(b)},set_sprite:function(a){},get_sprite:function(){}};var orgin_arr_width=8;var target_arr_width=map_arr_width;var m_offx=0;var m_offy=0;var mvArr=Array()