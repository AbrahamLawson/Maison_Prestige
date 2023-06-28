<?php

header("Content-type: application/json; charset=UTF-8");

$id = $_GET["id"] ?? null;

if (is_null($id) || $id === "") {
    echo '[]';
    exit();
}

// temp
require "../../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$request = $pdo->prepare("
    SELECT M.id AS id, M.status AS status, M.housing_id AS housing_id, M.team_id AS team_id, M.maintenance_date AS maintenance_date, M.due_date AS due_date, N.content AS note_content
    FROM maintenance AS M
    LEFT JOIN maintenance_notes AS N ON M.id = N.maintenance_id
    WHERE id = :id
");

$request->execute([
    ":id" => $id
]);

$data = $request->fetch(PDO::FETCH_ASSOC);

echo json_encode($data, JSON_PRETTY_PRINT);