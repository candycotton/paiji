<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

//从POST过来的signed_request中提取oauth2信息
if(!empty($_REQUEST["signed_request"])){
	$o = new SaeTOAuthV2( WB_INSITE_AKEY , WB_INSITE_SKEY  );
	$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
	if($data=='-2'){
		 die('签名错误!');
	}else{
		$_SESSION['oauth2']=$data;
	}
}

//判断用户是否授权
if (empty($_SESSION['oauth2']["user_id"]))
{  
	//若没有获取到access token，则发起授权请求
	include "wb_is_auth.php";
	exit;
} 
else
{
	//若已获取到access token，则加载应用信息
	$c = new SaeTClientV2( WB_INSITE_AKEY , WB_INSITE_SKEY , $_SESSION['oauth2']['oauth_token'] );
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id( $uid);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>Sweet Days: Sina Weibo Main</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="stylesheets/main.css"> 

		<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
		<script src="jquery/js/jquery-1.4.2.min.js" language="JavaScript"></script>
		<script src="scripts/calendar.js" language="JavaScript"></script>
		
		<script>
			$(function()
			{
				$('#main-calendar').calendarWidget({month: 11,year: 2011});
			});
		</script>

		<style>
			td, th {
				border-left: 1px solid #999;
				border-bottom: 1px solid #999;
				width: 120px;
				padding: 10px 0;
				text-align: center;
			}

			table {
				border-right: 1px solid #999;
				border-top: 1px solid #999;
			}

			th {
				background: #666;
				color: #fff;
			}

			.other-month {
				background: #eee;
			}
		</style>
		
	</head>

	<body>
	
	<div class="div-main">
		<table style="width: 100%">
			<tr>
				<td style="width: 20%">

<img src="<?=$user_message['avatar_large']?>" width="120"/>

				</td>
				<td style="vertical-align:middle;">
<?=$user_message['screen_name']?>,您好！
				</td>
			</tr>
			<tr>
				<td colspan="2" >
				<div id="main-calendar"></div>
				</td>
			</tr>
		</table>
	</div>
	
	
	</body>
</html>
