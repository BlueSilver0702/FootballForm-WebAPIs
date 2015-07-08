<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getLeaguesza();
getLeaguesFixza();

function getLeaguesza() {

	global $dbconn;

	//$query = $dbconn->prepare("SELECT f.teams_home_id, t.league_id, l.country_id, c.name FROM fixtures f, teams t, league l, countries c WHERE t.id=f.teams_home_id AND t.league_id=l.id AND c.id=l.country_id GROUP BY l.country_id ORDER BY c.name");
	$query = $dbconn->prepare("SELECT f.teams_id, t.league_id, l.country_id, c.name FROM team_positions f, teams t, league l, countries c WHERE t.id=f.teams_id AND t.league_id=l.id AND c.id=l.country_id GROUP BY l.country_id ORDER BY c.name");

	$query->execute();

	$row = $query->fetchAll();
	$query = NULL; // closes the connection


	foreach($row as $leagueArr) {

			$id = $leagueArr['country_id'];
			echo $id.' ';

			$query = $dbconn->prepare("UPDATE countries SET should_show_on_app=? WHERE id=?");
			$query->execute(array('Y', $id));
			$query = NULL; // closes the connection
	}
}

function getLeaguesFixza() {

	global $dbconn;

	$query = $dbconn->prepare("SELECT f.teams_home_id, t.league_id, l.country_id, c.name FROM fixtures f, teams t, league l, countries c WHERE t.id=f.teams_home_id AND t.league_id=l.id AND c.id=l.country_id GROUP BY l.country_id ORDER BY c.name");

	$query->execute();

	$row = $query->fetchAll();
	$query = NULL; // closes the connection


	foreach($row as $leagueArr) {

			$id = $leagueArr['country_id'];
			echo $id.' ';

			$query = $dbconn->prepare("UPDATE countries SET should_show_on_app=? WHERE id=?");
			$query->execute(array('Y', $id));
			$query = NULL; // closes the connection
	}
}

echo "mark_countries_to_show_on_app => success\n";

?>
