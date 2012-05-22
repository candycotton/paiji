<?php
require_once '../3rd/simple_html_dom.php';

function check_from_local()
{
	echo "checking from local ...";
	$html = file_get_html('http://us.battle.net/d3/en/status');
	
	if(null == $html)
	{
		return null;
	}

	$ret = $html->find('div.box');

	$d3status = array();

	foreach($ret as $div)
	{
		$area = $div->find('h3', 0)->innertext;
		foreach($div->find('div.server') as $serv)
		{
			if($serv->class == "server" || $serv->class == "server alt")
			{
				$server_name = trim($serv->find('div.server-name', 0)->innertext);
				$server_status_class = $serv->find('div', 0)->class;
				$server_status = "UP";
				if ($server_status_class != "status-icon up")
				{
					$server_status = "DOWN";
				}
				
				$d3status[$area][$server_name] = $server_status;
			}
		}
	}
	
	$d3status_time = date('Y-m-d H:i:s',time());

	$d3status_full["update_time"] = $d3status_time;
	$d3status_full["server_list"] = $d3status;

	$d3status_json = json_encode($d3status_full);
	
	echo "checking from local succeed. ";
	return $d3status_json;
}

// the param "url" should be a php api address, it will return final json data directly
function check_from_remote($url)
{
	echo "checking from remote ...";
	$html = file_get_html($url);
	if(null == $html)
	{
		return null;
	}

	$d3status = json_decode($html, true);
	if(null == $d3status)
	{
		return null;
	}

	// replace time with local time because different time zone.
	$d3status["update_time"] = date('Y-m-d H:i:s',time());
	
	echo "checking from remote succeed. ";
	return json_encode($d3status);
}

// check status from remote first, if failed, check from local
$d3status_json = check_from_remote('http://ipaiji.com/services/check_d3server.php');
if(null == $d3status_json)
{
	echo "check from remote failed. ";
	$d3status_json = check_from_local();
}

var_dump($d3status_json);

// write to storage
if(null != $d3status_json)
{
	$s = new SaeStorage();
	$s->write( 'main' , 'd3status.json' , $d3status_json );
}
?>