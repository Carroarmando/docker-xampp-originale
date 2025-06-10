<?php
include_once("../../includes/db.php");
session_start();

if (isset($_GET["demon_id"])) {
    $demon_id = intval($_GET["demon_id"]);

    $query = "SELECT demon_id, name, number, effect FROM demons WHERE demon_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $demon_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Game non trovato."]);
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti."]);
}
?>
