<?php

// temp
require "../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$maintenanceList = [];

// liste des entretiens non complétés en temps voulu
$request = $pdo->prepare("
    SELECT id, housing_id, team_id, maintenance_date, due_date
    FROM maintenance
    WHERE (due_date <= CURRENT_DATE OR maintenance_date < CURRENT_DATE) AND status != 'done' AND status != 'cancelled'
    ORDER BY due_date
");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_ASSOC);
$maintenanceList["alerts"] = $results;

// liste des entretiens à planifier
$request = $pdo->prepare("
    SELECT id, housing_id, team_id, maintenance_date, due_date
    FROM maintenance
    WHERE due_date > CURRENT_DATE AND maintenance_date >= CURRENT_DATE AND status = 'to define'
    ORDER BY due_date
");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_ASSOC);
$maintenanceList["to define"] = $results;

// liste des entretiens planifiés
$request = $pdo->prepare("
    SELECT id, housing_id, team_id, maintenance_date, due_date
    FROM maintenance
    WHERE due_date > CURRENT_DATE AND maintenance_date >= CURRENT_DATE AND status = 'defined'
    ORDER BY due_date
");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_ASSOC);
$maintenanceList["defined"] = $results;

// liste des logements
$request = $pdo->prepare("
    SELECT id, name, position, address
    FROM housing
    ORDER BY position
");
$request->execute();
$housingList = $request->fetchAll(PDO::FETCH_ASSOC);

// liste des identifiants d'équipe
$request = $pdo->prepare("
    SELECT id
    FROM teams
    WHERE active = 1
");
$request->execute();
$results = $request->fetchAll(PDO::FETCH_ASSOC);

$teamListTmp = $results;
$teamList = [];
foreach ($teamListTmp as $team) {
    $request = $pdo->prepare("
        SELECT U.id, U.first_name AS first_name, U.last_name AS last_name
        FROM users AS U
        JOIN team_members AS TM ON U.id = TM.member_id
        WHERE team_id = :team_id
    ");
    $request->execute([
        ":team_id" => $team["id"]
    ]);
    $team["members"] = $request->fetchAll(PDO::FETCH_ASSOC);
    $teamList[] = $team; // ajoute $team à $teamList
}