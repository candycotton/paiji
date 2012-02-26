<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>拍迹</title>
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css">

		<script src="jquery/js/jquery-1.4.2.min.js" language="JavaScript"></script>
		<script src="scripts/calendar.js" language="JavaScript" ></script>

		<script>
			$(function()
			{
				$('#main-calendar').calendarWidget({month: 1,year: 2012});
			});
		</script>

		<style>
			td, th {
				border-left: 1px solid #999;
				border-bottom: 1px solid #999;
				width: 120px;
				padding: 10px 0;
				text-align: center;
			}

			table {
				border-right: 1px solid #999;
				border-top: 1px solid #999;
			}

			th {
				background: #666;
				color: #fff;
			}

			.other-month {
				background: #eee;
			}
		</style>
		
		<script type="text/javascript"
			src="http://maps.google.com/maps/api/js?sensor=false" ></script>
		<script type="text/javascript">
			var geocoder;
			var map;
			function initialize() {
				geocoder = new google.maps.Geocoder();
				var latlng = new google.maps.LatLng(37.4419, -122.1419);
				var myOptions = {
					zoom: 8,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				map_GoUserCity();
			  }

			function map_GoUserCity() {
				var address = '<?=$user_message['location']?>';
				if (geocoder) {
					geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: map, 
							position: results[0].geometry.location
							});
						} else {
						alert("Geocode was not successful for the following reason: " + status);
						}
					});
				}
			}

			function codeAddress() {
				var address = document.getElementById("address").value;
				if (geocoder) {
					geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);
						var marker = new google.maps.Marker({
							map: map, 
							position: results[0].geometry.location
							});
						} else {
						alert("Geocode was not successful for the following reason: " + status);
						}
					});
				}
			  }
		</script>
		
</head>

<body onload="initialize();">

	<div class="div-main">
		<table style="width: 100%">
			<tr>
				<td style="width: 20%;"><img
					src="<?=$user_message['avatar_large']?>" width="120" alt="" />
				</td>
				<td colspan="3" style="vertical-align: middle;">
					<?=$user_message['screen_name']?>,您好<br>
					您来自： <?=$user_message['location']?><br>
					<input type="button" value="Locate" onclick="codeAddress()">
					<input id="address" type="textbox" value="<?=$user_message['location']?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" style="width: 50%;">
					<div id="main-calendar" ></div>
				</td>
				<td colspan="2" style="width: 50%;">
					<div id="map_canvas" style="width: 400px; height: 300px;"></div>
				</td>
			</tr>
		</table>
	</div>

</body>

</html>
