<?php

set_time_limit(350);

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';


getLeaguesxc();
//getSubleaguesxc();

function getLeaguesxc() {

	global $dbconn;

	//$query = $dbconn->prepare("SELECT tp.league_id AS league_id FROM team_positions tp GROUP BY tp.league_id");
	$query = $dbconn->prepare("SELECT f.teams_id, t.league_id FROM team_positions f, teams t WHERE t.id=f.teams_id GROUP BY t.league_id");
	//SELECT f.teams_home_id, t.league_id FROM fixtures f, teams t WHERE t.id=f.teams_home_id GROUP BY t.league_id

	$query->execute();

	$row = $query->fetchAll();
	$query = NULL; // closes the connection


	foreach($row as $leagueArr) {

			$id = $leagueArr['league_id'];
			echo $id.' ';

			$query = $dbconn->prepare("UPDATE league SET should_show_on_app=? WHERE id=?");
			$query->execute(array('Y', $id));
			$query = NULL; // closes the connection
	}
}

function getSubleaguesxc() {

	global $dbconn;

	$query = $dbconn->prepare("SELECT sl.league_id AS the_league_id FROM team_positions f, teams t, sub_league sl WHERE sl.id=t.league_id AND t.id=f.teams_id GROUP BY sl.league_id");
	//SELECT sl.league_id AS the_league_id FROM fixtures f, teams t, sub_league sl WHERE sl.id=f.league_id AND t.id=f.teams_home_id GROUP BY sl.league_id

	$query->execute();

	$row = $query->fetchAll();

	foreach($row as $leagueArr) {

			$id = $leagueArr['the_league_id'];
			echo $id.'  ';

			$query = $dbconn->prepare("UPDATE league SET should_show_on_app=? WHERE id=?");
			$query->execute(array('Y', $id));
			$query = NULL; // closes the connection
	}
}

echo "mark_leagues_to_show_on_app => success\n";
?>
