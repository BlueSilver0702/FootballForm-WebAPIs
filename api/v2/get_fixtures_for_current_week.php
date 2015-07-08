<?php

set_time_limit(2400);

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

getFixturesFor5Days();
sleep(92);
getFixturesFor10Days();
sleep(92);
getFixturesFor15Days();
sleep(92);
getFixturesFor20Days();
/*sleep(92);
getFixturesFor25Days();
sleep(92);
getFixturesFor30Days();
sleep(92);
getFixturesFor35Days();*/

function getFixturesFor5Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d');
	$end_date = date('Y-m-d', strtotime('+5 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor5Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

			}
		}
	}

}

function getFixturesFor10Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d', strtotime('+5 days'));
	$end_date = date('Y-m-d', strtotime('+10 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor10Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

				}
				$stmt = NULL;
		}
	}

}

function getFixturesFor15Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d', strtotime('+10 days'));
	$end_date = date('Y-m-d', strtotime('+15 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor15Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

				}
				$stmt = NULL;
		}
	}

}

function getFixturesFor20Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d', strtotime('+15 days'));
	$end_date = date('Y-m-d', strtotime('+20 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor20Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

				}

				$stmt = NULL;
		}
	}

}


function getFixturesFor25Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d', strtotime('+20 days'));
	$end_date = date('Y-m-d', strtotime('+25 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor25Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

				}
				$stmt = NULL;
			}
	}

}

function getFixturesFor30Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d', strtotime('+25 days'));
	$end_date = date('Y-m-d', strtotime('+30 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor30Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

				}

				$stmt = NULL;

		}
	}

}

function getFixturesFor35Days() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');

	//type 3 is month, type 4 is week and type 2 is today
	//$url = 'http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=4&s=1';

	$start_date = date('Y-m-d', strtotime('+30 days'));
	$end_date = date('Y-m-d', strtotime('+35 days'));

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=5&s=1&tz=Europe/London&start={$start_date}&end={$end_date}";

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

	echo "getFixturesFor35Days() => data success\n";

	if(isset($json['error']) && $json['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {

		echo $json['error'];
		die();

	}

	curl_close($cURL);

	$items = $json['list']['Sport'];

		foreach($items as $key) {

			$items = $key['Matchday'];

			foreach($items as $match_day) {

				$date = $match_day['date'];
				$items = $match_day['Match'];

				$stmt = $dbconn->prepare("REPLACE INTO fixtures (id,teams_home_id, teams_home_name, team_home_standing, teams_away_id, teams_away_name, team_away_standing, league_id, league_type, fixture_date, start_time, notes, date_updated, league_sort, status) values (:id,:teams_home_id, :teams_home_name, :team_home_standing, :teams_away_id, :teams_away_name, :team_away_standing, :league_id, :league_type, :fixture_date, :start_time, :notes, :now_alt, :league_sort, :status)");

				$stmt->bindParam(':fixture_date', $date);

				foreach($items as $item) {

					$stmt->bindParam(':id', $item['id']);
					$stmt->bindParam(':now_alt', $now_alternative);
					$stmt->bindParam(':league_id', $item['leagueCode']);
					$stmt->bindParam(':league_sort', $item['leagueSort']);
					$stmt->bindParam(':league_type', $item['leagueType']);

					$stmt->bindParam(':start_time', $item['startTime']);

					$stmt->bindParam(':status', $item['status']);

					$stmt->bindParam(':teams_home_id', $item['Home']['id']);
					$stmt->bindParam(':teams_home_name', $item['Home']['name']);
					$stmt->bindParam(':team_home_standing', $item['Home']['standing']);

					$stmt->bindParam(':teams_away_id', $item['Away']['id']);
					$stmt->bindParam(':teams_away_name', $item['Away']['name']);
					$stmt->bindParam(':team_away_standing', $item['Away']['standing']);

					$stmt->bindParam(':notes', $item['Information']['note']);

					$homid = $item['Home']['id'];

					if(is_numeric($homid)&&$homid!=0) $stmt->execute();

			}
			$stmt = NULL;
		}
	}

}

?>
