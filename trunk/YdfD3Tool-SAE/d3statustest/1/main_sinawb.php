<?php
session_start();

include_once( 'config.php' );
include_once( 'weibosdk/saetv2.ex.class.php' );

//从POST过来的signed_request中提取oauth2信息
if(!empty($_REQUEST["signed_request"])){
	$o = new SaeTOAuthV2( WB_INSITE_AKEY , WB_INSITE_SKEY  );
	$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
	if($data=='-2'){
		die('签名错误');
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
	$accessToken = $_SESSION['oauth2']['oauth_token'];
	$mySaeClient = new SaeTClientV2( WB_INSITE_AKEY , WB_INSITE_SKEY , $accessToken );
	$_SESSION["Sina_Weibo"]["access_key"] = WB_INSITE_AKEY;
	$_SESSION["Sina_Weibo"]["secret_key"] = WB_INSITE_SKEY;
	$_SESSION["Sina_Weibo"]["access_token"] = $accessToken;	
	$_SESSION["Sina_Weibo"]["sae_client"] = serialize($mySaeClient);

	$uid_get = $mySaeClient->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $mySaeClient->show_user_by_id( $uid);
	
}

include_once("server_status_utils.php");
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

	<body class="wb_body">
	
	<table align= "center"><tr>
	<td>
		<H1><?echo $user_message["screen_name"] . "， 欢迎使用 云淡风暗黑小助手。";?></H1> 
		服务器状态最后更新时间：<?=$update_time?>
	</td>
	<td>
		<script type="text/javascript" charset="utf-8">
		(function(){
		  var _w = 106 , _h = 58;
		  var param = {
			url:'http://apps.weibo.com/dstatus',
			type:'5',
			count:'1', /**是否显示分享数，1显示(可选)*/
			appkey:'2134516321', /**您申请的应用appkey,显示分享来源(可选)*/
			title:'美服高延迟，台服E37，获取最新游戏服务状态信息，来试试这个 @暗黑破坏神 小工具。 同样在玩暴雪游戏的你，来试试看吧。', /**分享的文字内容(可选，默认为所在页面的title)*/
			pic:'', /**分享图片的路径(可选)*/
			ralateUid:'2809315780', /**关联用户的UID，分享微博会@该用户(可选)*/
			language:'zh_cn', /**设置语言，zh_cn|zh_tw(可选)*/
			rnd:new Date().valueOf()
		  }
		  var temp = [];
		  for( var p in param ){
			temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
		  }
		  document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
		})()
		</script>
	</td>
	</tr></table>
	<div id="tabs" class="div-main-tabs-container default-font">
		<ul style="background-color: transparent;">
			<li class="default-font"><a href="server_status_body.php">服务器状态</a></li>
			<li class="default-font"><a href="server_announce.php">维护公告</a></li>
			<li class="default-font"><a href="wb_d3group.php">官方消息</a></li>
			<li class="default-font"><a href="wb_ydfgroup.php">云淡风工作室</a></li>
			<li class="default-font"><a href="app_store.php">App Store</a></li>
		</ul>
	</div>
	<br>
	© <a href=http://weibo.com/u/2809315780>云淡风工作室</a> 2012
	
	</body>
</html>

