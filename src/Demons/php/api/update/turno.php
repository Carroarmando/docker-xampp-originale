<?php
include_once("../../includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['user_id']) && isset($_GET['game_id']) && isset($_GET["turno"])) {
        $user_id = $_GET['user_id'];
        $game_id = $_GET['game_id'];
        $turno = $_GET["turno"];

        $query = "UPDATE partecipa set turno = ? WHERE game_id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $turno, $game_id, $user_id);
        $stmt->execute();

        echo "success";
    } else {
        http_response_code(400);
        exit("Dati mancanti: assicurati che user_id, game_id e turno siano settati.");
    }
}
?>
