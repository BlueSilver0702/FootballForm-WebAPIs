<?php

$root = "/home/football/www/";

include $root.'dbconnect_live_scores.php';
require_once $root.'api/v1/api_functions.php';

include $root.'dbconnect_new.php';
//require_once $root.'api/v2/app_functions.php';

global $dbconn_mysql;

$type = (isset($_REQUEST['type']) && $_REQUEST['type'] != '') ? $_REQUEST['type'] : false;
$match_id = (isset($_REQUEST['match_id']) && $_REQUEST['match_id'] != '') ? $_REQUEST['match_id'] : false;
$league_id = (isset($_REQUEST['league_id']) && $_REQUEST['league_id'] != '') ? $_REQUEST['league_id'] : false;
$should_show_no_results_as_success = (isset($_REQUEST['should_show_no_results_as_success']) && $_REQUEST['should_show_no_results_as_success'] != '') ? $_REQUEST['should_show_no_results_as_success'] : false;

//league_id for GET_GAMES is actually country_id
//Sorry, haven't got around to changing yet.

if($type=='GET_GAMES') {

	getGames($league_id, $should_show_no_results_as_success);

} else if($type=='GET_GAME_DATA') {

	getGameData($match_id);
}

function getGames($lid, $should_show_no_results_as_success) {

	global $dbconn_mysql;
	global $dbconn;

	$query = $dbconn->prepare("SELECT * FROM league WHERE country_id={$lid} ORDER BY SORT ASC");
	$query->execute();

	$rowco = $query->fetchAll();

	if(count($rowco)==0) {

		error("Sorry, we couldn't find any leagues associated with this country");

	} else {

		$array = array();
		$array['match_data'] = array();

		foreach ($rowco as $indi2) {

			$thelid=$indi2['id'];
			$lName=$indi2['name'];

			//HERE WE PERFORM THE QUERY THAT GETS THE LIVE SCORES FOR THE LEAGUE ID

			$query4 = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
												FROM teams t, teams t2, live_match lm
												LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
												WHERE lm.game_status!='Canc'
												AND lm.team_home_id=t.id
												AND lm.team_away_id=t2.id
												AND lm.league_id=$thelid
												ORDER BY lm.start_time ASC");
			$query4->execute();

			$rows = $query4->fetchAll();

			if(count($rows)>0){
				foreach ($rows as $row) {
					$row['league_name']=$lName;
					if(!in_array($row, $array['match_data'])) {
						$array['match_data'][] = $row;
					}
				}
			}

			//HERE WE PEFORM THE QUERY THAT GETS THE SUBLEAGUE LIVE SCORE DATA ETC

			$query2 = $dbconn->prepare("SELECT * FROM sub_league WHERE league_id={$thelid}");
			$query2->execute();

			$rowc = $query2->fetchAll();

			if(count($rowc)==0) {

				$query3 = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
											FROM teams t, teams t2, live_match lm
											LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
											WHERE lm.game_status!='Canc'
											AND lm.team_home_id=t.id
											AND lm.team_away_id=t2.id
											AND lm.league_id=$thelid
											ORDER BY lm.start_time ASC");
				$query3->execute();

				$rows = $query3->fetchAll();

				if(count($rows)>0){
					foreach ($rows as $row) {
						$row['league_name']=$lName;

						if(!in_array($row, $array['match_data'])) {
							$array['match_data'][] = $row;
						}
					}
				}

			} else {

				foreach ($rowc as $indi) {

					//this is subleague_id
					$leagid = $indi['id'];

					$the_league_id = $indi['league_id'];

					$query22 = $dbconn->prepare("SELECT * FROM league WHERE id={$the_league_id}");
					$query22->execute();

					$rowco22 = $query22->fetchAll();

					$query4 = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
												FROM teams t, teams t2, live_match lm
												LEFT OUTER JOIN live_scores ls ON (ls.match_id=lm.id AND ls.score='CURRENT')
												WHERE lm.game_status!='Canc'
												AND lm.team_home_id=t.id
												AND lm.team_away_id=t2.id
												AND lm.league_id=$leagid
												ORDER BY lm.start_time ASC");
					$query4->execute();

					$rows = $query4->fetchAll();

					if(count($rows)>0){
						foreach ($rows as $row) {
							$row['league_name']=$rowco22[0]['name'];

							if(!in_array($row, $array['match_data'])) {
								$array['match_data'][] = $row;
							}
						}
					}
				}

			}

		}

		if (count($array['match_data'])==0) {

			if($should_show_no_results_as_success=='Y') {

				success(array("title"=>"No Live Scores", "message"=>"Sorry, no live scores could be found for the selected country today."));

			} else {

				error("Sorry, no live score data could be found for this country.");

			}
			
		} else {
			success($array);
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

	$query = $dbconn_mysql->prepare("SELECT lm.*, ls.type AS score, ls.score AS type, t.name AS team_home_name, t2.name AS team_away_name
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


