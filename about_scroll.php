<?php
header("content-type:text/html; charset=utf-8");
require_once("config.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="MYO,engine,html5,avatar,chat,isometric,2.5D,iphone,ios,android,web,websocket,graphic,エンジン,アバター,チャット">
<meta name="description" content="MYO engine is a developing tool for anyone who want to create a Avatar chat system in no time.  MYO engine（MYO エンジン）は、誰でも簡単にアバターチャットシステムを作成できる開発エンジンです。" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>MYO Space</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="./iscroll/iscroll.js"></script>

<script type="text/javascript">
var myScroll;
var hm;
function loaded() {
	myScroll = new iScroll('wrapper');
	ajustOrientation();
    $("#but1").click(function() {
      setAbout1();
    })

    $("#but2").click(function() {
      setAbout2();
    })

    $("#but3").click(function() {
      window.open("./","_top");
    })

}

function ajustOrientation() {
   window.setTimeout(function() {window.top.scrollTo(0,1);} , 100);

   var orientation = window.orientation;
   if(orientation == 0)  {
        $("#wrapper").css("height","388px");
   }  else {
        $("#wrapper").css("height","238px");
   }

   if(orientation == null)  {
        $("#wrapper").css("height","488px");
   }

}


function vertAlign(pImg) {
   var lHeight = pImg.clientHeight;
   var lParentHeight = pImg.parentNode.clientHeight;
   pImg.style.marginTop = (lParentHeight - lHeight)/2 + "px";
}

function setHuman(val) {
   inistr = addItem(val);
   //alert(hm.orient);
   hm = new human(hm.orient,inistr);
}

function setAbout1() {
   myScroll.destroy();
   var contents = $("#about1").html();
   $("#thelist").html(contents);
   myScroll = new iScroll('wrapper');
}

function setAbout2() {
   myScroll.destroy();
   var contents = $("#about2").html();
   $("#thelist").html(contents);
   myScroll = new iScroll('wrapper');
}

function setCloth() {
   myScroll.destroy();
   var contents = $("#about2").html();
   $("#thelist").html(contents);
   myScroll = new iScroll('wrapper');
   $("#but1").text("保存");
}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

/* * * * * * * *
 *
 * Use this for high compatibility (iDevice + Android)
 *
 */
document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
/*
 * * * * * * * */


/* * * * * * * *
 *
 * Use this for iDevice only
 *
 */
//document.addEventListener('DOMContentLoaded', loaded, false);
/*
 * * * * * * * */


/* * * * * * * *
 *
 * Use this if nothing else works
 *
 */
//window.addEventListener('load', setTimeout(function () { loaded(); }, 200), false);
/*
 * * * * * * * */

</script>

<style type="text/css" media="all">
body,ul,li {
	padding:0;
	margin:0;
	border:0;
}

body {
	font-size:12px;
	-webkit-user-select:none;
    -webkit-text-size-adjust:none;
	font-family:helvetica;
}

#header {
	position:absolute; z-index:2;
	top:0; left:0;
	width:100%;
	height:20px;
	line-height:20px;
	background-color:#d51875;
	background-image:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0, #fe96c9), color-stop(0.05, #d51875), color-stop(1, #7b0a2e));
	background-image:-moz-linear-gradient(top, #fe96c9, #d51875 5%, #7b0a2e);
	background-image:-o-linear-gradient(top, #fe96c9, #d51875 5%, #7b0a2e);
	padding:0;
	color:#eee;
	font-size:12px;
	text-align:center;
}

#header a {
	color:#f3f3f3;
	text-decoration:none;
	font-weight:bold;
	text-shadow:0 -1px 0 rgba(0,0,0,0.5);
}

#footer {
	position:absolute; z-index:2;
	bottom:0; left:0;
	width:100%;
    top:388px;
	height:30px;
	background-color:#fff;
	background-image:-webkit-gradient(linear, 0 0, 0 100%, color-stop(0, #999), color-stop(0.02, #666), color-stop(1, #222));
	background-image:-moz-linear-gradient(top, #999, #666 2%, #222);
	background-image:-o-linear-gradient(top, #999, #666 2%, #222);
	padding:0;
	border-top:1px solid #444;
}

#footer li {
	display:block;
	float:left;
}

#footer li {
	width:25%;
	text-align:center;
}

#footer a {
	display:block;
	text-decoration:none;
	font-size:12px;
	color:#eee;
	line-height:24px;
	text-shadow:0 -1px 0 #000;
}

#footer span {
	display:block;
	font-size:30px;
	font-weight:bold;
}

#wrapper {
	position:relative; z-index:1;
	top:0px; bottom:30px; left:0;
	width:100%;
	height:388px;
	background:#aaa;
	overflow:auto;
}


#myFrame {
	position:absolute;
	top:0; left:0;
}

