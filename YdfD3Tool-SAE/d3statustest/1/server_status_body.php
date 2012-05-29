<?php
include_once("server_status_utils.php");
?>

	
	<div class="div-main">
		<table style="width: 100%">
			<tr class="tr-header">
			</tr>
			<tr>
				<td class="td-area background default-font">
					<H2>美国</H2>
					<?BuildList($d3status['Americas'])?>
				</td>
				<td class="td-area background default-font">
					<H2>欧洲</H2>
					<?BuildList($d3status['Europe'])?>
				</td>
				<td class="td-area background default-font">
					<H2>亚洲</H2>
					<?BuildList($d3status['Asia'])?>
				</td>
			</tr>

		</table>
	
	</div>
