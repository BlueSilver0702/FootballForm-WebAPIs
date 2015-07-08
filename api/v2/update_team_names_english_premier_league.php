<?php

/*
	Matt: I've added a column sub_league - as some teams seems to be getting added with other teams
	I'm guessing this is because there league_id is the same as another sub_league
*/

$root = "/home/football/www/";

include $root.'dbconnect_new.php';
require_once $root.'api/v2/app_functions.php';

updateHomeNamesFixtures();
updateAwayNamesFixtures();
updateTeamNamesTeams();
updateTeamNamesTeamPositions();

function updateHomeNamesFixtures() {

	global $dbconn;

	$query = "UPDATE fixtures SET teams_home_name='ARSENAL' WHERE teams_home_name='ARSENAL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='MAN UNITED' WHERE teams_home_name='MANCHESTER UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='STOKE' WHERE teams_home_name='STOKE CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='BURNLEY' WHERE teams_home_name='BURNLEY FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='LEICESTER' WHERE teams_home_name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='CHELSEA (U21)' WHERE teams_home_name='CHELSEA FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='CHELSEA (W)' WHERE teams_home_name='CHELSEA FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='CHELSEA' WHERE teams_home_name='CHELSEA FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='EVERTON (W)' WHERE teams_home_name='EVERTON FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='EVERTON (U21)' WHERE teams_home_name='EVERTON FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='EVERTON' WHERE teams_home_name='EVERTON FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='HULL' WHERE teams_home_name='HULL CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='LEICESTER (U21)' WHERE teams_home_name='LEICESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='LEICESTER' WHERE teams_home_name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='LIVERPOOL' WHERE teams_home_name='LIVERPOOL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='LIVERPOOL (U21)' WHERE teams_home_name='LIVERPOOL FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='MAN CITY (W)' WHERE teams_home_name='MANCHESTER CITY (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='MAN CITY (U21)' WHERE teams_home_name='MANCHESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='MAN CITY' WHERE teams_home_name='MANCHESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='NEWCASTLE' WHERE teams_home_name='NEWCASTLE UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='NEWCASTLE' WHERE teams_home_name='NEWCASTLE UTD'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='QPR' WHERE teams_home_name='QUEENS PARK RANGERS'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='SUNDERLAND' WHERE teams_home_name='SUNDERLAND AFC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='NORWICH' WHERE teams_home_name='NORWICH CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='FULHAM' WHERE teams_home_name='FULHAM FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

	$query = "UPDATE fixtures SET teams_home_name='CARDIFF' WHERE teams_home_name='CARDIFF CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
	$stmt = NULL; // closes the connection

}

function updateAwayNamesFixtures() {

	global $dbconn;

	$query = "UPDATE fixtures SET teams_away_name='ARSENAL' WHERE teams_away_name='ARSENAL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='MAN UNITED' WHERE teams_away_name='MANCHESTER UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='STOKE' WHERE teams_away_name='STOKE CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='BURNLEY' WHERE teams_away_name='BURNLEY FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='LEICESTER' WHERE teams_away_name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='CHELSEA (U21)' WHERE teams_away_name='CHELSEA FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='CHELSEA (W)' WHERE teams_away_name='CHELSEA FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='CHELSEA' WHERE teams_away_name='CHELSEA FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='EVERTON (W)' WHERE teams_away_name='EVERTON FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='EVERTON (U21)' WHERE teams_away_name='EVERTON FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='EVERTON' WHERE teams_away_name='EVERTON FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='HULL' WHERE teams_away_name='HULL CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='LEICESTER (U21)' WHERE teams_away_name='LEICESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='LEICESTER' WHERE teams_away_name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='LIVERPOOL' WHERE teams_away_name='LIVERPOOL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='LIVERPOOL (U21)' WHERE teams_away_name='LIVERPOOL FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='MAN CITY (W)' WHERE teams_away_name='MANCHESTER CITY (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='MAN CITY (U21)' WHERE teams_away_name='MANCHESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='MAN CITY' WHERE teams_away_name='MANCHESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='NEWCASTLE' WHERE teams_away_name='NEWCASTLE UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='NEWCASTLE' WHERE teams_away_name='NEWCASTLE UTD'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='QPR' WHERE teams_away_name='QUEENS PARK RANGERS'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='SUNDERLAND' WHERE teams_away_name='SUNDERLAND AFC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='NORWICH' WHERE teams_away_name='NORWICH CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='FULHAM' WHERE teams_away_name='FULHAM FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

	$query = "UPDATE fixtures SET teams_away_name='CARDIFF' WHERE teams_away_name='CARDIFF CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();

}

