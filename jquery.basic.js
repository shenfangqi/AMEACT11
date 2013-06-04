(function($){
    /* プラグイン名（myplugin）を指定 */
    /* 関数にオプション変数を渡す */
    $.fn.myplugin=function(config){
        /* 引数の初期値を設定（カンマ区切り） */
        var defaults={
            defColor:"#ff6699",
            defPadding:5
        }
        
        $("#tab").remove();
        
        $('<table id="tab"border="0"/>').appendTo('lay');
        
        //var my_tab = $("#tab");
        var my_tab = document.getElementById("tab");
        var contents="";
        var cnt=0;

        var options=$.extend(defaults, config);
        
        //alert(options.row);
        
        /* 一致した要素上で繰り返す */
        return this.each(function(i){
             cnt++;
            //$(this).text(this.tagName+"["+i+"]").css({"color":defaults.defColor,"padding":defaults.defPadding});
            //alert( $(this).attr("pic") +":"+ $(this).attr("code"));
            var imgstr = $(this).attr("pic");
            if(imgstr =="")
                 imgstr = "&nbsp;";
            else 
                 imgstr = "<img src='"+imgstr+"' width='60px' onload='vertAlign(this)'>";

            var codestr = $(this).attr("code");
            if(codestr =="")
                 codestr = "";
            else 
                 codestr = 'onclick=setHuman("'+codestr+'")';

            var am = cnt % options.row;
            if(am == 1)  {
                //$('<tr><td>'+$(this).text()+'</td></tr>').appendTo(my_tab);
                contents += '<tr><td><div class="box"'+codestr+'>'+imgstr+'</div></td>'; 
            } else if(am == 0) {
                contents += '<td><div class="box"'+codestr+'>'+imgstr+'</div></td></tr>'; 
            } else {
                contents += '<td><div class="box"'+codestr+'>'+imgstr+'</div></td>'; 
            }
            my_tab.innerHTML = contents;
        });
    };
})(jQuery);