(function($) {

   $.fn.sfqTouchSlider = function(options){

              var options = $.extend({
    			item: 'div.item',
    			hideClass: 'mt-hidden',
    			activeClass: 'active',
    			t_width:600,
    			t_height:600,
    			t_left:10,
    			t_top:30
              }, options);

              var $this = $(this);
	      $this.css({
			     'overflow':'hidden' , 
			     'border': '5px solid #000' , 
			     'width': options.t_width + "px" , 
			     'height': options.t_height + "px" , 
			     'left': options.t_left + "px" , 
			     'top': options.t_top + "px" , 
			     'position':'absolute'
			   });

              var contentHeight = parseInt($this.children("lay").css("height"));
              if(contentHeight < 500)
                    return;

              var div = document.createElement("div");
	      div.id = "sfq-bar";
	      div.style.zIndex = 0;
	      div.style.left = (options.t_width - 10) + "px";      //must be this css width - 10
	      div.style.top = "0px";
	      div.style.width = "15px";
	      div.style.height = "0px";
	      div.style.backgroundColor = "#f00";
	      div.style.position = "absolute";

              var thisDom = document.getElementsByTagName("nav")[0];
	      thisDom.appendChild( div );

              $this.bind('touchstart.sfqTouchSlider', startMoveEventFunction);
              $this.bind('touchend.sfqTouchSlider', endMoveEventFunction);
              $this.bind('touchmove.sfqTouchSlider', moveEventFunction);
             
              var scr_scroll_speed = 100;
              var tx=0;
              var ty=0;
              var sx=0;
              var sy=0;
              var isScrMoving=0;
              var md_cnt=0;
              var isMouseDown=0;
              var dura=0;
  
              var vt_start=0;
              var vt_end=0;
              var pos_start =0;
              var pos_end =0;
              var cycle_cnt=0;
              var iid;
  
              var map_width = options.t_width;
              var map_height = options.t_height;
              var dura_off = 150;
 
              function ss()  {
                   alert(options);
              }

              function m_down() {
                  //alert("mdown");
                  isMouseDown=1;
              }

              function startMoveEventFunction(e) {
                  clearInterval(iid);
                  cycle_cnt=0;
                  var p = getCoords(getTouches(e,0)[0]);
                  vt_start = new Date().getTime();
                  pos_start = p.y;
              }

              function endMoveEventFunction(e) {
                  //var p = e.changedTouches ;
                  var p = getTouches(e,1);
                  vt_end = new Date().getTime();
                  pos_end = p[0].pageY;

                  var vt = (pos_end - pos_start) / (vt_end - vt_start);
                  vt = Math.round(vt*100)/100;
              
                  e.preventDefault();
                  tx=0;
                  ty=0;
                  sx=0;
                  sy=0;
                  dura=0;
                  isScrMoving=0;

                  iid = setInterval(function () { setCycle(vt); }, 80);
              }

              var offset;
              function setCycle(vt) {
                  var thisY = parseInt($this.children("lay").position().top);
                  var thisHeight = parseInt($this.children("lay").css("height"));

                  var s = 1;
                  var t;
                  if(vt>=0)
                     s=1;
                  else
                     s=-1;

                  vt = 10*Math.abs(vt);
                  cycle_cnt++;
                  t = cycle_cnt;
                  if(offset != -9999)
                      offset = vt*t-(2*t*t/2);

                  if(thisY>=dura_off || thisY <= (map_height-dura_off)-thisHeight)
                     offset=-9999;

                  if(offset>0)
                       move(s*offset);
                  else if(thisY>0){
                       move(-15);
                       offset=-9999;
                  }
                  else if(thisY<map_height-thisHeight){
                       move(15);
                       offset=-9999;
                  }
                  else {
                       clearInterval(iid);
                       cycle_cnt=0;
                       offset=0;
                  }
              }


              function mapEditScreenMove(mx,my)  {
                  var td = new Date().getTime()-dura;
                  if(td < scr_scroll_speed)
                     return false;

                  dura = new Date().getTime();
              
                  var ox,oy,tmp;
                  if(sy==0) {
                       sy = my;
                  } else {
                       vt_start = new Date().getTime();
                       pos_start = my;
                       oy=parseInt((my-sy)/2);

                       //compare horizon and vectical movement,if the horizon movement > vectical movement then only handle horizon.
                       var or = Math.abs(ox)-Math.abs(oy);

                       //notice: 64 is the width of the basic grid, 30 is the height of basic grid. shouldn't be changed.
                       var hv;

                       move(oy);
                    }
              }

              function move(oy) {
                  var thisY = parseInt($this.children("lay").position().top);
                  var thisHeight = parseInt($this.children("lay").css("height"));
              
                  thisY += oy;

                  if(thisY >= dura_off)
                      thisY = dura_off;
                  else if(thisY <= (map_height-dura_off)-thisHeight)
                      thisY = (map_height-dura_off)-thisHeight;

                  thisY += "px";
                  
                  //var aa = document.getElementById("lay");
                  //aa.style.top = thisY;

                  $this.children("lay").css("top",parseInt(thisY));
                  $this.children("lay").css("position","absolute");

                  setBarSize(parseInt(thisY));
              }


              function moveEventFunction(e) {
                  var p = getCoords(getTouches(e,0)[0]);

                  isScrMoving=1;

                  if (e.originalEvent.touches) {
                          mapEditScreenMove(p.x , p.y);
                  }
                  return false;
              }
              
              function moveMSEventFunction(e) {
                  var ox,oy,tmp;
                  md_cnt++;

                  if (isMouseDown==1) {
                          md_cnt=0;
                          isScrMoving=1;
                          var evt = window.event || e;

                          md_cnt=0;
                          mapEditScreenMove(evt.clientX , evt.clientY);
                  }
                  return false;
              }

              function endMSMoveEventFunction(e) {
                  tx=0;
                  ty=0;
                  sx=0;
                  sy=0;
                  isMouseDown=0;
                  setTimeout(function() { isScrMoving=0; },300);
              }

              // Get the coordinates for a mouse or touch event
              function getCoords(e) {
                  if (e.offsetX) {
                      // Works in Chrome / Safari (except on iPad/iPhone)
                      return { x: e.offsetX, y: e.offsetY };
                  }
                  else if (e.layerX) {
                      // Works in Firefox
                      return { x: e.layerX, y: e.layerY };
                  }
                  else {
                      // Works in Safari on iPad/iPhone
                      //alert((e.pageX-cb_canvas.offsetLeft) +":"+ (e.pageY-cb_canvas.offsetTop));
                      return {x:e.pageX,y:e.pageY};
                  }
              }

              function ajustOrientation() {
                   window.setTimeout(function() { window.top.scrollTo(0,1);} , 100);
              }

              function info() {
                  alert(parseInt($this.children("lay").css("height")));
              }

              function setBarSize(offy) {
                  var oy_off=0;
                  var thisHeight = parseInt($this.children("lay").css("height"));
                  barLen = parseInt(map_height*map_height/thisHeight);

                  var baseHeight = map_height - thisHeight;
                  var thisLen;

                  var ispos=0;
                  if(offy > 0)  {
                      ispos=-1;
                      oy_off = offy;
                  }
                  else if(offy < baseHeight) {
                      ispos=1;
                      oy_off = baseHeight - offy;
                  }

                  if(oy_off !=0)   {
                       oy_off = Math.abs(oy_off);
                       oy_off = parseInt(map_height*oy_off/thisHeight);
                  }

                  thisLen = barLen - oy_off;

                  var mp;
                  if(ispos==-1)  {
                       mp=0;
                  }  
                  else if(ispos==1) {
                       mp = map_height-thisLen;
                  }
                  else if(ispos==0) {
                      var l1 = Math.abs(parseInt($this.children("lay").position().top));
                      var mp = parseInt(map_height*l1/thisHeight);
                  }

$("#info").val(map_height +":"+ thisLen);

                  mp = mp + "px";
                  thisLen += "px";

                  var thisDom1 = document.getElementById("sfq-bar");
                  thisDom1.style.top = mp;
                  thisDom1.style.height = thisLen;
              }

              // Get the touch points from this event
              function getTouches(e,act) {
                  if (e.originalEvent) {
                        if (act==0 && e.originalEvent.touches && e.originalEvent.touches.length) {
                                 return e.originalEvent.touches;
                        } else if (e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
                                 return e.originalEvent.changedTouches;
                        }
                  }
                  return e.touches;
              }
   } 

})(jQuery);