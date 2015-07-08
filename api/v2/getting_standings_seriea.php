<?php

/*
	Matt: I've added a column sub_league - as some teams seems to be getting added with other teams
	I'm guessing this is because there league_id is the same as another sub_league
*/

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

//getStandingData(30898);


getTheStandings();

function getTheStandings() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	$query = $dbconn->prepare("SELECT * FROM league");
	$query->execute();

	$row = $query->fetchAll();

	foreach ($row as $leagueData) {

		$league_id = $leagueData['id'];
		

		getStandingData($league_id);

		$query = $dbconn->prepare("SELECT * FROM sub_league WHERE league_id=$league_id");
		$query->execute();

		$row = $query->fetchAll();

		foreach ($row as $leagueData) {

			$sub_league_id = $leagueData['id'];

			getStandingData($sub_league_id);

		}

	}
}


function getStandingData($league_id) {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=7&s=1&l='.$league_id.'';

	echo $url."\n\n";
	

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

	$items = $json['list']['Sport'];

	$query = "REPLACE INTO team_positions (id,team_name,league_id,teams_id,position, points, total_played_amount, total_win, total_draw,
					total_lose, total_goals_for, total_goals_against, home_win, home_draw, home_lose, home_total_goals_for,
					home_total_goals_against, away_win, away_draw, away_lose, away_total_goals_for, away_total_goals_against,
					goal_difference, team_home_points, team_away_points, date_updated)
				values
				(:id, :team_name, $league_id, :teams_id, :position, :points, :total_played_amount, :total_win, :total_draw,
					:total_lose, :total_goals_for, :total_goals_against, :home_win, :home_draw, :home_lose, :home_total_goals_for,
					:home_total_goals_against, :away_win, :away_draw, :away_lose, :away_total_goals_for, :away_total_goals_against,
					:goal_difference, :team_home_points, :team_away_points, :now_alt)";
	
	$stmt = $dbconn->prepare($query);

	foreach($items as $key) {

		$item = $key;

		print_r($items);

		return;

		if(!isset($item['Table']['Teams'])) {

			echo " skipped {$league_id}\n\n\n\n";
			continue;

		} else {

			echo " actually working {$league_id}\n\n\n\n";
		}

		$items = $item['Table']['Teams'];

		foreach($items as $key) {

			$item = $key;
			//Group -1
			$position_value = $item['p'];
			$team_name_value = $item['tn'];
			$team_id_value = $item['id'];
			$total_played_value = $item['1'];
			//Group 1
			$home_win_value = $item['2'];
			$home_draw_value = $item['3'];
			$home_lose_value = $item['4'];
			$home_goals_for_value = $item['5'];
			$home_goals_against_value = $item['6'];
			//Group 2
			$away_win_value = $item['7'];
			$away_draw_value = $item['8'];
			$away_lose_value = $item['9'];
			$away_goals_for_value = $item['10'];
			$away_goals_against_value = $item['11'];
			//Group 3
			$total_win_value = $item['12'];
			$total_draw_value = $item['13'];
			$total_lose_value = $item['14'];
			$total_goals_for_value = $item['15'];
			$total_goals_against_value = $item['16'];
			//Group -1
			$goal_diff_value = $item['17'];
			$points_value = $item['19'];

			$id_of_value = $item['id'];

			$stmt->bindParam(':now_alt', $now_alternative);
			$stmt->bindParam(':position', $position_value);
			$stmt->bindParam(':team_name', $team_name_value);
			$stmt->bindParam(':teams_id', $team_id_value);
			$stmt->bindParam(':total_played_amount', $total_played_value);
			
			$stmt->bindParam(':home_win', $home_win_value);
			$stmt->bindParam(':home_draw', $home_draw_value);
			$stmt->bindParam(':home_lose', $home_lose_value);
			$stmt->bindParam(':home_total_goals_for', $home_goals_for_value);
			$stmt->bindParam(':home_total_goals_against', $home_goals_against_value);

			$stmt->bindParam(':away_win', $away_win_value);
			$stmt->bindParam(':away_draw', $away_draw_value);
			$stmt->bindParam(':away_lose', $away_lose_value);
			$stmt->bindParam(':away_total_goals_for', $away_goals_for_value);
			$stmt->bindParam(':away_total_goals_against', $away_goals_against_value);

			$stmt->bindParam(':total_win', $total_win_value);
			$stmt->bindParam(':total_draw', $total_draw_value);
			$stmt->bindParam(':total_lose', $total_lose_value);
			$stmt->bindParam(':total_goals_against', $total_goals_against_value);
			$stmt->bindParam(':total_goals_for', $total_goals_for_value);
			
			$stmt->bindParam(':goal_difference', $goal_diff_value);
			$stmt->bindParam(':points', $points_value);

			//Now lets work out the points for home and away
			$totalHomePoints = ($home_win_value * 3) + $home_draw_value;

			$totalAwayPoints = ($away_win_value * 3) + $away_draw_value;

			$stmt->bindParam(':team_home_points', $totalHomePoints);
			$stmt->bindParam(':team_away_points', $totalAwayPoints);
			$stmt->bindParam(':id', $id_of_value);

			//$stmt->execute();

			$querya = "REPLACE INTO teams (id,name,code,date_added,league_id) values (:id,:name,'NA',:date_added,$league_id)";
			$stmta = $dbconn->prepare($querya);
			$stmta->bindParam(':id', $team_id_value);
			$stmta->bindParam(':name', $team_name_value);
			$stmta->bindParam(':date_added', $now_alternative);
			//$stmta->execute();

			echo $team_id_value.' '. $league_id."\r\n";

			echo '  WORKED  ';

			//print_r($stmt->errorInfo());

		}
	}
}








