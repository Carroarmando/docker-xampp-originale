<?php
include("includes/db.php");
session_start();

if (!isset($_SESSION['room_id'])) 
{
    die("Errore: nessuna stanza selezionata.");
}

$room_id = $_SESSION['room_id'];

// Recupera i messaggi dalla tabella
$query = "select * from (select username, message, time from messages natural join users where room_id = $room_id order by time desc limit 10) as lastTenMessages order by time asc";
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