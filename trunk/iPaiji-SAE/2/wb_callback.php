<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
?>
<!--授权完成,<a href="wb_list.php">进入你的微博列表页面</a><br />-->
授权完成, 3秒后进入拍迹主页（定时器还没做，大家自己点击吧。）。<BR>
<a href="<?=PAGE_LOGGED_IN?>">直接进入拍迹</a><br />
<?php
} else {
?>
授权失败。
<?php
}
?>
