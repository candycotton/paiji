<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

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
	$c = new SaeTClientV2( WB_INSITE_AKEY , WB_INSITE_SKEY , $_SESSION['oauth2']['oauth_token'] );
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id( $uid);
	
}

include_once("server_status_utils.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>Ydf D3 tool</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="stylesheets/main.css"> 
		
	</head>

	<body>
	
	<H1><?echo $user_message["screen_name"] . "， 欢迎使用 云淡风暗黑小工具。";?></H1> 
	服务器状态最后更新时间：<?=$update_time?>
	
<?
include_once("server_status_body.php");
?>	
	© 云淡风工作室 2012
	
	</body>
</html>

