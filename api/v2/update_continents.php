<?php

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

updateContinents();

function updateContinents() {

	global $dbconn;

	$now_alternative = date('Y-m-d H:m:s');
	try {

	$STH = $dbconn->prepare("SELECT c.continent continent
                              FROM   countries c,
                              league l,
                              team_positions tp
                              LEFT OUTER JOIN sub_league sl
                              ON sl.id = tp.league_id
                              WHERE  tp.league_id = l.id
                              AND l.country_id = c.id
                              AND c.should_show_on_app = 'Y'
                              AND l.should_show_on_app = 'Y'
                              AND c.continent IS NOT NULL
                              GROUP BY c.continent");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	$STH->execute();
	$continents = array();
	while ($row = $STH->fetch()) {
		$continents[] = $row['continent'];
	}

	//success($continents);


	$query = $dbconn->prepare("DELETE FROM continents");
	$query->execute();


	$STH = $dbconn->prepare("INSERT INTO continents (name) VALUES (:name)");
	$STH->bindParam(':name',$name);
	foreach($continents as $name) {
			$STH->execute();
	}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}

	$query = $dbconn->prepare("UPDATE league SET has_fixtures = 0");
	$query->execute();

	$STH = $dbconn->prepare("SELECT l.* FROM league l, fixtures f
                              LEFT OUTER JOIN sub_league sl
                              ON sl.id=f.league_id
                              WHERE fixture_date >= date('now')
                              AND (sl.league_id = l.id OR f.league_id = l.id)
                              AND l.should_show_on_app='Y'
                              GROUP BY l.id
                              ORDER BY l.`sort` ASC");
	$STH->setFetchMode(PDO::FETCH_ASSOC);
	$STH->execute();
	$STH1 = $dbconn->prepare("UPDATE league SET has_fixtures = 1 WHERE id = :id");
	$STH1->bindParam(':id',$id);
	while ($row = $STH->fetch()) {
		$id = $row['id'];
		$STH1->execute();
	}
}


?>
