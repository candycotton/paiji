<?php
include_once( 'check_d3server_utils.php' );

$annouce_us = get_server_announcement( URL_ANNOUNCEMENT_SERVER_STATUS_US );
$annouce_tw = get_server_announcement( URL_ANNOUNCEMENT_SERVER_STATUS_TW );
$annouce_kr = get_server_announcement( URL_ANNOUNCEMENT_SERVER_STATUS_KR );

$annouce = array();

if(null != $annouce_us)
{
	$annouce["us"] = $annouce_us;
}

if(null != $annouce_tw)
{
	$annouce["tw"] = $annouce_tw;
}

if(null != $annouce_tw)
{
	$annouce["kr"] = $annouce_kr;
}

var_dump($annouce);
write_to_storage_json('d3annouce.json', $annouce);


?>