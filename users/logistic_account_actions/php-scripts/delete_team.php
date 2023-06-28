<?php

$id = $_GET["id"] ?? null;

if (is_null($id) || $id === "") {
    echo '[]';
    exit();
}

header("Content-type: application/json; charset=UTF-8");

// temp
require "../../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$request = $pdo->prepare("
    DELETE FROM teams
    WHERE id = :id
");

try
{
    $request->execute([
        ":id" => $id
    ]);

    echo json_encode(["message" => "success"], JSON_PRETTY_PRINT);
}
catch (Exception $e)
{
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => $e
    ]);
}
