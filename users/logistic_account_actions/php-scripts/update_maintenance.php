<?php

header("Content-type: application/json; charset=UTF-8");

$id = intval($_POST["id"]) ?? null;
$teamId = $_POST["team_id"] ?? null;
$date = $_POST["maintenance_date"] ?? null;
$note = $_POST["note_content"] ?? null;

if (is_null($id) || $id === "") {
    echo '[]';
    exit();
}

// temp
require "../../../bdd_connect.php";

$pdo = connexion_BDD ();
// ----

$request = $pdo->prepare("
    UPDATE maintenance
    SET team_id = :team_id, maintenance_date = :date,
    status = CASE WHEN :team_id IS NOT NULL AND :date IS NOT NULL THEN 'defined' ELSE status END
    WHERE id = :id;
");

try{
    $request->execute([
        ":team_id" => $teamId,
        ":date" => $date,
        ":id" => $id
    ]);

    if ($request->rowCount() > 0) {
        $response = ["maintenance update" => 
            ["status" => "success"]
        ];
    } else {
        // La requete d'UPDATE n'a UPDATE aucune ligne
        $response = ["maintenance update" => [
            "status" => "error",
            "message" => "no update"
        ]];
    }
}
catch (Exception $e) {
    $response = ["maintenance update" => [
        "status" => "error",
        "message" => $e
    ]];
}
if($note !== "" && !is_null($note))
{
    $request = $pdo->prepare("
        INSERT INTO maintenance_notes (maintenance_id, content)
        VALUES (:id, :note)
        ON DUPLICATE KEY UPDATE content = VALUES(content);            
    ");

    try {
        $request->execute([
            ":note" => $note,
            ":id" => $id
        ]);

        if ($request->rowCount() > 0) {
            $response += ["note update" => 
                ["status" => "success"]
            ];
        } else {
            // La requete d'UPDATE n'a UPDATE aucune ligne
            $response += ["note update" => [
                "status" => "error",
                "message" => "no update"
            ]];
        }
    }
    catch (Exception $e)
    {
        $response += ["note update" => [
            "status" => "error",
            "message" => $e
        ]];
    }
}

if ($response["maintenance update"]["status"] === "error" && $response["note update"]["status"] === "error")
{
    http_response_code(400);
}

echo json_encode($response, JSON_PRETTY_PRINT);

header("Location: ../");
exit();