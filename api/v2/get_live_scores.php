<?php

$root = "/home/football/www/";
include_once $root.'dbconnect_live_scores.php';
require_once $root.'api/v2/app_functions.php';

startScriptyy();

//http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=2&s=1

function startScriptyy() {

	global $dbconn_mysql;

	$url = "http://data2.scorespro.com/exporter/json.php?state=clientUpdate&usr=13creatanet&pwd=RtR67YjK&type=2&s=1";

	echo "Fetching live score...\n";
	echo "{$url}\n";


	$cURL = curl_init();

	curl_setopt($cURL, CURLOPT_URL, $url);
	curl_setopt($cURL, CURLOPT_HTTPGET, true);
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Accept: application/json'
	));

	$result = curl_exec($cURL);
	$json_data = json_decode($result,true);


	#$jsontext ='{"timestamp":1426759177692,"list":{"Sport":{"1":{"id":1,"name":"SOCCER","code":"SOC","hid":"7989238","Matchday":{"2015-03-19":{"date":"2015-03-19","Match":{"1177575":{"ct":"-3","id":"1177575","lastPeriod":"2 HF","leagueCode":"32359","leagueSort":"101","leagueType":"PHASE","startTime":"01:00","status":"Fin","statustype":"fin","type":"2","visible":"1","lineups":"0","Home":{"id":"5541","name":"BANFIELD","standing":""},"Away":{"id":"50024","name":"SOL DE AMERICA FORMO","standing":""},"Results":{"1":{"id":1,"name":"CURRENT","value":"1-0"},"2":{"id":2,"name":"FT","value":"1-0"},"3":{"id":3,"name":"HT","value":"0-0"},"Period":{"1":{"id":1,"name":"1HF","detail":"SCORE","value":"0-0"},"2":{"id":2,"name":"2HF","detail":"SCORE","value":"1-0"},"3":{"id":3,"name":"ET","detail":"SCORE","value":"0-0"},"4":{"id":4,"name":"PEN","detail":"SCORE","value":"0-0"}},"Scorer":[{"name":"BERTOLO N.","period":"2","team":"5541","time":"89","type":"","p_id":"0"}]},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"39665","name":"ARGENTINA"},"parentCompetition":{"id":"39666","name":"FA CUP"},"rootCompetition":{"id":"39665","name":"ARGENTINA"},"league":{"id":"32359","name":"ROUND 64"},"shortName":"ARG-CUP","round":"R64","note":"Knock out.","bitArray":"","timestamp":""}},"1182049":{"ct":"1","id":"1182049","lastPeriod":"2 HF","leagueCode":"29545","leagueSort":"37","leagueType":"PHASE","startTime":"02:30","status":"Fin","statustype":"fin","type":"2","visible":"1","lineups":"0","Home":{"id":"4527","name":"GUADALAJARA-CHIVAS","standing":"","Cards":{"countR":0,"countY":1,"countYR":0,"Card":[{"name":"TORDECILLAS O.","time":"90","type":"Yellow","p_id":"0"}]}},"Away":{"id":"4529","name":"CHIAPAS FC","standing":"","Cards":{"countR":0,"countY":3,"countYR":0,"Card":[{"name":"CERVANTES H.","time":"23","type":"Yellow","p_id":"0"},{"name":"RODRIGUEZ L.","time":"38","type":"Yellow","p_id":"0"},{"name":"ARMENTEROS E.","time":"75","type":"Yellow","p_id":"0"}]}},"Results":{"1":{"id":1,"name":"CURRENT","value":"2-1"},"2":{"id":2,"name":"FT","value":"2-1"},"3":{"id":3,"name":"HT","value":"0-0"},"Period":{"1":{"id":1,"name":"1HF","detail":"SCORE","value":"0-0"},"2":{"id":2,"name":"2HF","detail":"SCORE","value":"2-1"},"3":{"id":3,"name":"ET","detail":"SCORE","value":"0-0"},"4":{"id":4,"name":"PEN","detail":"SCORE","value":"0-0"}},"Scorer":[{"name":"ROMERO S.","period":"2","team":"4529","time":"52","type":"","p_id":"0"},{"name":"REYNA A.","period":"2","team":"4527","time":"63","type":"","p_id":"0"},{"name":"TORRES E.","period":"2","team":"4527","time":"73","type":"","p_id":"0"}]},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40631","name":"MEXICO"},"league":{"id":"29545","name":"SEMI FINALS"},"shortName":"MEX-CCL","round":"SF","note":"Knock out.","bitArray":"","timestamp":""}},"2090703":{"ct":"0","id":"2090703","lastPeriod":"","leagueCode":"101350","leagueSort":"4","leagueType":"LEAGUE","startTime":"10:15","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"102483","name":"SANTURTZI","standing":"8"},"Away":{"id":"101171","name":"CLUB BERMEO","standing":"15"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101350","name":"GRUPO 4"},"shortName":"ESP-TD","round":"25","note":"","bitArray":"","timestamp":""}},"2090702":{"ct":"0","id":"2090702","lastPeriod":"","leagueCode":"101350","leagueSort":"4","leagueType":"LEAGUE","startTime":"11:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"100712","name":"SCD DURANGO","standing":"5"},"Away":{"id":"22033","name":"AMURRIO","standing":"19"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101350","name":"GRUPO 4"},"shortName":"ESP-TD","round":"25","note":"","bitArray":"","timestamp":""}},"2096003":{"ct":"0","id":"2096003","lastPeriod":"","leagueCode":"101364","leagueSort":"15","leagueType":"LEAGUE","startTime":"11:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"100504","name":"UCD BURLADES","standing":"8"},"Away":{"id":"102506","name":"ARDOI","standing":"16"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101364","name":"GRUPO 15"},"shortName":"ESP-TD","round":"23","note":"","bitArray":"","timestamp":""}},"2096005":{"ct":"0","id":"2096005","lastPeriod":"","leagueCode":"101364","leagueSort":"15","leagueType":"LEAGUE","startTime":"11:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"102179","name":"BETI ONAK","standing":"15"},"Away":{"id":"100238","name":"OSASUNA B","standing":"3"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101364","name":"GRUPO 15"},"shortName":"ESP-TD","round":"23","note":"","bitArray":"","timestamp":""}},"1081453":{"ct":"0","id":"1081453","lastPeriod":"","leagueCode":"29716","leagueSort":"10","leagueType":"LEAGUE","startTime":"12:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"37940","name":"VIITORUL CONSTANTA","standing":"8"},"Away":{"id":"23861","name":"PANDURII TG JIU","standing":"10"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40852","name":"ROMANIA"},"league":{"id":"29716","name":"LIGA I"},"shortName":"ROU-L1","round":"22","note":"","bitArray":"","timestamp":""}},"1115255":{"ct":"0","id":"1115255","lastPeriod":"","leagueCode":"31014","leagueSort":"22","leagueType":"LEAGUE","startTime":"13:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"3419","name":"AGROTIKOS ASTERAS","standing":"10"},"Away":{"id":"33227","name":"ANAGENNISI KARDITSA","standing":"11"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40209","name":"GREECE"},"parentCompetition":{"id":"41406","name":"FOOTBALL LEAGUE"},"rootCompetition":{"id":"40209","name":"GREECE"},"league":{"id":"31014","name":"FOOTBALL LEAGUE GROUP 2"},"shortName":"GRE-FL","round":"23","note":"Distance 225Km. Sidelined Players : ANAGENNISI - Gkougkoudis S. (Susp.).","bitArray":"","timestamp":""}},"1152464":{"ct":"0","id":"1152464","lastPeriod":"","leagueCode":"29919","leagueSort":"10","leagueType":"LEAGUE","startTime":"13:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"45359","name":"ESPERANCE ST","standing":"4"},"Away":{"id":"45361","name":"AVENIR S.DE LA MARSA","standing":"8"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41107","name":"TUNISIA"},"league":{"id":"29919","name":"LIGUE 1"},"shortName":"TUN-L1","round":"21","note":"","bitArray":"","timestamp":""}},"1182473":{"ct":"0","id":"1182473","lastPeriod":"","leagueCode":"29502","leagueSort":"10","leagueType":"LEAGUE","startTime":"13:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"41515","name":"GOR MAHIA","standing":"1"},"Away":{"id":"43192","name":"BANDARI","standing":"2"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40570","name":"KENYA"},"league":{"id":"29502","name":"DIVISION 1"},"shortName":"KEN-D1","round":"3","note":"","bitArray":"","timestamp":""}},"1170913":{"ct":"0","id":"1170913","lastPeriod":"","leagueCode":"28978","leagueSort":"13","leagueType":"PHASE","startTime":"13:30","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"46274","name":"LUBUMBASHI SPORT","standing":"5"},"Away":{"id":"46273","name":"SANGA BALENDE","standing":"8"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"39914","name":"CONGO DR"},"league":{"id":"28978","name":"CHAMPIONSHIP PLAY OFF"},"shortName":"COD-PO","round":"5","note":"","bitArray":"","timestamp":""}},"1081441":{"ct":"0","id":"1081441","lastPeriod":"","leagueCode":"29716","leagueSort":"10","leagueType":"LEAGUE","startTime":"14:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"31146","name":"GAZ METAN MEDIAS","standing":"14"},"Away":{"id":"23847","name":"CFR 1907 CLUJ","standing":"18"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40852","name":"ROMANIA"},"league":{"id":"29716","name":"LIGA I"},"shortName":"ROU-L1","round":"22","note":"","bitArray":"","timestamp":""}},"1077334":{"ct":"0","id":"1077334","lastPeriod":"","leagueCode":"30778","leagueSort":"11","leagueType":"LEAGUE","startTime":"14:45","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"5455","name":"OLYMPIAKOS PIRAEUS","standing":"1"},"Away":{"id":"24989","name":"ASTERAS TRIPOLIS","standing":"4"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40209","name":"GREECE"},"parentCompetition":{"id":"41405","name":"SUPER LEAGUE"},"rootCompetition":{"id":"40209","name":"GREECE"},"league":{"id":"30778","name":"SUPER LEAGUE"},"shortName":"GRE-SL","round":"26","note":"Distance 195Km. Sidelined Players : OLYMPIAKOS P. - Durmaz J., Mitroglou K., Maniatis G., Megyeri B., Fuster D. (Injured). ASTERAS TRIPOLIS - Kosicky T., Parra F. (Injured).","bitArray":"","timestamp":""}},"1130404":{"ct":"0","id":"1130404","lastPeriod":"","leagueCode":"29665","leagueSort":"43","leagueType":"PHASE","startTime":"15:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"22843","name":"PODBESKIDZIE","standing":""},"Away":{"id":"28554","name":"PIAST GLIWICE","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40789","name":"POLAND"},"parentCompetition":{"id":"40792","name":"FA CUP"},"rootCompetition":{"id":"40789","name":"POLAND"},"league":{"id":"29665","name":"QUARTER FINALS"},"shortName":"POL-CUP","round":"SECOND LEG","note":"First leg (2-1).","bitArray":"","timestamp":""}},"2100505":{"ct":"0","id":"2100505","lastPeriod":"","leagueCode":"101454","leagueSort":"10","leagueType":"LEAGUE","startTime":"15:00","status":"Post","statustype":"fin","type":"2","visible":1,"lineups":"0","Home":{"id":"102405","name":"ABIA WARRIORS","standing":"13"},"Away":{"id":"39156","name":"DOLPHIN","standing":"14"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"101453","name":"NIGERIA"},"league":{"id":"101454","name":"PREMIER LEAGUE"},"shortName":"NGA-PL","round":"2","note":"","bitArray":"","timestamp":""}},"1147740":{"ct":"0","id":"1147740","lastPeriod":"","leagueCode":"29757","leagueSort":"20","leagueType":"LEAGUE","startTime":"15:30","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"45456","name":"AL-ETTIFAQ","standing":"4"},"Away":{"id":"45472","name":"AL-DRAIH","standing":"13"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40906","name":"SAUDI ARABIA"},"league":{"id":"29757","name":"DIVISION 1"},"shortName":"KSA-D1","round":"28","note":"FT result only.","bitArray":"","timestamp":""}},"2100551":{"ct":"0","id":"2100551","lastPeriod":"","leagueCode":"101423","leagueSort":"10","leagueType":"LEAGUE","startTime":"15:30","status":"Sched","statustype":"sched","type":"1","visible":"0","lineups":"0","Home":{"id":"101512","name":"SEWE SPORTS","standing":"8"},"Away":{"id":"101522","name":"DENGUELE","standing":"12"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"101422","name":"IVORY COAST"},"league":{"id":"101423","name":"LIGUE 1"},"shortName":"CIV-L1","round":"12","note":"","bitArray":"","timestamp":""}},"2095996":{"ct":"0","id":"2095996","lastPeriod":"","leagueCode":"101364","leagueSort":"15","leagueType":"LEAGUE","startTime":"15:45","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"102178","name":"CORELLANO","standing":"19"},"Away":{"id":"100508","name":"CD HUARTE","standing":"10"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101364","name":"GRUPO 15"},"shortName":"ESP-TD","round":"23","note":"","bitArray":"","timestamp":""}},"2090704":{"ct":"0","id":"2090704","lastPeriod":"","leagueCode":"101350","leagueSort":"4","leagueType":"LEAGUE","startTime":"16:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"101880","name":"OIARTZUN KE","standing":"20"},"Away":{"id":"100714","name":"ZALLA UC","standing":"6"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101350","name":"GRUPO 4"},"shortName":"ESP-TD","round":"25","note":"","bitArray":"","timestamp":""}},"2093202":{"ct":"0","id":"2093202","lastPeriod":"","leagueCode":"101356","leagueSort":"8","leagueType":"LEAGUE","startTime":"16:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"102119","name":"ESTRUCTURAS TINO","standing":"13"},"Away":{"id":"102492","name":"VILLA DE SIMANCAS","standing":"18"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101356","name":"GRUPO 8"},"shortName":"ESP-TD","round":"29","note":"","bitArray":"","timestamp":""}},"2096004":{"ct":"0","id":"2096004","lastPeriod":"","leagueCode":"101364","leagueSort":"15","leagueType":"LEAGUE","startTime":"16:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"100506","name":"CD IDOYA","standing":"17"},"Away":{"id":"28699","name":"PENA SPORT","standing":"1"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101364","name":"GRUPO 15"},"shortName":"ESP-TD","round":"23","note":"","bitArray":"","timestamp":""}},"1115099":{"ct":"0","id":"1115099","lastPeriod":"","leagueCode":"31013","leagueSort":"21","leagueType":"LEAGUE","startTime":"16:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"38076","name":"IRAKLIS PSACHNON","standing":"10"},"Away":{"id":"13082","name":"AEK ATHENS","standing":"1"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40209","name":"GREECE"},"parentCompetition":{"id":"41406","name":"FOOTBALL LEAGUE"},"rootCompetition":{"id":"40209","name":"GREECE"},"league":{"id":"31013","name":"FOOTBALL LEAGUE GROUP 1"},"shortName":"GRE-FL","round":"23","note":"Distance 100Km. Sidelined Players : AEL ATHENS - Bresevic I., Mantalos P. (Injured).","bitArray":"","timestamp":""}},"2096001":{"ct":"0","id":"2096001","lastPeriod":"","leagueCode":"101364","leagueSort":"15","leagueType":"LEAGUE","startTime":"16:30","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"100507","name":"CIRBONERO","standing":"11"},"Away":{"id":"100496","name":"UD MUTILVERA","standing":"5"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101364","name":"GRUPO 15"},"shortName":"ESP-TD","round":"23","note":"","bitArray":"","timestamp":""}},"2090700":{"ct":"0","id":"2090700","lastPeriod":"","leagueCode":"101350","leagueSort":"4","leagueType":"LEAGUE","startTime":"17:00","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"100725","name":"SD GERNIKA","standing":"2"},"Away":{"id":"17876","name":"AURRERA VITORIA","standing":"11"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101350","name":"GRUPO 4"},"shortName":"ESP-TD","round":"25","note":"","bitArray":"","timestamp":""}},"1176816":{"ct":"0","id":"1176816","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"17:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"3495","name":"DINAMO MOSCOW","standing":""},"Away":{"id":"21738","name":"NAPOLI","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (1-3).","bitArray":"","timestamp":""}},"1064419":{"ct":"0","id":"1064419","lastPeriod":"","leagueCode":"30232","leagueSort":"20","leagueType":"LEAGUE","startTime":"18:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"11875","name":"VEJLE","standing":"7"},"Away":{"id":"11914","name":"LYNGBY","standing":"2"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"39974","name":"DENMARK"},"league":{"id":"30232","name":"1. DIVISION"},"shortName":"DEN-D1","round":"20","note":"","bitArray":"","timestamp":""}},"1073861":{"ct":"0","id":"1073861","lastPeriod":"","leagueCode":"30755","leagueSort":"45","leagueType":"LEAGUE","startTime":"18:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"4449","name":"BAYERN MUNICH II","standing":"3"},"Away":{"id":"39948","name":"FC INGOLSTADT 04 II","standing":"6"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40179","name":"GERMANY"},"parentCompetition":{"id":"41404","name":"REGIONAL LEAGUES"},"rootCompetition":{"id":"40179","name":"GERMANY"},"league":{"id":"30755","name":"REGIONAL LEAGUE BAVARIA"},"shortName":"GER-REG","round":"25","note":"","bitArray":"","timestamp":""}},"1176814":{"ct":"0","id":"1176814","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"18:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"3581","name":"DINAMO KIEV","standing":""},"Away":{"id":"10818","name":"EVERTON","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (1-2).","bitArray":"","timestamp":""}},"1176815":{"ct":"0","id":"1176815","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"18:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"5064","name":"ROMA","standing":""},"Away":{"id":"3350","name":"FIORENTINA","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (1-1).","bitArray":"","timestamp":""}},"2096346":{"ct":"0","id":"2096346","lastPeriod":"","leagueCode":"101365","leagueSort":"16","leagueType":"LEAGUE","startTime":"19:30","status":"Sched","statustype":"sched","type":"2","visible":"0","lineups":"0","Home":{"id":"100478","name":"CD ARNEDO","standing":"17"},"Away":{"id":"100483","name":"CLUB ATLETICO VIANES","standing":"12"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"41044","name":"SPAIN"},"parentCompetition":{"id":"101337","name":"TERCERA DIVISION"},"rootCompetition":{"id":"41044","name":"SPAIN"},"league":{"id":"101365","name":"GRUPO 16"},"shortName":"ESP-TD","round":"25","note":"","bitArray":"","timestamp":""}},"1177600":{"ct":"0","id":"1177600","lastPeriod":"","leagueCode":"31152","leagueSort":"71","leagueType":"LEAGUE","startTime":"19:45","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"48775","name":"RAMSBOTTOM UNITED","standing":"20"},"Away":{"id":"28100","name":"BLYTH SPARTANS","standing":"9"},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"40011","name":"ENGLAND"},"parentCompetition":{"id":"42787","name":"NON LEAGUE PREMIER"},"rootCompetition":{"id":"40011","name":"ENGLAND"},"league":{"id":"31152","name":"NORTHERN PREMIER LEAGUE"},"shortName":"ENG-NLP","round":"MARCH","note":"FT result only.","bitArray":"","timestamp":""}},"1177576":{"ct":"0","id":"1177576","lastPeriod":"","leagueCode":"32359","leagueSort":"101","leagueType":"PHASE","startTime":"20:00","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"0","Home":{"id":"47429","name":"TEMPERLEY","standing":""},"Away":{"id":"40293","name":"PATRONATO","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"39665","name":"ARGENTINA"},"parentCompetition":{"id":"39666","name":"FA CUP"},"rootCompetition":{"id":"39665","name":"ARGENTINA"},"league":{"id":"32359","name":"ROUND 64"},"shortName":"ARG-CUP","round":"R64","note":"Knock out.","bitArray":"","timestamp":""}},"1176812":{"ct":"0","id":"1176812","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"20:05","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"23543","name":"BESIKTAS","standing":""},"Away":{"id":"3178","name":"CLUB BRUGGE","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (1-2).","bitArray":"","timestamp":""}},"1176813":{"ct":"0","id":"1176813","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"20:05","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"2913","name":"AJAX","standing":""},"Away":{"id":"18496","name":"DNEPR DNEPROPETROVSK","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (0-1).","bitArray":"","timestamp":""}},"1176817":{"ct":"0","id":"1176817","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"20:05","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"26253","name":"SEVILLA","standing":""},"Away":{"id":"17842","name":"VILLARREAL","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (3-1).","bitArray":"","timestamp":""}},"1176818":{"ct":"0","id":"1176818","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"20:05","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"5055","name":"INTER","standing":""},"Away":{"id":"14080","name":"VFL WOLFSBURG","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (1-3).","bitArray":"","timestamp":""}},"1176819":{"ct":"0","id":"1176819","lastPeriod":"","leagueCode":"29106","leagueSort":"27","leagueType":"PHASE","startTime":"20:05","status":"Sched","statustype":"sched","type":"2","visible":"1","lineups":"1","Home":{"id":"12662","name":"TORINO","standing":""},"Away":{"id":"23829","name":"ZENIT","standing":""},"Information":{"season":{"id":"256","name":"2014\/2015"},"country":{"id":"35477","name":"EUROPE (UEFA)"},"parentCompetition":{"id":"40075","name":"UEFA EUROPA LEAGUE"},"rootCompetition":{"id":"35477","name":"EUROPE (UEFA)"},"league":{"id":"29106","name":"ROUND 16"},"shortName":"UEFA-UEL","round":"SECOND LEG","note":"First leg (0-2).","bitArray":"","timestamp":""}}}}}}}}}';
	#$json_data = json_decode($jsontext,true);

	curl_close($cURL);

	if(isset($json_data['error']) && $json_data['error'] == 'EROR: 05-TOO FREQUENT UPDATE') {
		echo 'EROR: 05-TOO FREQUENT UPDATE';
		return;
	}

	echo "Live Score JSON success...\n";


	$json_data = $json_data['list']['Sport'][1]['Matchday'];



	// print_r($json_data);

	echo "Truncateing live tables\n";
	$query = $dbconn_mysql->prepare("DELETE FROM live_cards");
	$query->execute();
	$query = NULL;

	$query = $dbconn_mysql->prepare("DELETE FROM live_scorers");
	$query->execute();
	$query = NULL;

	$query = $dbconn_mysql->prepare("DELETE FROM live_scores");
	$query->execute();
	$query = NULL;

	$query = $dbconn_mysql->prepare("DELETE FROM live_match");
	$query->execute();
	$query = NULL;

	if(!is_array($json_data)) return;

	echo "Parsing JSON\n";
	foreach ($json_data as $newjson) {

		$json = $newjson;
		$date = $json['date'];
		$json = $json['Match'];

		foreach ($json as $match) {

			$id = $match['id'];
			$leagueID = $match['leagueCode'];
			$leagueType = $match['leagueType'];
			$startTime = $match['startTime'];
			$statustype = $match['statustype'];
			$gameStatus = $match['status'];

			$note = $match['Information']['note'];

			if($leagueID==0) continue;

			$homeArray = $match['Home'];
			$awayArray = $match['Away'];

			$teamHomeId = $homeArray['id'];
			$teamAwayId = $awayArray['id'];

			$teamHomeName = $homeArray['name'];
			$teamAwayName = $awayArray['name'];

			$query = $dbconn_mysql->prepare("REPLACE INTO teams (id, name) VALUES (?,?)");
			$query->execute(array($teamHomeId, $teamHomeName));
			$query = NULL;

			$query = $dbconn_mysql->prepare("REPLACE INTO teams (id, name) VALUES (?,?)");
			$query->execute(array($teamAwayId, $teamAwayName));
			$query = NULL;

			if($teamHomeId==0) continue;
			if($teamAwayId==0) continue;

			$query = $dbconn_mysql->prepare("REPLACE INTO live_match (id, league_id, league_type, start_time, status_type, game_status, note, team_home_id, team_away_id, date_updated) values (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
			$query->execute(array($id, $leagueID, $leagueType, $startTime, $statustype, $gameStatus, $note, $teamHomeId, $teamAwayId));
			$query = NULL;

			if($statustype=='live'||$statustype=='fin') {

				getTeamCards($homeArray, 'HOME', $id);
				getTeamCards($awayArray, 'AWAY', $id);

				$mResults = (isset($match['Results']) ? $match['Results'] : false);

				if(is_array($mResults)) {

					getResult($mResults, $id);

					if (isset($mResults['Scorer'])) getScorers($mResults['Scorer'], $id, $teamHomeId, $teamAwayId);

				}
			}
		}
	}
}

