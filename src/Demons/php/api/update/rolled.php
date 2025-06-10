<?php
include_once("../../includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['user_id'], $_GET['game_id'], $_GET['rolled'])) {
        $user_id = intval($_GET['user_id']);
        $game_id = intval($_GET['game_id']);
        $rolled = intval($_GET["rolled"]);

        $query = "UPDATE partecipa SET rolled = ? WHERE game_id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $rolled, $game_id, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "success";
        } else {
            http_response_code(404);
            echo "riga non trovata.";
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo "parametri user_id, game_id o rolled mancanti.";
    }
} else {
    http_response_code(405);
    echo "metodo non consentito. usa get.";
}
