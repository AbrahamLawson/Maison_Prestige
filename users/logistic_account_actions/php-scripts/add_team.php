<?php

header("Content-type: application/json; charset=UTF-8");

// temp
require "../../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$request = $pdo->prepare("
    INSERT INTO teams (active)
    VALUES (DEFAULT)
");

$request->execute();

echo json_encode(["message" => "success"], JSON_PRETTY_PRINT);