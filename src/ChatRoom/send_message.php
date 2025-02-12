<?php
include("includes/db.php");
session_start();

// Verifica che l'utente sia loggato e che il nome della stanza sia impostato
if (!isset($_SESSION['user_id']) || !isset($_SESSION['room_name'])) 
{
    header("Location: accedi.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $user_id = $_SESSION["user_id"];
    $room_id = $_SESSION["room_id"];
    $message = $_POST["message"];

    $query = "insert into messages (user_id, room_id, message) values ($user_id, $room_id, '$message')";
    
    if($conn->query($query))
        echo "success";
    else
        echo "error";
} 

?>