<?php
session_start();

include_once( 'config.php' );
include_once( 'weibosdk/saetv2.ex.class.php' );

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

$isAuthorized = ($token && !$token['error']);

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>Ydf D3 tool</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.8.20.custom.min.js"></script>
		<link rel="Stylesheet" type="text/css" href="jquery/css/ui-darkness/jquery-ui-1.8.20.custom.css">	
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css"> 
		
	</head>

	<body>
	
	
	<div id="divWeibo" class="div-main default-font">
	<?
	if($isAuthorized)
	{
		$d3_timeline = $c->user_timeline_by_id(2318706254, 1, 10);
		$d3_statuses = $d3_timeline["statuses"];
		$d3_user = $d3_statuses[0]["user"];
		echo "<img style=\"width: 80px; height: 80px;\" src=\"" . $d3_user['avatar_large'] . "\"/>";
		echo "<ul>";
		foreach($d3_statuses as $status)
		{
			echo "<li>" . $status["text"];
		}
		echo "</ul>";
	}
	?>	</div>
	

	
	</body>
</html>