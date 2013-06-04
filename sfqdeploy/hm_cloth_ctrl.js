function findInArr(thisarr,value)
{
    for(var i=0; i<thisarr.length; i++)
    {
       if(thisarr[i] == value)
       return i;
    }
    return -1;
}

function formPath(str)   {
     return str.substring(1);
}

function getinistr_main()  {
     return inistr_main;
}

function addItem(itemStr)  {
     var t1 = itemStr.split("||");
     var ret,t2;
     var bodyID,itemID,offsetStr;


     if(isItemInIni(itemStr,inistr_main))  {
            inistr_main = removeItem(itemStr);
            return inistr_main;
     }
     
     for(var i=0;i<t1.length;i++) {
        t2 = t1[i].split(":");
        bodyID = t2[0];
        itemID = t2[1];
        offsetStr = t2[2] +":"+ t2[3] +":"+ t2[4] +":"+ t2[5];

        //alert(i+"-"+bodyID+"-"+itemID+"-"+offsetStr);
        inistr_main = setItem(bodyID,itemID,offsetStr);
     }

     return inistr_main;
}

function removeItem(itemStr) {
     var t1 = itemStr.split("||");
     var ret,t2;
     var bodyID,itemID,offsetStr;

     for(var i=0;i<t1.length;i++) {
          t2 = t1[i].split(":");
          bodyID = t2[0];
          itemID = t2[1];

          inistr_main = unsetItem(bodyID,itemID);
     }

     return inistr_main;
}

function setItem(bodyID,itemID,offsetStr)  {
     var t1 = inistr_main.split("||");
     var ret="";

     for(var i=0;i<t1.length;i++)  {
          if(t1[i].startWith(bodyID)) {
               t1[i] += "_"+itemID+":"+offsetStr;
          }
          ret += "||" +t1[i];
     }

     return ret.substring(2);
}

function unsetItem(bodyID,itemID)  {
     var t1 = inistr_main.split("||");

     var t2;
     var ret="";
     var bid;
     var secStr ="";
     
//alert(bodyID +"***"+ itemID);

     for(var i=0;i<t1.length;i++)  {
          if(t1[i].startWith(bodyID)) {
               t2 = t1[i].split("_");
               bid = t2[0];
               for(var j=1;j<t2.length;j++)   {
//alert(t2[j]+ "+" + itemID);
                         if(t2[j].startWith(itemID)) {

                         } else {
                                secStr += t2[j] + "_";
                         }
               }
               secStr = secStr.substring(0,secStr.length-1);
               if(secStr)  {
                    t1[i] = bid +"_"+ secStr;
               } else
                    t1[i] = bid;
          }
          ret += "||" +t1[i];
     }

     return ret.substring(2);
}

function getAttachmentList(inistr_main)   {
     var t1 = inistr_main.split("||");
     var t2,t3;
     var list = [];

     for(var i=0;i<t1.length;i++)  {
            t2 = t1[i].split("_");
            for(var j=1;j<t2.length;j++)   {
                 t3 = t2[j].split(":");
                 t3 = t3[0].substring(1);
                 if(findInArr(list,t3)==-1)
                      list[list.length] = t3;
            }
     }

     return list;
}

//var itemStr = "body:A101:0:3:-1:1||lArm:B101:0:0:0:0||rArm:C101:0:1:0:1";
function getItemAttachement(itemStr)  {
     var t1 = itemStr.split("||");
     var t2 = t1[0].split(":");
     return t2[1].substring(1);
}

function isItemInIni(itemstr,inistr_main_str) {
     var t1 = getItemAttachement(itemstr);
     var t2 = getAttachmentList(inistr_main_str);

     if(findInArr(t2,t1)==-1)
         return false;
     else
         return true;
}