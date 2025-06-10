<?php
include_once("../../includes/db.php");
session_start();

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Connessione al database fallita."]);
    exit;
}

if (isset($_GET["user_id"], $_GET["game_id"])) {
    $user_id = intval($_GET["user_id"]);
    $game_id = intval($_GET["game_id"]);

    $query = "DELETE FROM partecipa WHERE game_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $game_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        http_response_code(404);
        echo "riga non trovata";
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo "parametri user_id o game_id mancanti";
}
?>
