<?php
include_once("../../includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['user_id']) && isset($_GET['game_id']) && isset($_GET["neighbor_id"])) {
        $user_id = $_GET['user_id'];
        $game_id = $_GET['game_id'];
        $neighbor_id = $_GET["neighbor_id"];

        // Verifica se esiste già la riga
        $checkQuery = "SELECT quantity FROM has_neighbor WHERE game_id = ? AND user_id = ? AND neighbor_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("iii", $game_id, $user_id, $neighbor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Riga esistente: incrementa quantity
            $updateQuery = "UPDATE has_neighbor SET quantity = quantity + 1 WHERE game_id = ? AND user_id = ? AND neighbor_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("iii", $game_id, $user_id, $neighbor_id);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Nuova riga con quantity = 0
            $insertQuery = "INSERT INTO has_neighbor (game_id, user_id, neighbor_id) VALUES (?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("iii", $game_id, $user_id, $neighbor_id);
            $insertStmt->execute();
            $insertStmt->close();
        }

        $stmt->close();
        echo "success";
    } else {
        http_response_code(400);
        exit("Dati mancanti: assicurati che user_id, game_id e neighbor siano settati.");
    }
}
?>
