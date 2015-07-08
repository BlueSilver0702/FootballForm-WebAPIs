<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getLeaguessd();

function getLeaguessd() {

	global $dbconn;

	$query = $dbconn->prepare("DELETE FROM sub_league");
	$query->execute();

	$query = $dbconn->prepare("SELECT * FROM league");
	$query->execute();

	$row = $query->fetchAll();

	foreach($row as $countryData) {

		$league_id = $countryData['id'];
		$country_id = $countryData['country_id'];

		$now_alternative = date('Y-m-d H:m:s');

		$url = "http://data2.scorespro.com/exporter/json.php?state=clientStructure&type=15&c={$country_id}&id={$league_id}";

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

		#echo "{$url}\n";
		#echo count($json['list']) . "\n";



		$items = $json['list'];
		$ttype = $items['type'];

		if(!empty($items)) {
			foreach($items as $key=> $leagueData) {


				// echo "{$key} => {$leagueData['id']}\n";
				//
				if(!isset($leagueData['id'])) continue;

				if(is_numeric($leagueData['id'])){

					$id = $leagueData['id'];
					$code = $leagueData['code'];
					$name = $leagueData['name'];
					$sort = $leagueData['sort'];
					$description = $leagueData['description'];
					$comp_start = $leagueData['comp_start'];
					$comp_end = $leagueData['comp_end'];

					echo " {$name} {$leagueData['id']} \n";

					$query = $dbconn->prepare("REPLACE INTO sub_league (id, name, code, sort, type, country_id, comp_start, comp_end, date_added, description, league_id) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$query->execute(array($id, $name, $code, $sort, $ttype, $country_id, $comp_start, $comp_end, $now_alternative, $description, $league_id));



					if (!$query) {
	    				echo "\nPDO::errorInfo():\n";
	    				print_r($dbconn->errorInfo());
					}

					$query = NULL; // closes the connection
				}
			}
		}

		//sleep(20);
	}
	echo "getting_sub_leagues => success\n";
}

?>
