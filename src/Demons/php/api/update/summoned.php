<?php
include_once("../../includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['user_id'], $_GET['game_id'], $_GET['summoned'])) {
        $user_id = intval($_GET['user_id']);
        $game_id = intval($_GET['game_id']);
        $summoned = intval($_GET["summoned"]);

        $query = "UPDATE partecipa SET summoned = ? WHERE game_id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $summoned, $game_id, $user_id);
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
        echo "parametri user_id, game_id o summoned mancanti.";
    }
} else {
    http_response_code(405);
    echo "metodo non consentito. usa get.";
}
