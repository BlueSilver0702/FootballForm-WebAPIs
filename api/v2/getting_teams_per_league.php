<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getListOfTeamsPerLeague();

function getListOfTeamsPerLeague() {

	$now_alternative = date('Y-m-d H:m:s');

	global $dbconn;

	$query = $dbconn->prepare("SELECT * FROM league");
	$query->execute();

	$row = $query->fetchAll();

	foreach ($row as $leagueData) {

		$league_id = $leagueData['id'];
		$country_id = $leagueData['country_id'];

		$url = "http://data2.scorespro.com/exporter/json.php?state=clientStructure&type=17&c={$country_id}&id={$league_id}";
		//$url = "http://data2.scorespro.com/exporter/json.php?state=clientStructure&type=17&c=36023&id=26009";
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

		print_r($items);
		//exit();

		$stmt = $dbconn->prepare("REPLACE INTO teams (id,name,code,date_added,league_id) values (:id,:name,:code,:now_alt,:leagueidd)");

		foreach($items as $key=>$value) {

			$item = $items[$key];
			$id = $item['id'];
			$code = $item['code'];
			$name = $item['name'];

			if(is_numeric($id)&&strlen($name)>1) {
				
			$stmt->bindParam(':now_alt', $now_alternative);
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':code', $code);
			$stmt->bindParam(':leagueidd', $league_id);
			$stmt->execute();

			}
		}
	}

	echo 'success';
}


?>
