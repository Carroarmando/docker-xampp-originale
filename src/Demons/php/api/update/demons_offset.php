<?php
include_once("../../includes/db.php");
session_start();

if (isset($_GET["game_id"])) {
    $game_id = intval($_GET["game_id"]);

    $query = "UPDATE games SET demons_offset = demons_offset + 1 WHERE game_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        http_response_code(404);
        echo json_encode(["error" => "Game non trovato o offset non modificato."]);
    } else {
        echo json_encode(["success" => true]);
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti."]);
}
?>
