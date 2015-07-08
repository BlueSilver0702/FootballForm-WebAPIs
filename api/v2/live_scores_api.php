<?php


$root = "/home/football/www/";

include $root.'dbconnect_live_scores.php';
require_once $root.'api/v1/api_functions.php';

global $dbconn_mysql;

$type = (isset($_REQUEST['type']) && $_REQUEST['type'] != '') ? $_REQUEST['type'] : false;
$match_id = (isset($_REQUEST['match_id']) && $_REQUEST['match_id'] != '') ? $_REQUEST['match_id'] : false;
$league_id = (isset($_REQUEST['league_id']) && $_REQUEST['league_id'] != '') ? $_REQUEST['league_id'] : false;

if($type=='GET_GAMES') {

	getGames($league_id);

} else if($type=='GET_GAME_DATA') {

	getGameData($match_id);
}

function getGames($lid) {

	global $dbconn_mysql;

	$array = array();

	$query = $dbconn_mysql->prepare("SELECT * FROM sub_league WHERE league_id={$lid}");
	$query->execute();

	$rowc = $query->fetchAll();

	if(count($rowc)==0) {

		$filter = "";
		if($_SERVER['REMOTE_ADDR'] != '62.30.95.25'){
			$filter = "	AND lm.league_id = $lid ";
		}

		$query = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
									FROM teams t, teams t2, live_match lm
									LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
									WHERE lm.game_status!='Canc'
									AND lm.team_home_id=t.id
									AND lm.team_away_id=t2.id
									$filter
									ORDER BY lm.status_type='live' DESC");

		$query->execute();

		$row = $query->fetchAll();
		$array['match_data'] = $row;
		success($row);

	} else {

		foreach ($rowc as $indi) {

			$leagid = $indi['id'];

			// just to actually get some results, Russia works well here
			$filter = "";
			if($_SERVER['REMOTE_ADDR'] != '62.30.95.25'){
				$filter = "	AND lm.league_id = $leagid ";
			}

			$query = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
										FROM teams t, teams t2, live_match lm
										LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
										WHERE lm.game_status!='Canc'
										AND lm.team_home_id=t.id
										AND lm.team_away_id=t2.id
										{$filter}
										ORDER BY ls.date_updated DESC");
			$query->execute();

			$row = $query->fetchAll();
			$array['match_data'] = $row;
			success($row);
		}

	}
}

function getGameData($match_id) {

	global $dbconn_mysql;

	$successArray = array();

	$query = $dbconn_mysql->prepare("SELECT * FROM live_scorers WHERE match_id={$match_id}");
	$query->execute();

	$scorers = $query->fetchAll();
	$successArray['scorers'] = $scorers;


	$query = $dbconn_mysql->prepare("SELECT * FROM live_scores WHERE match_id={$match_id}");
	$query->execute();

	$scores = $query->fetchAll();
	$successArray['scores'] = $scores;


	$query = $dbconn_mysql->prepare("SELECT * FROM live_cards WHERE match_id={$match_id}");
	$query->execute();

	$cards = $query->fetchAll();

	$successArray['cards'] = $cards;

	$query = $dbconn_mysql->prepare(" SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
								FROM teams t, teams t2, live_match lm
								LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
								WHERE lm.game_status!='Canc'
								AND lm.team_home_id=t.id
								AND lm.team_away_id=t2.id
								AND lm.id=$match_id
								ORDER BY lm.status_type='live' DESC");
	$query->execute();

	$cards = $query->fetchAll();

	$successArray['match_data'] = $cards;

	success($successArray);
}


