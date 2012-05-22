<?php
header('Content-Type: text/html; charset=UTF-8');

define( "WB_AKEY" , '<<APP_Key>>' );
define( "WB_SKEY" , '<<APP_Secret>>' );
define( "WB_CALLBACK_URL" , 'http://'.$_SERVER["HTTP_APPVERSION"].'.'.$_SERVER["HTTP_APPNAME"].'.sinaapp.com/callback.php' );
