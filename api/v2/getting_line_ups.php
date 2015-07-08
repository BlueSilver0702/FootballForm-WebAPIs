<?php
set_time_limit(1500);

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

$startDate = (isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != '') ? $_REQUEST['start_date'] : false;
$endDate = (isset($_REQUEST['end_date']) && $_REQUEST['end_date'] != '') ? $_REQUEST['end_date'] : false;

getTodaysGames($startDate, $endDate);

function getTodaysGames($startDate, $endDate) {

global $dbconn;

$now_alternative = date('Y-m-d H:m:s');

$date = date('Y-m-d');

if(strtotime($startDate)==0) {

	$startDate = $date;
	$endDate = $date;

}

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

		$items = (isset($json['list']['Sport']['1']['Matchday']) ? $json['list']['Sport']['1']['Matchday'] : false);

		if (!is_array($items)) {
			return;
		}

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
						$lineupsHome = (isset($homeArray['Lineups'])? $homeArray['Lineups'] : false);
						$lineupsAway = (isset($awayArray['Lineups'])? $awayArray['Lineups'] : false);

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

									echo $playerID;

									$stmt->bindParam(':player_id', $playerID);

									$stmt->execute();

								}



							}


						}
						$stmt = NULL; // closes the connection

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
						$stmt = NULL; // closes the connection

				}

			}
		}
	}

	echo "getting_line_ups => success";
}

?>
