<?

zipItUp();

function zipItUp() {

	global $root;

	$zip = new ZipArchive();

	$DelFilePath="football_form_database_new.db.zip";

	if(file_exists($DelFilePath)) {

	    unlink($DelFilePath);

	}

	if ($zip->open($DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {

		mail('aaron@createanet.co.uk', 'FOOTBALL FORM ZIP ISSUE', 'FOOTBALL FORM ZIP ISSUE LINE 140 IN CRON.PHP');

	}

	$zip->addFile("football_form_database_new.db", "football_form_database_new.db");

	print_r($zip);

	$zip->close();

}