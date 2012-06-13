<?php
session_start();
include_once( 'config.php' );
include_once( 'weibosdk/saetv2.ex.class.php' );
include_once( 'utils.php' );

$myAccessToken = $_SESSION["Sina_Weibo"]["access_token"];
$myAccessKey = $_SESSION["Sina_Weibo"]["access_key"];
$mySecretKey = $_SESSION["Sina_Weibo"]["secret_key"];

if(!$myAccessToken)
{
	exit();
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src=" http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=<?= $_SESSION["Sina_Weibo"]["access_key"] ?>" type="text/javascript" charset="utf-8"></script>
	</head>
	
	<body>

<table width="90%" align="center">
	<tr>
		<td width="33%">
			<div id="wb_follow_btn_diablo"></div>
			<script>
				WB2.anyWhere(function(W)
				{
					W.widget.followButton(
					{
						'nick_name': '暗黑破坏神',
						'id': "wb_follow_btn_diablo"
					});
				});
			</script>
		</td>
		<td width="33%">
			<div id="wb_follow_btn_ydf"></div>
			<script>
				WB2.anyWhere(function(W)
				{
					W.widget.followButton(
					{
						'nick_name': '云淡风工作室',
						'id': "wb_follow_btn_ydf"
					});
				});
			</script>
		</td>
		<td width="33%">
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<iframe width="710" height="450"  frameborder="0" scrolling="no" src="http://widget.weibo.com/list/list.php?language=zh_cn&width=710&height=450&listid=405631095&uname=%E4%B8%89%E8%A7%92%E7%8C%ABL&uid=1406303630&listname=%E5%AE%98%E6%96%B9%E5%BE%AE%E5%8D%9A&color=191814,393834,777777,BBBBBB,191814,292824&showcreate=0&isborder=0&showtitle=0&appkey=2134516321&dpc=1"></iframe>
		</td>
	</tr>
</table>

</body>
</html>
