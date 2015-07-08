<?php

include "../../lib/GCMPushMessage.php";

$apiKey = "AIzaSyCn8CJARTIXD9DeOaLUZOmpfAXKmgNPejI";
$devices = array('APA91bEAKtjkfMhBGmT7WTvaBT_4KKyvoiGzeIB91TdjHKZFm79X-zMvnO0_NEMLkNCms02rNveBt69jcBaotauOiYxhflJTZqVz2b97a-p8ZseRgKI7DWr2DReqONicbJ3lisdFcx13iYWoHamEt5ME4FLgH3bspcKvAxzyRPCq9zxzQ_2MHoI');
$message = "Test Message";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($message, array('title' => 'Test title'));

echo $response;
