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

//$mySaeClient = new SaeTClientV2( $myAccessKey, $mySecretKey, $myAccessToken);
$mySaeClient = unserialize($_SESSION[Sina_Weibo]["sae_client"]);
$uid_get = $mySaeClient->get_uid();
$uid = $uid_get['uid'];
$user_message = $mySaeClient->show_user_by_id( $uid);
if($user_message["error"])
{
	foreach ($user_message["error"] as $key => $value)
	{
		echo $key . " : " . $value . "<br>";
	}
}
exit;
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>Ydf D3 tool</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.8.20.custom.min.js"></script>
		<link rel="Stylesheet" type="text/css" href="jquery/css/ui-darkness/jquery-ui-1.8.20.custom.css">	
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css"> 

		<script src=" http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=<?= $_SESSION["Sina_Weibo"]["access_key"] ?>" type="text/javascript" charset="utf-8"></script>
		
	</head>
	
	<body>
	
	<table width="90%">
		<tr>
			<td width="40%">
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
				
				<div id="divWeibo" class="div-main default-font">
				<?
				if($mySaeClient)
				{
					$d3_timeline = $mySaeClient->user_timeline_by_id(2318706254, 1, 10);
					debugVarDump($d3_timeline);
					$d3_statuses = $d3_timeline["statuses"];
					echo "<ul>";
					foreach($d3_statuses as $status)
					{
						echo "<li>" . $status["text"];
					}
					echo "</ul>";
				}
				?>
				</div>
			</td>
			<td width="40%" style="vertical-align: top;">
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
				
				<div id="divWeiboYdf" class="div-main default-font">
				<?
				if($mySaeClient)
				{
					debugVarDump($mySaeClient);
					$ydf_timeline = $mySaeClient->user_timeline_by_id(2809315780, 1, 10);
					$ydf_statuses = $ydf_timeline["statuses"];
					echo "<ul>";
					foreach($ydf_statuses as $status)
					{
						echo "<li>" . $status["text"];
					}
					echo "</ul>";
				}
				?>
				</div>
			</td>
		</tr>
	</table>
	
	
	</body>
</html>