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
    SELECT id, name, position, address, capacity, description
    FROM housing
    WHERE id = :id
");

$request->execute([
    ":id" => $id
]);

$data = $request->fetch(PDO::FETCH_ASSOC);

echo json_encode($data, JSON_PRETTY_PRINT);