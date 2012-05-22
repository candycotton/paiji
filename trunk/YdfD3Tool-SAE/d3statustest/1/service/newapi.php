<?php
include_once("restutils.php");

$data = RestUtils::processRequest();

function processGetRequest($getRequest)
{
	$requestVars = $getRequest->getRequestVars();
	$getType = $requestVars["type"];

	$address["Americas"] = "12.129.193.254";
	$address["Europe"] = "213.155.134.45";
	$address["Asia"] = "211.234.120.10";
	$address["China"] = "";
	
	switch($getType)
	{
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