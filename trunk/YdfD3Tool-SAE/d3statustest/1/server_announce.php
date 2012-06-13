<?php

	$s = new SaeStorage();
	$data_json = $s->read( 'main' , 'd3annouce.json');
	
	$announce = json_decode($data_json, true);

	if(!$announce)
		exit;
		
?>

	
	<div class="div-main">
		<table style="width: 100%">
			<tr class="tr-header">
			</tr>
			<tr>
				<td class="td-area default-font" style="color: #3366EE">
					<H2>美服</H2>
					<h3><?=$announce['us']['title']?></h3>
					<?=$announce['us']['content']?>
				</td>
				<td class="td-area default-font" style="color: #3366EE">
					<H2>亚服</H2>
					<h3><?=$announce['tw']['title']?></h3>
					<?=$announce['tw']['content']?>
				</td>
			</tr>

		</table>
	
	</div>
