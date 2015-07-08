<?php
//fed254e09be1aece749cc81fad3419a6aaf14bcba29f2b02f75d92ce87eaf0c6

//production 4cfdd81e8fbd5565c2fe49e6dd8a7cdbf263efe3a96548452b4c9f3223fd7d55
sendAPNS('4cfdd81e8fbd5565c2fe49e6dd8a7cdbf263efe3a96548452b4c9f3223fd7d55', 'testing');

echo 'test';

function sendAPNS($vDeviceToken, $message) {

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