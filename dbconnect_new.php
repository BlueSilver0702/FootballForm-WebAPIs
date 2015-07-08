<?php

require_once '/home/football/dbconfig.php';
$root = "/home/football/www/";

try {
	# MySQL with PDO_MYSQL
	$dbconn = new PDO("sqlite:{$root}football_form_database_new.db", "", "");
} catch(PDOException $e) {
    echo $e->getMessage();
}

try {
	# MySQL with PDO_MYSQL
	$dbconn_android = new PDO("sqlite:{$root}football_form_database_android.db", "", "");
} catch(PDOException $e) {
    echo $e->getMessage();
}
