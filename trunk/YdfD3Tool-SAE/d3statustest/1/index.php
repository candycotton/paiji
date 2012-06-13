<?php
session_start();

include_once( 'config.php' );
include_once( 'weibosdk/saetv2.ex.class.php' );

$_SESSION["debug"] = $_REQUEST["debug"];

$token = $_SESSION['token'];
$isAuthorized = ($token && !$token['error']);

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if(!$isAuthorized)
{
	if (isset($_REQUEST['code'])) 
	{
		$keys = array();
		$keys['code'] = $_REQUEST['code'];
		$keys['redirect_uri'] = WB_CALLBACK_URL;
		try
		{
			$token = $o->getAccessToken( 'code', $keys ) ;
		} 
		catch (OAuthException $e)
		{
		}
	}

	if ($token)
	{
		$_SESSION['token'] = $token;
		setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
	}	
}

$accessToken = $_SESSION['token']['access_token'];
$_SESSION["Sina_Weibo"]["access_key"] = WB_AKEY;
$_SESSION["Sina_Weibo"]["secret_key"] = WB_SKEY;
$_SESSION["Sina_Weibo"]["access_token"] = $accessToken;

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $accessToken);
$_SESSION["Sina_Weibo"]["sae_client"] = serialize($c);

$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>Ydf D3 tool</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<script src=" http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=<?= $_SESSION["Sina_Weibo"]["access_key"] ?>" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.8.20.custom.min.js"></script>
		<link rel="Stylesheet" type="text/css" href="jquery/css/ui-darkness/jquery-ui-1.8.20.custom.css">	
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css"> 
		
		<script type="text/javascript">
			
			$(function() {
				$( "#tabs" ).tabs({
					ajaxOptions: {
						error: function( xhr, status, index, anchor ) {
							$( anchor.hash ).html(
								"Couldn't load this tab. We'll try to fix this as soon as possible. ");
						}
					},
					panelTemplate: "<div class='div-main-tabs-page'></div>"
				});
			});
			
		</script>
		
	</head>

	<body>

					
	<table align=center>
		<tr>
			<td style="padding: 0px 10px"><image src="../images/icon80.png"></td>
			<td><H1>云淡风暗黑小工具</H1>服务器状态最后更新时间：<?=$update_time?></td>
			<?
			if($user_message)
			{
				echo "<td>";
				echo "<img style=\"width: 80px; height: 80px;\" src=\"" . $user_message['avatar_large'] . "\"/>";
				echo "</td>";
			}
			?>
			
			<td>
			</td>
		</tr>
	</table>
	
	<div id="tabs" class="div-main-tabs-container default-font">
		<ul style="background-color: transparent;">
			<li class="default-font"><a href="server_status_body.php">服务器状态</a></li>
			<li class="default-font"><a href="server_announce.php">维护公告</a></li>
			<li class="default-font"><a href="wb_d3group.php">官方消息</a></li>
			<li class="default-font"><a href="wb_ydfgroup.php">云淡风工作室</a></li>
			<li class="default-font"><a href="app_store.php">App Store</a></li>
		</ul>
	</div>

	© 云淡风工作室 2012, 新浪微博应用<a href="http://apps.weibo.com/dstatus">点这里</a>

	<?
	if(!$mySaeClient)
	{
		$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
		echo "<p><a href=\"" . $code_url ."\"><img src=\"images/weibo_login.png\" title=\"点击进入授权页面\" alt=\"点击进入授权页面\" border=\"0\" /></a></p>";
	}
	?>

	</body>
</html>