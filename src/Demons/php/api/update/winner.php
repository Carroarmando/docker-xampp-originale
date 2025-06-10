<?php
include_once("../../includes/db.php");
session_start();

if (isset($_GET["game_id"]) && isset($_GET["user_id"])) {
    $game_id = intval($_GET["game_id"]);
    $user_id = intval($_GET["user_id"]);

    $query = "UPDATE games SET winner = ? WHERE game_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $game_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        http_response_code(404);
        echo json_encode(["error" => "Game non trovato o winner non modificato."]);
    } else {
        echo json_encode(["success" => true]);
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti."]);
}
?>
