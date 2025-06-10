<?php
include_once("../../includes/db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['user_id']) && isset($_GET['game_id']) && isset($_GET["demon_id"]) && isset($_GET["summoned"])) {
        $user_id = $_GET['user_id'];
        $game_id = $_GET['game_id'];
        $demon_id = intval($_GET["demon_id"]);
        $summoned = intval($_GET["summoned"]);

        // Costruzione dinamica della query
        $query = "INSERT INTO has_demon (game_id, user_id, demon_id, summoned) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiii", $game_id, $user_id, $demon_id, $summoned);

        if ($stmt->execute()) {
            echo "success";
        } else {
            http_response_code(500);
            echo "Errore nell'esecuzione della query.";
        }
    } else {
        http_response_code(400);
        exit("Dati mancanti: assicurati che user_id, game_id e demon siano settati.");
    }
} else {
    http_response_code(405);
    exit("Metodo non consentito.");
}
?>