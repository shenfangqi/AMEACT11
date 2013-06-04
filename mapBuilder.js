var orgin_arr_width=8;   //物品编辑的地图是8*8
var target_arr_width=map_arr_width;   //实际场景地图的宽度

function getImageArr(firstNode,item_mark_arr_ordered)  {
    var ret=[];
    ret[0]=firstNode;

    var target_item_pos_row_off = parseInt(firstNode / target_arr_width);
    var target_item_pos_col_off = parseInt(firstNode % target_arr_width);

    //alert(target_item_pos_row_off +":"+ target_item_pos_col_off);

    var first_item_pos_row_off = parseInt((item_mark_arr_ordered[0] / orgin_arr_width));
    var first_item_pos_col_off = parseInt((item_mark_arr_ordered[0] % orgin_arr_width));

    for(var i=1;i<item_mark_arr_ordered.length;i++)  {
          var row_off = parseInt(item_mark_arr_ordered[i] / orgin_arr_width);
          var col_off = parseInt(item_mark_arr_ordered[i] % orgin_arr_width);

          var t_row_off = target_item_pos_row_off + (row_off - first_item_pos_row_off);
          var t_col_off = target_item_pos_col_off + (col_off - first_item_pos_col_off);

          //alert(t_row_off +":"+ t_col_off );

          if(t_col_off >=target_arr_width || t_col_off < 0 || t_row_off >=target_arr_width || t_row_off < 0 )  {
              //array_push($ret,-1);
               ret[ret.length]=-1;
          } else {
              //array_push($ret,$t_row_off * $target_arr_width + $t_col_off);
              ret[ret.length]=t_row_off * target_arr_width + t_col_off;
          }
    }

    return ret;
}


function getLeftNode(vl,t1,t2)  {    //vl:origin input,the bottom node, t1:map bottom node,t2: map left node
   var vl_row_off = parseInt(vl / target_arr_width);
   var vl_col_off = parseInt(vl % target_arr_width);

   var t1_row_off = parseInt(t1 / orgin_arr_width);
   var t1_col_off = parseInt(t1 % orgin_arr_width);

   var t2_row_off = parseInt(t2 / orgin_arr_width);
   var t2_col_off = parseInt(t2 % orgin_arr_width);

   var ro = t1_row_off - t2_row_off;
   var co = t1_col_off - t2_col_off;

   var ret_row_off = vl_row_off - ro;
   var ret_col_off = vl_col_off - co;

   var ret;
   if(ret_col_off >=target_arr_width || ret_col_off < 0 || ret_row_off >=target_arr_width || ret_row_off < 0 )  {
       //alert(-1+":"+ret_row_off+":"+ret_col_off)
       ret=-1;
   }  else  {
       //alert(ret_row_off*target_arr_width+ret_col_off);
       ret=ret_row_off*target_arr_width+ret_col_off;
   }
   return ret;
}

function getItemBottomNode(arr) {    //the biggest node
    var ret=0;
    for(var i=0;i<arr.length;i++)  {
       if(arr[i]>ret) ret=arr[i];
    }
    return ret;
}

function getItemLeftNode(arr) {    //the first node
    return arr[0];
}


function clearOriginMap(bPos,item_mark_arr_ordered_str) {
    var item_mark_arr_ordered = item_mark_arr_ordered_str.split(",");
    var leftNode = getLeftNode(bPos,getItemBottomNode(item_mark_arr_ordered),getItemLeftNode(item_mark_arr_ordered));

    if(leftNode==-1)  {
        //alert(bPos+"--llleftNode is not correct,the left node is -1.");
        return false;
    }
    var imageArr = getImageArr(leftNode,item_mark_arr_ordered);

    if(!checkImageArr(imageArr)) {
        //alert("cannot clear location here. the now location contains -1.");
        return false;
    }
    for(var i=0;i<imageArr.length;i++)  {
        map_all_update[imageArr[i]] = 1;
    }
    
    return true;
}

//验证传入的位置信息，如合法就保存到目标地图数组
function setTargetMap(bPos,item_mark_arr_ordered_str,item_mark_arr_ordered_subitems_str) {
    var item_mark_arr_ordered = item_mark_arr_ordered_str.split(",");

    var item_mark_arr_ordered_subitems = item_mark_arr_ordered_subitems_str.split("||");

    var leftNode = getLeftNode(bPos,getItemBottomNode(item_mark_arr_ordered),getItemLeftNode(item_mark_arr_ordered));
    
    if(leftNode==-1)  {
        //alert(bPos+"--leftNode is not correct,the left node is -1.");
        return false;
    }
    var imageArr = getImageArr(leftNode,item_mark_arr_ordered);
    if(!checkImageArr(imageArr)) {
        //alert("cannot locate here. the now location contains -1.");
        return false;
    }

    if(isAvailable(imageArr)) {
        for(var i=0;i<imageArr.length;i++)  {
            map_all_update[imageArr[i]] = item_mark_arr_ordered_subitems[i];
        }
    } else {
       //alert("Occupied.");
       return false;
    }
     
    return true;
}


function isAvailable(imageArr)  {
    var ret=true;
    for(var i=0;i<imageArr.length;i++)  {
        if(!isBGImg(map_all_update[imageArr[i]]))
            ret=ret&false;
    }
    return ret;
}


function checkImageArr(arr) {
    for(var i=0;i<arr.length;i++) {
       if(arr[i]==-1) {
          return false;
       }
    }
    return true;
}


