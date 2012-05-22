<?php
require_once '../3rd/simple_html_dom.php';
$html = file_get_html('http://us.battle.net/d3/en/status');

$ret = $html->find('div.box');

/*
echo "<table><tr>";
foreach($ret as $div)
{
    echo "<td>";
	echo "<b>";
    echo $div->find('h3', 0)->innertext;
	echo "</b>";
	echo "<br>";
    foreach($div->find('div.server') as $serv)
    {
		if($serv->class == "server" || $serv->class == "server alt")
		{
			$server_name = $serv->find('div.server-name', 0)->innertext ;
			$server_status_class = $serv->find('div', 0)->class;
			$server_status = "UP";
			if ($server_status_class != "status-icon up")
			{
				$server_status = "DOWN";
			}
			echo "$server_name, $server_status";
			echo "<br>";
		}
    }
    echo "</td>";
}
echo "</tr></table>";
*/

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

$s = new SaeStorage();
$s->write( 'main' , 'd3status.json' , $d3status_json );
?>