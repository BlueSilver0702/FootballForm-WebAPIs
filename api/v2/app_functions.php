<?php
/*
define('APNS_CERT_PACK_DIST', 'apns/aps_production.pem');
define('APNS_CERT_PACK_DEV', 'apns/aps_development.pem');
define('APNS_CERT_PW', 'Createanet');
*/

function utf8_encode_array(&$item, $key){
//    $item = iconv('UTF-8','Windows-1252//TRANSLIT',$item);
$item = mb_convert_encoding( $item,'UTF-8' , 'Windows-1252');
}

function error($message = ''){
header('Content-type: application/json');
	$error = array('response'=>'Error', 'message'=>$message);
	die(json_encode($error));
}
function alert($message = ''){
	$alert = array('response'=>'Alert', 'message'=>$message);
	die(json_encode($alert));
}
function success($data=array()){

	if(!empty($data))
		array_walk_recursive($data, 'utf8_encode_array');
header('Content-type: application/json');
	$success = array('response'=>'Success', 'data'=>$data);
	die(json_encode($success));
}
function strip_html($string){
	$badChars 	= array("\r\n", "\n", "\r", "<p>", "</p>", "<br>", "<br />", "<li>", "</li>", "&nbsp;");
	$goodChars 	= array("", "", "", "", "\n\n", "\n\n", "\n\n", "- ", "\n", " ");

	return "" . (rtrim(strip_tags(str_replace($badChars, $goodChars, html_entity_decode($string)), '<p><br>'), "\n\n"));
}

function checkAPIKey($apiKey){
	if($apiKey != APP_API_KEY) error("API Key Incorrect");
}

function checkPassphrase($userId, $passphrase){
	if(crypt($userId, APP_API_SALT) != $passphrase) error('Incorrect passphrase, please try again');
}

function uniqueFilenameInPath($path, $extension, $charLen=6){
	if(substr($path, -1) != '/') 				$path 		.= '/';
	if(substr($extension, 0, 1) != '.') $extension = '.' . $extension;

	$isUnique = false;
	while(!$isUnique){
		$filename = substr(md5(uniqid()), 0, $charLen);
		if(!file_exists($path . $filename . $extension)) $isUnique = true;
	}

	return $path . $filename . $extension;
}
function hashPassword($plainText,$salt=null)
    {
		  define('SALT_LENGTH',16);
	      if ($salt === null)
		  {
			    $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
		  }
		  else
		  {
		        $salt = substr($salt, 0, SALT_LENGTH);
		  }
	  return $salt . sha1($salt . $plainText);
	}
function decryptPassword($key, $data)
{
	if(32 !== strlen($key)) $key = hash('MD5', $key, true);
	$data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
	$padding = ord($data[strlen($data) - 1]);
	return substr($data, 0, -$padding);
}

function authenticate($user_id,$pass,$token)
{
	global $dbconn;
	if(!isset($token) || ($token != 'dfd-sdh-fj--dfj--d-s-sd-sd-st-hsfg-jsf-sfgh-sf-5r-h-se-h-dsth-td' && $token != 'sa908at0wea4t00sortoesr0awetq-awtpert')){
	    header('WWW-Authenticate: Basic realm="GirlSafe API"');
	    header('HTTP/1.0 401 Unauthorized');
   		error('Secret Key Not Supplied or Incorrect');
    	exit;

	}else{
	if(!isset($user_id) || !isset($pass)){
	    header('WWW-Authenticate: Basic realm="GirlSafe API"');
	    header('HTTP/1.0 401 Unauthorized');
   		error('Sorry you cant access this page');
    	exit;
	}else{
		$checkQuery = $dbconn->query("SELECT email,password FROM customer WHERE id = '{$user_id}'");
		$checkQuery->setFetchMode(PDO::FETCH_ASSOC);
		$customer = $checkQuery->fetch();
	$pass = hashPassword($pass,$customer['password']);
	if($pass != $customer['password']){
	    header('WWW-Authenticate: Basic realm="GirlSafe API"');
	    header('HTTP/1.0 401 Unauthorized');
   		error('Sorry you cant access this page');
    	exit;
	}
	}
	}
}

function actuallyStripHtml($text){
	return trim(html_entity_decode(str_replace('&rsquo;', "'", str_replace('&mdash;', '-', str_replace('&ndash;', '-', strip_tags(str_replace("</p>", "\n", $text)))))));
}

