<?php

$root = "/home/football/www/";

include_once $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

subleagueCounterr();

function subleagueCounterr() {

	global $dbconn;

	$queryy = "UPDATE league SET has_subleague = (SELECT count(id) FROM sub_league sl WHERE sl.league_id = league.id)";

	$query = $dbconn->prepare($queryy);

	$query->execute();

    $query = NULL; // closes the connection

    echo "calculate_how_many_subleagues_per_league => success\n";

}

