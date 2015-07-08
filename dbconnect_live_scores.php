<?php

if(!isset($dbconn_mysql)) {
	require_once '/home/football/dbconfig.php';
	$root = "/home/football/www/";

	if(isset($root)){
		require_once $root . '../dbconfig.php';	
	} else if (isset($site) && $site = true) {
		require_once '../dbconfig.php';
	}else{
		require_once '../../../dbconfig.php';
	}

	try {
		# MySQL with PDO_MYSQL
		$dbconn_mysql = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	}
	catch(PDOException $e) {
	    echo $e->getMessage();
	}
}

 ?>