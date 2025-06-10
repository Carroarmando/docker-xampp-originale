<?php
include_once("../../includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['user_id']) && isset($_GET['game_id']) && isset($_GET["candle_id"])) {
        $user_id = $_GET['user_id'];
        $game_id = $_GET['game_id'];
        $candle_id = $_GET["candle_id"];

        $query = "INSERT INTO has_candle (game_id, user_id, candle_id) VALUES (?, ?, ?)";
        $stmt= $conn->prepare($query);
        $stmt->bind_param("iii", $game_id, $user_id, $candle_id);
        $stmt->execute();

        echo "success";
    } else {
        http_response_code(400);
        exit("Dati mancanti: assicurati che user_id, game_id e candle siano settati.");
    }
}
?>
