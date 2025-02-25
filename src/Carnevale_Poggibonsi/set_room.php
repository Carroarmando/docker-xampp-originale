<?php
session_start();
include("includes/db.php");

// Verifica che sia stato passato un ID valido
if (!isset($_GET['room_id'])) 
{
    die("ID stanza non specificato.");
}

// Ottieni i dettagli della stanza dal database
$room_id = $_GET['room_id'];
$query = "SELECT nome FROM rooms WHERE room_id = '$room_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['room_name'] = $row['nome']; // Salva il nome della stanza in sessione
    $_SESSION['room_id'] = $room_id;       // Salva l'id della stanza
    header("Location: room.php");          // Reindirizza a room.php
    exit;
} else {
    die("Stanza non trovata.");
}
