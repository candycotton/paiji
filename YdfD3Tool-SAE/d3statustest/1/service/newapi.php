<?php
include_once( 'restutils.php' );
include_once( 'check_d3server_utils.php' );
include_once( 'service_config.php' );

$data = RestUtils::processRequest();

function processGetRequest($getRequest)
{
	$requestVars = $getRequest->getRequestVars();
	$getType = $requestVars["type"];

	$address["Americas"] = "12.129.193.254";
	$address["Europe"] = "213.155.134.45";
	$address["Asia"] = "211.234.120.10";
	$address["China"] = "";
		
	$battlenet["America"] = "us.battle.net";
	$battlenet["Europe"] = "eu.battle.net";
	$battlenet["Asia"] = "tw.battle.net";
	$battlenet["China"] = "www.battlenet.com.cn";
	
	$speedtest["http_get_url"] = "d3/static/images/icons/map-small.gif";
	$speedtest["http_weight"] = 1;
	$speedtest["method"] = "http";

	switch($getType)
	{
		case 'version':
			$version_appstore = array(IOS_APPSTORE_D3HELPER_ID => IOS_APPSTORE_D3HELPER_VERSION, IOS_APPSTORE_D3SKILL_ID => IOS_APPSTORE_D3SKILL_VERSION);
			$version = array("app_store" => $version_appstore);
			RestUtils::sendResponse(200, json_encode($version), 'application/json');
			break;
		case 'announce':
			$annouce = read_from_storage_json('d3annouce.json');
			if(null != $annouce)
			{
				RestUtils::sendResponse(200, $annouce, 'application/json');
			}
			break;
		case 'serverip':
			// 亚服：211.234.120.10
			// 美服：12.129.193.254 
			// 欧服：213.155.134.45

			RestUtils::sendResponse(200, json_encode($address), 'application/json');
			break;
		case 'serverstatus':
		default:
			$s = new SaeStorage();
			$d3status_json = $s->read( 'main' , 'd3status.json');
			$d3status = json_decode($d3status_json, true );
			$d3status["server_ip"] = $address;
			$d3status["battle.net"] = $battlenet;
			$d3status["speedtest"] = $speedtest;
			RestUtils::sendResponse(200, json_encode($d3status), 'application/json');
			break;
	}
	
}

switch($data->getMethod()){
	// this is a request for all users, not one in particular
	case 'get':
		processGetRequest($data);
		break;
		// new user create
	case 'post':
		$user = new User();
		$user->setFirstName($data->getData()->first_name);  // just for example, this should be done cleaner
		// and so on...
		$user->save();

		// just send the new ID as the body
		RestUtils::sendResponse(201, $user->getId());
		break;
	default:
		$s = new SaeStorage();
		$d3status = $s->read( 'main' , 'd3status.json' , $d3status_json );
		echo $d3status;
		$d3status_json = json_decode($d3status, true);
		
		break;
}

exit;
?>