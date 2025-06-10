<?php
include_once("../../includes/db.php");
session_start();

if (isset($_GET["user_id"], $_GET["game_id"])) {
    $user_id = intval($_GET["user_id"]);
    $game_id = intval($_GET["game_id"]);

    $query = "SELECT * FROM has_neighbor WHERE user_id = ? AND game_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $neighbors = [];
    while ($row = $result->fetch_assoc())
        $neighbors[] = $row;

    echo json_encode($neighbors);

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Sessione mancante (opponent_id o game_id)."]);
}
?>
