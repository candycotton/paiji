<?php
$language = $_REQUEST["lang"];
$type = $_REQUEST["type"];
$width = $_REQUEST["ScreenWidth"] - 20;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>Ydf D3 tool</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="../stylesheets/main.css"> 
		
		
	</head>

	<body>

					
	<div class="div-support" align=center style="width: <?= $width ?>px">
<?

if(!$language)
{
	$language = "en-us";
}
if(!$type)
{
	$type = "ios";
}

include_once($language. "/" . $type . ".txt");
?>
	<p>
	<hr>
	</div>
	<p>

	© 云淡风工作室 2012, 新浪微博应用<a href="http://apps.weibo.com/dstatus">点这里</a>


	</body>
</html>