<?php

require_once '/home/football/dbconfig.php';
$root = "/home/football/www/";

$dbname = "football_export";


try {
    # MySQL with PDO_MYSQL
    $dbconn = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
} catch(PDOException $e) {
    echo $e->getMessage();
}
