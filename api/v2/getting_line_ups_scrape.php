<?php

//$root = "/home/football/www/";
//include $root.'dbconnect_live_scores.php';
//require_once $root.'api/v1/api_functions.php';
global $dbconn_mysql;

$query = $dbconn_mysql->prepare("SELECT * FROM should_run_flag");
$query->execute();
$row = $query->fetchAll();

$run = $row[0]['last_date_fetched'];
$when_should_stop = $row[0]['date_should_stop'];

if(strtotime($run) < strtotime($when_should_stop)) {
	die("All data captured! :-)");
}

$start_date = date('Y-m-d', strtotime($run.' -5 days'));
$end_date = date('Y-m-d', strtotime($run));

getTodaysGamesy($start_date, $end_date);

$query = $dbconn_mysql->prepare("UPDATE should_run_flag SET last_date_fetched=? WHERE id=0");
$query->execute(array($start_date));

function getTodaysGamesy($start_date, $end_date) {
	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&s=1&type=26&start='.$start_date.'&end='.$end_date.'';

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

	if($json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {
		echo $json['error'];
	} else {

		$items = $json['list']['Sport']['1']['Matchday'];

		foreach($items as $key) {

			$specDayData = $key;

				foreach($specDayData as $key=>$value) {

					$date = $specDayData['date'];
					$match = $specDayData['Match'];

					foreach($match as $key=>$value) {

						$items = $match[$key];

						$mid = $items['id'];

						$homeArray = $items['Home'];
						$awayArray = $items['Away'];

						$coachHome = $homeArray['coach'];
						$formationHome = $homeArray['formation'];
						$lineupsHome = $homeArray['Lineups'];
						$lineupsAway = $awayArray['Lineups'];

						$teamID=$items['Home']['id'];

						$stmt = $dbconn->prepare("REPLACE INTO line_ups (player_id,match_id,team_id,fixture_date, date_updated) values (:player_id,:match_id,:team_id,:fixture_date,:now_alt)");

						$stmt->bindParam(':team_id', $teamID);
						$stmt->bindParam(':fixture_date', $date);
						$stmt->bindParam(':match_id', $mid);
						$stmt->bindParam(':now_alt', $now_alternative);

						if(is_array($lineupsHome)) {

							//Lets get the line ups for the home team
							foreach($lineupsHome as $key=>$value) {

								$lineUpData = $lineupsHome[$key];
								$playerID = $lineUpData['id'];

									if ($playerID!=0) {

										$stmt->bindParam(':player_id', $playerID);

										$stmt->execute();

									}

							}

						}

						//Lets get the line ups for the away team
						$teamID=$items['Away']['id'];

						$stmt = $dbconn->prepare("REPLACE INTO line_ups (player_id,match_id,team_id,fixture_date, date_updated) values (:player_id,:match_id,:team_id,:fixture_date,:now_alt)");

						$stmt->bindParam(':team_id', $teamID);
						$stmt->bindParam(':fixture_date', $date);
						$stmt->bindParam(':match_id', $mid);
						$stmt->bindParam(':now_alt', $now_alternative);

						if(is_array($lineupsAway)) {

							//Lets get the line ups for the home team
							foreach($lineupsAway as $key=>$value) {

								$lineUpData = $lineupsAway[$key];
								$playerID = $lineUpData['id'];

								//echo 'name '.$name.' player id '.$playerID.' match id '.$mid.' teamid'.$teamID;
								if ($playerID!=0) {

									$stmt->bindParam(':player_id', $playerID);

									$stmt->execute();

								}

							}

						}

				}

			}		
		}
	}

	echo 'script ran';
}

?>
