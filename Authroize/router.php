<?php

	//error_reporting(E_ERROR | E_PARSE);

	require("config.php");
	require("PlantFormAjax.php");
	require("RequestAjax.php");

	list($callClass,$loadOpti) 																= explode("{",str_replace("}","",$_GET["load"]));
	list($callMethod,$loadArgs)																= explode(":",$loadOpti);
	$args																											= explode(",",$loadArgs);
	//print_r($args);
	$callClass::$pubVar["loadVars"] 													= is_array($args)	?	$args : "";
	$callClass::$callMethod();

	print_r(json_encode($callClass::$pubVar["exportJson"]));

?>