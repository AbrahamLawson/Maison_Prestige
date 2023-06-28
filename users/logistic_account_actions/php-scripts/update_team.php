<?php

header("Content-type: application/json; charset=UTF-8");

$memberId = intval($_POST["member_id"]) ?? null;
$teamId = $_POST["team_id"] ?? null;

if (is_null($memberId) || $memberId === "") {
    echo '[]';
    exit();
}

// temp
require "../../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$request = $pdo->prepare("
    UPDATE team_members
    SET team_id = :team_id
    WHERE member_id = :member_id;
");

try {
    $request->execute([
        ":team_id" => $teamId,
        ":member_id" => $memberId
    ]);

    if ($request->rowCount() > 0) {
        echo json_encode(["message" => "success"], JSON_PRETTY_PRINT);
        header("Location: ../");
        exit;
    } else {
        $request = $pdo->prepare("
            INSERT INTO team_members (team_id, member_id)
            VALUES (:team_id, :member_id)
        ");

        try {
            $request->execute([
                ":team_id" => $teamId,
                ":member_id" => $memberId
            ]);

            if ($request->rowCount() > 0) {
                echo json_encode(["message" => "success"], JSON_PRETTY_PRINT);
                header("Location: ../");
                exit;
            } else {
                // La requête d'INSERT n'a pas inséré de ligne
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "no update"
                ]);
                exit;
            }
        } catch (Exception $e) {
            // Une exception s'est produite lors de l'exécution de la requête d'INSERT
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
            exit;
        }
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
    exit;
}