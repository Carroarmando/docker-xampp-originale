<?php
session_start();
include("includes/db.php");

if (!isset($_GET['room_id'])) 
{
    die("ID stanza non specificato.");
}

$room_id = $_GET['room_id'];
$query = "SELECT nome FROM rooms WHERE room_id = '$room_id'";
$result = $conn->query($query);

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $_SESSION['room_name'] = $row['nome'];
    $_SESSION['room_id'] = $room_id;
    header("Location: room.php");
    exit;
} 
else 
    die("Stanza non trovata.");
