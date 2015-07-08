<?php
//BE WARNED - RUNNING THIS WILL REMOVE THE 2013/2014 PREFIX TO THE COUNTRIES
$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getSeasonData();

function getSeasonData() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	$url = 'http://data2.scorespro.com/exporter/json.php?state=clientStructure&type=12&s=1';
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

	$seasonData = $json['list'];
	$englandSeasonID = nil;
		
	foreach($seasonData as $key) {
		
		$seasonID = $key['id'];
		$name = $key['name'];

		if(is_numeric($seasonID)) {

			if($name=='2014/2015') {

				getCountriesFromSeasonID($seasonID);

			}
		}
	}
}


function getCountriesFromSeasonID($seasonID) {

	$now_alternative = date('Y-m-d H:m:s');

	global $dbconn;

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientStructure&type=13&ss={$seasonID}";
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

	/*
	$query = $dbconn->prepare("DELETE FROM countries");
	$query->execute();
	*/

	foreach($items as $countryData) {

		$countryID = $countryData['id'];
		$name = $countryData['name'];
		$code = $countryData['code'];

		if(is_numeric($countryID)) {

			echo $seasonID.' ';

			$query = $dbconn->prepare("INSERT INTO countries (id, name, code, date_updated, season_id) values (?, ?, ?, ?, ?)");
			$query->execute(array($countryID, $name, $code, $now_alternative, $seasonID));

		}	
	}
}


?>
