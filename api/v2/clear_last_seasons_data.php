<?php

set_time_limit(1500);

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v1/api_functions.php';

letsGetStarted();

function letsGetStarted() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');
	
	/*
	$countriesToDelete = array(
						 array('country'=>'Albania', 'id'=>'37623'),
						 array('country'=>'Algeria', 'id'=>'37628'),
						 array('country'=>'Austria', 'id'=>'35824'),
						 array('country'=>'Belgium', 'id'=>'35850'),
						 array('country'=>'Bosnia Herze', 'id'=>'37619'),
						 array('country'=>'Bulgaria', 'id'=>'35907'),
						 array('country'=>'Chile', 'id'=>'35922'),
						 array('country'=>'Croatia', 'id'=>'35967'),
						 array('country'=>'Cyprus', 'id'=>'35976'),
						 array('country'=>'Czech Republic', 'id'=>'35988'),
						 array('country'=>'Denmark', 'id'=>'35999'),
						 array('country'=>'England', 'id'=>'36023'),
						 array('country'=>'Europe UEFA', 'id'=>'35253'),
						 array('country'=>'France', 'id'=>'36133'),
						 array('country'=>'Germany', 'id'=>'36159'),
						 array('country'=>'Greece', 'id'=>'36184'),
						 array('country'=>'Hungary', 'id'=>'36204'),
						 array('country'=>'Iran', 'id'=>'37640'),
						 array('country'=>'Israel', 'id'=>'36304'),
						 array('country'=>'Italy', 'id'=>'36317'),
						 array('country'=>'Jordan', 'id'=>'37856'),
						 array('country'=>'Kuwait', 'id'=>'37694'),
						 array('country'=>'Malta', 'id'=>'37854'),
						 array('country'=>'Moldova', 'id'=>'37657'),
						 array('country'=>'Montenegro', 'id'=>'37950'),
						 array('country'=>'Morocco', 'id'=>'37645'),
						 array('country'=>'Netherlands', 'id'=>'36421'),
						 array('country'=>'Northern Ireland', 'id'=>'36457'),
						 array('country'=>'Oman', 'id'=>'37876'),
						 array('country'=>'Poland', 'id'=>'36498'),
						 array('country'=>'Portugal', 'id'=>'36509'),
						 array('country'=>'Qatar', 'id'=>'37700'),
						 array('country'=>'Romania', 'id'=>'36519'),
						 array('country'=>'Russia', 'id'=>'36521'),
						 array('country'=>'Saudia Arabia', 'id'=>'37652'),
						 array('country'=>'Scotland', 'id'=>'36616'),
						 array('country'=>'Slovakia', 'id'=>'36667'),
						 array('country'=>'Slovenia', 'id'=>'36677'),
						 array('country'=>'Spain', 'id'=>'36734'),
						 array('country'=>'Switzerland', 'id'=>'36763'),
						 array('country'=>'Tunisia', 'id'=>'37637'),
						 array('country'=>'Turkey', 'id'=>'36774'),
						 array('country'=>'UAE', 'id'=>'37708'),
						 array('country'=>'Ukraine', 'id'=>'36798'),
						 array('country'=>'Wales', 'id'=>'36840')
						);
						*/

	foreach ($countriesToDelete as $country) {

		$leagues = getLeagues($country['id']);

		foreach ($leagues as $league) {
			
			$leagueID = $league['id'];

			$subleagues = getSubLeagues($leagueID);

			doDeleting($leagueID);

			if (count($subleagues)>0) {
				
				foreach ($subleagues as $subleague) {
					$subleague_id = $subleague['id'];
					doDeleting($leagueID);
				}
			}
		}

		deleteCountry($country['id']);
	}

	vacuumDatabase();

	echo 'DELETED';
	
}

function doDeleting($league_id) {

	$fixture_ids = getFixtureIds($league_id);

	if(count($fixture_ids)>0) {
		print_r($fixture_ids);

		foreach ($fixture_ids as $fixture_id) {

			deleteYellowCards($fixture_id);
			deleteGoalsScored($fixture_id);
			deleteLineups($fixture_id);

		}
	}

	deleteFormPlayersView($league_id);
	deleteLast5Games($league_id);
	deleteTeamPositions($league_id);
	deleteTeams($league_id);
	deleteFixtures($league_id);
	deleteSubleagues($league_id);
	deleteLeague($league_id);

}

function getLeagues($country_id) {

	global $dbconn;

	$query = $dbconn->prepare("SELECT * FROM league WHERE country_id = ?");
	$query->execute(array($country_id));

	$row = $query->fetchAll();

	return $row;
}

function getSubLeagues($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("SELECT * FROM sub_league WHERE league_id = ?");
	$query->execute(array($league_id));

	$row = $query->fetchAll();

	return $row;
}

function getFixtureIds($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("SELECT * FROM fixtures WHERE league_id = ?");
	$query->execute(array($league_id));

	$row = $query->fetchAll();

	$fixture_ids = array();

	foreach($row as $fixture) {
		$fixture_ids[] = $fixture['id'];
	}

	return $fixture_ids;

}

function deleteCountry($country_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM countries WHERE id = ?");
	$query->execute(array($country_id));

}

function deleteYellowCards($match_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM yellow_cards WHERE match_id = ?");
	$query->execute(array($match_id));

}

function deleteGoalsScored($match_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM goals_scored WHERE match_id = ?");
	$query->execute(array($match_id));

}

function deleteLineups($match_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM line_ups WHERE match_id = ?");
	$query->execute(array($match_id));

}

function deleteFormPlayersView($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM form_players_view WHERE league_id = ?");
	$query->execute(array($league_id));

}

function deleteLast5Games($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM last_5_games WHERE league_id = ?");
	$query->execute(array($league_id));

}

function deleteTeamPositions($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM team_positions WHERE league_id = ?");
	$query->execute(array($league_id));

}

function deleteTeams($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM teams WHERE league_id = ?");
	$query->execute(array($league_id));

}

function deleteFixtures($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM fixtures WHERE league_id = ?");
	$query->execute(array($league_id));

}

function deleteSubleagues($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM sub_league WHERE league_id = ?");
	$query->execute(array($league_id));

}

function deleteLeague($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM league WHERE id = ?");
	$query->execute(array($league_id));

}

function vacuumDatabase($league_id) {

	global $dbconn;

	$query = $dbconn->prepare("VACUUM");
	$query->execute();

}

?>
