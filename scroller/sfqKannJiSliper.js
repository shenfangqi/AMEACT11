(function($) {

   $.fn.sfqKannJiSliper = function(options){

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


             alert($this.html());
/*
              var contentHeight = parseInt($this.children("lay").css("height"));
              if(contentHeight < 500)
                    return;

              var div = document.createElement("div");
	      div.id = "sfq-bar";
	      div.style.zIndex = 0;

              var thisDom = document.getElementsByTagName("nav")[0];
	      thisDom.appendChild( div );

              var scr_scroll_speed = 100;
 
              function ss()  {
                   alert(options);
              }
*/
}              