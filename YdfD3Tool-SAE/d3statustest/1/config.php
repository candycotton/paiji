<?php
header('Content-Type: text/html; charset=UTF-8');

// SAE 站点
define( "WB_AKEY" , '883543156' );
define( "WB_SKEY" , '1884f84a9083639ee3b3d5be77debbec' );
define( "WB_CALLBACK_URL" , 'http://'.$_SERVER["HTTP_APPNAME"].'.sinaapp.com' );

// Sina Weibo : 暗黑小助手 (站内应用)
define( "WB_INSITE_AKEY" , '2134516321' );
define( "WB_INSITE_SKEY" , '63efeef2eed220dc27968a40a2864aa9' );
define( "WB_INSITE_AUTHURL" , 'http://'.$_SERVER["HTTP_APPVERSION"].'.'.$_SERVER["HTTP_APPNAME"].'.sinaapp.com/wb_is_auth.php' );

define( "PAGE_LOGGED_IN", "logged_in.php" );
