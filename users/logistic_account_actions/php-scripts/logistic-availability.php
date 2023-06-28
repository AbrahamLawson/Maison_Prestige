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
    WITH RECURSIVE booking_date_range AS (
        SELECT start_date, end_date
        FROM booking
        WHERE housing_id = :housing_id
        AND status <> 'cancelled'
        AND status <> 'done'
        UNION ALL
        SELECT DATE_ADD(start_date, INTERVAL 1 DAY), end_date
        FROM booking_date_range
        WHERE DATE_ADD(start_date, INTERVAL 1 DAY) <= end_date
    ),
    unavailabilities_date_range AS (
        SELECT start_date, end_date
        FROM housing_unavailabilities
        WHERE housing_id = :housing_id
        UNION ALL
        SELECT DATE_ADD(start_date, INTERVAL 1 DAY), end_date
        FROM unavailabilities_date_range
        WHERE DATE_ADD(start_date, INTERVAL 1 DAY) <= end_date
    )
    SELECT start_date as date
    FROM booking_date_range
    UNION
    SELECT start_date as date
    FROM unavailabilities_date_range;
");

$request->execute([
    ":housing_id" => $id
]);

$data = $request->fetchAll(PDO::FETCH_COLUMN, 0);

echo json_encode($data, JSON_PRETTY_PRINT);