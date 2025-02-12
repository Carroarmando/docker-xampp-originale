<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) 
{
    header("Location: accedi.html");
    exit;
}

if (!isset($_GET['room_id'])) 
{
    echo "Errore: nessuna stanza specificata.";
    exit;
}

$room_id = $_GET['room_id'];
$user_id = $_SESSION['user_id'];

$query = "select * from rooms where room_id = $room_id";
$result = $conn->query($query);

if ($result->num_rows == 0) 
{
    echo "Errore: la stanza non esiste.";
    exit;
}

$query = "select * from user_in where user_id = $user_id and room_id = $room_id";
$result = $conn->query($query);

if ($result->num_rows == 0) 
{
    $query = "insert into user_in (user_id, room_id) values ($user_id, $room_id)";
    if (!$conn->query($query)) {
        echo "Errore durante l'aggiunta alla stanza: " . $conn->error;
        exit;
    }
}

$_SESSION['room_id'] = $room_id;

$query = "select nome from rooms where room_id = $room_id";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$_SESSION['room_name'] = $row['nome'];

header("Location: room.php");
exit;
?>
