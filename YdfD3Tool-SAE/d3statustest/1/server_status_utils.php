<?php

$d3status_json = json_encode($d3status);

$s = new SaeStorage();
$d3status_jsonsource = $s->read( 'main' , 'd3status.json' , $d3status_json );
$d3status_full = json_decode($d3status_jsonsource, true);
$update_time = $d3status_full["update_time"];
$d3status = $d3status_full["server_list"];

function BuildList($areaData)
{
	echo "<table style=\"width: 180px;\">";
	foreach ($areaData as $server => $status)
	{
		if($server == "Gold")
		{
			echo "<tr><td colspan><H3>拍卖行</H3></td></tr>";
		}
		echo "<tr style=\"height: 40px;\">";
		echo "<td style=\"width: 90%;\"><div>" . $server . "</div></td>";
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