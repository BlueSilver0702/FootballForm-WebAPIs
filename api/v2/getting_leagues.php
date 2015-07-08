<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v1/api_functions.php';

getLeagues();

function getLeagues() {

	global $dbconn;

	$queryz = $dbconn->prepare("DELETE FROM league");
	$queryz->execute();

	$query = $dbconn->prepare("SELECT * FROM countries");
	$query->execute();

	$row = $query->fetchAll();

	/*
	$query = $dbconn->prepare("DELETE FROM league");
	$query->execute();
	*/

	foreach($row as $countryData) {

		$country_id = $countryData['id'];
		$season_id = $countryData['season_id'];

		$now_alternative = date('Y-m-d H:m:s');

		$url = "http://data2.scorespro.com/exporter/json.php?state=clientStructure&type=14&c={$country_id}";

		$cURL = curl_init();

		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_HTTPGET, true);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Accept: application/json'
		));

		$result = curl_exec($cURL);
		$json = json_decode($result,true);

		curl_close($cURL);

		$items = $json['list'];

		foreach($items as $leagueData) {

			$id = $leagueData['id'];

			if(is_numeric($id)) {

				$code = $leagueData['code'];
				$name = $leagueData['name'];
				$sort = $leagueData['sort'];
				$description = $leagueData['description'];
				$comp_start = $leagueData['comp_start'];
				$comp_end = $leagueData['comp_end'];

				echo " {$name} \n\n";

				$query = $dbconn->prepare("INSERT INTO league (id, name, sort, code, season_id, country_id, comp_start, comp_end, date_added, description) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$query->execute(array($id, $name, $sort, $code, $season_id, $country_id, $comp_start, $comp_end, $now_alternative, $description));

				if (!$query) {
    				echo "\nPDO::errorInfo():\n";
    				print_r($dbconn->errorInfo());
				}
			}
		}
	}
}

?>