function updateTeamNamesTeams() {

	global $dbconn;

	$query = "UPDATE teams SET name='ARSENAL' WHERE name='ARSENAL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='MAN UNITED' WHERE name='MANCHESTER UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='STOKE' WHERE name='STOKE CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='BURNLEY' WHERE name='BURNLEY FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='LEICESTER' WHERE name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='CHELSEA (U21)' WHERE name='CHELSEA FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='CHELSEA (W)' WHERE name='CHELSEA FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='CHELSEA' WHERE name='CHELSEA FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='EVERTON (W)' WHERE name='EVERTON FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='EVERTON (U21)' WHERE name='EVERTON FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='EVERTON' WHERE name='EVERTON FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='HULL' WHERE name='HULL CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='LEICESTER (U21)' WHERE name='LEICESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='LEICESTER' WHERE name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='LIVERPOOL' WHERE name='LIVERPOOL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='LIVERPOOL (U21)' WHERE name='LIVERPOOL FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='MAN CITY (W)' WHERE name='MANCHESTER CITY (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='MAN CITY (U21)' WHERE name='MANCHESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='MAN CITY' WHERE name='MANCHESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='NEWCASTLE' WHERE name='NEWCASTLE UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='NEWCASTLE' WHERE name='NEWCASTLE UTD'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='QPR' WHERE name='QUEENS PARK RANGERS'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='SUNDERLAND' WHERE name='SUNDERLAND AFC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='NORWICH' WHERE name='NORWICH CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='FULHAM' WHERE name='FULHAM FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE teams SET name='CARDIFF' WHERE name='CARDIFF CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

}

function updateTeamNamesTeamPositions() {

	global $dbconn;

	$query = "UPDATE team_positions SET team_name='ARSENAL' WHERE team_name='ARSENAL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='MAN UNITED' WHERE team_name='MANCHESTER UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='STOKE' WHERE team_name='STOKE CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='BURNLEY' WHERE team_name='BURNLEY FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='LEICESTER' WHERE team_name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='CHELSEA (U21)' WHERE team_name='CHELSEA FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='CHELSEA (W)' WHERE team_name='CHELSEA FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='CHELSEA' WHERE team_name='CHELSEA FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='EVERTON (W)' WHERE team_name='EVERTON FC (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='EVERTON (U21)' WHERE team_name='EVERTON FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='EVERTON' WHERE team_name='EVERTON FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='HULL' WHERE team_name='HULL CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='LEICESTER (U21)' WHERE team_name='LEICESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='LEICESTER' WHERE team_name='LEICESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='LIVERPOOL' WHERE team_name='LIVERPOOL FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='LIVERPOOL (U21)' WHERE team_name='LIVERPOOL FC (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='MAN CITY (W)' WHERE team_name='MANCHESTER CITY (W)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='MAN CITY (U21)' WHERE team_name='MANCHESTER CITY (U21)'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='MAN CITY' WHERE team_name='MANCHESTER CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='NEWCASTLE' WHERE team_name='NEWCASTLE UNITED'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='NEWCASTLE' WHERE team_name='NEWCASTLE UTD'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='QPR' WHERE team_name='QUEENS PARK RANGERS'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='SUNDERLAND' WHERE team_name='SUNDERLAND AFC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='NORWICH' WHERE team_name='NORWICH CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='FULHAM' WHERE team_name='FULHAM FC'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

	$query = "UPDATE team_positions SET team_name='CARDIFF' WHERE team_name='CARDIFF CITY'";
	$stmt = $dbconn->prepare($query);
	$stmt->execute();
$stmt = NULL; // closes the connection

}

?>
