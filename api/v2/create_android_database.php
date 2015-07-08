<?php

set_time_limit(120);

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

$tables = array(
	"countries" => array(
		"id" => "_id",
		"name" => "name",
		"code" => "code",
		"date_updated" => "date_updated",
		"season_id" => "season_id",
		"should_show_on_app" => "should_show_on_app",
		"continent" => "continent",
		"no_of_leagues_with_data" => "no_of_leagues_with_data"
		),
	"fixtures" => array(
		"id" => "_id",
		"teams_home_id" => "teams_home_id",
		"teams_home_name" => "teams_home_name",
		"team_home_score" => "team_home_score",
		"team_home_standing" => "team_home_standing",
		"teams_away_id" => "teams_away_id",
		"teams_away_name" => "teams_away_name",
		"team_away_score" => "team_away_score",
		"team_away_standing" => "team_away_standing",
		"league_id" => "league_id",
		"league_type" => "league_type",
		"league_sort" => "league_sort",
		"fixture_date" => "fixture_date",
		"start_time" => "start_time",
		"notes" => "notes",
		"date_updated" => "date_updated",
		"status" => "status"
		),
	"goals_scored" => array(
		"id" => "_id",
		"match_id" => "match_id",
		"team_id" => "team_id",
		"player_id" => "player_id",
		"player_name" => "player_name",
		"time_scored_in" => "time_scored_in",
		"date_added" => "date_added",
		"type" => "type",
		"period" => "period",
		"team_side" => "team_side"
		),
	"league" => array(
		"id" => "_id",
		"name" => "name",
		"sort" => "sort",
		"code" => "code",
		"season_id" => "season_id",
		"country_id" => "country_id",
		"comp_start" => "comp_start",
		"comp_end" => "comp_end",
		"date_added" => "date_added",
		"sorting_order" => "sorting_order",
		"description" => "description",
		"should_show_on_app" => "should_show_on_app",
		"has_subleague" => "has_subleague"
		),
	"line_up_and_history_id" => array(
		"id" => "_id",
		"code" => "code",
		"hid" => "hid",
		"name" => "name",
		"date_added" => "date_added",
		"lineup_hid" => "lineup_hid"
		),
	"line_ups" => array(
		"player_id" => "player_id",
		"match_id" => "match_id",
		"team_id" => "team_id",
		"fixture_date" => "fixture_date",
		"date_updated" => "date_updated"
		),
	"players" => array(
		"id" => "_id",
		"name" => "name",
		"team_id" => "team_id",
		"team_name" => "team_name",
		"date_added" => "date_added",
		"league_id" => "league_id"
		),
	"players_deleted" => array(
		"id" => "_id",
		"name" => "name",
		"team_id" => "team_id",
		"team_name" => "team_name",
		"date_added" => "date_added",
		"league_id" => "league_id"
		),
	"rss_feed_links" => array(
		"id" => "_id",
		"name" => "name",
		"url" => "url"
		),
	"seasons" => array(
		"id" => "_id",
		"name" => "name",
		"code" => "code",
		"date_updated" => "date_updated"
		),
	"sub_league" => array(
		"id" => "_id",
		"name" => "name",
		"code" => "code",
		"sort" => "sort",
		"type" => "type",
		"country_id" => "country_id",
		"comp_start" => "comp_start",
		"comp_end" => "comp_end",
		"date_added" => "date_added",
		"description" => "description",
		"league_id" => "league_id"
		),
	"team_positions" => array(
		"id" => "_id",
		"league_id" => "league_id",
		"teams_id" => "teams_id",
		"team_name" => "team_name",
		"position" => "position",
		"points" => "points",
		"team_home_points" => "team_home_points",
		"team_away_points" => "team_away_points",
		"total_played_amount" => "total_played_amount",
		"total_win" => "total_win",
		"total_draw" => "total_draw",
		"total_lose" => "total_lose",
		"total_goals_for" => "total_goals_for",
		"total_goals_against" => "total_goals_against",
		"goal_difference" => "goal_difference",
		"home_win" => "home_win",
		"home_draw" => "home_draw",
		"home_lose" => "home_lose",
		"home_total_goals_for" => "home_total_goals_for",
		"home_total_goals_against" => "home_total_goals_against",
		"away_win" => "away_win",
		"away_draw" => "away_draw",
		"away_lose" => "away_lose",
		"away_total_goals_for" => "away_total_goals_for",
		"away_total_goals_against" => "away_total_goals_against",
		"date_updated" => "date_updated",
		"logoID" => "logoID"
		),
	"teams" => array(
		"id" => "_id",
		"name" => "name",
		"code" => "code",
		"is_favourite" => "is_favourite",
		"date_added" => "date_added",
		"league_id" => "league_id",
		"logoID" => "logoID"
		),
	"yellow_cards" => array(
		"id" => "_id",
		"match_id" => "match_id",
		"team_id" => "team_id",
		"player_id" => "player_id",
		"player_name" => "player_name",
		"time_player_got_card" => "time_player_got_card",
		"recieved_at" => "recieved_at",
		"date_added" => "date_added",
		"type" => "type"
		),
	"last_5_games" => array(
		"league_id" => "league_id",
		"team_id" => "team_id",
		"results" => "results"
		),
	"form_players_view" => array(
		"player_id" => "player_id",
		"player_name" => "player_name",
		"team_name" => "team_name",
		"team_id" => "team_id",
		"p1_goals" => "p1_goals",
		"p2_goals" => "p2_goals",
		"appearances" => "appearances",
		"type" => "type",
		"league_id" => "league_id"
		)

	);

$dbconn_android->exec("ATTACH '/home/football/public_html/football_form_database_new.db' AS ios_db");

$dbconn_android->beginTransaction();

try {
	foreach ($tables as $table_name => $table_columns) {
		$dbconn_android->exec("DELETE FROM {$table_name}");
		$query = "INSERT INTO main.{$table_name} (";
		$tmp = array();
		foreach ($table_columns as $ios_col_name => $android_col_name) {
			$tmp[] = " `{$android_col_name}` ";
		}
		$query .= implode(',', $tmp);
		$query .= ") SELECT ";
		$tmp = array();
		foreach ($table_columns as $ios_col_name => $android_col_name) {
			$tmp[] = " `{$ios_col_name}` AS `{$android_col_name}` ";
		}
		$query .= implode(',', $tmp);
		$query .= " FROM ios_db.{$table_name}";
		$dbconn_android->exec($query);

	}
} catch (PDOException $e) {
	print_r($e);
}

$dbconn_android->commit();
$dbconn_android->exec("VACUUM");

$dbconn_android = NULL;

zipItUpAndroid();

function zipItUpAndroid() {

	global $root;

	$zip = new ZipArchive();

	$DelFilePath="{$root}football_form_database_android.db.zip";

	if(file_exists($DelFilePath)) {

	    unlink($DelFilePath);

	}

	if ($zip->open($DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {

		mail('matt@createanet.co.uk', 'FOOTBALL FORM ANDROID ZIP ISSUE', 'FOOTBALL FORM ANDROID ZIP ISSUE');

	}

	$zip->addFile("{$root}football_form_database_android.db", "football_form_database_android.db");

	print_r($zip);

	$zip->close();

}

