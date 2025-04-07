<?php

	ini_set("display_errors","on");
	ini_set("memory_limit","256M");
	error_reporting(E_ERROR | E_PARSE);

	$mssql["host"]												= "192.168.1.252";
	$mssql["port"]												= "1433";
	$mssql["username"]										= "susan";
	$mssql["password"]										= "susan000";
	$mssql["driver"]											= "dblib:version=8.0";
	
	$sendmail["method"]										= "AES-256-CBC";
	$sendmail["key"]											= "AlienOfBottleZTYEvhuHiDYZTV5m5EynQfkbUTYFBSEbYk";
	$sendmail["iv"]												= "AOBztSpjQ51PeuEzG8s9F";
	
	$GLOBALS["db"]												= $mssql;
	$GLOBALS["sendmail"]									= $sendmail;

?>