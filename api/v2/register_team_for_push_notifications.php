<?php

$root = "/home/football/www/";

include $root.'dbconnect_live_scores.php';
include $root.'dbconnect_new.php';
require_once $root.'api/v1/api_functions.php';

$device_token = (isset($_REQUEST['deviceToken']) && $_REQUEST['deviceToken'] != '') ? $_REQUEST['deviceToken'] : false;
$team_id = (isset($_REQUEST['teamId']) && $_REQUEST['teamId'] != '') ? $_REQUEST['teamId'] : false;
$device_type = (isset($_REQUEST['device_type']) && $_REQUEST['device_type'] != '') ? $_REQUEST['device_type'] : false;

$device_type = ($device_type == 'ANDROID') ? 'ANDROID' : 'IOS';
$remove_device = (isset($_REQUEST['remove_device']) && $_REQUEST['remove_device'] == 'Y');

if(strlen($device_token)!=0) {

	if($remove_device){
		$query = $dbconn_mysql->prepare("DELETE FROM users_push_notifications WHERE team_id = ? AND device_token = ?");
		$query->execute(array($team_id, $device_token));
	} else {
		$query = $dbconn_mysql->prepare("INSERT INTO users_push_notifications (team_id, device_token, device_type, date_updated) VALUES (?, ?, ?, NOW())");
		$query->execute(array($team_id, $device_token, $device_type));
	}

}
