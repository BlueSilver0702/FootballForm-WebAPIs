<?php

set_time_limit(1500); //650
$root = "/home/football/www/";

if(!$dbconn){
	include_once $root.'dbconnect_new.php';
}

require_once $root.'api/v2/app_functions.php';

$dbconn->beginTransaction();

$query = "DELETE FROM last_5_games";
$query = $dbconn->query($query);
$query = NULL; // closes the connection

// Matt's bit to build last 5 games view
$query = "SELECT l.id as league_id, t.id as team_id
			FROM teams t, league l
			WHERE l.id = t.league_id

			UNION

			SELECT l.id as league_id, t.id as team_id
			FROM teams t, sub_league l
			WHERE l.id = t.league_id";

$query = $dbconn->query($query);



$tnquery = $dbconn->prepare("INSERT INTO last_5_games (league_id, team_id, results) VALUES (:league_id, :team_id, :results)");

if($query == false) {
            print_r($dbconn->errorInfo(), 1);
        }


if($query->rowCount() > 0) {
	$query = NULL; // closes the connection
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

		// work out their last 5 games
		$query2 = "SELECT
					(( CASE
			           WHEN ( `team_home_score` > team_away_score
			                  AND teams_home_id = {$row['team_id']} )
			                 OR ( team_away_score > team_home_score
			                      AND teams_away_id = {$row['team_id']} ) THEN 'WON'
			           WHEN ( `team_home_score` < team_away_score
			                  AND teams_home_id = {$row['team_id']} )
			                 OR ( team_away_score < team_home_score
			                      AND teams_away_id = {$row['team_id']} ) THEN 'LOST'
			           WHEN ( `team_home_score` = team_away_score
			                  AND teams_home_id = {$row['team_id']} )
			                 OR ( team_away_score = team_home_score
			                      AND teams_away_id = {$row['team_id']} ) THEN 'DRAW'
			         end )
					|| '*' ||
			       teams_home_name
					|| '*' ||
			       teams_away_name
					|| '*' ||
			       team_home_score
					|| '*' ||
			       team_away_score)
			       as result
			FROM   teams t2,
			       fixtures f
			WHERE  f.league_id = {$row['league_id']}
			       AND f.status = 'Fin'
			       AND ( f.teams_home_id = t2.id OR f.teams_away_id = t2.id )
			       AND f.fixture_date < date('now')
			       AND t2.id = {$row['team_id']}
			GROUP  BY f.id
			ORDER  BY f.fixture_date DESC
			LIMIT  5";

		$query2 = $dbconn->query($query2);

		$out = array();
		while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {
			$out[] = $row2['result'];
		}

		$tnquery->execute(array($row['league_id'], $row['team_id'], implode('+', $out)));

	}
	$dbconn->commit();

	echo "create_form_players_table => success\n";

} else {
	echo "create_form_players_table => fail\n";
}

$tnquery = NULL; // closes the connection







/*
$query = "
EXPLAIN QUERY PLAN

SELECT p.id as player_id, p.name as player_name, t.name as team_name, t.id as team_id,
	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 1
		AND f2.league_id = f.league_id
		AND gs1.player_id = p.id
	) as p1_goals

	FROM line_ups lu, fixtures f, teams t, players p

	WHERE lu.match_id = f.id
	AND lu.player_id = p.id
	AND lu.match_id = f.id
	AND t.id = lu.team_id

	GROUP BY p.id, f.league_id";

print_r($query);

$sth = $dbconn->query($query);
$res = $sth->fetchAll();

print_r($res);

exit();




// delete old records
$query = "DELETE FROM form_players_view";
$query = $dbconn->query($query);

// add new records
// Both home and away scores
$query = "INSERT INTO form_players_view (player_id, player_name, team_name, team_id, p1_goals, p2_goals, appearances, type, league_id)

	SELECT p.id as player_id, p.name as player_name, t.name as team_name, t.id as team_id,
	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 1
		AND f2.league_id = f.league_id
		AND gs1.player_id = p.id
	) as p1_goals,

	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 2
		AND f2.league_id  = f.league_id
		AND gs1.player_id = p.id
	) as p2_goals,

	(
		SELECT Count(lu.match_id) as appearances
		FROM line_ups lu, fixtures f2
		WHERE lu.match_id = f2.id
		AND f2.league_id  = f.league_id
		AND lu.player_id = p.id
		AND (f2.teams_away_id = t.id OR f2.teams_home_id = t.id)
	) as appearances, 0 as type, f.league_id

	FROM line_ups lu, fixtures f, teams t, players p

	WHERE lu.match_id = f.id
	AND lu.player_id = p.id
	AND lu.match_id = f.id
	AND t.id = lu.team_id

	GROUP BY p.id, f.league_id";

$query = $dbconn->prepare($query);
print_r($dbconn->errorInfo());
$query->execute();
$res = $query->fetchAll();


print_r($res);

echo 'DONE';
exit();










// Away scores
$query = "INSERT INTO form_players_view (player_id, player_name, team_name, team_id, p1_goals, p2_goals, appearances, type, league_id)


	SELECT p.id as player_id, p.name as player_name, t.name as team_name, t.id as team_id,

	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 1
		AND f2.league_id  = f.league_id
		AND gs1.player_id = p.id
		AND gs1.team_side = 'Away'
	) as p1_goals,

	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 2
		AND f2.league_id  = f.league_id
		AND gs1.player_id = p.id
		AND gs1.team_side = 'Away'
	) as p2_goals,

	(
		SELECT Count(lu.match_id) as appearances
		FROM line_ups lu, fixtures f2
		WHERE lu.match_id = f2.id
		AND f2.league_id  = f.league_id
		AND lu.player_id = p.id
		AND f2.teams_away_id = t.id
	) as appearances, 2 as type, f.league_id

	FROM line_ups lu, fixtures f, teams t, players p

	WHERE lu.match_id = f.id
	AND lu.player_id = p.id
	AND lu.match_id = f.id
	AND t.id = lu.team_id

	GROUP BY p.id, f.league_id";

$query = $dbconn->prepare($query);
print_r($dbconn->errorInfo());
$query->execute();



// Home scores
$query = "INSERT INTO form_players_view (player_id, player_name, team_name, team_id, p1_goals, p2_goals, appearances, type, league_id)


	SELECT p.id as player_id, p.name as player_name, t.name as team_name, t.id as team_id,

	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 1
		AND f2.league_id = f.league_id
		AND gs1.player_id = p.id
		AND gs1.team_side = 'Home'
	) as p1_goals,

	(
		SELECT Count(gs1.id)
	 	FROM goals_scored gs1, fixtures f2
		WHERE gs1.match_id = f2.id
		AND gs1.period = 2
		AND f2.league_id  = f.league_id
		AND gs1.player_id = p.id
		AND gs1.team_side = 'Home'
	) as p2_goals,

	(
		SELECT Count(lu.match_id) as appearances
		FROM line_ups lu, fixtures f2
		WHERE lu.match_id = f2.id
		AND f2.league_id  = f.league_id
		AND lu.player_id = p.id
		AND f2.teams_home_id = t.id
	) as appearances, 1 as type, f.league_id

	FROM line_ups lu, fixtures f, teams t, players p

	WHERE lu.match_id = f.id
	AND lu.player_id = p.id
	AND lu.match_id = f.id
	AND t.id = lu.team_id

	GROUP BY p.id, f.league_id";

$query = $dbconn->prepare($query);
print_r($dbconn->errorInfo());
$query->execute();
*/