.css3comm {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #080008;
	width:100px;
	padding: 6px 6px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#ffffff);
	background: -webkit-gradient(
		linear, left top, left bottom,
		from(#ffffff),
		to(#ffffff));
	border-radius: 12px;
	-moz-border-radius: 12px;
	-webkit-border-radius: 12px;
	border: 1px solid #7e8082;
}

.box {
    	 width: 46px;
	     height: 46px;
	     border: "2px solid #000";
	     line-height: 46px;
	     text-align: center;
	     margin: 1px;
	     display: block;
	     text-decoration: none;
	     overflow: hidden;
	     position: relative;
         BACKGROUND-COLOR:#FFF;

         -moz-border-radius: 15px;   /* firefox */
         border-radius: 15px;        /* CSS3 */
}

hr.style-six {
    border: 0;
    height: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}

</style>
</head>

<body   onorientationchange="ajustOrientation();">

<div id="header"><table width="100%"><tr><td width=50% align="center"><b>MYO Space</b></td></tr></table></div>


<div id = "about2" style="display:none">
    <table style="background-color:#f0f0f0;font-size:14px" border=0 width="100%">
         <tr>
              <td>
                  <p>WEB エンジニアの諶方琦（セン　ホウキ）と申します。今東京在住の中国人技術者です。１０年間以上WEB開発に携わっており、anshex.comという会社 で３ｄ空間のセカンドライフ向けの開発をしたことがあります。最近HTML５を使ったモバイルアプリの開発に夢中です。</p>
                  <p>MYO エンジンは最近の１年で個人で開発したものです。技術者であり、UIのデザインにまったくできなく、AMEBAピグの素材を勝手に使わせてこのデモ用のシ ステムを構築しました。できたシステムはAMEBAピグのパクリにも見えてピグに大変申し訳ないです。新しいUI素材があれば、１週間以内で新しいアバ ターシステムが作り上げられると思います。興味ある方はぜひ遠慮なく私にメールください。</p>
                  <p>Email:<a href="mailto:nevin.ug206@gmail.com?subject=about MYO">nevin.ug206@gmail.com</a></p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
              </td>
         </tr>
    </table>
</div>


<div id = "about1" style="display:none">
               <table style="background-color:#f0f0f0;	font-size:14px" border=0 width="100%">
	              <tr>
	                <td>
	                   <p>最近開発業界で話題になっているHTML５ですは、ソーシャルシステムの開発に一番ふさわしい技術と言われています。しかし、実際の開発運用ではクロスブラザー、タッチ処理など難点がたくさん存在します。MYOエンジンはこれらの難点を解決するために生まれたものです。</p>

                       <p>MYOエンジンはアバターチャットシステムの開発専用のHTML５ゲームエンジンです。アバターパーツの組み合わせ、地図作成、リアルタイム通信、アクション編集などいろいろな機能を提供するクロスブラザーのエンジンです。</p>

                       <p>MYO エンジンを使えば、ほとんどコーディングしなくでも、AMEBAピグのような２.５Dアバターシステムが作れます。MYOエンジンはHTML５対応してい るので、これで作ったシステムはWEBブラウザー、IOS、Androidのどれでも問題なく動作します。OS毎の開発が不要になり、コストを大幅に削減 することができます。</p>
                       <p>&nbsp;</p>
                       <p>&nbsp;</p>
                       <p>&nbsp;</p>
	                </td>
	             </tr>
	           </table>
</div>

<table width="100%" border="0" style="position:absolute;left:0px;top:20px">
<tr>
   <td width="100px" valign="top">
      <table border="0" width="100%">
          <tr>
              <td align="center">
                 <button type="button" id="but1" class="css3comm">MYOエンジン</button>
              </td>
          </tr>
          <tr>
              <td align="center">
                 <button type="button" id="but2" class="css3comm">開発者</button>
              </td>
          </tr>
          <tr>
              <td align="center">
                 <button type="button" id="but3" class="css3comm">戻る</button>
              </td>
          </tr>

      </table>
   </td>

   <td>
   <div id="wrapper">
   	   <div id="scroller">
	 	   <ul id="thelist">
               <table style="background-color:#f0f0f0;	font-size:14px" border=0 width="100%">
	              <tr>
	                <td>
	                   <p>最近開発業界で話題になっているHTML５ですは、ソーシャルシステムの開発に一番ふさわしい技術と言われています。しかし、実際の開発運用ではクロスブラザー、タッチ処理など難点がたくさん存在します。MYOエンジンはこれらの難点を解決するために生まれたものです。</p>

                       <p>MYOエンジンはアバターチャットシステムの開発専用のHTML５ゲームエンジンです。アバターパーツの組み合わせ、地図作成、リアルタイム通信、アクション編集などいろいろな機能を提供するクロスブラザーのエンジンです。</p>

                       <p>MYO エンジンを使えば、ほとんどコーディングしなくでも、AMEBAピグのような２.５Dアバターシステムが作れます。MYOエンジンはHTML５対応してい るので、これで作ったシステムはWEBブラウザー、IOS、Androidのどれでも問題なく動作します。OS毎の開発が不要になり、コストを大幅に削減 することができます。</p>
                       <p>&nbsp;</p>
                       <p>&nbsp;</p>
                       <p>&nbsp;</p>
	                </td>
	             </tr>
	           </table>
		   </ul>
	   </div>
   </div>
   </td>

</tr>
</table>

</body>


</html>