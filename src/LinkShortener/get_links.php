<?php
include("includes/db.php");
session_start();

$user_id = $_SESSION['user_id'];

// Recupera i messaggi dalla tabella
$query = "select * from links where user_id = $user_id";
$result = $conn->query($query);

$messages = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Invia i messaggi come JSON
header('Content-Type: application/json');
echo json_encode($messages);
?>
