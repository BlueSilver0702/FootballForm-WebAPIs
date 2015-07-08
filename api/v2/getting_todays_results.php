<?php

set_time_limit(1500);

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

$startDate = (isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != '') ? $_REQUEST['start_date'] : false;
$endDate = (isset($_REQUEST['end_date']) && $_REQUEST['end_date'] != '') ? $_REQUEST['end_date'] : false;

getTodaysGamesResults($startDate, $endDate);

function getTodaysGamesResults($startDate, $endDate) {

global $dbconn;

$now_alternative = date('Y-m-d H:m:s');

$date = date('Y-m-d');

if(strtotime($startDate)==0) {
	$startDate = $date;
	$endDate = $date;
}

$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$startDate}&end={$endDate}";

echo $url;

//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=6&s=1&l=26009';
//26009

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
// print_r($json);
curl_close($cURL);

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {
		echo $json['error'];
	} else {

		$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

				foreach($items as $match_day) {

					$date = $match_day['date'];
					$itemss = $match_day['Match'];

					$stmtInsert = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status, team_home_score, team_away_score) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_al, :league_sort, :status, :team_home_score, :team_away_score)");

					$stmtInsert->bindParam(':now_al', $now_alternative);

					$homeTeamScorers =0;
					$awayTeamScorers=0;
					$index = 0;

					foreach($itemss as $matchData) {

						$stmtInsert->bindParam(':fixture_date', $date);

						//$matchData = $itemss[$key];

						$awayID = $matchData['Away']['id'];
						$homeID = $matchData['Home']['id'];

						$homeArray = $matchData['Home'];
						$index = $index +1;
						$mid = $matchData['id'];

						$resultsArray = (isset($matchData['Results']) ? $matchData['Results'] : false);
						$awayArray = (isset($matchData['Away']) ? $matchData['Away'] : false);
						$itemsScorer = (isset($resultsArray['Scorer']) ? $resultsArray['Scorer'] : false);

						$stmtInsert->bindParam(':id', $matchData['id']);

						$stmtInsert->bindParam(':league_id', $matchData['leagueCode']);
						$stmtInsert->bindParam(':league_sort', $matchData['leagueSort']);
						$stmtInsert->bindParam(':league_type', $matchData['leagueType']);

						$stmtInsert->bindParam(':start_time', $matchData['startTime']);

						$stmtInsert->bindParam(':status', $matchData['status']);

						$stmtInsert->bindParam(':teams_home_id', $matchData['Home']['id']);
						$stmtInsert->bindParam(':teams_home_name', $matchData['Home']['name']);
						$stmtInsert->bindParam(':team_home_standing', $matchData['Home']['standing']);


						$stmtInsert->bindParam(':teams_away_id', $matchData['Away']['id']);
						$stmtInsert->bindParam(':teams_away_name', $matchData['Away']['name']);
						$stmtInsert->bindParam(':team_away_standing', $matchData['Away']['standing']);
						$stmtInsert->bindParam(':notes', $matchData['Information']['note']);



						$fullTimeScore = '0-0';

						if(is_array($resultsArray)) {

							foreach($resultsArray as $keyy=>$valuee) {

								$data = $resultsArray[$keyy];

								if (!isset($data['name'])) continue;

								if ($data['name']=='FT') {
									$fullTimeScore = $data['value'];
									echo ' '.$fullTimeScore."\n";
								}
							}

						}

						$scoreArray = explode("-", $fullTimeScore);
						$stmtInsert->bindParam(':team_home_score', $scoreArray[0]);
						$stmtInsert->bindParam(':team_away_score', $scoreArray[1]);

						$homid = $matchData['Home']['id'];

						if(is_numeric($homid)&&$homid!=0) {

						    if (!$stmtInsert->execute()) {

	    					}

	    				}


						$cardsHome = (isset($homeArray['Cards']['Card']) ? $homeArray['Cards']['Card'] : false);
						$cardsAway = (isset($awayArray['Cards']['Card']) ? $awayArray['Cards']['Card'] : false);


						//$cardsHome = $homeArray['Cards']['Card'];
						//$cardsAway = $awayArray['Cards']['Card'];



						$stmt = $dbconn->prepare("DELETE FROM yellow_cards WHERE match_id='$mid'");
						$stmt->execute();

						if(is_array($cardsHome)) {

							foreach($cardsHome as $key=>$value) {

								$stmt = $dbconn->prepare("INSERT INTO yellow_cards (team_id, match_id, player_id, player_name, time_player_got_card, date_added, type, recieved_at) values (:team_id, :match_id, :player_id, :player_name, :time_player_got_card, :now_al, :type, 'Home')");

								$cardData = $cardsHome[$key];
								$playerName = $cardData['name'];
								$time = $cardData['time'];
								$type = $cardData['type'];
								$player_id = $cardData['p_id'];

								if(strlen($playerName)==0) {

								$playerName = 'UNKNOWN';

								}

								$stmt->bindParam(':now_al', $now_alternative);
								$stmt->bindParam(':team_id', $homeArray['id']);
								$stmt->bindParam(':match_id', $mid);
								$stmt->bindParam(':player_id', $player_id);
								$stmt->bindParam(':player_name', $playerName);
								$stmt->bindParam(':time_player_got_card', $time);
								$stmt->bindParam(':type', $type);

								if($player_id != 0) {
									$stmt->execute();
								}
							}
						}

						if(is_array($cardsAway)) {

							foreach($cardsAway as $key=>$value) {

								$stmt = $dbconn->prepare("INSERT INTO yellow_cards (team_id, match_id, player_id, player_name, time_player_got_card, date_added, type, recieved_at) values (:team_id, :match_id, :player_id, :player_name, :time_player_got_card, :now_al, :type, 'Away')");


								$cardData = $cardsAway[$key];
								$playerName = $cardData['name'];
								$time = $cardData['time'];
								$type = $cardData['type'];
								$player_id = $cardData['p_id'];

								$stmt->bindParam(':now_al', $now_alternative);
								$stmt->bindParam(':team_id', $awayArray['id']);
								$stmt->bindParam(':match_id', $mid);
								$stmt->bindParam(':player_id', $player_id);
								$stmt->bindParam(':player_name', $playerName);
								$stmt->bindParam(':time_player_got_card', $time);
								$stmt->bindParam(':type', $type);

								if($player_id != 0) {
									$stmt->execute();
								}
							}
						}

						$homeTeamScorers =0;
						$awayTeamScorers=0;

						$stmt = $dbconn->prepare("DELETE FROM goals_scored WHERE match_id='$mid'");
						$stmt->execute();

						$stmt = $dbconn->prepare("INSERT INTO goals_scored (team_id, match_id, player_id, player_name, time_scored_in, date_added, type, period, team_side) values (:team_id, :match_id, :player_id, :player_name, :time_scored_in, :now_al, :type, :period, :team_side)");


						if(is_array($itemsScorer)) {

							foreach($itemsScorer as $key=>$value) {

								$item = $itemsScorer[$key];

								if($item['team'] == $homeID) {

									$name = $item['name'];
									$period = $item['period'];
									$team_id = $item['team'];
									$time = $item['time'];
									$type = $item['type'];
									$player_id = $item['p_id'];
									$team_side = 'Home';

								} else if($item['team'] == $awayID) {

									$name = $item['name'];
									$period = $item['period'];
									$team_id = $item['team'];
									$time = $item['time'];
									$type = $item['type'];
									$player_id = $item['p_id'];
									$team_side = 'Away';

								}


								$stmt->bindParam(':now_al', $now_alternative);
								$stmt->bindParam(':team_id', $team_id);
								$stmt->bindParam(':match_id', $mid);
								$stmt->bindParam(':player_id', $player_id);
								$stmt->bindParam(':player_name', $name);
								$stmt->bindParam(':time_scored_in', $time);
								$stmt->bindParam(':type', $type);
								$stmt->bindParam(':period', $period);
								$stmt->bindParam(':team_side', $team_side);

								if(strlen($name)==0) {
									//print_r($item);
									$name = 'UNKNOWN';

								}

								if($player_id != 0) {
									$stmt->execute();
								}
							}
						}
					}
				}
			}

		echo "getting_todays_results.php => success\n";

	}

}
?>