function findInArr(a,b){for(var c=0;c<a.length;c++){if(a[c]==b)return c}return-1}function formPath(a){return a.substring(1)}function getinistr_main(){return inistr_main}function addItem(a){var b=a.split("||");var c,d;var e,f,g;if(isItemInIni(a,inistr_main)){inistr_main=removeItem(a);return inistr_main}for(var h=0;h<b.length;h++){d=b[h].split(":");e=d[0];f=d[1];g=d[2]+":"+d[3]+":"+d[4]+":"+d[5];inistr_main=setItem(e,f,g)}return inistr_main}function removeItem(a){var b=a.split("||");var c,d;var e,f,g;for(var h=0;h<b.length;h++){d=b[h].split(":");e=d[0];f=d[1];inistr_main=unsetItem(e,f)}return inistr_main}function setItem(a,b,c){var d=inistr_main.split("||");var e="";for(var f=0;f<d.length;f++){if(d[f].startWith(a)){d[f]+="_"+b+":"+c}e+="||"+d[f]}return e.substring(2)}function unsetItem(a,b){var c=inistr_main.split("||");var d;var e="";var f;var g="";for(var h=0;h<c.length;h++){if(c[h].startWith(a)){d=c[h].split("_");f=d[0];for(var i=1;i<d.length;i++){if(d[i].startWith(b)){}else{g+=d[i]+"_"}}g=g.substring(0,g.length-1);if(g){c[h]=f+"_"+g}else c[h]=f}e+="||"+c[h]}return e.substring(2)}function getAttachmentList(a){var b=a.split("||");var c,d;var e=[];for(var f=0;f<b.length;f++){c=b[f].split("_");for(var g=1;g<c.length;g++){d=c[g].split(":");d=d[0].substring(1);if(findInArr(e,d)==-1)e[e.length]=d}}return e}function getItemAttachement(a){var b=a.split("||");var c=b[0].split(":");return c[1].substring(1)}function isItemInIni(a,b){var c=getItemAttachement(a);var d=getAttachmentList(b);if(findInArr(d,c)==-1)return false;else return true}