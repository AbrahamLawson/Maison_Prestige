<?php

header("Content-type: application/json; charset=UTF-8");

$prompt = $_GET["prompt"] ?? null;

if (is_null($prompt) || $prompt === "") {
    echo '[]';
    exit();
}

// temp
require "../../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$request = $pdo->prepare("
    SELECT u.id AS user_id, U.mail AS mail, U.first_name AS first_name, U.last_name AS last_name, TM.team_id
    FROM users AS U
    LEFT JOIN team_members AS TM ON TM.member_id = U.id
    WHERE CONCAT(U.first_name, ' ', U.last_name) LIKE :prompt AND role = 'maintenance'
    ORDER BY U.last_name;
");

$request->execute([
    ":prompt" => "%" . $prompt . "%"
]);

$data = $request->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data, JSON_PRETTY_PRINT);