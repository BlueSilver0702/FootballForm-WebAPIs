<?php

$root = "/home/football/www/";

include_once $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';


work();

function work() {

	global $dbconn;
	$date = date("Y-m-d");

	$queryy = "UPDATE countries SET no_of_leagues_with_data = (SELECT COUNT(DISTINCT l.id) FROM league l, fixtures f
							   LEFT OUTER JOIN sub_league sl
							   ON sl.id=f.league_id
							   WHERE (sl.league_id = l.id OR f.league_id = l.id)
							   AND l.should_show_on_app='Y'
							   AND countries.id=l.country_id)";

	$query = $dbconn->prepare($queryy);

	$query->execute();

	$query = NULL; // closes the connection

	echo "calculate_how_many_leagues_have_data_in_country => success\n";

}

