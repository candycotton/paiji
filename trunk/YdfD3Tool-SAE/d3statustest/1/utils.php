<?php
function debugVarDump($obj)
{
	$debugMode = ($_REQUEST["debug"] == "yes") || ($_SESSION["debug"] == "yes");
	if($debugMode)
	{
		echo "" . $_REQUEST["debug"] . "<br>";
		echo "" . $_SESSION["debug"] . "<br>";
		var_dump($obj);
	}
}
?>