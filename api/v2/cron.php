<?php

// getting_countries gets the countries based on what season
// getting_leagues cycles through the countries, pulls their id's and then gets the leagues
// getting_standings gets the league table
// getting_teams_per_league gets all teams in the leagues
// mark_leagues_to_show_on_app looks at the teams_standings table, sees what we have data for and then updates the should_show_on_app field in leagues to Y as we have data for it

//exit();


$start_time = time();

error_reporting(0);
set_time_limit(2400); //25 minutes just as a precaution

$root = "/home/football/www/";

include $root.'dbconnect_live_scores.php';
include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';


$query = $dbconn_mysql->prepare("SELECT * FROM should_run_flag");
$query->execute();
$row = $query->fetchAll();
$query = NULL; // closes the connection
$date_flag_updated = $row[0]['date_flag_updated'];

$now = date("Y-m-d H:i:s");

$mins = round((strtotime($now) - strtotime($date_flag_updated)) /60);

if($mins>90) {
	$query = $dbconn_mysql->prepare("UPDATE should_run_flag SET flag='Y' WHERE id=0");
	$query->execute();

	$query = NULL; // closes the connection
}

register_shutdown_function( "fatal_handler" );

function fatal_handler() {

	global $dbconn_mysql;

	$error = error_get_last();

  	if($error !== NULL) {

	    $errno   = $error["type"];
	    $errfile = $error["file"];
	    $errline = $error["line"];
	    $errstr  = $error["message"];

	    $query = $dbconn_mysql->prepare("UPDATE should_run_flag SET flag='Y' WHERE id=0");
		$query->execute();

		$query = NULL; // closes the connection

		writeError(print_r($error, true));
  	}
}



$query = $dbconn_mysql->prepare("SELECT * FROM should_run_flag");
$query->execute();
$row = $query->fetchAll();
$run = $row[0]['flag'];

// REMOVE BY MATT - trying to resolve server issues 19-02-15
// if($run=='N') exit();

$cron_count = $row[0]['cron_count'];


$query = $dbconn_mysql->prepare("UPDATE should_run_flag SET cron_count=cron_count+1, flag='N', date_flag_updated=NOW() WHERE id=0");
$query->execute();

$query = NULL; // closes the connection

runScript('get_live_scores', true);
//runScript('get_if_should_push', true);

//was 30, reducing to 22 as per clients request to fetch results more often
if($cron_count<22) {

	$query = $dbconn_mysql->prepare("UPDATE should_run_flag SET flag='Y' WHERE id=0");
	$query->execute();

	$query = NULL; // closes the connection

	exit();
}

$query = $dbconn_mysql->prepare("UPDATE should_run_flag SET cron_count=0 WHERE id=0");
$query->execute();

$query = NULL; // closes the connection

//runScript('getting_line_ups_scrape'); //Just for the weekend

runScript('getting_standings');
runScript('get_fixtures_for_current_week');
sleep(92);
//Putting this here as we need to sleep 90 seconds as our automatic way of detecting that wont work
//as the the get_fixtures_for_current_week takes at least 5 minutes to run and needs to sleep after for the following script
//and thought it would be nicer to sleep in here so the script can run independently aswell and not take as long.
runScript('getting_players');
runScript('getting_todays_results');
runScript('getting_line_ups');
runScript('getting_sub_leagues', true);
#runScript('calculate_how_many_leagues_have_data_in_country', true);
runScript('calculate_how_many_subleagues_per_league', true);
runScript('create_form_players_table', true);
runScript('mark_countries_to_show_on_app', true);
runScript('mark_leagues_to_show_on_app', true);
runScript('create_android_database', true);
runScript('update_team_names_english_premier_league', true);
//runScript('update_continents');

zipItUp();

//runScript('scrape_data');

$query = $dbconn_mysql->prepare("UPDATE should_run_flag SET flag='Y' WHERE id=0");
$query->execute();

function runScript($scriptName, $skipSleep = false) {

	global $dbconn;

	echo $scriptName."\n ";

	$start_time = time();

	try {

		include $scriptName.'.php';

	} catch (Exception $e) {

		writeError($e);

	}

	if(!$skipSleep) {

		$end_time = time();
		$time_dif = $end_time-$start_time;
		$timeran = 92-$time_dif;
		echo " sleeping {$timeran} ";

		if($timeran>0) {
			sleep($timeran);
		} else {
			sleep(1);
		}

	}
}

function writeError($e) {

	print_r($e);

	$errorMessage = $e->getMessage().' '.$e->getFile();
	$file = 'error.txt';
	file_put_contents($file, $errorMessage, FILE_APPEND | LOCK_EX);
}

function zipItUp() {

	global $root;

	$zip = new ZipArchive();

	$DelFilePath="{$root}football_form_database_new.db.zip";

	if(file_exists($DelFilePath)) {
	    unlink($DelFilePath);
	}
	
	$zip->open($DelFilePath, ZIPARCHIVE::CREATE);
	$zip->addFile("{$root}football_form_database_new.db", "football_form_database_new.db");

	$zip->close();

}

