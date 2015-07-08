<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getTodaysGamesPlayers();

function getTodaysGamesPlayers() {

	global $dbconn;

	//$startDate = '2014-04-27';
	//$endDate = '2014-04-29';

	$startDate = date('Y-m-d');
	$endDate = date('Y-m-d');

	$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&s=1&type=26&start='.$startDate.'&end='.$endDate.'';

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

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];

	} else {

		if(!isset($json['list']['Sport']['1']['Matchday']) || !is_array($json['list']['Sport']['1']['Matchday'])) return;

		$items = $json['list']['Sport']['1']['Matchday'];

		foreach($items as $key=>$value) {

			$specDayData = $items[$key];

			foreach($specDayData as $key=>$value) {

				$match = $specDayData['Match'];

				foreach($match as $key=>$value) {

					$items = $match[$key];

					$mid = $items['id'];

					$homeArray = $items['Home'];
					$awayArray = $items['Away'];

					$coachHome = $homeArray['coach'];
					$formationHome = $homeArray['formation'];

					$homeArrayLineups = (isset($homeArray['Lineups']) ? $homeArray['Lineups'] : false);
					$awayArrayLineups = (isset($awayArray['Lineups']) ? $awayArray['Lineups'] : false);

					$lineupsHome = $homeArrayLineups;
					$lineupsAway = $awayArrayLineups;

					$homeArraySubs = (isset($homeArray['Substitutes']) ? $homeArray['Substitutes'] : false);
					$awayArraySubs = (isset($awayArray['Substitutes']) ? $awayArray['Substitutes'] : false);

					$subsHome = $homeArraySubs;
					$subsAway = $awayArraySubs;

					$teamID=$items['Home']['id'];

					$stmt = $dbconn->prepare("REPLACE INTO players (id,name,team_id, date_added) values (:id,:name,:team_id, :now_alt)");

					$now_alternative = date('Y-m-d H:m:s');
					$stmt->bindParam(':now_alt', $now_alternative);

					$stmt->bindParam(':team_id', $teamID);

					if(!is_array($lineupsHome)) return;
			//Lets get the line ups for the home team
					foreach($lineupsHome as $key=>$value) {

						$lineUpData = $lineupsHome[$key];
						$name = $lineUpData['name'];
						$playerID = $lineUpData['id'];

				//echo 'name '.$name.' player id '.$playerID.' match id '.$mid.' teamid'.$teamID;
						if (strlen($name)!=0) {

							$stmt->bindParam(':name', $name);
							$stmt->bindParam(':id', $playerID);

							$stmt->execute();

						}
					}

					$stmt = NULL; // closes the connection

					//Lets get the substitutions for the home team
					$teamID=$items['Home']['id'];

					$stmt = $dbconn->prepare("REPLACE INTO players (id,name,team_id, date_added) values (:id,:name,:team_id, :now_alt)");

					$now_alternative = date('Y-m-d H:m:s');
					$stmt->bindParam(':now_alt', $now_alternative);

					$stmt->bindParam(':team_id', $teamID);

					if(!is_array($subsHome)) return;

					foreach($subsHome as $key=>$value) {

						$subsData = $subsHome[$key];
						$pin_id = $subsData['pin_id'];
						$pout_id = $subsData['pout_id'];
						$pin_name = $subsData['pin_name'];
						$pout_name = $subsData['pout_name'];

						if (strlen($pin_name)!=0 && strlen($pin_id)!=0) {
							$stmt->bindParam(':name', $pin_name);
							$stmt->bindParam(':id', $pin_id);

							$stmt->execute();
						}

						if (strlen($pout_name)!=0 && strlen($pout_id)!=0) {
							$stmt->bindParam(':name', $pout_name);
							$stmt->bindParam(':id', $pout_id);

							$stmt->execute();
						}



					}
					$stmt = NULL; // closes the connection

					//Lets get the line ups for the away team
					$teamID=$items['Away']['id'];

					$stmt = $dbconn->prepare("REPLACE INTO players (id,name,team_id, date_added) values (:id,:name,:team_id, :now_alt)");

					$now_alternative = date('Y-m-d H:m:s');
					$stmt->bindParam(':now_alt', $now_alternative);

					$stmt->bindParam(':team_id', $teamID);

					if(!is_array($lineupsAway)) return;

					foreach($lineupsAway as $key=>$value) {

						$lineUpData = $lineupsAway[$key];
						$name = $lineUpData['name'];
						$playerID = $lineUpData['id'];

						if (strlen($name)!=0) {

							$stmt->bindParam(':name', $name);
							$stmt->bindParam(':id', $playerID);

							$stmt->execute();

						}



					}
					$stmt = NULL; // closes the connection


					//Lets get the substitutions for the away team

					$teamID=$items['Away']['id'];

					$stmt = $dbconn->prepare("REPLACE INTO players (id,name,team_id, date_added) values (:id,:name,:team_id, :now_alt)");

					$now_alternative = date('Y-m-d H:m:s');
					$stmt->bindParam(':now_alt', $now_alternative);

					$stmt->bindParam(':team_id', $teamID);

					if(!is_array($subsAway)) return;

					foreach($subsAway as $key=>$value) {

						$subsData = $subsAway[$key];
						$pin_id = $subsData['pin_id'];
						$pout_id = $subsData['pout_id'];
						$pin_name = $subsData['pin_name'];
						$pout_name = $subsData['pout_name'];


						if (strlen($pin_name)!=0 && strlen($pin_id)!=0) {
							$stmt->bindParam(':name', $pin_name);
							$stmt->bindParam(':id', $pin_id);

							$stmt->execute();
						}

						if (strlen($pout_name)!=0 && strlen($pout_id)!=0) {
							$stmt->bindParam(':name', $pout_name);
							$stmt->bindParam(':id', $pout_id);

							$stmt->execute();

						}

					}
					$stmt = NULL; // closes the connection
				}

			}
		}
	}

		/*
		date('Y-m-d', strtotime($Date. ' + 1 days'));

		$startDate = date('Y-m-d', strtotime($startDate. ' + 5 days'));
		$endDate = date('Y-m-d', strtotime($endDate. ' + 5 days'));

		sleep(65);

		getTodaysGames($startDate, $endDate);
		*/

}

	?>
