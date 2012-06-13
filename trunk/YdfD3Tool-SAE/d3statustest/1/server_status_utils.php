<?php

$d3status_json = json_encode($d3status);

$s = new SaeStorage();
$d3status_jsonsource = $s->read( 'main' , 'd3status.json' , $d3status_json );
$d3status_full = json_decode($d3status_jsonsource, true);
$update_time = $d3status_full["update_time"];
$d3status = $d3status_full["server_list"];

$server_dict = array(
	"Game Server" => "游戏服务器",
	"Gold" => "金币（Gold）",
	"Hardcore" => "专家拍卖行（Hardcore）",
	"USD" => "美元（USD）",
	"AUD" => "澳元（AUD）",
	"MXN" => "墨西哥比索（MXN）", 
	"BRL" => "巴西雷亚尔（BRL）",
	"CLP" => "智利比索（CLP）",
	"ARS" => "阿根廷比索（ARS）",
	"EUR" => "欧元（EUR）",
	"GBP" => "英镑（GBP）", 
	"RUB" => "俄罗斯卢布（RUB）"
	);


	

function BuildList($areaData)
{
	global $server_dict;
	
	echo "<table style=\"width: 180px;\">";
	foreach ($areaData as $server => $status)
	{
		if($server == "Gold")
		{
			echo "<tr><td colspan><H3>拍卖行</H3></td></tr>";
		}
		echo "<tr style=\"height: 40px;\">";
		$display_server = $server_dict[$server];
		if(!$display_server)
		{
			$display_server = $server;
		}
		echo "<td style=\"width: 90%;\"><div>" . $display_server . "</div></td>";
		echo "<td>";
		$statusclass = "status-icon down";
		if($status == "UP") { $statusclass = "status-icon up"; } 
		echo "<div class=\"" . $statusclass . "\"></div>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>