<?php

$root = "/home/football/www/";

$apiKey = "AIzaSyCn8CJARTIXD9DeOaLUZOmpfAXKmgNPejI";

include_once $root.'lib/GCMPushMessage.php';
include_once $root.'dbconnect_new.php';
include_once $root.'dbconnect_live_scores.php';
require_once $root.'api/v2/app_functions.php';

startPushCheck();

function startPushCheck() {

	global $dbconn_mysql;
	global $dbconn;
	global $apiKey;

	$gcpm = new GCMPushMessage($apiKey);

	$query = $dbconn_mysql->prepare("SELECT ls.match_id, ls.player_id, ls.name, ls.time, upn.device_token, ls.team_id, upn.device_type AS device_type FROM live_scorers ls, users_push_notifications upn WHERE ls.team_id=upn.team_id");

	$query->execute();
	$data = $query->fetchAll();

	foreach ($data as $gameData) {


		$name = $gameData['name'];
		$tid = $gameData['team_id'];
		$mid = $gameData['match_id'];
		$suf = suffixAddition($gameData['time']);

		$tnquery = $dbconn->prepare("SELECT * FROM teams WHERE id = ? LIMIT 1");
		$tnquery->execute(array($tid));

		$rowtn = $tnquery->fetchAll();

		$query = $dbconn_mysql->prepare("SELECT * FROM sent_pushes WHERE team_id=? AND match_id=? AND time=? AND player_name=?");
		$query->execute(array($tid, $mid, $suf, $name));

		$row = $query->fetchAll();
		$co = count($row);

		//$co=0;
		if($co==0) {

			$tn = $rowtn[0]['name'];

			if(!$tn) {

				$message = "{$name} just scored in the {$suf} minute!";

			} else {

				$message = "{$name} ($tn) just scored in the {$suf} minute!";

			}

			if($gameData['device_type']=='ANDROID') {

				$devices = array($gameData['device_token']);

				$gcpm->setDevices($devices);
				$response = $gcpm->send($message, array());

			} else {

				sendAPNSProduction($gameData['device_token'], $message);
			}

			

			$query = $dbconn_mysql->prepare("INSERT INTO sent_pushes (team_id, match_id, time, player_name) VALUES (?,?,?,?)");
			$query->execute(array($tid, $mid, $suf, $name));

		}
	}
}

function suffixAddition($number) {
    
    $ones = $number % 10;
    $temp = floor($number/10.0);
    $tens = $temp%10;
    
    if ($tens ==1) {
        $suffix = @"th";
    } else if ($ones ==1){
        $suffix = @"st";
    } else if ($ones ==2){
        $suffix = @"nd";
    } else if ($ones ==3){
        $suffix = @"rd";
    } else {
        $suffix = @"th";
    }
    
    return $number.$suffix;
}

function sendAPNSProduction($vDeviceToken, $message) {

	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns/ckprod.pem');
	stream_context_set_option($ctx, 'ssl', 'passphrase', 'Createanet');
	$fp = stream_socket_client(
		'ssl://gateway.push.apple.com:2195', $err,
		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	

	if (!$fp) return false;
	$body['aps'] = array(
		'alert' => $message,
		'sound' => 'default',
		'badge' => 1
		);

	/* This was causing the error 'undefined variable' which makes perfect sense as data isn't passed in or anything...
	Have commented out for now.
	if ($data != false) {
		foreach ($data as $key => $value) {
			$body[$key] = $value;
		}
	}
	*/
	
	$payload = json_encode($body);
	$msg = chr(0) . pack('n', 32) . pack('H*', $vDeviceToken) . pack('n', strlen($payload)) . $payload;
	$result = fwrite($fp, $msg, strlen($msg));
	if (!$result) return false;
	fclose($fp);

}

function sendAPNSSandbox($vDeviceToken, $message) {

	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns/ck.pem');
	stream_context_set_option($ctx, 'ssl', 'passphrase', 'Createanet');
	$fp = stream_socket_client(
		'ssl://gateway.sandbox.push.apple.com:2195', $err,
		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp) return false;
	$body['aps'] = array(
		'alert' => $message,
		'sound' => 'default',
		'badge' => 1
		);
	if ($data != false) {
		foreach ($data as $key => $value) {
			$body[$key] = $value;
		}
	}
	
	$payload = json_encode($body);
	$msg = chr(0) . pack('n', 32) . pack('H*', $vDeviceToken) . pack('n', strlen($payload)) . $payload;
	$result = fwrite($fp, $msg, strlen($msg));
	if (!$result) return false;
	fclose($fp);
}


?>
