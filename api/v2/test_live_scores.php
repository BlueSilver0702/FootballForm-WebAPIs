<?php

$root = "/home/football/www/";

include $root.'dbconnect_live_scores.php';
require_once $root.'api/v1/api_functions.php';

include $root.'dbconnect_new.php';
//require_once $root.'api/v2/app_functions.php';

global $dbconn_mysql;

	getGames($league_id);

function getGames($lid) {

	global $dbconn_mysql;
	global $dbconn;

	$array = array();

	$query3 = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
							FROM teams t, teams t2, live_match lm
							LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
							WHERE lm.game_status!='Canc'
							AND lm.team_home_id=t.id
							AND lm.team_away_id=t2.id
							ORDER BY lm.status_type='live' DESC");
	$query3->execute();

	$rows = $query3->fetchAll();
	$array['match_data'] = $row;

	success($array);

}

