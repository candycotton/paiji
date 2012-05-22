<?php
session_start();

include_once( 'config.php' );
include_once( 'weibosdk/saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sweet Days: Login</title>
</head>

<body>
<?=$user_message['screen_name']?>,您好！<br>
<img src="<?=$user_message['avatar_large']?>"/>
<?php
foreach ($user_message as $k => $v) {
	echo "<p>".$k."：".$v."</p>";
	}
?>
</body>
</html>
