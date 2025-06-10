<?php
include_once("../../includes/db.php");
session_start();

if (isset($_GET["game_id"])) {
    $game_id = intval($_GET["game_id"]);

    $query = "UPDATE games SET neighborhood_offset = neighborhood_offset + 1 WHERE game_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result->affected_rows) {
        http_response_code(404);
        echo json_encode(["error" => "Game non trovato."]);
    }
    else {
        echo json_encode("success");
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti."]);
}
?>