function getTeamCards($data, $gametype, $matchid) {

	global $dbconn_mysql;

	$teamName = $data['name'];
	$teamId = $data['id'];

	if(!is_array($data)) return;

	if(!isset($data['Cards']) || !is_array($data['Cards'])) return;

	$cardData = $data['Cards']['Card'];

	if(!is_array($cardData)) return;

	foreach($cardData as $cards) {

		$name = $cards['name'];
		$player_id = $cards['p_id'];
		$time = $cards['time'];
		$type = $cards['type'];

		if(strlen($name)==0) continue;

		$query = $dbconn_mysql->prepare("INSERT INTO live_cards (match_id, team_id, card_type, player_id, time_player_got_card, player_name, home_or_away) values (?, ?, ?, ?, ? , ?,?)");
		$query->execute(array($matchid, $teamId, $type, $player_id, $time, $name, $gametype));
		$query = NULL;

	}
}

function getResult($data, $matchid) {

	global $dbconn_mysql;

	foreach($data as $results) {

		if(!isset($results['name']) || !isset($results['value'])) continue;

		$name = $results['name'];
		$value = $results['value'];

		$query = $dbconn_mysql->prepare("INSERT INTO live_scores (match_id, type, score, date_updated) values (?, ?, ?, NOW())");
		$query->execute(array($matchid, $value, $name));
		$query = NULL;

	}
}

function getScorers($data, $matchid, $hometeam, $awayteam) {

	global $dbconn_mysql;

	if(!is_array($data)) {

		echo ' NO SCORERS LIVE SCORES ';
		return;
	}

	foreach($data as $results) {

		$name = $results['name'];
		$period = $results['period'];
		$teamid = $results['team'];
		$time = $results['time'];
		$type = $results['type'];
		$playerid = $results['p_id'];

		$scoreType = 'UNKNOWN';
		$teid ='';
		if($teamid==$hometeam) {
			$scoreType = 'HOME';
			$teid=$hometeam;
		} else if($teamid==$awayteam) {
			$scoreType = 'AWAY';
			$teid=$awayteam;
		}

		if(strlen($name)!=0) {
			$query = $dbconn_mysql->prepare("INSERT INTO live_scorers (match_id, player_id, team_id, name, period, type, time, date_updated, home_or_away) values (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
			$query->execute(array($matchid, $playerid, $teid, $name, $period, $type, $time, $scoreType));
			$query = NULL;
		}
	}
}