// Image Helpers
function imageURLForImageType($imageName, $imagePathPrefix, $imageType=''){
	if($imageType != '') $imageType = '_' . $imageType;
	$devicePathComponent = (DEVICE_MODEL == 'iPad' || DEVICE_MODEL == 'iPad Simulator') 	? "ipad{$imageType}/" : "iphone{$imageType}/";
	$retinaPathComponent = (DEVICE_SCREEN_SCALE < 2) 	? NON_RETINA_IMAGE_PATH_COMPONENT : RETINA_IMAGE_PATH_COMPONENT;

	$returnURL = $imagePathPrefix . $devicePathComponent . $retinaPathComponent . $imageName;

	return $returnURL;
}


// APNS

function getDeviceTokenForUser($vUser){
	if(is_numeric($vUser)){
		$query = 'SELECT device_token FROM app_users WHERE id = "' . mysql_real_escape_string($vUser) . '" LIMIT 1';
	}else{
		$query = 'SELECT device_token FROM app_users WHERE username = "' . mysql_real_escape_string($vUser) . '" LIMIT 1';
	}
	$result = mysql_query($query);
	if(mysql_num_rows($result) == 0) return false;
	$row = mysql_fetch_assoc($result);
	return $row['device_token'];
}

function sendAPNS($vDeviceToken, $message,$data =  false){

	if(strlen($vDeviceToken) < 64){
		$vDeviceToken = getDeviceTokenForUser($vDeviceToken);
	}

	// Production
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', APNS_CERT_PACK_DIST);
	stream_context_set_option($ctx, 'ssl', 'passphrase', APNS_CERT_PW);
	$fp = stream_socket_client(
		'ssl://gateway.push.apple.com:2195', $err,
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
	//echo $result;
	if (!$result) return false;
	fclose($fp);


	// Development
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', APNS_CERT_PACK_DEV);
	stream_context_set_option($ctx, 'ssl', 'passphrase', APNS_CERT_PW);
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

	return true;

}


function doAlert($user_id, $lat, $lng, $alertType, $alertId){




	global $dbconn;

	$user = getAlertData($user_id, $alertId);



	$errors = array();


	foreach ($user['phones'] as $phone) {

		try {
			mBlox::sendSMS($phone, $user['name'], $user['phone'], $user['lat'], $user['lng'], $alertId);
		} catch (mBoxException $e){

			$error = "Unknown error";

			switch ($e->getCode()) {
				case mBoxException::EX_INVALID_LOCATION:
					$error = 'Location invalid';
					break;
				case mBoxException::EX_INVALID_UKNUMBER:
					$error = 'Invalid UK number';
					break;
			}

			$errors[] = $error;

		}
	}

	$query = "UPDATE alerts SET date_complete = NOW(), alert_raised = 'Y' WHERE id = {$alertId}";
	$dbconn->query($query);

	if(count($errors) > 0){
		$out = array('message'=> implode(', ', $errors));
		error($out);
	}

}

/*
	Gets an array of data for a given user ID
*/
function getAlertData($userId, $alertId){
	global $dbconn;

	$alertId = (int)$alertId;
	$userId = (int)$userId;

	$query = "SELECT c.firstname, c.surname, c.phone, li.lat, li.lng
				FROM customer c
				LEFT OUTER JOIN (
					SELECT user_id, lat, lng
					FROM location
					WHERE user_id = {$userId}
					ORDER BY time_now DESC
					LIMIT 1
				) as li ON (li.user_id = c.id)
				WHERE c.id = {$userId}";

	$result = $dbconn->query($query);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$user = $result->fetch();

	$user['name'] = $user['firstname'] . ((strlen($user['surname']) > 0) ? ' ' . $user['surname'] : '');

	$query = "SELECT phone
				FROM alert_numbers al
				WHERE al.alert_id = {$alertId}";

	$user['phones'] = array();
    foreach ($dbconn->query($query) as $row) {
    	$user['phones'][] = $row['phone'];
    }

	$query = "SELECT a.alert_type
				FROM alerts a
				WHERE a.id = {$alertId}";

	$result = $dbconn->query($query);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$alert = $result->fetch();

	$user['alert_type'] = $alert['alert_type'];
	$user['alert_id'] = $alertId;


	return $user;
}

?>