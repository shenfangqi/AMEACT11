<?
/**

 * ファイルに関するファイル
 * 情報一覧
 * @package    index
 * @author     yang
 * @copyright  WEIC 株式会社
 * @version    1.0
 * @access     public

 */
 /**
 *  データベース接続の情報を読み込む
 */
require( "./config.inc.php" );
/**
 *  登録ユーザーの情報をSESSIONに設定
 */

require( "./login_var.php" );

//Redirect
if ($ok == false) {

	Header("Location: ./error.php");
}
else
{ ?>
	<html>
	<meta http-equiv="Content-Type" content="text/html" charset=utf-8>
	<head><title>Management--<?php echo $projectname[$_SESSION["g_dbidx"]]?></title>
	<STYLE TYPE='text/css'>
	<!-- TextRollover-1 -->
	a:link { color:#FFFFFF; text-decoration:none}
	a:visited { color:#FFFFFF; text-decoration:none}
	a:hover { color:#FF9900; text-decoration:none; cursor:hand}
	a:active { color:#FFFFFF; text-decoration:none}
	</STYLE>
	<SCRIPT LANGUAGE="javascript">
		<!--
	function logout()
	{
  		if (confirm('ログアウトしてもよろしいでしょうか？'))
    		top.location.href = "./index.php?logout=1";
	}
		//-->

	</SCRIPT>
	</head>
	<body bgcolor="#000033" topmargin=7 leftmargin=0>
	<!--Title-->
	<center>
	<table width=50% cellspacing="0" cellpadding="5">
	  <tr>
	     <td valign="top" align="center">
		<img src="images/banner-statics.jpg" width="460" height="184">

		</td>
	  </tr>
	  <tr>
	  	<td>
	  	<p align="right">
	  	<input name="button" type=button style='color: #111111; font-family: Verdana; font-size: 7pt; font-weight: bold; border-style: groove; border-width: 3; background-color: #BBBBBB' onClick="logout();" value='&nbsp;ログアウト' size=6>
	  	</td>
	  </tr>
	</table>

	<hr width=85%>
	<table width='85%' align='center'>

	<tr>
	<td width=40% align='left' valign='top'>
		<small><font color='#FF9900'>アカウント</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small></small>
	</td>
	</tr>
	<tr>
	<td width=30% align='left' valign='top'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--ユーザ・アカウント版</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small>

			<? if ($_SESSION["g_pri"] == 0)  { ?>
				<a href="account/index.php">
	    			編集画面
	    			</a>
	    		<? } elseif ($_SESSION["g_pri"] == 1) {?>
					<a href="account/index.php">
	    			編集画面 -- (所属されたグループのみ)
					</a>
	    		<? } else {?>
	    			編集画面
	    		<? } ?>

	    </small>
	</td>
	</tr>

	<tr>
	<td width=30% align='left' valign='top'>
		<small><font color='#FF9900'>統計:</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small></small>
	</td>
	</tr>
	<tr>
	<td width=30% align='left' valign='top'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--アクセス数</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small>
        <? if ($_SESSION["g_pri"] ==0)  { ?>
        <a href="history/allaccess/index.php">
	    		グループのアクセス数
	    	</a>
			<? } else { ?>
            <font color='#999999'>
            	グループのアクセス数
				</font>

           <? }?> </small>
	</td>
	</tr>
	<tr>
	<td width=30% align='left' valign='top'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--進捗に関する統計</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small>
			<? if ($_SESSION["g_pri"] !=3)  { ?>
				<a href="history/progress/index.php">
	    		学生の学習進捗状況
	    		</a>
			<? } else { ?>
				<font color='#999999'>
	    		学生の学習進捗状況
				</font>
			<? }?></small>
	</td>
	</tr>
<!--	<tr>
	    <td width="30%">
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--学生に関する統計</font></small>
	    </td>
		<td width=100% align='left' valign='top'>
		<small>
			<? if ($_SESSION["g_pri"] !=3)  { ?>
				<a href="history/userlog/index.php">
	    		グループの学習履??- (ユーザー??
	    		</a>
			<? } else { ?>
				<font color='#999999'>
	    		グループの学習履??- (ユーザー??
				</font>
			<? }?></small>
	</td>
	</tr>
	<tr>
	<td width=30% align='left' valign='top'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--成績管理</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small>
			<? if ($_SESSION["g_pri"] !=3)  { ?>
				<a href="history/markonly/index.php">
	    		グループの成績統??- (ユーザー??
	    		</a>
			<? } else { ?>
				<font color='#999999'>
				グループの成績統??- (ユーザー??
				</font>
			<? }?></small>
	</td>
	</tr>-->






	<tr>
	<td width=30% align='left' valign='top'>
		<small><font color='#FF9900'>その他</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small></small>
	</td>
	</tr>
	<tr>
	<td width=30% align='left' valign='top'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--知らせの編集</small>
	</td>
	<td width=100% align='left' valign='top'>
		<small>
			<? if ($_SESSION["g_pri"] == 0)  { ?>
				<a href="editnews/index.php">
	    		知らせ情報の管理
	    		</a>
			<? } else { ?>
				<font color='#999999'>
				知らせ情報の管理
				</font>
			<? }?></small>
	</td>
	</tr>
	<tr>
	    <td width="30%">
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--教材の編集</font>
	    </td>
	    <td><small>
			<? if ($_SESSION["g_pri"] == 0)  { ?>
				<a href="editlecture/index.php">
					メタデータ情報の編集
				</a>
			<? } else { ?>
				<font color='#999999'>
				メタデータ情報の編集
				</font>
			<? }?>

	    </small></td>
	</tr>
	<tr>
	    <td width="30%">
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--教材の分類</font>
	    </td>
	    <td><small>
				<? if ($_SESSION["g_pri"] == 0)  { ?>
					<a href="assignlecturegrp/index.php">
						グループごとの指定
					</a>
	    		<? } elseif ($_SESSION["g_pri"] == 1) {?>
					<a href="assignlecturegrp/index.php">
	    			グループごとの指定-- (所属されたグループのみ)
					</a>
	    		<? } else {?>
					<font color='#999999'>
	    			グループごとの指定
					</font>
	    		<? } ?>


	    </small></td>
	</tr>

	<tr>
	    <td width="30%">
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--データベースの編集</font>
	    </td>
	    <td><small>
			<? if ($_SESSION["g_pri"] == 0)  { ?>
				<a href="DbEditor/index.php">
	    		データベースの編集
	    	</a>
			<? } else { ?>
				<font color='#999999'>
				データベースの編集
				</font>
			<? }?>

	    </small></td>
	</tr>

<!--	<tr>
	    <td width="30%">
	    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><font color='#999999'>--ファイル・マネジャー</font>
	    </td>
	    <td><small>
	    	<a href="fileman/index.php">
	    		ファイル・マネジャー
	    	</a>
	    </small></td>
	</tr>
-->
	</table>
	</center>
	</body>
	</html>
<?
}
?>
