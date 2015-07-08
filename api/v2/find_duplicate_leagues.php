<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getLeagues();

function getLeagues() {

	global $dbconn;

	$query = $dbconn->prepare("SELECT country_id, name, COUNT(id) AS count FROM league
							   GROUP BY name, country_id
							   HAVING count>1");

	$query->execute();

	$allLeagues = $query->fetchAll();

	foreach ($allLeagues as $data) {

		$query = $dbconn->prepare("SELECT id, name FROM league WHERE name = '{$data['name']}' AND country_id={$data['country_id']}");
		$query->execute();

		$ids = $query->fetchAll();
		
		foreach ($ids as $id) {
			$name=$id['name'];

			$id=$id['id'];

			$query = $dbconn->prepare("SELECT id FROM sub_league WHERE league_id = '{$id}'");
			$query->execute();

			$subLeagueID = $query->fetchAll();
			$newSubLeagueIds = array();

			foreach ($subLeagueID as $subid) {
				$newSubLeagueIds[] = $subid['id'];
			}

			$newSubLeagueIds[] = $id;

			$newSubLeagueIds = implode(',', $newSubLeagueIds);

			$query = $dbconn->prepare("SELECT id FROM fixtures WHERE league_id in ($newSubLeagueIds)");
			$query->execute();

			$fixturesReturned = $query->fetchAll();

			$query = $dbconn->prepare("SELECT id FROM team_positions WHERE league_id in ($newSubLeagueIds)");
			$query->execute();

			$tpReturned = $query->fetchAll();

			if(count($tpReturned)==0&&count($fixturesReturned)==0) {
				
				$query = $dbconn->prepare("DELETE FROM league WHERE id = {$id}");
				$query->execute();

			}

		}
			
	}

}

?>
