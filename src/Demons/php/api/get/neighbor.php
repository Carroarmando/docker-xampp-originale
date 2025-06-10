<?php
include_once("../../includes/db.php");
session_start();

if (isset($_GET["neighbor_id"])) {
    $neighbor_id = intval($_GET["neighbor_id"]);

    $query = "SELECT neighbor_id, name, number, sex, type, effect FROM neighbors WHERE neighbor_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $neighbor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Neighbor non trovato."]);
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Dati mancanti."]);
}
?>