/*
$item = $items[$key];
				//Group -1
				$position_value = $item['p'];
				$team_name_value = $item['tn'];
				$team_id_value = $item['id'];
				$total_played_value = $item['1'];
				//Group 1
				$home_win_value = $item['2'];
				$home_draw_value = $item['3'];
				$home_lose_value = $item['4'];
				$home_goals_for_value = $item['5'];
				$home_goals_against_value = $item['6'];
				//Group 2
				$away_win_value = $item['7'];
				$away_draw_value = $item['8'];
				$away_lose_value = $item['9'];
				$away_goals_for_value = $item['10'];
				$away_goals_against_value = $item['11'];
				//Group 3
				$total_win_value = $item['12'];
				$total_draw_value = $item['13'];
				$total_lose_value = $item['14'];
				$total_goals_for_value = $item['15'];
				$total_goals_against_value = $item['16'];
				//Group -1
				$goal_diff_value = $item['17'];
				$points_value = $item['19'];

				$id_of_value = $item['id'];

				$stmt->bindParam(':now_alt', $now_alternative);
				$stmt->bindParam(':position', $position_value);
				$stmt->bindParam(':team_name', $team_name_value);
				$stmt->bindParam(':teams_id', $team_id_value);
				$stmt->bindParam(':total_played_amount', $total_played_value);
				
				$stmt->bindParam(':home_win', $home_win_value);
				$stmt->bindParam(':home_draw', $home_draw_value);
				$stmt->bindParam(':home_lose', $home_lose_value);
				$stmt->bindParam(':home_total_goals_for', $home_goals_for_value);
				$stmt->bindParam(':home_total_goals_against', $home_goals_against_value);

				$stmt->bindParam(':away_win', $away_win_value);
				$stmt->bindParam(':away_draw', $away_draw_value);
				$stmt->bindParam(':away_lose', $away_lose_value);
				$stmt->bindParam(':away_total_goals_for', $away_goals_for_value);
				$stmt->bindParam(':away_total_goals_against', $away_goals_against_value);

				$stmt->bindParam(':total_win', $total_win_value);
				$stmt->bindParam(':total_draw', $total_draw_value);
				$stmt->bindParam(':total_lose', $total_lose_value);
				$stmt->bindParam(':total_goals_against', $total_goals_against_value);
				$stmt->bindParam(':total_goals_for', $total_goals_for_value);
				
				$stmt->bindParam(':goal_difference', $goal_diff_value);
				$stmt->bindParam(':points', $points_value);

				//Now lets work out the points for home and away
				$totalHomePoints = ($home_win_value * 3) + $home_draw_value;

				$totalAwayPoints = ($away_win_value * 3) + $away_draw_value;

				$stmt->bindParam(':team_home_points', $totalHomePoints);
				$stmt->bindParam(':team_away_points', $totalAwayPoints);
				$stmt->bindParam(':id', $id_of_value);

				//$stmt->execute();

				$querya = "REPLACE INTO teams (id,name,code,date_added,league_id) values (:id,:name,'NA',:date_added,$league_id)";
				$stmta = $dbconn->prepare($querya);
				$stmta->bindParam(':id', $team_id_value);
				$stmta->bindParam(':name', $team_name_value);
				$stmta->bindParam(':date_added', $now_alternative);
				*/
?>
